<?php
class ResearchPanel extends Panel {

	private static $allowed_children = array('Research');

	public function canDelete()
	{
		return false;
	}

}

class ResearchPanel_Controller extends Panel_Controller {

    private static $allowed_actions = array (
        'CreateResearchItemForm',
        'doCreateResearchItem'
    );

	public function init() {
		parent::init();
		// You can include any CSS or JS required by your project here.
		// See: http://doc.silverstripe.org/framework/en/reference/requirements
        Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/add-research-item.js');
	}

    public function CreateResearchItemForm()
    {
        $ResearchTitle  = TextField::create('Title', 'Research Title')->addExtraClass('required-field');
        $ResearchName  = TextField::create('ResearcherName', 'Researcher Name')->addExtraClass('required-field');
        $EmailAddress = EmailField::create('ResearcherEmail', 'Researcher Email')->addExtraClass('required-field');
        $ResearcherOrganisation = TextField::create('ResearcherOrganisation', 'Researcher Organisation');
        $LinkOneTitle = TextField::create('ExternalLink1Title', 'Link 1 Title');
        $LinkOne    = TextField::create('ExternalLink1', 'Link 1');
        $LinkTwoTitle = TextField::create('ExternalLink2Title', 'Link 2 Title');
        $LinkTwo    = TextField::create('ExternalLink2', 'Link 2');
        $Intro  = TextField::create('Intro', 'Introduction');
        $Content = HtmlEditorField::create('Content', 'Description')->addExtraClass('required-field');

        $fields = FieldList::create(
            $ResearchTitle, $ResearchName, $EmailAddress, $ResearcherOrganisation, $LinkOneTitle, $LinkOne,
            $LinkTwoTitle, $LinkTwo, $Intro, $Content
        );

        $actions = FieldList::create(
            FormAction::create('doCreateResearchItem', 'Submit Research')->addExtraClass('FormClass')
                ->setUseButtonTag(true)->addExtraClass('button')
        );

        $required = new RequiredFields(array(
            'Title', 'Content', 'ResearcherEmail', 'ResearcherName'
        ));

        $form = Form::create($this, 'CreateResearchItemForm', $fields, $actions, $required);
        $form->setTemplate('CustomEventForm');
        $form->setAttribute('novalidate', '');

        //return $form;
        $data = Session::get("FormData.{$form->getName()}.data");
        return $data ? $form->loadDataFrom($data) : $form;
    }

    public function doCreateResearchItem($data, $form)
    {
        Session::set("FormData.{$form->getName()}.data", $data);

        $ResearchItem = Research::create();

        $form->saveInto($ResearchItem);

        $researchHolderPage = Page::get()->filter(array(
            'URLSegment'    =>  'research'
        ));

        $researchHolderPageID = $researchHolderPage->first();
        $ResearchItem->ParentID = $researchHolderPageID->ID;

        $ResearchItem->writeToStage('Stage');

        $form->sessionMessage('Thanks for your Research submission!','good');

        $config = SiteConfig::current_site_config();
        if($config->ResearchNotificationEmail > '')
        {
            $this->sendEmailToAdminFromSystem($config->ResearchNotificationEmail, $ResearchItem->Title, "Research");
        }

        Session::clear("FormData.{$form->getName()}.data");

        return $this->redirectBack();
    }

}