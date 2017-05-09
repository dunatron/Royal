<?php

class People extends DataObject
{
	private static $db = array(
		'MemberNumber' => 'Int',
		'UserID' => 'Varchar(255)',
		'SortOrder' => 'Varchar(255)',
		'mySQLid' => 'Int',
		'FirstName' => 'Varchar(255)',
		'LastName' => 'Varchar(255)',
		'FullName' =>  'Varchar(255)',
		'Qualifications' => 'Varchar(255)',
		'FullAddress' => 'Text',
		'DisplayAddress' => 'Varchar(255)', 
		'Grade' => 'Varchar(55)',
		'BiographicalNotes' => 'HTMLText',
		'ResearchNotes' => 'Text', 
		'CRMID' =>  'Int',
		'Title' => 'Varchar(255)'
	);

	private static $has_one = array(
		'Photo' => 'File'
	);

	private static $summary_fields = array(
		'FullName' => 'Person',
		'Grade' => 'Type'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->addFieldToTab('Root.Main', $photo = UploadField::create('Photo','Photo'));
		$photo->setFolderName('people');

		//$fields->addFieldToTab('Root', new Tab('Import', _t('Import.Import', 'Import People')));

		return $fields;
	}

	// public function Title()
	// {
	// 	$FullName = $this->FullName;
	// 	$Parts = explode(' ', $FullName);
	// 	//$Title = trim($Parts[0]);

	// 	$key = array_search(trim($this->LastName), $Parts);
	// 	unset($Parts[$key]);

	// 	$key = array_search(trim($this->FirstName), $Parts);
	// 	unset($Parts[$key]);

	// 	$Title = implode(' ', $Parts);
	// 	if($Title > '')
	// 	{
	// 		return $Title;
	// 	}

	// 	return null;
	// }

	public function Link() {
		return '/members/memberpage/'.$this->ID;
	}
	
	public function getShowInSearch() {
		return 1;
	}

}

class PeopleController extends Controller
{

	//private static $allowed_actions = array('FullUpdate','ImportPeople');
	//private static $url_handlers = array('fullupdate' => 'FullUpdate');

	public function FullUpdate()
	{

		$count = $this->NewImportPeople();
		return '<br><h1>People Imported: '.$count.'</h1>';
	}

	public function NewImportPeople()
	{

		ini_set('memory_limit', '256M');

		$checkIDS = array();

		$folder = Folder::find_or_make('/people');
		$relativeFilePath = $_SERVER['DOCUMENT_ROOT'].'/'.$folder->getRelativePath();

		$url = 'http://api.royalsociety.org.nz:8080/api/members';
		//$url = 'http://';
		
		echo '<br />Getting People from '.$url.'<br />';

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$raw = curl_exec($curl);
		$result = json_decode($raw);



		$updating = 0;
		$creating = 0;
		if(count($result) == 0)
		{
			return "<br />\r\n".'+++Out of Cheese Error+++'."<br />\r\n".'Nothing recieved from API so process halted';
		}

		foreach($result as $fellow)
		{
			$CRMID = $fellow->ID;
			$check = People::get()->filter(array('CRMID'=>$CRMID));

			if($check->count() == 1)
			{
				$person = $check->first();
				$PhotoID = $person->PhotoID;
				$action = 'updating';
				$updating++;
			}
			else
			{
				$person = People::create();
				$PhotoID = null;
				$action = 'creating';
				$creating++;
			}

			$person->MemberNumber = $fellow->MemberNumber;
			$person->UserID = $fellow->UserID;
			$person->SortOrder = $fellow->SortOrder;
			$person->mySQLid = $fellow->mySQLid;
			$person->FirstName = $fellow->FirstName;
			$person->LastName = $fellow->LastName;
			$person->FullName = $fellow->FullName;
			$person->Qualifications = $fellow->Qualifications;
			$person->FullAddress = $fellow->FullAddress;
			$person->DisplayAddress = $fellow->DisplayAddress; 
			$person->Grade = $fellow->Grade;
			$person->BiographicalNotes = $fellow->BiographicalNotes;
			$person->ResearchNotes = $fellow->ResearchNotes;
			$person->CRMID = $fellow->ID;
			$person->Title = $fellow->Title;

			// 1. delete any existing photo file
			if($PhotoID && $PhotoID > 0)
			{
				$File = File::get()->byID($PhotoID);
				if($File)
				{
					$File->delete();
				}
				$person->PhotoID = null; // safety in case anything after this fails
			}
			// 2. create new photo file
			if($fellow->Image > '')
			{
				$fileName = str_replace(' ','-',$fellow->FullName).'-'.time().'.png';

				$data = base64_decode($fellow->Image);

				$im = imagecreatefromstring($data);
				$image = imagepng($im, $relativeFilePath.$fileName, 0, null);
				
				// 3. associate new photo with person
				$file = new Image();
				$file->ParentID = $folder->ID;
				$file->OwnerID = 1;
				$file->Name = $fileName;
				$file->FileName = $folder->Filename.$fileName;
				$file->Title = $fellow->FullName;
				$person->PhotoID = $file->write();

			}
			$checkIDS[] = $person->MemberNumber;
			$PersonUID = $person->write();
		}
		// sweep People for People to remove
		$deleted = 0;
		$currentPeople = People::get();
		foreach($currentPeople as $person)
		{
			if(!in_array($person->MemberNumber,$checkIDS))
			{
				// delete photo
				if($person->PhotoID > 0)
				{
					$File = File::get()->byID($person->PhotoID);
					if($File)
					{
						$File->delete();
					}
				}
				// delete person
				$person->delete();
				$deleted++;
			}
		}
		echo '<br />Updated: '.$updating;
		echo '<br />Created: '.$creating;
		echo '<br />Deleted: '.$deleted;
		$count = $updating+$creating;
		return $count;

	}

}
