<?php

class FullPeopleImportTask extends BuildTask
{
	protected $title = 'Update People From CRM';

	protected $description = 'Will import and update or create all the people in the Royal CRM';

	protected $enabled = true;

	function run($request)
	{
		$pc = new PeopleController;
		echo $pc->FullUpdate();
	}
}