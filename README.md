## Google Calendar API problems

Since we need the *service* class to return *true* we'll have to set objects true for it.

	$client->setUseObjects(true);
	
	//right before 
	$service = new apiCalendarService($client);
	// cause the default behaviour is to return arrays

> Answer for the Stack Overflow Question [here](http://stackoverflow.com/questions/11908420/trying-to-get-a-list-of-events-from-a-calendar-using-php)

Instantiate a class with new *Google_* prefix

	$calendar = new Google_Calendar();


## Install the Zend Framework install for parsing GData

###Change your htaccess to include the Zend library . It is different for all versions of ZendGdata
	
	php_value include_path "../ZendGdata-1.12.3/library"

Also you need to load these libraries

+Zend Gdata libraries
+Zend Gdata 
+Zend Gdata Query
+Zend client login

## Create $_COOKIES 

If this isn't done you will face an error called

> Badly formatted datetime in attribute

This is to navigate through various domains i.e. Google OAuth and the redirected website