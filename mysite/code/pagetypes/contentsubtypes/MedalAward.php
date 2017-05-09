<?php

class MedalAward extends RoyalSocContent
{
	private static $can_be_root = false;

	//private static $hide_ancestor = 'MedalsAwardsPanel';

	private static $singular_name = 'Medal Award';
	private static $plural_name = 'Medal Awards';

	private static $icon = 'mysite/icons/medal.png';

	private static $db = array();

	// private static $has_one = array(
	// 	'Audience' => 'MedalAwardAudience'
	// );

	private static $many_many = array(
		'Subjects' => 'Subject',
		'Audience' => 'MedalAwardAudience'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$field = new CheckboxSetField('Audience','Audience(s)', MedalAwardAudience::get()->map('ID','Title'));
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		$field = new CheckboxSetField('Subjects','Subjects', Subject::get()->map('ID','Title'));
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		return $fields;
	}

}

class MedalAward_Controller extends RoyalSocContent_Controller
{

}