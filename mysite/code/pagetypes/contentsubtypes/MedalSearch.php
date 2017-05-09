<?php

class MedalSearch extends RoyalSocContent
{

    private static $can_be_root = false;

    private static $singular_name = 'Medal Search';
    private static $plural_name = 'Medal Search';

    private static $icon = 'mysite/icons/medal.png';

    private static $db = array();

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        return $fields;
    }

}

class MedalSearch_Controller extends RoyalSocContent_Controller
{
    private static $allowed_actions = array(
        'generateSubjects',
        'generateMedals'
    );

    public function getMedalAudience()
    {
        $audiences = MedalAwardAudience::get();
        return $audiences;
    }

    public function generateSubjects()
    {
        $AudienceID = NULL;
        if (isset($_POST['Value'])) {
            $AudienceID = $_POST['Value'];
        }

        $Audience = MedalAwardAudience::get()->byID($AudienceID);

        $medals = $Audience->MedalsAwards();

        $medalsArr = ArrayList::create();

        foreach ($medals as $m)
        {
            $medalsArr->add($m);
        }

        $subjectsArr = ArrayList::create();
        foreach ($medalsArr as $medal)
        {
            $subjects = $medal->Subjects();

            foreach ($subjects as $s) {
                $subjectsArr->add($s);
            }
        }
        $subjectsArr->removeDuplicates('ID');

        $data = ArrayData::create(array(
            'Subjects' => $subjectsArr
        ));

        echo $data->renderWith('AjaxSelectBox');
    }

    public function generateMedals()
    {
        $AudienceID =   NULL;
        $SubjectID  =   NULL;

        if (isset($_POST['AudienceID'])) {
            $AudienceID = $_POST['AudienceID'];
        }
        if (isset($_POST['SubjectID'])) {
            $SubjectID = $_POST['SubjectID'];
        }

        // Audience Medals
        $audience = MedalAwardAudience::get()->byID($AudienceID);
        $audienceMedalsArr = array();

        $audienceMedals = $audience->MedalsAwards();
        foreach ($audienceMedals as $medal)
        {
            array_push($audienceMedalsArr, $medal->ID);
        }

        // Subject Medals
        $subject = Subject::get()->byID($SubjectID);
        $subjectMedalsArr = array();

        $subjectMedals = $subject->MedalsAwards();
        foreach ($subjectMedals as $medal)
        {
            array_push($subjectMedalsArr, $medal->ID);
        }

        // Final Medals
        $finalMedalIDS = array();
        foreach ($audienceMedalsArr as $AID)
        {
            if (in_array($AID, $subjectMedalsArr)) {
                array_push($finalMedalIDS, $AID);
            }
        }

        $FINALMEDALS = MedalAward::get()->byIDs($finalMedalIDS);

        $MedalDataArray = ArrayList::create();
        foreach ($FINALMEDALS as $medal)
        {
            // Strip content tags
            $medalContent = strip_tags($medal->Intro);
            $medalData = DataObject::create();

            $medalData->MedalTitle = $medal->Title;
            $medalData->MedalContent = $medalContent;

            $medalData->MedalURL = $medal->Link();

            $MedalDataArray->add($medalData);
        }

        $data = ArrayData::create(array(
            'Medals' => $MedalDataArray,
        ));

        echo $data->renderWith('AjaxMedals');
    }
}