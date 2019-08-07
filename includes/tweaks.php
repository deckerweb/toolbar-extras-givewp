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


add_action( 'admin_menu', 'ddw_tbexgive_add_submenu_for_givewp_changelog', 1000 );
/**
 * Add additional admin menu items to make Toolbar settings more accessable.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_is_givewp_active()
 * @uses ddw_tbexgive_string_givewp()
 * @uses add_submenu_page()
 */
function ddw_tbexgive_add_submenu_for_givewp_changelog() {

	/** Bail early if Give Donations not active */
	if ( ! ddw_tbexgive_is_givewp_active() ) {
		return;
	}

	remove_action( 'admin_menu', 'give_add_add_ons_option_link', 999999 );

	/** Add to Give's regular left-hand admin menu */
	$menu_title = sprintf(
		/* translators: %s - Word Give */
		esc_html_x( '%s Changelog', 'Admin submenu title', 'toolbar-extras-givewp' ),
		ddw_tbexgive_string_givewp()
	);

	add_submenu_page(
		'edit.php?post_type=give_forms',
		$menu_title,
		$menu_title,
		'manage_options',
		esc_url( admin_url( 'index.php?page=give-changelog' ) )
	);

}  // end function


add_filter( 'parent_file', 'ddw_tbexgive_parent_submenu_tweaks' );
/**
 * When editing an Oxygen template within the Admin, properly highlight it as
 *   the 'submenu' of Oxygen.
 *
 * @since 1.0.0
 * @since 1.1.0 Simplified and tweaked for Oxygen 2.3 or higher.
 *
 * @uses get_current_screen()
 *
 * @param string $parent_file The filename of the parent menu.
 * @return string $parent_file The tweaked filename of the parent menu.
 */
function ddw_tbexgive_parent_submenu_tweaks( $parent_file ) {

	if ( 'dashboard_page_give-changelog' === get_current_screen()->id ) {

		$parent_file = 'edit.php?post_type=give_forms';
		$GLOBALS[ 'submenu_file' ] = 'give-changelog';

	}  // end if

	return $parent_file;

}  // end function


add_filter( 'submenu_file', 'ddw_tbexgive_submenu_file_tweaks', 10, 2 );
/**
 * ???
 *
 * @since 1.0.0
 */
function ddw_tbexgive_submenu_file_tweaks( $submenu_file, $parent_file ){

	if ( 'dashboard_page_give-changelog' === get_current_screen()->id ) {

		$parent_file = 'edit.php?post_type=give_forms';
		$submenu_file = 'index.php?page=give-changelog';

	}  // end if

	return $submenu_file;
}


//add_action( 'admin_footer', 'ddw_debugging_admin_20190807_1526', 100000 );
function ddw_debugging_admin_20190807_1526() {

	echo '<div class="admin notice error"><p>';

	echo 'Debugging: ' . '';

	echo '<br /><br />Array-Inhalt:<br />';
	print_r( $GLOBALS[ 'submenu' ][ 'edit.php?post_type=give_forms' ] );

	echo '</p></div>';

}  // end debugging function


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
