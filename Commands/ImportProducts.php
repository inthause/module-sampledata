<?php
/**
 * Copyright (C) 2014 Proximis
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */
namespace Rbs\Sampledata\Commands;

/**
* @name \Rbs\Sampledata\Commands\ImportProducts
*/
class ImportProducts
{
	use \Rbs\Sampledata\Commands\DefaultsDocumentsTrait;

	/**
	 * @param \Change\Events\Event $event
	 * @throws \Exception
	 */
	public function execute(\Change\Events\Event $event)
	{
		if ($event instanceof \Change\Commands\Events\Event) {
			$response = $event->getCommandResponse();
		} else {
			$response = null;
		}

		$workspace = $event->getApplication()->getWorkspace();
		$applicationServices = $event->getApplicationServices();

		$documentManager = $applicationServices->getDocumentManager();
		$this->documentManager = $documentManager;

		$documentCodeManager = $applicationServices->getDocumentCodeManager();
		$this->documentCodeManager = $documentCodeManager;

		$params = new \Zend\Stdlib\Parameters($event->paramsToArray());

		$filePath = $workspace->composeAbsolutePath($event->getParam('filePath'));
		if (!is_readable($filePath))
		{
			if ($response)
			{
				$response->addErrorMessage('Unable to read: ' . $filePath);
			}
			return;
		}

		$json = json_decode(file_get_contents($filePath), true);
		if (!is_array($json))
		{
			if ($response)
			{
				$response->addErrorMessage('Invalid json file: ' . $filePath);
			}

			return;
		}

		/** @var \Rbs\Commerce\CommerceServices $commerceServices */
		$commerceServices = $event->getServices('commerceServices');

		$importer = new \Rbs\Sampledata\Import\ImportProduct();
		$importer->setDocumentManager($documentManager)
			->setModelManager($applicationServices->getModelManager())
			->setDocumentCodeManager($documentCodeManager)
			->setI18nManager($applicationServices->getI18nManager())
			->setStorageManager($applicationServices->getStorageManager())
			->setAttributeManager($commerceServices->getAttributeManager())
			->setStockManager($commerceServices->getStockManager());

		$webStore = $this->getDefaultWebStore($params->get('webStoreId'));
		$billingArea =  $this->getDefaultBillingArea($params->get('billingAreaId'));
		$groupAttribute =  $this->getDefaultGroupAttribute($params->get('groupAttributeId'));
		$section = $this->getDefaultSection($params->get('sectionId'));

		if ($response)
		{
			$response->addInfoMessage('File: ' . $filePath . ', products: ' . count($json));
			$response->addInfoMessage(' webStore: '. ($webStore ? $webStore->getId() . ' ' .$webStore->getLabel() : '-'));
			$response->addInfoMessage(' billingArea: '. ($billingArea ? $billingArea->getId() . ' ' .$billingArea->getLabel() : '-'));
			$response->addInfoMessage(' groupAttribute: '. ($groupAttribute ? $groupAttribute->getId() . ' ' .$groupAttribute->getLabel() : '-'));
			$response->addInfoMessage(' section: '. ($section ? $section->getId() . ' ' .$section->getLabel() : '-'));
		}

		$importer->setDefaultWebStore($webStore);
		$importer->setDefaultBillingArea($billingArea);
		$importer->setDefaultGroupAttribute($groupAttribute);
		$importer->setDefaultSection($section);

		$transactionManager = $applicationServices->getTransactionManager();
		foreach (array_chunk($json, 10) as $productsChunk)
		{
			try
			{
				$transactionManager->begin();
				foreach ($productsChunk as $productData)
				{
					$product = $importer->import($productData);
					if ($product)
					{
						echo 'Imported product: ', $productData['_id'], ', ', $product, PHP_EOL;
					}
				}
				$transactionManager->commit();
			}
			catch (\Exception $e)
			{
				echo $e->getTraceAsString();
				throw $transactionManager->rollBack($e);
			}
		}
	}
}