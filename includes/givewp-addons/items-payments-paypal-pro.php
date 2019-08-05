<?php

// includes/givewp-addons/items-payments-paypal-pro

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_payments_paypal_pro', 100 );
/**
 * Items for Add-On:
 *   Give - PayPal Pro Gateway (Premium, by GiveWP/ Impress.org, LLC)
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
function ddw_tbexgive_aoitems_payments_paypal_pro( $admin_bar ) {

	/** Use Add-On hook place */
	add_filter( 'tbexgive/filter/is_givewp_addon', '__return_empty_string' );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-paypalpro',
			'parent' => 'givewp-addons',
			'title'  => esc_attr__( 'PayPal Pro Payments', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gateways&section=paypal-payments-pro' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'PayPal Pro Payment Gateway', 'toolbar-extras-givewp' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-paypalpro-settings',
				'parent' => 'ao-givewp-paypalpro',
				'title'  => esc_attr__( 'PayPal Pro Settings', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gateways&section=paypal-payments-pro' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'PayPal Pro Settings', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-paypalpro-website-payments-rest-api',
				'parent' => 'ao-givewp-paypalpro',
				'title'  => esc_attr__( 'Website Payments Pro (REST API)', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gateways&section=paypal-website-payments-pro-rest-api' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Website Payments Pro (REST API)', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-paypalpro-website-payments-nvp-api',
				'parent' => 'ao-givewp-paypalpro',
				'title'  => esc_attr__( 'Website Payments Pro (NVP API)', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gateways&section=paypal-website-payments-pro-nvp-api' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Website Payments Pro (NVP API)', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-paypalpro-account',
				'parent' => 'ao-givewp-paypalpro',
				'title'  => esc_attr__( 'My PayPal Pro Account', 'toolbar-extras-givewp' ),
				'href'   => 'https://www.paypal.com',
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'My PayPal Pro Account (paypal.com)', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** For Settings group */
		$admin_bar->add_node(
			array(
				'id'     => 'payment-settings-ao-givewp-paypalpro-settings',
				'parent' => 'group-givewp-settings-payment-addons-paypalpro',
				'title'  => esc_attr__( 'PayPal Pro Settings', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gateways&section=paypal-payments-pro' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'PayPal Pro Settings', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-paypalpro-resources',
					'parent' => 'ao-givewp-paypalpro',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-paypalpro-docs',
				'group-givewp-paypalpro-resources',
				'https://givewp.com/documentation/add-ons/paypal-pro-gateway/'
			);

		}  // end if

}  // end function
