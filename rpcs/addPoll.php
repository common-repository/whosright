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

	
	$wr = new WhosRightApiV1(WR_API_KEY, WR_API_TOKEN, WR_API_URL);
	//echo $response;
	
	if (isset($_POST['new_poll'])) {
		$response = $wr->addPoll($data);
		$response_json = json_decode($response, true);
		//print_r($response_json);
		
		global $user_ID;
		$new_post = array(
			'post_title' => $_POST['title'],
			'post_content' => $_POST['desc'],
			'post_status' => 'publish',
			'post_date' => date('Y-m-d H:i:s'),
			'post_author' => $user_ID,
			'post_type' => 'wr_poll',
			'post_category' => array(0)
		);
		$post_id = wp_insert_post($new_post);
		add_post_meta($post_id, "wr_id", $response_json['id']);
		echo $response;
	} else { // edit
		$response = $wr->editPoll($data);
		$response_json = json_decode($response, true);
		echo $response;
	}
	//echo $post_id;
?>
