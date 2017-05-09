<?php

class FieldResearchCategory extends DataObject
{
	private static $db = array(
		'FieldResearchCategory' => 'VarChar(255)'
	);

	private static $summary_fields = array(
		'Title' => 'Field Research Category'
	);

	private static $has_many = array(
		'FieldResearchSubCategories' => 'FieldResearchSubCategory'
	);

	public function getCMSValidator() {
		return new RequiredFields(array('FieldResearchCategory'));
	}

	public function getTitle()
	{
		return $this->FieldResearchCategory;
	}

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		
		$fields->removeFieldFromTab('Root','FieldResearchSubCategories');

		return $fields;
	}

}

class FieldResearchSubCategory extends DataObject
{
	private static $db = array(
		'FieldResearchSubCategory' => 'VarChar(255)'
	);

	private static $summary_fields = array(
		'Title' => 'Field Research SubCategory'
	);

	private static $has_one = array(
		'FieldResearchCategory' => 'FieldResearchCategory'
	);

	private static $has_many = array(
		'FieldResearchCodes' => 'FieldResearchCode'
	);

	public function getCMSValidator() {
		return new RequiredFields(array('FieldResearchSubCategory'));
	}


	public function getTitle()
	{
		return $this->FieldResearchCategory()->Title.' : '.$this->FieldResearchSubCategory;
	}

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		
		$fields->removeFieldFromTab('Root','FieldResearchCodes');

		return $fields;
	}

}

class FieldResearchCode extends DataObject
{
	private static $db = array(
		'FieldResearchCode' => 'VarChar(255)'
	);

	private static $summary_fields = array(
		'Title' => 'Field Research Code'
	);

	private static $has_one = array(
		'FieldResearchSubCategory' => 'FieldResearchSubCategory'
	);

	public function getCMSValidator() {
		return new RequiredFields(array('FieldResearchCode'));
	}

	public function getTitle()
	{
		return $this->FieldResearchSubCategory()->Title.' : '.$this->FieldResearchCode;
	}

}