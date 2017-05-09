<?php

class RoyalIndex extends SolrIndex {
	function init()
	{
	    //https://github.com/silverstripe/silverstripe-fulltextsearch/blob/master/docs/en/Solr.md
		$this->addClass('RoyalSocContent');
		$this->addClass('Panel');
		$this->addClass('Project');
		$this->addClass('File');
		$this->addClass('Event');
        $this->addClass('People');
		$this->addAllFulltextFields();
        $this->addStoredField('Content');
        $this->addStoredField('Title');
        $this->addStoredField('BiographicalNotes');

        //$this->addFilterField('ShowInSearch');

		// $this->addFulltextField('Title');
		// $this->addFulltextField('Content');
		
	}
}