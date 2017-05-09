<?php

class Page extends SiteTree
{

    private static $db = array();

    private static $has_one = array();

    private static $many_many = array(
        'Tags' => 'CoreTag',
    );

    private static $many_many_extraFields = array(
        'Tags' => array(
            'IsFixed' => 'Boolean(false)',
            'IsFromParent' => 'Boolean(false)'
        )
    );

    private static $defaults = array(
        'ShowInMenus' => false
    );

    public function ClipText($title, $text)
    {
        if (strlen($title . $text) > 100) {
            $limit = 90 - strlen($title) - 3;
            $text = substr($text, 0, $limit) . '...';
        }
        return $text;
    }

    public function TagChecking($defaultTag, $class = null)
    {

        $existingTags = $this->Tags();

        $onlyAudienceTag = $this->OnlyAudienceTag($existingTags);

        if ($class == 'Panel' || $class == 'Project' || $class == 'EventPanel' || $class == 'FundsandOpportuntiesPanel' || $class == 'MedalsAwardsPanel' || $class == 'MicroSite') {

            if (count($existingTags) == 0 || $onlyAudienceTag) {

                // check if tag already exists
                $checkTag = CoreTag::get()->filter(array('Tag' => $defaultTag))->first();
                if ($checkTag) {
                    $this->Tags()->add($checkTag, ['IsFixed' => true]);
                } else {
                    $mainTag = CoreTag::create();
                    $mainTag->Tag = $defaultTag;
                    $mainTag->write();
                    $this->Tags()->add($mainTag, ['IsFixed' => true]);
                }

            }

            $audience = false;
            foreach ($existingTags as $tag) {
                if (substr($tag->Tag, 0, 9) == 'audience:') $audience = true;
                if ($tag->IsFixed == 1 && $tag->IsFromParent == 0) {
                    if ($tag->Tag != $defaultTag) //changing default tag
                    {
                        $oldTag = $tag->Tag;

                        $tag->Tag = $defaultTag;
                        $tag->write();

                        $this->updatePromoteTag($oldTag, $defaultTag);
                    }

                }
            }
            if (!$audience) {
                $audienceAll = CoreTag::get()->filter(array('Tag' => 'audience:all'))->first();
                $this->Tags()->add($audienceAll);
            }

            $this->createPromoteTag($class, $defaultTag);


        } else {

            $audience = false;
            foreach ($existingTags as $tag) {
                if (substr($tag->Tag, 0, 9) == 'audience:') $audience = true;
            }
            if (!$audience) {
                $audienceAll = CoreTag::get()->filter(array('Tag' => 'audience:all'))->first();
                $this->Tags()->add($audienceAll);
            }
        }

        $this->checkPromoteTags($existingTags, $this->ID);

    }

    private function createPromoteTag($class, $defaultTag)
    {
        if ($class == 'Panel' || $class == 'Project' || $class == 'EventPanel' || $class == 'FundsandOpportuntiesPanel' || $class == 'MedalsAwardsPanel') {
            $promoteTag = 'promote:' . $defaultTag;
            $checkTag = CoreTag::get()->filter(array('Tag' => $promoteTag))->first();
            if (!$checkTag) {
                $newTag = CoreTag::create();
                $newTag->Tag = $promoteTag;
                $newTag->IsSystem = 1;
                $newTag->write();
            }
        }
    }

    private function OnlyAudienceTag($existingTags)
    {
        if (count($existingTags) == 1) {
            if (substr($existingTags[0]->Tag, 0, 9) == 'audience:') {
                return true;
            }
        }
        return false;
    }

    public function updatePromoteTag($oldtag, $newtag)
    {
        $OldPromoteTag = 'promote:' . $oldtag;
        $NewPromoteTag = 'promote:' . $newtag;
        $tag = CoreTag::get()->filter(array('Tag' => $OldPromoteTag))->first();
        if ($tag) {
            $tag->Tag = $NewPromoteTag;
            $tag->write();
        }

    }

    private function checkPromoteTags($existingTags, $ID)
    {
        foreach ($existingTags as $tag) {
            if (substr($tag->Tag, 0, 8) == 'promote:') {
                DB::prepared_query('DELETE FROM "Page_Tags" WHERE "Page_Tags"."CoreTagID" = ? AND "Page_Tags"."PageID" <> ?', array($tag->ID, $ID));
            }
            if (strpos($tag->Tag, ':box') || strpos($tag->Tag, ':item')) {
                DB::prepared_query('DELETE FROM "Page_Tags" WHERE "Page_Tags"."CoreTagID" = ? AND "Page_Tags"."PageID" <> ?', array($tag->ID, $ID));
            }
        }
    }

    public function FindHeroImage($force = null)
    {
        $PanelClasses = array(
            'Panel',
            'Project',
            'EventPanel',
            'FundsOpportunitiesPanel',
            'MedalsAwardsPanel',
            'NewsPanel',
            'ResearchPanel'
        );

        if ($this->HeroImage()->exists()) {
            return $this->HeroImage();
        } else {
            if ($force == 'Image') {

                $folder = Folder::find('assets/defaultImages');
                $file = File::get()->filter(array('ParentID'=>$folder->ID))->sort('RAND()')->first();

                if ($file) {
                    return $file;
                }
            } else {
                if (in_array($this->getClassName(), $PanelClasses)) {

                    $folder = Folder::find('assets/defaultBanners');
                    $file = File::get()->filter(array('ParentID'=>$folder->ID))->sort('RAND()')->first();

                    if ($file) {
                        return $file;
                    }
                } else {

                    $folder = Folder::find('assets/defaultImages');
                    $file = File::get()->filter(array('ParentID'=>$folder->ID))->sort('RAND()')->first();

                    if ($file) {
                        return $file;
                    }
                }
            }
        }

    }

    public function genAudience()
    {
        $audience = array('curious', 'researcher', 'student-teacher');
        $key = rand(0, 2);
        return $audience[$key];
    }

}

class Page_Controller extends ContentController
{

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
    private static $allowed_actions = array(
        'DonateForm',
        'ContactForm',
        'HireForm',
        'MembershipForm',
        'RoyalSearchForm',
        'goSearch',
        'BookForm',
        'frontEndEventForm',
        'updateFeEventData',
        'doFrontEndEvent'

    );

    public function RoyalBreadCrumbs()
    {
        return SiteTree::Breadcrumbs(20, false, false, true);
    }

    public function FacilitiesPageURL()
    {
        $Home = Page::get()->filter(array('URLSegment' => 'home'))->first();
        $FacilitiesPage = Page::get()->byID($Home->FacilitiesPageID);
        if ($FacilitiesPage) {
            return $FacilitiesPage->Link();
        }
    }

    public function JoinUsPageURL()
    {
        $Home = Page::get()->filter(array('URLSegment' => 'home'))->first();
        $JoinUsPage = Page::get()->byID($Home->JoinUsPageID);
        if ($JoinUsPage) {
            return $JoinUsPage->Link();
        }
    }

    public function AnniversaryPageURL()
    {
        $Home = Page::get()->filter(array('URLSegment' => 'home'))->first();
        $AnniversaryPage = Page::get()->byID($Home->AnniversaryPageID);
        if ($AnniversaryPage) {
            return $AnniversaryPage->Link();
        }
    }

    public function VacanciesPageURL()
    {
        $Home = Page::get()->filter(array('URLSegment' => 'home'))->first();
        $VacanciesPage = Page::get()->byID($Home->VacanciesPageID);
        if ($VacanciesPage) {
            return $VacanciesPage->Link();
        }
    }

    public function AboutUsPageURL()
    {
        $Home = Page::get()->filter(array('URLSegment' => 'home'))->first();
        $AboutUsPage = Page::get()->byID($Home->AboutUsID);
        if ($AboutUsPage) {
            return $AboutUsPage->Link();
        }
    }

    public function NewslettersSignUpURL()
    {
        $Home = Page::get()->filter(array('URLSegment' => 'home'))->first();
        $NewslettersSignUpPage = Page::get()->byID($Home->NewslettersSignUpPageID);
        if ($NewslettersSignUpPage) {
            return $NewslettersSignUpPage->Link();
        }
    }

    public function Menu()
    {
        // $Home = Page::get()->filter(array('URLSegment'=>'home'))->first();
        // $output = '<li class="parent md-col-6 lrg-col-4"><a class="inactive" href="'.$Home->Link().'">'.$Home->MenuTitle.'</a>
        // 				<div class="arrow-container">
        // 									<span class="arrow-head"></span>
        // 									<span class="arrow-line"></span>
        // 								</div>
        // 			</li>';
        $TopLevel = Page::get()->filter(array('ShowInMenus' => 1, 'ParentID' => 0));
        foreach ($TopLevel as $Page) {
            $output .= '<li class="parent md-col-6 lrg-col-4"><a class="inactive" href="' . $Page->Link() . '">' . $Page->MenuTitle . '</a>';
            $output .= '<div class="arrow-container">
							<span class="arrow-head"></span>
							<span class="arrow-line"></span>
						</div>';
            $addedPages = array();
            $NextLevel = Page::get()->filter(array('ShowInMenus' => 1, 'ParentID' => $Page->ID));
            if (count($NextLevel) > 0) {
                $output .= '<ul class="children">';
                foreach ($NextLevel as $SubPage) {
                    if (!in_array($SubPage->ID, $addedPages)) {
                        $addedPages[] = $SubPage->ID;
                        $output .= '<li class="child"><a href="' . $SubPage->Link() . '">' . $SubPage->MenuTitle . '</a></li>';
                    }
                }
                $output .= '</ul>';
            }

            // get items tagged with the top level tag
            $topLevelTag = $Page->Tags()->filter(array('IsFixed' => 1))->first();
            if ($topLevelTag) {
                $NextLevel = $topLevelTag->Pages()->exclude('ID', $Page->ID)->filter(array('ShowInMenus' => 1));
                if (count($NextLevel) > 0) {
                    $output .= '<ul class="children">';
                    foreach ($NextLevel as $SubPage) {
                        if (!in_array($SubPage->ID, $addedPages)) {
                            $addedPages[] = $SubPage->ID;
                            $output .= '<li class="child"><a href="' . $SubPage->Link() . '">' . $SubPage->MenuTitle . '</a></li>';
                        }
                    }
                    $output .= '</ul>';
                }
            }


            $output .= '</li>';
        }
        return $output;
    }


    public function init()
    {
        parent::init();
        // You can include any CSS or JS required by your project here.
        // See: http://doc.silverstripe.org/framework/en/reference/requirements
        Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/vendor/min/jquery3.1.1-min.js');
        Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/vendor/min/modernizr-csscontent-transform-svg-min.js');
        Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/plugins.js');
        Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/vendor/min/bootstrap-modal.min.js');
        Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/main.js');
        Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/medal-search.js');
        Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/field-research-calculator.js');
        Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/socio-economic-calculator.js');

        Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/vendor/min/hammer-time-min.js');

        Requirements::css('themes/' . SSViewer::current_theme() . '/css/tweaks.css');

        //Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/share-this.js');
        //::javascript('themes/' . SSViewer::current_theme() . '/js/createFrontEndEvent.js');
        Requirements::javascript('themes/' . SSViewer::current_theme() . '/js/events-panel-filter.js');


        if ($_SERVER['QUERY_STRING']) {

            parse_str($_SERVER['QUERY_STRING'], $output);

            if (isset($output['result']) && isset($output['userid'])) {
                $paymentSecret = $output['result'];
                $paymentUserID = $output['userid'];

                $this->doGateWayPaymentResponse();
            }
            if (isset($output['multiplebooks'])) {
                $multiBookEmail = $output['EmailAddress'];
                $multiBookCustName = $output['Name'];
                $multiTransactionID = $output['TransactionID'];
                $this->notifyMultiBook($multiBookEmail, $multiBookCustName, $multiTransactionID);
            }

        }


    }

    public function notifyMultiBook($email, $bookCustName, $multiTransactionID)
    {
        $config = SiteConfig::current_site_config();
        $order = BookOrders::get()->filter(array('TransactionID' => $multiTransactionID))->first();
        $orderID = $order->ID;
        $data = ArrayData::create(array(
            'FormUsed' => 'book',
            'MultiBook' => 'true',
            'EmailAddress' => $email,
            'Name' => $bookCustName,
            'OrderID' => $orderID
        ));
        if ($order->GatewayResponse == 'Awaiting Gateway Response') {
            $order->GatewayResponse = 'Gateway Response Complete';
            $order->write();


            if ($config->BookOrderNotificationEmail > '') {

                $email = Email::create();

                $email->setTo($config->BookOrderNotificationEmail);
                $email->setFrom('no-reply@royalsociety.org.nz');

                $email->setSubject('Multi Book Order Request - ' . $order->ID);
                $email->setBody(
                    $bookCustName . ' has a request to purchase multiple copies of ' . $config->BookTitle . '<br/><br/>
		        	<h3>' . $bookCustName . ' can be contacted via their details below:</h3>
		        	<table>
						<tr>
							<td>Fullname:</td>
							<td>' . $bookCustName . '</td>
						</tr>
						<tr>
							<td>Postal Address:</td>
							<td>' . $order->Address . '</td>
						</tr>
						<tr>
							<td>Email Address:</td>
							<td>' . $order->EmailAddress . '</td>
						</tr>
					</table>
						
		        	<h3>Order request information is listed below:</h3>
		        	<table>
						<tr>
							<td>Comments:</td>
							<td>' . $order->Comments . '</td>
						</tr>
						<tr>
							<td>Order Number:</td>
							<td>' . $order->ID . '</td>
						</tr>
						<tr>
							<td>Transaction ID:</td>
							<td>' . $order->TransactionID . '</td>
						</tr>
					</table>
		        	<br/><br/>
					<strong>Note: </strong> You can see the status and full details of the request here: <a href="/admin/orderbook/BookOrders/EditForm/field/BookOrders/item/' . $order->ID . '/edit">Update request for ' . $bookCustName . '</a>'

                );

                $email->send();
            }

        }

        echo $data->renderWith('PaymentSuccess');
    }

    public function doGateWayPaymentResponse()
    {
        include('dps/PxPay_Curl.inc.php');

        $config = SiteConfig::current_site_config();

        //$PxPay_Url    = "https://sec.paymentexpress.com/pxpay/pxaccess.aspx";
        //$PxPay_Userid = "RoyalSocietyNZWeb";
        //$PxPay_Key    = "01897a5ba8d761caacb2b7e0a8dbf4d01c17c7a086c2435f426293fb4fa646a4";

        $PxPay_Url = $config->PaymentExpressURL;

        $PxPay_Userid = $config->PaymentExpressUserID;

        $PxPay_Key = $config->PaymentExpressKey;

        $pxpay = new PxPay_Curl($PxPay_Url, $PxPay_Userid, $PxPay_Key);

        $enc_hex = $_REQUEST["result"];

        $rsp = $pxpay->getResponse($enc_hex);
        $formUsedArr = explode('-', $rsp->getMerchantReference());
        $formUsed = $formUsedArr[0];


        $Success = $rsp->getSuccess();
        $AmountSettlement = $rsp->getAmountSettlement();
        $AuthCode = $rsp->getAuthCode();  # from bank
        $CardName = $rsp->getCardName();  # e.g. "Visa"
        $CardNumber = $rsp->getCardNumber(); # Truncated card number
        $DateExpiry = $rsp->getDateExpiry(); # in mmyy format
        $DpsBillingId = $rsp->getDpsBillingId();
        $BillingId = $rsp->getBillingId();
        $CardHolderName = $rsp->getCardHolderName();
        $DpsTxnRef = $rsp->getDpsTxnRef();
        $TxnType = $rsp->getTxnType();
        $TxnData1 = $rsp->getTxnData1();
        $TxnData2 = $rsp->getTxnData2();
        $TxnData3 = $rsp->getTxnData3();
        $CurrencySettlement = $rsp->getCurrencySettlement();
        $ClientInfo = $rsp->getClientInfo(); # The IP address of the user who submitted the transaction
        $TxnId = $rsp->getTxnId();
        $CurrencyInput = $rsp->getCurrencyInput();
        $EmailAddress = $rsp->getEmailAddress();
        $MerchantReference = $rsp->getMerchantReference();
        $ResponseText = $rsp->getResponseText();
        $TxnMac = $rsp->getTxnMac(); # An indication as to the uniqueness of a card used in relation to others

        $data = ArrayData::create(array(
            'PaymentSuccess' => $Success,
            'Amount' => $AmountSettlement,
            'AuthCode' => $AuthCode,
            'CardName' => $CardName,
            'CardNumber' => $CardNumber,
            'DateExpiry' => $DateExpiry,
            'DpsBillingId' => $DpsBillingId,
            'CardHolderName' => $CardHolderName,
            'DpsTxnRef' => $DpsTxnRef,
            'TxnType' => $TxnType,
            'TxnData1' => $TxnData1,
            'TxnData2' => $TxnData2,
            'TxnData3' => $TxnData3,
            'CurrencySettlement' => $CurrencySettlement,
            'ClientInfo' => $ClientInfo,
            'TxnId' => $TxnId,
            'CurrencyInput' => $CurrencyInput,
            'EmailAddress' => $EmailAddress,
            'MerchantReference' => $MerchantReference,
            'ResponseText' => $ResponseText,
            'TxnMac' => $TxnMac,
            'FormUsed' => $formUsed
        ));


        if ($formUsed == 'book') {


            if ($rsp->getSuccess() == "1") {
                $order = BookOrders::get()->filter(array('TransactionID' => $TxnId))->first();
                if ($order->GatewayResponse == 'Awaiting Gateway Response') {
                    $order->GatewayResponse = 'Gateway Response Complete';
                    $order->OrderStatus = 'PaymentComplete';
                    $order->write();

                    $result = "The transaction was approved.";
                    //Merchant Email
                    if ($config->BookOrderNotificationEmail > '') {

                        $email = Email::create();

                        $email->setTo($config->BookOrderNotificationEmail);
                        $email->setFrom('no-reply@royalsociety.org.nz');

                        $email->setSubject('Book Order Confirmed');
                        $email->setBody(
                            $order->FirstName . ' ' . $order->LastName . ' has purchased ' . $config->BookTitle . ' for $' . $AmountSettlement . '<br/><br/>
				        	<h3>The shipment and customer details are listed below:</h3>
				        	<table>
								<tr>
									<td>Fullname:</td>
									<td>' . $order->FirstName . ' ' . $order->LastName . '</td>
								</tr>
								<tr>
									<td>Postal Address:</td>
									<td>' . $order->Address . '</td>
								</tr>
								<tr>
									<td>Email Address:</td>
									<td>' . $order->EmailAddress . '</td>
								</tr>
								<tr>
									<td>Comments:</td>
									<td>' . $order->Comments . '</td>
								</tr>
				        	</table>
				        	<br/><br/>
				        	<h3>The order details are listed below:</h3>
				        	<table>
								<tr>
									<td>Item Ordered:</td>
									<td>' . $config->BookTitle . '</td>
								</tr>
								<tr>
									<td>Quantity Ordered:</td>
									<td>' . $order->Quantity . '</td>
								</tr>
								<tr>
									<td>Unit Price:</td>
									<td>$' . $config->BookPrice . '</td>
								</tr>
								<tr>
									<td>Amount Paid (Including Shipping):</td>
									<td>$' . $AmountSettlement . '</td>
								</tr>
								<tr>
									<td>Order ID:</td>
									<td>' . $order->ID . '</td>
								</tr>
				        	</table>
				        	<br/><br/>
							<strong>Note: </strong> Dont forget to update the shipping status for this order here: <a href="/admin/orderbook/BookOrders/EditForm/field/BookOrders/item/' . $order->ID . '/edit">Update order status for ' . $order->FirstName . ' ' . $order->LastName . '</a>'

                        );

                        $email->send();
                    }
                    //Customer Email
                    if ($EmailAddress > '') {

                        $email = Email::create();

                        $email->setTo($EmailAddress);
                        $email->setFrom('no-reply@royalsociety.org.nz');

                        $email->setSubject('Book Order Confirmed');
                        $email->setBody(
                            'Thank you ' . $order->FirstName . ' ' . $order->LastName . ' for purchasing ' . $config->BookTitle . ' for $' . $AmountSettlement . ' from (<a href="/">Royal Society NZ</a>) <br/><br/>
				        	<h3>The shipment and customer details provided to the merchant are listed below:</h3>
				        	<table>
								<tr>
									<td>Fullname:</td>
									<td>' . $order->FirstName . ' ' . $order->LastName . '</td>
								</tr>
								<tr>
									<td>Postal Address:</td>
									<td>' . $order->Address . '</td>
								</tr>
								<tr>
									<td>Email Address:</td>
									<td>' . $order->EmailAddress . '</td>
								</tr>
								<tr>
									<td>Comments:</td>
									<td>' . $order->Comments . '</td>
								</tr>
				        	</table>
				        	<br/><br/>
				        	<h3>The order details are listed below:</h3>
				        	<table>
								<tr>
									<td>Item Ordered:</td>
									<td>' . $config->BookTitle . '</td>
								</tr>
								<tr>
									<td>Quantity Ordered:</td>
									<td>' . $order->Quantity . '</td>
								</tr>
								<tr>
									<td>Unit Price:</td>
									<td>$' . $config->BookPrice . '</td>
								</tr>
								<tr>
									<td>Amount Paid (Including Shipping):</td>
									<td>$' . $AmountSettlement . '</td>
								</tr>
								<tr>
									<td>Order ID:</td>
									<td>' . $order->ID . '</td>
								</tr>
				        	</table>
				        	<br/><br/>
							<strong>Note: </strong> If you have any concerns with the order information, please do not hesitate to contact RSNZ:<br/>
							<strong>Email: <a href="mailto:' . $config->BookOrderNotificationEmail . '?subject=Customer enquiry - ' . $order->ID . ' - ' . $config->BookTitle . ' ">' . $config->BookOrderNotificationEmail . '</a><br/></strong>
							<strong>Phone: <a href="tel:' . $config->BookOrderContactNumber . '">' . $config->BookOrderContactNumber . '</a></strong>'

                        );

                        $email->send();
                    }
                }


            } else {
                $result = "The transaction was declined.";
            }

        } else if ($formUsed == 'donate') {


            if ($rsp->getSuccess() == "1") {
                $result = "The transaction was approved.";
                if ($config->DonationNotificationEmail > '') {
                    $email = Email::create();

                    $email->setTo($config->DonationNotificationEmail);
                    $email->setFrom('no-reply@royalsociety.org.nz');

                    $email->setSubject('Donation Made');
                    $email->setBody('A donation of ' . $rsp->getAmountSettlement() . ' has been made from ' . $rsp->getCardName());

                    $email->send();
                }
            } else {
                $result = "The transaction was declined.";
            }
        }


        echo $data->renderWith('PaymentSuccess');

    }

    public function Fellows()
    {
        $url = 'http://mercuryit7.test.mercuryit.co.nz/api/members';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $raw = curl_exec($curl);
        $result = json_decode($raw);

        $output = '';

        //<img src="'.$this->renderImage($fellow->Image).'" />
        $count = 0;
        foreach ($result as $fellow) {

            $output .= '<hr />';
            foreach ($fellow as $k => $v) {
                $output .= '[' . $k . '] ' . $v . '<br />';
            }

            //$output .= '<div><img src="data:image/png;base64,'.$fellow->Image.'" height="158px" width="130px" />'.$fellow->FullName.' ('.$fellow->Qualifications.')<div>';
            $count++;
        }

        return 'Count: ' . $count . '<br />' . $output;

    }

    public function Individual()
    {
        $id = 2401;

        $url = 'http://mercuryit7.test.mercuryit.co.nz/api/members/' . $id;

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $raw = curl_exec($curl);
        $result = json_decode($raw);

        $output = '<div><img src="data:image/png;base64,' . $result->Image . '" height="158px" width="130px" /></div>';

        foreach ($result as $k => $v) {
            if ($k == 'Image') {
                // do nothing
            } else {
                $output .= '<div><strong>' . $k . ':</strong> ' . $v . '<div>';
            }
        }

        return $output;
    }

    private $dpsresponse = null;

    public function DonateForm()
    {

        $fields = new FieldList(
            TextField::create('FirstName', 'First Name')->setAttribute('required', true)->addExtraClass('required-field'), // make required
            TextField::create('LastName', 'Last Name')->setAttribute('required', true)->addExtraClass('required-field'), // make required
            EmailField::create('Email', 'Email Address')->setAttribute('required', true)->addExtraClass('required-field'),
            TextField::create('Phone', 'Phone Number')->setAttribute('required', true)->addExtraClass('required-field'),
            CurrencyField::create('Amount', 'Amount')->setAttribute('required', true)->setAttribute('min', 3)->addExtraClass('required-field'), // make required
            CheckboxField::create('ContactBequest', 'I would like someone to contact me about making a bequest in a will.'),
            HiddenField::create('URlWeCameFrom', 'Field we will put the current link into')->setValue($this->Link())
        );

        $actions = new FieldList(
            FormAction::create('doSubmitDonateForm')->setTitle('Donate')->addExtraClass('button'),
            ResetFormAction::create('')->setTitle('Clear Form')->addExtraClass('button')
        );

        $required = new RequiredFields(array(
            'FirstName', 'LastName'
        ));

        $form = new Form($this, 'DonateForm', $fields, $actions, $required);

        if ($this->dpsresponse == 'good') {
            $form->sessionMessage('Thank you for your donation.');
        } elseif ($this->dpsresponse == 'bad') {
            $form->sessionMessage('Sorry there was a problem processing your donation.');
        }
        $form->setTemplate('DonationForm');

        $data = Session::get("FormData.{$form->getName()}.data");

        return $data ? $form->loadDataFrom($data) : $form;

        //return $form;

    }

    public function doSubmitDonateForm($data, $form)
    {

        Session::set("FormData.{$form->getName()}.data", $data);

        $config = SiteConfig::current_site_config();

        if ($data['ContactBequest'] == true) {
            if ($config->DonationNotificationEmail > '') {
                $email = Email::create();

                $email->setTo($config->DonationNotificationEmail);
                $email->setFrom('no-reply@royalsociety.org.nz');

                $email->setSubject('Bequest Request');

                $message = $data['FirstName'] . ' ' . $data['LastName'] . ' has requested they be contacted about making a bequest. Their details are:<br />
					Email: ' . $data['Email'] . '
					Phone: ' . $data['Phone'];

                $email->setBody($message);

                $email->send();
            }
        }

        $CheckRealAmount = $output = floatval(ltrim($data["Amount"], '$'));
        $checkEmail = $data["Email"];

        if ($CheckRealAmount < .01) {
            $form->addErrorMessage('Amount', 'Amount cannot be $0', 'bad-amount');

            return $this->redirectBack();
        }

//        if (strpos($checkEmail, '@') !== true) {
//            $form->addErrorMessage('Email', 'Email field must be a valid email address', 'bad-amount');
//
//            return $this->redirectBack();
//        }

        Session::clear("FormData.{$form->getName()}.data");
        //include('mysite/code/dps/PxPay_Curl.inc.php');
        include('dps/PxPay_Curl.inc.php');

        //$PxPay_Url    = "https://sec.paymentexpress.com/pxpay/pxaccess.aspx";
        //$PxPay_Userid = "RoyalSocietyNZWeb";
        //$PxPay_Key    = "01897a5ba8d761caacb2b7e0a8dbf4d01c17c7a086c2435f426293fb4fa646a4";

        $PxPay_Url = $config->PaymentExpressURL;

        $PxPay_Userid = $config->PaymentExpressUserID;

        $PxPay_Key = $config->PaymentExpressKey;

        $pxpay = new PxPay_Curl($PxPay_Url, $PxPay_Userid, $PxPay_Key);

        $request = new PxPayRequest();

        $http_host = getenv("HTTP_HOST");
        $request_uri = getenv("SCRIPT_NAME");
        $server_url = "http://$http_host";
        $script_url = "$server_url$request_uri"; //Using this code after PHP version 4.3.4
        //$script_url = (version_compare(PHP_VERSION, "4.3.4", ">=")) ?"$server_url$request_uri" : "$server_url/$request_uri";

        $pageURL = 'http';
        if (Director::protocol() == 'https') {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        //$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        $pageURL .= $_SERVER["SERVER_NAME"] . '/' . $data['URlWeCameFrom'];


        $script_url = $pageURL;


        # the following variables are read from the form
        # $Quantity = $data["Amount"];
        $MerchantReference = 'donate-' . $data["FirstName"] . '-' . $data["LastName"] . '-' . time();
        $Address1 = $data["FirstName"];
        $Address2 = $data["LastName"];
        # $Address3 = $_REQUEST["Address3"];

        #Calculate AmountInput
        //$AmountInput = preg_replace('/$/','',$data["Amount"]);
        $AmountInput = $data["Amount"]; // has a dollar sign. this gateway accepts floats only not strings
        $RealAmount = $output = floatval(ltrim($data["Amount"], '$'));

        #Generate a unique identifier for the transaction
        $TxnId = uniqid("ID");

        #Set PxPay properties
        $request->setMerchantReference($MerchantReference);
        $request->setAmountInput($RealAmount);
        $request->setTxnData1($Address1);
        $request->setTxnData2($Address2);
        #$request->setTxnData3($Address3);
        $request->setTxnType("Purchase");
        $request->setCurrencyInput("NZD");
        $request->setEmailAddress("hugh.wicks@samdog.nz");
        $request->setUrlFail($script_url);            # can be a dedicated failure page
        $request->setUrlSuccess($script_url);            # can be a dedicated success page
        $request->setTxnId($TxnId);

        #The following properties are not used in this case
        # $request->setEnableAddBillCard($EnableAddBillCard);
        # $request->setBillingId($BillingId);
        # $request->setOpt($Opt);

//

        #Call makeRequest function to obtain input XML
        $request_string = $pxpay->makeRequest($request);

        error_log(var_export($request_string, true));

        #Obtain output XML
        $response = new MifMessage($request_string);

        #Parse output XML
        $url = $response->get_element_text("URI");
        $valid = $response->get_attribute("valid");

        error_log(var_export($valid, true));

        $othervalid = $valid;

        if ($valid == 1) {
            #Redirect to payment page
            header("Location: " . $url);
            die(); // This die needs to be here DON'T REMOVE
        } else {

            //$form->sessionMessage(var_export($othervalid, true));

            return $this->redirectBack();

        }

    }


    //Book Form


    //forms

    /** v CONTACT FORM v **/
    public function ContactForm()
    {
        $fields = new FieldList(

            TextField::create('FirstName')->addExtraClass('fn')->setAttribute('placeholder', 'First Name')->setAttribute('required', true)->addExtraClass('required-field'),
            TextField::create('LastName')->addExtraClass('ln')->setAttribute('placeholder', 'Last Name')->setAttribute('required', true)->addExtraClass('required-field'),
            EmailField::create('Email')->addExtraClass('em')->setAttribute('placeholder', 'Email address')->setAttribute('required', true)->addExtraClass('required-field'),
            DropdownField::create('TopicSelect', 'Select Topic..',
                Topic::get()->map('Email', 'Title')->toArray()
            ),
            TextareaField::create('Message')->addExtraClass('mg')->setAttribute('placeholder', 'Your message...')->setAttribute('required', true)->addExtraClass('required-field')
        );
        $actions = new FieldList(
            FormAction::create('submitContact')->setTitle('Send')->addExtraClass('button'),
            ResetFormAction::create('')->setTitle('Clear Form')->addExtraClass('button')
        );


        $form = new Form($this, 'ContactForm', $fields, $actions);
        $form->setTemplate('CustomContactFormModal');

        return $form;
    }

    //
    public function submitContact($data, $form)
    {
        //Set confirmation text to field above.
        $successContent = 'Email content below: <br/>';

        $topic = Topic::get()->filter(array(
            'Email' => $data['TopicSelect']
        ));

        $topicFirst = $topic->first();


        //Contruct form data for recipient
        $formDataSubmission = '
			<table>
				<tbody>
				<tr>
					<td>Firstname:	</td> 
					<td>' . $data['FirstName'] . '</td>
				</tr>
				<tr>
					<td>Lastname:	</td>
					<td>' . $data['LastName'] . '</td>
				</tr>
				<tr>
					<td>Email:	</td>
					<td>' . $data['Email'] . '</td>
				</tr>
				<tr>
					<td>Topic:	</td>
					<td>' . $topicFirst->Title . '</td>
				</tr>
				<tr>
					<td>Message:	</td>
					<td>' . $data['Message'] . '</td>
				</tr>


				</tbody>
			</table>';
        $successContent .= $formDataSubmission;


        $email = new Email($topicFirst->Email, 'Contact form submission', $successContent);


        if (!$email->send()) {
            $content = 'There was a problem sending your data, please resubmit the form.';

        }
        return array(
            'Content' => 'CONTACT EMAIL SENT!',
            'Form' => ''
        );
    }

    /** ^ CONTACT FORM ^ **/


    /** v Hire FORM v **/
    public function HireForm()
    {
        $fields = new FieldList(

            TextField::create('FirstName')->addExtraClass('fn')->setAttribute('placeholder', 'First Name..')->setAttribute('required', true)->addExtraClass('required-field'),
            TextField::create('LastName')->addExtraClass('ln')->setAttribute('placeholder', 'Last Name..')->setAttribute('required', true)->addExtraClass('required-field'),
            EmailField::create('Email')->addExtraClass('em')->setAttribute('placeholder', 'Email address..')->setAttribute('required', true)->addExtraClass('required-field'),
            LiteralField::create('HireDateLabel', '<label class="left">Booking Day</label>'),
            DatetimeField::create('HireDate', 'Hire Date')->getDateField()->setConfig('showcalendar', true)->setAttribute('placeholder', 'Select booking day..')->setAttribute('required', true)->addExtraClass('required-field'),
            LiteralField::create('HireTimeLabel', '<label class="left">Booking Time</label>'),
            DatetimeField::create('HireTime', 'Hire Time')->getTimeField()->setconfig('use_strtotime', true)->setAttribute('placeholder', 'Enter booking time..')->setAttribute('required', true)->addExtraClass('required-field'),
            TextField::create('Duration')->addExtraClass('dr')->setAttribute('placeholder', 'BookingDuration')->setAttribute('required', true)->addExtraClass('required-field'),
            TextField::create('Organisation')->addExtraClass('org')->setAttribute('placeholder', 'Your organisation..')->setAttribute('required', true)->addExtraClass('required-field'),
            TextareaField::create('BookingReason')->addExtraClass('br')->setAttribute('placeholder', 'Reason for booking..')->setAttribute('required', true)->addExtraClass('required-field'),
            TextareaField::create('BookingQuestions')->addExtraClass('bq')->setAttribute('placeholder', 'Ask a question about the room..'),
            DropdownField::create('RoomSelect', 'Select Room..',
                Room::get()->map('ID', 'Room')->toArray()
            )

        );
        $actions = new FieldList(
            FormAction::create('submitHire')->setTitle('Send')->addExtraClass('hire-form')->setUseButtonTag(true)->addExtraClass('hire-submit')->addExtraClass('button')
        );

        $form = new Form($this, 'HireForm', $fields, $actions);
        $form->setTemplate('CustomHireForm');

        return $form;
    }

    //
    public function submitHire($data, $form)
    {
        //Set confirmation text to field above.
        $successContent = 'Email content below: <br/>';

        //Contruct form data for recipient
        $formDataSubmission = '
			<table>
				<tbody>
				<tr>
					<td>Firstname:	</td>
					<td>' . $data['FirstName'] . '</td>
				</tr>
				<tr>
					<td>Lastname:	</td>
					<td>' . $data['LastName'] . '</td>
				</tr>
				<tr>
					<td>Email:	</td>
					<td>' . $data['Email'] . '</td>
				</tr>
				<tr>
					<td>Email:	</td>
					<td>' . $data['RoomSelect'] . '</td>
				</tr>
				<tr>
					<td>Message:	</td>
					<td>' . $data['Organisation'] . '</td>
				</tr>
				<tr>
					<td>Message:	</td>
					<td>' . $data['HireDate'] . '</td>
				</tr>
				<tr>
					<td>Message:	</td>
					<td>' . $data['HireTime'] . '</td>
				</tr>
				<tr>
					<td>Message:	</td>
					<td>' . $data['BookingReason'] . '</td>
				</tr>
				<tr>
					<td>Message:	</td>
					<td>' . $data['BookingQuestions'] . '</td>
				</tr>



				</tbody>
			</table>';
        $successContent .= $formDataSubmission;


        $email = new Email('rooms@royalsociety.org.nz', 'rooms@royalsociety.org.nz', 'Contact form submission', $successContent);

        if (!$email->send()) {
            $content = 'There was a problem sending your data, please resubmit the form.';
        }
        return array(
            'Content' => 'HIRE EMAIL SENT!',
            'Form' => ''
        );
    }

    /** ^ Hire FORM ^ **/


    /** v Membership FORM v **/
    public function MembershipForm()
    {
        $fields = new FieldList(

        //set urls and member types.
            DropdownField::create('MembershipSelect', 'Select Membership Type..',
                array(
                    'crm/url/fellow' => 'Fellow',
                    'crm/url/companion' => 'Companion',
                    'crm/url/member' => 'Member'
                )
            )

        );
        $actions = new FieldList(
            FormAction::create('submitMembership')->setTitle('Go')->addExtraClass('Membership-form')->setUseButtonTag(true)->addExtraClass('Membership-submit')->addExtraClass('button')
        );


        $form = new Form($this, 'MembershipForm', $fields, $actions);
        $form->setTemplate('CustomMembershipForm');


        return $form;

    }

    //
    public function submitMembership($data, $form)
    {

        $URL = 'http://SomeCrmMembershipURL.com/';
        return $this->redirect($URL . $data['MembershipSelect']);


    }

    /** ^ Membership FORM ^ **/


    public function RoyalSearchForm()
    {
        $fields = new FieldList(
            TextField::create('Search', 'Search')->addExtraClass('search'),
            HiddenField::create('From', 'The page the form was sent from')->setValue($this->Link())
        );
        $actions = new FieldList(
            FormAction::create('goSearch', 'Go')->addExtraClass('search-active')->setUseButtonTag(true)
        );
        $form = new Form($this, 'RoyalSearchForm', $fields, $actions);
        $form->setTemplate('RoyalSearchForm');
        $form->disableSecurityToken();
        $form->setFormMethod('GET', true);
        $form->setTemplate('RoyalSearchForm');
        $form->addExtraClass('searchForm');

        return $form;
    }

    public function goSearch($data, $form, SS_HTTPRequest $request)
    {
        $search = '';
        $searchAS = '';
//    	if(isset($_GET['Search']))
//    	{
//    		$search = trim(htmlspecialchars($_GET['Search']));
//    	}
//
//    	$from = Null;
//
//        if(isset($_GET['From']))
//        {
//            $from = $_GET['From'];
//        }
//
//        if(isset($data['From']) && $data['From'] == '/medals-and-awards/')
//        {
//            $from = 'Medal';
//        }
//
//        if(isset($data['From']) && $data['From'] == '/funds-and-opportunites/')
//        {
//            $from = 'funds-and-opportunities';
//        }
//
//        if(isset($data['From']) && $data['From'] == '/join-us/')
//        {
//            $from = 'Membership';
//        }
//
//        if(isset($data['From']) && $data['From'] == '/events/')
//        {
//            $from = 'Events';
//        }

        // ToDo: sort out documents
//        if(isset($data['From']) && $data['From'] == '/documents/')
//        {
//            $from = 'Documents';
//        }


        if (isset($data['Search'])) {
            $search = $data['Search'];
        }

        // Set Search as a type
        if (isset($data['vistorstatus'])) {
            $searchAS = $data['vistorstatus'];
        }


        $index = new RoyalIndex();
        $query = new SearchQuery();
        $query->search($search);


        $params = array(
            'hl' => 'true'
        );
        $results = $index->search($query, -1, 9000, $params); // third param is the amount of results in one go -1 not working. I think 9000 is a good base ;) ;) ;)

        $results->spellcheck;

        $ResultsList = ArrayList::create();


        /**
         * Add results that are only tagged by core tag first
         */
        foreach ($results->Matches as $r) {

            if (method_exists($r, 'Tags') && $r->getClassName() != 'Image') {
                $matchTags = $r->Tags();
                foreach ($matchTags as $TagMatch) {
                    if ($TagMatch->Tag == $searchAS) {
                        $ResultsList->add($r);
                    }
                }
            }

        }

        foreach ($results->Matches as $r) {

            if ($r->getClassName() != 'Image' && $r->ShowInSearch != false) {
                $ResultsList->add($r);
            }

        }

        $ResultsList->removeDuplicates();
        $ResultsList = Page::get();

        $PaginatedResultsList = PaginatedList::create($ResultsList, $this->getRequest());
        $PaginatedResultsList->setPageLength(5);

        // $data = ArrayData::create(array(
        //     'Results' => $ResultsList,
        //     'KeyWord' => $data['Search'],
        // ));

        $data = ArrayData::create(array(
            'Results' => $PaginatedResultsList,
            'KeyWord' => $data['Search'],
        ));

        return $this->owner->customise($data)->renderWith('Page_results');
        //return $this->owner->customise($PaginatedData)->renderWith('Page_results');

    }


    /**
     * Add Front End Event Form
     */
    public function getFrontEndEvents()
    {
        $eventArr = array();
        $eventArr['CREATE'] = 'CREATE NEW EVENT';
        $FrontEvents = Event::get()
            ->filter(array(
                'Source' => 'FE'
            ));
        foreach ($FrontEvents as $e) {
            $eventArr[$e->ID] = $e->Title;
        }

        return $eventArr;
    }

    public function regionAsMap()
    {
        $regionArr = array();
        $Regions = Region::get();
        foreach ($Regions as $region) {
            $regionArr[$region->ID] = $region->Region;
        }

        return $regionArr;
    }

    public function EditorToolBar()
    {
        return HtmlEditorField_Toolbar::create($this, 'EditorToolbar');
    }

    public function frontEndEventForm()
    {
        $FEDropDown = DropdownField::create('EventID', 'Event', $this->getFrontEndEvents())->addExtraClass('required-field');
        $EventName  = TextField::create('Title', 'Event name')->addExtraClass('required-field');
//        $HeroImage = UploadField::create('HeroImage', 'Hero Image')
//            ->setCanAttachExisting(false)
//            ->setCanPreviewFolder(false)
//            ->setAllowedMaxFileNumber(1);

        $Region = DropdownField::create('RegionID', 'Region', $this->regionAsMap())->addExtraClass('required-field');
        $FullName = TextField::create('FullName', 'Event Submitter')->addExtraClass('required-field');
        $Email = EmailField::create('Email', 'Event Submitter Email')->addExtraClass('required-field');
        $Organisation = TextField::create('Organisation', 'Event Host Organisation')->addExtraClass('required-field');
        $Link= TextField::create('Link', 'Booking Link (will override RSVP Email for \'Booking\' button, please include https:// or http://)')
            ->addExtraClass('required-field');
        $RSVPEmail = TextField::create('RSVPEmail', 'RSVP Email')->addExtraClass('required-field');
        $InfoURL = TextField::create('InfoURL', 'More Information URL (please include https:// or http://)')
            ->addExtraClass('required-field');
        $Topic= TextField::create('Topic', 'Topic')->addExtraClass('required-field');
        $SpeakerName = TextField::create('SpeakerName', 'Speaker Name')->addExtraClass('required-field');
        $SpeakerTitle= TextField::create('SpeakerTitle', 'Speaker Title')->addExtraClass('required-field');
        $Location = TextField::create('Location', 'Location')->addExtraClass('required-field');
        $Start = DatetimeField::create('Start','Event Start Time')->getDateField()
            ->setConfig('showcalendar',true)
            ->setAttribute('required', true)
            ->addExtraClass('required-field')
            ->setConfig('use_strtotime', true);
        $End = DatetimeField::create('End','Event Finish Time')->getDateField()
            ->setConfig('showcalendar',true)->setAttribute('required', true)
            ->addExtraClass('required-field')
            ->setConfig('use_strtotime', true);

        $startLabel = LiteralField::create('StartLabel', '<label class="left" for="Form_frontEndEventForm_Start">Event Start Time</label>');
        $endLabel = LiteralField::create('EndLabel', '<label class="left" for="Form_frontEndEventForm_End">Event Finish Time</label>');

        $Description = HtmlEditorField::create('Content', 'Description')->addExtraClass('required-field');

        $fields = FieldList::create(
            $FEDropDown, $EventName, $Region, $FullName, $Email, $Organisation, $Link, $RSVPEmail, $InfoURL, $Topic, $SpeakerName,
            $SpeakerTitle, $Location,$startLabel, $Start, $endLabel, $End, $Description
        );

        $actions = FieldList::create(
            FormAction::create('doFrontEndEvent', 'Submit')->addExtraClass('FormClass')
            ->setUseButtonTag(true)->addExtraClass('button')
        );

        $required = new RequiredFields(array(
            'Title', 'RegionID', 'FullName', 'Email', 'Organisation', 'Link', 'RSVPEmail',
            'InfoURL', 'Topic', 'SpeakerName', 'SpeakerTitle', 'Location', 'Start', 'End',
            'Content'
        ));

        $form = Form::create($this, 'frontEndEventForm', $fields, $actions, $required);
        $form->setTemplate('CustomEventForm');

        //return $form;
        $data = Session::get("FormData.{$form->getName()}.data");
        return $data ? $form->loadDataFrom($data) : $form;
    }

    public function updateFeEventData()
    {
        $Event = '';
        if(isset($_POST['Value']))
        {
            if ($_POST['Value'] == 'CREATE')
            {
                $Event = Event::create();
            }
            else
            {
                $Event = Event::get()->byID($_POST['Value']);
            }
        }

        $formData = new stdClass();
        $formData->EventName    = $Event->Title;
        $formData->FullName = $Event->FullName;
        $formData->Region = $Event->RegionID;
        $formData->Email = $Event->Email;
        $formData->Organisation = $Event->Organisation;
        $formData->Link = $Event->Link;
        $formData->RSVPEmail = $Event->RSVPEmail;
        $formData->InfoURL = $Event->InfoURL;
        $formData->Topic = $Event->Topic;
        $formData->SpeakerType = $Event->SpeakerType;
        $formData->SpeakerName = $Event->SpeakerName;
        $formData->SpeakerTitle = $Event->SpeakerTitle;
        $formData->Source = $Event->Source;
        $formData->SourceID = $Event->SourceID;
        $formData->RawData = $Event->RawData;
        $formData->UpdateData = $Event->UpdateData;
        $formData->Location = $Event->Location;
        $formData->Start = $Event->Start;
        $formData->End = $Event->End;
        $formData->Content = $Event->Content;

        $encodeEvent = json_encode($formData);
        return $encodeEvent;
    }

    public function doFrontEndEvent($data, $form)
    {
        Session::set("FormData.{$form->getName()}.data", $data);
        $event = Event::create();

        $form->saveInto($event);

        $event->Source = 'FE';

        $eventHolderPage = Page::get()->filter(array(
            'URLSegment'    =>  'events'
        ));

        $event->Start = $data['Start']['date'];
        $event->End = $data['End']['date'];

        $eventHolderPageID = $eventHolderPage->first();
        $event->ParentID = $eventHolderPageID->ID;

        $event->writeToStage('Stage');

        Session::clear("FormData.{$form->getName()}.data");
        $form->sessionMessage('Thanks for your event submission!','good');

        // Send email to Admin $config = SiteConfig::current_site_config();
        $config = SiteConfig::current_site_config();
        if($config->EventNotificationEmail > '')
        {
            $this->sendEmailToAdminFromSystem($config->EventNotificationEmail, $event->Title, "Event");
        }

        return $this->redirectBack();
    }

    public function sendEmailToAdminFromSystem($emailAddress,$title, $type)
    {
        $email = Email::create();

        $email->setTo($emailAddress);
        $email->setFrom('no-reply@royalsociety.org.nz');
        $email->setSubject('New '.$type.' : '.$title);
        $email->setBody('A new '.$type.' has been added to the system and needs to be published, please check the CMS');

        return $email->send();

    }


    public function getArrowSVGIcon()
    {
        $theme = $this->ThemeDir();
        return file_get_contents('./themes/royalsoc/img/controls/homepage/red-arrow.svg');
    }

}


