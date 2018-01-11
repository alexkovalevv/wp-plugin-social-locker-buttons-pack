<?php
	/**
	 * Выполнить следующие функции при активации плагина
	 * @author Alex Kovalev <alex.kovalevv@gmail.com>
	 * @copyright Alex Kovalev 22.04.2017
	 * @version 1.0
	 */

	function onp_slr_activation()
	{
		global $sociallocker;
		/*$early_activate = get_option('opanda_tracking', false);
		$isLicense = get_option('onp_license_' . $sociallocker->pluginName, false);

		if( $early_activate && $isLicense ) {
			factory_000_set_lazy_redirect(opanda_get_admin_url('how-to-use', array('onp_sl_page' => 'sociallocker-last-updates')));
		}*/
	}

	//add_action('after_bizpanda_activation', 'onp_slr_activation');

