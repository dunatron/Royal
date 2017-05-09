<?php
class OffSiteLink extends RoyalSocContent {

	private static $can_be_root = false;


	private static $singular_name = 'Off Site Link';
	private static $plural_name = 'Off Site Links';

	private static $icon = 'mysite/icons/offsite.png';

	private static $db = array(
		'OffSiteURL' => 'Varchar(255)'
	);

	private static $has_one = array(
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		//$fields->removeFieldFromTab('Root.Main', 'RoyalSocContent');

		$fields->removeFieldFromTab('Root.Main', 'ShowQuotes');
		$fields->removeFieldFromTab('Root.Main', 'Intro');
		$fields->removeFieldFromTab('Root.Main', 'Content');

		$fields->removeFieldFromTab('Root','RelatedContent');
		$fields->removeFieldFromTab('Root','RelatedDocuments');
		$fields->removeFieldFromTab('Root','RelatedMedia');

		$field = new TextField('OffSiteURL', 'Off Site Link : (please include https:// or http://');
		$fields->addFieldToTab('Root.Main',$field,'Metadata');

		return $fields;
	}

	// public function Link()
	// {
	// 	if(is_subclass_of(Controller::curr(),'LeftAndMain'))
	// 	{
	// 		return parent::Link();		
	// 	}
	// 	else
	// 	{
	// 		return $this->OffSiteLink;
	// 	}
	// }

}
class OffSiteLink_Controller extends RoyalSocContent_Controller {

	/**
	 * An array of actions that can be accessed via a request. Each array element should be an action name, and the
	 * permissions or conditions required to allow the user to access it.
	 *
	 * <code>
	 * array (
	 *     'action', // anyone can access this action
	 *     'action' => true, // same as above
	 *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
	 *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
	 * );
	 * </code>
	 *
	 * @var array
	 */
	private static $allowed_actions = array (
	);

	public function init() {
		parent::init();
		// You can include any CSS or JS required by your project here.
		// See: http://doc.silverstripe.org/framework/en/reference/requirements
	}

}