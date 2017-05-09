<?php

class Project extends Page
{

    private static $icon = 'mysite/icons/project.png';

    private static $hide_ancestor = 'Page';

    private static $allowed_children = array('*RoyalSocContent','FormPage','*OnlineDocument','Project','MedalAward','FundOpportunity', 'MedalSearch', 'FundSearch','Panel','Members','OffSiteLink','SocioEconomicCalculator','FieldResearchCalculator','StaffPage');

    private static $db = array(
        'Blurb' => 'VarChar(255)'
    );

    private static $has_one = array(
        'HeroImage' => 'Image'
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeFieldFromTab('Root.Main', 'Content');

        $fields->addFieldToTab('Root.Main', TextField::create('Blurb'), 'Metadata');

        $config = GridFieldConfig_RelationEditor::create();

        $config->removeComponentsByType('GridFieldEditButton');
        $config->removeComponentsByType('GridFieldDeleteAction');
        $config->removeComponentsByType('GridFieldAddNewButton');
        $config->addComponent(new GridFieldTagDeleteAction());

        $field = GridField::create('Tags', 'Tags', $this->Tags(), $config);
        $fields->addFieldToTab('Root.Main', $field, 'Metadata');

        $fields->addFieldToTab(
            'Root.Main',
            $uploadField = new UploadField(
                $name = 'HeroImage',
                $title = 'Hero Image : Upload a single high resolution image'
            ),
            'Metadata'
        );

        $uploadField->setAllowedFileCategories('image');
        $uploadField->setAllowedMaxFileNumber(1);
        $uploadField->setFolderName('ProjectHeroImages');

        return $fields;
    }

    // on creation create first tag and add it to the project
    protected function onBeforeWrite()
    {
        parent::onBeforeWrite();

        $defaultTag = strtolower(preg_replace('/-/', ' ', $this->URLSegment));
        Page::TagChecking($defaultTag, get_class());

    }

    public function onBeforeDelete()
    {
        parent::onBeforeDelete();

        $defaultTag = strtolower(preg_replace('/-/',' ',$this->URLSegment));
        $tags = $this->Tags()->filter(array('Tag'=>$defaultTag));
        foreach($tags as $tag)
        {
            $ID = $tag->ID;
            DB::prepared_query('DELETE FROM "Page_Tags" WHERE "Page_Tags"."CoreTagID" = ?', array($ID));
            $tag->delete();
        }

        $promoteTag = 'promote:'.$defaultTag;
        $checkTag = CoreTag::get()->filter(array('Tag'=>$promoteTag))->first();
        if($checkTag)
        {
            $checkTag->delete();
        }



    }

}
class Project_Controller extends Page_Controller
{

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
    private static $allowed_actions = array();

    public function init()
    {
        parent::init();
        // You can include any CSS or JS required by your project here.
        // See: http://doc.silverstripe.org/framework/en/reference/requirements
    }

    public function PromoteContentID()
    {
        $promoteID = null;
        $searchTag = 'promote:' . str_replace('-', ' ', $this->URLSegment);

        $pages = Page::get();
        foreach ($pages as $page) {
            $tags = $page->Tags();
            foreach ($tags as $tag) {
                if ($tag->Tag == $searchTag)
                {
                    $promoteID = $page->ID;
                    break;
                }
            }
            if ($promoteID)
            {
                break;
            }
        }

        if($promoteID == NULL){
            $AssociatedPages = new ArrayList();
            $AssociatedContent = new ArrayList();
            foreach(Page::get()->filter(array('ParentID'=>$this->ID)) as $obj)
            {
                if($obj->getClassName() == 'Event')
                {
                    if(strtotime($obj->End) > time())
                    {
                        $obj->LastEdited = $obj->Start;
                        $AssociatedPages->push($obj);
                    }
                } 
                else
                {
                   $AssociatedPages->push($obj);
                }
            }
            $ContainerTag = $this->Tags()->filter(array('IsFixed'=>true))->first();
            foreach($ContainerTag->Pages()->exclude('ID',$this->ID) as $obj)
            {
                 $AssociatedPages->push($obj);
            }

            $promoteID = $AssociatedPages->sort(array('LastEdited'=>'DESC'))->first()->ID;

        }

        return $promoteID;
    }

    public function PromoteContent()
    {
        $page = Page::get()->byID($this->PromoteContentID());
        if($page)
        {
            if(!empty($page->Blurb))
            {
                $Text = strip_tags($page->Blurb);
            } 
            else
            {
                $Text = strip_tags($page->Intro);
            }

           if($page->getClassName() == 'OffSiteLink')
            {
                $Link = $page->OffSiteLink;
                $OffSite = 'target="_blank"';
            }
            else
            {
                $Link = $page->Link();
                $OffSite = '';
            }

            $data = ArrayData::create(array(
                'Title' => $page->Title,
                'Text' => $Text,
                'Image' => $page->FindHeroImage('Image'),
                'Link' => $Link,
                'OffSite' => $OffSite
            ));
            return $data;
        }
    }

    public function AssociatedContent()
    {
        $AssociatedPages = new ArrayList();
        $AssociatedContent = new ArrayList();
        $PromoteID = $this->PromoteContentID();
        foreach(Page::get()->filter(array('ParentID'=>$this->ID))->exclude('ID', $PromoteID) as $obj)
        {
            if($obj->getClassName() == 'Event')
            {
                if(strtotime($obj->End) > time())
                {
                    $obj->LastEdited = $obj->Start;
                    $AssociatedPages->push($obj);
                }
            } 
            else
            {
               $AssociatedPages->push($obj);
            }

        }
        $ContainerTag = $this->Tags()->filter(array('IsFixed'=>true))->first();
        foreach($ContainerTag->Pages()->exclude('ID',$this->ID) as $obj)
        {
            if($obj->ID != $PromoteID)
            {
                if($obj->getClassName() == 'Event')
                {
                    if(strtotime($obj->End) > time())
                    {
                        $obj->LastEdited = $obj->Start;
                        $AssociatedPages->push($obj);
                    }
                } 
                else
                {
                   $AssociatedPages->push($obj);
                }
            }
        }

        foreach($AssociatedPages->sort(array('LastEdited'=>'DESC')) as $obj)
        {
            if(!empty($obj->Blurb))
            {
                $Text = strip_tags($obj->Blurb);
            } 
            else
            {
                $Text = strip_tags($obj->Intro);
            }

            if($obj->getClassName() == 'OffSiteLink')
            {
                $Link = $obj->OffSiteLink;
                $OffSite = 'target="_blank"';
            }
            else
            {
                $Link = $obj->Link();
                $OffSite = '';
            }

            $Text = $this->ClipText($obj->Title, $Text);

            $data = ArrayData::create(array(
                'Title' => $obj->Title,
                'Text' => $Text,
                'Image' => $obj->FindHeroImage(),
                'Link' => $Link,
                'OffSite' => $OffSite
            ));

            $AssociatedContent->push($data);
        }
        return $AssociatedContent;
    }

}
