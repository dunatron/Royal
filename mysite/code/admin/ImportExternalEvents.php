<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 3/04/17
 * Time: 9:28 AM
 */
class ImportFindaEvents extends BuildTask
{
    protected $title = 'Import External Events';

    protected $description = 'Import external EventFinda and EventBrite events into "Event" PageType';

    protected $enabled = true;

    // Test EventFinda -> http://api.eventfinda.co.nz/v2/events.xml?rows=20&username=Eventosaurus
    // Test EventBrite -> https://www.eventbriteapi.com/v3/users/me/owned_events/?token=KFK2PL24HIA4OVGVBZW5&expand=venue,logo,organizer,category

    function run($request)
    {
        $eventList = ArrayList::create();

        $findaCall = $this->FindaAPICall();
        $findaEvents = $findaCall;

        // Event Brite
        $briteCall = $this->BriteAPICall();
        $briteEvents = $briteCall;

        $eventList->merge($briteEvents);
        $eventList->merge($findaEvents);

        $currentEventIDS = array();
        $CurrentEvents = Event::get();
        foreach ($CurrentEvents as $c)
        {
            array_push($currentEventIDS, $c->SourceID);
        }

        //$expireDate = date('Y-m-d', strtotime(date('Y-m-d')." -1 month"));
        //$expireDate = date('Y-m-d', strtotime(date('Y-m-d')." -10 year"));
        $expireDate = date('Y-m-d', strtotime(date('Y-m-d')));
        echo $expireDate;
        echo '<br/>';

        $count = 0;
        foreach ($eventList as $e)
        {

            $expiredEvent = new Boolean(1); // 1=expired, 0=fresh
            echo $e->EndDate.'</br>';
            if (new DateTime($expireDate) > new DateTime($e->EndDate)) {
                echo '<p>LESSER</p>';
                $expiredEvent = 1;
            } else {
                echo '<p>GREATER</p>';
                $expiredEvent = 0;
            }
            //fake fresh events
            //$expiredEvent = 0;
            echo '<br/>';

            if (!in_array($e->SourceID, $currentEventIDS)) {
                //create event
                if($expiredEvent != 1){
                    echo '<p style="color: green;">creating event: Because its SourceID is not yet in the database</p>';
                    $this->createNewEventPage($e, 'create'); // add event item to EventPage
                } else {
                    echo '<p style="color: red;">Expired event: Not adding to the database because event is expired</p>';
                }

            } else {
                // Update Event
                if($expiredEvent != 1){
                    echo '<p style="color: orange;">Updating event: SourceID found: '.$e->SourceID.'</p>';
                    $this->createNewEventPage($e, 'update');
                } else {
                    // delete event
                    echo '<p style="color: red;">Not importing expired event: event is in the database but has expired: You can delte in the cms</p>';
                    //$this->deleteExpiredEvent($e);
                }

            }
            echo '========='.$count.'===========<br>';
            $count++;
        }

    }

    public function curl_get_file_size( $url ) {
      // Assume failure.
      $result = -1;

      $curl = curl_init( $url );

      // Issue a HEAD request and follow any redirects.
      curl_setopt( $curl, CURLOPT_NOBODY, true );
      curl_setopt( $curl, CURLOPT_HEADER, true );
      curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
      curl_setopt( $curl, CURLOPT_FOLLOWLOCATION, true );
      //curl_setopt( $curl, CURLOPT_USERAGENT, get_user_agent_string() );

      $data = curl_exec( $curl );
      curl_close( $curl );

      if( $data ) {
        $content_length = "unknown";
        $status = "unknown";

        if( preg_match( "/^HTTP\/1\.[01] (\d\d\d)/", $data, $matches ) ) {
          $status = (int)$matches[1];
        }

        if( preg_match( "/Content-Length: (\d+)/", $data, $matches ) ) {
          $content_length = (int)$matches[1];
        }

        // http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
        if( $status == 200 || ($status > 300 && $status <= 308) ) {
          $result = $content_length;
        }
      }

      return $result;
    }

    public function checkforChanges($e, $event)
    {
        $changes = false;
        if($event->SourceID != $e->SourceID)
        {
            $changes = true;
        }
        if($event->Title != $e->Title)
        {
            $changes = true;
        }
        if(strip_tags($event->Content) != strip_tags($e->Description))
        {
            $changes = true;
        }
        if($event->FullName != $e->UserName)
        {
            $changes = true;
        }
        if($event->Topic   != $e->EventTopic)
        {
            $changes = true;
        }
        if($event->Link != $e->EventURL)
        {
            $changes = true;
        }
        if($event->Source != $e->Source)
        {
            $changes = true;
        }
        if($event->Organisation != $e->SpeakerName)
        {
            $changes = true;
        }
        if($event->Location != $e->Venue)
        {
            $changes = true;
        }
        if(strtotime($event->Start) != strtotime($e->StartDate))
        {
            $changes = true;
        }
        if(strtotime($event->End) != strtotime($e->EndDate))
        {
            $changes = true;
        }

        return $changes;
    }

    public function createNewEventPage($e, $action)
    {
        $event = NULL;
        $sendmail = false;
        // Get Event Parent Page
        $eventHolderPage = Page::get()->filter(array(
            'URLSegment'    =>  'events'
        ));

        $eventHolderPageID = $eventHolderPage->first();

        // Get Event Names. If name is equal to event title, create just location

        // Create new Event
        if ($action == 'create'){
            $event = Event::create();
            // ToDo remove test
            echo '<p style="color: green;">Creating New Event</p>';
        } 
        elseif($action == 'update')
        {
            $allEvents = Event::get()->filter(array(
                'SourceID'  =>  $e->SourceID
            ));
            $event = $allEvents->first();
            echo '<p style="color:orange">updating event '.$event->ID.':'.$event->Title.'</p>';

            $assocHeroImageID = $event->HeroImageID;

            // if(!empty($assocHeroImageID))
            // {
            //     echo '<p>Old File Image found '.$assocHeroImageID.' preparing to delete</p>';
            //     $this->deleteExistingImage($assocHeroImageID);
            //     $event->HeroImageID = null; // safety in case anything after this fails
            // }
        }   

        $config = SiteConfig::current_site_config(); 

        if($action == "update")
        {
            if($this->checkforChanges($e, $event))
            {
                $event->SourceID = $e->SourceID;
                $event->Title = $e->Title;
                $event->Content = $e->Description;
                $event->FullName = $e->UserName;
                $event->Topic   = $e->EventTopic;
                $event->Link = $e->EventURL;
                $event->ParentID = $eventHolderPageID->ID;
                $event->Source = $e->Source;
                $event->Organisation = $e->SpeakerName;

                $event->Location = $e->Venue;
                $event->Start = $e->StartDate;
                $event->End = $e->EndDate;

                $event->RawData = serialize($e);

                $event->writeToStage('Stage');
                $sendmail = true;
            }

        }
        elseif ($action == "create")
        {

            $event->SourceID = $e->SourceID;
            $event->Title = $e->Title;
            $event->Content = $e->Description;
            $event->FullName = $e->UserName;
            $event->Topic   = $e->EventTopic;
            $event->Link = $e->EventURL;
            $event->ParentID = $eventHolderPageID->ID;
            $event->Source = $e->Source;
            $event->Organisation = $e->SpeakerName;

            $event->Location = $e->Venue;
            $event->Start = $e->StartDate;
            $event->End = $e->EndDate;

            $event->RawData = serialize($e);

            $event->writeToStage('Stage');
            $sendmail = true;
            
        } 

        if(!empty($e->ExternalImageURL))
        {
            $createnewfile = true;
            if($action == 'update')
            {
                if(!empty($assocHeroImageID))
                {
                    $newFileSize = $this->curl_get_file_size($e->ExternalImageURL);
                    $File  = File::get()->byID($assocHeroImageID);
                    if($File)
                    {
                        $oldFileSize = File::get()->byID($assocHeroImageID)->getAbsoluteSize();
                    }
                    else
                    {
                        $oldFileSize = 0;
                    }
                    if($newFileSize == $oldFileSize)
                    {
                        // do nothing
                        $createnewfile = false;
                    }
                    else
                    {
                        // echo '<p>Old File Image found '.$assocHeroImageID.' preparing to delete</p>';
                        // $this->deleteExistingImage($assocHeroImageID);
                        // $event->HeroImageID = null; // safety in case anything after this fails
                        $createnewfile = true;
                    }
                }
            }
            if($createnewfile)
            {
                // Create Image from external URL
                $folder = Folder::find_or_make('/EventHeroImages');
                $relativeFilePath = $_SERVER['DOCUMENT_ROOT'].'/'.$folder->getRelativePath();

                $fileName = str_replace(' ','-',$e->Title).'-'.time();

                $goodFileName = preg_replace('/[^A-Za-z0-9\-]/', '', $fileName);
                $goodFileName .= '.png';

                // if old file size equals new file size don't bother doing anything else

                copy($e->ExternalImageURL, $relativeFilePath . DIRECTORY_SEPARATOR . $goodFileName);

                $file = new Image();

                $file->ParentID = $folder->ID;
                $file->OwnerID = 1;
                $file->Name = $fileName;
                $file->FileName = $folder->Filename.$goodFileName;
                $file->Title = $e->Title;
                $event->HeroImageID = $file->write();
                $event->writeToStage('Stage');
                $sendmail = true;
            }
        }

        if($config->EventNotificationEmail > '' && $sendmail){
            $sendEmail = $this->sendEmailToAdmin($config->EventNotificationEmail,$action, $e->SourceID, $e->Title);
        }

    }

    public function deleteExistingImage($assocHeroImageID)
    {
        $File = File::get()->byID($assocHeroImageID);
        echo '<p style="color: red;">Deleting image: '.$File->Filename.'</p>';
        $File->delete();
        if($File->exists()){
            echo '<p style="color: red">error trying to delete file: file still exists</p>';
        } else {
            echo '<p style="color: #00FF00">File successfully deleted</p>';
        }
        return;
    }

    public function deleteExpiredEvent($event)
    {
//        $allEvents = Event::get()->filter(array(
//            'SourceID'  =>  $event->SourceID
//        ));
//        $event = $allEvents->first();
        $allEvents = Page::get('Event')->filter(array(
            'SourceID'  =>  $event->SourceID
        ));
        $event = $allEvents->first();
        $event->deleteFromStage('Live');
        $event->deleteFromStage('Stage');
        $event->delete();
        return;
    }

    public function EventFindaUserName()
    {
        return 'royalsocietynz';
    }

    public function EventFindaPassword()
    {
        return '2pr2nv6nb7n6';
    }

    //Test -> http://api.eventfinda.co.nz/v2/events.xml?rows=20&username=Royalsocietyofnz
    public function FindaUsers()
    {
        $users = array(
            'Royalsocietyofnz',
        );
        return $users;
    }

    public function FindaAPICall()
    {
        $findaEvents = array();
        $users = $this->FindaUsers();
        foreach ($users as $u){
            $events = $this->getEventFindaEvents($u);
            $findaEvents = array_merge($findaEvents, $events);
        }
        return $findaEvents;
    }

    public function FindaOffsetPages($collection)
    {
        $count = $collection->{'@attributes'}->count;
        $offset = $count / 20;
        $ceiling = ceil($offset);
        return $ceiling;
    }

    public function getEventFindaEvents($user)
    {
        // Request the response in JSON format using the .json extension
        // Request the response in JSON format using the .json extension
        $url = 'http://api.eventfinda.co.nz/v2/events.json?rows=20&username='.$user;

        $process = curl_init($url);
        curl_setopt($process, CURLOPT_USERPWD, $this->EventFindaUserName() . ":" . $this->EventFindaPassword());
        curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($process);

        $collection = json_decode($return);

        $offset = $this->FindaOffsetPages($collection);
        $EventArray = array();
        for ($i = 1; $i <= $offset; $i++) {
            if($i != 1){
                $url = 'http://api.eventfinda.co.nz/v2/events.json?rows=20&offset=20&username='.$user;
            } else {
                $count = $i-1;
                $addOffset = $count * 20;
                $url = 'http://api.eventfinda.co.nz/v2/events.json?rows=20&offset='.$addOffset.'&username='.$user;
            }

            $process = curl_init($url);
            curl_setopt($process, CURLOPT_USERPWD, $this->EventFindaUserName() . ":" . $this->EventFindaPassword());
            curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
            $return = curl_exec($process);

            $collection = json_decode($return);
            foreach ($collection->events as $event) {
                $e = new Event();
                $e->Title = $event->name;
                $e->SourceID = $event->id;
                $e->Source = 'EventFinda';
                $e->Description = $event->description;
                $e->StartDate = $event->datetime_start;
                $e->EndDate = $event->datetime_end;
                $e->Address = $event->address;
                $e->Venue = $event->location_summary;
                $e->IsLive = 'Live';
                $e->SpeakerName = $event->presented_by;
                $e->UserName = $event->username;
                if (isset($event->booking_phone)) {
                    $e->Phone = $event->booking_phone;
                }
                $e->EventURL = $event->url;
                if (isset($event->booking_web_site)) {
                    $e->TicketWebsite = $event->booking_web_site;
                }
                $e->Capacity = 'EventFinda:STILL TO FIND';
                // Handle Event Finda Images
                $images = $event->images->images;
                $bestImage = $this->eventFindaBestImage($images);
                $e->ExternalImageURL = $bestImage;
                $e->EventTopic = $event->category->name;

                array_push($EventArray, $e);
            }
        }

        return $EventArray;
    }

    public function eventFindaBestImage($images)
    {
        $imageURL = '';
        foreach ($images as $image) {
            $imageQuality = 0;
            $currQuality = 0;
            foreach ($image->transforms->transforms as $transform) {
                if ($transform->transformation_id == 7) {
                    $currQuality = 5;
                } elseif ($transform->transformation_id == 27) {
                    $currQuality = 4;
                } elseif ($transform->transformation_id == 8) {
                    $currQuality = 3;
                } elseif ($transform->transformation_id == 2) {
                    $currQuality = 2;
                } elseif ($transform->transformation_id == 15) {
                    $currQuality = 1;
                }
                if ($currQuality > $imageQuality) {
                    $imageQuality = $currQuality;
                    $imageURL = $transform->url;
                }
            }
        }
        return $imageURL;
    }



    /**
     * EVENT BRITE
     */
    public function BriteUsers()
    {
        $users = array(
            'KFK2PL24HIA4OVGVBZW5', // Royal society
        );
        return $users;
    }

    public function BriteAPICall()
    {
        $briteEvents = array();
        $tokens = $this->BriteUsers();
        foreach ($tokens as $t){
            $events = $this->getEventBriteEvents($t);
            $briteEvents = array_merge($briteEvents, $events);
        }
        return $briteEvents;
    }

    /***
     * EventBrite (personal OAuth Token: JPJWOZVYBY5QD6OOGL3W)
     */
    public function getEventBriteEvents($token)
    {
        $briteService = new RestfulService('https://www.eventbriteapi.com/v3/users/me/owned_events/?token='.$token.'&expand=venue,logo,organizer,category');
        // perform the query
        $conn = $briteService->request();

        $collection = json_decode($conn->getBody());

        $numberofEvents = $collection->pagination->object_count;


        $paginationCount = $collection->pagination->page_count;

        $EventArray = array();
        for ($PaginationPage = 1; $PaginationPage <= $paginationCount; $PaginationPage++) {

            $briteServiceDRY = new RestfulService('https://www.eventbriteapi.com/v3/users/me/owned_events/?token='.$token.'&expand=venue,logo,organizer,category&page='.$PaginationPage.'');
            // perform the query
            $connDRY = $briteServiceDRY->request();

            $collectionDRY = json_decode($connDRY->getBody());

            foreach ($collectionDRY->events as $event) {
                if($event->status == 'live')
                {
                    $e = new Event();
                    if ($event->id) {
                        $e->SourceID = $event->id;
                    }
                    if ($event->name->text) {
                        $e->Title = $event->name->text;
                    }
                    if ($event->description->text) {
                        $e->Description = $event->description->html;
                    }
                    if ($event->start->local) {
                        $e->StartDate = $event->start->local;
                    }
                    if ($event->end->local) {
                        $e->EndDate = $event->end->local;
                    }
                    if (isset($event->venue->address->localized_address_display)) {
                        $e->Address = $event->venue->address->localized_address_display;
                        $e->Venue = $event->venue->address->localized_address_display;
                    }

                    if ($event->status) {
                        $e->IsLive = $event->status;
                    }
                    if ($event->organizer->name != NULL) {
                        $e->UserName = $event->organizer->name;
                        $e->SpeakerName = $event->organizer->name;
                    }
                    $e->Phone = 'NO PHONE YET';
                    if ($event->url) {
                        $e->EventURL = $event->url;
                    }
                    $e->TicketWebsite = 'LOOK INTO FREE AND PURCHASABLE TICKETS';
                    if ($event->capacity) {
                        $e->Capacity = $event->capacity;
                    }
                    if ($event->logo != NULL) {
                        $e->ExternalImageURL = $event->logo->original->url;
                    }
                    $e->Source = 'EventBrite';

                    if (isset($event->category->name_localized)) {
                        $e->EventTopic = $event->category->name_localized;
                    }

                    $e->Organisation = $event->organizer->name;

                    array_push($EventArray, $e);
                }
            }
        }

        return $EventArray;

    }

    public function sendEmailToAdmin($emailAddress,$action,$source,$title)
    {
        $email = Email::create();

        $email->setTo($emailAddress);
        $email->setFrom('no-reply@royalsociety.org.nz');
        if($action == 'create')
        {
            $email->setSubject('New Event : '.$title);
            $email->setBody('A new event has been added to the system from '.ucfirst($source).' and needs to be published, please check the CMS');
        }
        else
        {
            $email->setSubject('Updated Event : '.$title);
            $email->setBody('An event has been updated in the system from '.ucfirst($source).' and needs to be published, please check the CMS');
        }

        return $email->send();

    }

}