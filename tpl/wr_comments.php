<?php $url = get_option('siteurl')."/wp-content/plugins/whosright"; ?>
<a name='respond'></a>
<input id='wr_plugin_url' type='hidden' value='<?php echo $wr_plugin_url ?>' />

<script type='text/javascript'>
	function loginWhosright() {
		window.open("<?php echo $wr_host ?>/login_extern?return=<?php echo get_option('siteurl') ?>/wp-content/plugins/whosright/whosright_login_return.php", "_blank", "location=0,status=0,menubar=1,height=460,width=330,resizable=0"); 
		return false;
	}
	function logoutWhosright() {
		window.open("<?php echo $wr_host ?>/logout_extern?return=<?php echo get_option('siteurl') ?>/wp-content/plugins/whosright/whosright_login_return.php", "_blank", "location=0,status=0,menubar=1,height=460,width=330,resizable=0"); 
	}
	function whosrightLoginCallback(logged_in) {
		if (logged_in) {
			saveCommentData();
			document.location.reload();
		}
	}
	function whosrightLogoutCallback() {
		<?php if ($wr_user) { ?>
			saveCommentData();
			document.location.reload();
		<?php } else { ?>
			jQuery.each(jQuery('#whosright iframe.login_frame'), function(i, f) {
				f.src = f.src;
			});
		<?php } ?>
	}
</script>

<div id='fadeout'></div>
<div id='attach'>
	<div class='attach_tabs'>
		<div onClick='attach_video()' class='tab tab_attach_video' style="background-image: url('<?php echo $url ?>/tab_attach_video.png');"></div>
		<div onClick='attach_photo()' class='tab tab_attach_photo' style="background-image: url('<?php echo $url ?>/tab_attach_photo.png');"></div>
	</div>

	<div class='tab_content attach_video_content'>
		<p>Insert <img src='<?php echo $url ?>/logo_youtube_small.png' border='0' /> link or embed code</p>
		<input class='youtube_link' type='text' width='100%' name='youtube_code' />
		
		<div class='video_preview'>
			<center><img src='<?php echo $url ?>/logo_youtube.png' border='0' style='margin-top: 30px' /></center>
		</div>
		
		<span><input class='button rounded_4 submit_button' type='button' value='Submit' /></span>
		<input class='button rounded_4 cancel_button' type='button' value='Cancel' />
		<input class='button rounded_4 remove_button' type='button' value='Remove Media' />
	</div>

	<div class='tab_content attach_photo_content'>
		<p>Upload a photo from your computer <img src='<?php echo $url ?>/icon_photo.png' border='0' /></p>

		<form method='post' enctype='multipart/form-data' action='<?php echo $url ?>/rpcs/uploadAttachment.php'>
			<input type='file' name='photo' style='width: 100%' />
		</form>

		<div class='photo_preview'>
			<center><img src='<?php echo $url ?>/logo_uploadphoto.png' border='0' style='margin-top: 30px' /></center>
		</div>
		<span><input class='button rounded_4 submit_button' type='button' value='Submit' /></span>
		<input class='button rounded_4 cancel_button' type='button' value='Cancel' />
		<input class='button rounded_4 remove_button' type='button' value='Remove Media' />
	</div>
</div>

<div class='post rounded_5' style='padding: 5px'>
	<script type='text/javascript'>
		function saveCommentData() {
			var comment = jQuery('#whosright .main_comment_form textarea[name=comment]').val();
			var attach = jQuery('#whosright .main_comment_form input[name=attach_media]').val();
			var anon = jQuery('#whosright .main_comment_form input[name=anonymous]').attr('checked');
			var options = { path: '/', expires: 1 };

			jQuery.cookie('wr_tmp_comment', comment, options);
			jQuery.cookie('wr_tmp_attach', attach, options);
			jQuery.cookie('wr_tmp_anon', anon, options);
		}
	</script>

	<script type='text/javascript'>
		jQuery(document).ready(function() {
			var options = { path: '/', expires: 1 };

			if (jQuery.cookie('wr_tmp_comment')) {
				$('#whosright .main_comment_form textarea[name=comment]').val(jQuery.cookie('wr_tmp_comment'));
				$('#whosright .main_comment_form input[name=attach_media]').val(jQuery.cookie('wr_tmp_attach')).trigger('change');
				if (jQuery.cookie('wr_tmp_anon') == 'true') {
					$('#whosright .main_comment_form input[name=anonymous]').attr({ 'checked': 'checked' });
				}
			}
			jQuery.cookie('wr_tmp_comment', null, options);
			jQuery.cookie('wr_tmp_attach', null, options);
			jQuery.cookie('wr_tmp_anon', null, options);
		});
	</script>

		<a href='http://whosright.com/poll/<?php echo $wr_poll['titleSlug'] ?>' target='_blank' title='<?php echo $wr_poll['title'] ?>'>
			<img src='<?php echo get_option('siteurl') ?>/wp-content/plugins/whosright/images/poweredby.png' alt="At WhosRight.com, we provide you with the tools to instantly Create media-rich polls and Share them with your friends and the community to finally determine Who's Right?" border='0' style='float: left; margin: 5px; cursor: pointer;' />
		</a>
	<?php 
		if (!$wr_user) { 
			echo "<iframe class='login_frame' src='".WR_API_HOST."/login_extern?network=facebook&rnd=".rand()."&return=".get_option('siteurl')."/wp-content/plugins/whosright/whosright_login_return.php' border='0' frameborder='0' width='82' height='22' style='float: right; margin: 5px;'></iframe>";
			echo "<iframe class='login_frame' src='".WR_API_HOST."/login_extern?network=twitter&rnd=".rand()."&return=".get_option('siteurl')."/wp-content/plugins/whosright/whosright_login_return.php' border='0' frameborder='0' width='82' height='22' style='float: right; margin: 5px;'></iframe>";
			echo "<iframe class='login_frame' src='".WR_API_HOST."/login_extern?network=myspace&rnd=".rand()."&return=".get_option('siteurl')."/wp-content/plugins/whosright/whosright_login_return.php' border='0' frameborder='0' width='82' height='22' style='float: right; margin: 5px;'></iframe>";
			?><img src='<?php echo get_option('siteurl') ?>/wp-content/plugins/whosright/images/btn_whosright_small.png' border='0' style='float: right; margin: 5px; cursor: pointer;' onClick='loginWhosright()' />
			<p style='margin: 5px'>Log in to make a comment.</p>
		<?php
		} else {
			echo "<p style='margin: 5px'>Logged in as ".$wr_user['first_name'].' '.$wr_user['last_name']." <a href='javascript:void()' onClick='logoutWhosright(); return false;'><u>Logout</u></a></p>";
		}
	?>

	<form method='post' action='<?php echo $wr_plugin_url ?>/rpcs/postComment.php' class='post_comment_form main_comment_form'>
		<input type='hidden' name='id' value="<?php echo $wr_poll['id'] ?>" />
		<input type='hidden' name='wr_api_token' value="<?php echo @$_COOKIE['wr_api_token']; ?>" />
		<textarea name='comment' style='width: 98%' rows='5' class='rounded_5'><?php echo @$_GET['comment'] ?></textarea>
		<div class='media_preview'></div>
		<table width='98%' cellpadding='0' cellspacing='0'>
			<tr>
				<td>
					<span class='attach_media_text'>Attach media:</span>
					<input type='hidden' name='attach_media' value='<?php @$_GET['attach_media'] ?>' />
					<div class='comment_attach_btn icon_video' onClick="g_attach_source = $(this).parents('form').find('input[name=attach_media]'); attach_video();"></div>
					<div class='comment_attach_btn icon_picture' onClick="g_attach_source = $(this).parents('form').find('input[name=attach_media]'); attach_photo();"></div>
				</td>
				<td align='right'>
					<input type='checkbox' name='anonymous' id='anonymous' <?php if ($_GET['anonymous'] == 'on') { ?>checked<?php } ?>/>
					<label for='anonymous'>Make Anonymous</label>
					<?php if (!$wr_user) { ?>
						<input type='button' onClick='alert("Please login to make a comment");' value='Submit Comment' class='rounded_5 button comment_button' />
					<?php } else { ?>
						<input type='submit' value='Submit Comment' class='rounded_5 button comment_button' />
					<?php } ?>
				</td>
			</tr>
		</table>
	</form>

	<?php
		$grand_parent = false;
		$level = 0;
		$child_wrapper_open = false;
		if (isset($wr_poll['comments_list'])) { foreach ($wr_poll['comments_list'] as $comment) {
			if ($comment['parent_id'] == 0) {
				$grand_parent = $comment['id'];
				$level = 0;
			} else {
				$last_parent = $comment['parent_id'];
				if ($comment['parent_id'] > 0 && $comment['parent_id'] == $grand_parent) {
					$level = 1;
				} else {
					$level = 2;
				}
			}
			if ($comment['parent_id'] == 0 && $child_wrapper_open == true) {
				$child_wrapper_open = false;
				echo "</div>";
			}
			if ($level == 1) {
				echo "<div class=\"spacer spacer_straight spacer_indent_long_{$comment['side']}\" style='height: 100%'></div>";
			}
			if ($comment['is_anonymous']) {
				$comment['user']['thumb'] = $wr_image_host.'/images/anon_user.png';
				$comment['user']['first_name'] = 'Anonymous';
				$comment['user']['last_name'] = '';
			}
			if ($comment['user']['thumb'] == '') {
				$comment['user']['thumb'] = $wr_image_host.'/images/anon_user.png';
			}
		?>
			<div class="comment_outer <?php if ($comment['parent_id']) { ?>nested_comment<?php } ?>">
				<?php if ($comment['has_children']) { ?>
					<div class='spacer spacer_straight spacer_indent<?php echo $level ?>'></div>
				<?php } ?>
				<?php if ($level == 1) { ?>
					<?php if ($comment['has_children']) { ?>
						<div class='spacer spacer_straight spacer_indent<?php echo $level ?>'></div>
					<?php } ?>
					<div class="spacer spacer_<?php echo $comment['side'] ?>"></div>
					<div class="spacer spacer_white spacer_white_<?php echo $comment['oside'] ?>"></div>
				<?php } ?>
				<?php if ($level >= 2) { ?>
					<div class='spacer spacer_white spacer_white_left'></div>
					<div class='spacer spacer_white spacer_white_right'></div>
				<?php } ?>
				<div class="comment rounded_5">
					<input type='hidden' name='comment_id' value="<?php echo $comment['id'] ?>" />
					
					<!-- comment author thumb / vote info -->
					<div class='comment_author_wrapper' style="<?php echo $comment['side'] ?>: 0px; margin-<?php echo $comment['oside'] ?>: 5px;">
						<?php if (!$comment['is_anonymous']) { ?><a href="http://whosright.com/<?php if (!$comment['user']['vip_account']) { ?>users/<?php } ?><?php echo $comment['user']['name'] ?>"><?php } ?>
							<img src="<?php if (substr($comment['user']['thumb'], 0, 4) != 'http') { echo WR_API_HOST; } echo $comment['user']['thumb'] ?>" width='32' height='32' border='0' style='margin-top: 5px; width: 32px; height: 32px;' /><br />
						<?php if (!$comment['is_anonymous']) { ?></a><?php } ?>
						<span class='vote-choice'><?php echo strtoupper($comment['vote_choice']) ?></span>
						<input type='button' value='Reply' class='button reply_button rounded_5' style='margin-bottom: 5px' />
					</div>

					<!-- attached media (if any) -->
					<?php if ($comment['media']) { ?>
					<div style="float: <?php echo $comment['oside'] ?>">
						<div class='media_obj'>
							<?php if ($comment['media']['format'] == 1) { ?>
								<img src="<?php if (substr($comment['media']['url'], 0, 4) != 'http') { echo WR_API_HOST; } echo $comment['media']['url'] ?>" width='200' border='0' style='width: 200px' />
							<?php } else if ($comment['media']['format'] == 2) { ?>
								<?php echo $comment['media']['url']; ?>
							<?php } ?>
						</div>
					</div>
					<?php } ?>

					<!-- comment author name, timestamp and text in center -->
					<div style="text-align: <?php echo $comment['side'] ?>; min-height: 100px; margin-<?php echo $comment['side'] ?>: 65px;">
						<div style="float: <?php echo $comment['oside'] ?>;" class='comment_timestamp'><?php echo $comment['created_at'] ?></div>
						<div class='comment_text'>
							<h5>
								<?php if ($comment['side'] == 'right') { ?>
									<?php if ($comment['user']['id'] == $wr_user['id']) { ?>
										<span class='comment_edit'><span class='icon'></span>Edit</span>
										<span class='comment_delete'><span class='icon'></span>Delete</span>
									<?php } else if (current_user_can('moderate_comments')) { ?>
										<span class='comment_delete'><span class='icon'></span>Delete</span>
									<?php } ?>
								<?php } ?>
								<?php if (!$comment['is_anonymous']) { ?><a href="http://whosright.com/<?php if (!$comment['user']['vip_account']) { ?>users/<?php } echo $comment['user']['name']; ?>"><?php } ?>
								
								<?php echo $comment['user']['first_name'].' '.$comment['user']['last_name']; ?>
								<?php if (!$comment['is_anonymous']) { ?></a><?php } ?>
								<?php if ($comment['side'] == 'left') { ?>
									<?php if ($comment['user']['id'] == $wr_user['id']) { ?>
										<span class='comment_edit'><span class='icon'></span>Edit</span>
										<span class='comment_delete'><span class='icon'></span>Delete</span>
									<?php } else if (current_user_can('moderate_comments')) { ?>
										<span class='comment_delete'><span class='icon'></span>Delete</span>
									<?php } ?>
								<?php } ?>
							</h5>
							<p><?php echo $comment['comment'] ?></p>
						</div>
					</div>
				</div>
			</div>
			<?php if ($comment['parent_id'] == 0) { ?>
				<?php $child_wrapper_open = true; ?>
				<div class='comment_children_wrapper'>
			<?php } ?>
	<?php
		} }
	?>
	<?php
		if ($child_wrapper_open == true) {
			$child_wrapper_open = false;
			echo "</div>";
		}
	?>
</div>

