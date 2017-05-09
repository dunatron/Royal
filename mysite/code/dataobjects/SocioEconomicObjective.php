<?php

class SocioEconomicObjectiveCategory extends DataObject
{
	private static $db = array(
		'SocioEconomicObjectiveCategory' => 'VarChar(255)'
	);

	private static $summary_fields = array(
		'Title' => 'Socio Economic Objective Category'
	);

	private static $has_many = array(
		'SocioEconomicObjectiveSubCategories' => 'SocioEconomicObjectiveSubCategory'
	);

	public function getCMSValidator() {
		return new RequiredFields(array('SocioEconomicObjectiveCategory'));
	}

	public function getTitle()
	{
		return $this->SocioEconomicObjectiveCategory;
	}

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		
		$fields->removeFieldFromTab('Root','SocioEconomicObjectiveSubCategories');

		return $fields;
	}

}

class SocioEconomicObjectiveSubCategory extends DataObject
{
	private static $db = array(
		'SocioEconomicObjectiveSubCategory' => 'VarChar(255)'
	);

	private static $summary_fields = array(
		'Title' => 'Socio Economic Objective SubCategory'
	);

	private static $has_one = array(
		'SocioEconomicObjectiveCategory' => 'SocioEconomicObjectiveCategory'
	);

	private static $has_many = array(
		'SocioEconomicObjectiveCodes' => 'SocioEconomicObjectiveCode'
	);

	public function getCMSValidator() {
		return new RequiredFields(array('SocioEconomicObjectiveSubCategory'));
	}

	public function getTitle()
	{
		return $this->SocioEconomicObjectiveCategory()->Title.' : '.$this->SocioEconomicObjectiveSubCategory;
	}

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		
		$fields->removeFieldFromTab('Root','SocioEconomicObjectiveCodes');

		return $fields;
	}

}

class SocioEconomicObjectiveCode extends DataObject
{
	private static $db = array(
		'SocioEconomicObjectiveCode' => 'VarChar(255)'
	);

	private static $summary_fields = array(
		'Title' => 'Socio Economic Objective Code'
	);

	private static $has_one = array(
		'SocioEconomicObjectiveSubCategory' => 'SocioEconomicObjectiveSubCategory'
	);

	public function getCMSValidator() {
		return new RequiredFields(array('SocioEconomicObjectiveCode'));
	}

	public function getTitle()
	{
		return $this->SocioEconomicObjectiveSubCategory()->Title.' : '.$this->SocioEconomicObjectiveCode;
	}

}