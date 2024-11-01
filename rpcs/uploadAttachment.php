<?php
	require_once('../../../../wp-load.php');
	require_once('../config.php');
	require_once('../WhosRightApiV1.php');

	if (in_array( strtolower( ini_get( 'magic_quotes_gpc' ) ), array( '1', 'on' ) ) ) {
		$_POST = array_map( 'stripslashes', $_POST );
		$_GET = array_map( 'stripslashes', $_GET );
	}

	if (isset($_FILES['whosright_photo'])) {
		$_FILES['photo'] = $_FILES['whosright_photo'];
	}

	if (isset($_FILES['photo'])) {
		$img_data = getimagesize($_FILES['photo']['tmp_name']);
		if ($img_data === false) {
			echo json_encode(array('error' => 'This doesn\'t look like an image.'));
			return;
		}
		if ($img_data['mime'] != 'image/png' && $img_data['mime'] != 'image/jpg' && $img_data['mime'] != 'image/jpeg' && $img_data['mime'] != 'gif') {
			echo json_encode(array('error' => $img_data['mime'].' is not a supported image format.'));
			return;
		}

		$wr = new WhosRightApiV1(WR_API_KEY, WR_API_TOKEN, WR_API_URL);
		$ret = $wr->uploadAttachment($_FILES['photo']['tmp_name'], $_FILES['photo']['name']);
		$json = json_decode($ret, true);
		if (isset($json['url'])) {
			$json['url'] = WR_API_HOST.$json['url'];
		}
		echo json_encode($json);
	} else {
		echo json_encode(array('error' => 'No photo posted.'));
	}
?>
