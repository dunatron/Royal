<?php
class DocumentParagraph extends OnlineDocument {

	private static $can_be_root = false;


	private static $singular_name = 'Online Document - Paragraph';
	private static $plural_name = 'Online Document - Parargaphs';

	private static $icon = 'mysite/icons/docpara.png';

	private static $db = array(
	);

	private static $has_one = array(
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->removeFieldFromTab('Root.Main','Tags');
		$fields->removeFieldFromTab('Root','RelatedContent');
		$fields->removeFieldFromTab('Root','RelatedDocuments');
		$fields->removeFieldFromTab('Root','RelatedMedia');
		$fields->removeFieldFromTab('Root','FreeTags');

		$fields->removeFieldFromTab('Root','RelatedContent');

		$fields->removeFieldFromTab('Root.Main','Intro');

		$fields->removeFieldFromTab('Root.Main','ShowQuotes');

		$fields->removeFieldFromTab('Root.Main','NoNumbering');

		$fields->removeFieldFromTab('Root.Main','CollapsedTOC');

		$fields->addFieldToTab('Root.Main', HtmlEditorField::create('Content'), 'Metadata');

		return $fields;
	}

}
class DocumentParagraph_Controller extends OnlineDocument_Controller {

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

	public function Content()
	{
		// find parent Online Doc then redirect to it
		$OnlineDocID = $this->GetOnlineID($this->ParentID);
		$OnlineDocument = Page::get()->byID($OnlineDocID);
		$this->redirect($OnlineDocument->Link().'#'.$this->ID);
	}

	private function GetOnlineID($ParentID)
	{
		$ParentPage = Page::get()->byID($ParentID);
		if($ParentPage->getClassName() == 'OnlineDocument')
		{
			return $ParentID;
		}
		else
		{
			return $this->GetOnlineID($ParentPage->ParentID);
		}
	}

}