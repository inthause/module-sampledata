<?php
/**
 * Copyright (C) 2014 Proximis
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */
namespace Rbs\Sampledata\Commands;

/**
 * @name \Rbs\Sampledata\Commands\SetDefaults
 */
class SetDefaults
{
	use \Rbs\Sampledata\Commands\DefaultsDocumentsTrait;

	/**
	 * @param \Change\Events\Event $event
	 * @throws \Exception
	 */
	public function execute(\Change\Events\Event $event)
	{
		if ($event instanceof \Change\Commands\Events\Event)
		{
			$response = $event->getCommandResponse();
		}
		else
		{
			$response = null;
		}

		$applicationServices = $event->getApplicationServices();
		$LCID = $applicationServices->getI18nManager()->getDefaultLCID();

		$documentManager = $applicationServices->getDocumentManager();
		$this->documentManager = $documentManager;

		$documentCodeManager = $applicationServices->getDocumentCodeManager();
		$this->documentCodeManager = $documentCodeManager;

		$sectionInput = $event->getParam('section', 0);
		$webStoreInput = $event->getParam('webStore', 0);
		$billingAreaInput = $event->getParam('billingArea', 0);
		$groupAttributeInput = $event->getParam('groupAttribute', 0);

		if ($webStoreInput !== 0 || $billingAreaInput !== 0 || $groupAttributeInput !== 0 || $sectionInput !== 0)
		{
			$transactionManager = $applicationServices->getTransactionManager();
			try
			{
				$transactionManager->begin();

				if ($sectionInput !== 0)
				{
					$section = $this->setDefaultSection($sectionInput, $documentManager, $documentCodeManager);
					if ($section === null)
					{
						if ($response)
						{
							$response->addErrorMessage('Unable to resolve Section: ' . $sectionInput);
						}
						return;
					} else {
						$response->addInfoMessage('Set default section: ' . $sectionInput .
							' as ' . $section . ', ' . $section->getLabel());
					}
				}

				if ($billingAreaInput !== 0)
				{
					$billingArea = $this->setDefaultBillingArea($billingAreaInput, $documentManager, $documentCodeManager);
					if ($billingArea === null)
					{
						if ($response)
						{
							$response->addErrorMessage('Unable to resolve Billing Area: ' . $billingAreaInput);
						}
						return;
					} else {
						$response->addInfoMessage('Set default Billing Area: ' . $billingAreaInput .
							' as ' . $billingArea . ', ' . $billingArea->getLabel());
					}
				}

				if ($webStoreInput !== 0)
				{
					$webStore = $this->setDefaultWebStore($webStoreInput, $documentManager, $documentCodeManager);
					if ($webStore === null)
					{
						if ($response)
						{
							$response->addErrorMessage('Unable to resolve Web Store: ' . $webStoreInput);
						}
						return;
					} else {
						$response->addInfoMessage('Set default Web Store: ' . $webStoreInput .
							' as ' . $webStore . ', ' . $webStore->getLabel());
					}
				}

				if ($groupAttributeInput !== 0)
				{
					$groupAttribute = $this->setDefaultGroupAttribute($groupAttributeInput, $documentManager, $documentCodeManager);
					if ($groupAttribute === null)
					{
						if ($response)
						{
							$response->addErrorMessage('Unable to resolve Group Attribute: ' . $groupAttributeInput);
						}
						return;
					} else {
						$response->addInfoMessage('Set default Group Attribute: ' . $groupAttributeInput .
							' as ' . $groupAttribute . ', ' . $groupAttribute->getLabel());
					}
				}

				$transactionManager->commit();
			}
			catch (\Exception $e)
			{
				throw $transactionManager->rollBack($e);
			}
		}

		if ($response)
		{
			$webStore = $this->getDefaultWebStore(0);
			$billingArea =  $this->getDefaultBillingArea(0);
			$groupAttribute =  $this->getDefaultGroupAttribute(0);
			$section =  $this->getDefaultSection(0);
			$website = $this->getDefaultWebsite(0);

			$response->addInfoMessage(' Defaults documents:');
			$response->addInfoMessage(' - section: '. ($section ? $section->getId() . ' ' .$section->getLabel() . ' '. ($section->getDocumentModel()->getShortName()) : '-'));
			$response->addInfoMessage(' - website: '. ($website ? $website->getId() . ' ' .$website->getLabel() : '-'));
			$response->addInfoMessage(' - webStore: '. ($webStore ? $webStore->getId() . ' ' .$webStore->getLabel() : '-'));
			$response->addInfoMessage(' - billingArea: '. ($billingArea ? $billingArea->getId() . ' ' .$billingArea->getLabel() : '-'));
			$response->addInfoMessage(' - groupAttribute: '. ($groupAttribute ? $groupAttribute->getId() . ' ' .$groupAttribute->getLabel() : '-'));
		}
	}

	/**
	 * @param string|integer $section
	 * @param \Change\Documents\DocumentManager $documentManager
	 * @param \Change\Documents\DocumentCodeManager $documentCodeManager
	 * @return \Rbs\Website\Documents\Section|null
	 */
	protected function setDefaultSection($section, $documentManager, $documentCodeManager)
	{
		if ($section === 'first')
		{
			$query = $documentManager->getNewQuery('Rbs_Website_Section');
			$query->addOrder('id');
			$section = $query->getFirstDocument();
		}
		elseif (is_numeric($section))
		{
			$section = $documentManager->getDocumentInstance($section);
			if (!($section instanceof \Rbs\Website\Documents\Section))
			{
				$section = null;
			}
		}

		if ($section instanceof \Rbs\Website\Documents\Section)
		{
			$defaultSections = $documentCodeManager->getDocumentsByCode('default_section', 'Rbs_Sampledata');
			$defaultSection = $this->getDefaultDocument($defaultSections, 'Rbs_Website_Section');
			if ($defaultSection)
			{
				if (!$section->equals($defaultSection))
				{
					$documentCodeManager->removeDocumentCode($defaultSection, 'default_section', 'Rbs_Sampledata');
					$documentCodeManager->addDocumentCode($section, 'default_section', 'Rbs_Sampledata');
				}
			}
			else
			{
				$documentCodeManager->addDocumentCode($section, 'default_section', 'Rbs_Sampledata');
			}
		}
		else
		{
			$section = null;
		}
		return $section;
	}

	/**
	 * @param string|integer $billingArea
	 * @param \Change\Documents\DocumentManager $documentManager
	 * @param \Change\Documents\DocumentCodeManager $documentCodeManager
	 * @return \Rbs\Price\Documents\BillingArea|null
	 */
	protected function setDefaultBillingArea($billingArea, $documentManager, $documentCodeManager)
	{
		if ($billingArea === 'first')
		{
			$query = $documentManager->getNewQuery('Rbs_Price_BillingArea');
			$query->addOrder('id');
			$billingArea = $query->getFirstDocument();
		}
		elseif (is_numeric($billingArea))
		{
			$billingArea = $documentManager->getDocumentInstance($billingArea);
			if (!($billingArea instanceof \Rbs\Price\Documents\BillingArea))
			{
				$billingArea = null;
			}
		}

		if ($billingArea instanceof \Rbs\Price\Documents\BillingArea)
		{
			$defaultBillingAreas = $documentCodeManager->getDocumentsByCode('default_billingArea', 'Rbs_Sampledata');
			$defaultBillingArea = $this->getDefaultDocument($defaultBillingAreas, 'Rbs_Price_BillingArea');
			if ($defaultBillingArea)
			{
				if (!$billingArea->equals($defaultBillingArea))
				{
					$documentCodeManager->removeDocumentCode($defaultBillingArea, 'default_billingArea', 'Rbs_Sampledata');
					$documentCodeManager->addDocumentCode($billingArea, 'default_billingArea', 'Rbs_Sampledata');
				}
			}
			else
			{
				$documentCodeManager->addDocumentCode($billingArea, 'default_billingArea', 'Rbs_Sampledata');
			}
		}
		else
		{
			$billingArea = null;
		}
		return $billingArea;
	}


	/**
	 * @param string|integer $webStore
	 * @param \Change\Documents\DocumentManager $documentManager
	 * @param \Change\Documents\DocumentCodeManager $documentCodeManager
	 * @return \Rbs\Store\Documents\WebStore|null
	 */
	protected function setDefaultWebStore($webStore, $documentManager, $documentCodeManager)
	{
		if ($webStore === 'first')
		{
			$query = $documentManager->getNewQuery('Rbs_Store_WebStore');
			$query->addOrder('id');
			$webStore = $query->getFirstDocument();
		}
		elseif (is_numeric($webStore))
		{
			$webStore = $documentManager->getDocumentInstance($webStore);
			if (!($webStore instanceof \Rbs\Store\Documents\WebStore))
			{
				$webStore = null;
			}
		}

		if ($webStore instanceof \Rbs\Store\Documents\WebStore)
		{
			$defaultWebStores = $documentCodeManager->getDocumentsByCode('default_webStore', 'Rbs_Sampledata');
			$defaultWebStore = $this->getDefaultDocument($defaultWebStores, 'Rbs_Store_WebStore');
			if ($defaultWebStore)
			{
				if (!$webStore->equals($defaultWebStore))
				{
					$documentCodeManager->removeDocumentCode($defaultWebStore, 'default_webStore', 'Rbs_Sampledata');
					$documentCodeManager->addDocumentCode($webStore, 'default_webStore', 'Rbs_Sampledata');
				}
			}
			else
			{
				$documentCodeManager->addDocumentCode($webStore, 'default_webStore', 'Rbs_Sampledata');
			}
		}
		else
		{
			$webStore = null;
		}
		return $webStore;
	}

	/**
	 * @param string|integer $groupAttribute
	 * @param \Change\Documents\DocumentManager $documentManager
	 * @param \Change\Documents\DocumentCodeManager $documentCodeManager
	 * @return \Rbs\Catalog\Documents\Attribute|null
	 */
	protected function setDefaultGroupAttribute($groupAttribute, $documentManager, $documentCodeManager)
	{
		if ($groupAttribute === 'first')
		{
			$query = $documentManager->getNewQuery('Rbs_Catalog_Attribute');
			$query->andPredicates($query->eq('valueType', \Rbs\Catalog\Documents\Attribute::TYPE_GROUP));
			$query->addOrder('id');
			$groupAttribute = $query->getFirstDocument();
		}
		elseif (is_numeric($groupAttribute))
		{
			$groupAttribute = $documentManager->getDocumentInstance($groupAttribute);
			if (!($groupAttribute instanceof \Rbs\Catalog\Documents\Attribute))
			{
				$groupAttribute = null;
			}
		}

		if ($groupAttribute instanceof \Rbs\Catalog\Documents\Attribute)
		{
			$defaultGroupAttributes = $documentCodeManager->getDocumentsByCode('default_groupAttribute', 'Rbs_Sampledata');
			$defaultGroupAttribute = $this->getDefaultDocument($defaultGroupAttributes, 'Rbs_Catalog_Attribute');
			if ($defaultGroupAttribute)
			{
				if (!$groupAttribute->equals($defaultGroupAttribute))
				{
					$documentCodeManager->removeDocumentCode($defaultGroupAttribute, 'default_groupAttribute', 'Rbs_Sampledata');
					$documentCodeManager->addDocumentCode($groupAttribute, 'default_groupAttribute', 'Rbs_Sampledata');
				}
			}
			else
			{
				$documentCodeManager->addDocumentCode($groupAttribute, 'default_groupAttribute', 'Rbs_Sampledata');
			}
		}
		else
		{
			$groupAttribute = null;
		}
		return $groupAttribute;
	}
}