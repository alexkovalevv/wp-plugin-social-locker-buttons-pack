<?php
	/**
	 * Предустановочные настройки админки социального замка
	 * @author Alex Kovalev <alex.kovalevv@gmail.com>
	 * @copyright Alex Kovalev 22.04.2017
	 * @version 1.0
	 */

	require_once OPANDA_SLR_PLUGIN_DIR . '/panda-items/social-locker/admin/stats/detalied.php';
	require_once OPANDA_SLR_PLUGIN_DIR . '/panda-items/social-locker/admin/metaboxes/social-options.php';

	function onp_slr_print_scripts_to_preview_head()
	{
		?>
		<link rel="stylesheet" type="text/css" href="<?php echo OPANDA_SLR_PLUGIN_URL ?>/plugin/assets/css/migration-rus-to-en.min.css">
		<script type="text/javascript" src="<?php echo OPANDA_SLR_PLUGIN_URL ?>/plugin/assets/js/migration-rus-to-en.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?php echo OPANDA_SLR_PLUGIN_URL ?>/plugin/assets/css/buttons-pack.min.css">
		<?php
		if( !onp_build('free') ) {
			?>

			<script type="text/javascript" src="<?php echo OPANDA_SLR_PLUGIN_URL ?>/plugin/assets/js/buttons-pack-premium.min.js"></script>
		<?php
		} else {
			?>
			<script type="text/javascript" src="<?php echo OPANDA_SLR_PLUGIN_URL ?>/plugin/assets/js/buttons-pack-free.min.js"></script>
		<?php
		}
	}

	add_action('bizpanda_print_scripts_to_preview_head', 'onp_slr_print_scripts_to_preview_head');