<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 4/04/17
 * Time: 3:58 PM
 */

class SocioEconomicCalculator extends RoyalSocContent
{
    private static $can_be_root = false; 

    private static $singular_name = 'Calculator: Socio Economic';
    private static $plural_name = 'Calculators: Socio Economic';

    private static $icon = 'mysite/icons/funds.png';

    private static $db = array();

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        return $fields;
    }
}
class SocioEconomicCalculator_Controller extends RoyalSocContent_Controller
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
        'generateEconomicCodes',
        'generateFinalEconomicCodes'
    );

    public function init()
    {
        parent::init();
    }

    public function getSocioEconomicCategories()
    {
        $categories = SocioEconomicObjectiveCategory::get();
        return $categories;
    }

    public function generateSubCats()
    {
        $CategoryID = NULL;
        if (isset($_POST['Value'])) {
            $CategoryID = $_POST['Value'];
        }

        $SubCategories = SocioEconomicObjectiveSubCategory::get()->filter(array(
            'SocioEconomicObjectiveCategoryID'   =>  $CategoryID
        ));

        $data = ArrayData::create(array(
            'SubCategories' => $SubCategories
        ));

        echo $data->renderWith('AjaxSocioEconomicSubCategories');
    }

    public function generateEconomicCodes()
    {
        $SubCatID = NULL;
        if (isset($_POST['SubCatID'])) {
            $SubCatID = $_POST['SubCatID'];
        }

        $researchCodes = SocioEconomicObjectiveCode::get()->filter(array(
            'SocioEconomicObjectiveSubCategoryID'    =>  $SubCatID
        ));

        $data = ArrayData::create(array(
            'EconomicCodes' => $researchCodes,
        ));

        echo $data->renderWith('AjaxEconomicCodesDropdown');
    }

    public function generateFinalEconomicCodes()
    {
        $CodeID = null;
        if (isset($_POST['CodeID']))
        {
            $CodeID = $_POST['CodeID'];
        }
        error_log($CodeID);

        $socioCode = SocioEconomicObjectiveCode::get()->byID($CodeID);

        $code = $socioCode->SocioEconomicObjectiveCode;
        $part = explode(' ',$code);
        $socioCode->SocioEconomicObjectiveCode = $part[0];

        $data = ArrayData::create(array(
            'EconomicCode' => $socioCode,
        ));

        echo $data->renderWith('AjaxEconomicCodes');
    }
}


