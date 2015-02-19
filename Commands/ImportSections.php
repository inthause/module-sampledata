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
* @name \Rbs\Sampledata\Commands\ImportSections
*/
class ImportSections
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



		$importer = new \Rbs\Sampledata\Import\ImportSection();
		$importer->setDocumentManager($documentManager)
			->setModelManager($applicationServices->getModelManager())
			->setDocumentCodeManager($documentCodeManager)
			->setI18nManager($applicationServices->getI18nManager());

		$rootSection = $this->getDefaultSection($params->get('sectionId'));
		if (!$rootSection)
		{
			echo 'No default section defined', PHP_EOL;
			return;
		}

		$indexPageId = $params->get('indexPageId');
		$indexPage = null;
		if ($indexPageId)
		{
			$indexPage = $documentManager->getDocumentInstance($indexPageId);
			if (!($indexPage instanceof \Rbs\Website\Documents\Page)) {
				$indexPage = null;
			}
		}
		else
		{
			$webStore = $this->getDefaultWebStore(0);
			$website = $rootSection->getWebsite();
			if ($webStore && $website)
			{
				$context = 'Rbs Commerce WebStore Initialize '.$website->getId().' '.$webStore->getId();
				$documents = $documentCodeManager->getDocumentsByCode('rbs_commerce_initialize_contextual_product_list', $context);
				foreach ($documents as $document)
				{
					if ($document instanceof \Rbs\Website\Documents\Page)
					{
						$indexPage = $document;
						break;
					}
				}
			}
		}

		if ($response)
		{
			$response->addInfoMessage('File: ' . $filePath . ', section: ' . count($json));
			$response->addInfoMessage(' section: '. ($rootSection ? $rootSection->getId() . ' ' .$rootSection->getLabel() : '-'));
			$response->addInfoMessage(' index page: '. ($indexPage ? $indexPage->getId() . ' ' .$indexPage->getLabel() : '-'));
		}

		$importer->setDefaultCategoryIndex($indexPage);
		$importer->setDefaultSection($rootSection);

		$transactionManager = $applicationServices->getTransactionManager();
		foreach ($json as $groupId => $groupData)
		{
			if (!isset($groupData['categories']) || !is_array($groupData['categories']))
			{
				echo 'Ignored group: ', $groupId, PHP_EOL;
				continue;
			}

			try
			{
				$transactionManager->begin();
				$groupData['_id'] = $groupId;
				$importer->setDefaultSection($rootSection);

				$group = $importer->import($groupData);
				echo 'group: ', $groupId, ', ', $group, PHP_EOL;
				if ($group)
				{
					$importer->setDefaultSection($group);
					$mergedCategories = [];
					foreach ($groupData['categories'] as $categoryId => $categoryData)
					{
						if (isset($categoryData['mergedIn']))
						{
							$mergedIn = $categoryData['mergedIn'];
							if (!isset($groupData['categories'][$mergedIn]))
							{
								echo 'Invalid category to merge: ', $mergedIn, ' for: ', $categoryId,PHP_EOL;
								continue;
							}

							$category = $importer->getDocumentsResolver()->getSection($groupId . '_' . $categoryId);
							if (!$category)
							{
								$mergedCategories[$categoryId] = $mergedIn;
							}
						}
						else
						{
							$categoryData['_id'] = $groupId . '_' . $categoryId;
							$category = $importer->import($categoryData);
							echo '   category: ', $categoryId, ', ', $category, PHP_EOL;
						}
					}

					foreach ($mergedCategories as $categoryId => $mergedIn)
					{
						$category = $importer->getDocumentsResolver()->getSection($groupId . '_' . $mergedIn);
						if ($category)
						{
							$documentCodeManager->addDocumentCode($category, $groupId . '_' . $categoryId, $importer->getContextId());
						}
						else
						{
							echo 'Unable to merge: ', $categoryId, ' in: ', $mergedIn, PHP_EOL;
						}
					}
				}

				$transactionManager->commit();
			}
			catch (\Exception $e)
			{
				throw $transactionManager->rollBack($e);
			}
		}

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
}