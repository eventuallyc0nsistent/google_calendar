<?php
session_start();

require_once('Zend/Loader.php') ;
require_once('Zend/Gdata.php');
require_once('Zend/Gdata/Calendar.php') ;
;
// Inorder to use the Google Data API for inserting events into calendar
Zend_Loader::loadClass('Zend_Gdata_AuthSub');
Zend_Loader::loadClass('Zend_Gdata');
Zend_Loader::loadClass('Zend_Gdata_Query');


$my_calendar = 'http://www.google.com/calendar/feeds/default/private/full';
  
if (!isset($_SESSION['cal_token'])) {
    if (isset($_GET['token'])) {
        // You can convert the single-use token to a session token.
        $session_token =
            Zend_Gdata_AuthSub::getAuthSubSessionToken($_GET['token']);
        // Store the session token in our session.
        $_SESSION['cal_token'] = $session_token;
    } else {
        // Display link to generate single-use token
        $googleUri = Zend_Gdata_AuthSub::getAuthSubTokenUri(
            'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
            $my_calendar, 0, 1);
        echo "Click <a href='$googleUri'>here</a> " .
             "to authorize this application.";
        exit();
    }
}

// Create an authenticated HTTP Client to talk to Google.
$client = Zend_Gdata_AuthSub::getHttpClient($_SESSION['cal_token']);
 
// create instance of Calendar service via Gdata
$service = new Zend_Gdata_Calendar($client);




try {

	// Create a new entry using the calendar service's magic factory method
	$event= $service->newEventEntry();
	 
	// Populate the event with the desired information
	// Note that each attribute is crated as an instance of a matching class
	$event->title = $service->newTitle("Testing Event");
	$event->where = array($service->newWhere("Mountain View, California"));
	$event->content = $service->newContent(" This is my awesome event. RSVP required.");
	 
	// Set the date using RFC 3339 format.
	$startDate = "2013-04-15";
	$startTime = "14:00";
	$endDate = "2013-04-15";
	$endTime = "16:00";
	$tzOffset = "-08";
	 
	$when = $service->newWhen();
	$when->startTime = "{$startDate}T{$startTime}:00.000{$tzOffset}:00";
	$when->endTime = "{$endDate}T{$endTime}:00.000{$tzOffset}:00";
	$event->when = array($when);

	// $who = $service->newwho();
	// $who->setEmail('am@energysolforum.com');
	//$event->setWho(array($who));



	$email = 'ab@energysolforum.com';
	$SendEventNotifications = new Zend_Gdata_Calendar_Extension_SendEventNotifications(); 
    $SendEventNotifications->setValue(true); 
    $event->SendEventNotifications = $SendEventNotifications;

    $who = $service->newwho();
    $who->setEmail($email);

    $event->setWho(array($who)); 
	 
	// Upload the event to the calendar server
	// A copy of the event as it is recorded on the server is returned
	$newEvent = $service->insertEvent($event);



    
} catch (Exception $e) {
    die('An error occured: ' . $e->getMessage()."\n");
}

echo "Event sent to calendar";