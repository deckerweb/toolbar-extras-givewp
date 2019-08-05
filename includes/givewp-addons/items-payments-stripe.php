<?php

// includes/givewp-addons/items-payments-stripe

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_payments_stripe', 100 );
/**
 * Items for Add-On:
 *   Give - Stripe Gateway (Premium, by GiveWP/ Impress.org, LLC)
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
function ddw_tbexgive_aoitems_payments_stripe( $admin_bar ) {

	/** Use Add-On hook place */
	add_filter( 'tbexgive/filter/is_givewp_addon', '__return_empty_string' );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-stripe',
			'parent' => 'givewp-addons',
			'title'  => esc_attr__( 'Stripe Payments', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gateways&section=stripe-settings' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'Stripe Payment Gateway', 'toolbar-extras-givewp' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-stripe-settings',
				'parent' => 'ao-givewp-stripe',
				'title'  => esc_attr__( 'Stripe Settings', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gateways&section=stripe-settings' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Stripe Settings', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-stripe-plaid-settings',
				'parent' => 'ao-givewp-stripe',
				'title'  => esc_attr__( 'Stripe + Plaid Settings', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gateways&section=stripe-ach-settings' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Stripe + Plaid Settings', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-stripe-advanced',
				'parent' => 'ao-givewp-stripe',
				'title'  => esc_attr__( 'Advanced Settings', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=advanced&section=stripe' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Advanced Settings', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-stripe-dashboard',
				'parent' => 'ao-givewp-stripe',
				'title'  => esc_attr__( 'My Stripe Dashboard', 'toolbar-extras-givewp' ),
				'href'   => 'https://dashboard.stripe.com/dashboard',
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'My Stripe Dashboard (stripe.com)', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-stripe-logs',
				'parent' => 'ao-givewp-stripe',
				'title'  => esc_attr__( 'Stripe Logs', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-tools&tab=logs&section=stripe' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Stripe Logs', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-stripe-resources',
					'parent' => 'ao-givewp-stripe',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-stripe-docs',
				'group-givewp-stripe-resources',
				'https://givewp.com/documentation/add-ons/stripe-gateway/'
			);

		}  // end if

}  // end function
