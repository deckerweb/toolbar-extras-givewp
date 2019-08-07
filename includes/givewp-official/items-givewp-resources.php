<?php

// includes/givewp-official/items-givewp-resources

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_items_givewp_core_resources', 99 );
/**
 * Give Donations external resources items
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_display_items_resources()
 * @uses ddw_tbexgive_string_give_resources()
 * @uses ddw_tbex_get_resource_url()
 * @uses ddw_tbex_meta_rel()
 * @uses ddw_tbex_meta_target()
 * @uses ddw_tbex_resource_item()
 * @uses ddw_tbexgive_string_givewp()
 *
 * @param object $admin_bar Holds all nodes of the Toolbar.
 */
function ddw_tbexgive_items_givewp_core_resources( $admin_bar ) {

	/** Bail early if resources display is disabled */
	/*
	if ( ! ddw_tbex_display_items_resources() ) {
		return;
	}
	*/

	$admin_bar->add_node(
		array(
			'id'     => 'givewp-resources',
			'parent' => 'group-donation-resources',
			'title'  => ddw_tbexgive_string_give_resources(),
			'href'   => ddw_tbex_get_resource_url( 'givewp', 'url_docs' ),
			'meta'   => array(
				'rel'    => ddw_tbex_meta_rel(),
				'target' => ddw_tbex_meta_target(),
				'title'  => ddw_tbexgive_string_give_resources(),
			)
		)
	);

		ddw_tbex_resource_item(
			'documentation',
			'givewp-resources-docs',
			'givewp-resources',
			ddw_tbex_get_resource_url( 'givewp', 'url_docs' )
		);

		ddw_tbex_resource_item(
			'tutorials',
			'givewp-resources-tutorials',
			'givewp-resources',
			ddw_tbex_get_resource_url( 'givewp', 'url_tutorials' ),
			sprintf(
				/* translators: %s - Word "Give" */
				esc_attr__( 'Getting Started - Learn %s Tutorials', 'toolbar-extras-givewp' ),
				ddw_tbexgive_string_givewp()
			)
		);

		ddw_tbex_resource_item(
			'youtube-channel',
			'givewp-resources-youtube',
			'givewp-resources',
			ddw_tbex_get_resource_url( 'givewp', 'url_videos' )
		);

		ddw_tbex_resource_item(
			'support-contact',
			'givewp-resources-support-contact',
			'givewp-resources',
			ddw_tbex_get_resource_url( 'givewp', 'url_support_contact' )
		);

		ddw_tbex_resource_item(
			'official-blog',
			'givewp-resources-blog',
			'givewp-resources',
			ddw_tbex_get_resource_url( 'givewp', 'url_blog' )
		);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-resources-bugs-features',
				'parent' => 'givewp-resources',
				'title'  => esc_attr__( 'Bug Reports &amp; Feature Requests', 'toolbar-extras-givewp' ),
				'href'   => ddw_tbex_get_resource_url( 'givewp', 'url_github_issues' ),
				'meta'   => array(
					'rel'    => ddw_tbex_meta_rel(),
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Bug Reports &amp; Feature Requests via GitHub Issues', 'toolbar-extras-givewp' ),
				)
			)
		);

		ddw_tbex_resource_item(
			'my-account',
			'givewp-resources-account-portal',
			'givewp-resources',
			ddw_tbex_get_resource_url( 'givewp', 'url_myaccount' )
		);

		/** Developer documentation */
		if ( ddw_tbex_display_items_dev_mode() && current_user_can( 'manage_options' ) ) {

			ddw_tbex_resource_item(
				'documentation-dev',
				'givewp-resources-developer-docs',
				'givewp-resources',
				ddw_tbex_get_resource_url( 'givewp', 'url_docs_developer' )
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-resources-snippet-library',
					'parent' => 'givewp-resources',
					'title'  => esc_attr__( 'Snippet Library', 'toolbar-extras-givewp' ),
					'href'   => ddw_tbex_get_resource_url( 'givewp', 'url_snippet_library' ),
					'meta'   => array(
						'rel'    => ddw_tbex_meta_rel(),
						'target' => ddw_tbex_meta_target(),
						'title'  => esc_attr__( 'Snippet Library for Customizing Give Donations', 'toolbar-extras-givewp' ),
					)
				)
			);

		}  // end if

	/** Action Hook: After Give Donations Resources */
	do_action( 'tbexgive/givewp_resources/after' );

	$admin_bar->add_node(
		array(
			'id'     => 'givewp-community',
			'parent' => 'group-donation-resources',
			'title'  => ddw_tbexgive_string_give_community(),
			'href'   => ddw_tbex_get_resource_url( 'givewp', 'url_fb_group' ),
			'meta'   => array(
				'rel'    => ddw_tbex_meta_rel(),
				'target' => ddw_tbex_meta_target(),
				'title'  => ddw_tbexgive_string_give_community(),
			)
		)
	);

		ddw_tbex_resource_item(
			'facebook-group',
			'givewp-community-fbgroup',
			'givewp-community',
			ddw_tbex_get_resource_url( 'givewp', 'url_fb_group' )
		);

		ddw_tbex_resource_item(
			'translations-community',
			'givewp-community-translations',
			'givewp-community',
			ddw_tbex_get_resource_url( 'givewp', 'url_translations' )
		);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-community-give-stories',
				'parent' => 'givewp-community',
				'title'  => esc_attr__( 'Give Stories', 'toolbar-extras-givewp' ),
				'href'   => ddw_tbex_get_resource_url( 'givewp', 'url_give_stories' ),
				'meta'   => array(
					'rel'    => ddw_tbex_meta_rel(),
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Give Stories', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-community-giving-tuesday',
				'parent' => 'givewp-community',
				'title'  => esc_attr__( 'Giving Tuesday', 'toolbar-extras-givewp' ),
				'href'   => ddw_tbex_get_resource_url( 'givewp', 'url_giving_tuesday' ),
				'meta'   => array(
					'rel'    => ddw_tbex_meta_rel(),
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Giving Tuesday', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-community-nonprofit-101',
				'parent' => 'givewp-community',
				'title'  => esc_attr__( 'Nonprofit 101', 'toolbar-extras-givewp' ),
				'href'   => ddw_tbex_get_resource_url( 'givewp', 'url_nonprofit_101' ),
				'meta'   => array(
					'rel'    => ddw_tbex_meta_rel(),
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Nonprofit 101', 'toolbar-extras-givewp' ),
				)
			)
		);

}  // end function
