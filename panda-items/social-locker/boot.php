<?php
	/**
	 * Настройки социального замка для фронтенда
	 * @author Alex Kovalev <alex.kovalevv@gmail.com>
	 * @copyright Alex Kovalev 22.04.2017
	 * @version 1.0
	 */

	function onp_slr_social_locker_options($options, $id)
	{
		global $post;

		$postUrl = $post != null
			? get_permalink($post->ID)
			: '';

		$vkLikeUrl = opanda_get_item_option($id, 'vk_like_url', false, $postUrl);
		$vkShareUrl = opanda_get_item_option($id, 'vk_share_url', false, $postUrl);
		$okClassUrl = opanda_get_item_option($id, 'ok_share_url', false, $postUrl);
		$mailClassUrl = opanda_get_item_option($id, 'mail_share_url', false, $postUrl);

		unset($options['socialButtons']['google']['plus']);
		unset($options['socialButtons']['youtube']['subscribe']);

		// Удаляем кнопку google plus, так как она больше не используется
		$key = array_search('google-plus', $options['socialButtons']['order']);
		if( $key !== false && isset($options['socialButtons']['order'][$key]) ) {
			unset($options['socialButtons']['order'][$key]);
		}

		$options['socialButtons']['vk'] = array(
			'appId' => opanda_get_option('vk_appid'),
			'like' => array(
				'pageUrl' => $vkLikeUrl,
				'pageTitle' => opanda_get_item_option($id, 'vk_like_message_title'),
				'pageDescription' => opanda_get_item_option($id, 'vk_like_message_description'),
				'pageImage' => opanda_get_item_option($id, 'vk_like_message_image'),
				'title' => opanda_get_item_option($id, 'vk_like_title'),
			)
		);

		if( !onp_build('free') ) {
			$options['socialButtons']['vk']['share'] = array(
				'pageUrl' => $vkShareUrl,
				'pageTitle' => opanda_get_item_option($id, 'vk_share_message_title'),
				'pageDescription' => opanda_get_item_option($id, 'vk_share_description'),
				'pageImage' => opanda_get_item_option($id, 'vk_share_message_image'),
				'title' => opanda_get_item_option($id, 'vk_share_title')
			);

			$options['socialButtons']['vk']['subscribe'] = array(
				'groupId' => opanda_get_item_option($id, 'vk_subscribe_group_id'),
				'title' => opanda_get_item_option($id, 'vk_subscribe_title'),
			);

			$options['socialButtons']['vk']['notify'] = array(
				'groupId' => opanda_get_item_option($id, 'vk_notify_group_id'),
				'title' => opanda_get_item_option($id, 'vk_notify_title'),
			);

			$options['socialButtons']['google']['youtube'] = array(
				'channelId' => opanda_get_item_option($id, 'google_youtube_channel_id'),
				'title' => opanda_get_item_option($id, 'google_youtube_title')
			);
		}

		$options['socialButtons']['mail'] = array(
			'share' => array(
				'title' => opanda_get_item_option($id, 'mail_share_title'),
				'pageUrl' => $mailClassUrl,
				'pageDescription' => opanda_get_item_option($id, 'mail_share_message_description'),
				'pageImage' => opanda_get_item_option($id, 'mail_share_message_image'),
				'pageTitle' => opanda_get_item_option($id, 'mail_share_message_title'),
			)
		);

		$options['socialButtons']['ok'] = array(
			'share' => array(
				'title' => opanda_get_item_option($id, 'ok_share_title'),
				'url' => $okClassUrl
			)
		);

		return $options;
	}

	add_filter('bizpanda_social-locker_item_options', 'onp_slr_social_locker_options', 20, 2);

	function onp_slr_social_locker_allowed_buttons($allowedButtons)
	{
		unset($allowedButtons['youtube-subscribe']);

		$allowedButtons[] = 'vk-like';
		$allowedButtons[] = 'ok-share';
		$allowedButtons[] = 'mail-share';

		if( !onp_build('free') ) {
			$allowedButtons[] = 'google-youtube';
			$allowedButtons[] = 'vk-notify';
			$allowedButtons[] = 'vk-share';
			$allowedButtons[] = 'vk-subscribe';
		}

		return $allowedButtons;
	}

	add_filter('bizpanda_social-locker_allowed_buttons', 'onp_slr_social_locker_allowed_buttons');