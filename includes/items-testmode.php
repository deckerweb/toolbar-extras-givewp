<?php

// includes/items-testmode

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


remove_action( 'admin_head', '_give_test_mode_notice_admin_bar_css' );
remove_action( 'admin_bar_menu', '_give_show_test_mode_notice_in_admin_bar', 1000, 1 );

add_action( 'admin_bar_menu', 'ddw_tbexgive_item_give_test_mode', 1000, 1 );
/**
 * This tweaks the original GiveWP Test Mode and makes it available on the
 *   frontend too, plus, makes it more customizeable.
 *
 * @param WP_Admin_Bar $admin_bar WP_Admin_Bar instance, passed by reference.
 *
 * @return bool
 */
function ddw_tbexgive_item_give_test_mode( $admin_bar ) {

	/** Bail early if needed functions don't exist */
	if ( ! function_exists( 'give_is_setting_enabled' ) || ! function_exists( 'give_is_test_mode' ) ) {
		return FALSE;
	}

	/** Check Give Test Mode */
	$is_test_mode = ! empty( $_POST[ 'test_mode' ] ) ?
		give_is_setting_enabled( $_POST[ 'test_mode' ] ) :
		give_is_test_mode();

	if ( ! current_user_can( 'view_give_reports' ) || ! $is_test_mode ) {
		return FALSE;
	}

	/** Prepare */
	$use_icon = ddw_tbex_get_option( 'givewp', 'testmode_use_icon' );
	$label    = ddw_tbex_get_option( 'givewp', 'testmode_name' );
	$label    = ( ! empty( $label) ) ? $label : esc_attr__( 'Give Test Mode Active', 'toolbar-extras-givewp' );#
	$title    = $label;
	$class    = '';

	/** Build icon & title together */
	if ( 'givewp' === $use_icon ) {

		$class = 'tbex-node-givewp-logo';

		$title = sprintf(
			'<span class="dashicons-before ab-icon tbex-settings-icon tbexgive-givewp-logo"></span><span class="ab-label">%1$s</span>',
			$label
		);

	} elseif ( 'dashicon' === $use_icon ) {

		$class = 'tbex-node-givewp-dashicon';
		$title = ddw_tbex_item_title_with_settings_icon( $label, 'givewp', 'testmode_icon' );

	}  // end if

	// Add the main site admin menu item.
	$admin_bar->add_node(
		array(
			'id'     => 'give-test-notice',
			'parent' => 'top-secondary',
			'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gateways' ) ),
			'title'  => $title,		//ddw_tbex_item_title_with_settings_icon( $title, 'givewp', 'testmode_icon' ),
			'meta'   => array(
				'class'  => 'give-test-mode-active ' . $class,
				'target' => '',
				'title'  => esc_attr__( 'Give Test Mode Active - No Live Transactions will be processed', 'toolbar-extras-givewp' ),
			),
		)
	);

	return TRUE;

}  // end function
