<?php
class News extends RoyalSocContent {


	private static $icon = 'mysite/icons/news.png';

	private static $singular_name = 'News';
	private static $plural_name = 'News';

	//private static $hide_ancestor = 'NewsPanel';

	private static $can_be_root = false;

	private static $db = array(
		'PublishedDate' => 'SS_Datetime'
	);

	//private static $allowed_children = 'none';

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		// $config = GridFieldConfig_RelationEditor::create();
		
		// $config->removeComponentsByType('GridFieldEditButton');
		// $config->removeComponentsByType('GridFieldDeleteAction');
		// $config->removeComponentsByType('GridFieldAddNewButton');
		// $config->addComponent(new GridFieldTagDeleteAction());
		// $field = GridField::create('Tags', 'Tags', $this->Tags(), $config);
		// $fields->addFieldToTab('Root.Main', $field, 'Content');

		// $fields->addFieldToTab(
		// 	'Root.Main', 
		// 	$uploadField = new UploadField(
		// 		$name = 'HeroImage', 
		// 		$title = 'Hero Image : Upload a single high resolution image'
		// 	),
		// 	'Content' 
		// );
		// $uploadField->setAllowedFileCategories('image');
		// $uploadField->setAllowedMaxFileNumber(1);
		// $uploadField->setFolderName('ContentHeroImages');

		// $config = GridFieldConfig_RelationEditor::create();
		// $config->removeComponentsByType('GridFieldEditButton');
		// $config->removeComponentsByType('GridFieldAddNewButton');
		// $field = GridField::create('Related', 'Related Content', $this->Related(), $config);
		// $fields->addFieldToTab('Root.RelatedContent', $field);

		// $fields->addFieldToTab('Root.FreeTags', GridField::create(
		// 	'FreeTags', 'Free Tags', $this->FreeTags(), GridFieldConfig_RecordEditor::create()
		// ));

		// $field = new CheckboxField('ShowQuotes','Show Quote Box');
		// $fields->addFieldToTab('Root.Main', $field, 'Content');

		// $field = new UploadField('Documents','Documents',$this->Documents());
		// $field->setFolderName('documents');
		// $fields->addFieldToTab('Root.Documents', $field);

		// $field = new TextareaField('Intro','Introduction');
		// $fields->addFieldToTab('Root.Main', $field, 'Content');

		// $fields->addFieldToTab('Root.Media', GridField::create(
		// 	'Media','Media', $this->Media(), GridFieldConfig_RelationEditor::create()
		// ));

		$field = new DatetimeField('PublishedDate','Published Date : if this is used this date will be used in sorting this content');
		$field->getDateField()->setConfig('showcalendar',true);
		$field->getTimeField()->setconfig('use_strtotime', true);
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		return $fields;
	}

	public function onAfterWrite()
    {
        if ($this->owner->PublishedDate > 0)
        {
            $table_name = ClassInfo::baseDataClass($this->owner->ClassName); 
            DB::query('UPDATE '.$table_name." SET LastEdited = '".Convert::raw2sql($this->owner->PublishedDate)."'  WHERE ID = ".intval($this->owner->ID).' LIMIT 1');
        }
    }

    public function onAfterPublish()
    {
        if ($this->owner->PublishedDate > 0)
        {
            $table_name = ClassInfo::baseDataClass($this->owner->ClassName);
            DB::query('UPDATE '.$table_name."_Live SET LastEdited = '".Convert::raw2sql($this->owner->PublishedDate)."'  WHERE ID = ".intval($this->owner->ID).' LIMIT 1');
        }
    }


}
class News_Controller extends RoyalSocContent_Controller {

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