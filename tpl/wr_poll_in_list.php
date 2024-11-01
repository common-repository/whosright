<?php
	require_once('wp-content/plugins/whosright/render_functions.php');
	if ($wr_poll['user']['thumb'] == '') {
		$wr_poll['user']['thumb'] = $wr_image_host.'/images/anon_user.png';
	}
?>
<div class='list_poll_wrapper'>
	<form method='post' class='poll_vote_form' action='<?php echo $wr_plugin_url ?>/rpcs/vote.php'>
		<input type='hidden' name='vote' value="<?php echo $wr_poll['id'] ?>" />
		<input type='hidden' name='wordpress_id' value='<?php the_ID() ?>' />
		<input type='hidden' name='wordpress_permalink' value='<?php the_permalink() ?>' />
		<input type='hidden' name='require_code' value="<?php echo $wr_poll['require_code'] ?>" />
		<input type='hidden' name='voting_code' value="" />
		<div class='post rounded_5' >
			<div class='title'>
				<h2><a href="<?php the_permalink(); ?>"><?php echo shorten($wr_poll['title'], 100) ?></a></h2>
			</div>
			<table width='100%'>
				<tr>
					<?php if ($wr_poll['vote_result']) { ?>
						<td valign='top' width='60%'>
							<div class='poll_header'>
								<?php if (isset($wr_poll['attachments'])) { foreach ($wr_poll['attachments'] as $vs) { ?>
									<?php if ($vs['format'] == 1) { ?>
										<div class='vs_obj'>
											<a href="<?php the_permalink(); ?>">
												<img src="<?php echo $vs['url'] ?>" width='138' border='0' style='width: 138px' />
											</a>
										</div>
									<?php } elseif ($vs['format'] == 2) { ?>
										<?php if ($vs['thumb'] != '') { ?>
											<div class='vs_obj'>
												<a href="<?php the_permalink(); ?>">
													<img src="<?php echo $vs['thumb'] ?>" width='138' border='0' style='width: 138px' />
												</a>
											</div>
										<?php } else { ?>
											<?php if (strpos($vs['url'], "/cnn/")) { ?>
												<div class='vs_obj' style='width: 430px; height: 300px; float: none; margin-bottom: 2em;'>
													<?php echo $vs['url'] ?>
												</div>
											<?php } else { ?>
												<div class='vs_obj' style='width: 280px; height: 200px; float: none; margin-bottom: 2em;'>
													<?php echo $vs['url'] ?>
												</div>
											<?php } ?>
										<?php } ?>
									<?php } ?>
								<?php } } ?>
								<a href="http://whosright.com/<?php if (!$wr_poll['user']['vip_account']) { ?>users/<?php } ?><?php echo $wr_poll['user']['name'] ?>">
									<img class='author_thumb' src="<?php if (substr($wr_poll['user']['thumb'], 0, 4) != 'http') { echo WR_API_HOST; } echo $wr_poll['user']['thumb'] ?>" width='32' height='32' border='0' style='width: 32px; height: 32px' />
								</a>
								<p class='post_text'>
									<a href="http://whosright.com/<?php if (!$wr_poll['user']['vip_account']) { ?>users/<?php } ?><?php echo $wr_poll['user']['name'] ?>">
										<span class='author'><?php echo $wr_poll['user']['first_name'].' '.$wr_poll['user']['last_name'] ?></span>
									</a>
									<?php echo shorten($wr_poll['description'], 300) ?>
								</p>
							</div>
							<table style='width: 350px; margin-left: 5px; margin-top: 5px;'>
							<?php foreach ($wr_poll['options'] as $option) { ?>
								<tr>
									<td valign='top'>
										<span class='option_letter'><?php if ($wr_poll['advanced']) { echo $option['option_index']+1; } else { echo $option['option_letter']; }?></span>
									</td>
									<td width='95%' valign='top'>
										<span class='vote_result'>
											<div class='bar rounded_3' style="width: 0%" value="<?php echo round($option['percentage']) ?>%"></div>
											<span class='text'><?php echo $option['title'] ?></span>
										</span>
									</td>
									<td valign='top'>
										<span style='padding-left: 5px'><?php echo $option['percentage'] ?>%</span>
									</td>
								</tr>
							<?php } ?>
							</table>
						</td>
						<td valign='top'>
							<div class='related_polls rounded_4'>
								<h3 style='margin: 5px'>Related polls</h3>
								<?php $count=0;
								if (isset($wr_poll['related'])) { foreach ($wr_poll['related'] as $obj) {
									if ($count < 4) { ?>
										<p style='font-weight: bold; padding-left: 5px; margin-bottom: 0em; height: 1.5em; overflow: hidden; width: 200px;'>
											<a href="<?php echo $obj['permalink'] ?>"><?php echo $obj['title'] ?></a>
										</p>
										<?php $count = $count + 1;
									}
								} } ?>
							</div>
						</td>
					<?php } else { ?>
						<td valign='top'>
							<div class='poll_header'>
								<?php if (isset($wr_poll['attachments'])) { foreach ($wr_poll['attachments'] as $vs) { ?>
									<?php if ($vs['format'] == 1) { ?>
										<div class='vs_obj'>
											<a href="<?php the_permalink(); ?>">
												<img src="<?php echo $vs['url'] ?>" width='138' border='0' style='width: 138px' />
											</a>
										</div>
									<?php } elseif ($vs['format'] == 2) { ?>
										<?php if ($vs['thumb'] != '') { ?>
											<div class='vs_obj'>
												<a href="<?php the_permalink(); ?>">
													<img src="<?php echo $vs['thumb'] ?>" width='138' border='0' style='width: 138px' />
												</a>
											</div>
										<?php } else { ?>
											<?php if (strpos($vs['url'], "/cnn/")) { ?>
												<?php $wide_embed = true; ?>
												<div class='vs_obj' style='width: 430px; height: 300px; float: none; margin-bottom: 2em;'>
													<?php echo $vs['url'] ?>
												</div>
											<?php } else { ?>
												<div class='vs_obj' style='width: 280px; height: 200px; float: none; margin-bottom: 2em;'>
													<?php echo $vs['url'] ?>
												</div>
											<?php } ?>
										<?php } ?>
									<?php } ?>
								<?php } }?>
								<a href="http://whosright.com/<?php if (!$wr_poll['user']['vip_account']) { ?>users/<?php } ?><?php echo $wr_poll['user']['name'] ?>">
									<img class='author_thumb' src="<?php if (substr($wr_poll['user']['thumb'], 0, 4) != 'http') { echo WR_API_HOST; } echo $wr_poll['user']['thumb'] ?>" width='32' height='32' border='0' style='width: 32px; height: 32px' />
								</a>
								<p class='post_text'>
									<a href="http://whosright.com/<?php if (!$wr_poll['user']['vip_account']) {?>users/<?php } ?><?php echo $wr_poll['user']['name'] ?>">
										<span class='author'><?php echo $wr_poll['user']['first_name'].' '.$wr_poll['user']['last_name'] ?></span>
									</a>
									<?php echo shorten($wr_poll['description'], 300) ?>
								</p>
							</div>
							<div style='clear: both'>
								<table cellpadding='0' cellspacing='0'>
									<tr>
										<?php $count = 0;
										if (isset($wr_poll['vs'])) { foreach ($wr_poll['vs'] as $vs) {
											$count = $count + 1;
											if ($count < 3) { ?>
												<td align='left' valign='center'>
													<?php if ($vs['format'] == 1) { ?>
														<div class='vs_obj'>
															<a href="<?php the_permalink(); ?>">
																<img src="<?php echo $vs['url'] ?>" width='138' border='0' style='width: 138px' />
															</a>
														</div>
													<?php } elseif ($vs['format'] == 2) { ?>
														<?php if ($vs['thumb'] != '') { ?>
															<div class='vs_obj'>
																<a href="<?php the_permalink(); ?>">
																	<img src="<?php echo $vs['thumb'] ?>" width='138' border='0' style='width: 138px' />
																</a>
															</div>
														<?php } else { ?>
															<div class='vs_obj' style='width: 280px; height: 200px'>
																<?php echo $vs['url'] ?>
															</div>
														<?php } ?>
													<?php } ?>
												</td>
												<?php if ($count == 1 && count($wr_poll['vs']) > 1) { ?>
												<td>
													<img src='<?php echo $wr_image_host ?>/images/vs.png' class='vs' border='0' />
												</td>
												<?php } ?>
											<?php } ?>
										<?php } } ?>
									</tr>
								</table>
							</div>
						</td>
						<td valign='top' width='300'>
							<div class='post_options_wrapper' <?php if ($wide_embed) { ?>style='width: 160px'<?php } ?>>
								<?php if (isset($wr_poll['options'])) { foreach ($wr_poll['options'] as $option) { ?>
									<p class='post_option'>
										<span class='option_letter'><?php if ($wr_poll['advanced']) { echo $option['option_index']+1; } else { echo $option['option_letter']; } ?></span>
										<input name="vote<?php echo $wr_poll['id']?>" id="<?php echo $wr_poll['id'].$option['id']?>" value="<?php echo $option['option_index'] ?>" type='radio' />
										<label for="<?php echo $wr_poll['id'].$option['id'] ?>" ><?php echo shorten($option['title'], 100) ?></label>
									</p>
								<?php } } ?>
							</div>
						</td>
					<?php } ?>
				</tr>
				<tr>
					<td colspan='2'>
						<hr />
					</td>
				</tr>
				<tr>
					<td align='left' valign='top'>
						<div style='padding-left: 7px; padding-bottom: 7px'>
							<span>Votes <?php echo $wr_poll['votes'] ?></span>
							<img src='<?php echo $wr_image_host ?>/images/icon_votes.png' border='0' />
							
							<span>Comments <?php echo $wr_poll['comments'] ?></span>
							<img src='<?php echo $wr_image_host ?>/images/icon_comments.png' border='0' />
						</div>
					</td>
					<td align='right'>
						<div style='padding-right: 7px; padding-bottom: 7px;'>
							<?php if (!$wr_poll['vote_result']) { ?>
								<input type='button' class='button vote_button rounded_5' value='Vote' onClick="window.location='<?php the_permalink(); ?>'" />
							<?php } ?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</form>
</div>
