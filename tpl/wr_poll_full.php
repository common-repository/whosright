<?php
	if ($wr_poll['user']['thumb'] == '') {
		$wr_poll['user']['thumb'] = $wr_image_host.'/images/anon_user.png';
	}
?>
<form method='post' class='poll_vote_form' action='<?php echo $wr_plugin_url ?>/rpcs/vote.php'>
	<input type='hidden' name='vote' id='poll_id' value="<?php echo $wr_poll['id']; ?>" />
	<input type='hidden' name='wordpress_id' value="<?php the_ID() ?>" />
	<input type='hidden' name='require_code' value="<?php echo $wr_poll['require_code'] ?>" />
	<input type='hidden' name='voting_code' value="" />
	<input type='hidden' name='wordpress_permalink' value='<?php the_permalink() ?>' />

	<div class='post rounded_5' >
		<div class='title'>
			<h2 class='post_title'><?php echo $wr_poll['title']; ?></h2>
		</div>
		<table width='100%' border='0'>
			<tr class='poll_full_header_wrapper'>
				<?php include('wr_poll_full_header.php'); ?>
			</tr>
			<tr>
				<td colspan='2'>
					<hr />
				</td>
			</tr>
			<?php if (count($wr_poll['vs'])) { ?>
			<tr>
				<td colspan='2'>
					<?php if (count($wr_poll['vs']) > 2) {?>
					<div class='scroll_left'>
							<div class='image'></div>
					</div>
					<?php } ?>
					<div class='options_scroll'>
						<table width='100%' cellpadding='0' cellspacing='0'>
							<tr>
							<?php $c = 0; foreach ($wr_poll['vs'] as $vs) { $c++; ?>
								<td>
								<?php if ($vs['format'] == 1) { ?>
									<div class='vs_obj'>
										<img src="<?php echo $vs['url']; ?>" width='280' border='0' style='width: 280px' />
									</div>
								<?php } else if ($vs['format'] == 2) { ?>
									<div class='vs_obj' style='width: 280px; height: 200px'>
										<?php echo $vs['url']; ?>
									</div>
								<?php } ?>
								</td>
								<?php if ($c < count($wr_poll['vs'])) { ?>
									<td valign='middle' style='vertical-align: middle'>
										<img src='<?php echo $wr_image_host ?>/images/vs.png' class='vs' border='0' />
									</td>
								<?php } ?>
							<?php } ?>
							</tr>
							
						</table>
					</div>
					<?php if (count($wr_poll['vs']) > 2) { ?>
					<div class='scroll_right'>
						<div class='image'></div>
					</div>
					<?php } ?>
				</td>
			</tr>
			<tr>
				<td colspan='2'>
					<hr />
				</td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan='2' align='left' valign='top'>
					<table class='social_controls' cellpadding='0' cellspacing='0'>
						<tr>
							<td>
								<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo the_permalink(); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=10&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:26px; margin-top: 6px;" allowTransparency="true"></iframe>
							</td>
							<td>
								<div style='padding-top: 6px'>
									<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
								</div>
							</td>
							<td>
								<?php if (!$wr_poll['vote_result']) { ?>
									<input type='button' class='button vote_button rounded_5' value='Vote' onClick="alert('Click on an option to vote');" />
								<?php } ?>
							</td>
						</tr>
					</table>
					<div style='padding-left: 7px; padding-bottom: 7px'>
						<span>Votes <?php echo $wr_poll['votes']; ?></span>
						<img src='<?php echo $wr_image_host ?>/images/icon_votes.png' border='0' />
						
						<span>Comments <?php echo $wr_poll['comments']; ?></span>
						<img src='<?php echo $wr_image_host ?>/images/icon_comments.png' border='0' />
					</div>
				</td>
			</tr>
		</table>
	</div>
</form>
