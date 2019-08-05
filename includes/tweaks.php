<?php

// includes/tweaks

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'wp_before_admin_bar_render', 'ddw_tbexgive_maybe_remove_toolbar_items' );
/**
 * Optionally remove original items from Toolbar Extras that may not be needed
 *   in a Give Donations context.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_id_main_item()
 *
 * @global mixed $GLOBALS[ 'wp_admin_bar' ]
 */
function ddw_tbexgive_maybe_remove_toolbar_items() {

	/** Toolbar Extras items/groups */
	if ( ddw_tbexgive_use_tweak_tbex_build_group() ) {
		$GLOBALS[ 'wp_admin_bar' ]->remove_node( ddw_tbex_id_main_item() );
	}

}  // end function


/**
 * Array with all GiveWP textdomains - base plugin, and all supported extensions.
 *
 * @since 1.0.0
 *
 * @return array Array of all textdomains for GiveWP + Add-Ons.
 */
function ddw_tbexgive_get_givewp_textdomains() {

	return array(

		/** Main plugin */
		'give',

		/** Official Add-Ons */
		'give-annual-receipts',
		'give-authorize',
		'give-aweber',
		'give-braintree',
		'give-ccavenue',
		'give-constant-contact',
		'give-convertkit',
		'give-currency-switcher',
		'give-dwolla',
		'give-fee-recovery',
		'give-form-field-manager',
		'give-gift-aid',
		'give-gocardless',
		'give-google-analytics',
		'give-manual-donations',
		'give-mailchimp',
		'give-paymill',
		'give-paypal-pro',
		'give-pdf-receipts',
		'give-per-form-gateways',
		'give-razorpay',
		'give-recurring',
		'give-sofort',
		'give-square',
		'give-stripe',
		'give-tributes',
		'give-twocheckout',
		'give-wepay',
		'give-zapier',
	);

}  // end function


add_filter( 'tbex_filter_unloading_textdomains', 'ddw_tbexgive_tweak_unload_textdomain_givewp' );
/**
 * Unload textdomain(s) for "GiveWP" plugin.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_use_tweak_unload_translations_givewp()
 * @uses ddw_tbexgive_get_givewp_textdomains()
 *
 * @param array $textdomains Array of textdomains.
 * @return array Modified array of textdomains for unloading.
 */
function ddw_tbexgive_tweak_unload_textdomain_givewp( $textdomains ) {

	/** Bail early if tweak shouldn't be used */
	if ( ! ddw_tbexgive_use_tweak_unload_translations_givewp() ) {
		return $textdomains;
	}

	//$givewp_domains = array( 'give', );

	return array_merge( $textdomains, ddw_tbexgive_get_givewp_textdomains() );

}  // end function
