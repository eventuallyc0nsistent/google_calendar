<?php
session_start();

$path = '/energysolforum.com/googlecalendar/ZendGdata-1.12.3/library';
set_include_path(get_include_path() . PATH_SEPARATOR . $path);

require_once 'Google_Client.php';
require_once 'Google_CalendarService.php';
require_once '../googlecalendar/ZendGdata-1.12.3/library/Zend/Loader.php' ;
require_once '../googlecalendar/ZendGdata-1.12.3/library/Zend/Gdata.php';
require_once '../googlecalendar/ZendGdata-1.12.3/library/Zend/Gdata/Calendar.php';

// Inorder to use the Google Data API for inserting events into calendar
Zend_Loader::loadClass('Zend_Gdata');
Zend_Loader::loadClass('Zend_Gdata_Query');

$scriptUri = "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];

$client = new Google_Client();
$client->setAccessType('online'); // default: offline
$client->setClientId('615935043870.apps.googleusercontent.com');
$client->setClientSecret('66FOV9zJXZ__gYyiZZwUq_I-');
$client->setRedirectUri($scriptUri);
$client->setDeveloperKey('AIzaSyCqRbX0IHNhmfR7l3wUnOSSTEvjlG7gfiw'); // API key
$client->setApplicationName("Calendar");

// $service implements the client interface, has to be set before auth call
$client->setUseObjects(true); 
$service = new Google_CalendarService($client);


// create instance of Calendar service via Gdata
$gdata_service = new Zend_Gdata_Calendar($client);

if (isset($_GET['logout'])) { // logout: destroy token
    unset($_SESSION['token']);
	die('Logged out.');
}

if (isset($_GET['code'])) { // we received the positive auth callback, get the token and store it in session
    $client->authenticate();
    $_SESSION['token'] = $client->getAccessToken();
}

if (isset($_SESSION['token'])) { // extract token from session and configure client
    $token = $_SESSION['token'];
    $client->setAccessToken($token);
}

if (!$client->getAccessToken()) { // auth call to google
    $authUrl = $client->createAuthUrl();
    header("Location: ".$authUrl);
    die;
}




try {


	/* param for XMl

	@email - Email Address
	@rel - relationship
	gd:attendeeStaute - gEnumConstruct - Status of event attendee
	gd:attendeeType - gEnumConstruct - Type of event attendee
	gd:EntryLink - EntryLink - Entry representing person details. This entry should implement the Contact kind. In many cases, this entry will come from a contact feed.
	

	eg : <gd:who rel="http://schemas.google.com/g/2005#message.from" email="jo@example.com"/>
	*/

	// $event = new Google_Event();
	// $event->setSummary('Angeliques Event');
	// $event->setLocation('137 Varick Street, New York, NY 10013');
	// $start = new Google_EventDateTime();
	// $start->setDateTime('2011-06-03T10:00:00.000-07:00');
	// $event->start($setStart);
	// $end = new Google_EventDateTime();
	// $end->setDateTime('2011-06-03T10:25:00.000-07:00');
	// $event->setEnd($end);
	// $attendee1 = new Google_EventAttendee();
	// $attendee1->setEmail('kk@energysolforum.com');
	// $attendee2 = new Google_EventAttendee();
	// $attendee2->setEmail('vg@energysolforum.com');
	// // ...
	// $attendees = array($attendee1,$attendee2);
	// $event->attendees = $attendees;
	// $createdEvent = $service->events->insert('primary', $event);

	// echo $createdEvent->getId();
	
	$listFeed = $gdata_service->getCalendarListFeed();

    
} catch (Exception $e) {
    die('An error occured: ' . $e->getMessage()."\n");
}
