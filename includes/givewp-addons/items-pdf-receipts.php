<?php

// includes/givewp-addons/items-pdf-receipts

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_pdf_receipts', 100 );
/**
 * Items for Add-On: Give - PDF Receipts (Premium, by GiveWP/ Impress.org, LLC)
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
function ddw_tbexgive_aoitems_pdf_receipts( $admin_bar ) {

	/** Bail early if no proper permissions */
	if ( ! current_user_can( 'manage_give_settings' ) ) {
		return $admin_bar;
	}
	
	/** Use Add-On hook place */
	add_filter( 'tbexgive/filter/is_givewp_addon', '__return_empty_string' );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-pdfreceipts',
			'parent' => 'givewp-addons',
			'title'  => esc_attr__( 'PDF Receipts', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=pdf_receipts' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'PDF Receipts', 'toolbar-extras-givewp' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-pdfreceipts-settings',
				'parent' => 'ao-givewp-pdfreceipts',
				'title'  => esc_attr__( 'Template Builder', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=pdf_receipts' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Template Builder &amp; Settings', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-pdfreceipts-preview',
				'parent' => 'ao-givewp-pdfreceipts',
				'title'  => esc_attr__( 'Preview PDF Receipt', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( '?give_pdf_receipts_action=preview_pdf' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Preview PDF Receipt - Opens PDF File', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-pdfreceipts-resources',
					'parent' => 'ao-givewp-pdfreceipts',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-pdfreceipts-docs',
				'group-givewp-pdfreceipts-resources',
				'https://givewp.com/documentation/add-ons/pdf-receipts/'
			);

		}  // end if

}  // end function
