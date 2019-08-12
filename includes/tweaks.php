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


add_filter( 'parse_query', 'ddw_tbexgive_filter_all_givewp_pages' );
/**
 * Modify the query for our edit Page views filter (donation-pages=givewp).
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_display_givewp_pages_views_filter()
 * @uses ddw_tbexgive_get_all_givewp_pages_ids()
 *
 * @param object $query
 */
function ddw_tbexgive_filter_all_givewp_pages( $query ) {

	if ( is_admin()
		&& 'page' === $query->query[ 'post_type' ]
		&& current_user_can( 'manage_give_settings' )
		&& ddw_tbexgive_display_givewp_pages_views_filter()
	) {

		if ( isset( $_GET[ 'donation-pages' ] ) && 'givewp' === sanitize_key( wp_unslash( $_GET[ 'donation-pages' ] ) ) ) {

			$query->set( 'post__in', ddw_tbexgive_get_all_givewp_pages_ids() );

		}  // end if

	}  // end if

}  // end function


add_filter( 'views_edit-page', 'ddw_tbexgive_pages_givewp_views_filter', 10, 1 );
/**
 * Add a new Views filter on edit Page screen:
 *   Lists all GiveWP-specific pages, which are controlled via GiveWP settings
 *   or contain a GiveWP-specific Shortcode.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_display_givewp_pages_views_filter()
 * @uses ddw_tbexgive_get_all_givewp_pages_ids()
 * @uses ddw_tbexgive_string_givewp()
 *
 * @param array $views Holds all views of Page states (post states).
 * @return array Modified array of views.
 */
function ddw_tbexgive_pages_givewp_views_filter( $views ) {

	/** Bail early if no proper permissions */
	if ( ! current_user_can( 'manage_give_settings' )
		|| ! ddw_tbexgive_display_givewp_pages_views_filter()
	) {
		return $views;
	}

	$result = count( ddw_tbexgive_get_all_givewp_pages_ids() );
	$class  = ( isset( $_GET[ 'donation-pages' ] ) && 'givewp' == sanitize_key( wp_unslash( $_GET[ 'donation-pages' ] ) ) ) ? ' class="current"' : '';
  
	$admin_url = add_query_arg(
		'donation-pages',
		'givewp',
		admin_url( 'edit.php?post_type=page' )
	);

	$views[ 'donation-pages' ] = sprintf(
		'<a href="%1$s"%2$s>%3$s <span class="count">(%4$d)</span></a>',
		esc_url( $admin_url ),
	  	$class,
		ddw_tbexgive_string_givewp(),
		absint( $result )
	);

	return $views;

}  // end function


add_filter( 'display_post_states', 'ddw_tbexgive_add_post_state_givewp_shortcode_pages', 10, 2 );
/**
 * Adds a new post state "Give Shortcode" to all pages which contain a
 *   GiveWP-specific Shortcode.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_display_shortcode_post_state()
 * @uses ddw_tbexgive_get_givewp_shortcode_pages()
 * @uses ddw_tbexgive_string_givewp()
 *
 * @param array  $post_states Array holding all post states.
 * @param object $post        Object of the current post type item.
 * @return array Modified array of post states.
 */
function ddw_tbexgive_add_post_state_givewp_shortcode_pages( $post_states, $post ) {

	/** Bail early if no Post State wanted */
	if ( ! ddw_tbexgive_display_shortcode_post_state() ) {
		return $post_states;
	}

	/** Conditionally add post state where wanted */
	if ( 'page' === $post->post_type ) {

		/** Only add row action if we have a Oxygen-enabled item */
		if ( in_array( $post->ID, ddw_tbexgive_get_givewp_shortcode_pages() ) ) {

			$post_states[ 'givewp_shortcode_page' ] = sprintf(
				/* translators: %s - label, "Give" */
				__( '%s Shortcode', 'Label for Post State', 'toolbar-extras-oxygen' ),
				ddw_tbexgive_string_givewp()
			);

		}  // end if

	}  // end if

	return $post_states;

}  // end function


add_action( 'wp_before_admin_bar_render', 'ddw_tbexgive_maybe_remove_toolbar_items' );
/**
 * Optionally remove original items from Toolbar Extras that may not be needed
 *   in a Give Donations context.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_use_tweak_tbex_build_group()
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
 * @uses ddw_tbexgive_use_admin_menu_tweak()
 * @uses ddw_tbexgive_string_givewp()
 * @uses add_submenu_page()
 */
function ddw_tbexgive_add_submenu_for_givewp_changelog() {

	/** Bail early if Give Donations not active, or, if tweak should not be used */
	if ( ! ddw_tbexgive_is_givewp_active()
		|| ! ddw_tbexgive_use_admin_menu_tweak()
	) {
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


add_action( 'admin_menu', 'ddw_tbexgive_add_submenu_for_givewp_pages', 1000 );
/**
 * Add additional admin menu items to make Toolbar settings more accessable.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_display_givewp_pages_views_filter()
 * @uses ddw_tbexgive_string_givewp()
 * @uses add_submenu_page()
 */
function ddw_tbexgive_add_submenu_for_givewp_pages() {

	/** Bail early if no proper permissions or not wanted */
	if ( ! current_user_can( 'manage_give_settings' )
		|| ! ddw_tbexgive_display_givewp_pages_views_filter()
	) {
		return;
	}

	$admin_url = add_query_arg(
		'donation-pages',
		'givewp',
		admin_url( 'edit.php?post_type=page' )
	);

	$menu_title = sprintf(
		/* translators: %s - label, "Give" */
		esc_attr__( '%s Pages', 'toolbar-extras-givewp' ),
		ddw_tbexgive_string_givewp()
	);

	add_submenu_page(
		'edit.php?post_type=page',
		$menu_title,
		$menu_title,
		'manage_give_settings',
		esc_url( $admin_url )
	);

}  // end function


add_filter( 'parent_file', 'ddw_tbexgive_parent_submenu_tweaks' );
/**
 * Tweak Give Changelog parent file/ submenu file.
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
 * Tweak submenu file.
 *
 * @since 1.0.0
 *
 * @param string $submenu_file The filename of the submenu.
 * @param string $parent_file  The filename of the parent menu.
 * @return string $submenu_file The modified string for submenu.
 */
function ddw_tbexgive_submenu_file_tweaks( $submenu_file, $parent_file ){

	if ( 'dashboard_page_give-changelog' === get_current_screen()->id ) {

		$parent_file  = 'edit.php?post_type=give_forms';
		$submenu_file = 'index.php?page=give-changelog';

	}  // end if

	return $submenu_file;

}  // end function


/**
 * Get an array with all known GiveWP textdomains - base plugin, and all
 *   supported Add-Ons.
 *
 * @since 1.0.0
 *
 * @return array Array of all known textdomains for GiveWP + Add-Ons.
 */
function ddw_tbexgive_get_givewp_textdomains() {

	return apply_filters(
		'tbexgive/filter/givewp/textdomains',
		array(

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

			/** Misc Add-Ons */
			'sss-4-givewp',
		)
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

	return array_merge( $textdomains, ddw_tbexgive_get_givewp_textdomains() );

}  // end function
