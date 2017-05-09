<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 31/03/17
 * Time: 12:56 PM
 */
class LetterCategory extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar(100)',
    );

    private static $has_one = array(
        'Newsletter'    =>  'Newsletter'
    );

    private static $has_many = array(
        'LetterLinks'   =>  'LetterLink'
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $gfCatConfig = GridFieldConfig_RelationEditor::create();
        $CategoryList = $this->LetterLinks();
        $CatField = new GridField('cats', null, $CategoryList, $gfCatConfig);

        $fields->addFieldToTab('Root.Main',
            $CatField
        );

        return $fields; // TODO: Change the autogenerated stub
    }
}