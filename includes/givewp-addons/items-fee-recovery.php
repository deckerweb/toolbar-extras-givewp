<?php

// includes/givewp-addons/items-fee-recovery

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_fee_recovery', 100 );
/**
 * Items for Add-On: Give - Fee Recovery (Premium, by GiveWP/ Impress.org, LLC)
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_premium_addon_title_attr()
 * @uses ddw_tbex_display_items_resources()
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_aoitems_fee_recovery( $admin_bar ) {

	/** Use Add-On hook place */
	add_filter( 'tbexgive/filter/is_givewp_addon', '__return_empty_string' );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-feerecovery',
			'parent' => 'givewp-addons',
			'title'  => esc_attr__( 'Fee Recovery', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=givefeerecovery' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'Fee Recovery', 'toolbar-extras-givewp' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-feerecovery-settings',
				'parent' => 'ao-givewp-feerecovery',
				'title'  => esc_attr__( 'Settings', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=givefeerecovery' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Settings', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** Reports */
		if ( current_user_can( 'view_give_reports' ) ) {

			$admin_bar->add_node(
				array(
					'id'     => 'ao-givewp-feerecovery-report-income',
					'parent' => 'ao-givewp-feerecovery',
					'title'  => esc_attr__( 'Report: Fee Income', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-reports&tab=fee&section=give-fee-income' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Settings', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'ao-givewp-feerecovery-report-conversion',
					'parent' => 'ao-givewp-feerecovery',
					'title'  => esc_attr__( 'Report: Fee Conversion', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-reports&tab=fee&section=give-fee-conversion' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Settings', 'toolbar-extras-givewp' ),
					)
				)
			);

		}  // end if

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-feerecovery-resources',
					'parent' => 'ao-givewp-feerecovery',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-feerecovery-docs',
				'group-givewp-feerecovery-resources',
				'https://givewp.com/documentation/add-ons/fee-recovery/'
			);

		}  // end if

}  // end function
