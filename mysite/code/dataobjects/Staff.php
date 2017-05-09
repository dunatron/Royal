<?php

class Staff extends DataExtension
{
	private static $db = array(
		'Department' => 'Varchar(255)',
		'IsManager' => 'Boolean',
		'Profile' => 'Text',
		'JobTitle' => 'Varchar(255)',
		'DDI' => 'Varchar(55)'
	);

	private static $has_one = array(
		'StaffPhoto' => 'Image',
	);

	public function updateCMSFields(FieldList $fields)
	{
		$uploadField = new UploadField('StaffPhoto','Photo');
		
		$uploadField->setAllowedFileCategories('image');
		$uploadField->setAllowedMaxFileNumber(1);
		$uploadField->setFolderName('StaffPhotos');
		//$fields->push($uploadField);
		$fields->addFieldToTab('Root.Main', $uploadField, 'FirstName');

		$field = new TextField('Department','Department');
		$fields->addFieldToTab('Root.Main',$field,'Email');

		$field = new TextField('JobTitle','Job Title');
		$fields->addFieldToTab('Root.Main',$field,'Email');

		$field = new CheckboxField('IsManager','Department Manager');
		$fields->addFieldToTab('Root.Main', $field, 'Email');

		$field = new TextareaField('Profile','Profile');
		$fields->addFieldToTab('Root.Main', $field, 'Email');

		$field = new TextField('DDI','DDI');
		$fields->addFieldToTab('Root.Main',$field,'Email');


	}
}