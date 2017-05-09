<?php

class Quotes extends DataObject 
{
	private static $db = array(
		'Title' => 'Varchar(255)',
		'Person' => 'Varchar(255)',
		'Quote' => 'Text'
	);

	private static $summary_fields = array(
		'Title' => 'Title',
		'Person' => 'Person',
		'Quote' => 'Quote'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		return $fields;
	}

}