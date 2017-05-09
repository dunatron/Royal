<?php

class Research extends RoyalSocContent
{
	private static $can_be_root = false;

	private static $singular_name = 'Research';
	private static $plural_name = 'Research';

	private static $icon = 'mysite/icons/research2.png';

	private static $db = array(
		'ResearcherName' => 'VarChar(255)',
		'ResearcherEmail' => 'VarChar(255)',
		'ResearcherOrganisation' => 'VarChar(255)',
		'ExternalLink1' => 'VarChar(255)',
        'ExternalLink2' => 'VarChar(255)',
        'ExternalLink1Title' => 'VarChar(255)',
        'ExternalLink2Title' => 'VarChar(255)'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$field = new TextField('ResearcherName', 'Researcher Name');
        $fields->addFieldToTab('Root.Main', $field, 'Intro');

        $field = new EmailField('ResearcherEmail', 'Researcher Email');
        $fields->addFieldToTab('Root.Main', $field, 'Intro');

        $field = new TextField('ResearcherOrganisation', 'Researcher Organisation');
        $fields->addFieldToTab('Root.Main', $field, 'Intro');

        $field = new TextField('ExternalLink1Title', 'Link 1 Title');
        $fields->addFieldToTab('Root.Main', $field, 'Intro');

        $field = new TextField('ExternalLink1', 'Link 1');
        $fields->addFieldToTab('Root.Main', $field, 'Intro');

        $field = new TextField('ExternalLink2Title', 'Link 2 Title');
        $fields->addFieldToTab('Root.Main', $field, 'Intro');

        $field = new TextField('ExternalLink2', 'Link 2');
        $fields->addFieldToTab('Root.Main', $field, 'Intro');

		return $fields;
	}

}