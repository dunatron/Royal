<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 4/04/17
 * Time: 2:41 PM
 */
class FieldResearchCalculator extends RoyalSocContent
{
    private static $can_be_root = false; 

    private static $singular_name = 'Calculator: Field Research';
    private static $plural_name = 'Calculator: Field Research';

    private static $icon = 'mysite/icons/funds.png';

    private static $db = array();

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        return $fields;
    }
}
class FieldResearchCalculator_Controller extends RoyalSocContent_Controller
{

    /**
     * array (
     *     'action', // anyone can access this action
     *     'action' => true, // same as above
     *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
     *     'action' => '->checkAction' // you can only access this action if >checkAction() returns true
     * );
     * @var array
     */
    private static $allowed_actions = array(
        'generateSubCats',
        'generateFieldResearchCodes',
        'generateFinalResearchCode'
    );

    public function init()
    {
        parent::init();
    }

    public function getResearchCategories()
    {
        $categories = FieldResearchCategory::get();
        return $categories;
    }

    public function generateSubCats()
    {
        $CategoryID = NULL;
        if (isset($_POST['Value'])) {
            $CategoryID = $_POST['Value'];
        }

        $SubCategories = FieldResearchSubCategory::get()->filter(array(
            'FieldResearchCategoryID'   =>  $CategoryID
        ));

        $data = ArrayData::create(array(
            'SubCategories' => $SubCategories
        ));

        echo $data->renderWith('AjaxResearchSubCategories');
    }

    public function generateFieldResearchCodes()
    {
        $SubCatID = NULL;
        if (isset($_POST['SubCatID'])) {
            $SubCatID = $_POST['SubCatID'];
        }

        $researchCodes = FieldResearchCode::get()->filter(array(
            'FieldResearchSubCategoryID'    =>  $SubCatID
        ));

        $data = ArrayData::create(array(
            'ResearchCodes' => $researchCodes,
        ));

        echo $data->renderWith('AjaxResearchCodesDropDown');
    }

    public function generateFinalResearchCode()
    {
        $CodeID = null;
        if (isset($_POST['CodeID']))
        {
            $CodeID = $_POST['CodeID'];
        }
        error_log($CodeID);

        $researchCode = FieldResearchCode::get()->byID($CodeID);

        $code = $researchCode->FieldResearchCode;
        $part = explode(' ',$code);
        $researchCode->FieldResearchCode = $part[0];

        $data = ArrayData::create(array(
            'ResearchCode' => $researchCode,
        ));

        echo $data->renderWith('AjaxResearchCodes');
    }
}


