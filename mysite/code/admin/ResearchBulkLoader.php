<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 30/03/17
 * Time: 10:23 AM
 */
class ResearchBulkLoader extends Controller
{

    private static $allowed_actions = array('ResearchBulkForm');

    protected $template = "ResearchBulkUploadPage";

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $member = Member::currentUser();
        if(!$member) Security::permissionFailure();
    }

    public function Link($action = null)
    {
        return Controller::join_links('ResearchBulkLoader', $action);
    }

    public function ResearchBulkForm()
    {
        $form = new Form(
            $this,
            'ResearchBulkForm',
            new FieldList(
                new FileField('CsvFile', false)
            ),
            new FieldList(
                new FormAction('doUpload', 'Upload')
            ),
            new RequiredFields()
        );
        return $form;
    }

    public function doUpload($data, $form)
    {
        // Delete all records before bulk upload. Records get changed every 10 years or so
        $this->deleteOldData();

        $results = ($_FILES['CsvFile']['tmp_name']);
        $file = fopen($results, r);
        $firstline = fgets($file, 4096); // Gets first record(i.e not being stored in the db as its the column name)
        //Gets the number of fields, in CSV-files the names of the fields are mostly given in the first line
        $num = strlen($firstline) - strlen(str_replace(";", "", $firstline));

        $i = 0;

        //CSV: one line is one record and the cells/fields are separated by ","
        //so $stringRecord is an two dimensional array
        while ($line[$i] = fgets($file, 4096)) {

            $stringRecord[$i] = array();
            $stringRecord[$i] = explode("|", $line[$i], ($num + 1));
            $i++;
        }

        $MainCategory = NULL;//$MainCategory = new FieldResearchCategory();
        $SubCategory = NULL;//$SubCategory = new FieldResearchSubCategory();
        $Code = NULL;//$Code = new FieldResearchCode();
        foreach ($stringRecord as $key => $number) {
            foreach ($number as $k => $content) {
                $myArray = explode('|', $content);
                // Category
                if (!empty($myArray[0])) {
                    $MainCategory = new FieldResearchCategory();
                    $MainCategory->FieldResearchCategory = $myArray[0] . ' ' . $myArray[3];
                    $MainCategory->write();
                }
                // SubCategory
                if (!empty($myArray[1])) {
                    $SubCategory = new FieldResearchSubCategory();
                    $SubCategory->FieldResearchSubCategory = $myArray[1] .' '. $myArray[3];
                    $SubCategory->FieldResearchCategoryID = $MainCategory->ID;
                    $SubCategory->write();
                }
                // Code
                if (!empty($myArray[2])) {
                    $Code = new FieldResearchCode();
                    $Code->FieldResearchCode = $myArray[2] .' '. $myArray[3];
                    $Code->FieldResearchSubCategoryID = $SubCategory->ID;
                    $Code->write();
                }
            }
        }

        return $this->redirectBack();
    }

    public function deleteOldData()
    {
        /*
         * Deleting in lowest dependency order, ie, codes first, then subCat, then mainCat
         */
        $codes = FieldResearchCode::get();
        foreach ($codes as $code) {
            $code->delete();
        }

        $sCategory = FieldResearchSubCategory::get();
        foreach ($sCategory as $cat) {
            $cat->delete();
        }

        $mCategory = FieldResearchCategory::get();
        foreach ($mCategory as $cat) {
            $cat->delete();
        }
        return;
    }
}