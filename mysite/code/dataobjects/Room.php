<?php

class Room extends DataObject
{
	private static $db = array(
		'Room' => 'VarChar(255)'
	);

	private static $indexes = array(
		'Room_Index' => array('type' => 'unique', 'value' =>  'Room')
	);

	private static $summary_fields = array(
		'Room' => 'Room'
	);

	public function getTitle()
	{
		return $this->Room;
	}

	public function getCMSValidator() {
		return new RequiredFields(array('Room'));
	}

}


