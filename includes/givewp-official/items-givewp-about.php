<?php

// includes/givewp-official/items-givewp-about

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_items_givewp_about', 30 );
/**
 * "About" items for Give Donations, under WP Logo Group.
 *
 * @since 1.0.0
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_items_givewp_about( $admin_bar ) {

	$admin_bar->add_node(
		array(
			'id'     => 'givewp-about',
			'parent' => 'wp-logo',
			'title'  => esc_attr__( 'About Give Donations', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'index.php?page=give-getting-started' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => esc_attr__( 'About Give Donations - Getting Started', 'toolbar-extras-givewp' ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-about-getting-started',
				'parent' => 'givewp-about',
				'title'  => esc_attr__( 'Getting Started', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'index.php?page=give-getting-started' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Getting Started with Give Donations', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-about-whats-new',
				'parent' => 'givewp-about',
				'title'  => esc_attr__( 'What\'s New', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'index.php?page=give-changelog' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'What\'s New - Changelog', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-about-credits',
				'parent' => 'givewp-about',
				'title'  => esc_attr__( 'Credits &amp; Contributors', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'index.php?page=give-credits' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Credits &amp; Contributors', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-about-translations',
				'parent' => 'givewp-about',
				'title'  => esc_attr__( 'Translations', 'toolbar-extras-givewp' ),
				'href'   => ddw_tbex_get_resource_url( 'givewp', 'url_translations' ),
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Help Translate Give Donations Plugin', 'toolbar-extras-givewp' ),
				)
			)
		);

}  // end function
