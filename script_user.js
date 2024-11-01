function animateResults(parent) {
	if (parent) {
		bars = parent.find('.bar');
	} else {
		bars = jQuery('.bar');
	}
	jQuery.each(bars, function(i, item) {
		jQuery(item).animate({ width: jQuery(item).attr('value') }, 1000);
		//jQuery(item).css({ width: jQuery(item).attr('value') });
	});
}

function hideAddPoll() {
	jQuery('.addpoll_container').css({ zIndex: -2 }).animate({ marginTop: -600 });
}
function showAddPoll() {
	jQuery('.addpoll_container').animate({ marginTop: 0 }, function() { jQuery(this).css({ zIndex: 1 }); });
}

jQuery(document).ready(function() { init_script(); });

function init_script() {
	jQuery('.twitter_connect').click(function() { login_twitter(); });
	jQuery('.facebook_connect').click(function() { login_facebook(); });
	jQuery('#fadeout').css({ opacity: 0.4 });
	jQuery('.header .search_results .background ').css({ opacity: 0.9 });

	jQuery('object').attr({ width: '100%', height: '100%' });
	jQuery('embed').attr({ width: '100%', height: '100%' });

	animateResults();
	
	jQuery('.post .post_option').hover(
		function() { jQuery(this).find('.option_letter').css({ backgroundPosition: '-34px 0px' }) },
		function() { jQuery(this).find('.option_letter').css({ backgroundPosition: '0px 0px' }) }
	);

	jQuery('input.add_poll_button').click(function() {
		if (parseInt(jQuery('.addpoll_container').css('marginTop')) == 0) {
			hideAddPoll();
		} else {
			showAddPoll();
			if (jQuery('.search_box').val() != defaultSearchText) {
				jQuery('.addpoll_container input[name=title]').val(jQuery('.search_box').val()).focus();
			}
		}
	});
	jQuery('#fadeout').click(function() {
		jQuery('#fadeout').fadeOut();
		jQuery('#login').fadeOut();
		jQuery('#attach').fadeOut(0);
	});

	jQuery('.post_option').click(handle_vote);
	
	function handle_vote() {
		//console.log('clicked');
		//console.log(this);
		if (jQuery(this).find('.post_option_text').attr('contentEditable') == 'true') {
			return false;
		}
		if (jQuery(this).hasClass('post_option_advanced')) {
			return false;
		}

		if (!jQuery(this).find('span').hasClass('selected')) {
			jQuery(".post_option span").removeClass("selected"); 
			jQuery(this).find("span").addClass("selected"); 
			jQuery(".post_option input").removeAttr("checked"); 
			jQuery(this).find("input").attr({ "checked":"checked"});
		}
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
					var wrapper = form.parent();
					if (wrapper.hasClass('list_poll_wrapper')) {
						mode = 'list';
					} else {
						wrapper = wrapper.find('.poll_full_header_wrapper');
						mode = 'full';
					}
					var wp_id = form.find('input[name=wordpress_id]').val();
					var link_base = jQuery('#wr_wp_siteurl').val() + '/wp-content/plugins/whosright/single.php?';
					if (mode == 'list') {
						wrapper.animate({ opacity: 0.01 }, 500, function() {
							wrapper.load(link_base + 'wp_id=' + wp_id + '&no_layout=1&mode=' + mode, function() {
								animateResults(); 
								wrapper.animate({ opacity: 1 }, 500);
								wrapper.find('.post_option').click(handle_vote);
							});
						});
					} else {
						wrapper.load(link_base + 'wp_id=' + wp_id + '&no_layout=1&mode=' + mode, function() {
							animateResults();
							wrapper.find('.post_option').click(handle_vote);
						});
					}
				}
			}
		});
		return false;
	};

	jQuery('.addpoll_container form').ajaxForm({ 
		dataType: 'json',
		success: function(resp) {
			if (resp.error) {
				alert(resp.error);
			} else {
				document.location = resp.url;
			}
		}
	});
	jQuery('.addpoll_container .submit_button').click(function() {
		if (jQuery('.addpoll_container select[name=category]').val() == -1) {
			alert('Please choose a category.');
		} else {
			jQuery('.addpoll_container form').submit();
		}
	});
	jQuery('.addpoll_container .cancel_button').click(function() {
		jQuery('.addpoll_container input[type=text]').val('');
		jQuery('.addpoll_container textarea').val('');
		jQuery('.addpoll_container select').val(-1);
		jQuery('.add_poll_button').trigger('click');
	});

	function reProcessOptions() {
		jQuery.each(jQuery('.addpoll_container tr.option'), function(i, item) {
			var num = i + 1;
			jQuery(item).prev().find('th').html('Option ' + num);
			jQuery(item).find('input.option_text').attr({ name: 'whosright_option_' + num });
			jQuery(item).find('input.option_attach_media').attr({ name: 'whosright_attach_media_' + num });
			jQuery(item).find('input.attach_button').attr({ 'class': 'attach_option_ ' + num + ' attach_button' });
			jQuery(item).find('input.delete_button').attr({ 'class': 'attach_delete_' + num + ' delete_button' });
		});
	}

	jQuery('.attach_button').click(function() { attach(jQuery(this).prev()); });
	jQuery('.addpoll_container input[name=add_option]').click(function() {
		var num_options = jQuery('.addpoll_container tr.option').length;
		var limit_options = 5;
		if (jQuery('#post_advanced').attr('checked') == true) { 
			limit_options = 999;
		}
		if (num_options < limit_options) {
			var new_option = jQuery(jQuery('.addpoll_container tr.option')[0]).clone(true);
			++num_options;
			new_option.find('input[name=whosright_option_1]').attr({ name: 'whosright_option_' + num_options }).val('');
			new_option.find('input.attach_option_1').removeClass('attach_option_1').addClass('attach_option_' + num_options);
			new_option.find('input.attach_delete_1').removeClass('attach_delete_1').addClass('attach_delete_' + num_options);
			new_option.find('input[name=whosright_attach_media_1]').attr({ name: 'whosright_attach_media_' + num_options }).val('');
			new_option.insertBefore(jQuery('.addpoll_container .end_option'));
			jQuery('<tr><th>Option ' + num_options + '</th></tr>').insertBefore(new_option);
		}
		reProcessOptions();
	});
	jQuery('.addpoll_container input.delete_button').click(function() {
		var num_options = jQuery('.addpoll_container tr.option').length;
		if (num_options > 2) {
			jQuery(this).parent().parent().prev().remove();
			jQuery(this).parent().parent().remove();
		}
		reProcessOptions();
	});
	
	function toggleAdvanced() {
		if (jQuery('#post_advanced').attr('checked') == true) {
			jQuery('.addpoll_container .option_attach_media').show();
			jQuery('.addpoll_container .option .attach_button').hide();
		} else {
			jQuery('.addpoll_container .option_attach_media').hide();
			jQuery('.addpoll_container .option .attach_button').show();
		}
	}
	jQuery('.addpoll_container .option_attach_media').change(function() {
		jQuery('.addpoll_container .option_media_preview').html(jQuery(this).val());
	});

	jQuery('.addpoll_container input[name=whosright_post_advanced]').click(function() { toggleAdvanced(); });
	jQuery('.addpoll_container #post_advanced_label').click(function() { toggleAdvanced(); });
	
	if (jQuery('.post_comment_form').length) {
		jQuery('.post_comment_form').ajaxForm({
			dataType: 'json',
			success: function(resp) {
				if (resp.error) {
					alert(resp.error);
				} else {
					document.location.reload();
				}
			}
		});
		jQuery('input[name=whosright_attach_media]').change(function() {
			var data = jQuery(this).val();
			if (data != '') {
				if (data.substr(0, 6) == '<embed' || data.substr(0, 7) == '<object') {
					jQuery(this).parents('form').find('.media_preview').html(data);
				} else {
					jQuery(this).parents('form').find('.media_preview').html("<img src='" + data + "' width='150' border='0' />");
				}
				jQuery(this).parents('form').find('.media_preview').fadeIn();
			} else {
				jQuery(this).parents('form').find('.media_preview').fadeOut();
			}
		});
	}
	
	if (jQuery('.photo_upload_form').length) {
		jQuery('.photo_upload_form #photo_upload').change(function() {
			jQuery('.attach_photo_content input[type=button]').hide();
			jQuery('.photo_upload_form').submit();
		});
		jQuery('.photo_upload_form').ajaxForm({
			dataType: 'json',
			success: function(data) {
				jQuery('.attach_photo_content input[type=button]').show();
				if (data.url) {
					jQuery('<img />').attr({ width: 64, height: 64, border: 0, src: data.url }).appendTo(jQuery('.user_thumb_cell').empty());
					jQuery('input[name=photo_url]').val(data.url);
				} else {
					alert(data.error);
				}
			}
		});
	}
	
	if (jQuery('.comment_edit').length) {
		jQuery('.comment_edit').click(function() {
			var self = jQuery(this);
			var comment_id = self.parents('.comment').find('input[name=comment_id]').val();
			var poll_id = jQuery('#poll_id').val();
			var text_container = self.parents('.comment_text').find('p');
			if (jQuery(this).html() == 'Save Changes') {
				jQuery.getJSON(jQuery('#wr_plugin_url').val() + '/rpcs/updateComment.php?poll_id=' + poll_id + '&comment_id=' + comment_id + '&comment=' + encodeURIComponent(text_container.html()), function(data) {
					self.html('Edit<span class="icon"></span>');
				});
			} else {
				text_container.attr({ contentEditable: 'true' }).focus();
				self.html('Save Changes');
			}
		});
	}

	if (jQuery('.comment_delete').length) {
		jQuery('.comment_delete').click(function() {
			var self = jQuery(this);
			var comment_id = self.parents('.comment').find('input[name=comment_id]').val();
			var poll_id = jQuery('#poll_id').val();
			jQuery.getJSON(jQuery('#wr_plugin_url').val() + '/rpcs/deleteComment.php?poll_id=' + poll_id + '&comment_id=' + comment_id, function(data) {
				document.location.reload();
			});
		});
	}

	jQuery('.comment .reply_button').click(function() {
		var parent_id = jQuery(this).parents('.comment').find('input[name=comment_id]').val();
		jQuery('.post .comment_reply_form_wrapper').slideUp(function() { jQuery(this).remove(); });
		var comment_form = jQuery('.post .main_comment_form').clone(true).removeClass('main_comment_form').addClass('comment_reply_form');
		comment_form.find('label[for=anonymous]').attr({ 'for': 'comment_anonymous' });
		comment_form.find('#anonymous').attr({ id: 'comment_anonymous' });
		jQuery('<input />').attr({ type: 'hidden', name: 'parent_id', value: parent_id }).appendTo(comment_form);

		var wrapper = jQuery('<div></div>').addClass('comment_outer').addClass('nested_comment').addClass('comment_reply_form_wrapper');
		jQuery('<div></div>').addClass('spacer').addClass('spacer_white').addClass('spacer_white_left').appendTo(wrapper);
		jQuery('<div></div>').addClass('spacer').addClass('spacer_white').addClass('spacer_white_right').appendTo(wrapper);
		comment_form.css({ marginTop: 25 });
		comment_form.appendTo(wrapper);

		wrapper.hide().insertAfter(jQuery(this).parents('.comment')).slideDown('fast');
		setTimeout(function() {
			wrapper.find('textarea').focus();
		});
	});
	
	if (jQuery('.options_scroll').length) {
		var current = jQuery(jQuery('.options_scroll td')[0]);
		jQuery('.scroll_left').click(function() {
			var prev = current.prev();
			if (prev.length && prev.find('.vs_obj').length == 0) {
				prev = prev.prev();
			}
			if (prev.length) {
				jQuery('.options_scroll').scrollTo(prev, 400);
				current = prev;
			}
		});
		jQuery('.scroll_right').click(function() {
			var next = current.next();
			if (next.length && next.find('.vs_obj').length == 0) {
				next = next.next();
			}
			if (next.length && next.next().length) {
				jQuery('.options_scroll').scrollTo(next, 400);
				current = next;
			}
		});
	}
}


var g_attach_source;

function init_attach(callback) {
	jQuery('#attach').load('/tpl/attach.html', function() {
		jQuery('#attach .youtube_link').keyup(function() { process_youtube(this); });
		jQuery('#attach .youtube_link').bind('paste', function(e) {
			var self = this;
			setTimeout(function() { process_youtube(self); });
		});
		function process_youtube(self) {
			var data     = jQuery(self).val();
			var match   = /(\/|\?)v(\/|=)([^&]+)&?/.exec(data);
			var videoId = (match && match.length >= 4) ? match[3] : null;
			if (videoId) {
				jQuery('.video_preview').html('<object width="100%" height="100%"><param name="movie" value="http://www.youtube.com/v/' + videoId + '&amp;hl=en_US&amp;fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"><param name="wmode" value="transparent" /></param><embed src="http://www.youtube.com/v/' + videoId + '&amp;hl=en_US&amp;fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="transparent" width="100%" height="100%"></embed></object>');
			} else {
				if (data.substr(0, 6) == '<embed' || data.substr(0, 7) == '<object') {
					jQuery('.video_preview').html(data);
				}
			}
		};

		jQuery('#attach .attach_photo_content form').ajaxForm({
			dataType: 'json',
			success: function(resp) {
				jQuery('.attach_photo_content input[type=button]').show();
				if (resp.url) {
					jQuery('.photo_preview').html("<img src='" + resp.url + "' width='100%' border='0' />");
				} else {
					alert(resp.error);
				}
			}
		});

		jQuery('#attach .attach_photo_content input[type=file]').change(function() {
			jQuery('.attach_photo_content input[type=button]').hide();
			jQuery('#attach .attach_photo_content form').submit();
		});
		
		jQuery('#attach .attach_photo_content .submit_button').click(function() {
			g_attach_source.val(jQuery('#attach .attach_photo_content .photo_preview img').attr('src'));
			g_attach_source.next().attr({ value: 'Media Attached' });
			g_attach_source.trigger('change');
			jQuery('#fadeout').fadeOut();
			jQuery('#attach').fadeOut();
		});

		jQuery('#attach .attach_video_content .submit_button').click(function() {
			g_attach_source.val(jQuery('#attach .attach_video_content .video_preview').html());
			g_attach_source.next().attr({ value: 'Media Attached' });
			g_attach_source.trigger('change');
			jQuery('#fadeout').fadeOut();
			jQuery('#attach').fadeOut();
		});

		jQuery('#attach .cancel_button').click(function() {
			jQuery('#fadeout').fadeOut();
			jQuery('#attach').fadeOut();
		});
		jQuery('#attach .remove_button').click(function() {
			g_attach_source.val('');
			g_attach_source.next().attr({ value: 'Attach Media +' });
			jQuery('#fadeout').fadeOut();
			jQuery('#attach').fadeOut();
		});

		callback();
	});
}

function attach(source) {
	g_attach_source = source;
	attach_video(source);
}

function attach_video() {
	init_attach(function() {
		jQuery('#fadeout').fadeIn();
		jQuery('#attach').fadeIn();
		jQuery('#attach .attach_photo_content').hide();
		jQuery('#attach .attach_video_content').show();
	});
}
function attach_photo() {
	init_attach(function() {
		jQuery('#fadeout').fadeIn();
		jQuery('#attach').fadeIn();
		jQuery('#attach .attach_video_content').hide();
		jQuery('#attach .attach_photo_content').show();
	});
}


