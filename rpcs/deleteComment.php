<?php
	require_once('../../../../wp-load.php');
	require_once('../config.php');
	require_once('../WhosRightApiV1.php');

	if (in_array( strtolower( ini_get( 'magic_quotes_gpc' ) ), array( '1', 'on' ) ) ) {
		$_POST = array_map( 'stripslashes', $_POST );
		$_GET = array_map( 'stripslashes', $_GET );
	}
	
	//$_POST = array_map( 'addslashes', $_POST );
	//$_GET = array_map( 'addslashes', $_GET );

	$data = $_POST;

	$wr = new WhosRightApiV1(WR_API_KEY, WR_API_TOKEN, WR_API_URL);
	$response = $wr->deleteComment(
		$_GET['poll_id'], 
		$_GET['comment_id'], 
		@$_COOKIE['wr_api_token']
	);
	echo $response;
?>
