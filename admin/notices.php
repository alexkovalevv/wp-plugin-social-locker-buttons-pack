<?php
	// ------------------------------------------------------------------------------------------
	// Расширяет набор кнопок для всплывающего окна с просьбой проголосовать.
	// ------------------------------------------------------------------------------------------

	if( onp_build('free') ) {
		function onp_slr_achievement_popups_new_track_buttons($metrics)
		{
			$metrics[] = 'unlock-via-vk-like';
			$metrics[] = 'unlock-via-vk-share';
			$metrics[] = 'unlock-via-vk-subscribe';
			$metrics[] = 'unlock-via-mail-share';
			$metrics[] = 'unlock-via-ok-share';

			return $metrics;
		}

		add_filter('onp_sl_achievement_popups_track_metrics', 'onp_slr_achievement_popups_new_track_buttons');

		function onp_slr_achievement_popups_message_data($metric)
		{
			switch( $metric ) {
				case 'unlock-via-vk-like':
					$units = __('likes', 'bizpanda');
					$where = __('on Vkontakte', 'bizpanda');
					break;
				case 'unlock-via-vk-share':
					$units = __('shares', 'bizpanda');
					$where = __('on Vkontakte', 'bizpanda');
					break;
				case 'unlock-via-vk-subscribe':
					$units = __('subscribes', 'bizpanda');
					$where = __('on Vkontakte', 'bizpanda');
					break;
				case 'unlock-via-mail-share':
					$units = __('shares', 'bizpanda');
					$where = __('on Mail', 'bizpanda');
					break;
				case 'unlock-via-ok-share':
					$units = __('shares', 'bizpanda');
					$where = __('on Odnoklassniki', 'bizpanda');
					break;
				default:
					$units = 'undefined';
					$where = 'undefined';
					break;
			}

			return array('units' => $units, 'where' => $where);
		}

		add_filter('onp_sl_achievement_popups_message_data', 'onp_slr_achievement_popups_message_data');
	}
