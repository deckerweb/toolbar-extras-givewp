<?php

// includes/givewp-addons/items-currency-switcher

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_currency_switcher', 100 );
/**
 * Items for Add-On:
 *   Give - Currency Switcher (Premium, by GiveWP/ Impress.org, LLC)
 *
 * @since 1.0.0
 *
 * @uses give_annual_receipts_get_donor_object()
 * @uses ddw_tbex_string_premium_addon_title_attr()
 * @uses ddw_tbex_meta_target()
 * @uses ddw_tbex_display_items_resources()
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_aoitems_currency_switcher( $admin_bar ) {

	/** Bail early if no proper permissions */
	if ( ! current_user_can( 'manage_give_settings' ) ) {
		return $admin_bar;
	}
	
	/** Use Add-On hook place */
	add_filter( 'tbexgive/filter/is_givewp_addon', '__return_empty_string' );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-currencyswitcher',
			'parent' => 'givewp-addons',
			'title'  => esc_attr__( 'Currency Switcher', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=currency-switcher' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'Currency Switcher', 'toolbar-extras-givewp' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-currencyswitcher-general',
				'parent' => 'ao-givewp-currencyswitcher',
				'title'  => esc_attr__( 'General Settings', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=currency-switcher&section=general-settings' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'General Settings', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-currencyswitcher-geolocation',
				'parent' => 'ao-givewp-currencyswitcher',
				'title'  => esc_attr__( 'Geolocation', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=currency-switcher&section=geolocation' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Geolocation', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-currencyswitcher-payment-gateways',
				'parent' => 'ao-givewp-currencyswitcher',
				'title'  => esc_attr__( 'Payment Gateways', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=currency-switcher&section=payment-gateway' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Payment Gateways', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-currencyswitcher-exchange-rates-apis',
				'parent' => 'ao-givewp-currencyswitcher',
				'title'  => esc_attr__( 'Exchange Rates APIs', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=currency-switcher&section=exchange-rates-api' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Exchange Rates APIs', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-currencyswitcher-resources',
					'parent' => 'ao-givewp-currencyswitcher',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-currencyswitcher-docs',
				'group-givewp-currencyswitcher-resources',
				'https://givewp.com/documentation/add-ons/currency-switcher/'
			);

		}  // end if

}  // end function
