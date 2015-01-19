<?php
/**
 * Copyright (C) 2014 Proximis
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */
namespace Rbs\Sampledata\Import;

/**
 * @name \Rbs\Sampledata\Import\DocumentsResolver
 */
class DocumentsResolver
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
	 * @var string
	 */
	protected $contextId;


	protected $documentCodesIds = [
		'products' => [],
		'sku' => [],
		'attributes' => [],
		'brands' => [],
		'images' => [],
		'webStores' => [],
		'billingAreas' => [],
		'targets' => [],
	];

	/**
	 * @param \Change\Documents\DocumentManager $documentManager
	 * @param \Change\Documents\DocumentCodeManager $documentCodeManager
	 * @param string $contextId
	 */
	public function __construct(\Change\Documents\DocumentManager $documentManager,
		\Change\Documents\DocumentCodeManager $documentCodeManager, $contextId = 'Rbs_Sampledata')
	{
		$this->documentManager = $documentManager;
		$this->documentCodeManager = $documentCodeManager;
		$this->contextId = $contextId;
	}

	/**
	 * @param array|string $data
	 * @param string $key
	 * @return null|string
	 */
	protected function extractCode($data, $key = '_id')
	{
		if (is_array($data))
		{
			return (isset($data[$key])) ? strval($data[$key]) : null;
		}
		return $data ? strval($data) : null;
	}

	/**
	 * @param array|string $data
	 * @return \Rbs\Catalog\Documents\Product|null
	 */
	public function getProduct($data)
	{
		$code = $this->extractCode($data);
		if ($code)
		{
			if (isset($this->documentCodesIds['products'][$code]))
			{
				return $this->documentManager->getDocumentInstance($this->documentCodesIds['products'][$code]);
			}
			foreach ($this->documentCodeManager->getDocumentsByCode($code, $this->contextId) as $document)
			{
				if ($document instanceof \Rbs\Catalog\Documents\Product)
				{
					$this->documentCodesIds['products'][$code] = $document->getId();
					return $document;
				}
			}
		}
		return null;
	}

	/**
	 * @param array|string $data
	 * @return \Rbs\Stock\Documents\Sku|null
	 */
	public function getSku($data)
	{
		$code = $this->extractCode($data, 'code');
		if ($code)
		{
			if (isset($this->documentCodesIds['sku'][$code]))
			{
				return $this->documentManager->getDocumentInstance($this->documentCodesIds['sku'][$code]);
			}
			$query = $this->documentManager->getNewQuery('Rbs_Stock_Sku');
			$query->andPredicates($query->eq('code', $code));
			$document = $query->getFirstDocument();
			if ($document instanceof \Rbs\Stock\Documents\Sku)
			{
				$this->documentCodesIds['sku'][$code] = $document->getId();
				return $document;
			}
		}
		return null;
	}

	/**
	 * @param array|string $data
	 * @return \Rbs\Catalog\Documents\Attribute|null
	 */
	public function getAttribute($data)
	{
		$code = $this->extractCode($data, 'attribute_id');
		if ($code)
		{
			if (isset($this->documentCodesIds['attributes'][$code]))
			{
				return $this->documentManager->getDocumentInstance($this->documentCodesIds['attributes'][$code]);
			}
			foreach ($this->documentCodeManager->getDocumentsByCode($code, $this->contextId) as $document)
			{
				if ($document instanceof \Rbs\Catalog\Documents\Attribute)
				{
					$this->documentCodesIds['attributes'][$code] = $document->getId();
					return $document;
				}
			}
		}
		return null;
	}

	/**
	 * @param array|string $data
	 * @return \Rbs\Brand\Documents\Brand|null
	 */
	public function getBrand($data)
	{
		$code = $this->extractCode($data, 'brand_id');
		if ($code)
		{
			if (isset($this->documentCodesIds['brands'][$code]))
			{
				return $this->documentManager->getDocumentInstance($this->documentCodesIds['brands'][$code]);
			}
			foreach ($this->documentCodeManager->getDocumentsByCode($code, $this->contextId) as $document)
			{
				if ($document instanceof \Rbs\Brand\Documents\Brand)
				{
					$this->documentCodesIds['brands'][$code] = $document->getId();
					return $document;
				}
			}
		}
		return null;
	}

	/**
	 * @param array|string $data
	 * @return \Rbs\Media\Documents\Image|null
	 */
	public function getImage($data)
	{
		$code = $this->extractCode($data);
		if ($code)
		{
			if (isset($this->documentCodesIds['images'][$code]))
			{
				return $this->documentManager->getDocumentInstance($this->documentCodesIds['images'][$code]);
			}
			foreach ($this->documentCodeManager->getDocumentsByCode($code, $this->contextId) as $document)
			{
				if ($document instanceof \Rbs\Media\Documents\Image)
				{
					$this->documentCodesIds['images'][$code] = $document->getId();
					return $document;
				}
			}
		}
		return null;
	}

	/**
	 * @param array|string $data
	 * @return \Rbs\Store\Documents\WebStore|null
	 */
	public function getWebStore($data)
	{
		$code = $this->extractCode($data);
		if ($code)
		{
			if (isset($this->documentCodesIds['webStores'][$code]))
			{
				return $this->documentManager->getDocumentInstance($this->documentCodesIds['webStores'][$code]);
			}
			foreach ($this->documentCodeManager->getDocumentsByCode($code, $this->contextId) as $document)
			{
				if ($document instanceof \Rbs\Store\Documents\WebStore)
				{
					$this->documentCodesIds['webStores'][$code] = $document->getId();
					return $document;
				}
			}
		}
		return null;
	}

	/**
	 * @param array|string $data
	 * @return \Rbs\Price\Documents\BillingArea|null
	 */
	public function getBillingArea($data)
	{
		$code = $this->extractCode($data);
		if ($code)
		{
			if (isset($this->documentCodesIds['billingAreas'][$code]))
			{
				return $this->documentManager->getDocumentInstance($this->documentCodesIds['billingAreas'][$code]);
			}
			foreach ($this->documentCodeManager->getDocumentsByCode($code, $this->contextId) as $document)
			{
				if ($document instanceof \Rbs\Store\Documents\WebStore)
				{
					$this->documentCodesIds['billingAreas'][$code] = $document->getId();
					return $document;
				}
			}
		}
		return null;
	}

	/**
	 * @param array|string $data
	 * @return \Rbs\Price\Documents\UserGroup|null
	 */
	public function getTarget($data)
	{
		$code = $this->extractCode($data);
		if ($code)
		{
			if (isset($this->documentCodesIds['targets'][$code]))
			{
				return $this->documentManager->getDocumentInstance($this->documentCodesIds['targets'][$code]);
			}
			foreach ($this->documentCodeManager->getDocumentsByCode($code, $this->contextId) as $document)
			{
				if ($document instanceof \Rbs\Price\Documents\UserGroup)
				{
					$this->documentCodesIds['targets'][$code] = $document->getId();
					return $document;
				}
			}
		}
		return null;
	}
}