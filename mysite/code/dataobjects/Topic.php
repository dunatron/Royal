<?php

class Topic extends DataObject
{
	private static $db = array(
		'Title' => 'VarChar(255)',
		'Email' => 'VarChar(255)'
	);

	private static $summary_fields = array(
		'Title' => 'Topic Title',
		'Email' => 'Contact Email Address'



	);



	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		 $fields = new FieldList(
            TextField::create('Title'),
            EmailField::create('Email')
        );

		return $fields;
	}

	public function getCMSValidator() 
	{
		return new RequiredFields(array('Title','Email'));
	}

}

