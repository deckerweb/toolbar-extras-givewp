<?php

// includes/functions-global

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Setting internal plugin helper values.
 *
 * @since 1.0.0
 *
 * @return array $tbexgive_info Array of info values.
 */
function ddw_tbexgive_info_values() {

	$tbexgive_info = array(

		'url_translate'       => 'https://translate.wordpress.org/projects/wp-plugins/toolbar-extras-givewp',
		'url_wporg_faq'       => 'https://wordpress.org/plugins/toolbar-extras-givewp/#faq',
		'url_wporg_forum'     => 'https://wordpress.org/support/plugin/toolbar-extras-givewp',
		'url_wporg_review'    => 'https://wordpress.org/support/plugin/toolbar-extras-givewp/reviews/?filter=5/#new-post',
		'url_snippets'        => 'https://toolbarextras.com/docs-category/custom-code-snippets/',
		'first_code'          => '2019',
		'url_plugin'          => 'https://toolbarextras.com/addons/give-donations/',
		'url_plugin_docs'     => 'https://toolbarextras.com/docs-category/givewp-addon/',
		'url_plugin_faq'      => 'https://toolbarextras.com/docs-category/faqs/',
		'url_github'          => 'https://github.com/deckerweb/toolbar-extras-givewp',
		'url_github_issues'   => 'https://github.com/deckerweb/toolbar-extras-givewp/issues',

		/** For settings etc. */
		'url_give_shortcodes' => 'https://givewp.com/documentation/core/shortcodes/',

	);  // end of array

	return $tbexgive_info;

}  // end function


/**
 * Helper: ID string for Donations main item.
 *
 * @since 1.0.0
 *
 * @return string ID of main item.
 */
function ddw_tbexgive_id_donations_item() {

	return strtolower(
		sanitize_html_class(
			apply_filters(
				'tbexgive/filter/donations_item/id',
				'tbex-givewp-donations'
			),
			'tbex-givewp-donations'	// fallback
		)
	);

}  // end function


/**
 * To get filterable hook priority for main Donations item.
 *   Default: 72 - that means after "Build" group (and after "New Content" group).
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return int Hook priority for main item.
 */
function ddw_tbexgive_donations_item_priority() {

	return absint(
		apply_filters(
			'tbexgive/filter/donations_item/priority',
			ddw_tbex_get_option( 'givewp', 'donations_tl_priority' )	// 72	// 72.01
		)
	);

}  // end function


/**
 * To get filterable hook priority for optional Featured Form item.
 *   Default: 1000 - that means after "Build" group (and after "New Content" group).
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return int Hook priority for main item.
 */
function ddw_tbexgive_formfeat_item_priority() {

	return absint(
		apply_filters(
			'tbexgive/filter/formfeat_item/priority',
			ddw_tbex_get_option( 'givewp', 'formfeat_priority' )	// 1000
		)
	);

}  // end function


/**
 * Get all time ranges for reports, filterable.
 *
 * @since 1.0.0
 *
 * @return array Filterable array of time ranges for reports.
 */
function ddw_tbexgive_get_report_ranges() {

	return apply_filters(
		'tbexgive/filter/reports/ranges',
		array(
			'today'        => _x( 'Today', 'Time range for filtering', 'toolbar-extras-givewp' ),
			'yesterday'    => _x( 'Yesterday', 'Time range for filtering', 'toolbar-extras-givewp' ),
			'this_week'    => _x( 'This Week', 'Time range for filtering', 'toolbar-extras-givewp' ),
			'last_week'    => _x( 'Last Week', 'Time range for filtering', 'toolbar-extras-givewp' ),
			'this_month'   => _x( 'This Month', 'Time range for filtering', 'toolbar-extras-givewp' ),
			'last_month'   => _x( 'Last Month', 'Time range for filtering', 'toolbar-extras-givewp' ),
			'this_quarter' => _x( 'This Quarter', 'Time range for filtering', 'toolbar-extras-givewp' ),
			'last_quarter' => _x( 'Last Quarter', 'Time range for filtering', 'toolbar-extras-givewp' ),
			'this_year'    => _x( 'This Year', 'Time range for filtering', 'toolbar-extras-givewp' ),
			'last_year'    => _x( 'Last Year', 'Time range for filtering', 'toolbar-extras-givewp' ),
		)
	);

}  // end function


/**
 * Get the IDs of all GiveWP Donation-specific pages which are controlled via
 *   GiveWP settings.
 *
 * @since 1.0.0
 *
 * @return array Array of page IDs.
 */
function ddw_thexgive_get_givewp_donation_pages() {

	$give_settings = get_option( 'give_settings' );

	$give_pages = apply_filters(
		'tbexgive/filter/givewp_pages/settings_based',
		array(
			'success_page',
			'failure_page',
			'history_page',
			'subscriptions_page',
		)
	);

	$give_pages_ids = array();

	foreach ( $give_pages as $give_page ) {

		$give_pages_ids[] = absint( $give_settings[ $give_page ] );

	}  // end foreach

	return $give_pages_ids;

}  // end function


/**
 * Get the IDs of all pages that contain GiveWP-specific Shortcodes - beyond the
 *   Donation-specific pages which are already controlled via GiveWP settings.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_pages_with_shortcode()
 */
function ddw_tbexgive_get_givewp_shortcode_pages() {

	$give_shortcodes = apply_filters(
		'tbexgive/filter/givewp_pages/shortcode_based',
		array(
			'give_donor_wall',
			'give_form_grid',
			'give_login',
			'give_register',
			'give_profile_editor',
		)
	);

	$give_shorcode_pages_ids = array();

	foreach ( $give_shortcodes as $give_shortcode ) {

		if ( ! is_null( ddw_tbex_get_pages_with_shortcode( $give_shortcode ) ) ) {

			foreach ( ddw_tbex_get_pages_with_shortcode( $give_shortcode ) as $give_shorcode_page ) {

				$give_shorcode_pages_ids[] = absint( $give_shorcode_page->ID );

			}  // end foreach

		}  // end if

	}  // end foreach

	return $give_shorcode_pages_ids;

}  // end function


/**
 * Get the IDs of pages that are either a Donation-specific GiveWP page
 *   (settings controlled) or contain a GiveWP-specific Shortcode.
 *
 * @since 1.0.0
 *
 * @uses ddw_thexgive_get_givewp_donation_pages()
 * @uses ddw_tbexgive_get_givewp_shortcode_pages()
 */
function ddw_tbexgive_get_all_givewp_pages_ids() {

	return apply_filters(
		'tbexgive/filter/givewp_pages/ids',
		array_merge( ddw_thexgive_get_givewp_donation_pages(), ddw_tbexgive_get_givewp_shortcode_pages() )
	);

}  // end function
