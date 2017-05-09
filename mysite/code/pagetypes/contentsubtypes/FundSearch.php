<?php

class FundSearch extends RoyalSocContent
{

    private static $can_be_root = false;

    private static $singular_name = 'Fund Search';
    private static $plural_name = 'Fund Search';

    private static $icon = 'mysite/icons/funds.png';

    private static $db = array();

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        return $fields;
    }

}

class FundSearch_Controller extends RoyalSocContent_Controller
{
    private static $allowed_actions = array(
        'generateTypes',
        'generateFundOpportunities'
    );

    public function getFundAudience()
    {
        $audiences = FundOpportunityAudience::get();
        return $audiences;
    }

    public function generateTypes()
    {
        $AudienceID = NULL;
        if (isset($_POST['AUDIENCEID'])) {
            $AudienceID = $_POST['AUDIENCEID'];
        }

        $audience = FundOpportunityAudience::get()->byID($AudienceID);
        $funds = $audience->FundsOpportunities();

        $fundsArr = ArrayList::create();

        foreach ($funds as $f)
        {
            $fundsArr->add($f);
        }

        $typesArr = ArrayList::create();
        foreach ($fundsArr as $fund)
        {
            $types = $fund->Types();

            foreach ($types as $t)
            {
                $typesArr->add($t);
            }
        }
        $typesArr->removeDuplicates('ID');

        $data = ArrayData::create(array(
            'Types' => $typesArr
        ));

        echo $data->renderWith('AjaxTypeSelectBox');

    }

    public function generateFundOpportunities()
    {
        if(isset($_POST['AudienceID']))
        {
            $audienceID = $_POST['AudienceID'];
        }
        if(isset($_POST['TypeID']))
        {
            $typeID = $_POST['TypeID'];
        }

        /*
        $funds = FundOpportunity::get()->filter(array(
            'AudienceID'    =>  $audienceID,
            'TypeID'    =>  $typeID
        ));

        $FundDataArray = ArrayList::create();
        foreach ($funds as $fund)
        {
            $fundData = DataObject::create();

            $fundData->FundTitle = $fund->Title;
            $fundData->FundContent = $fund->Content;
            $fundData->FundURL = $fund->URL;
            $fundData->subjects = $subjects = $fund->Subjects();

            $FundDataArray->add($fundData);
        }

        $data = ArrayData::create(array(
            'Funds' =>  $FundDataArray
        ));

        echo $data->renderWith('AjaxFunds');
        */

        // audience funds
        $audience = FundOpportunityAudience::get()->byID($audienceID);
        $audienceFundArr = array();

        $audienceFunds = $audience->FundsOpportunities();
        foreach ($audienceFunds as $fund)
        {
            array_push($audienceFundArr, $fund->ID);
        }

        // types funds
        $type = FundOpportunityType::get()->byID($typeID);
        $typeFundsArr = array();

        $typeFunds = $type->FundsOpportunities();
        foreach ($typeFunds as $fund)
        {
            array_push($typeFundsArr, $fund->ID);
        }

        // Final Funds
        $finalFundIDS = array();
        foreach ($audienceFundArr as $AFID)
        {
            if (in_array($AFID, $typeFundsArr)) {
                array_push($finalFundIDS, $AFID);
            }
        }

        $FINALFUNDS = FundOpportunity::get()->byIDs($finalFundIDS);


        $FundDataArray = ArrayList::create();
        foreach ($FINALFUNDS as $fund)
        {
            // Strip content tags
            $fundContent = strip_tags($fund->Intro);
            $fundData = DataObject::create();

            $fundData->FundTitle = $fund->Title;
            $fundData->FundContent = $fundContent;

            $fundData->FundURL = $fund->Link();
            $fundData->subjects = $subjects = $fund->Subjects();

            $FundDataArray->add($fundData);
        }

        $data = ArrayData::create(array(
            'Funds' =>  $FundDataArray
        ));

        echo $data->renderWith('AjaxFunds');



    }

}