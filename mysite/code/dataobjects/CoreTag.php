<?php

class CoreTag extends DataObject
{
	private static $db = array(
		'Tag' => 'VarChar(255)',
		'IsSystem' => 'Boolean(false)'
	);

	private static $indexes = array(
		'Tag_Index' => array('type' => 'unique', 'value' =>  'Tag')
	);

	private static $belongs_many_many = array(
		'Pages' => 'Page'
	);

	private static $summary_fields = array(
		'Tag' => 'Tag'
	);

	public function getTitle()
	{
		return $this->Tag;
	}

	public function canDelete()
	{
		return false;
	}

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->removeFieldFromTab('Root.Main','IsSystem');

		$fields->removeFieldFromTab('Root','RoyalSocContent');
		$fields->removeFieldFromTab('Root','Projects');
		$fields->removeFieldFromTab('Root','Panels');

		return $fields;
	}

	public function getCMSValidator() 
	{
		return new RequiredFields(array('Tag'));
	}

	protected function onBeforeWrite() {	
		parent::onBeforeWrite();
		
		$current = CoreTag::get()->byID($this->ID)->Tag;
		Page::updatePromoteTag($current, $this->Tag);

	}

	function canView($member = null)
	{
		return true;
	}

}


