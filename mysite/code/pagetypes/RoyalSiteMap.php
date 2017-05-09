<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 10/04/17
 * Time: 9:55 AM
 */
class RoyalSiteMap extends Page
{

    private static $singular_name        = "Royal Site Map";
    private static $plural_name          = "Royal Site Maps";
    private static $db = array();
    
    static $defaults = array (
	    'ShowInMenus' => true,
	    'ShowInSearch' => false
    );

    private static $can_be_root = true;

    private static $hide_ancestor = null;
    
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        
        return $fields;
    }
    
}
class RoyalSiteMap_Controller extends Page_Controller
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
        'getRoyalChildPages'
    );

    public function init()
    {
        parent::init();
    }

    public function getAllTopLevelPages()
    {
        // Array Containing all top level pages
        $TopLevelPages = ArrayList::create();

        $homePages = Home::get()->filter(array(
            'ParentID'  =>  0
        ))->exclude('Title','For Staff');

        $panelPages = Panel::get()->filter(array(
            'ParentID'  =>  0
        ))->exclude('Title','For Staff');

        $projectPages = Project::get()->filter(array(
            'ParentID'  =>  0
        ))->exclude('Title','For Staff');

        foreach ($homePages as $page)
        {
            $TopLevelPages->add($page);

        }

        foreach ($panelPages as $page)
        {
            $TopLevelPages->add($page);
        }

        foreach ($projectPages as $page)
        {
            $TopLevelPages->add($page);
        }

        return $TopLevelPages;
    }

}


