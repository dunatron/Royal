<?php

class BookOrders extends DataObject
{
	private static $db = array(
		'FirstName' => 'Varchar(255)',
		'LastName' => 'Varchar(255)',
		'Address' => 'Text',
		'EmailAddress' => 'Varchar(255)',
		'Comments' => 'Text',
		'Quantity' => 'Varchar(255)',
		'OrderCost' => 'Varchar(255)',
		'OrderStatus' => 'Varchar(255)',
		'TransactionID' => 'Varchar(255)',
		'ShipmentStatus' => 'Varchar(255)',
		'GatewayResponse' => 'Varchar(255)'


		
	);

	private static $summary_fields = array(
		'ID' => 'Order Number',
		'FirstName' => 'Customer First Name',
		'LastName' => 'Customer Last Name',
		'Address' => 'Customer Address',
		'EmailAddress' => 'Customer Email Address',
		'Comments' => 'Comments',
		'Quantity' => 'Quantity',
		'OrderCost' => 'Total Order Cost',
		'OrderStatus' => 'Order Status',
		'TransactionID' => 'Transaction ID',
		'ShipmentStatus' => 'Shipment Shipped',
		'GatewayResponse' => 'Gateway Response'



	);


	private static $default_sort = 'OrderStatus ASC, ShipmentStatus ASC'; 


	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->addFieldToTab('Root.Main', TextField::create('FirstName', 'Customer First Name'));
		$fields->addFieldToTab('Root.Main', TextField::create('LastName', 'Customer Last Name'));
		$fields->addFieldToTab('Root.Main', EmailField::create('EmailAddress', 'Customer Email Address'));

		if (!empty($this->TransactionID))
		{
			$fields->addFieldToTab('Root.Main', ReadonlyField::create('TransactionID', 'Transaction ID'));
		} 
		else 
		{
			$fields->addFieldToTab('Root.Main', TextField::create('TransactionID', 'Transaction ID'));
		}

		$fields->addFieldToTab('Root.Main', DropdownField::create(
		  'OrderStatus',
		  'Order Status',
		  array(
		    'PaymentComplete' => 'Payment Complete',
		    'PaymentIncomplete' => 'Payment Incomplete',
		    'RequestingMultiples'=> 'Requesting Multiples'
		  )
		));

		$fields->addFieldToTab('Root.Main', DropdownField::create(
		  'ShipmentStatus',
		  'Shipping Status',
		  array(
		    'Sent' => 'Sent',
		    'Unsent' => 'Unsent'
		  )
		));
		$fields->addFieldToTab('Root.Main', NumericField::create('OrderCost', 'Total Order Cost'));
		$fields->addFieldToTab('Root.Main', NumericField::create('Quantity', 'Quanitity'));
		$fields->addFieldToTab('Root.Main', TextField::create('GatewayResponse', 'Gateway Response'));

		
		// $field = new TextField('Name','Title of Book');
		// $fields->addFieldToTab('Root.Content.BookOrders',$field);

		// $field = new TextField('Address','Book Description');
		// $fields->addFieldToTab('Root.Content.BookOrders',$field);

		// $field = new TextField('EmailAddress','Book Price');
		// $fields->addFieldToTab('Root.Content.BookOrders', $field);

		// $field = new TextField('OrderStatus','Status Of Order');
		// $fields->addFieldToTab('Root.Content.BookOrders', $field);

		// $field = new TextField('OrderName','Order Name');
		// $fields->addFieldToTab('Root.Content.BookDetails', $field, 'OrderName');
		return $fields;

	}

}