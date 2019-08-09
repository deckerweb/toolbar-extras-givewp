<?php

// includes/givewp-addons/items-annual-receipts

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_annual_receipts', 100 );
/**
 * Items for Add-On:
 *   Give - Annual Receipts (Premium, by GiveWP/ Impress.org, LLC)
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
function ddw_tbexgive_aoitems_annual_receipts( $admin_bar ) {

	/** Bail early if no proper permissions */
	if ( ! current_user_can( 'manage_give_settings' ) ) {
		return $admin_bar;
	}
	
	/** Use Add-On hook place */
	add_filter( 'tbexgive/filter/is_givewp_addon', '__return_empty_string' );

	$give_settings   = get_option( 'give_settings' );
	$history_page_id = $give_settings[ 'history_page' ];
	$donor           = function_exists( 'give_annual_receipts_get_donor_object' ) ? give_annual_receipts_get_donor_object() : '';

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-annualreceipts',
			'parent' => 'givewp-addons',
			'title'  => esc_attr__( 'Annual Receipts', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=annual_receipts' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'Annual Receipts', 'toolbar-extras-givewp' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-annualreceipts-settings',
				'parent' => 'ao-givewp-annualreceipts',
				'title'  => esc_attr__( 'Template Builder', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=annual_receipts' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Template Builder &amp; Settings', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** Page Preview (Sub Section of Donation History Page) */
		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-annualreceipts-preview-page',
				'parent' => 'ao-givewp-annualreceipts',
				'title'  => esc_attr__( 'Page Preview', 'toolbar-extras-givewp' ),
				'href'   => wp_nonce_url( home_url( add_query_arg( 'give_action', 'annual_receipt' ) ), 'annual-receipt-' . $donor->id ),	//esc_url( get_permalink( $history_page_id ) . '/?give_action=annual_receipt' ),
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Annual Receipt Preview of Page - Opens Section of Donation History Page', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** PDF Preview */
		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-annualreceipts-preview-pdf',
				'parent' => 'ao-givewp-annualreceipts',
				'title'  => esc_attr__( 'PDF Preview', 'toolbar-extras-givewp' ),
				'href'   => wp_nonce_url( add_query_arg( 'give_action', 'annual_receipt', get_permalink( $history_page_id ) ), 'annual-receipt-' . $donor->id ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'PDF Preview of Annual Receipt - Opens PDF File', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** For GiveWP Pages */
		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-pages-misc-annualreceipts',
				'parent' => 'group-givewp-pages-misc',
				'title'  => esc_attr__( 'Annual Receipts', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'post.php?post=' . $history_page_id . '&action=edit' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Annual Receipts', 'toolbar-extras-givewp' ),
				)
			)
		);

			$admin_bar->add_node(
				array(
					'id'     => 'ao-givewp-pages-misc-annualreceipts-preview',
					'parent' => 'ao-givewp-pages-misc-annualreceipts',
					'title'  => esc_attr__( 'Live Preview', 'toolbar-extras-givewp' ),
					'href'   => wp_nonce_url( add_query_arg( 'give_action', 'annual_receipt', get_permalink( $history_page_id ) ), 'annual-receipt-' . $donor->id ),
					'meta'   => array(
						'target' => ddw_tbex_meta_target(),
						'title'  => esc_attr__( 'Live Preview Page', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'ao-givewp-pages-misc-annualreceipts-edit',
					'parent' => 'ao-givewp-pages-misc-annualreceipts',
					'title'  => esc_attr__( 'Edit Page', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'post.php?post=' . $history_page_id . '&action=edit' ) ),
					'meta'   => array(
						'target' => ddw_tbex_meta_target(),
						'title'  => esc_attr__( 'Edit Page', 'toolbar-extras-givewp' ),
					)
				)
			);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-annualreceipts-resources',
					'parent' => 'ao-givewp-annualreceipts',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-annualreceipts-docs',
				'group-givewp-annualreceipts-resources',
				'https://givewp.com/documentation/add-ons/give-annual-receipts-overview/'
			);

		}  // end if

}  // end function
