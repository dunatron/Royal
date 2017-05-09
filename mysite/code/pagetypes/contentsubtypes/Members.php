<?php

class Members extends RoyalSocContent
{
	private static $can_be_root = false;


	private static $icon = 'mysite/icons/person.png';

	private static $db = array(
		'DefaultView' => 'VarChar(55)'
	);

	private static $singular_name = 'Members';
	private static $plural_name = 'Members';

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

		$ViewOptions = array('Selectable'=>'Selectable');
		$People = People::get();
		foreach($People as $P)
		{
			if(!in_array($P->Grade, $ViewOptions))
			{
				$ViewOptions[$P->Grade] = $P->Grade;
			}
		}
		$field = new DropdownField('DefaultView','View', $ViewOptions, 'Selectable');
		$fields->addFieldToTab('Root.Main', $field, 'Metadata');

		$fields->removeFieldFromTab('Root.Main','Content');


		return $fields;
	}

	public function GradeOptions($selected='Fellow')
	{
		$Grades = array();
		$People = People::get();
		foreach($People as $P)
		{
			if(!in_array($P->Grade, $Grades))
			{
				$Grades[] = $P->Grade;
			}
		}
		
		foreach($Grades as $Grade)
		{
			$mark = null;
			if($Grade == $selected)
			{
				$mark = ' SELECTED="TRUE" ';
			}
			$output .= '<option value="'.$Grade.'" '.$mark.'>'.$Grade.'</option>';
		}
		return $output;

	}

}

class Members_Controller extends RoyalSocContent_Controller
{

	public function init() {
		parent::init();
		// You can include any CSS or JS required by your project here.
		// See: http://doc.silverstripe.org/framework/en/reference/requirements

		Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/peoplefilter.js');
		
	}


	private static $allowed_actions = array(
		'Person','People','MemberPage'
	);

	public function People()
	{
		if(!$_POST['Grade'])
		{
			if($this->DefaultView == 'Selectable')
			{
				$Grade = 'Fellow';
			}
			else
			{
				$Grade = $this->DefaultView;
			}
			
		}
		else
		{
			$Grade = $_POST['Grade'];
		}

		$People = People::get()->filter(array('Grade'=>$Grade))->sort('SortOrder','ASC');

		if(Director::is_ajax())
		{
			foreach($People as $Person)
			{
				$output .= $Person->renderWith('_People');
			}
			return $output;
		}
		else
		{
			return $People;
		}
	}

	public function Person()
	{
		$person = People::get()->byID($_POST['ID']);
		return $person->renderWith('_Person');
	}

	public function MemberPage(SS_HTTPRequest $request)
	{
		
		$person = People::get()->byID($request->param('ID'));
		
		if(!$person) {
            return $this->httpError(404,'That person could not be found');
        }

        //return $person->renderWith('Person');
        return $this->owner->customise($person)->renderWith('Person');
	}

}