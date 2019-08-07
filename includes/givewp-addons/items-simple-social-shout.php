<?php

// includes/givewp-addons/items-simple-social-shout

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_simple_social_shout', 100 );
/**
 * Items for Add-On: Simple Social Shout for GiveWP (free, by Matt Cromwell)
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
function ddw_tbexgive_aoitems_simple_social_shout( $admin_bar ) {

	/** Bail early if no proper permissions */
	if ( ! current_user_can( 'manage_give_settings' ) ) {
		return $admin_bar;
	}
	
	/** Use Add-On hook place */
	add_filter( 'tbexgive/filter/is_givewp_addon', '__return_empty_string' );

	$give_settings        = get_option( 'give_settings' );
	$confirmation_page_id = $give_settings[ 'success_page' ];

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-simplesocialshout',
			'parent' => 'givewp-addons',
			'title'  => esc_attr__( 'Simple Social Shout', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=sss4givewp-setting-fields' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_free_addon_title_attr( __( 'Simple Social Shout for GiveWP', 'toolbar-extras-givewp' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-simplesocialshout-settings',
				'parent' => 'ao-givewp-simplesocialshout',
				'title'  => esc_attr__( 'Settings', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=sss4givewp-setting-fields' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Settings', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-simplesocialshout-page-preview',
				'parent' => 'ao-givewp-simplesocialshout',
				'title'  => esc_attr__( 'Donation Confirmation: Preview', 'toolbar-extras-givewp' ),
				'href'   => esc_url( get_permalink( $confirmation_page_id ) ),
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Donation Confirmation: Live Preview of Page', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-simplesocialshout-page-edit',
				'parent' => 'ao-givewp-simplesocialshout',
				'title'  => esc_attr__( 'Donation Confirmation: Edit Page', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'post.php?post=' . $confirmation_page_id . '&action=edit' ) ),
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Donation Confirmation: Edit this Page', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-simplesocialshout-resources',
					'parent' => 'ao-givewp-simplesocialshout',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-simplesocialshout-docs',
				'group-givewp-simplesocialshout-resources',
				'https://github.com/impress-org/give-simple-social-shout/blob/master/README.md'
			);

		}  // end if

}  // end function
