<script type='text/javascript'>
	var expand_height = 270;
	jQuery(document).ready(function() {
		function expandOption(self) {
			if (!self.hasClass('post_option_advanced_expanded')) {
				jQuery('.post_option_advanced_expanded').removeClass('post_option_advanced_expanded');
				var self_attach = self.find('.attachment');
				jQuery('.attachment').not(self_attach).animate({ height: 0 }, 250, function() { jQuery(this).hide(); });
				self_attach.css({ height: 0 }).show().animate({ height: expand_height }, 250);
				self.addClass('post_option_advanced_expanded');
			} else {
				self.find('.attachment').animate({ height: 0 }, 250, function() { jQuery(this).hide(); });
				self.removeClass('post_option_advanced_expanded');
			}
		}

		function initEvents() {
			if (jQuery('object').html().indexOf('soundcloud.com') == -1) {
				jQuery('#whosright object').attr({ width: 331, height: 263 });
				jQuery('#whosright embed').attr({ width: 331, height: 263 });
			} else {
				jQuery('.attachment').css({ height: 90, paddingTop: 10, paddingRight: 10, marginBottom: 10 });
				expand_height = 81;
			}
			jQuery('#whosright .post_option_advanced label').click(function() { expandOption(jQuery(this).parent()); return false; });
			jQuery('#whosright .post_option_advanced .advanced_play_button').click(function() { expandOption(jQuery(this).parent()); return false; });
			jQuery('#whosright .post_option_advanced .bar_wrapper').click(function() { expandOption(jQuery(this).parent()); return false; });
		}
		initEvents();
		
		jQuery('#whosright .post_option_advanced .advanced_vote_button').click(function() {
			jQuery(this).parent().find('input[type=radio]').trigger('click');
			var form = jQuery(this).parents('form');
			var poll_id = form.find('input[name=vote]').val();
			if (form.find('input[name=require_code]').val() != '0') {
				var code = prompt('Please input your unique code to vote on this poll:');
				form.find('input[name=voting_code]').val(code);
			}
			form.ajaxSubmit({
				dataType: 'json',
				success: function(resp) {
					if (resp.error) {
						alert(resp.error);
					} else {
						if (form.find('input[name=voting_code]').val() != '0') {
							alert('Thanks, vote accepted.');
						}
						var wrapper = jQuery('#poll_full_advanced_options_wrapper');
						var wp_id = form.find('input[name=wordpress_id]').val();
						var link_base = '<?php get_option('siteurl') ?>/wp-content/plugins/whosright/single.php?wp_id=' + wp_id + '&';
						wrapper.load(link_base + 'no_layout=1&mode=full', function() {
							initEvents();
							animateResults(); 
						});
					}
				}
			});
			return false;
		});

	});
</script>
