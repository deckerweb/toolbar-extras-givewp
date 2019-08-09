<?php

// includes/givewp-addons/items-convertkit

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_convertkit', 100 );
/**
 * Items for Add-On:
 *   Give - ConvertKit (Premium, by GiveWP/ Impress.org, LLC)
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
function ddw_tbexgive_aoitems_convertkit( $admin_bar ) {

	/** Bail early if no proper permissions */
	if ( ! current_user_can( 'manage_give_settings' ) ) {
		return $admin_bar;
	}
	
	/** Use Add-On hook place */
	add_filter( 'tbexgive/filter/is_givewp_addon', '__return_empty_string' );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-convertkit',
			'parent' => 'givewp-addons',
			'title'  => esc_attr__( 'ConvertKit', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=addons&section=convertkit-settings' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'ConvertKit', 'toolbar-extras-givewp' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-convertkit-settings',
				'parent' => 'ao-givewp-convertkit',
				'title'  => esc_attr__( 'Settings', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=addons&section=convertkit-settings' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Settings', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-convertkit-dashboard',
				'parent' => 'ao-givewp-convertkit',
				'title'  => esc_attr__( 'My ConvertKit Dashboard', 'toolbar-extras-givewp' ),
				'href'   => 'https://app.convertkit.com/',
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'My ConvertKit Dashboard', 'toolbar-extras-givewp' ) . ' (app.convertkit.com)',
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-convertkit-resources',
					'parent' => 'ao-givewp-convertkit',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-convertkit-docs',
				'group-givewp-convertkit-resources',
				'https://givewp.com/documentation/add-ons/convertkit/'
			);

		}  // end if

}  // end function
