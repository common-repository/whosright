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
	//print_r($_POST);

	if (!isset($_POST['voting_code'])) {
		if (!isset($_COOKIE['wr_api_token']) && isset($_COOKIE['voted_'.$_POST['vote']])) {
			echo json_encode(array('error' => 'Sorry, you have already voted on this poll.'));
			return;
		}
	}

	$wr = new WhosRightApiV1(WR_API_KEY, WR_API_TOKEN, WR_API_URL);
	$response = $wr->vote($_POST['vote'], $_POST['vote'.$_POST['vote']], @$_POST['voting_code'], @$_COOKIE['wr_api_token']);
	$response_json = json_decode($response, true);

	if (!isset($response_json['error'])) {
		$_SESSION['votes'][$_POST['vote']] = $_POST['vote'.$_POST['vote']];
		setcookie('voted_'.$_POST['vote'], $_POST['vote'.$_POST['vote']], time() + 60*60*24*30, '/');
	}

	echo $response;	
?>