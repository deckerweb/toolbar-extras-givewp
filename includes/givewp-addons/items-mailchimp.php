<?php

// includes/givewp-addons/items-mailchimp

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_mailchimp', 100 );
/**
 * Items for Add-On:
 *   Give - Mailchimp (Premium, by GiveWP/ Impress.org, LLC)
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
function ddw_tbexgive_aoitems_mailchimp( $admin_bar ) {

	/** Use Add-On hook place */
	add_filter( 'tbexgive/filter/is_givewp_addon', '__return_empty_string' );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-mailchimp',
			'parent' => 'givewp-addons',
			'title'  => esc_attr__( 'Mailchimp', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=give-mailchimp' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'Mailchimp', 'toolbar-extras-givewp' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-mailchimp-settings',
				'parent' => 'ao-givewp-mailchimp',
				'title'  => esc_attr__( 'Settings', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=give-mailchimp' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Settings', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-mailchimp-audience',
				'parent' => 'ao-givewp-mailchimp',
				'title'  => esc_attr__( 'My Mailchimp Audience', 'toolbar-extras-givewp' ),
				'href'   => 'https://us2.admin.mailchimp.com/audience/',
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'My Mailchimp Audience (mailchimp.com)', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-mailchimp-campaigns',
				'parent' => 'ao-givewp-mailchimp',
				'title'  => esc_attr__( 'My Mailchimp Campaigns', 'toolbar-extras-givewp' ),
				'href'   => 'https://us2.admin.mailchimp.com/campaigns/',
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'My Mailchimp Campaigns (mailchimp.com)', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-mailchimp-resources',
					'parent' => 'ao-givewp-mailchimp',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-mailchimp-docs',
				'group-givewp-mailchimp-resources',
				'https://givewp.com/documentation/add-ons/mailchimp/'
			);

		}  // end if

}  // end function
