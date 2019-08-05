<?php

// includes/givewp-addons/items-tributes

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_tributes', 100 );
/**
 * Items for Add-On: Give - Tributes (Premium, by GiveWP/ Impress.org, LLC)
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
function ddw_tbexgive_aoitems_tributes( $admin_bar ) {

	/** Use Add-On hook place */
	add_filter( 'tbexgive/filter/is_givewp_addon', '__return_empty_string' );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-tributes',
			'parent' => 'givewp-addons',
			'title'  => esc_attr__( 'Tributes', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=tributes' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'Tributes', 'toolbar-extras-givewp' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-tributes-settings',
				'parent' => 'ao-givewp-tributes',
				'title'  => esc_attr__( 'Settings', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=tributes' ) ),
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
					'id'     => 'ao-givewp-tributes-report-tribute-donations',
					'parent' => 'ao-givewp-tributes',
					'title'  => esc_attr__( 'Report: Tribute Donations', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-reports&tab=tributes&section=give-tributes-donations' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Report: All Tribute Donations', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'ao-givewp-tributes-report-mailacard',
					'parent' => 'ao-givewp-tributes',
					'title'  => esc_attr__( 'Report: Mail a Card', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-reports&tab=tributes&section=give-tributes-mail-card' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Report: Mail a Card', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'ao-givewp-tributes-report-ecards',
					'parent' => 'ao-givewp-tributes',
					'title'  => esc_attr__( 'Report: eCards', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-reports&tab=tributes&section=give-tributes-ecard' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Report: eCards', 'toolbar-extras-givewp' ),
					)
				)
			);

		}  // end if

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-tributes-resources',
					'parent' => 'ao-givewp-tributes',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-tributes-docs',
				'group-givewp-tributes-resources',
				'https://givewp.com/documentation/add-ons/tributes/'
			);

		}  // end if

}  // end function
