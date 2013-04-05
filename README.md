# Google Calendar API problems

Since we need the *service* class to return *true* we'll have to set objects true for it.

	$client->setUseObjects(true);
	
	//right before 
	$service = new apiCalendarService($client);
	// cause the default behaviour is to return arrays

> Answer for the Stack Overflow Question [here](http://stackoverflow.com/questions/11908420/trying-to-get-a-list-of-events-from-a-calendar-using-php)

Instantiate a class with new *Google_* prefix

	$calendar = new Google_Calendar();


# Install the Zend Framework install for parsing GData

save in the htaccess of the root file
php_value include_path "../ZendGdata-1.12.3/library"


save as PHP
top 

load Zend Gdata libraries
Zend Gdata 
Zend Gdata Query
Zend client login


Zend Gdata Query
