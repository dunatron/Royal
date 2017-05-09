<?php

class Media extends DataObject
{
	private static $db = array(
		'Title' => 'VarChar(255)',
		'Transcript' => 'HTMLText',
		'URL' => 'Text'
	);


	private static $belongs_many_many = array(
		'RoyalSocContent' => 'RoyalSocContent'
	);

	private static $summary_fields = array(
		'Title' => 'Title',
		'URL' => 'URL'
	);

	public function getCMSValidator() {
		return new RequiredFields(array('Title','URL'));
	}

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->removeFieldFromTab('Root','RoyalSocContent');

		// $fields->addFieldToTab('Root.Main', $mediafile = UploadField::create('MediaFile','Media File'));
		// $mediafile->setFolderName('media');

		$field = new TextareaField('URL','Embed code from hosting site');
		$fields->addFieldToTab('Root.Main',$field);

		return $fields;
	}

	public function Link()
	{
		return '/media/show/'.$this->ID;
	}

	public function LinkingMode()
	{
		return Controller::curr()->getRequest()->param('ID') == $this->ID ? 'current' : 'link';
	}

	public function Embed()
	{
		$url = $this->URL;
		return $url;
	}

}

class Media_Controller extends Page_Controller 
{

	private static $allowed_actions = array('show');

	public function show(SS_HTTPRequest $request)
	{
		$media = Media::get()->byID($request->param('ID'));

		if(!$media)
		{
			return $this->httpError(404, 'That media could not be found');
		}

		//return $media->renderWith('Media');
        return $this->owner->customise($media)->renderWith('Media');
	}
}

