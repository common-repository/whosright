<form method='post' class='poll_vote_form' action='<?php echo $wr_plugin_url ?>/rpcs/vote.php'>
	<input type='hidden' name='vote' id='poll_id' value="<?php echo $wr_poll['id'] ?>" />
	<input type='hidden' name='wordpress_id' value="<?php the_ID() ?>" />
	<input type='hidden' name='require_code' value="<?php echo $wr_poll['require_code'] ?>" />
	<input type='hidden' name='voting_code' value="" />

	<div class='post_options_wrapper' style='width: 100%; padding-top: 0px;'>
		<?php foreach ($wr_poll['options'] as $option) { ?>
			<div class='post_option post_option_advanced'>
				<?php if (!$wr_poll['vote_result']) { ?>
					<input type='button' class='rounded_3 advanced_button advanced_vote_button' value='VOTE' />
				<?php } ?>
				<?php if (count($option['attachments'])) { ?>
					<?php if ($option['attachments'][0]['format'] == 2) { ?>				
						<input type='button' class='rounded_3 advanced_button advanced_play_button' value='PLAY' />
					<?php } else { ?>
						<input type='button' class='rounded_3 advanced_button advanced_play_button' value='EXPAND' />
					<?php } ?>
				<?php } ?>
				<span class='option_letter'><?php if ($wr_poll['advanced']) { echo $option['option_index']+1; } else { echo $option['option_letter']; } ?></span>
				<input name="vote<?php echo $wr_poll['id']?>" id="<?php echo $wr_poll['id'].$option['id'] ?>" value="<?php echo $option['option_index'] ?>" type='radio' />
				<label for="<?php echo $wr_poll['id'].$option['id']?>"><span class='post_option_text'><?php echo $option['title'] ?></span></label>
				<?php if ($wr_poll['vote_result']) { ?>
					<div class='bar_wrapper'>
						<div class='bar rounded_3' style="width: 0%" value="<?php echo round($option['percentage']) ?>%"></div>
					</div>
					<div class='results_percentage'><?php echo round($option['percentage']) ?>%</div>
				<?php } ?>

				<?php if (count($option['attachments'])) { ?>
					<div class='attachment' style='height: 100%; margin-top: 5px;'>
						<input type='hidden' name='attachment_format' value='<?php echo $option['attachments'][0]['format'] ?>' />
						<?php if ($option['attachments'][0]['format'] == 1 && substr($option['attachments'][0]['url'], 0, 4) == 'http') { ?>
							<img src='<?php echo $option['attachments'][0]['url']; ?>' border='0' />
						<?php } else { ?>
							<?php echo stripslashes($option['attachments'][0]['url']) ?>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
</form>
