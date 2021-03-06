<?php

// includes/givewp-addons/items-mailchimp-for-wp

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_mailchimp_for_wp', 100 );
/**
 * Items for Add-On: Mailchimp for WordPress (free, by ibericode)
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_free_addon_title_attr()
 * @uses ddw_tbex_meta_target()
 * @uses ddw_tbex_display_items_resources()
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_aoitems_mailchimp_for_wp( $admin_bar ) {

	/** Bail early if no proper permissions */
	if ( ! current_user_can( 'manage_options' ) ) {
		return $admin_bar;
	}

	/** Use Add-On hook place */
	add_filter( 'tbexgive/filter/is_givewp_addon', '__return_empty_string' );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-mc4wp',
			'parent' => 'givewp-addons',
			'title'  => esc_attr__( 'Mailchimp for WP', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'admin.php?page=mailchimp-for-wp' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_free_addon_title_attr( __( 'Mailchimp for WP', 'toolbar-extras-givewp' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-mc4wp-integration',
				'parent' => 'ao-givewp-mc4wp',
				'title'  => esc_attr__( 'Give Integration', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'admin.php?page=mailchimp-for-wp-integrations&integration=give' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Give Integration', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-mc4wp-audience',
				'parent' => 'ao-givewp-mc4wp',
				'title'  => esc_attr__( 'My Mailchimp Audience', 'toolbar-extras-givewp' ),
				'href'   => 'https://us2.admin.mailchimp.com/audience/',
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'My Mailchimp Audience', 'toolbar-extras-givewp' ) . ' (mailchimp.com)',
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-mc4wp-campaigns',
				'parent' => 'ao-givewp-mc4wp',
				'title'  => esc_attr__( 'My Mailchimp Campaigns', 'toolbar-extras-givewp' ),
				'href'   => 'https://us2.admin.mailchimp.com/campaigns/',
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'My Mailchimp Campaigns', 'toolbar-extras-givewp' ) . ' (mailchimp.com)',
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-mc4wp-resources',
					'parent' => 'ao-givewp-mc4wp',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-mc4wp-docs',
				'group-givewp-mc4wp-resources',
				'https://kb.mc4wp.com/category/integrations/'
			);

		}  // end if

}  // end function
