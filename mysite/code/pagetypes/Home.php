<?php
class Home extends Page {

	private static $has_one = array(
		'FacilitiesPage' => 'SiteTree',
		'JoinUsPage' => 'SiteTree',
		'AnniversaryPage' => 'SiteTree',
		'VacanciesPage' => 'SiteTree',
		'AboutUsPage' => 'SiteTree',
		'NewslettersSignUpPage' => 'SiteTree'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->removeFieldFromTab('Root.Main', 'Content');

		$field = new TreeDropdownField('FacilitiesPageID','Select the Facilities Page','SiteTree');
		$fields->addFieldToTab('Root.Main', $field, 'Metadata');

		$field = new TreeDropdownField('JoinUsPageID','Select the Join Us Page','SiteTree');
		$fields->addFieldToTab('Root.Main', $field, 'Metadata');

		$field = new TreeDropdownField('NewslettersSignUpPageID','Select the Newsletter Sign Up Page','SiteTree');
		$fields->addFieldToTab('Root.Main', $field, 'Metadata');

		$field = new TreeDropdownField('AnniversaryPageID','Select the 150th Anniversary microsite','SiteTree');
		$fields->addFieldToTab('Root.Main', $field, 'Metadata');

		$field = new TreeDropdownField('VacanciesPageID','Select the Vacancies page','SiteTree');
		$fields->addFieldToTab('Root.Main', $field, 'Metadata');

		$field = new TreeDropdownField('AboutUsPageID','Select the About Us page','SiteTree');
		$fields->addFieldToTab('Root.Main', $field, 'Metadata');

		return $fields;
	}


}
class Home_Controller extends Page_Controller {

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
	private static $allowed_actions = array ('SliderContent','SetAudienceCookie');

	public function init() {
		parent::init();
		// You can include any CSS or JS required by your project here.
		// See: http://doc.silverstripe.org/framework/en/reference/requirement
		Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/homepage.js');
		//Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/custom-slider.js');
	}

	public function OurCommunities()
	{
		$tag = CoreTag::get()->filter(array('Tag'=>'tab:ourcommunities'))->first();
		$Pages = $tag->Pages();
		return $Pages;
	}

	public function Boxes($audience)
	{
		$theme = SSViewer::current_theme();
		$output = '';

		$count = 0;
		for($i=1;$i<=4;$i++)
		{
			$tagname = 'audience:'.$audience.':box'.$i;
			$tag = CoreTag::get()->filter(array('Tag'=>$tagname))->first();
			$Page = $tag->Pages()->first();
			if($Page)
			{
				$count++;
				$output .= '
				<div class="panel-item md-col-6 lrg-col-6" panel-page-id="'.$Page->ID.'">
					<div class="panel-img-container" style="background-image:url(\'themes/'.$theme.'/img/boxes/'.$audience.'tile'.$count.'.jpg\')">
					    <div class="panel-img"  style="background-image:url(\'themes/'.$theme.'/img/boxes/'.$audience.'tile'.$count.'.jpg\')"></div>
					    <div class="backdrop-slide">
					        <a href="'.$Page->Link().'" class="panel-text">'.$Page->MenuTitle.'</a>';
				$output .= $this->BoxItems($count, $Page, $audience);
				$output .='		       
					    </div>   
					</div>
				</div>
				';
			}
		}
		if($count < 4)
		{
			$tagname = 'audience:'.$audience;
			$tag = CoreTag::get()->filter(array('Tag'=>$tagname))->first();
			$Pages = $tag->Pages()->filter(array('ParentID'=>0))->exclude('Title','For Staff');
			foreach($Pages as $Page)
			{
				$count++;
				$output .= '
				<div class="panel-item md-col-6 lrg-col-6" panel-page-id="'.$Page->ID.'">
					<div class="panel-img-container" style="background-image:url(\'themes/'.$theme.'/img/boxes/'.$audience.'tile'.$count.'.jpg\')">
					    <div class="panel-img"  style="background-image:url(\'themes/'.$theme.'/img/boxes/'.$audience.'tile'.$count.'.jpg\')"></div>
					    <div class="backdrop-slide">
					        <a href="'.$Page->Link().'" class="panel-text">'.$Page->MenuTitle.'</a>';
				$output .= $this->BoxItems($count, $Page, $audience);
				$output .='			       
					    </div>   
					</div>
				</div>
				';
				if($count == 4)
				{
					break;
				}
			}
		}
		if($count < 4)
		{
			while($count < 4)
			{
				$count++;
				$output .= '
				<div class="panel-item md-col-6 lrg-col-6" panel-page-id="'.$Page->ID.'">
					<div class="panel-img-container" style="background-image:url(\'themes/'.$theme.'/img/boxes/'.$audience.'tile'.$count.'.jpg\')">
					    <div class="panel-img"  style="background-image:url(\'themes/'.$theme.'/img/boxes/'.$audience.'tile'.$count.'.jpg\')"></div>
						    <div class="backdrop-slide">
						        		       
						    </div>   
						</div>
				</div>';
			}
		}
		return $output;
	}

	public function BoxItems($Box, $ParentPage, $audience)
	{
		$output = '';
		$count = 0;
		for($i=1;$i<=4;$i++)
		{
			$tagname = 'audience:'.$audience.':box'.$Box.':item'.$i;
			$tag = CoreTag::get()->filter(array('Tag'=>$tagname))->first();
			$Page = $tag->Pages()->first();
			if($Page)
			{
				$count++;
				$output .= '<a href="'.$Page->Link().'" class="panel-link">'.$Page->MenuTitle.'</a>';
			}

		}

		if($count < 4)
		{
			//echo var_export($Page,true);

			if($ParentPage->getClassName() == 'EventPanel' || $ParentPage->getClassName() == 'NewsPanel')
	        {
	            $Sort = 'LastEdited';
	        }
	        else
	        {
	            $Sort = 'Sort';
	        }

	        if($ParentPage->getClassName() == 'NewsPanel')
	        {
	            $Order = 'DESC';
	        }
	        else
	        {
	            $Order = 'ASC';
	        }

			$Pages = Page::get()->filter(array('ParentID'=>$ParentPage->ID))->sort(array($Sort=>$Order));
			foreach($Pages as $Page)
			{
				if($Page->getClassName() == 'Event')
				{
//					$Location = $Page->Locations()->sort('Start', 'DESC')->first();
	                if(strtotime($Page->Start) > time())
	                {
	              
	                    $count++;
						$output .= '<a href="'.$Page->Link().'" class="panel-link">'.$Page->MenuTitle.'</a>';
						if($count == 4)
						{
							break;
						}
	                }
				}
				else
				{

					$count++;
					$output .= '<a href="'.$Page->Link().'" class="panel-link">'.$Page->MenuTitle.'</a>';
					if($count == 4)
					{
						break;
					}
				}
			}
		}
		return $output;
	}

	public function SliderContent()
	{
		//echo '<br />Post: '.$_POST['atype'];
		//$audience = 'all';
		if(isset($_POST['atype']))
		{
			$atype = $_POST['atype'];
			switch($atype)
			{
				case 'all':
				case 'curious':
					$audience = 'all';
					break;
				case 'stuteach':
				case 'teachersandstudents':
					$audience = 'teachersandstudents';
					break;
				case 'research':
				case 'researchers':
					$audience = 'researchers';
					break;
			}
		}
		else
		{
			$audience = 'all';
		}

		$boxIDs = json_decode($_POST['boxids']);

		$output = '';

		$SliderPanels = new ArrayList();

		//$tagname = 'audience:'.$audience;
		$tagname = 'slider:'.$audience;
		
		$tag = CoreTag::get()->filter(array('Tag'=>$tagname))->first();
		if($tag)
		{
			//$pages = $tag->Pages()->filter(array('ParentID'=>0))->filterAny('ClassName',array('Panel','Project','EventPanel','FundsOpportuntiesPanel','MedalsAwardsPanel','NewsPanel'))->exclude('Title','For Staff');
			$pages = $tag->Pages();
			foreach($pages as $page)
			{
				if(!empty($page->Blurb))
	            {
	                $Text = strip_tags($page->Blurb);
	            } 
	            else
	            {
	                $Text = strip_tags($page->Intro);
	            }

	            $Text = $this->ClipText($page->Title, $Text);


				$data = ArrayData::create(array(
	                'Title' => $page->Title,
	                'Text' => $Text,
	                'Image' => $page->HeroImage(),
	                'Link' => $page->Link()
	            ));

				if($page->getClassName() == 'Event')
				{
					if(strtotime($page->End) > time())
					{
						if(is_array($boxIDs))
						{
							if(!in_array($page->ID,$boxIDs))
							{
								$SliderPanels->push($data);
							}
						}
						else
						{
							$SliderPanels->push($data);					
						}
					}
				}
				else
				{
					if(is_array($boxIDs))
					{
						if(!in_array($page->ID,$boxIDs))
						{
							$SliderPanels->push($data);
						}
					}
					else
					{
						$SliderPanels->push($data);					
					}

				}


			}

			// $pages = $tag->Pages()->filter(array('ParentID:not'=>0))->filterAny('ClassName',array('Panel','Project','EventPanel','FundsOpportuntiesPanel','MedalsAwardsPanel','NewsPanel'));
			
			// foreach($pages as $page)
			// {
			// 	if(!empty($page->Blurb))
	  //           {
	  //               $Text = strip_tags($page->Blurb);
	  //           } 
	  //           else
	  //           {
	  //               $Text = strip_tags($page->Intro);
	  //           }
	  //           $Text = $this->ClipText($page->Title, $Text);
			// 	$data = ArrayData::create(array(
	  //               'Title' => $page->Title,
	  //               'Text' => $Text,
	  //               'Image' => $page->HeroImage(),
	  //               'Link' => $page->Link()
	  //           ));
			// 	if(is_array($boxIDs))
			// 	{
			// 		if(!in_array($page->ID,$boxIDs))
			// 		{
			// 			$SliderPanels->push($data);
			// 		}
			// 	}
			// 	else
			// 	{
			// 		$SliderPanels->push($data);
			// 	}
			// }

		}
		foreach($SliderPanels as $Panel)
		{
			$output .= $Panel->renderWith('_HomePageSlider');
		}
		return $output;
	}

	public function SetAudienceCookie()
	{
		if($_POST['royalsocietyaudience'])
		{
			$duration = time()+60*60*24*365;
			setcookie('RoyalSocietyAudience',$_POST['royalsocietyaudience'],$duration, '/');
		}
	}

	public function AudienceType()
	{
		$audiencetype = 'all';
		
		if($_COOKIE['RoyalSocietyAudience'])
		{
			$audiencetype = $_COOKIE['RoyalSocietyAudience'];
		}

		return '<input type="hidden" name="audiencetype" id="audiencetype" value="'.$audiencetype.'" />';
	}


}