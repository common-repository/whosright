<?php 
	if ($wr_poll['user']['thumb'] == '') {
		$wr_poll['user']['thumb'] = $wr_image_host.'/images/anon_user.png';
	}
?>
<div class='post rounded_5' >
	<div class='title'>
		<h2 class='post_title'><a href="<?php the_permalink(); ?>"><?php echo $wr_poll['title'] ?></a></h2>
	</div>
	<table width='100%'>
		<tr class='poll_full_header_wrapper'>
			<td valign='top'>
				<?php if (isset($wr_poll['attachments'])) { foreach ($wr_poll['attachments'] as $vs) { ?>
					<?php if ($vs['format'] == 1) { ?>
						<div class='vs_obj' style='float: left'>
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
					<?php } else { ?>
						<div style='padding: 5px'><?php echo $vs['url'] ?></div>
					<?php } ?>
				<?php } } ?>
				<p class='post_text' style='margin-top: 1em; margin-left: 5px;'>
					<a href='http://whosright.com/poll/<?php echo $wr_poll['titleSlug'] ?>' target='_blank' title='<?php echo $wr_poll['title'] ?>'>
						<img src='<?php echo get_option('siteurl') ?>/wp-content/plugins/whosright/images/poweredby.png' border='0' alt="At WhosRight.com, we provide you with the tools to instantly Create media-rich polls and Share them with your friends and the community to finally determine Who's Right?" style='float: right; margin: 5px; cursor: pointer;' />
					</a>
					<span class='post_description'><?php echo $wr_poll['description'] ?></span>
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<hr />
			</td>
		</tr>
		<tr>
			<td align='left' valign='top'>
				<?php if (!$wr_poll['list_mode']) { ?>
					<table class='social_controls' cellpadding='0' cellspacing='0'>
						<tr>
							<td>
								<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo the_permalink() ?>&amp;layout=button_count&amp;show_faces=false&amp;width=10&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:26px; margin-top: 6px;" allowTransparency="true"></iframe>
							</td>
							<td>
								<div style='padding-top: 6px'>
									<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
								</div>
							</td>
						</tr>
					</table>
				<?php } ?>
				<div style='padding-left: 7px; padding-bottom: 7px'>
					<span>Votes <?php echo $wr_poll['votes'] ?></span>
					<img src='<?php echo $wr_image_host ?>/images/icon_votes.png' border='0' />
					
					<span>Comments <?php echo $wr_poll['comments'] ?></span>
					<img src='<?php echo $wr_image_host ?>/images/icon_comments.png' border='0' />

					<?php if ($wr_poll['list_mode']) { ?>
					<div style='padding-right: 7px; padding-bottom: 7px; float: right'>
							<input type='button' class='button vote_button rounded_5' value="<?php if ($wr_poll['vote_result']) { echo 'Results'; } else { echo 'Vote'; } ?>" onClick="window.location='<?php the_permalink(); ?>'" />
					</div>
					<?php } ?>
				</div>
			</td>
		</tr>
	</table>
</div>
<?php if (!$wr_poll['list_mode']) { ?>
	<div class='post rounded_5' id='poll_full_advanced_options_wrapper'>
		<?php include('wr_poll_full_advanced_options.php'); ?>
	</div>
<?php require_once('wr_poll_advanced_script.php'); ?>
<?php } ?>

<br />


