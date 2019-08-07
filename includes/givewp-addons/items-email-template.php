<?php

// includes/givewp-addons/items-email-template

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_email_template', 100 );
/**
 * Items for Add-On:
 *   Give Donation - Email Template (free, by Hannes Etzelstorfer/ codemiq KG)
 *   (including its base plugin "WP HTML Mail" by the same author)
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_free_addon_title_attr()
 * @uses ddw_tbex_display_items_resources()
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_aoitems_email_template( $admin_bar ) {

	/** Bail early if no proper permissions */
	if ( ! current_user_can( 'manage_options' ) ) {
		return $admin_bar;
	}

	/** Use Add-On hook place */
	add_filter( 'tbexgive/filter/is_givewp_addon', '__return_empty_string' );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-emailtemplate',
			'parent' => 'givewp-addons',
			'title'  => esc_attr__( 'HTML Email Template', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'options-general.php?page=wp-html-mail' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_free_addon_title_attr( __( 'Give Donation Email Template', 'toolbar-extras-givewp' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-emailtemplate-general',
				'parent' => 'ao-givewp-emailtemplate',
				'title'  => esc_attr__( 'General Template Options', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'options-general.php?page=wp-html-mail&tab=general' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Edit &amp; Preview General Email Template Options', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-emailtemplate-header',
				'parent' => 'ao-givewp-emailtemplate',
				'title'  => esc_attr__( 'Email Header', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'options-general.php?page=wp-html-mail&tab=header' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Edit &amp; Preview Email Header', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-emailtemplate-footer',
				'parent' => 'ao-givewp-emailtemplate',
				'title'  => esc_attr__( 'Email Footer', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'options-general.php?page=wp-html-mail&tab=footer' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Edit &amp; Preview Email Footer', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-emailtemplate-content',
				'parent' => 'ao-givewp-emailtemplate',
				'title'  => esc_attr__( 'Email Content (Body)', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'options-general.php?page=wp-html-mail&tab=content' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Edit &amp; Preview Email Content (Body)', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-emailtemplate-give-options',
				'parent' => 'ao-givewp-emailtemplate',
				'title'  => esc_attr__( 'Give Template Options', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'options-general.php?page=wp-html-mail&tab=plugins' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Give Template Options', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-emailtemplate-resources',
					'parent' => 'ao-givewp-emailtemplate',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-emailtemplate-docs',
				'group-givewp-emailtemplate-resources',
				'https://codemiq.com/en/support/wp-html-mail-documentation/'
			);

		}  // end if

}  // end function
