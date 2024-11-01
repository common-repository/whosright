<br />
<a href='http://whosright.com' target='_blank' title='WhosRight provides a video-based social forum for you, your friends, and the world to air out your opinions and get an answer to the age-old question of WhosRight.'>
	<img src='../wp-content/plugins/whosright/images/poweredby.png' border='0' style='margin: 5px; cursor: pointer;' />
</a>
<style type='text/css'>
	.whosright_settings label {
		width: 200px;
		display: inline-block;
	}
	.whosright_settings input[type=text] {
		width: 300px;
	}
</style>

<form method='post' class='whosright_settings'>
	<?php if (isset($admin) && !isset($admin['status'])) { ?>
		<p style='font-weight: bold; color: green'>API key configured correctly, you are posting as <?php echo $admin['first_name'].' '.$admin['last_name']; ?>.</p>
	<?php } elseif (isset($admin) && isset($admin['status']) && $admin['status'] == 'error') { ?>
		<p style='font-weight: bold; color: red'>API error: <?php echo $admin['message'] ?></p>
	<?php } else { ?>
		<p style='font-weight: bold; color: red'>If you do not have received your API keys yet, go to whosright.com, create an account and retrieve your API key under settings page.</p>
	<?php } ?>
	<label>Whosright API key</label><input type='text' name='whosright_api_key' value='<?php echo get_option('whosright_api_key') ?>' /><br />
	<label>Whosright API token</label><input type='text' name='whosright_api_token' value='<?php echo get_option('whosright_api_token') ?>' /><br />
	<label>Whosright API host</label><input type='text' name='whosright_api_host' value='<?php echo get_option('whosright_api_host', 'http://whosright.com') ?>' /><br />
	<hr />
	<label style='width: 250px' for='whosright_disable_comments'>Disable Whosright comment engine</label><input id='whosright_disable_comments' type='checkbox' name='whosright_disable_comments' <?php echo get_option('whosright_disable_comments', false) ? 'checked' : '' ?> />
	<!-- 
	<label>Facebook API key</label><input type='text' name='whosright_fb_api_key' value='<?php echo get_option('whosright_fb_api_key') ?>' /><br />
	<label>Twitter Consumer Key</label><input type='text' name='whosright_tw_consumer_key' value='<?php echo get_option('whosright_tw_consumer_key') ?>' /><br />
	<label>Twitter Consumer Secret</label><input type='text' name='whosright_tw_consumer_secret' value='<?php echo get_option('whosright_tw_consumer_secret') ?>' /><br />
	-->

	<br />

	<label></label><input type='submit' value='Save Settings' />
</form>
