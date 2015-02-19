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
* @name \Rbs\Sampledata\Commands\DefaultsDocumentsTrait
*/
trait DefaultsDocumentsTrait
{
	/**
	 * @var \Change\Documents\DocumentManager
	 */
	protected $documentManager;

	/**
	 * @var \Change\Documents\DocumentCodeManager
	 */
	protected $documentCodeManager;


	/**
	 * @param \Change\Documents\AbstractDocument[] $defaultDocuments
	 * @param string $modelName
	 * @return \Change\Documents\AbstractDocument|null
	 */
	protected function getDefaultDocument($defaultDocuments, $modelName)
	{
		foreach ($defaultDocuments as $document)
		{
			if ($document->getDocumentModel()->isInstanceOf($modelName))
			{
				return $document;
			}
		}
		return null;
	}

	/**
	 * @param integer|null $id
	 * @return \Rbs\Store\Documents\WebStore|null
	 */
	protected function getDefaultWebStore($id)
	{
		$webStore = $this->documentManager->getDocumentInstance($id);
		if (!($webStore instanceof \Rbs\Store\Documents\WebStore))
		{
			$webStore = $this->getDefaultDocument(
				$this->documentCodeManager->getDocumentsByCode('default_webStore', 'Rbs_Sampledata'),
				'Rbs_Store_WebStore');
		}
		return $webStore;
	}

	/**
	 * @param integer|null $id
	 * @return \Rbs\Price\Documents\BillingArea|null
	 */
	protected function getDefaultBillingArea($id)
	{
		$billingArea = $this->documentManager->getDocumentInstance($id);
		if (!($billingArea instanceof \Rbs\Price\Documents\BillingArea))
		{
			$billingArea = $this->getDefaultDocument(
				$this->documentCodeManager->getDocumentsByCode('default_billingArea', 'Rbs_Sampledata'),
				'Rbs_Price_BillingArea');
		}
		return $billingArea;
	}

	/**
	 * @param integer|null $id
	 * @return \Rbs\Catalog\Documents\Attribute|null
	 */
	protected function getDefaultGroupAttribute($id)
	{
		$groupAttribute = $this->documentManager->getDocumentInstance($id);
		if (!($groupAttribute instanceof \Rbs\Catalog\Documents\Attribute)
			|| $groupAttribute->getValueType() !== \Rbs\Catalog\Documents\Attribute::TYPE_GROUP)
		{
			$groupAttribute = $this->getDefaultDocument(
				$this->documentCodeManager->getDocumentsByCode('default_groupAttribute', 'Rbs_Sampledata'),
				'Rbs_Catalog_Attribute');
		}
		return $groupAttribute;
	}

	/**
	 * @param integer|null $id
	 * @return \Rbs\Website\Documents\Section|null
	 */
	protected function getDefaultSection($id)
	{
		$section = $this->documentManager->getDocumentInstance($id);
		if (!($section instanceof \Rbs\Website\Documents\Section))
		{
			$section = $this->getDefaultDocument(
				$this->documentCodeManager->getDocumentsByCode('default_section', 'Rbs_Sampledata'),
				'Rbs_Website_Section');
		}
		return $section;
	}

	/**
	 * @param integer|null $id
	 * @return \Rbs\Website\Documents\Website|null
	 */
	protected function getDefaultWebsite($id)
	{
		$section = $this->getDefaultSection($id);
		return $section instanceof \Rbs\Website\Documents\Section ? $section->getWebsite() : null;
	}
}