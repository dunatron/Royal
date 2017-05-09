<?php
class OnlineDocument extends RoyalSocContent {

	private static $can_be_root = false;


	private static $singular_name = 'Online Document';
	private static $plural_name = 'Online Documents';

	private static $icon = 'mysite/icons/onlinedoc.png';

	private static $allowed_children = array('DocumentSection','DocumentParagraph');	

	private static $db = array(
		'NoNumbering' => 'Boolean',
		'CollapsedTOC' => 'Boolean'
	);

	private static $has_one = array(
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->removeFieldFromTab('Root.Main', 'Content');
		$fields->removeFieldFromTab('Root.Main', 'HeroImage');

		$fields->removeFieldFromTab('Root.Main','Intro');

		$field = new CheckboxField('NoNumbering','No Numbering');
		$fields->addFieldToTab('Root.Main', $field, 'ShowQuotes');

		$field = new CheckboxField('CollapsedTOC','Collapse Table of Contents');
		$fields->addFieldToTab('Root.Main', $field, 'ShowQuotes');


		return $fields;
	}

}
class OnlineDocument_Controller extends RoyalSocContent_Controller {

	/**
	 * An array of actions that can be accessed via a request. Each array element should be an action name, and the
	 * permissions or conditions required to allow the user to access it.
	 *
	 * <code>
	 * array (
	 *     'action', // anyone can access this action
	 *     'action' => true, // same as above
	 *     'action' => 'ADMIN', // you must have ADMIN permissions to access this action
	 *     'action' => '->checkAction' // you can only access this action if $this->checkAction() returns true
	 * );
	 * </code>
	 *
	 * @var array
	 */
	private static $allowed_actions = array (
	);

	public function init() {
		parent::init();
		// You can include any CSS or JS required by your project here.
		// See: http://doc.silverstripe.org/framework/en/reference/requirements
		Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/toc.js');
	}

	/*
	    <div class="user-content">
            <% loop $AllChildren %>
                <p><span>$Pos</span> $Title</p>
                <p>$Content</p>
                <% loop $ALLChildren %>
                    <p><span>$Up.Pos&#46;$Pos</span> $Title</p>
                    <p>$Content</p>
                <% end_loop %>
            <% end_loop %>
        </div>
	
	*/

    public function Test()
    {
    	return var_export($_SERVER,true);
    }

	public function Content()
	{

		if($this->CollapsedTOC == 1)
		{
			$tocclass = 'closed';
		}
		else
		{
			$tocclass = 'open';
		}
		$TOC = $this->TOC($this->ID, null, $this->NoNumbering, $tocclass);
		$Content = $this->childContent($this->ID, null, $this->NoNumbering);
		return '<h3 id="toctitle" class="'.$tocclass.'">Table of Contents</h3>'.$TOC.$Content;
	}

	private function childContent($ParentID=null, $pcount, $numbering)
	{
		$Content = '';
		if($ParentID)
		{	
			$count = 1;
			$Parts = Page::get()->filter(array('ParentID'=>$ParentID));
			foreach($Parts as $Part)
			{
				$number = null;
				if($numbering == 0){
					if($pcount){
						$number = $pcount.'.'.$count.'. ';
					}
					else
					{
						$number = $count.'. ';
					}
				}
				$Type = $Part->getClassName();
				if($Type == 'DocumentParagraph')
				{
					$Content .= '<h1 class="documentpara" id="'.$Part->ID.'">'.$number.$Part->Title.'</h1>';
					$Content .=  $Part->Content;
				}
				else
				{
					$Content .= '<h1 class="documentsec" id="'.$Part->ID.'">'.$number.$Part->Title.'</h1>';
					$Content .= $this->childContent($Part->ID, $count, $numbering);
				}
				$count++;
			}

		}
		return $Content;
	}

	private function TOC($ParentID=null, $pcount, $numbering, $tocclass=null)
	{
		$Content = '<ul class="royaltoc '.$tocclass.'">';
		if($ParentID)
		{	
			$count = 1;
			$Parts = Page::get()->filter(array('ParentID'=>$ParentID));
			foreach($Parts as $Part)
			{
				$number = null;
				if($numbering == 0){
					if($pcount){
						$number = $pcount.'.'.$count.'. ';
					}
					else
					{
						$number = $count.'. ';
					}
				}
				$Type = $Part->getClassName();
				if($Type == 'DocumentParagraph')
				{
					$Content .= '<li><a href="#'.$Part->ID.'">'.$number.$Part->Title.'</a></li>';
					//$Content .=  $Part->Content;
				}
				else
				{
					$Content .= '<li><a href="#'.$Part->ID.'">'.$number.$Part->Title.'</a>';
					$Content .= $this->TOC($Part->ID, $count, $numbering);
					$Content .= '</li>';
				}
				$count++;
			}

		}
		$Content .= '</ul>';
		return $Content;
	}


}