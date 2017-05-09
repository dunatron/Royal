<?php

class RoyalAdminCoreTags extends ModelAdmin 
{

	private static $managed_models = array(
		'CoreTag'
	);

	private static $url_segment = 'royaladmincoretag';

	private static $menu_title = 'Core Tags';

	private static $menu_icon = 'mysite/icons/tag.png';

	public function getList()
	{
		$list = parent::getList();
		if($this->modelClass == 'CoreTag')
		{
			$list = $list->exclude('IsSystem','1');
		}
		return $list;
	}

}

class RoyalAdminRooms extends ModelAdmin 
{

	private static $managed_models = array(
		'Room'
	);

	private static $url_segment = 'royaladminroom';

	private static $menu_title = 'Rooms';

	private static $menu_icon = 'mysite/icons/rooms.png';

}

class RoyalAdminFieldResearch extends ModelAdmin 
{

	private static $managed_models = array(
		'FieldResearchCategory','FieldResearchSubCategory','FieldResearchCode'
	);

	private static $url_segment = 'royaladminfieldresearch';

	private static $menu_title = 'Field Research';

	private static $menu_icon = 'mysite/icons/research.png';

}

class RoyalAdminSocioEconomicObjective extends ModelAdmin 
{

	private static $managed_models = array(
		'SocioEconomicObjectiveCategory','SocioEconomicObjectiveSubCategory','SocioEconomicObjectiveCode'
	);

	private static $url_segment = 'royaladminsocioeconomicobjective';

	private static $menu_title = 'Socio Economic Objectives';

	private static $menu_icon = 'mysite/icons/socio.png';

}

class RoyalAdminMedia extends ModelAdmin 
{
	private static $managed_models = array(
		'Media'
	);

	private static $url_segment = 'royaladminmedia';

	private static $menu_title = 'Media';

	private static $menu_icon = 'mysite/icons/media.png';
}

class RoyalAdminRegion extends ModelAdmin 
{
	private static $managed_models = array(
		'Region'
	);

	private static $url_segment = 'royaladminregion';

	private static $menu_title = 'Regions';

	private static $menu_icon = 'mysite/icons/region.png';
}

class RoyalAdminFund extends ModelAdmin
{
	private static $managed_models = array(
		'FundOpportunityType','FundOpportunityAudience'
	);

	private static $url_segment = 'royaladminfunddata';

	private static $menu_title = 'Fund Data';

	private static $menu_icon = 'mysite/icons/funds.png';
}

class RoyalAdminMedal extends ModelAdmin
{
	private static $managed_models = array(
		'MedalAwardAudience'
	);

	private static $url_segment = 'royaladminmedaldata';

	private static $menu_title = 'Medal Data';

	private static $menu_icon = 'mysite/icons/medal.png';
}

class RoyalAdminSubject extends ModelAdmin
{
	private static $managed_models = array(
		'Subject'
	);

	private static $url_segment = 'royaladminsubject';

	private static $menu_title = 'Subjects';

	private static $menu_icon = 'mysite/icons/subject.png';
}

class RoyalAdminPeople extends ModelAdmin
{
	private static $managed_models = array(
		'People'
	);

	private static $url_segment = 'royaladminpeople';

	private static $menu_title = 'People';

	private static $menu_icon = 'mysite/icons/person.png';
}

class RoyalAdminQuotes extends ModelAdmin
{
	private static $managed_models = array(
		'Quotes'
	);

	private static $url_segment = 'royaladminquotes';

	private static $menu_title = 'Quotes';

	private static $menu_icon = 'mysite/icons/quote.png';
}

class RoyalAdminCarousel extends ModelAdmin
{
	private static $managed_models = array(
		'Carousel'
	);

	private static $url_segment = 'royaladmincarousel';

	private static $menu_title = 'Carousels';

	private static $menu_icon = 'mysite/icons/carousel.png';
}

class RoyalAdminTopics extends ModelAdmin
{
	private static $managed_models = array(
		'Topic'
	);

	private static $url_segment = 'royaladmintopic';

	private static $menu_title = 'Topics';

	private static $menu_icon = 'mysite/icons/topics.png';
}

class RoyalAdminOrderBook extends ModelAdmin
{
	private static $managed_models = array(
		'BookOrders'
	);

	private static $url_segment = 'orderbook';

	private static $menu_title = 'Book Orders';

	private static $menu_icon = 'mysite/icons/orders.png';
}
//<div>Icons made by <a href="http://www.freepik.com" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>