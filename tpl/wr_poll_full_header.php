<?php
	if ($wr_poll['user']['thumb'] == '') {
		$wr_poll['user']['thumb'] = $wr_image_host.'/images/anon_user.png';
	}
?>
<?php if ($wr_poll['vote_result']) { ?>
	<td valign='top' width='100%' style='padding: 5px'>
		<div class='related_polls rounded_4' style='margin-top: 5px; margin-left: 10px; margin-bottom: 5px; float: right;' <?php if ($wide_embed) { ?>style='width: 150px'<?php } ?>>
			<h3>Related polls</h3>
			<?php
				$count=0;
				foreach ($wr_related as $obj) {
					if ($count < 4) {?>
						<p style='font-weight: bold; margin-top: 0.5em; margin-bottom: 0;'><a href="<?php echo $obj['permalink'] ?>"><?php echo $obj['title'] ?></a></p>
						<?php $count = $count + 1; ?>
					<?php } ?>
			<?php } ?>
		</div>
		<?php if (isset($wr_poll['attachments'])) { foreach ($wr_poll['attachments'] as $vs) { ?>
			<?php if ($vs['format'] == 1) { ?>
				<div class='vs_obj'>
					<img src="<?php echo $vs['url'] ?>" width='138' border='0' style='width: 138px' />
				</div>
			<?php } else if ($vs['format'] == 2) { ?>
				<?php if (strpos($vs['url'], '/cnn/')) { ?>
					<?php $wide_embed = true; ?>
					<div class='vs_obj' style='width: 430px; height: 380px; float: none; margin-bottom: 2em;'>
						<?php echo $vs['url'] ?>
					</div>
				<?php } else { ?>
					<div class='vs_obj' style='width: 280px; height: 200px; float: none; margin-bottom: 2em;'>
						<?php echo $vs['url'] ?>
					</div>
				<?php } ?>
			<?php } ?>
		<?php } } ?>
		<a href="http://whosright.com/<?php if (!$wr_poll['user']['vip_account']) { echo 'users/'; } echo $wr_poll['user']['name'] ?>">
			<img class='author_thumb' src="<?php if (substr($wr_poll['user']['thumb'], 0, 4) != 'http') { echo WR_API_HOST; } echo $wr_poll['user']['thumb'] ?>" width='32' height='32' border='0' style='width: 32px; height: 32px' />
		</a>
		<p class='post_text'>
			<a href="http://whosright.com/<?php if (!$wr_poll['user']['vip_account']) { echo 'users/'; } echo $wr_poll['user']['name'] ?>">
				<span class='author'><?php echo $wr_poll['user']['first_name'].' '.$wr_poll['user']['last_name'] ?></span>
			</a>
			<span class='post_description'><?php echo $wr_poll['description'] ?></span>
		</p>

		<table width='100%' border='0' style='margin-top: 10px'>
		<?php foreach($wr_poll['options'] as $option) { ?>
			<tr>
				<td valign='top'>
					<span class='option_letter'><?php if ($wr_poll['advanced']) { echo $option['option_index']+1; } else { echo $option['option_letter']; } ?></span>
				</td>
				<td width='80%'>
					<span class='vote_result'>
						<div class='bar rounded_3' style="width: 0%" value="<?php echo round($option['percentage']) ?>%"></div>
						<div style='width: 100%' class='text post_option_text'><?php echo $option['title'] ?></div>
					</span>
				</td>
				<td valign='top'>
					<span style='padding-left: 5px'><?php echo $option['percentage'] ?>%</span>
				</td>
			</tr>
		<?php } ?>
		</table>
	</td>
<?php } else { ?>
	<td valign='top'>
		<div class='post_options_wrapper' <?php if ($wide_embed) { ?>style='width: 160px'<?php } ?> style='float: right; margin-left: 10px; margin-bottom: 10px;'>
			<?php if (isset($wr_poll['options'])) foreach ($wr_poll['options'] as $option) { ?>
				<p class='post_option'>
					<span class='option_letter'><?php if ($wr_poll['advanced']) { echo $option['option_index']+1; } else { echo $option['option_letter']; } ?></span>
					<input name="vote<?php echo $wr_poll['id']?>" id="<?php echo $wr_poll['id'].$option['id']?>" value="<?php echo $option['option_index'] ?>" type='radio' />
					<label for="<?php echo $wr_poll['id'].$option['id'] ?>"><span class='post_option_text'><?php echo $option['title'] ?></span></label>
				</p>
			<?php } ?>
		</div>
		<div style='padding-left: 7px; padding-top: 7px; padding-right: 7px;'>
			<?php if (isset($wr_poll['attachments'])) foreach ($wr_poll['attachments'] as $vs) { ?>
				<?php if ($vs['format'] == 1) { ?>
					<div class='vs_obj'>
						<img src="<?php echo $vs['url'] ?>" width='138' border='0' style='width: 138px' />
					</div>
				<?php } else if ($vs['format'] == 2) { ?>
					<?php if (strpos($vs['url'], '/cnn/')) { ?>
						<?php $wide_embed = true; ?>
						<div class='vs_obj' style='width: 430px; height: 380px; float: none; margin-bottom: 2em;'>
							<?php echo $vs['url']; ?>
						</div>
					<?php } else { ?>
						<div class='vs_obj' style='width: 280px; height: 200px; float: none; margin-bottom: 2em;'>
							<?php echo $vs['url'] ?>
						</div>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			<div style='width: 100%'>
				<a href="http://whosright.com/<?php if (!$wr_poll['user']['vip_account']) { echo 'users/'; } echo $wr_poll['user']['name'] ?>">
					<img class='author_thumb' src="<?php if (substr($wr_poll['user']['thumb'], 0, 4) != 'http') { echo WR_API_HOST; } echo $wr_poll['user']['thumb'] ?>" width='32' height='32' border='0' style='width: 32px; height: 32px;' />
				</a>
				<p class='post_text'>
					<a href="http://whosright.com/<?php if (!$wr_poll['user']['vip_account']) { echo 'users/'; } echo $wr_poll['user']['name'] ?>">
						<span class='author'><?php echo $wr_poll['user']['first_name'].' '.$wr_poll['user']['last_name'] ?></span>
					</a>
					<span class='post_description'><?php echo $wr_poll['description'] ?></span>
				</p>
			</div>
			<a href='http://whosright.com/poll/<?php echo $wr_poll['titleSlug'] ?>' target='_blank' title='<?php echo $wr_poll['title'] ?>'>
				<img src='<?php echo get_option('siteurl') ?>/wp-content/plugins/whosright/images/poweredby.png' border='0' style='float: left; clear: both; margin: 5px; cursor: pointer;' />
			</a>
		</div>
	</td>
<?php } ?>
