<?php

// includes/plugin-manager

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Optionally include the Toolbar Extras Plugin Manager to manage the required
 *   and suggested plugins.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'ddw_tbex_plugin_manager' ) ) :

	if ( defined( 'TBEX_PLUGIN_DIR' ) ) {
		require_once TBEX_PLUGIN_DIR . 'includes/admin/plugin-manager.php';
	}

endif;


add_filter( 'tbex/filter/plugin_manager', 'ddw_tbexgive_plugin_manager_givewp' );
/**
 * Add the required and suggested plugins for Toolbar Extras for Give Donations.
 *   Dashboard to the plugins array of the Toolbar Extras Plugin Manager.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_pm_badge()
 * @uses ddw_tbex_pmstring_for()
 * @uses ddw_tbex_pmstring_info()
 * @uses ddw_tbex_pmstring_for_general()
 *
 * @param array $plugins Array of plugins for Plugin Manager.
 * @return array Merged and modified array of plugins and their arguments.
 */
function ddw_tbexgive_plugin_manager_givewp( $plugins ) {

	$class = 'info';

	$for_givewp = ddw_tbex_pmstring_for( __( 'Add-On for Give Donations', 'toolbar-extras-givewp' ) );

	$plugins_givewp = array(
		array(
			'name'    => _x( 'Give Donations', 'Plugin Name', 'toolbar-extras-givewp' ),
			'slug'    => 'give',
			'version' => '2.5.2+',
			'notice' => array(
				'message' => ddw_tbex_pm_badge( 'required' ) .
					$for_givewp .
					ddw_tbex_pmstring_info( __( 'Required base plugin for this Add-On to have any impact', 'toolbar-extras-givewp' ) ),
				'class'   => $class,
			),
		),
		array(
			'name'    => _x( 'Mailchimp for WordPress', 'Plugin Name', 'toolbar-extras-givewp' ),
			'slug'    => 'mailchimp-for-wp',
			'version' => '4.5.3+',
			'notice'  => array(
				'message' => ddw_tbex_pm_badge( 'recommended' ) .
					$for_givewp .
					ddw_tbex_pmstring_info( __( 'Highly recommended extension to integrate Give Donations with your lists in Mailchimp Email Marketing', 'toolbar-extras-givewp' ) ),
				'class'   => $class,
			),
		),

	);  // end array

	/** Merge arrays and return */
	return array_merge( $plugins, $plugins_givewp );

}  // end function
