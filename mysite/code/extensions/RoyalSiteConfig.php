<?php

class RoyalSiteConfig extends DataExtension
{
	private static $db = array(
		'YouMayAlsoLikeTag' => 'Varchar(255)',
		'RoyalTwitterURL' => 'Varchar(255)',
		'RoyalFacebookURL' => 'Varchar(255)',
		'EventNotificationEmail' => 'Varchar(255)',
		'GoogleAnalyticsCode' => 'Varchar(255)',
		'PaymentExpressURL' => 'Varchar(255)',
		'PaymentExpressUserID' => 'Varchar(255)',
		'PaymentExpressKey' => 'Varchar(255)',
		'DonationNotificationEmail' => 'Varchar(255)',
		'DonateText' => 'HTMLText',
		'BookOrderNotificationEmail' => 'Varchar(255)',
		'BookOrderContactNumber' => 'Varchar(255)',
		'BookPrice' => 'Varchar(255)',
		'BookTitle' => 'Text',
		'BookAuthor' => 'Text',
		'BookBlurb' => 'HTMLText',
		'BookIntro' => 'Varchar(255)',
		'ShipPriceNZ' => 'Text',
		'ShipPriceAUS' => 'Text',
		'ShipPriceINTER' => 'Text',
		'NewsNotificationEmail' => 'Varchar(255)',
		'ResearchNotificationEmail' => 'Varchar(255)'
	);

	private static $has_one = array(
		'YouMayAlsoLike' => 'Page',
		'BookPhoto' => 'Image'
	);	


	public function updateCMSFields(FieldList $fields)
	{
		//Royal Config tab
		$fields->addFieldToTab('Root.RoyalConfig', new HeaderField('BottomOfPageShare','Bottom Of Page Share', 2));
		$fields->addFieldToTab('Root.RoyalConfig', new TreeDropdownField('YouMayAlsoLikeID','Choose a page to show at link to at the bottom of pages:', 'SiteTree'));
		$fields->addFieldToTab('Root.RoyalConfig', new TextField('YouMayAlsoLikeTag','Tag Line'));

		$fields->addFieldToTab('Root.RoyalConfig', new HeaderField('SocialMedia','Social Media', 2));
		$fields->addFieldToTab('Root.RoyalConfig', new TextField('RoyalTwitterURL','Royal Society Twitter URL (https:// or http:// required)'));
		$fields->addFieldToTab('Root.RoyalConfig', new TextField('RoyalFacebookURL','Royal Society Facebook URL (https:// or http:// required)'));


		$fields->addFieldToTab('Root.RoyalConfig', new HeaderField('EventNotificationEmail','Notification Emails', 2));
		$fields->addFieldToTab('Root.RoyalConfig', new TextField('EventNotificationEmail','Email event import notifications to be sent to'));		
		$fields->addFieldToTab('Root.RoyalConfig', new TextField('NewsNotificationEmail','Email news notifications to be sent to'));
		$fields->addFieldToTab('Root.RoyalConfig', new TextField('ResearchNotificationEmail','Email research notifications to be sent to'));


		$fields->addFieldToTab('Root.RoyalConfig', new HeaderField('DonationFormSetup','Donation Form Setup', 2));
		$fields->addFieldToTab('Root.RoyalConfig', new TextField('DonationNotificationEmail','Donation Notification Email'));
		$fields->addFieldToTab('Root.RoyalConfig', new HtmlEditorField('DonateText','Donation Form Text'));

		$fields->addFieldToTab('Root.RoyalConfig', new TextField('BookOrderNotificationEmail','Book Order Notification Email'));
		$fields->addFieldToTab('Root.RoyalConfig', new TextField('BookOrderContactNumber','Contact Phone Number for Customer'));


		$fields->addFieldToTab('Root.RoyalConfig', new HeaderField('GoogleCode','Google Code', 2));
		$fields->addFieldToTab('Root.RoyalConfig', new TextField('GoogleAnalyticsCode','Google Analytics Code'));

		$fields->addFieldToTab('Root.RoyalConfig', new HeaderField('PaymentExpressCredentials','Payment Express Credentials', 2));
		$fields->addFieldToTab('Root.RoyalConfig', new TextField('PaymentExpressURL','Payment Express Gateway URL'));
		$fields->addFieldToTab('Root.RoyalConfig', new TextField('PaymentExpressUserID','Payment Express Gateway ID'));
		$fields->addFieldToTab('Root.RoyalConfig', new TextField('PaymentExpressKey','Payment Express Gateway Key'));




		//Book Details Tab
		$uploadField = new UploadField('BookPhoto','Cover Photo');
		$uploadField->setAllowedFileCategories('image');
		$uploadField->setAllowedMaxFileNumber(1);
		$fields->push($uploadField);
		$fields->addFieldToTab('Root.BookDetails', $uploadField);

		$field = new TextField('BookTitle','Title of Book');
		$fields->addFieldToTab('Root.BookDetails',$field);

		$field = new TextField('BookAuthor','Author of Book');
		$fields->addFieldToTab('Root.BookDetails',$field);

		$field = new NumericField('BookPrice','Book Price');
		$fields->addFieldToTab('Root.BookDetails', $field);

		$field = new TextareaField('BookIntro','Book Intro');
		$fields->addFieldToTab('Root.BookDetails',$field);

		$field = new HtmlEditorField('BookBlurb','Book Blurb');
		$fields->addFieldToTab('Root.BookDetails',$field);

		$field = new NumericField('ShipPriceNZ','Shipping Price NZ');
		$fields->addFieldToTab('Root.BookDetails', $field);

		$field = new NumericField('ShipPriceAUS','Shipping Price AUS');
		$fields->addFieldToTab('Root.BookDetails', $field);

		$field = new NumericField('ShipPriceINTER','Shipping Price International');
		$fields->addFieldToTab('Root.BookDetails', $field);

		

		// $field = new TextField('BookOrderEmail','Book Payment Notification Email');
		// $fields->addFieldToTab('Root.BookDetails', $field);


	}

	public function CurrentLikePage()
    {
        $config = SiteConfig::current_site_config();

        $page = $config->YouMayAlsoLike();

        $data = ArrayData::create(array(
            'Tag'   =>  $config->YouMayAlsoLikeTag,
            'Title' =>  $page->Title,
            'URL'   =>  $page->URLSegment
        ));

        return $data;
    }
}