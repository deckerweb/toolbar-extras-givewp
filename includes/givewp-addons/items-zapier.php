<?php

// includes/givewp-addons/items-zapier

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_zapier', 100 );
/**
 * Items for Add-On: Give - Zapier (Premium, by GiveWP/ Impress.org, LLC)
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
function ddw_tbexgive_aoitems_zapier( $admin_bar ) {

	/** Bail early if no proper permissions */
	if ( ! current_user_can( 'manage_give_settings' ) ) {
		return $admin_bar;
	}
	
	/** Use Add-On hook place */
	add_filter( 'tbexgive/filter/is_givewp_addon', '__return_empty_string' );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-zapier',
			'parent' => 'givewp-addons',
			'title'  => esc_attr__( 'Zapier Integration', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=zapier' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'Zapier', 'toolbar-extras-givewp' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-zapier-settings',
				'parent' => 'ao-givewp-zapier',
				'title'  => esc_attr__( 'Setup &amp; Testing', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=zapier' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Setup Steps and Testing Triggers', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-zapier-settings',
				'parent' => 'ao-givewp-zapier',
				'title'  => esc_attr__( 'Setup &amp; Testing', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=zapier' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Setup Steps and Testing Triggers', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** Zapier Account */
		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-zapier-myzaps',
				'parent' => 'ao-givewp-zapier',
				'title'  => esc_attr__( 'My Zapier Zaps', 'toolbar-extras-givewp' ),
				'href'   => 'https://zapier.com/app/zaps',
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'My Zapier Zaps (zapier.com)', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-zapier-myhistory',
				'parent' => 'ao-givewp-zapier',
				'title'  => esc_attr__( 'My Zapier Task History', 'toolbar-extras-givewp' ),
				'href'   => 'https://zapier.com/app/history',
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'My Zapier Task History (zapier.com)', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-zapier-myapps',
				'parent' => 'ao-givewp-zapier',
				'title'  => esc_attr__( 'My Zapier Apps', 'toolbar-extras-givewp' ),
				'href'   => 'https://zapier.com/app/connections',
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'My Zapier Apps/ Connections (zapier.com)', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-zapier-resources',
					'parent' => 'ao-givewp-zapier',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-zapier-docs',
				'group-givewp-zapier-resources',
				'https://givewp.com/documentation/add-ons/zapier/'
			);

		}  // end if

}  // end function
