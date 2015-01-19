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
			->setDocumentCodeManager($applicationServices->getDocumentCodeManager())
			->setI18nManager($applicationServices->getI18nManager())
			->setStorageManager($applicationServices->getStorageManager())
			->setAttributeManager($commerceServices->getAttributeManager());

		$webStore = $this->getDefaultWebStore($documentManager, $params->get('webStoreId'));
		$billingArea =  $this->getDefaultBillingArea($documentManager, $params->get('billingAreaId'));
		$groupAttribute =  $this->getDefaultGroupAttribute($documentManager, $params->get('groupAttributeId'));
		$website =  $this->getDefaultWebsite($documentManager, $params->get('websiteId'));

		if ($response)
		{
			$response->addInfoMessage('File: ' . $filePath . ', products: ' . count($json));
			$response->addInfoMessage(' webStore: '. ($webStore ? $webStore->getId() . ' ' .$webStore->getLabel() : '-'));
			$response->addInfoMessage(' billingArea: '. ($billingArea ? $billingArea->getId() . ' ' .$billingArea->getLabel() : '-'));
			$response->addInfoMessage(' groupAttribute: '. ($groupAttribute ? $groupAttribute->getId() . ' ' .$groupAttribute->getLabel() : '-'));
			$response->addInfoMessage(' website: '. ($website ? $website->getId() . ' ' .$website->getLabel() : '-'));
		}

		$importer->setDefaultWebStore($webStore);
		$importer->setDefaultBillingArea($billingArea);
		$importer->setDefaultGroupAttribute($groupAttribute);
		$importer->setDefaultWebsite($website);

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
				throw $transactionManager->rollBack($e);
			}
		}
	}

	/**
	 * @param \Change\Documents\DocumentManager $documentManager
	 * @param integer|null $id
	 * @return \Rbs\Store\Documents\WebStore|null
	 */
	protected function getDefaultWebStore($documentManager, $id)
	{
		$webStore = $documentManager->getDocumentInstance($id);
		if (!($webStore instanceof \Rbs\Store\Documents\WebStore))
		{
			$query = $documentManager->getNewQuery('Rbs_Store_WebStore');
			$query->addOrder('id');
			$webStore = $query->getFirstDocument();
		}
		return $webStore;
	}

	/**
	 * @param \Change\Documents\DocumentManager $documentManager
	 * @param integer|null $id
	 * @return \Rbs\Price\Documents\BillingArea|null
	 */
	protected function getDefaultBillingArea($documentManager, $id)
	{
		$billingArea = $documentManager->getDocumentInstance($id);
		if (!($billingArea instanceof \Rbs\Price\Documents\BillingArea))
		{
			$query = $documentManager->getNewQuery('Rbs_Price_BillingArea');
			$query->addOrder('id');
			$billingArea = $query->getFirstDocument();
		}
		return $billingArea;
	}

	/**
	 * @param \Change\Documents\DocumentManager $documentManager
	 * @param integer|null $id
	 * @return \Rbs\Catalog\Documents\Attribute|null
	 */
	protected function getDefaultGroupAttribute($documentManager, $id)
	{
		$groupAttribute = $documentManager->getDocumentInstance($id);
		if (!($groupAttribute instanceof \Rbs\Catalog\Documents\Attribute)
			|| $groupAttribute->getValueType() !== \Rbs\Catalog\Documents\Attribute::TYPE_GROUP)
		{
			$query = $documentManager->getNewQuery('Rbs_Catalog_Attribute');
			$query->andPredicates($query->eq('valueType', \Rbs\Catalog\Documents\Attribute::TYPE_GROUP));
			$query->addOrder('id');
			$groupAttribute = $query->getFirstDocument();
		}
		return $groupAttribute;
	}

	/**
	 * @param \Change\Documents\DocumentManager $documentManager
	 * @param integer|null $id
	 * @return \Rbs\Website\Documents\Website|null
	 */
	protected function getDefaultWebsite($documentManager, $id)
	{
		$website = $documentManager->getDocumentInstance($id);
		if (!($website instanceof \Rbs\Website\Documents\Website))
		{
			$query = $documentManager->getNewQuery('Rbs_Website_Website');
			$query->addOrder('id');
			$website = $query->getFirstDocument();
		}
		return $website;
	}
}