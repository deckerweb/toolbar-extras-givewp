<?php

// includes/givewp-addons/items-manual-donations

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_manual_donations', 100 );
/**
 * Items for Add-On:
 *   Give - Manual Donations (Premium, by GiveWP/ Impress.org, LLC)
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
function ddw_tbexgive_aoitems_manual_donations( $admin_bar ) {

	/** Bail early if no proper permissions */
	if ( ! current_user_can( 'edit_give_payments' ) ) {
		return $admin_bar;
	}

	/** Use Add-On hook place */
	add_filter( 'tbexgive/filter/is_givewp_addon', '__return_empty_string' );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-manualdonations',
			'parent' => 'givewp-addons',
			'title'  => esc_attr__( 'Manual Donations', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-manual-donation' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'Manual Donations', 'toolbar-extras-givewp' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-manualdonations-new',
				'parent' => 'ao-givewp-manualdonations',
				'title'  => esc_attr__( 'New Manual Donation', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-manual-donation' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Add new Manual Donation Payment', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-manualdonations-resources',
					'parent' => 'ao-givewp-manualdonations',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-manualdonations-docs',
				'group-givewp-manualdonations-resources',
				'https://givewp.com/documentation/add-ons/manual-donations/'
			);

		}  // end if

}  // end function


add_filter( 'admin_bar_menu', 'ddw_tbexgive_items_new_content_manual_donation', 1000 );
/**
 * Item for New Content Group: New Manual Donation
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_display_items_new_content()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_items_new_content_manual_donation( $admin_bar ) {

	/** Bail early if items display is not wanted, or no proper permissions */
	if ( ! ddw_tbex_display_items_new_content()
		|| ! current_user_can( 'edit_give_payments' )
		|| is_network_admin()
	) {
		return $admin_bar;
	}

	$admin_bar->add_node(
		array(
			'id'     => 'give-md-new-payment',		// same as original!
			'title'  => esc_attr__( 'Manual Donation', 'toolbar-extras-givewp' ),
			'meta'   => array(
				'title'  => esc_attr__( 'Give Manual Donation Payment', 'toolbar-extras-givewp' ),
			)
		)
	);

}  // end if
