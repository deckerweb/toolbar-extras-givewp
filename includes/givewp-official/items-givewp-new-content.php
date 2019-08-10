<?php

// includes/givewp-official/items-givewp-new-content

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_filter( 'admin_bar_menu', 'ddw_tbexgive_items_new_content_give_form', 100 );
/**
 * Item for New Content Group: New Give Form (Campaign)
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_display_items_new_content()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_items_new_content_give_form( $admin_bar ) {

	/** Bail early if items display is not wanted */
	/*
	if ( ! ddw_tbex_display_items_new_content() ) {
		return;
	}
	*/

	$admin_bar->add_node(
		array(
			'id'     => 'new-give_forms',		// same as original!
			'title'  => esc_attr__( 'Give Donation Form', 'toolbar-extras-givewp' ),
			'meta'   => array(
				'title'  => esc_attr__( 'Give Donation Form/ Campaign', 'toolbar-extras-givewp' ),
			)
		)
	);

}  // end if
