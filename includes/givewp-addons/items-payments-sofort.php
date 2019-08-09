<?php

// includes/givewp-addons/items-payments-sofort

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_payments_sofort', 100 );
/**
 * Items for Add-On:
 *   Give - Sofort Gateway (Premium, by GiveWP/ Impress.org, LLC)
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
function ddw_tbexgive_aoitems_payments_sofort( $admin_bar ) {

	/** Bail early if no proper permissions */
	if ( ! current_user_can( 'manage_give_settings' ) ) {
		return $admin_bar;
	}
	
	/** Use Add-On hook place */
	add_filter( 'tbexgive/filter/is_givewp_addon', '__return_empty_string' );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-sofort',
			'parent' => 'givewp-addons',
			'title'  => esc_attr__( 'Sofort Payments', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gateways&section=sofort' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'Sofort Payment Gateway', 'toolbar-extras-givewp' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-sofort-settings',
				'parent' => 'ao-givewp-sofort',
				'title'  => esc_attr__( 'Sofort Settings', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gateways&section=sofort' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Sofort Settings', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** For GiveWP Settings */
		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-payment-gateways-sofort-settings',
				'parent' => 'group-givewp-settings-payment-addons-misc',
				'title'  => esc_attr__( 'Sofort', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gateways&section=sofort' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Sofort Settings', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-sofort-dashboard',
				'parent' => 'ao-givewp-sofort',
				'title'  => esc_attr__( 'My Sofort Dashboard', 'toolbar-extras-givewp' ),
				'href'   => 'https://www.sofort.com/payment/users/login',
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'My Sofort Dashboard', 'toolbar-extras-givewp' ) . ' (sofort.com)',
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-sofort-resources',
					'parent' => 'ao-givewp-sofort',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-sofort-docs',
				'group-givewp-sofort-resources',
				'https://givewp.com/documentation/add-ons/sofort-payment-gateway/'
			);

		}  // end if

}  // end function
