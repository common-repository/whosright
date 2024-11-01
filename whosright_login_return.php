<?php
	if (isset($_GET['wr_user_id']) && isset($_GET['wr_api_token'])) {
		require_once('../../../wp-load.php');
		require_once('config.php');
		require_once('WhosRightApiV1.php');
		
		$whosright_api = new WhosRightApiV1(get_option('whosright_api_key'), get_option('whosright_api_token'), get_option('whosright_api_host').'/api/v1/');
		$ret_json = $whosright_api->isTokenValid($_GET['wr_api_token']);
		$ret = json_decode($ret_json, true);
		if (isset($ret['status']) && $ret['status'] == 'error') {
			setcookie('wr_user_id', false, time() - 60*60*24, '/');
			setcookie('wr_api_token', false, time() - 60*60*24, '/');
			$function = 'whosrightLogoutCallback()';
		} else {
			setcookie('wr_user_id', $_GET['wr_user_id'],  time()+60*60*24*30, '/');
			setcookie('wr_api_token', $_GET['wr_api_token'],  time()+60*60*24*30, '/');
			$function = 'whosrightLoginCallback(true)';
		}
	} else {
		setcookie('wr_user_id', false, time() - 60*60*24, '/');
		setcookie('wr_api_token', false, time() - 60*60*24, '/');
		$function = 'whosrightLogoutCallback()';
	}
?>
<html>
	<head>
		<meta http-Equiv="Cache-Control" Content="no-cache">
		<meta http-Equiv="Pragma" Content="no-cache">
		<meta http-Equiv="Expires" Content="0">

		<script type='text/javascript'>
			function onLoad() {
				setTimeout(function() { 
					if (window.parent && window.parent.whosrightLoginCallback) { 
						window.parent.<?php echo $function ?>; 
					} 
					if (window.opener && window.opener.whosrightLoginCallback) { 
						window.opener.<?php echo $function ?>; 
						window.close(); 
					}
				}, 1000);
			}
		</script>
	</head>
	<body onload="onLoad()"></body>
</html>
