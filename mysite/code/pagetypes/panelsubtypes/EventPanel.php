<?php
class EventPanel extends Panel {

	private static $allowed_children = array('Event');	

	public function canDelete()
	{
		return false;
	}

}
class EventPanel_Controller extends Panel_Controller {

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
        Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/createFrontEndEvent.js');
	}

	public function getRegions()
    {
        $regions = Region::get();
        return $regions;
    }

    public function eventFilterDates()
    {
        $dateArr = ArrayList::create();

        for ($count = 0; $count <= 12; $count++) {
            $d = new DataObject();
            $d->Date = date('F-Y', strtotime(date('F-Y')." +".$count." month"));
            $dateArr->add($d);
        }

        return $dateArr;
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

        if($this->getClassName() == 'EventPanel' || $this->getClassName() == 'NewsPanel')
        {
            $Sort = 'LastEdited';
        }
        else
        {
            $Sort = 'Sort';
        }

        if($this->getClassName() == 'NewsPanel')
        {
            $Order = 'DESC';
        }
        else
        {
            $Order = 'ASC';
        }

        foreach($AssociatedPages->sort(array($Sort=>$Order)) as $obj)
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

                $Link = $obj->OffSiteURL;
                $OffSite = 'target="_blank"';
            }
            else
            {
                $Link = $obj->Link();
                $OffSite = '';
            }

            $Text = $this->ClipText($obj->Title, $Text);

            error_log($obj->End);
            $dateStringConvert = strtotime($obj->End);
            $dateAttr = date('F-Y', $dateStringConvert);

            $data = ArrayData::create(array(
                'Title' => $obj->Title,
                'Text' => $Text,
                'Region' => $obj->Region(),
                'EndDate' => $dateAttr,
                'Image' => $obj->FindHeroImage(),
                'Link' => $Link,
                'OffSite' => $OffSite
            ));

            $AssociatedContent->push($data);
        }
        return $AssociatedContent;
    }

}