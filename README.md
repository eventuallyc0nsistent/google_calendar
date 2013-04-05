# Google Calendar API problems
Since we need the *service* class to return *true* we'll have to set objects true for it.
	$client->setUseObjects(true);
	//right before 
	$service = new apiCalendarService($client);
	// cause the default behaviour is to return arrays
> Answer for the Stack Overflow Question [here](http://stackoverflow.com/questions/11908420/trying-to-get-a-list-of-events-from-a-calendar-using-php)