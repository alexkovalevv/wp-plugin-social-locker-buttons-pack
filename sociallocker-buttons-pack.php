<?php
	/**
	 * Plugin Name: [Sociallocker Addon] Buttons pack	 
	 * Description: Expands the set of social buttons for Social locker. The set includes social networks: Vkontakte, Odnoklassniki, Moy mir, Instagram, Pinterest, Draugiem, Livejournal.
	 * Author: Alex Kovalev <alex.kovalevv@gmail.com>
	 * Version: 1.0.1	 
	 */

	define('OPANDA_SLR_PLUGIN_URL', plugins_url(null, __FILE__));
	define('OPANDA_SLR_PLUGIN_DIR', dirname(__FILE__));

	$asPlugin = !defined('LOADING_SOCIALLOCKER_BUTTONS_PACK_AS_ADDON');

	function onp_sl_rus_buttons_addon_init()
	{
		// Если социальный замок не установлен, останавливаем расширение
		if( !defined('SOCIALLOCKER_PLUGIN_ACTIVE') ) {
			return false;
		}

		load_plugin_textdomain('sl-buttons-pack', false, dirname(plugin_basename(__FILE__)) . '/langs');

		require_once OPANDA_SLR_PLUGIN_DIR . '/panda-items/social-locker/boot.php';
		require_once OPANDA_SLR_PLUGIN_DIR . '/plugin/boot.php';

		if( is_admin() ) {
			require_once OPANDA_SLR_PLUGIN_DIR . '/panda-items/social-locker/admin/boot.php';
			require_once OPANDA_SLR_PLUGIN_DIR . '/admin/boot.php';
		}
	}

	if( $asPlugin ) {
		add_action('init', 'onp_sl_rus_buttons_addon_init');
	} else {
		onp_sl_rus_buttons_addon_init();
	}
