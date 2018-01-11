<?php
	/**
	 * Общие функции и вызовы для фронтенд
	 * @author Alex Kovalev <alex.kovalevv@gmail.com>
	 * @copyright Alex Kovalev 22.04.2017
	 * @version 1.0
	 */

	/**
	 * Подменяем JQuery библиотеки плагина на свои
	 */
	function onp_slr_connect_locker_assets()
	{
		wp_enqueue_style('opanda-migration-rus-to-en', OPANDA_SLR_PLUGIN_URL . '/plugin/assets/css/migration-rus-to-en.min.css', array(), '1.0.2');
		wp_enqueue_script('opanda-migration-rus-to-en', OPANDA_SLR_PLUGIN_URL . '/plugin/assets/js/migration-rus-to-en.min.js', array(
			'opanda-lockers'
		), '1.0.2', true);

		wp_enqueue_style('opanda-buttons-pack', OPANDA_SLR_PLUGIN_URL . '/plugin/assets/css/buttons-pack.min.css', array(), '1.0.2');

		if( !onp_build('free') ) {
			wp_enqueue_script('opanda-buttons-pack', OPANDA_SLR_PLUGIN_URL . '/plugin/assets/js/buttons-pack-premium.min.js', array(
				'opanda-migration-rus-to-en'
			), '1.0.2', true);
		} else {
			wp_enqueue_script('opanda-buttons-pack', OPANDA_SLR_PLUGIN_URL . '/plugin/assets/js/buttons-pack-free.min.js', array(
				'opanda-migration-rus-to-en'
			), '1.0.2', true);
		}
	}

	add_action('bizpanda_connect_locker_assets', 'onp_slr_connect_locker_assets');
