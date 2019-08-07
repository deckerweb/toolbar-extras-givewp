<?php

// includes/givewp-addons/items-gift-aid

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_gift_aid', 100 );
/**
 * Items for Add-On: Give - Gift Aid (Premium, by GiveWP/ Impress.org, LLC)
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
function ddw_tbexgive_aoitems_gift_aid( $admin_bar ) {

	/** Use Add-On hook place */
	add_filter( 'tbexgive/filter/is_givewp_addon', '__return_empty_string' );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-giftaid',
			'parent' => 'givewp-addons',
			'title'  => esc_attr__( 'Gift Aid', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gift-aid' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'Gift Aid', 'toolbar-extras-givewp' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-giftaid-settings',
				'parent' => 'ao-givewp-giftaid',
				'title'  => esc_attr__( 'Settings', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gift-aid' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Settings', 'toolbar-extras-givewp' ),
				)
			)
		);

		if ( current_user_can( 'view_give_reports' ) ) {

			$admin_bar->add_node(
				array(
					'id'     => 'ao-givewp-giftaid-report',
					'parent' => 'ao-givewp-giftaid',
					'title'  => esc_attr__( 'Report: Gift Aid Donations', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-reports&tab=gift-aid' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Report: All Gift Aid Donations', 'toolbar-extras-givewp' ),
					)
				)
			);

		}  // end if

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-giftaid-resources',
					'parent' => 'ao-givewp-giftaid',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-giftaid-docs',
				'group-givewp-giftaid-resources',
				'https://givewp.com/documentation/add-ons/gift-aid/'
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-giftaid-ukgov-info',
					'parent' => 'group-givewp-giftaid-resources',
					'title'  => esc_attr__( 'UK Gift Aid Program', 'toolbar-extras-givewp' ),
					'href'   => 'https://www.gov.uk/donating-to-charity/gift-aid',
					'meta'   => array(
						'target' => ddw_tbex_meta_target(),
						'title'  => esc_attr__( 'United Kingdom Government: Gift Aid Program Info', 'toolbar-extras-givewp' ),
					)
				)
			);

		}  // end if

}  // end function
