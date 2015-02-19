<?php
/**
 * Copyright (C) 2014 Proximis
 *
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */
namespace Rbs\Sampledata\Import;

/**
* @name \Rbs\Sampledata\Import\ImportProduct
*/
class ImportProduct
{
	/**
	 * @var \Rbs\Website\Documents\Section
	 */
	protected $defaultSection;

	/**
	 * @var \Rbs\Store\Documents\WebStore
	 */
	protected $defaultWebStore;

	/**
	 * @var \Rbs\Price\Documents\BillingArea
	 */
	protected $defaultBillingArea;

	/**
	 * @var \Rbs\Catalog\Documents\Attribute
	 */
	protected $defaultGroupAttribute;

	/**
	 * @var string
	 */
	protected $contextId = 'Rbs_Sampledata';

	/**
	 * @var \Change\Documents\DocumentManager
	 */
	protected $documentManager;

	/**
	 * @var \Change\Documents\modelManager
	 */
	protected $modelManager;

	/**
	 * @var \Change\I18n\I18nManager
	 */
	protected $i18nManager;

	/**
	 * @var \Change\Storage\StorageManager
	 */
	protected $storageManager;

	/**
	 * @var \Rbs\Catalog\Attribute\AttributeManager
	 */
	protected $attributeManager;

	/**
	 * @var \Rbs\Stock\StockManager
	 */
	protected $stockManager;

	/**
	 * @var \Change\Documents\DocumentCodeManager
	 */
	protected $documentCodeManager;

	/**
	 * @var \Rbs\Sampledata\Import\DocumentsResolver
	 */
	protected $documentsResolver;

	/**
	 * @return string
	 */
	public function getContextId()
	{
		return $this->contextId;
	}

	/**
	 * @param string $contextId
	 * @return $this
	 */
	public function setContextId($contextId)
	{
		$this->contextId = $contextId;
		return $this;
	}

	/**
	 * @return \Rbs\Website\Documents\Section
	 */
	public function getDefaultSection()
	{
		return $this->defaultSection;
	}

	/**
	 * @param \Rbs\Website\Documents\Section $defaultSection
	 * @return $this
	 */
	public function setDefaultSection($defaultSection)
	{
		$this->defaultSection = $defaultSection;
		return $this;
	}

	/**
	 * @return \Rbs\Store\Documents\WebStore
	 */
	public function getDefaultWebStore()
	{
		return $this->defaultWebStore;
	}

	/**
	 * @param \Rbs\Store\Documents\WebStore $defaultWebStore
	 * @return $this
	 */
	public function setDefaultWebStore($defaultWebStore)
	{
		$this->defaultWebStore = $defaultWebStore;
		return $this;
	}

	/**
	 * @return \Rbs\Price\Documents\BillingArea
	 */
	public function getDefaultBillingArea()
	{
		return $this->defaultBillingArea;
	}

	/**
	 * @param \Rbs\Price\Documents\BillingArea $defaultBillingArea
	 * @return $this
	 */
	public function setDefaultBillingArea($defaultBillingArea)
	{
		$this->defaultBillingArea = $defaultBillingArea;
		return $this;
	}

	/**
	 * @return \Rbs\Catalog\Documents\Attribute
	 */
	public function getDefaultGroupAttribute()
	{
		return $this->defaultGroupAttribute;
	}

	/**
	 * @param \Rbs\Catalog\Documents\Attribute $defaultGroupAttribute
	 * @return $this
	 */
	public function setDefaultGroupAttribute($defaultGroupAttribute)
	{
		$this->defaultGroupAttribute = $defaultGroupAttribute;
		return $this;
	}

	/**
	 * @return \Change\Documents\DocumentManager
	 */
	public function getDocumentManager()
	{
		return $this->documentManager;
	}

	/**
	 * @param \Change\Documents\DocumentManager $documentManager
	 * @return $this
	 */
	public function setDocumentManager($documentManager)
	{
		$this->documentManager = $documentManager;
		return $this;
	}

	/**
	 * @return \Change\Documents\modelManager
	 */
	public function getModelManager()
	{
		return $this->modelManager;
	}

	/**
	 * @param \Change\Documents\modelManager $modelManager
	 * @return $this
	 */
	public function setModelManager($modelManager)
	{
		$this->modelManager = $modelManager;
		return $this;
	}

	/**
	 * @return \Change\I18n\I18nManager
	 */
	public function getI18nManager()
	{
		return $this->i18nManager;
	}

	/**
	 * @param \Change\I18n\I18nManager $i18nManager
	 * @return $this
	 */
	public function setI18nManager($i18nManager)
	{
		$this->i18nManager = $i18nManager;
		return $this;
	}

	/**
	 * @param \Change\Storage\StorageManager $storageManager
	 * @return $this
	 */
	public function setStorageManager($storageManager)
	{
		$this->storageManager = $storageManager;
		return $this;
	}

	/**
	 * @return \Change\Storage\StorageManager
	 */
	protected function getStorageManager()
	{
		return $this->storageManager;
	}

	/**
	 * @param \Rbs\Catalog\Attribute\AttributeManager $attributeManager
	 * @return $this
	 */
	public function setAttributeManager($attributeManager)
	{
		$this->attributeManager = $attributeManager;
		return $this;
	}

	/**
	 * @return \Rbs\Catalog\Attribute\AttributeManager
	 */
	protected function getAttributeManager()
	{
		return $this->attributeManager;
	}

	/**
	 * @return \Rbs\Stock\StockManager
	 */
	public function getStockManager()
	{
		return $this->stockManager;
	}

	/**
	 * @param \Rbs\Stock\StockManager $stockManager
	 * @return $this
	 */
	public function setStockManager($stockManager)
	{
		$this->stockManager = $stockManager;
		return $this;
	}

	/**
	 * @return \Change\Documents\DocumentCodeManager
	 */
	public function getDocumentCodeManager()
	{
		return $this->documentCodeManager;
	}

	/**
	 * @param \Change\Documents\DocumentCodeManager $documentCodeManager
	 * @return $this
	 */
	public function setDocumentCodeManager($documentCodeManager)
	{
		$this->documentCodeManager = $documentCodeManager;
		return $this;
	}

	/**
	 * @return \Rbs\Sampledata\Import\DocumentsResolver
	 */
	public function getDocumentsResolver()
	{
		if (!$this->documentsResolver)
		{
			$this->documentsResolver = new \Rbs\Sampledata\Import\DocumentsResolver($this->documentManager, $this->documentCodeManager, $this->contextId);
		}
		return $this->documentsResolver;
	}

	/**
	 * @param \Rbs\Sampledata\Import\DocumentsResolver $documentsResolver
	 * @return $this
	 */
	public function setDocumentsResolver($documentsResolver)
	{
		$this->documentsResolver = $documentsResolver;
		return $this;
	}

	/**
	 * @param array $data
	 * @return \Rbs\Catalog\Documents\Product
	 */
	public function import(array $data)
	{
		$validData = $this->validData($data);
		if (is_array($validData))
		{
			$code = $validData['_id'];
			$product = $this->getDocumentsResolver()->getProduct($code);
			if ($product === null)
			{
				$newProduct = true;
				/** @var \Rbs\Catalog\Documents\Product $product */
				$product = $this->getDocumentManager()->getNewDocumentInstanceByModelName('Rbs_Catalog_Product');
				$product->setRefLCID($validData['refLCID']);
			}
			else
			{
				$newProduct = false;
			}

			$product->setNewSkuOnCreation(false);
			$product->useCorrection(false);

			$skuData = (isset($validData['sku'])) ? $validData['sku'] : null;
			$sku = null;
			if (is_array($skuData))
			{
				$sku = $this->importSku($skuData);
				if (!$sku)
				{
					return null;
				}
			}
			$product->setSku($sku);

			foreach ($validData['LCID'] as $LCID => $productLocalizedData)
			{
				try
				{
					$this->getDocumentManager()->pushLCID($LCID);
					if ($validData['refLCID'] == $LCID)
					{
						if (isset($validData['group']) && isset($validData['category']))
						{
							$sectionCode = $validData['group'] . '_' . $validData['category'];
							$section = $this->getDocumentsResolver()->getSection($sectionCode);
							if ($section)
							{
								$product->setPublicationSections([$section]);
							}
							else
							{
								echo 'Invalid publication section: ', $sectionCode, ' on product: ', $code, PHP_EOL;
							}
						}
						else
						{
							$product->setPublicationSections([]);
						}

						if (!$this->saveProduct($product, $validData, $productLocalizedData))
						{
							$this->getDocumentManager()->popLCID();
							return null;
						}
					}
					else
					{
						if (!$this->saveLocalizedProduct($product, $productLocalizedData))
						{
							$this->getDocumentManager()->popLCID();
							return null;
						}
					}
					$this->getDocumentManager()->popLCID();
				}
				catch (\Exception $e)
				{
					$this->getDocumentManager()->popLCID($e);
				}
			}

			if ($newProduct)
			{
				$this->getDocumentCodeManager()->addDocumentCode($product, $code, $this->contextId);
				$this->publishProduct($product, 'PUBLISHABLE');
			}
			return $product;
		}
		return null;
	}

	public function validData($data)
	{
		if (!is_array($data) || !isset($data['_id']) ||
			!isset($data['LCID']) || !is_array($data['LCID']) || !count($data['LCID'])) {
			return null;
		}

		$refLCID = null;
		foreach ($data['LCID'] as $LCID => $i18nData)
		{
			if (!$refLCID)
			{
				$refLCID = $LCID;
			}

			if (!is_array($i18nData) || !isset($i18nData['title']))
			{
				return null;
			}
		}
		$data['refLCID'] = $refLCID;
		if (isset($data['variantGroup']) && is_array($data['variantGroup']) && isset($data['variantGroup']['rootProduct_id']))
		{
			$rootProductId = $data['variantGroup']['rootProduct_id'];
			if ($rootProductId === $data['_id'])
			{
				if (!isset($data['variantGroup']['axesAttributes_id']) || !is_array($data['variantGroup']['axesAttributes_id'])
				 || !count($data['variantGroup']['axesAttributes_id']))
				{
					return null;
				}
				unset($data['sku']);
			}
			else
			{
				$rootProduct = $this->getDocumentsResolver()->getProduct($rootProductId);
				if (!$rootProduct) {
					return null;
				}
			}
		}
		else
		{
			unset($data['variantGroup']);
		}

		if (isset($data['sku']))
		{
			$sku = $data['sku'];
			if (!is_array($sku) || !isset($sku['code'])) {
				return null;
			}
			if (isset($sku['prices']) && is_array($sku['prices']))
			{
				foreach ($sku['prices'] as $idx => $priceData)
				{
					if (!isset($priceData['value']) || !is_numeric($priceData['value'])) {
						return null;
					}
				}
			}
			else
			{
				unset($data['sku']['prices']);
			}
		}
		return $data;
	}

	/**
	 * @param \Rbs\Catalog\Documents\Product $product
	 * @param array $productData
	 * @param array $productLocalizedData
	 * @return boolean
	 */
	protected function saveProduct(\Rbs\Catalog\Documents\Product $product, array $productData, array $productLocalizedData)
	{
		$product->setLabel($productLocalizedData['title']);

		if (isset($productData['visuals_id']) && is_array($productData['visuals_id']))
		{
			$visuals = [];
			foreach ($productData['visuals_id'] as $visualUrl)
			{
				$visual = $this->importVisual($visualUrl);
				if ($visual)
				{
					$visuals[] = $visual;
				}
			}
			$product->setVisuals($visuals);
		}

		if (array_key_exists('brand_id', $productData))
		{
			$product->setBrand($this->getDocumentsResolver()->getBrand($productData['brand_id']));
		}

		$addVariantGroup = false;

		if (isset($productData['variantGroup']))
		{
			$rootProductId = $productData['variantGroup']['rootProduct_id'];
			if (!$product->getVariantGroup())
			{
				if ($productData['_id'] == $rootProductId)
				{
					$addVariantGroup = true;
					$product->setVariant(false);
				}
				else
				{
					$rootProduct = $this->getDocumentsResolver()->getProduct($rootProductId);
					$variantGroup = $rootProduct->getVariantGroup();
					if ($variantGroup)
					{
						$product->setVariantGroup($variantGroup);
						$product->setAttribute($variantGroup->getGroupAttribute());
						$product->setVariant(true);
					}
				}
			}
		}
		else
		{
			$product->setVariant(false);
		}

		$section = $this->defaultSection;
		if ($section)
		{
			if (!$product->getVariant())
			{
				$product->getPublicationSections()->add($section);
			}
			else
			{
				$product->setPublicationSections([]);
			}
		}

		if (!$product->getAttribute() || !$product->getVariant(false))
		{
			$groupAttribute = null;
			if (isset($productData['attributeGroup_id']))
			{
				$groupAttribute = $this->getDocumentsResolver()->getAttribute($productData['attributeGroup_id']);
			}
			else
			{
				$groupAttribute = $this->getDefaultGroupAttribute();
			}

			if ($groupAttribute && $groupAttribute->getValueType() === \Rbs\Catalog\Documents\Attribute::TYPE_GROUP)
			{
				if (isset($productLocalizedData['attributeValues']) && is_array($productLocalizedData['attributeValues']) && count($productLocalizedData['attributeValues']))
				{
					$this->updateDefaultAttribute($groupAttribute, $productLocalizedData['attributeValues']);
				}
				$product->setAttribute($groupAttribute);
			}
		}

		$productLocalization = $product->getCurrentLocalization();
		$productLocalization->setTitle($productLocalizedData['title']);
		if (isset($productLocalizedData['description']))
		{
			$description = new \Change\Documents\RichtextProperty();
			$description->setEditor('Html');
			$description->setRawText($productLocalizedData['description']);
			$productLocalization->setDescription($description);
		}

		$attrValues = [];
		if (isset($productLocalizedData['attributeValues']))
		{
			$attrValues = $this->importAttributesValue($productLocalizedData['attributeValues']);
		}

		$normalizedValues = $this->getAttributeManager()->normalizeRestAttributeValues($attrValues, $product->getAttribute());
		$productLocalization->setAttributeValues($normalizedValues);
		if ($this->saveDocument($product))
		{
			if ($addVariantGroup)
			{
				$this->importNewVariantGroup($product, $productData);
			}
			return true;
		}
		return false;
	}

	/**
	 * @param \Rbs\Catalog\Documents\Product $product
	 * @param array $productLocalizedData
	 * @return boolean
	 */
	protected function saveLocalizedProduct(\Rbs\Catalog\Documents\Product $product, array $productLocalizedData)
	{
		$productLocalization = $product->getCurrentLocalization();
		$productLocalization->setTitle($productLocalizedData['title']);
		if (isset($productLocalizedData['description']))
		{
			$description = new \Change\Documents\RichtextProperty();
			$description->setEditor('Html');
			$description->setRawText($productLocalizedData['description']);
			$productLocalization->setDescription($description);
		}

		$attrValues = [];
		if (isset($productLocalizedData['attributeValues']) && is_array($productLocalizedData['attributeValues']))
		{
			$attrValues = $this->importAttributesValue($productLocalizedData['attributeValues']);
		}

		$normalizedValues = $this->getAttributeManager()->normalizeRestAttributeValues($attrValues, $product->getAttribute());
		$productLocalization->setAttributeValues($normalizedValues);
		return $this->saveDocument($product);
	}

	/**
	 * @param array $skuData
	 * @return \Rbs\Stock\Documents\Sku|null
	 */
	protected function importSku(array $skuData)
	{
		$code = $skuData['code'];
		/** @var $sku \Rbs\Stock\Documents\Sku */
		$sku = $this->getDocumentsResolver()->getSku($code);
		if ($sku === null)
		{
			$sku = $this->getDocumentManager()->getNewDocumentInstanceByModelName('Rbs_Stock_Sku');
			$sku->setCode($code);
		}
		$sku->useCorrection(false);

		foreach ($skuData as $entryName => $entryValue)
		{
			switch ($entryName)
			{
				case 'code' :
				case 'prices' :
					break;
				case 'ean13' :
					$sku->setEan13($entryValue);
					break;
				case 'upc' :
					$sku->setUpc($entryValue);
					break;
				case 'jan' :
					$sku->setJan($entryValue);
					break;
				case 'isbn' :
					$sku->setIsbn($entryValue);
					break;
				case 'partNumber' :
					$sku->setPartNumber($entryValue);
					break;
				case 'unit' :
					$sku->setUnit($entryValue);
					break;
				case 'unlimitedInventory' :
					$sku->setUnlimitedInventory($entryValue);
					break;
				case 'allowQuantitySplit' :
					$sku->setAllowQuantitySplit($entryValue);
					break;
				case 'allowBackorders' :
					$sku->setAllowBackorders($entryValue);
					break;
				case 'quantityIncrement' :
					$sku->setQuantityIncrement($entryValue);
					break;
				case 'minQuantity' :
					$sku->setMinQuantity($entryValue);
					break;
				case 'maxQuantity' :
					$sku->setMaxQuantity($entryValue);
					break;
				case 'thresholds' :
					if (is_array($entryValue))
					{
						$thresholds = [];
						foreach ($entryValue as $threshold)
						{
							if (is_array($threshold) && isset($threshold['threshold']) && isset($threshold['code']))
							{
								$thresholds[] = [
									'l' => min(intval($threshold['threshold']), \Rbs\Stock\StockManager::UNLIMITED_LEVEL),
									'c' => $threshold['code']
								];
							}
						}
						$sku->setThresholds($thresholds);
					}
					break;
				case 'virtual' :
					$sku->setVirtual($entryValue);
					break;
				case 'physicalProperties' :
					$sku->setPhysicalProperties($entryValue);
					break;
			}
		}

		if ($this->saveDocument($sku))
		{
			if (isset($skuData['level']))
			{
				$level = intval($skuData['level']);
				if ($level < 0)
				{
					$level = 0;
				}
				elseif ($level > \Rbs\Stock\StockManager::UNLIMITED_LEVEL)
				{
					$level = \Rbs\Stock\StockManager::UNLIMITED_LEVEL;
				}
			}
			else
			{
				$level = 100;
			}

			$inventoryEntry = $this->getStockManager()->getInventoryEntry($sku, $this->getDefaultWebStore()->getWarehouseId());
			if (!$inventoryEntry)
			{
				/** @var $inventoryEntry \Rbs\Stock\Documents\InventoryEntry */
				$inventoryEntry = $this->getDocumentManager()->getNewDocumentInstanceByModelName('Rbs_Stock_InventoryEntry');
				$inventoryEntry->setLevel($level);
				$inventoryEntry->setSku($sku);
				$inventoryEntry->setWarehouse($this->getDefaultWebStore()->getWarehouseIdInstance());
				$inventoryEntry->save();
			}
			elseif ($inventoryEntry->getLevel() != $level)
			{
				$inventoryEntry->setLevel($level);
				$inventoryEntry->save();
			}

			if (isset($skuData['prices']) && is_array($skuData['prices']))
			{
				$prices = [];
				foreach ($skuData['prices'] as $priceData)
				{
					if (!isset($priceData['startActivation']))
					{
						$priceData['startActivation'] = '2009-12-31T23:00:00Z';
					}
					$startActivation = new \DateTime($priceData['startActivation']);
					$prices[$startActivation->format(\DateTime::ISO8601)] = $priceData;
				}
				ksort($prices);

				$basePrice = null;
				foreach ($prices as $startActivation => $priceData)
				{
					$price = $this->importPrice($sku, $priceData, $basePrice);
					if (!$price)
					{
						return null;
					}

					if (!$basePrice)
					{
						$basePrice = $price;
					}
				}
			}
			return $sku;
		}
		return null;
	}

	/**
	 * @param \Rbs\Stock\Documents\Sku $sku
	 * @param array $priceData
	 * @param \Rbs\Price\Documents\Price $basePrice
	 * @return \Rbs\Price\Documents\Price|null
	 */
	protected function importPrice(\Rbs\Stock\Documents\Sku $sku, array $priceData, \Rbs\Price\Documents\Price $basePrice = null)
	{
		// La clé de mise a jour est la combinaison de sku_id, webStore_id, billingArea_id, startActivation

		$priceData += ['taxCategories' => null, 'discountDetail' => null, 'ecoTax' => null, 'target_id' => null,
			'endActivation' => null, 'basePriceValue' => null];

		/** @var $webStore \Rbs\Store\Documents\WebStore */
		$webStore = $this->getDefaultWebStore();

		/** @var $billingArea \Rbs\Price\Documents\BillingArea */
		$billingArea = $this->getDefaultBillingArea();

		$targetId = $priceData['target_id'];
		if ($targetId)
		{
			$target = $this->getDocumentsResolver()->getTarget($targetId);
			$targetId = ($target) ? $target->getId() : 0;
		}
		else
		{
			$targetId = 0;
			$target = null;
		}

		$startActivation = new \DateTime($priceData['startActivation']);

		$query = $this->getDocumentManager()->getNewQuery('Rbs_Price_Price');
		$query->andPredicates(
			$query->eq('sku', $sku),
			$query->eq('webStore', $webStore),
			$query->eq('billingArea', $billingArea),
			$query->eq('targetId', $targetId),
			$query->eq('startActivation', $startActivation));

		/** @var $price \Rbs\Price\Documents\Price */
		$price = $query->getFirstDocument();
		if ($price === null)
		{
			$price = $this->getDocumentManager()->getNewDocumentInstanceByModelName('Rbs_Price_Price');
			$price->setSku($sku);
			$price->setWebStore($webStore);
			$price->setBillingArea($billingArea);
			$price->setStartActivation($startActivation);
			if ($target)
			{
				$price->setTargetId($targetId);
				$price->setPriority($target->getDefaultPriority());
			}
		}
		$price->setTaxCategories($priceData['taxCategories']);
		$price->setDiscountDetail($priceData['discountDetail']);
		$price->setValue($priceData['value']);
		$price->setEcoTax(isset($priceData['ecoTax']) ? $priceData['ecoTax'] : null);
		if (isset($priceData['endActivation']))
		{
			$price->setEndActivation(new \DateTime($priceData['endActivation']));
		}
		else
		{
			$price->setEndActivation(null);
		}
		if (isset($priceData['basePriceValue']))
		{
			$price->setBasePrice($basePrice);
			if (!isset($priceData['discountDetail'])){
				$price->setDiscountDetail('-' . round(100 - (($priceData['value'] / $priceData['basePriceValue']) * 100)) . '%');
			}
		}
		elseif ($price->getBasePrice())
		{
			$price->getBasePrice()->delete();
			$price->setBasePrice(null);
		}

		$this->saveDocument($price);
		return $price;
	}

	/**
	 * @param string $visualUrl
	 * @return \Rbs\Media\Documents\Image|null
	 */
	protected function importVisual($visualUrl)
	{
		$path = @parse_url($visualUrl, PHP_URL_PATH);
		if ($path === false) {
			return null;
		}
		$storageManager = $this->getStorageManager();

		$normalizedPath = $storageManager->getStorageByName('images')->normalizePath($path);
		if (strpos($normalizedPath, 'images/') === 0)
		{
			$normalizedPath = substr($normalizedPath, 7);
		}

		$changeURI = $this->getStorageManager()->buildChangeURI('images', '/' .$normalizedPath)
			->normalize()->toString();

		$itemInfo = $this->getStorageManager()->getItemInfo($changeURI);
		if ($itemInfo === null || !$itemInfo->isFile())
		{
			$data = @file_get_contents($visualUrl);
			if ($data === false)
			{
				return null;
			}
			file_put_contents($changeURI, $data);
		}
		else
		{
			@touch($changeURI);
		}

		/** @var $image \Rbs\Media\Documents\Image */
		$image = $this->getDocumentsResolver()->getImage($path);
		if ($image === null)
		{
			$image = $this->getDocumentManager()->getNewDocumentInstanceByModelName('Rbs_Media_Image');
			$image->setLabel($path);
			$image->setPath($changeURI);
			if ($this->saveDocument($image))
			{
				$this->getDocumentCodeManager()->addDocumentCode($image, $path, $this->contextId);
				return $image;
			}
			return null;
		}
		return $image;
	}

	/**
	 * @param \Rbs\Catalog\Documents\Product $product
	 * @param array $productData
	 */
	protected function importNewVariantGroup(\Rbs\Catalog\Documents\Product $product, array $productData)
	{
		/** @var $variantGroup \Rbs\Catalog\Documents\VariantGroup */
		$variantGroupData = $productData['variantGroup'];
		$variantGroup = $this->getDocumentManager()->getNewDocumentInstanceByModelName('Rbs_Catalog_VariantGroup');
		$variantGroup->setLabel($product->getLabel());
		$variantGroup->setRootProduct($product);
		$this->updateVariantGroupAttributes($variantGroup, $variantGroupData);

		(new \Rbs\Catalog\Job\AxesConfiguration())->updateGroupAttribute($this->getAttributeManager(),
			$this->getDocumentManager(), $variantGroup);

		$this->saveDocument($variantGroup);
	}

	/**
	 * @param \Rbs\Catalog\Documents\VariantGroup $variantGroup
	 * @param array $variantGroupData
	 */
	protected function updateVariantGroupAttributes($variantGroup, array $variantGroupData)
	{
		$axesAttributes = [];
		foreach ($variantGroupData['axesAttributes_id'] as $axesAttributeId)
		{
			$axesAttribute = $this->getDocumentsResolver()->getAttribute($axesAttributeId);
			if ($axesAttribute)
			{
				$axesAttributes[] = $axesAttribute;
			}
			else
			{
				$axesAttributes[] = $this->createNewAttribute($axesAttributeId, true);
			}
		}
		$variantGroup->setAxesAttributes($axesAttributes);

		if (isset($variantGroupData['otherAttributes_id']) && is_array($variantGroupData['otherAttributes_id']))
		{
			$otherAttributes = [];
			foreach ($variantGroupData['otherAttributes_id'] as $otherAttributeId)
			{
				$otherAttribute = $this->getDocumentsResolver()->getAttribute($otherAttributeId);
				if ($otherAttribute)
				{
					$otherAttributes[] = $otherAttribute;
				}
				else
				{
					$otherAttributes[] = $this->createNewAttribute($otherAttributeId);
				}
			}

			$variantGroup->setOthersAttributes($otherAttributes);
		}

	}

	/**
	 * @param \Change\Documents\AbstractDocument $document
	 * @return bool
	 */
	protected function saveDocument(\Change\Documents\AbstractDocument $document)
	{
		$documentShortName = $document->getDocumentModel()->getShortName();
		try
		{
			$modProps = $document->getModifiedPropertyNames();
			if (count($modProps))
			{
				if ($document->isNew()) {
					//echo 'New document ';
				}
				$document->save();
				//echo $document, ' saved: ', implode(', ',$modProps), PHP_EOL;
			}
			else
			{
				//echo $document, ' not modified', PHP_EOL;
			}
			return true;
		}
		catch (\Change\Documents\PropertiesValidationException $e)
		{
			$properties = $e->getPropertiesErrors();
			foreach ($properties as $propertyName => $messages)
			{
				echo 'Invalid property ', $propertyName, ' on document ', $documentShortName, ': ', implode(', ', $messages), PHP_EOL;
			}
		}
		catch (\Exception $e)
		{
			echo 'Unable to save document ', $documentShortName, ': ' . $e->getMessage();
		}
		return false;
	}


	//ATTRIBUTES

	/**
	 * @param string $attributeId
	 * @param boolean $axis
	 * @return \Rbs\Catalog\Documents\Attribute
	 * @throws \Exception
	 */
	protected function createNewAttribute($attributeId, $axis = false)
	{
		/** @var $attribute \Rbs\Catalog\Documents\Attribute */
		$attribute = $this->getDocumentManager()->getNewDocumentInstanceByModelName('Rbs_Catalog_Attribute');
		$attribute->setLabel($attributeId);
		$attribute->getCurrentLocalization()->setTitle($attributeId);
		$attribute->setVisibility(null);
		$attribute->setValueType(\Rbs\Catalog\Documents\Attribute::TYPE_STRING);
		$attribute->setAxis($axis);
		$this->saveDocument($attribute);
		$this->getDocumentCodeManager()->addDocumentCode($attribute, $attributeId, $this->contextId);
		return $attribute;
	}


	/**
	 * @param array $attributeValues
	 * @return array
	 */
	protected function importAttributesValue($attributeValues)
	{
		$attrValues = [];
		foreach ($attributeValues as $attributeValue)
		{
			$attribute = $this->getDocumentsResolver()->getAttribute($attributeValue['attribute_id']);
			if ($attribute)
			{
				$v = strval($attributeValue['value']);
				$attrValues[] = ['id' => $attribute->getId(), 'valueType' => $attribute->getValueType(), 'value' => $v];
			}
		}
		return $attrValues;
	}

	/**
	 * @param \Rbs\Catalog\Documents\Attribute $defaultAttribute
	 * @param array $attributeValues
	 */
	protected function updateDefaultAttribute(\Rbs\Catalog\Documents\Attribute $defaultAttribute, array $attributeValues)
	{
		$modified = false;
		$currentIds = $defaultAttribute->getAttributesIds();
		foreach ($attributeValues as $attributeValue)
		{
			$attribute = $this->getDocumentsResolver()->getAttribute($attributeValue['attribute_id']);

			if (!$attribute)
			{
				$attribute = $this->createNewAttribute($attributeValue['attribute_id']);
			}

			if (!in_array($attribute->getId(), $currentIds))
			{
				$modified = true;
				$defaultAttribute->getAttributes()->add($attribute);
			}
		}
		if ($modified)
		{
			$defaultAttribute->save();
		}
	}

	//PUBLICATION
	protected $publicationTaskCodes = ['requestValidation', 'contentValidation', 'publicationValidation'];

	/**
	 * @param \Rbs\Catalog\Documents\Product $product
	 */
	public function publishProduct(\Rbs\Catalog\Documents\Product $product)
	{
		foreach ($product->getLCIDArray() as $LCID)
		{
			try
			{
				$this->getDocumentManager()->pushLCID($LCID);

				$this->executePublicationTask($product, $LCID, $this->publicationTaskCodes);

				$this->getDocumentManager()->popLCID();
			}
			catch (\Exception $e)
			{
				$this->getDocumentManager()->popLCID($e);
			}
		}
	}

	/**
	 * @param \Change\Documents\AbstractDocument $document
	 * @param string $LCID
	 * @param array $publicationTaskCodes
	 */
	protected function executePublicationTask(\Change\Documents\AbstractDocument $document, $LCID, array $publicationTaskCodes)
	{
		$query = $this->getDocumentManager()->getNewQuery('Rbs_Workflow_Task');

		$query->andPredicates(
			$query->in('taskCode', $publicationTaskCodes),
			$query->eq('document', $document),
			$query->eq('documentLCID', $LCID),
			$query->eq('status', \Change\Workflow\Interfaces\WorkItem::STATUS_ENABLED));

		$task = $query->getFirstDocument();
		if ($task instanceof \Rbs\Workflow\Documents\Task)
		{
			$userId = 0;
			$context = [];
			$workflowInstance = $task->execute($context, $userId);
			if ($workflowInstance)
			{
				$this->executePublicationTask($document, $LCID, $publicationTaskCodes);
			}
		}
	}
}