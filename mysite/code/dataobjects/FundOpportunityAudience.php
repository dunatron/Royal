<?php

class FundOpportunityAudience extends DataObject
{
	private static $db = array(
		'Audience' => 'VarChar(255)',
	);

	private static $summary_fields = array(
		'Title' => 'Audience'
	);

	private static $belongs_many_many = array(
		'FundsOpportunities' => 'FundOpportunity'
	);

	static $searchable_fields = array(
        'Audience'
    );

    public function getCMSValidator() {
		return new RequiredFields(array('Audience'));
	}

	public function getTitle()
	{
		return $this->Audience;
	}

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		
		$fields->removeFieldFromTab('Root','FundsOpportunities');

		return $fields;
	}
}
