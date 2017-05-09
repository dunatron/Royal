<?php
class MicroSite extends RoyalSocContent {


	private static $icon = 'mysite/icons/microsite.png';

	private static $db = array(
		'VideoURL' => 'Varchar(255)',
		'TextColour' => 'Varchar(55)',
		'TiktokTitle' => 'Varchar(255)',
		'TiktokEmbededURL' => 'Varchar(255)',
		'ShowPageSlider' => 'Boolean',
		'PageSliderTitle' => 'Varchar(255)',
		'EmbededVideoURL' => 'Text',
		'Layout' => 'Text'
	);

	private static $has_one = array(
		'MicroSiteLogo' => 'Image',
		'Carousel' => 'Carousel'
	);

	// private static $has_many = array (
 //        'Orders' => 'BookOrders'
 //    );

	private static $singular_name = 'Micro Site';
	private static $plural_name = 'Micro Sites';

	protected $template = "MicroSite";

	//private static $can_be_root = false;
	//private static $allowed_children = 'none';

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->removeFieldFromTab('Root.Main', 'Intro');
		$fields->removeFieldFromTab('Root.Main', 'ShowQuotes');


		// $config = GridFieldConfig_RelationEditor::create();
		
		// $config->removeComponentsByType('GridFieldEditButton');
		// $config->removeComponentsByType('GridFieldDeleteAction');
		// $config->removeComponentsByType('GridFieldAddNewButton');
		// $config->addComponent(new GridFieldTagDeleteAction());
		// $field = GridField::create('Tags', 'Tags', $this->Tags(), $config);
		// $fields->addFieldToTab('Root.Main', $field, 'Content');

		$fields->addFieldToTab(
			'Root.Main', 
			$uploadField = new UploadField(
				$name = 'MicroSiteLogo', 
				$title = 'Logo Image'
			),
			'Content' 
		);
		$Folder = Folder::find_or_make('/MicroSiteLogos');
		$uploadField->setAllowedFileCategories('image');
		$uploadField->setAllowedMaxFileNumber(1);
		$uploadField->setFolderName('MicroSiteLogos');


		$fields->addFieldToTab(
			'Root.Main', 
			$uploadField = new UploadField(
				$name = 'HeroImage', 
				$title = 'Banner Image : Upload a single high resolution image'
			),
			'Content' 
		);
		$Folder = Folder::find_or_make('/MicroSiteBannerImages');
		$uploadField->setAllowedFileCategories('image');
		$uploadField->setAllowedMaxFileNumber(1);
		$uploadField->setFolderName('MicroSiteBannerImages');

		$field = new TextField('VideoURL','Video URL for Banner Button (please include https:// or http://)');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		$field = new TextField('TextColour','Colour for header text (in #000000 format)');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		$field = new TextareaField('Layout','Layout
				<br >You can use the following tags seperated by commas
				<br />[tiktok]
				<br />[carousel]
				<br />[pageslider]
				<br />[quotes]
				<br />[content]
				<br />[video]
				<br />[book]
				<br />[]
		');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		$field = new TextField('TiktokTitle','Tiktok Title');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		$field = new TextField('TiktokEmbededURL','TikTok Embedded URL (please include https:// or http://)');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		$CarouselOptions = array(0=>'Select a Carousel');
		$Carousels = Carousel::get();
		foreach($Carousels as $C)
		{
			$CarouselOptions[$C->ID] = $C->Title;

		}
		$field = new DropdownField('CarouselID','Carousel', $CarouselOptions, 'none');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		// $field = new CheckboxField('ShowPageSlider','Show Page Slider');
		// $fields->addFieldToTab('Root.Main', $field, 'Content');
		

		$field = new TextField('PageSliderTitle','Page Slider Title');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		$field = new TextareaField('EmbededVideoURL','Embedded Video URL from hosting site');
		$fields->addFieldToTab('Root.Main', $field, 'Content');

		// 'ShowPageSlider' => 'Boolean',
		// 'PageSliderTitle' => 'Varchar(255)'


		// $config = GridFieldConfig_RelationEditor::create();
		// $config->removeComponentsByType('GridFieldEditButton');
		// $config->removeComponentsByType('GridFieldAddNewButton');
		// $field = GridField::create('Related', 'Related Content', $this->Related(), $config);
		// $fields->addFieldToTab('Root.RelatedContent', $field);

		// $fields->addFieldToTab('Root.FreeTags', GridField::create(
		// 	'FreeTags', 'Free Tags', $this->FreeTags(), GridFieldConfig_RecordEditor::create()
		// ));

		// $field = new CheckboxField('ShowQuotes','Show Quote Box');
		// $fields->addFieldToTab('Root.Main', $field, 'Content');

		// $field = new UploadField('Documents','Documents',$this->Documents());
		// $field->setFolderName('documents');
		// $fields->addFieldToTab('Root.Documents', $field);

		// $field = new TextareaField('Intro','Introduction');
		// $fields->addFieldToTab('Root.Main', $field, 'Content');

		// $fields->addFieldToTab('Root.Media', GridField::create(
		// 	'Media','Media', $this->Media(), GridFieldConfig_RelationEditor::create()
		// ));

		return $fields;
	}

	protected function onBeforeWrite() {	
		parent::onBeforeWrite();

		$defaultTag = strtolower(preg_replace('/-/',' ',$this->URLSegment));
		Page::TagChecking($defaultTag, get_class());
	}

}
class MicroSite_Controller extends RoyalSocContent_Controller {

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
		'SliderContent',
		'BookForm'

	);


	public function BookForm()
	{
		$config = SiteConfig::current_site_config();
		$shipNZ = $config->ShipPriceNZ;
		$shipAUS = $config->ShipPriceAUS;
		$shipINTER = $config->ShipPriceINTER;
		$unitPrice = $config->BookPrice;

		$form = Form::create(
            $this,
            __FUNCTION__,
            FieldList::create(
                TextField::create('FirstName', 'First Name')->addExtraClass('required-field md-col-6')->setAttribute('required', true),
                TextField::create('LastName', 'Last Name')->addExtraClass('required-field md-col-6')->setAttribute('required', true),
                EmailField::create('EmailAddress', 'Email Address')->addExtraClass('required-field')->setAttribute('required', true),
                TextareaField::create('Address', 'Shipping Address')->addExtraClass('required-field')->setAttribute('required', true),
                CountryDropdownField::create('Shipping', 'Country','','NZ')->addExtraClass('required-field')->setAttribute('required', true),
                TextareaField::create('Comments', 'Additional Comments'),
                HiddenField::create('URlWeCameFrom', 'Field we will put the current link into')->setValue($this->Link()),
                HiddenField::create('UnitPrice', 'Price per unit')->setValue($unitPrice),
                HiddenField::create('ShipNZ', 'Price for NZ shipping')->setValue($shipNZ),
                HiddenField::create('ShipAUS', 'Price for AUS shipping')->setValue($shipAUS),
                HiddenField::create('shipINTER', 'Price for INTER shipping')->setValue($shipINTER),
                CheckboxField::create('QtyCheck', 'I would like to order multiple books')

            ),
            FieldList::create(
                FormAction::create('doSubmitBookForm','Submit Order')->addExtraClass('button')
            ),
            RequiredFields::create('Name','EmailAddress','Address')
        );


		$form->setTemplate('BookOrderForm');


        return $form;

	}

	public function doSubmitBookForm($data, $form)
	{


		//Session::set("FormData.{$form->getName()}.data", $data);

		//$form->sessionMessage('Thanks for your order!','good');

    	//uncomment below

	    $config = SiteConfig::current_site_config(); 
	    // include('../../dps/PxPay_Curl.inc.php');
	    include('../mysite/code/dps/PxPay_Curl.inc.php');

		// $PxPay_Url    = "https://sec.paymentexpress.com/pxpay/pxaccess.aspx";
		// $PxPay_Userid = "RoyalSocietyNZWeb";
		// $PxPay_Key    = "01897a5ba8d761caacb2b7e0a8dbf4d01c17c7a086c2435f426293fb4fa646a4";
        
        $PxPay_Url = $config->PaymentExpressURL;

        $PxPay_Userid = $config->PaymentExpressUserID;

        $PxPay_Key    = $config->PaymentExpressKey;

        $pxpay = new PxPay_Curl( $PxPay_Url, $PxPay_Userid, $PxPay_Key );

		$request = new PxPayRequest();

		$http_host   = getenv("HTTP_HOST");
		$request_uri = getenv("SCRIPT_NAME");
		$server_url  = "http://$http_host";
		$script_url  = "$server_url$request_uri"; //Using this code after PHP version 4.3.4
		//$script_url = (version_compare(PHP_VERSION, "4.3.4", ">=")) ?"$server_url$request_uri" : "$server_url/$request_uri";

		$pageURL = 'http';
		if (Director::protocol() == 'https')
		{
			$pageURL .= "s";
		}
		$pageURL .= "://";
		//$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		$pageURL .= $_SERVER["SERVER_NAME"].'/'.$data['URlWeCameFrom'];


		$script_url = $pageURL;

		$qtyChecker = $data['QtyCheck'];

		$ShipLocation = $data["Shipping"];
		if($ShipLocation == 'NZ'){
			$ShipPrice = $config->ShipPriceNZ;
		}
		else if($ShipLocation == 'AS'){
			$ShipPrice = $config->ShipPriceAUS;
		}
		else{
			$ShipPrice = $config->ShipPriceINTER;
		}
		
		$countriesArray = Zend_Locale::getTranslationList('territory');
		$countryName = $countriesArray[$data["Shipping"]];

		# the following variables are read from the form
		# $Quantity = $data["Amount"];
		$MerchantReference = 'book-'.$data["FirstName"].'-'.$data["LastName"].'-'.time();
		$fName = $data["FirstName"];
		$lName = $data["LastName"];
		$AddressLine = $data["Address"].'<br/>'.$countryName;
		$EmailAddress = $data["EmailAddress"];

		# $Address3 = $_REQUEST["Address3"];

		#Calculate AmountInput
		//$AmountInput = preg_replace('/$/','',$data["Amount"]);
        $AmountInput = $config->BookPrice; // has a dollar sign. this gateway accepts floats only not strings

        $RealAmount = $output  = floatval($AmountInput)+$ShipPrice;


		#Generate a unique identifier for the transaction
		$TxnId = uniqid("ID");

		#Set PxPay properties
		$request->setMerchantReference($MerchantReference);
		$request->setAmountInput($RealAmount);
		$request->setTxnData1($fName);
		$request->setTxnData2($lName);
		$request->setTxnData3($AddressLine);
		$request->setTxnType("Purchase");
		$request->setCurrencyInput("NZD");
		$request->setEmailAddress($EmailAddress);
		$request->setUrlFail($script_url);			# can be a dedicated failure page
		$request->setUrlSuccess($script_url);			# can be a dedicated success page
		$request->setTxnId($TxnId);

		#The following properties are not used in this case
		# $request->setEnableAddBillCard($EnableAddBillCard);
		# $request->setBillingId($BillingId);
		# $request->setOpt($Opt);

//

		#Call makeRequest function to obtain input XML
		$request_string = $pxpay->makeRequest($request);

		#Obtain output XML
		$response = new MifMessage($request_string);

		#Parse output XML
		$url = $response->get_element_text("URI");
		$valid = $response->get_attribute("valid");

		$othervalid = $valid;

		if($valid == 1 && $qtyChecker == null)
		{
			$order = BookOrders::create();
		    $order->FirstName = $fName;
		    $order->LastName = $lName;
		    $order->Address = $AddressLine;
		    $order->EmailAddress = $EmailAddress;
		    $order->TransactionID = $TxnId;
		    $order->OrderStatus = 'PaymentIncomplete';
		    $order->ShipmentStatus = 'Unsent';
		    $order->Comments = $data['Comments'];
		    $order->Quantity = '1';
		    $order->OrderCost = $RealAmount;
		    $order->GatewayResponse = 'Awaiting Gateway Response';
		    $order->write();
		    // $order->OrderStatus = 'returned payment!';
		    // $order->write();

			#Redirect to payment page
			header("Location: ".$url);
			die(); // This die needs to be here DON'T REMOVE
		}
		else if($qtyChecker == 1){

			$order = BookOrders::create();
		    $order->FirstName = $fName;
		    $order->LastName = $lName;
		    $order->Address = $AddressLine;
		    $order->EmailAddress = $EmailAddress;
		    $order->TransactionID = $TxnId;
		    $order->OrderStatus = 'RequestingMultiples';
		    $order->ShipmentStatus = 'Unsent';
		    $order->Comments = $data['Comments'];
		    $order->Quantity = 'TBC';
		    $order->OrderCost = $RealAmount;
		    $order->GatewayResponse = 'Awaiting Gateway Response';
		    $order->write();
		    $url = $this->Link('?multiplebooks=1&EmailAddress='.$EmailAddress.'&Name='.$fName.' '.$lName.'&TransactionID='.$TxnId);
		    // $order->OrderStatus = 'returned payment!';
		    // $order->write();
		    return $this->redirect($url);
			
		}
		else
		{

            $form->sessionMessage(var_export($othervalid,true));

			return $this->redirectBack();

		}

	    //uncomment above

    }



	public function init() {
		parent::init();
		// You can include any CSS or JS required by your project here.
		// See: http://doc.silverstripe.org/framework/en/reference/requirements
		Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/vendor/min/jquery3.1.1-min.js');
		Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/vendor/min/hammer-time-min.js');
		Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/vendor/min/jquery.bxslider.min.js');
		Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/vendor/min/modernizr-csscontent-transform-svg-min.js');
		Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/plugins.js');

		Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/microsite.js');
		Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/custom-slider.js');
		



		Requirements::css('themes/' . SSViewer::current_theme() . '/css/tweaks.css');
	}

	public function RenderMicroSite()

	{	

		
		

		$config = SiteConfig::current_site_config(); 
		//$book = BookDetails::get()->limit(1)->first();
		$inspectorGadget = explode(",", $this->Layout);
		$inspectorGadget = array_map('trim', $inspectorGadget);

		foreach ($inspectorGadget as $Gadget) {
		    if($Gadget == '[tiktok]'){
		    	$returnHtml .= '
		    	<div class="timeline widget-container first-widget lrg-col-6">
                <h3 class="widget-title">'.$this->TiktokTitle.'</h3>
                    <div class="embed-toki-html">
                        <iframe onmousewheel="" frameborder="0" style="border-width:0;" id="tl-timeline-iframe" height="380" src="'.$this->TiktokEmbededURL.'"></iframe>
                        <script type="text/javascript">
                        if (window.postMessage) {
                        var tlMouseupFunc = function() {
                        var tlFrame = document.getElementById("tl-timeline-iframe");
                        if (tlFrame.contentWindow && tlFrame.contentWindow.postMessage) {
                        tlFrame.contentWindow.postMessage("mouseup","*");
                        }
                        }
                        if (typeof window.addEventListener != "undefined") {
                        window.addEventListener("mouseup", tlMouseupFunc, false);
                        }
                        else if (typeof window.attachEvent != "undefined") {
                        window.attachEvent("onmouseup", tlMouseupFunc);
                        }
                        }
                        </script>
                    </div>
                </div>';
		    }
		    else if($Gadget == '[carousel]'){
		    	//$CarouselTitle = $this->CarouselImages();
		    	$returnHtml .= '
		    	<div class="image-library widget-container lrg-col-6">
                        <h3 class="widget-title">'.$this->CarouselTitle().'</h3>
                        <div class="bx-wrapper-relative">
                            <ul class="bxslider">
                              '.$this->CarouselImages().'
                            </ul>
                            <div class="outside">
                              <span id="slider-prev"></span>
                              <span id="slider-next"></span>
                            </div>
                            <div class="bx-textwrap">
                                <h4 class="slider-title"></h4>
                                <p class="slider-text"></p>
                            </div>
                        </div>

                    </div>';
		    }
		    else if($Gadget == '[pageslider]'){
		    	$returnHtml .= '
		    	<div class="view-slide-position lrg-col-6 widget-container">
                <h3 class="widget-title">'.$this->PageSliderTitle.'</h3>
                    <div class="micro-slide">
                        <div class="slide-container">
                            <div class="custom-slide-viewport">
                                <div class="custom-slide-container" id="custom-slide-id">
                                    <img src="/mysite/icons/royalloader.gif" class="sliderloader" />
                                    <div class="top-slide tablet-slide"></div>
                                    <div class="bottom-slide tablet-slide"></div>
                                    <span class="button-prev"></span>
                                    <span class="button-next"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
		    }
		    else if($Gadget == '[quotes]'){
		    	//Not sure how to get quote here.
		    	$Quote = Quotes::get()->sort('RAND()')->limit(1)->first();
		    	$returnHtml .= '
		    	<div class="quote widget-container lrg-col-6">
                        
                        <div class="quote-block">
                            <div class="quote-person">
                                <p class="quote-name">'.$Quote->Person.'</p>
                                <p class="quote-title">'.$Quote->Title.'</p>
                            </div>
                            <div class="quote-text">
                                <p>'.$Quote->Quote.'</p>
                            </div>
                        </div>
                        
                    </div>';		    	
		    }
		    else if($Gadget == '[content]'){
		    	$returnHtml .= '
		    	<div class="htmlContent widget-container content-container lrg-col-6">             
                      '.ShortcodeParser::get_active()->parse($this->Content).'         
                    </div>';
                    //  '.$this->Content.'
                    // '.ShortcodeParser::get_active()->parse($this->Content).'   
		    }
		    else if($Gadget == '[book]'){
		    	//Perhaps not cleanest way of getting image url, using template for all logic would be better.
		    	$bookID = $config->BookPhotoID;
				$bookImage = File::get()->byID($bookID);
				$bookImageURL = $bookImage->Filename;
				// $baseurl = $_SERVER['SERVER_NAME'];

		    	$returnHtml .= '
		    	<div class="book widget-container lrg-col-6">
			    	<h3 class="bookTitle widget-title">'.$config->BookTitle.'</h3>
			    	<p class="bookAuthor"><strong>By: '.$config->BookAuthor.'</strong></p><br/>
			    	<p class="bookImage"><img src="/'.$bookImageURL.'"/></p>
			    	<p class="bookIntro"><strong>'.$config->BookIntro.'</strong></p>
			    	<p class="bookBlurb">'.$config->BookBlurb.'</p>
			    	
			    	
			    	<div class="button-outer">
			            <div class="button">
			                <a href="#purchase" data-toggle="modal" data-target="#bookModal">
			                    Puchase Book
			                </a>
			            </div>
			        </div>
			    </div>';
			    //<p class="bookPrice"><strong>Book Price: </strong>$'.$config->BookPrice.'</p>
		    	
		    	
		    }
		    else if($Gadget == '[]')
		    {
		    	$returnHtml .= '<div class="empty widget-container content-container lrg-col-6"></div>';	
		    }
		    
		    else if($Gadget == '[video]'){
		    	$returnHtml .= '<div class="video widget-container content-container lrg-col-6"><div class="videowrapper">'.$this->EmbededVideoURL.'</div></div>';
		    }

		}
		return $returnHtml;


		// split on comma
		// for each recognised tag: $output.=  <% include XXXXX %>
		// return output

	}

	public function TextColour()
	{
		if($this->TextColour > '' && substr($this->TextColour,0,1) == '#')
		{
			return $this->TextColour;
		}
		return '#ffffff';
	}

	public function InsertTag()
	{
		$tag = $this->Tags()->filter(array('IsFixed'=>true))->first()->Tag;
		return '<input type="hidden" name="micrositetag" id="micrositetag" value="'.$tag.'" />';
	}

	public function SliderContent()
	{

		$tagname = $_POST['atype'];

		$output = '';

		$SliderPanels = new ArrayList();
		
		$tag = CoreTag::get()->filter(array('Tag'=>$tagname))->first();
		if($tag)
		{
			// $pages = $tag->Pages()->filter(array('ParentID'=>0))->filterAny('ClassName',array('Panel','Project','EventPanel','FundsOpportuntiesPanel','MedalsAwardsPanel','NewsPanel'));
			
			$pages = $tag->Pages()->filter(array('IsFixed'=>false));
			//$pages = $tag->Pages();

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
			
				$SliderPanels->push($data);	
				

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
				
			// 	$SliderPanels->push($data);
				
			// }

		}

		foreach($SliderPanels as $Panel)
		{
			$output .= $Panel->renderWith('_HomePageSlider');
		}
		return $output;
	}

	public function Carousel()
	{
		if($this->CarouselID > 0)
		{
			return true;
		}
		return null;
	}

	public function CarouselTitle()
	{
		return Carousel::get()->byID($this->CarouselID)->Title;
	}

	public function CarouselImages()
	{
		$output = '';
		$sliders = new ArrayList();
		$CID = Carousel::get()->byID($this->CarouselID)->ID;
		$Images = CarouselImage::get()->filter(array('CarouselID'=>$CID));
		foreach($Images as $image)
		{
			$data = ArrayData::create(array(
				'Title' => $image->Title,
				'Caption' => $image->Caption,
				'Image' => $image->Image()
			));
			$sliders->push($data);
		}
		foreach($sliders as $slide)
		{
			$output .= $slide->renderWith('_Carousel');
		}
		return $output;
	}

}