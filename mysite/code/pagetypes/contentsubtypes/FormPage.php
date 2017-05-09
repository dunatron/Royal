<?php
class FormPage extends RoyalSocContent {

	private static $can_be_root = false;


	private static $singular_name = 'Form Page';
	private static $plural_name = 'Form Pages';

	private static $icon = 'mysite/icons/formpage.png';

	private static $db = array(
		'ContentBeforeForm' => 'HTMLText',
		'ContentAfterForm' => 'HTMLText',
		'SelectedForm' => 'Varchar(255)'
	);

	private static $has_one = array(
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->removeFieldFromTab('Root.Main', 'Content');
		//$fields->removeFieldFromTab('Root.Main', 'HeroPage');

		$fields->addFieldToTab('Root.Main', HtmlEditorField::create('ContentBeforeForm', 'Content Before Form'), 'Metadata');
		$fields->addFieldToTab('Root.Main', DropdownField::create('SelectedForm','Select Form',
			array(
				'none'=>'Select a form to add to this page',
				//'ContactForm' => 'Contact Form',
				'HireForm' => 'Hire Form',
				//'DonateForm' => 'Donate Form',
				'MembershipForm' => 'Membership Form'


			)
		),
		'Metadata');
		$fields->addFieldToTab('Root.Main', HtmlEditorField::create('ContentAfterForm', 'Content After Form'), 'Metadata');

		return $fields;
	}

}
class FormPage_Controller extends RoyalSocContent_Controller {

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
		'FormPageForm'
	);

	public function init() {
		parent::init();
		// You can include any CSS or JS required by your project here.
		// See: http://doc.silverstripe.org/framework/en/reference/requirements
	}

	public function FormPageForm()
	{

		if($this->SelectedForm > '')
		{
			switch($this->SelectedForm)
			{
				case 'ContactForm':
					return $this->ContactForm();
					break;

				case 'HireForm':
					return $this->HireForm();
					break;

				case 'DonateForm':
					return $this->DonateForm();
					break;

				case 'MembershipForm':
					return $this->MembershipForm();
					break;
			}
		}
	}

}