<?php
/**
 * Copyright (C) 2014 Proximis
 * This Source Code Form is subject to the terms of the Mozilla Public
 * License, v. 2.0. If a copy of the MPL was not distributed with this
 * file, You can obtain one at http://mozilla.org/MPL/2.0/.
 */
namespace Rbs\Sampledata\Import;

/**
 * @name \Rbs\Sampledata\Import\ImportSection
 */
class ImportSection
{
	/**
	 * @var \Rbs\Website\Documents\Section
	 */
	protected $defaultSection;

	/**
	 * @var \Rbs\Website\Documents\Page
	 */
	protected $defaultCategoryIndex;

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
	 * @return \Rbs\Website\Documents\Page
	 */
	public function getDefaultCategoryIndex()
	{
		return $this->defaultCategoryIndex;
	}

	/**
	 * @param \Rbs\Website\Documents\Page $defaultCategoryIndex
	 * @return $this
	 */
	public function setDefaultCategoryIndex($defaultCategoryIndex)
	{
		$this->defaultCategoryIndex = $defaultCategoryIndex;
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
			$this->documentsResolver = new \Rbs\Sampledata\Import\DocumentsResolver($this->documentManager,
				$this->documentCodeManager, $this->contextId);
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
	 * @return \Rbs\Website\Documents\Section
	 */
	public function import(array $data)
	{
		$validData = $this->validData($data);
		if (is_array($validData))
		{
			$LCID = $validData['refLCID'];
			$newTopic = false;
			$code = $validData['_id'];
			$section = $this->getDocumentsResolver()->getSection($code);
			if (!$section)
			{
				$newTopic = true;
				/** @var \Rbs\Website\Documents\Topic $section */
				$section = $this->getDocumentManager()->getNewDocumentInstanceByModelName('Rbs_Website_Topic');
				$section->setRefLCID($LCID);
				$section->setSection($this->getDefaultSection());
			}
			$section->setLabel($validData['title']);
			$section->useCorrection(false);
			$section->getCurrentLocalization()->setTitle($validData['title']);

			if ($this->saveDocument($section))
			{
				if (!$section->getIndexPage() && $this->getDefaultCategoryIndex())
				{
					$this->setSectionPageFunction($section, $this->getDefaultCategoryIndex());
				}

				if ($newTopic)
				{
					$this->getDocumentCodeManager()->addDocumentCode($section, $code, $this->contextId);
					$this->publishTopic($section, 'PUBLISHABLE');
				}

				$this->addSectionProductList($section);
				return $section;
			}
		}
		return null;
	}

	/**
	 * @param \Rbs\Website\Documents\Section $section
	 * @param \Rbs\Website\Documents\Page $page
	 * @param string $functionCode
	 * @return \Rbs\Website\Documents\SectionPageFunction|null
	 */
	protected function setSectionPageFunction($section, $page, $functionCode = 'Rbs_Website_Section')
	{
		$query = $this->getDocumentManager()->getNewQuery('Rbs_Website_SectionPageFunction');
		$sectionPageFunction = $query->andPredicates($query->eq('functionCode', $functionCode), $query->eq('section', $section))->getFirstDocument();
		if (!$sectionPageFunction)
		{
			/* @var $sectionPageFunction \Rbs\Website\Documents\SectionPageFunction */
			$sectionPageFunction = $this->getDocumentManager()->getNewDocumentInstanceByModelName('Rbs_Website_SectionPageFunction');
			$sectionPageFunction->setSection($section);
			$sectionPageFunction->setFunctionCode($functionCode);
		}
		$sectionPageFunction->setPage($page);
		$this->saveDocument($sectionPageFunction);
		return $sectionPageFunction;
	}

	/**
	 * @param \Rbs\Website\Documents\Section $section
	 * @return \Rbs\Catalog\Documents\SectionProductList|null
	 */
	public function addSectionProductList(\Rbs\Website\Documents\Section $section)
	{
		$query = $this->getDocumentManager()->getNewQuery('Rbs_Catalog_SectionProductList');
		$query->andPredicates($query->eq('synchronizedSection', $section));

		/** @var $sectionProductList \Rbs\Catalog\Documents\SectionProductList */
		$sectionProductList = $query->getFirstDocument();
		if ($sectionProductList === null)
		{
			$sectionProductList = $this->getDocumentManager()->getNewDocumentInstanceByModelName('Rbs_Catalog_SectionProductList');
			$sectionProductList->setSynchronizedSection($section);
			$sectionProductList->setLabel($section->getLabel());
		}
		if ($this->saveDocument($sectionProductList))
		{
			return $sectionProductList;
		}
		return null;
	}


	/**
	 * @param $data
	 * @return array|null
	 */
	public function validData($data)
	{
		if (!is_array($data) || !isset($data['_id']))
		{
			return null;
		}

		if (!isset($data['refLCID']))
		{
			$data['refLCID'] = 'fr_FR';
		}
		if (!isset($data['title']))
		{
			$data['title'] = $data['_id'];
		}
		return $data;
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
				if ($document->isNew())
				{
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
				echo 'Invalid property ', $propertyName, ' on document ', $documentShortName, ': ', implode(', ',
					$messages), PHP_EOL;
			}
		}
		catch (\Exception $e)
		{
			echo 'Unable to save document ', $documentShortName, ': ' . $e->getMessage();
		}
		return false;
	}



	//PUBLICATION
	protected $publicationTaskCodes = ['requestValidation', 'contentValidation', 'publicationValidation'];

	/**
	 * @param \Rbs\Website\Documents\Topic $topic
	 */
	public function publishTopic(\Rbs\Website\Documents\Topic $topic)
	{
		foreach ($topic->getLCIDArray() as $LCID)
		{
			try
			{
				$this->getDocumentManager()->pushLCID($LCID);

				$this->executePublicationTask($topic, $LCID, $this->publicationTaskCodes);

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