<?php

class FundOpportunityType extends DataObject
{
	private static $db = array(
		'Type' => 'VarChar(255)',
	);

	private static $summary_fields = array(
		'Title' => 'Type'
	);

	private static $belongs_many_many = array(
		'FundsOpportunities' => 'FundOpportunity'
	);

	static $searchable_fields = array(
        'Type'
    );

    public function getCMSValidator() {
		return new RequiredFields(array('Type'));
	}

	public function getTitle()
	{
		return $this->Type;
	}

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		
		$fields->removeFieldFromTab('Root','FundsOpportunities');

		return $fields;
	}
}
