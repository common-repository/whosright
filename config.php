<?php
	// these are your whosright API keys - you shouldn't need to change these
	define('WR_API_KEY', get_option('whosright_api_key'));
	define('WR_API_TOKEN', get_option('whosright_api_token'));


	// staging server, for testing
	//define('WR_API_HOST', 'http://v2.whosrite.com'); 
	// production server - use this when going live
	//define('WR_API_HOST', 'http://whosright.com');
	define('WR_API_HOST', get_option('whosright_api_host', 'http://whosright.com')); //'http://v2.whosright.local');

	// your facebook and twitter keys to enable users using those accounts for commenting
	define("FACEBOOK_APP_ID", "");
	define("TWITTER_CONSUMER_KEY", "");
	define("TWITTER_CONSUMER_SECRET", "");
	
	
	// you don't need to change these, internal use by the plugin only
	define('WR_API_URL', WR_API_HOST.'/api/v1/');
	define('USE_HTTP_AUTH', false);
	define('WR_API_USER', '');
	define('WR_API_PASS', '');
?>
