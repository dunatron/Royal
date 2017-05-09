<?php

class StaffPage extends RoyalSocContent
{
	private static $can_be_root = false;
	private static $icon = 'mysite/icons/staff.png';

	private static $singular_name = 'Staff';
	private static $plural_name = 'Staff';

	private static $db = array(
		'Department' => 'Varchar(255)'
	);


	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$Departments = $this->getDepartments();

		$DepartmnentOptions = array('all'=>'');
		foreach($Departments as $Department)
		{
			$DepartmnentOptions[$Department] = $Department;
		}
		$field = new DropdownField('Department','Department to display (leave blank to show all)', $DepartmnentOptions, 'all');
		$fields->addFieldToTab('Root.Main', $field, 'Metadata');


		return $fields;
	}

	public function getDepartments($exclude='')
	{
		$Departments = array();
		$Members = Member::get()->exclude('Department',$exclude);
		foreach($Members as $M)
		{
			if(!in_array($M->Department, $Departments) && $M->inGroup('Staff'))
			{
				$Departments[] = $M->Department;
			}
		}
		return $Departments;
	}

}

class StaffPage_Controller extends RoyalSocContent_Controller
{
	private static $allowed_actions = array(
		'Staff','Person'
	);

	public function init() {
		parent::init();
		// You can include any CSS or JS required by your project here.
		// See: http://doc.silverstripe.org/framework/en/reference/requirement
		Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/staff.js');
		//Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/custom-slider.js');
	}


	public function Person()
	{
		if($_POST['ID'])
		{
			$person = Member::get()->byID($_POST['ID']);
			return $person->renderWith('_StaffDetails');
		}
		return 'Whoops!';
	}


	public function Staff()
	{
		$output = '';
		if($this->Department == 'all')
		{

			$output = $this->Department('Royal Society Te Apārangi');

			$Departments = $this->getDepartments('Royal Society Te Apārangi');

			foreach($Departments as $Department)
			{
				$output .= $this->Department($Department);
			}

			
		}
		else
		{
			$output .= $this->Department($this->Department);
		}
		return $output;
	}

	public function getDepartments($exclude='')
	{
		$Departments = array();
		$Members = Member::get()->exclude('Department',$exclude);
		foreach($Members as $M)
		{
			if(!in_array($M->Department, $Departments) && $M->inGroup('Staff'))
			{
				$Departments[] = $M->Department;
			}
		}
		return $Departments;
	}

	private function Department($department)
	{
		$output = '<h2>'.$department.'</h2>';
		$manager = Member::get()->filter(array('Department'=>$department, 'IsManager'=>1))->sort('Surname','ASC');
		foreach($manager as $person)
		{
			if($person->inGroup('Staff'))
			{
				$output .= $person->renderWith('_Staff');
			}
		}
		$staff = Member::get()->filter(array('Department'=>$department, 'IsManager'=>0))->sort('Surname','ASC');
		foreach($staff as $person)
		{
			if($person->inGroup('Staff'))
			{
				$output .= $person->renderWith('_Staff');
			}
		}
		return $output.'<div class="clear"></div>';
	}

}