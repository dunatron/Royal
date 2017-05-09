<?php

class FundOpportunity extends RoyalSocContent
{

	private static $can_be_root = false;


	//private static $hide_ancestor = 'FundsOpportunitiesPanel';

	private static $singular_name = 'Fund and Opportunity';
	private static $plural_name = 'Funds and Opportunities';

	private static $icon = 'mysite/icons/funds.png';

	private static $db = array(
		'URL' => 'VarChar(255)',
		'Email' => 'VarChar(255)'
	);

	// private static $has_one = array(
	// 	'Audience' => 'FundOpportunityAudience'
	// );

	private static $many_many = array(
		'Subjects' => 'Subject',
		'Types' => 'FundOpportunityType',
		'Audience' => 'FundOpportunityAudience'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		// $field = new Dropdownfield('AudienceID','Audience', FundOpportunityAudience::get()->map('ID','Title'));
		// $field->setEmptyString('[Select One]');
		// $fields->addFieldToTab('Root.Main', $field, 'Content');

		$field = new CheckboxSetField('Audience','Audience(s)', FundOpportunityAudience::get()->map('ID','Title'));
		$fields->addFieldToTab('Root.Main', $field, 'Content');	

		// $field = new Dropdownfield('TypeID','Type', FundOpportunityType::get()->map('ID','Title'));
		// $field->setEmptyString('[Select One]');
		// $fields->addFieldToTab('Root.Main', $field, 'Content');	

		$field = new CheckboxSetField('Types','Types', FundOpportunityType::get()->map('ID','Title'));
		$fields->addFieldToTab('Root.Main', $field, 'Content');	

		$field = new CheckboxSetField('Subjects','Subjects', Subject::get()->map('ID','Title'));
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		$field = new TextField('URL','URL');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		$field = new EmailField('Email','Email');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		return $fields;
	}

}

class FundOpportunity_Controller extends RoyalSocContent_Controller
{

}