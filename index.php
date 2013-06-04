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

// Set info into cookies pass across multiple URLs 	
setcookie("cal_start_date", $_POST['cal_start_date'] , time()+3600);
setcookie("cal_start_time", $_POST['cal_start_time'] , time()+3600);
setcookie("cal_end_date", $_POST['cal_end_date'] , time()+3600);
setcookie("cal_end_time", $_POST['cal_end_time'] , time()+3600);
setcookie("cal_title", $_POST['cal_title'] , time()+3600);
setcookie("cal_where", $_POST['cal_where'] , time()+3600);
setcookie("cal_desc", $_POST['cal_desc'] , time()+3600);

  
if (!isset($_SESSION['cal_token'])) {
    if (isset($_GET['token'])) {
        // You can convert the single-use token to a session token.
        $session_token = Zend_Gdata_AuthSub::getAuthSubSessionToken($_GET['token']);
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

// Create an instance of the Calendar service using an unauthenticated HTTP client
// $service = new Zend_Gdata_Calendar();

try {

	// Create a new entry using the calendar service's magic factory method
	$event= $service->newEventEntry();
	 
	// Populate the event with the desired information
	// Note that each attribute is crated as an instance of a matching class
	$event->title = $service->newTitle($_COOKIE['cal_title']);
	$event->where = array($service->newWhere($_COOKIE['cal_where']));
	$event->content = $service->newContent($_COOKIE['cal_desc']);
	 
	// Set the date using RFC 3339 format.
	// $startDate = "2013-04-16";
	// $startTime = "14:00";
	// $endDate = "2013-04-16";
	// $endTime = "16:00";
	// $tzOffset = "-08";	 

	$startDate = $_COOKIE['cal_start_date'];
	$startTime = $_COOKIE['cal_start_time'];
	$endDate = $_COOKIE['cal_end_date'];
	$endTime = $_COOKIE['cal_end_time']; 
	$tzOffset = "-05";
	
	$when = $service->newWhen();
	$when->startTime = "{$startDate}T{$startTime}:00{$tzOffset}:00";
	$when->endTime = "{$endDate}T{$endTime}:00{$tzOffset}:00";
	$event->when = array($when);

	$email = 'kk@energysolforum.com';
	// $email = 'event@energysolforum.com';
	$SendEventNotifications = new Zend_Gdata_Calendar_Extension_SendEventNotifications(); 
    	$SendEventNotifications->setValue(true);
    	$event->SendEventNotifications = $SendEventNotifications;

    	$who = $service->newwho();
    	$who->setEmail($email);

    	$event->setWho(array($who)); 
	 
	// Upload the event to the calendar server
	// A copy of the event as it is recorded on the server is returned
	$newEvent = $service->insertEvent($event);
	$redirect_url = 'http://energysolutionsforum.com/esf-calendar/?data=added' ;
//	$encoded_url = urlencode($redirect_url);
	header("Location:$redirect_url");


} catch (Exception $e) {
    die('An error occured: ' . $e->getMessage()."\n");
} ?>