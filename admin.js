jQuery(document).ready(function() {
/*
	wr = jQuery('#wr_ap').remove();
	jQuery('#post').remove();
	wr.appendTo(jQuery('#wpbody-content'));
*/

	jQuery('#fadeout').css({ opacity: 0.4 });

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
	jQuery('.addpoll_container input[name=whosright_add_option]').click(function() {
		var num_options = jQuery('.addpoll_container tr.option').length;
		if (num_options < 999) {
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
		//if (num_options > 2) {
			jQuery(this).parent().parent().prev().remove();
			jQuery(this).parent().parent().remove();
		//}
		reProcessOptions();
	});
	var submitting = false;
	jQuery('.addpoll_container form').ajaxForm({ 
		dataType: 'json',
		success: function(resp) {
			submitting = false;
			if (resp.error) {
				alert(resp.error);
				jQuery('.addpoll_container .submit_button').enable();
			} else {
				alert('Post submitted.');
				//document.location.reload();
			}
		}
	});
	jQuery('.addpoll_container .submit_button').click(function() {
		if (submitting == false) {
			if (jQuery('.addpoll_container select[name=whosright_category]').val() == -1) {
				alert('Please choose a category.');
			} else {
				submitting = true;
				jQuery('.addpoll_container form').submit();
			}
		}
	});
	
	function toggleAdvanced() {
		if (jQuery('#post_advanced_att').attr('checked') == true) {
			jQuery('.addpoll_container .option_attach_media').show();
			jQuery('.addpoll_container .attach_button').hide();
			jQuery('.addpoll_container textarea[name=whosright_attach_media]').show();
		} else {
			jQuery('.addpoll_container textarea[name=whosright_attach_media]').hide();
			jQuery('.addpoll_container .option_attach_media').hide();
			jQuery('.addpoll_container .attach_button').show();
		}
	}
	jQuery('.addpoll_container input[name=whosright_post_advanced_att]').click(function() { toggleAdvanced(); });
	jQuery('.addpoll_container #post_advanced_att_label').click(function() { toggleAdvanced(); });
});



var g_attach_source;

function init_attach(callback) {
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
		
		jQuery('#attach .attach_photo_content .photo_preview img').clone().appendTo(
			g_attach_source.parent().parent().prev().find('.media_preview').empty()
		);
	});

	jQuery('#attach .attach_video_content .submit_button').click(function() {
		g_attach_source.val(jQuery('#attach .attach_video_content .video_preview').html());
		g_attach_source.next().attr({ value: 'Media Attached' });
		g_attach_source.trigger('change');
		jQuery('#fadeout').fadeOut();
		jQuery('#attach').fadeOut();

		jQuery('#attach .attach_video_content .video_preview').clone().appendTo(
			g_attach_source.parent().parent().prev().find('.media_preview').empty()
		);
	});

	jQuery('#attach .cancel_button').click(function() {
		jQuery('#fadeout').fadeOut();
		jQuery('#attach').fadeOut();
	});
	jQuery('#attach .remove_button').click(function() {
		g_attach_source.val('');
		g_attach_source.next().attr({ value: 'Attach Media +' });
		g_attach_source.parent().parent().prev().find('.media_preview').empty()
		jQuery('#fadeout').fadeOut();
		jQuery('#attach').fadeOut();
	});

	callback();
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

