<?php

// includes/givewp-official/items-givewp-pages

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_items_givewp_pages', 98 );
/**
 * Give Donations items for special Donation Pages (Shortcode Pages).
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_is_givewp_recurring_donations_active()
 * @uses ddw_tbexgive_display_shortcode_pages()
 * @uses ddw_tbexgive_get_pages_with_shortcode()
 * @uses ddw_tbex_meta_target()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_items_givewp_pages( $admin_bar ) {

	$give_settings = get_option( 'give_settings' );

	$give_pages = array(
		'success_page',
		'failure_page',
		'history_page',
		'subscriptions_page',
	);

	$admin_bar->add_node(
		array(
			'id'     => 'givewp-pages',
			'parent' => 'group-donation-options',
			'title'  => esc_attr__( 'Donation Pages', 'toolbar-extras-givewp' ),
			'href'   => current_user_can( 'manage_give_settings' ) ? esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=general&section=general-settings' ) ) : esc_url( admin_url( 'edit.php?post_type=page' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => esc_attr__( 'Edit and Preview Give Donation Pages', 'toolbar-extras-givewp' ),
			)
		)
	);

		foreach ( $give_pages as $give_page ) {

			$give_page_id    = absint( $give_settings[ $give_page ] );
			$give_page_title = esc_attr( get_the_title( $give_page_id ) );

			if ( ! ddw_tbexgive_is_givewp_recurring_donations_active() && 'subscriptions_page' === $give_page ) {
				continue;
			}

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-pages-' . $give_page,
					'parent' => 'givewp-pages',
					'title'  => $give_page_title,
					'href'   => esc_url( admin_url( 'post.php?post=' . $give_page_id . '&action=edit' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Edit and Preview Page', 'toolbar-extras-givewp' ) . ': ' . $give_page_title,
					)
				)
			);

				$admin_bar->add_node(
					array(
						'id'     => 'givewp-pages-' . $give_page . '-preview',
						'parent' => 'givewp-pages-' . $give_page,
						'title'  => esc_attr__( 'Live Preview', 'toolbar-extras-givewp' ),
						'href'   => esc_url( get_permalink( $give_page_id ) ),
						'meta'   => array(
							'target' => ddw_tbex_meta_target(),
							'title'  => esc_attr__( 'Live Preview Page', 'toolbar-extras-givewp' ) . ': ' . $give_page_title,
						)
					)
				);

				$admin_bar->add_node(
					array(
						'id'     => 'givewp-pages-' . $give_page . '-edit',
						'parent' => 'givewp-pages-' . $give_page,
						'title'  => esc_attr__( 'Edit Page', 'toolbar-extras-givewp' ),
						'href'   => esc_url( admin_url( 'post.php?post=' . $give_page_id . '&action=edit' ) ),
						'meta'   => array(
							'target' => ddw_tbex_meta_target(),
							'title'  => esc_attr__( 'Edit Page', 'toolbar-extras-givewp' ) . ': ' . $give_page_title,
						)
					)
				);

		}  // end foreach

		/** List special GiveWP Shortcode pages if enabled in settings */
		if ( ddw_tbexgive_display_shortcode_pages() ) {

			/**
			 * GiveWP special Shortcodes
			 * @link https://givewp.com/documentation/core/shortcodes/
			 */
			$give_shortcodes = array(
				'give_donor_wall',
				'give_login',
				'give_register',
				'give_profile_editor',
			);

			$give_shortcodes_addition = array( 'give_form_grid' );

			if ( 'enabled' === $give_settings[ 'forms_archives' ] ) {
				$give_shortcodes = array_merge( $give_shortcodes_addition, $give_shortcodes );
			}

			/** Loop through all given GiveWP Shortcodes of our array */
			foreach ( $give_shortcodes as $give_shortcode ) {

				/**
				 * Only proceed (aka add any items) if our helper function returns
				 *   not null, that means there are pages existing with at least one
				 *   of these special Shortcodes.
				 */
				if ( ! is_null( ddw_tbexgive_get_pages_with_shortcode( $give_shortcode ) ) ) {

					$admin_bar->add_group(
						array(
							'id'     => 'group-givewp-shortcode-pages',
							'parent' => 'givewp-pages',
						)
					);

						$admin_bar->add_node(
							array(
								'id'     => 'givewp-shortcode-pages-heading',
								'parent' => 'group-givewp-shortcode-pages',
								'title'  => '<em>' . esc_attr__( 'Special Shortcode Pages', 'toolbar-extras-givewp' ) . ':</em>',
								'href'   => ddw_tbex_get_info_url( 'url_give_shortcodes', 'givewp' ),
								'meta'   => array(
									'target' => ddw_tbex_meta_target(),
									'title'  => esc_attr__( 'List of Pages with Special GiveWP Shortcodes', 'toolbar-extras-givewp' ),
								)
							)
						);

					foreach ( ddw_tbexgive_get_pages_with_shortcode( $give_shortcode ) as $give_shorcode_page ) {

						$give_shortcode_page_id    = absint( $give_shorcode_page->ID );
						$give_shortcode_page_title = esc_attr( $give_shorcode_page->post_title );

						$admin_bar->add_node(
							array(
								'id'     => 'givewp-shortcode-pages-' . $give_shortcode,
								'parent' => 'group-givewp-shortcode-pages',
								'title'  => '&nbsp;&bull; ' . $give_shortcode_page_title,
								'href'   => esc_url( admin_url( 'post.php?post=' . $give_shortcode_page_id . '&action=edit' ) ),
								'meta'   => array(
									'target' => '',
									'title'  => esc_attr__( 'Edit and Preview Page', 'toolbar-extras-givewp' ) . ': ' . $give_shortcode_page_title,
								)
							)
						);

							$admin_bar->add_node(
								array(
									'id'     => 'givewp-shortcode-pages-' . $give_shortcode . '-preview',
									'parent' => 'givewp-shortcode-pages-' . $give_shortcode,
									'title'  => esc_attr__( 'Live Preview', 'toolbar-extras-givewp' ),
									'href'   => esc_url( get_permalink( $give_shortcode_page_id ) ),
									'meta'   => array(
										'target' => ddw_tbex_meta_target(),
										'title'  => esc_attr__( 'Live Preview Page', 'toolbar-extras-givewp' ) . ': ' . $give_shortcode_page_title,
									)
								)
							);

							$admin_bar->add_node(
								array(
									'id'     => 'givewp-shortcode-pages-' . $give_shortcode . '-edit',
									'parent' => 'givewp-shortcode-pages-' . $give_shortcode,
									'title'  => esc_attr__( 'Edit Page', 'toolbar-extras-givewp' ),
									'href'   => esc_url( admin_url( 'post.php?post=' . $give_shortcode_page_id . '&action=edit' ) ),
									'meta'   => array(
										'target' => ddw_tbex_meta_target(),
										'title'  => esc_attr__( 'Edit Page', 'toolbar-extras-givewp' ) . ': ' . $give_shortcode_page_title,
									)
								)
							);

					}  // end foreach (list pages/items)

				}  // end if (pages with Shortcode check)

			}  // end foreach (loop Shortcodes)

		}  // end if (settings check)

}  // end function
