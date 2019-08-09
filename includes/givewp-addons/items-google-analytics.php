<?php

// includes/givewp-addons/items-google-analytics

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_google_analytics', 100 );
/**
 * Items for Add-On:
 *   Give - Google Analytics Donation Tracking (Premium, by GiveWP/ Impress.org, LLC)
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_premium_addon_title_attr()
 * @uses ddw_tbex_meta_target()
 * @uses ddw_tbex_display_items_resources()
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_aoitems_google_analytics( $admin_bar ) {

	/** Bail early if no proper permissions */
	if ( ! current_user_can( 'manage_give_settings' ) ) {
		return $admin_bar;
	}
	
	/** Use Add-On hook place */
	add_filter( 'tbexgive/filter/is_givewp_addon', '__return_empty_string' );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-gatracking',
			'parent' => 'givewp-addons',
			'title'  => esc_attr__( 'Google Analytics', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=general&section=google-analytics' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'Google Analytics Donation Tracking', 'toolbar-extras-givewp' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-gatracking-settings',
				'parent' => 'ao-givewp-gatracking',
				'title'  => esc_attr__( 'Settings', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=general&section=google-analytics' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Settings', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-gatracking-gadashboard',
				'parent' => 'ao-givewp-gatracking',
				'title'  => esc_attr__( 'My Google Analytics Dashboard', 'toolbar-extras-givewp' ),
				'href'   => 'https://analytics.google.com/analytics/web/',
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'My Google Analytics Dashboard', 'toolbar-extras-givewp' ) . ' (analytics.google.com)',
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-gatracking-resources',
					'parent' => 'ao-givewp-gatracking',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-gatracking-docs',
				'group-givewp-gatracking-resources',
				'https://givewp.com/documentation/add-ons/google-analytics/'
			);

		}  // end if

}  // end function
