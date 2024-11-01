<?php
	// these are your whosright API keys - you shouldn't need to change these
	define('WR_API_KEY', 'R1_4c742314aadd4505315705');
	define('WR_API_TOKEN', 'd1db7823161bb3abbc735ce82cfa8f7e');


	// staging server, for testing
	//define('WR_API_HOST', 'http://v2.whosrite.com'); 
	// production server - use this when going live
	define('WR_API_HOST', 'http://whosright.com');
	//define('WR_API_HOST', 'http://v2.whosright.local');

	// your facebook and twitter keys to enable users using those accounts for commenting
	define("FACEBOOK_APP_ID", "");
	define("TWITTER_CONSUMER_KEY", "");
	define("TWITTER_CONSUMER_SECRET", "");
	
	
	// you don't need to change these, internal use by the plugin only
	define('WR_API_URL', WR_API_HOST.'/api/v1/');
	define('USE_HTTP_AUTH', true);
	define('WR_API_USER', 'wr');
	define('WR_API_PASS', 'beta123');
?>
