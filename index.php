<?php
session_start();
require_once 'Google_Client.php';
require_once 'Google_CalendarService.php';

$scriptUri = "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];

$client = new Google_Client();
$client->setAccessType('online'); // default: offline
$client->setApplicationName('My Application name');
$client->setClientId('615935043870.apps.googleusercontent.com');
$client->setClientSecret('66FOV9zJXZ__gYyiZZwUq_I-');
$client->setRedirectUri($scriptUri);
$client->setDeveloperKey('AIzaSyCqRbX0IHNhmfR7l3wUnOSSTEvjlG7gfiw'); // API key
$client->setApplicationName("Calendar");

// $service implements the client interface, has to be set before auth call
$client->setUseObjects(true); 
$service = new Google_CalendarService($client);

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
//energysolutionsforum.org_n68es4rrhp273jv7vcrg5ik9r4@group.calendar.google.com
	$events = $service->events->listEvents('energysolutionsforum.org_n68es4rrhp273jv7vcrg5ik9r4@group.calendar.google.com');
	foreach ($events->getItems() as $event ) {

		echo "<pre>";
		print_r($event);
		//exit();
	}
		
	
	// while(true) {
	//   foreach ($events->getItems() as $event) {
	//     print_r($event) ;
	//   }
	//   $pageToken = $events->getNextPageToken();
	//   if ($pageToken) {
	//     $optParams = array('pageToken' => $pageToken);
	//     $events = $service->events->listEvents('primary', $optParams);
	//   } else {
	//     break;
	//   }
	// }
    
} catch (Exception $e) {
    die('An error occured: ' . $e->getMessage()."\n");
}
