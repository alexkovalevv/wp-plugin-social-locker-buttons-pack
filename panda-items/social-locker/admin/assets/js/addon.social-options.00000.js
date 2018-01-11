/**
 * Расширяем социальные опции для редактора замков
 * @author Alex Kovalev <alex.kovalevv@gmail.com>
 * @copyright Alex Kovalev 22.04.2017
 * @version 1.0
 */


(function($) {
	'use strict';

	if( !window.bizpanda ) {
		window.bizpanda = {};
	}
	if( !window.bizpanda.socialOptions ) {
		window.bizpanda.socialOptions = {};
	}

	window.bizpanda.socialOptions.filterDefaultOrderFreeButtons = function(options) {
		options.push('vk-like');
		options.push('mail-share');
		return options;
	};

	window.bizpanda.socialOptions.filterOptions = function(options) {

		delete options.socialButtons.youtube;

		options.socialButtons.google['youtube'] = {
			channelId: $("#opanda_google_youtube_channel_id").val(),
			title: $("#opanda_google_youtube_title").val()
		};

		options.socialButtons.vk = {
			like: {
				pageTitle: $("#opanda_vk_like_message_name").val(),
				pageDescription: $("#opanda_vk_like_message_description").val(),
				pageUrl: $("#opanda_vk_like_url").val(),
				pageImage: $("#opanda_vk_like_message_image").val(),
				text: $("#opanda_vk_like_message_caption").val(),
				title: $("#opanda_vk_like_title").val()
			},

			share: {
				pageUrl: $("#opanda_vk_share_url").val(),
				pageTitle: $("#opanda_vk_share_message_title").val(),
				pageDescription: $("#opanda_vk_share_description").val(),
				pageImage: $("#opanda_vk_share_message_image").val(),
				title: $("#opanda_vk_share_title").val()

			},

			subscribe: {
				groupId: $("#opanda_vk_subscribe_group_id").val(),
				title: $("#opanda_vk_subscribe_title").val()
			},

			notify: {
				groupId: $("#opanda_vk_notify_group_id").val(),
				title: $("#opanda_vk_notify_title").val()

			}
		};

		options.socialButtons.ok = {
			share: {
				url: $("#opanda_ok_share_url").val(),
				title: $("#opanda_ok_share_title").val()
			}
		};

		options.socialButtons.mail = {
			share: {
				pageUrl: $("#opanda_mail_share_url").val(),
				pageDescription: $("#opanda_mail_share_message_description").val(),
				pageImage: $("#opanda_mail_share_message_image").val(),
				pageTitle: $("#opanda_mail_share_message_title").val(),
				title: $("#opanda_mail_share_title").val()
			}
		};

		return options;
	};

})(jQuery);
