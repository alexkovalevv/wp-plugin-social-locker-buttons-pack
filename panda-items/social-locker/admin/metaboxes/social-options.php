<?php
	/**
	 * Социальный опции для Социального замка
	 * @author Alex Kovalev <alex.kovalevv@gmail.com>
	 * @copyright Alex Kovalev 22.04.2017
	 * @version 1.0
	 */

	/**
	 * @param object $scripts
	 * @param object $styles
	 */
	function opanda_slr_sociallocker_item_edit_assets($scripts, $styles)
	{
		$scripts->add(OPANDA_SLR_PLUGIN_URL . '/panda-items/social-locker/admin/assets/js/addon.social-options.00000.js');
	}

	add_action('bizpanda_panda-item_edit_assets', 'opanda_slr_sociallocker_item_edit_assets', 10, 2);

	/**
	 * @param array $tabs
	 * @return mixed
	 */
	function onp_slr_social_options($tabs)
	{
		foreach($tabs['items'] as $tabKey => $tab) {

			// Удаляем кнопку старую youtube.
			if( $tab['name'] == 'youtube-subscribe' || $tab['name'] == 'google-plus' ) {
				unset($tabs['items'][$tabKey]);
			}

			// Удаляем дополнительные настройки для кнопки fb like.
			if( $tab['name'] == 'facebook-like' ) {
				foreach($tab['items'] as $facebookLikeTabItemKey => $facebookLikeTabItem) {
					if( $facebookLikeTabItem['type'] == 'more-link' ) {
						unset($tabs['items'][$tabKey]['items'][$facebookLikeTabItemKey]);
					}
				}
			}

			// Удаляем уведомление, что нужно установить app id, для кнопки fb share
			if( $tab['name'] == 'facebook-share' || $tab['name'] == 'google-share' || $tab['name'] == 'google-plus' || $tab['name'] == 'youtube-subscribe' ) {
				foreach($tab['items'] as $facebookShareTabItemKey => $facebookShareTabItem) {
					if( $facebookShareTabItem['type'] == 'html' ) {
						unset($tabs['items'][$tabKey]['items'][$facebookShareTabItemKey]);
					}
				}
			}
		}

		if( onp_build('free') ) {
			$vkIsActiveByDefault = true;
		} else {
			$vkIsActiveByDefault = false;
		}

		// - VK Like Tab
		$tabs['items'][] = array(
			'type' => 'tab-item',
			'name' => 'vk-like',
			'items' => array(
				array(
					'type' => 'checkbox',
					'way' => 'buttons',
					'title' => __('Available', 'sl-buttons-pack'),
					'hint' => __('Set On, to activate the button.', 'sl-buttons-pack'),
					'name' => 'vk-like_available',
					'default' => $vkIsActiveByDefault
				),
				array(
					'type' => 'url',
					'title' => __('URL to share', 'sl-buttons-pack'),
					'hint' => __('Set any URL to Like (for example, main page of your site). Leave this field empty to use a current page.', 'sl-buttons-pack'),
					'name' => 'vk_like_url'
				),
				array(
					'type' => 'textbox',
					'title' => __('Button Title', 'sl-buttons-pack'),
					'hint' => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'sl-buttons-pack'),
					'name' => 'vk_like_title',
					'default' => __('I like', 'sl-buttons-pack')
				),
				array(
					'type' => 'more-link',
					'name' => 'vk-like-button-options',
					'title' => __('Show more options', 'sl-buttons-pack'),
					'count' => 4,
					'items' => array(

						array(
							'type' => 'form-group',
							'title' => __('Data To Share', 'sl-buttons-pack'),
							'hint' => __('By default data extracted from the URL will be used to publish a message on a user wall. But you can specify other data you want users to share.', 'sl-buttons-pack'),
							'items' => array(

								array(
									'type' => 'textbox',
									'title' => __('Name', 'sl-buttons-pack'),
									'hint' => __('Optional. The name of the link attachment.', 'sl-buttons-pack'),
									'name' => 'vk_like_message_name'
								),
								array(
									'type' => 'textbox',
									'title' => __('Image', 'sl-buttons-pack'),
									'hint' => __('Optional. The URL of a picture attached to this post. The picture must be at least 50px by 50px (though minimum 200px by 200px is preferred) and have a maximum aspect ratio of 3:1.', 'sl-buttons-pack'),
									'name' => 'vk_like_message_image'
								),
							)
						)
					)
				)
			)
		);

		// - Mail Share tab
		$tabs['items'][] = array(
			'type' => 'tab-item',
			'name' => 'mail-share',
			'items' => array(

				array(
					'type' => 'checkbox',
					'way' => 'buttons',
					'title' => __('Available', 'sl-buttons-pack'),
					'hint' => __('Set On, to activate the button.', 'sl-buttons-pack'),
					'name' => 'mail-share_available',
					'default' => false
				),
				array(
					'type' => 'url',
					'title' => __('URL to share', 'sl-buttons-pack'),
					'hint' => __('Set any URL to Share (for example, main page of your site). Leave this field empty to use a current page.', 'sl-buttons-pack'),
					'name' => 'mail_share_url'
				),
				array(
					'type' => 'textbox',
					'title' => __('Button Title', 'sl-buttons-pack'),
					'hint' => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'sl-buttons-pack'),
					'name' => 'mail_share_title',
					'default' => __('share', 'sl-buttons-pack')
				),
				array(
					'type' => 'more-link',
					'name' => 'mail-share-button-options',
					'title' => __('Show more options', 'sl-buttons-pack'),
					'count' => 4,
					'items' => array(

						array(
							'type' => 'form-group',
							'title' => __('Data To Share', 'sl-buttons-pack'),
							'hint' => __('By default data extracted from the URL will be used to publish a message on a user wall. But you can specify other data you want users to share.', 'sl-buttons-pack'),
							'items' => array(

								array(
									'type' => 'textbox',
									'title' => __('Name', 'sl-buttons-pack'),
									'hint' => __('Optional. The name of the link attachment.', 'sl-buttons-pack'),
									'name' => 'mail_share_message_title'
								),
								array(
									'type' => 'textbox',
									'title' => __('Description', 'sl-buttons-pack'),
									'hint' => __('Optional. The description of the link (appears beneath the link caption). If not specified, this field is automatically populated by information scraped from the link, typically the title of the page.', 'sl-buttons-pack'),
									'name' => 'mail_share_message_description'
								),
								array(
									'type' => 'textbox',
									'title' => __('Image', 'sl-buttons-pack'),
									'hint' => __('Optional. The URL of a picture attached to this post. The picture must be at least 50px by 50px (though minimum 200px by 200px is preferred) and have a maximum aspect ratio of 3:1.', 'sl-buttons-pack'),
									'name' => 'mail_share_message_image'
								),
							)
						)
					)
				)
			)
		);

		// - OK Share Tab
		$tabs['items'][] = array(
			'type' => 'tab-item',
			'name' => 'ok-share',
			'items' => array(
				array(
					'type' => 'checkbox',
					'way' => 'buttons',
					'title' => __('Available', 'sl-buttons-pack'),
					'hint' => __('Set On, to activate the button.', 'sl-buttons-pack'),
					'name' => 'ok-share_available',
					'default' => false
				),
				array(
					'type' => 'url',
					'title' => __('URL to share', 'sl-buttons-pack'),
					'hint' => __('Set any URL to Share (for example, main page of your site). Leave this field empty to use a current page.', 'sl-buttons-pack'),
					'name' => 'ok_share_url'
				),
				array(
					'type' => 'textbox',
					'title' => __('Button Title', 'sl-buttons-pack'),
					'hint' => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'sl-buttons-pack'),
					'name' => 'ok_share_title',
					'default' => __('share', 'sl-buttons-pack')
				)
			)
		);

		if( onp_build('free') ) {
			// - Google Youtube
			$tabs['items'][] = array(
				'type' => 'tab-item',
				'name' => 'google-youtube',
				'items' => array(
					array(
						'type' => 'checkbox',
						'way' => 'buttons',
						'title' => __('Available', 'sl-buttons-pack'),
						'hint' => __('Set On, to activate the button.', 'sl-buttons-pack'),
						'name' => 'google-youtube_available',
						'value' => false,
						'default' => false
					),
					array(
						'type' => 'textbox',
						'title' => __('Channel ID', 'sl-buttons-pack'),
						'hint' => __('Set a channel ID to subscribe (for example, <a href="http://www.youtube.com/channel/UCANLZYMidaCbLQFWXBC95Jg" target="_blank">UCANLZYMidaCbLQFWXBC95Jg</a>).', 'sl-buttons-pack'),
						'name' => 'google_youtube_fake_field_2'
					),
					array(
						'type' => 'textbox',
						'title' => __('Button Title', 'sl-buttons-pack'),
						'hint' => __('Optional. A visible title of the buttons that is used in some themes (by default only in the Secrets theme).', 'sl-buttons-pack'),
						'name' => 'google_youtube_fake_field_3',
						'default' => __('Youtube', 'sl-buttons-pack')
					)
				)
			);

			// - VK Subscribe Tab
			$tabs['items'][] = array(
				'type' => 'tab-item',
				'name' => 'vk-subscribe',
				'items' => array(
					array(
						'type' => 'checkbox',
						'way' => 'buttons',
						'title' => __('Available', 'sl-buttons-pack'),
						'hint' => __('Set On, to activate the button.', 'sl-buttons-pack'),
						'name' => 'vk-subscribe_available',
						'value' => false,
						'default' => false
					),
					array(
						'type' => 'textbox',
						'title' => __('Group ID', 'sl-buttons-pack'),
						'hint' => __('Your group/public page ID or short name in VK. For example, 11283947 or yandex).', 'sl-buttons-pack'),
						'name' => 'vk_subscribe_fake_field_1'
					),
					array(
						'type' => 'textbox',
						'title' => __('Button Title', 'sl-buttons-pack'),
						'hint' => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'sl-buttons-pack'),
						'name' => 'vk_subscribe_fake_field_2',
						'default' => __('subscribe', 'sl-buttons-pack')
					)
				)
			);
			// - VK Share Tab
			$tabs['items'][] = array(
				'type' => 'tab-item',
				'name' => 'vk-share',
				'items' => array(
					array(
						'type' => 'checkbox',
						'way' => 'buttons',
						'title' => __('Available', 'sl-buttons-pack'),
						'hint' => __('Set On, to activate the button.', 'sl-buttons-pack'),
						'name' => 'vk-share_available',
						'value' => false,
						'default' => false
					),
					array(
						'type' => 'url',
						'title' => __('URL to share', 'sl-buttons-pack'),
						'hint' => __('Set any URL to Like (for example, main page of your site). Leave this field empty to use a current page.', 'sl-buttons-pack'),
						'name' => 'vk_share__fake_field_1'
					),
					array(
						'type' => 'textbox',
						'title' => __('Name', 'sl-buttons-pack'),
						'hint' => __('Optional. The name of the link attachment.', 'sl-buttons-pack'),
						'name' => 'vk_share_fake_field_4'
					),
					array(
						'type' => 'textbox',
						'title' => __('Image', 'sl-buttons-pack'),
						'hint' => __('Optional. The URL of a picture attached to this post. The picture must be at least 50px by 50px (though minimum 200px by 200px is preferred) and have a maximum aspect ratio of 3:1.', 'sl-buttons-pack'),
						'name' => 'vk_share_fake_field_5'
					),
					array(
						'type' => 'textbox',
						'title' => __('Button Title', 'sl-buttons-pack'),
						'hint' => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'sl-buttons-pack'),
						'name' => 'vk_share_fake_field_3',
						'default' => __('share', 'sl-buttons-pack')
					)
				)
			);

			// - VK notify Tab
			$tabs['items'][] = array(
				'type' => 'tab-item',
				'name' => 'vk-notify',
				'items' => array(
					array(
						'type' => 'checkbox',
						'way' => 'buttons',
						'title' => __('Available', 'sl-buttons-pack'),
						'hint' => __('Set On, to activate the button.', 'sl-buttons-pack'),
						'name' => 'vk-notify_available',
						'value' => false,
						'default' => false
					),
					array(
						'type' => 'textbox',
						'title' => __('Group ID', 'sl-buttons-pack'),
						'hint' => __('Your group/public page ID or short name in VK. For example, 11283947 or yandex).', 'sl-buttons-pack'),
						'name' => 'vk_notify_fake_field_1'
					),
					array(
						'type' => 'textbox',
						'title' => __('Button Title', 'sl-buttons-pack'),
						'hint' => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'sl-buttons-pack'),
						'name' => 'vk_notify_fake_field_2',
						'default' => __('subscribe', 'sl-buttons-pack')
					)
				)
			);
		} else {
			// - Google Youtube Tab
			$tabs['items'][] = array(
				'type' => 'tab-item',
				'name' => 'google-youtube',
				'items' => array(
					array(
						'type' => 'checkbox',
						'way' => 'buttons',
						'title' => __('Available', 'sl-buttons-pack'),
						'hint' => __('Set On, to activate the button.', 'sl-buttons-pack'),
						'name' => 'google-youtube_available',
						'default' => false
					),
					array(
						'type' => 'textbox',
						'title' => __('Channel ID', 'sl-buttons-pack'),
						'hint' => __('Set a channel ID to subscribe (for example, <a href="http://www.youtube.com/channel/UCANLZYMidaCbLQFWXBC95Jg" target="_blank">UCANLZYMidaCbLQFWXBC95Jg</a>).', 'sl-buttons-pack'),
						'name' => 'google_youtube_channel_id'
					),
					array(
						'type' => 'textbox',
						'title' => __('Button Title', 'sl-buttons-pack'),
						'hint' => __('Optional. A visible title of the buttons that is used in some themes (by default only in the Secrets theme).', 'sl-buttons-pack'),
						'name' => 'google_youtube_title',
						'default' => __('Youtube', 'sl-buttons-pack')
					)
				)
			);

			// - VK Subscribe Tab
			$tabs['items'][] = array(
				'type' => 'tab-item',
				'name' => 'vk-subscribe',
				'items' => array(
					array(
						'type' => 'checkbox',
						'way' => 'buttons',
						'title' => __('Available', 'sl-buttons-pack'),
						'hint' => __('Set On, to activate the button.', 'sl-buttons-pack'),
						'name' => 'vk-subscribe_available',
						'default' => false
					),
					array(
						'type' => 'textbox',
						'title' => __('Group ID', 'sl-buttons-pack'),
						'hint' => __('Your group/public page ID or short name in VK. For example, 11283947 or yandex).', 'sl-buttons-pack'),
						'name' => 'vk_subscribe_group_id'
					),
					array(
						'type' => 'textbox',
						'title' => __('Button Title', 'sl-buttons-pack'),
						'hint' => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'sl-buttons-pack'),
						'name' => 'vk_subscribe_title',
						'default' => __('subscribe', 'sl-buttons-pack')
					)
				)
			);

			// - VK notify Tab
			$tabs['items'][] = array(
				'type' => 'tab-item',
				'name' => 'vk-notify',
				'items' => array(
					array(
						'type' => 'checkbox',
						'way' => 'buttons',
						'title' => __('Available', 'sl-buttons-pack'),
						'hint' => __('Set On, to activate the button.', 'sl-buttons-pack'),
						'name' => 'vk-notify_available',
						'default' => false
					),
					array(
						'type' => 'textbox',
						'title' => __('Group ID', 'sl-buttons-pack'),
						'hint' => __('Your group/public page ID or short name in VK. For example, 11283947 or yandex).', 'sl-buttons-pack'),
						'name' => 'vk_notify_group_id'
					),
					array(
						'type' => 'textbox',
						'title' => __('Button Title', 'sl-buttons-pack'),
						'hint' => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'sl-buttons-pack'),
						'name' => 'vk_notify_title',
						'default' => __('subscribe', 'sl-buttons-pack')
					)
				)
			);

			// - VK Share Tab
			$tabs['items'][] = array(
				'type' => 'tab-item',
				'name' => 'vk-share',
				'items' => array(
					array(
						'type' => 'checkbox',
						'way' => 'buttons',
						'title' => __('Available', 'sl-buttons-pack'),
						'hint' => __('Set On, to activate the button.', 'sl-buttons-pack'),
						'name' => 'vk-share_available',
						'default' => true
					),
					array(
						'type' => 'url',
						'title' => __('URL to share', 'sl-buttons-pack'),
						'hint' => __('Set any URL to Like (for example, main page of your site). Leave this field empty to use a current page.', 'sl-buttons-pack'),
						'name' => 'vk_share_url'
					),
					array(
						'type' => 'textarea',
						'title' => __('Name', 'sl-buttons-pack'),
						'hint' => __('Optional. The name of the link attachment.', 'sl-buttons-pack'),
						'name' => 'vk_share_message_title'
					),
					array(
						'type' => 'textbox',
						'title' => __('Image', 'sl-buttons-pack'),
						'hint' => __('Optional. The URL of a picture attached to this post. The picture must be at least 50px by 50px (though minimum 200px by 200px is preferred) and have a maximum aspect ratio of 3:1.', 'sl-buttons-pack'),
						'name' => 'vk_share_message_image'
					),
					array(
						'type' => 'textbox',
						'title' => __('Button Title', 'sl-buttons-pack'),
						'hint' => __('Optional. A title of the button that is situated on the covers in the themes "Secrets" and "Flat".', 'sl-buttons-pack'),
						'name' => 'vk_share_title',
						'default' => __('share', 'sl-buttons-pack')
					)
				)
			);
		}

		return $tabs;
	}

	add_filter('onp_sl_social_options', 'onp_slr_social_options');

	function onp_slr_social_options_free_buttons($buttons)
	{

		$buttons[] = 'vk-like';
		$buttons[] = 'mail-share';
		$buttons[] = 'ok-share';

		return $buttons;
	}

	add_filter('onp_sl_social_options_free_buttons', 'onp_slr_social_options_free_buttons');

	function onp_slr_social_options_default_order($defaultOrder)
	{
		if( onp_build('free') ) {
			$defaultOrder[] = 'vk-like';
		} else {
			$defaultOrder[] = 'vk-share';
		}

		return $defaultOrder;
	}

	add_filter('onp_sl_social_options_default_order', 'onp_slr_social_options_default_order');



