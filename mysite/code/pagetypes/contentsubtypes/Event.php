<?php

class Event extends RoyalSocContent
{

	private static $can_be_root = false;


	private static $singular_name = 'Event';
	private static $plural_name = 'Events';

	//private static $hide_ancestor = 'EventPanel';

	private static $icon = 'mysite/icons/event.png';

	private static $db = array(
		'FullName' => 'VarChar(255)',
		'Email' => 'VarChar(255)',
		'Organisation' => 'VarChar(255)',
		'Link' => 'VarChar(255)',
        'RSVPEmail' => 'VarChar(255)',
        'InfoURL' => 'VarChar(255)',
		'Topic' => 'VarChar(255)',
		'SpeakerType' => 'Enum("Keynote, Guest","Guest")',
		'SpeakerName' => 'VarChar(255)',
		'SpeakerTitle' => 'VarChar(255)',
		'Source' => 'Enum("FE,CMS,EventBrite,EventFinda","CMS")',
		'SourceID' => 'VarChar(255)',
		'RawData' => 'Text',
		'UpdateData' => 'Text',
        'Location' => 'Text',
        'Start' => 'SS_Datetime',
        'End' => 'SS_Datetime',
        'EditedDescription' => 'HTMLText'
	);

	private static $has_one = array(
		'HeroImage' => 'Image',
		'SpeakerImage' => 'Image',
        'Region' => 'Region'
	);

	private static $has_many = array(
		'Locations' => 'Location'
	);


    public function BookingURL()
    {
        if($this->Link)
        {   
            return 'href="'.$this->Link.'"';
        }
        else if($this->RSVPEmail)
        {
            return 'href="mailto:'.$this->RSVPEmail.'"';
        }
        else
        {
            return null;
        }
    }

    private function nl2p($string) {

        foreach (explode("\n", $string) as $line) {
            if (trim($line)) {
                $paragraphs .= '<p>' . $line . '</p>';
            }
        }

        return $paragraphs; 
    }


    public function FormattedContent()
    {
        if($this->EditedDescription > '')
        {
            $output = $this->EditedDescription;
        }
        else
        {
            if($this->Source == 'EventFinda')
            {
                $output = $this->nl2p($this->Content);
            }
            else
            {
                $output = $this->Content;
            }
        }
        return $output;
    }

	public function getCMSFields()
	{

		 $fields = parent::getCMSFields();

        $fields->removeFieldFromTab('Root.Main', 'Content');
        $fields->removeFieldFromTab('Root.Main', 'HeroImage');
        $fields->removeFieldFromTab('Root.Main', 'ShowQuotes');

        // Title
        if (!empty($this->Title) && $this->SourceID != NULL) {
            $field = new ReadonlyField('Title', 'Event name');
            $fields->addFieldToTab('Root.Main', $field, 'URLSegment');
        } else {
            $field = new TextField('Title', 'Event name');
            $fields->addFieldToTab('Root.Main', $field, 'URLSegment');
        }

        if (!empty($this->FullName) && $this->SourceID != Null) {

            $field = new ReadonlyField('FullName', 'Event Submitter');
            $fields->addFieldToTab('Root.Main', $field, 'Metadata');
        } else {
            $field = new Textfield('FullName', 'Event Submitter');
            $fields->addFieldToTab('Root.Main', $field, 'Metadata');
        }


        $field = new EmailField('Email', 'Event Submitter Email');
        $fields->addFieldToTab('Root.Main', $field, 'Metadata');


        if (!empty($this->Organisation) && $this->SourceID != Null) {
            $field = new ReadonlyField('Organisation', 'Event Host Organisation');
            $fields->addFieldToTab('Root.Main', $field, 'Metadata');
        } else {
            $field = new Textfield('Organisation', 'Event Host Organisation');
            $fields->addFieldToTab('Root.Main', $field, 'Metadata');
        }

        $HeroUploadField = new UploadField(
            $name = 'HeroImage',
            $title = 'Hero Image : Upload a single high resolution image'
        );
        $HeroUploadField->setAllowedFileCategories('image');
        $HeroUploadField->setAllowedMaxFileNumber(1);
        $HeroUploadField->setFolderName('EventHeroImages');
        $fields->addFieldToTab('Root.Main', $HeroUploadField, 'Metadata');

        if (!empty($this->Link) && $this->SourceID != Null) {
            $field = new ReadonlyField('Link', 'Booking Link (will override RSVP Email for \'Booking\' button, please include https:// or http://)');
            $fields->addFieldToTab('Root.Main', $field, 'Metadata');
        } else {
            $field = new Textfield('Link', 'Booking Link (will override RSVP Email for \'Booking\' button, please include https:// or http://)');
            $fields->addFieldToTab('Root.Main', $field, 'Metadata');
        }


        $field = new TextField('RSVPEmail', 'RSVP Email');
        $fields->addFieldToTab('Root.Main', $field, 'Metadata');


        $field = new TextField('InfoURL', 'More Information URL (please include https:// or http://)');
        $fields->addFieldToTab('Root.Main', $field, 'Metadata');


        if (!empty($this->Content) && $this->SourceID != Null) {
            $field = new ReadonlyField('Content', 'Description');
            $fields->addFieldToTab('Root.Main', $field, 'Metadata');
        } else {
            $field = new HTMLEditorField('Content', 'Description');
            $fields->addFieldToTab('Root.Main', $field, 'Metadata');
        }
        $field = new HTMLEditorField('EditedDescription','Edited Description');
        $fields->addFieldToTab('Root.Main', $field, 'Metadata');

        $SpeakerUploadField = new UploadField(
            $name = 'SpeakerImage',
            $title = 'Speaker Image'
        );
        $SpeakerUploadField->setAllowedFileCategories('image');
        $SpeakerUploadField->setAllowedMaxFileNumber(1);
        $SpeakerUploadField->setFolderName('SpeakerImages');
        $fields->addFieldToTab('Root.Main', $SpeakerUploadField, 'Metadata');



        $field = new Textfield('SpeakerName', 'Speaker Name');
        $fields->addFieldToTab('Root.Main', $field, 'Metadata');


        $field = new TextField('SpeakerTitle', 'Speaker Title');
        $fields->addFieldToTab('Root.Main', $field, 'Metadata');

        if (!empty($this->Location) && $this->SourceID != Null) {
            $field = new ReadonlyField('Location', 'Location');
            $fields->addFieldToTab('Root.Main', $field, 'Metadata');
        } else {
            $field = new TextareaField('Location', 'Location');
            $fields->addFieldToTab('Root.Main', $field, 'Metadata');
        }

        if (!empty($this->Start) && $this->SourceID != Null) {
            $field = new ReadonlyField('Start', 'Event Start Time');
            $fields->addFieldToTab('Root.Main', $field, 'Metadata');
        } else {
            $field = DatetimeField::create('Start', 'Event Start Time')->setConfig('calendar', true);
            $field->getTimeField()->setConfig('use_strtotime', true);
            $fields->addFieldToTab('Root.Main', $field, 'Metadata');
        }

        if (!empty($this->End) && $this->SourceID != Null) {
            $field = new ReadonlyField('End', 'Event Finish Time');
            $fields->addFieldToTab('Root.Main', $field, 'Metadata');
        } else {
            $field = DatetimeField::create('End', 'Event Finish Time')->setConfig('calendar', true);
            $field->getTimeField()->setConfig('use_strtotime', true);
            $fields->addFieldToTab('Root.Main', $field, 'Metadata');
        }

        $fields->addFieldToTab('Root.Main', new DropdownField(
            'RegionID',
            'Choose A Region',
            Region::get()->map('ID', 'Region')->toArray(),
            null,
            true
        ),'Metadata');

        if ($this->Source == 'FE') {
            $fields->addFieldToTab('Root.Main', ReadonlyField::create('RawData', 'Raw Data'), 'Metadata');
            $fields->addFieldToTab('Root.Main', ReadonlyField::create('UpdateData', 'Update Data'), 'Metadata');
        }
        if ($this->Source == 'EventFinda' || $this->Source == 'EventBrite') {
            $fields->addFieldToTab('Root.Main', ReadonlyField::create('Source', 'Source'), 'Metadata');
        }

        return $fields;
	}

    protected function onBeforeWrite()
    {
        parent::onBeforeWrite();

        $parts = explode(' ', $this->End);
        if($parts[1] == '00:00:00')
        {
            $this->End = $parts[0].' 23:59:59';
        }

    }

    public function onAfterWrite()
    {
        $NextEventDate = $this->NextDate();
        if ($NextEventDate > 0) {
            $table_name = ClassInfo::baseDataClass($this->owner->ClassName);
            DB::query('UPDATE ' . $table_name . " SET LastEdited = '" . Convert::raw2sql($NextEventDate) . "'  WHERE ID = " . intval($this->owner->ID) . ' LIMIT 1');
        }
    }

    public function onAfterPublish()
    {
        $NextEventDate = $this->NextDate();
        if ($NextEventDate > 0) {
            $table_name = ClassInfo::baseDataClass($this->owner->ClassName);
            DB::query('UPDATE ' . $table_name . "_Live SET LastEdited = '" . Convert::raw2sql($NextEventDate) . "'  WHERE ID = " . intval($this->owner->ID) . ' LIMIT 1');
        }
    }

    private function NextDate()
    {
        $today = date('Y-m-d', time());
//        foreach ($this->Locations()->sort('Start', 'ASC') as $Location) {
//            $EventDate = date('Y-m-d', strtotime($Location->Start));
//            if ($EventDate >= $today) {
//                return $EventDate;
//            }
//        }
        $EventDate = date('Y-m-d', strtotime($this->Start));
        if ($EventDate >= $today) {
            return $EventDate;
        }
    }

}

class Event_Controller extends RoyalSocContent_Controller
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

}

//class Location extends DataObject
//{
//    private static $db = array(
//        'Location' => 'Text',
//        'Start' => 'SS_Datetime',
//        'End' => 'SS_Datetime'
//    );
//
//    private static $has_one = array(
//        'Event' => 'Event',
//        'Region' => 'Region'
//    );
//
//    public function getTitle()
//    {
//        //return Region::get()->byID($this->RegionID)->Title;
//        return $this->Location;
//    }
//
//    public function getName()
//    {
//        //return Region::get()->byID($this->RegionID)->Title;
//        return $this->Location;
//    }
//
//    public function getCMSFields()
//    {
//        $fields = parent::getCMSFields();
//
//        return $fields;
//    }
//
//    public function onAfterWrite()
//    {
//        // set parent Event to draft
//        $Event = Event::get()->byID($this->EventID);
//        $Event->deleteFromStage('Live');
//    }
//
//
//}

class Region extends DataObject
{
    private static $db = array(
        'Region' => 'VarChar(255)'
    );

    private static $has_many = array(
        'Events' => 'Event'
    );

    private static $summary_fields = array(
        'Region' => 'Region'
    );

    public function getTitle()
    {
        return $this->Region;
    }

    public function getName()
    {
        return $this->Region;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
//        $fields->removeFieldFromTab('Root', 'Locations');
        return $fields;
    }

}