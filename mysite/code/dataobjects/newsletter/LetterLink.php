<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 31/03/17
 * Time: 12:56 PM
 */
class LetterLink extends DataObject
{
    private static $db = array(
        'Link' => 'Varchar(100)',
    );

    private static $has_one = array(
        'LetterCategory'    =>  'LetterCategory'
    );

    public function CustomPages()
    {
        $pages = Page::get();
        return $pages;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $link = TreeDropdownField::create('Link', 'Choose a Page', 'SiteTree');

        $link->setDisableFunction(function($item) {
            return ( ! $item instanceof RoyalSocContent);
        });

        $fields->addFieldsToTab('Root.Main', array(
            $link
        ));

        return $fields; // TODO: Change the autogenerated stub
    }
}