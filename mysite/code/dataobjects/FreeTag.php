<?php

class FreeTag extends DataObject
{
	private static $db = array(
		'FreeTag' => 'VarChar(255)',
	);

	private static $has_one = array(
		'RoyalSocContent' => 'RoyalSocContent'
	);

	private static $summary_fields = array(
		'FreeTag' => 'Free Tag'
	);

	public function getTitle()
	{
		return $this->FreeTag;
	}

	public function getCMSValidator() {
		return new RequiredFields(array('FreeTag'));
	}

}