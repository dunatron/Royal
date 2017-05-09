<?php

class Carousel extends DataObject
{
	private static $db = array(
		'Title' => 'VarChar(255)',
	);

	private static $has_many = array(
		'Images' => 'CarouselImage'
	);

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();

		$fields->removeFieldFromTab('Root','Images');

		// $conf = GridFieldConfig_RelationEditor::create();
		// $conf->addComponent(new GridFieldSortableRows('SortOrder'));

		$fields->addFieldToTab('Root.CarouselImages', GridField::create(
            'Images',
            'Images in this Carousel',
            $this->Images(),
            GridFieldConfig_RecordEditor::create()->addComponent(new GridFieldSortableRows('SortOrder'))
        ));

		//$imagegrid->addComponent(new GridFieldSortableRows('SortOrder'));

		return $fields;
	}

	public function getCMSValidator() 
	{
		return new RequiredFields(array('Title'));
	}

}

class CarouselImage extends DataObject
{
	private static $db = array(
		'Title' => 'Varchar(255)',
		'Caption' => 'Varchar(255)',
		'SortOrder' => 'Int'
	);

	private static $has_one = array(
		'Image' => 'Image',
		'Carousel' => 'Carousel'
	);

	private static $summary_fields = array (
        'GridThumbnail' => '',
        'Title' => 'Title for Image',
        'Caption' => 'Short Caption for Image'
    );

    private static $default_sort = 'SortOrder';

	public function getCMSFields()
	{
		$fields = FieldList::create(
			TextField::create('Title'),
			TextField::create('Caption'), 
			$uploader = UploadField::create('Image')
		);
		$uploader->setAllowedFileCategories('image');
		$uploader->setAllowedMaxFileNumber(1);
		$uploader->setFolderName('CarouselImages');

		return $fields;
	}

	public function getGridThumbnail(){
		if($this->Image()->exists())
		{
			return $this->Image()->SetWidth(100);
		}
		return "(no image)";
	}
}
