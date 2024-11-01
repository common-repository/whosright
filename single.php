<?php
	require_once('../../../wp-load.php');
	require_once('config.php');
	require_once('WhosRightApiV1.php');
	$whosright_api = new WhosRightApiV1(WR_API_KEY, WR_API_TOKEN, WR_API_URL);
	require_once('render_functions.php');
	$whosrightpoll = new WhosrightPoll($_GET['wp_id']);
?>
