<?php
class NewsPanel extends Panel {

	private static $allowed_children = array('News');	

	public function canDelete()
	{
		return false;
	}

}
class NewsPanel_Controller extends Panel_Controller {

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
	    'doCreateNewsItem',
        'CreateNewsItemForm'
	);

	public function init() {
		parent::init();
		// You can include any CSS or JS required by your project here.
		// See: http://doc.silverstripe.org/framework/en/reference/requirements
        Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/add-news-item.js');
	}

    public function CreateNewsItemForm()
    {
        $NewsTitle  = TextField::create('Title', 'News Title')->addExtraClass('required-field');
        $LinkOne    = TextField::create('LinkOne', 'Link One');
        $LinkTwo    = TextField::create('LinkTwo', 'Link Two');
        $Content = HtmlEditorField::create('Content', 'Description')->addExtraClass('required-field');

        $fields = FieldList::create(
            $NewsTitle, $LinkOne, $LinkTwo, $Content
        );

        $actions = FieldList::create(
            FormAction::create('doCreateNewsItem', 'Submit')->addExtraClass('FormClass')
                ->setUseButtonTag(true)->addExtraClass('button')
        );

        $required = new RequiredFields(array(
            'Title', 'Content'
        ));

        $form = Form::create($this, 'CreateNewsItemForm', $fields, $actions, $required);
        $form->setTemplate('CustomEventForm');
        $form->setAttribute('novalidate', '');

        //return $form;
        $data = Session::get("FormData.{$form->getName()}.data");
        return $data ? $form->loadDataFrom($data) : $form;
    }

    public function doCreateNewsItem($data, $form)
    {
        Session::set("FormData.{$form->getName()}.data", $data);

        $linkOne = $data['LinkOne'];
        $linkTwo = $data['LinkTwo'];

        $NewsItem = News::create();

        $NewsItem->Title = $data['Title'];

        $NewsItem->Content = $data['Content']
            .'<p><a href="'.$linkOne.'">'.$linkOne.'</a></p>'
            .'<p><a href="'.$linkTwo.'">'.$linkTwo.'</a></p>';

        $newsHolderPage = Page::get()->filter(array(
            'URLSegment'    =>  'news'
        ));

        $newsHolderPageID = $newsHolderPage->first();
        $NewsItem->ParentID = $newsHolderPageID->ID;

        $NewsItem->writeToStage('Stage');

        $form->sessionMessage('Thanks for your news submission!','good');

        $config = SiteConfig::current_site_config();
        if($config->EventNotificationEmail > '')
        {
            $this->sendEmailToAdminFromSystem($config->NewsNotificationEmail, $NewsItem->Title, "News");
        }

        Session::clear("FormData.{$form->getName()}.data");

        return $this->redirectBack();
    }

}