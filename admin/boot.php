<?php
	/**
	 * Общие функции и вызовы для админки
	 * @author Alex Kovalev <alex.kovalevv@gmail.com>
	 * @copyright Alex Kovalev 22.04.2017
	 * @version 1.0
	 */

	require_once OPANDA_SLR_PLUGIN_DIR . '/admin/notices.php';
	require_once OPANDA_SLR_PLUGIN_DIR . '/admin/activation.php';

	/**
	 * Покдлючаем скрипты на страницу редактирования замков
	 * @param object $scripts
	 * @param object $styles
	 */
	function onp_slr_items_edit_assets($scripts, $styles)
	{
		$styles->add(OPANDA_SLR_PLUGIN_URL . '/admin/assets/css/addon.item-edit.010001.css');
	}

	add_action('bizpanda_panda-item_edit_assets', 'onp_slr_items_edit_assets', 10, 2);

	/**
	 * Расширяем опции видимости замков
	 * @param $options
	 * @return array
	 */
	/*function onp_slr_visability_options($options)
	{
		foreach($options as $key => $option) {
			if( isset($option['id']) && $option['id'] == 'bp-simple-visibility-options' ) {

				foreach($options[$key]['items'] as $keyItem => $item) {
					if( isset($item['name']) && $item['name'] == 'delay' ) {
						unset($options[$key]['items'][$keyItem]);
					}
				}

				array_unshift($options[$key]['items'], array(
					'type' => 'textbox',
					'name' => 'locker_show_delay',
					'title' => __('Задержка замка', 'sl-buttons-pack'),
					'hint' => __('Установите задержку появляения замка на странице в секундах.', 'sl-buttons-pack'),
					'icon' => OPANDA_BIZPANDA_URL . '/assets/admin/img/timer-icon.png',
					'default' => 0
				));
			}
		}

		return $options;
	}

	add_filter('bizpanda_visability_options', 'onp_slr_visability_options');*/

	/**
	 * Расширяем дополнительные опции замков
	 * @param $options
	 * @return mixed
	 */
	/*function onp_slr_advanced_options($options)
	{

		foreach($options as $key => $option) {
			if( isset($option['name']) && $option['name'] == 'close' ) {

				array_splice($options, $key + 1, 0, array(
					array(
						'type' => 'div',
						'id' => 'bp-advanced-close-button-options',
						'items' => array(
							array(
								'type' => 'textbox',
								'name' => 'close_button_show_delay',
								'title' => __('Задержка кнопки', 'sl-buttons-pack'),
								'hint' => __('Установите задержку появляения кнопки закрыть в секундах.', 'sl-buttons-pack'),
								'icon' => OPANDA_BIZPANDA_URL . '/assets/admin/img/timer-icon.png',
								'default' => 0
							)
						)
					)
				));
			}
		};

		return $options;
	}

	add_filter('bizpanda_advanced_options', 'onp_slr_advanced_options');*/
