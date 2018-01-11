<?php
	/**
	 * Расширяем статистуку по социальным кнопкам
	 * @author Alex Kovalev <alex.kovalevv@gmail.com>
	 * @copyright Alex Kovalev 22.04.2017
	 * @version 1.0
	 */

	function onp_slr_detailed_stats_table($table)
	{
		if( !onp_build('free') ) {
			$table['channels']['columns']['unlock-via-vk-share'] = array(
				'title' => __('VK Share', 'sl-buttons-pack'),
				'cssClass' => 'opanda-col-number'
			);
			$table['channels']['columns']['unlock-via-vk-subscribe'] = array(
				'title' => __('VK Subscribe', 'sl-buttons-pack'),
				'cssClass' => 'opanda-col-number'
			);
			$table['channels']['columns']['unlock-via-vk-notify'] = array(
				'title' => __('VK Notify', 'sl-buttons-pack'),
				'cssClass' => 'opanda-col-number'
			);
		}

		$table['channels']['columns']['unlock-via-vk-like'] = array(
			'title' => __('VK like', 'sl-buttons-pack'),
			'cssClass' => 'opanda-col-number'
		);

		$table['channels']['columns']['unlock-via-ok-share'] = array(
			'title' => __('OK Share', 'sl-buttons-pack'),
			'cssClass' => 'opanda-col-number'
		);
		$table['channels']['columns']['unlock-via-mail-share'] = array(
			'title' => __('Mail Share', 'sl-buttons-pack'),
			'cssClass' => 'opanda-col-number'
		);

		return $table;
	}

	add_filter('onp_sl_detailed_stats_table', 'onp_slr_detailed_stats_table');

	function onp_slr_detailed_stats_chart($channels)
	{
		$channels['unlock-via-vk-like'] = array(
			'title' => __('VK Likes', 'sl-buttons-pack'),
			'color' => '#5F83AA'
		);

		if( !onp_build('free') ) {
			$channels['unlock-via-vk-share'] = array(
				'title' => __('VK Shares', 'sl-buttons-pack'),
				'color' => '#5F83AA'
			);

			$channels['unlock-via-vk-subscribe'] = array(
				'title' => __('VK Subscribes', 'sl-buttons-pack'),
				'color' => '#5F83AA'
			);
			$channels['unlock-via-vk-notify'] = array(
				'title' => __('VK Notify', 'sl-buttons-pack'),
				'color' => '#5F83AA'
			);
		}

		$channels['unlock-via-ok-share'] = array(
			'title' => __('OK Shares', 'sl-buttons-pack'),
			'color' => '#FE9D4A'
		);

		$channels['unlock-via-mail-share'] = array(
			'title' => __('Mail Shares', 'sl-buttons-pack'),
			'color' => '#07447E'
		);

		return $channels;
	}

	add_filter('onp_sl_detailed_stats_chart', 'onp_slr_detailed_stats_chart');

