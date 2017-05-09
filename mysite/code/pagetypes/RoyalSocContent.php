<?php
class RoyalSocContent extends Page {

	private static $icon = 'mysite/icons/royalsoccontent.png';

	private static $singular_name = 'RSNZ Content';
	private static $plural_name = 'RSNZ Content';

	private static $hide_ancestor = 'Page';

	//private static $can_be_root = false;

	private static $allowed_children = array('*RoyalSocContent','FormPage','*OnlineDocument','Project','MedalAward','FundOpportunity', 'MedalSearch', 'FundSearch','Panel','Members','OffSiteLink','SocioEconomicCalculator','FieldResearchCalculator','StaffPage');

	private static $db = array(
		'ShowQuotes' => 'Boolean',
		'Intro' => 'Text',
		'RelatedContentLabel' => 'VarChar(255)'
	);

	private static $has_one = array(
		'HeroImage' => 'Image'
	);

	private static $has_many = array(
		'FreeTags' => 'FreeTag'
	);

	private static $many_many = array(
		'Related' => 'Page',
		'Media' => 'Media',
		'Documents' => 'File'
	);

	// private static $many_many_extraFields = array(
	// 	'Tags' => array(
	// 		'IsFixed' => 'Boolean(false)'
	// 	)
	// );

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$config = GridFieldConfig_RelationEditor::create();
		
		$config->removeComponentsByType('GridFieldEditButton');
		$config->removeComponentsByType('GridFieldDeleteAction');
		$config->removeComponentsByType('GridFieldAddNewButton');
		$config->addComponent(new GridFieldTagDeleteAction());
		$field = GridField::create('Tags', 'Tags', $this->Tags(), $config);
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		$fields->addFieldToTab(
			'Root.Main', 
			$uploadField = new UploadField(
				$name = 'HeroImage', 
				$title = 'Hero Image : Upload a single high resolution image'
			),
			'Content' 
		);
		$uploadField->setAllowedFileCategories('image');
		$uploadField->setAllowedMaxFileNumber(1);
		$uploadField->setFolderName('ContentHeroImages');

		$fields->addFieldToTab('Root.FreeTags', GridField::create(
			'FreeTags', 'Free Tags', $this->FreeTags(), GridFieldConfig_RecordEditor::create()
		));

		$config = GridFieldConfig_RelationEditor::create();
		$config->removeComponentsByType('GridFieldEditButton');
		$config->removeComponentsByType('GridFieldAddNewButton');
		$field = GridField::create('Related', 'Related Content', $this->Related(), $config);
		$fields->addFieldToTab('Root.RelatedContent', $field);

		$field = new CheckboxField('ShowQuotes','Show Quote Box');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		$field = new UploadField('Documents','Documents',$this->Documents());
		$field->setFolderName('documents');
		$fields->addFieldToTab('Root.RelatedDocuments', $field);

		$field = new TextareaField('Intro','Introduction');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		$fields->addFieldToTab('Root.RelatedMedia', GridField::create(
			'Media','Media', $this->Media(), GridFieldConfig_RelationEditor::create()
		));

		$field = new TextField('RelatedContentLabel','Related Content Label');
		$fields->addFieldToTab('Root.RelatedContent', $field, 'Related');

		return $fields;
	}

	// on creation create first tag from parent main tag
	protected function onBeforeWrite() {	
		parent::onBeforeWrite();

		$nonTagged = array(
			'DocumentSection',
			'DocumentParagraph',
			'MicroSite'
		);

		if(!in_array(get_class($this),$nonTagged))
		{
			if($this->ParentID == 0)
			{
				Page::TagChecking(null, get_class($this));
			}
			else
			{
				$ParentFixedTag = $this->Parent()->Tags()->filter(array('IsFixed'=>1))->column('Tag')[0];
				Page::TagChecking($ParentFixedTag, get_class($this));
			}

		}
	}

}
class RoyalSocContent_Controller extends Page_Controller {

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

	public function RelatedPageData()
    {
    	$related = new ArrayList();
        $pages = $this->Related();
        foreach($this->Related() as $page)
        {
        	if($page->getClassName() == 'OffSiteLink')
            {
                $Link = $page->OffSiteURL;
                $OffSite = 'target="_blank"';
            }
            else
            {
                $Link = $page->Link();
                $OffSite = '';
            }

        	$data = ArrayData::create(array(
        		'Title' => $page->Title,
        		'Link' => $Link,
        		'OffSite' => $OffSite
        	));
        	$related->push($data);
        }
        foreach($this->Documents() as $document)
        {
        	$data = ArrayData::create(array(
        		'Title' => $document->Title,
        		'Link' => $document->Link()
        	));
        	$related->push($data);	
        }
        foreach($this->Media() as $media)
        {
        	$data = ArrayData::create(array(
        		'Title' => $media->Title,
        		'Link' => $media->Link()
        	));
        	$related->push($data);
        }
        return $related;
    }

    public function QuoteGenerator()
    {
    	$quotes = Quotes::get()->sort('RAND()')->limit(1);

    	return $quotes;
    }

    public function ChildPages()
    {
    	$pages = Page::get()->filter(array('ParentID'=>$this->ID));
    	return $pages;
    }

}