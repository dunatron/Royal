<?php

class Subject extends DataObject
{
	private static $db = array(
		'Subject' => 'VarChar(255)'
	);

	private static $belongs_many_many = array(
		'MedalsAwards' => 'MedalAward'
	);

	private static $summary_fields = array(
		'Title' => 'Subject'
	);

	private static $searchable_fields = array(
        'Subject'
    );

    public function getCMSValidator() {
		return new RequiredFields(array('Subject'));
	}

	public function getTitle()
	{
		return $this->Subject;
	}

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		
		$fields->removeFieldFromTab('Root','MedalsAwards');

		return $fields;
	}
}