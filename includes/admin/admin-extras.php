<?php

// includes/admin/admin-extras

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Add Add-On "Settings" links to Plugins page.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_is_toolbar_extras_active()
 * @uses ddw_tbexgive_is_givewp_active()
 *
 * @param array $action_links (Default) Array of plugin action links.
 * @return array Modified array of plugin action links.
 */
function ddw_tbexgive_custom_settings_links( $action_links = [] ) {

	/** Add settings link only if user can 'manage_options' */
	if ( current_user_can( 'manage_options' ) ) {

		/** If environment is not ready point to plugin manager */
		if ( ( ddw_tbexgive_is_toolbar_extras_active() && version_compare( TBEX_PLUGIN_VERSION, TBEXGIVE_REQUIRED_BASE_PLUGIN_VERSION, '>=' ) )
			&& ! ddw_tbexgive_is_givewp_active()
		) {

			$tbexgive_links[ 'tbexgive-settings' ] = sprintf(
				'<a href="%s" title="%s"><span class="dashicons-before dashicons-admin-plugins"></span> %s</a>',
				esc_url( admin_url( 'plugins.php?page=toolbar-extras-suggested-plugins' ) ),
				esc_html__( 'First Step: Setup Environment to use the plugin', 'toolbar-extras-givewp' ),
				esc_attr__( 'First Step: Setup Environment', 'toolbar-extras-givewp' )
			);

		}  // end if

		/** Give Donations & Settings Page links */
		if ( ddw_tbexgive_is_toolbar_extras_active() && ddw_tbexgive_is_givewp_active() ) {

			$tbexgive_links[ 'tbexgive-givewp' ] = sprintf(
				'<a href="%s" title="%s"><span class="dashicons-before dashicons-heart"></span> %s</a>',
				esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-payment-history' ) ),
				esc_html__( 'Give Donations - Transaction History', 'toolbar-extras-givewp' ),
				esc_attr__( 'Donations', 'toolbar-extras-givewp' )
			);

			$tbexgive_links[ 'tbexgive-settings' ] = sprintf(
				'<a href="%s" title="%s"><span class="dashicons-before dashicons-admin-generic"></span> %s</a>',
				esc_url( admin_url( 'options-general.php?page=toolbar-extras&tab=givewp' ) ),
				esc_html__( 'Toolbar Settings for Give Donations', 'toolbar-extras-givewp' ),
				esc_attr__( 'Toolbar Settings', 'toolbar-extras-givewp' )
			);

		}  // end if

	}  // end if

	/** Display plugin settings links */
	return apply_filters(
		'tbexgive/filter/plugins_page/settings_link',
		array_merge( $tbexgive_links, $action_links ),
		$tbexgive_links 		// additional param
	);

}  // end function


add_filter( 'plugin_row_meta', 'ddw_tbexgive_plugin_links', 10, 2 );
/**
 * Add various support links to Plugins page.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_info_link()
 *
 * @param array  $tbexgive_links (Default) Array of plugin meta links
 * @param string $tbexgive_file  Path of base plugin file
 * @return array $tbexgive_links Array of plugin link strings to build HTML markup.
 */
function ddw_tbexgive_plugin_links( $tbexgive_links, $tbexgive_file ) {

	/** Capability check */
	if ( ! current_user_can( 'install_plugins' ) ) {
		return $tbexgive_links;
	}

	/** List additional links only for this plugin */
	if ( $tbexgive_file === TBEXGIVE_PLUGIN_BASEDIR . 'toolbar-extras-givewp.php' ) {

		?>
			<style type="text/css">
				tr[data-plugin="<?php echo $tbexgive_file; ?>"] .plugin-version-author-uri a.dashicons-before:before {
					font-size: 17px;
					margin-right: 2px;
					opacity: .85;
					vertical-align: sub;
				}
			</style>
		<?php

		/* translators: Plugins page listing */
		$tbexgive_links[] = ddw_tbex_get_info_link(
			'url_wporg_forum',
			esc_html_x( 'Support', 'Plugins page listing', 'toolbar-extras-givewp' ),
			'dashicons-before dashicons-sos',
			'givewp'
		);

		/* translators: Plugins page listing */
		$tbexgive_links[] = ddw_tbex_get_info_link(
			'url_fb_group',
			esc_html_x( 'Facebook Group', 'Plugins page listing', 'toolbar-extras-givewp' ),
			'dashicons-before dashicons-facebook'
		);

		/* translators: Plugins page listing */
		$tbexgive_links[] = ddw_tbex_get_info_link(
			'url_translate',
			esc_html_x( 'Translations', 'Plugins page listing', 'toolbar-extras-givewp' ),
			'dashicons-before dashicons-translation',
			'givewp'
		);

		/* translators: Plugins page listing */
		$tbexgive_links[] = ddw_tbex_get_info_link(
			'url_donate',
			esc_html_x( 'Donate', 'Plugins page listing', 'toolbar-extras-givewp' ),
			'button dashicons-before dashicons-thumbs-up'
		);

		/* translators: Plugins page listing */
		$tbexgive_links[] = ddw_tbex_get_info_link(
			'url_newsletter',
			esc_html_x( 'Join our Newsletter', 'Plugins page listing', 'toolbar-extras-givewp' ),
			'button-primary dashicons-before dashicons-awards'
		);

	}  // end if plugin links

	/** Output the links */
	return apply_filters(
		'tbexgive/filter/plugins_page/more_links',
		$tbexgive_links
	);

}  // end function


add_filter( 'admin_footer_text', 'ddw_tbexgive_admin_footer_tweak' );
/**
 * On the "Give Donations" settings tab add footer text to invite for plugin
 *   review.
 *
 * @since 1.0.0
 *
 * @uses get_current_screen()
 *
 * @param string $footer_text The content that will be printed.
 * @return string The content that will be printed.
 */
function ddw_tbexgive_admin_footer_tweak( $footer_text ) {

	/** Current screen logic */
	$current_screen = get_current_screen();
	$is_tbex_screen = array(
		'give_forms_page_give-settings',
	);	

	/** Active settings tab logic */
	$active_tab = isset( $_GET[ 'tab' ] ) ? sanitize_key( wp_unslash( $_GET[ 'tab' ] ) ) : '';

	/** Conditionally set footer text */
	if ( in_array( $current_screen->id, $is_tbex_screen )
		|| ( 'settings_page_toolbar-extras' === $current_screen->id && 'givewp' === $active_tab )
	) {

		$rating = sprintf(
			/* translators: %s - 5 stars icons */
			'<a href="https://wordpress.org/support/plugin/toolbar-extras-givewp/reviews/?filter=5#new-post" target="_blank" rel="noopener noreferrer">' . __( '%s rating', 'toolbar-extras-givewp' ) . '</a>',
			'&#9733;&#9733;&#9733;&#9733;&#9733;'
		);

		$footer_text = sprintf(
			/* translators: 1 - Toolbar Extras for Give Donations / 2 - label "5 star rating" */
			__( 'Enjoyed %1$s? Please leave us a %2$s. We really appreciate your support!', 'toolbar-extras' ),
			'<strong>' . __( 'Toolbar Extras for Give Donations', 'toolbar-extras-givewp' ) . '</strong>',
			$rating
		);

	}  // end if

	/** Render footer text */
	return $footer_text;

}  // end function


add_filter( 'debug_information', 'ddw_tbexgive_site_health_add_debug_info', 6 );
/**
 * Add additional plugin related info to the Site Health Debug Info section.
 *   (Only relevant for WordPress 5.2 or higher)
 *
 * @link https://make.wordpress.org/core/2019/04/25/site-health-check-in-5-2/
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_debug_diagnostic()
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 * @uses ddw_tbex_string_uninstalled()
 * @uses ddw_tbexgive_is_give_test_mode()
 *
 * @param array $debug_info Array holding all Debug Info items.
 * @return array Modified array of Debug Info.
 */
function ddw_tbexgive_site_health_add_debug_info( $debug_info ) {

	/** Add our Debug info */
	$debug_info[ 'toolbar-extras-givewp' ] = array(
		'label'       => esc_html__( 'Toolbar Extras for Give Donations', 'toolbar-extras-givewp' ) . ' (' . esc_html__( 'Add-On Plugin', 'toolbar-extras-givewp' ) . ')',
		'description' => ddw_tbex_string_debug_diagnostic( 'givewp' ),
		'fields'      => array(

			/** Add-On values etc. */
			'tbexgive_plugin_version' => array(
				'label' => __( 'Add-On Plugin version', 'toolbar-extras-givewp' ),
				'value' => TBEXGIVE_PLUGIN_VERSION,
			),
			'tbexgive_required_base_plugin_version' => array(
				'label' => __( 'Required Base Plugin version', 'toolbar-extras-givewp' ),
				'value' => TBEXGIVE_REQUIRED_BASE_PLUGIN_VERSION,
			),
			'tbexgive_donations_tl_priority' => array(
				'label' => __( 'Donations item priority', 'toolbar-extras-givewp' ),
				'value' => get_option( 'tbex-options-givewp', '72' )[ 'donations_tl_priority' ],
			),
			'tbexgive_donations_tl_url' => array(
				'label' => __( 'Donations item custom URL', 'toolbar-extras-givewp' ),
				'value' => get_option( 'tbex-options-givewp', '' )[ 'donations_tl_url' ],
			),
			'tbexgive_formfeat_display' => array(
				'label' => __( 'Display Featured Form item', 'toolbar-extras-givewp' ),
				'value' => get_option( 'tbex-options-givewp', ddw_tbex_string_yes( 'return' ) )[ 'formfeat_display' ],
			),
			'tbexgive_formfeat_form_id' => array(
				'label' => __( 'Featured Form ID', 'toolbar-extras' ),
				'value' => get_option( 'tbex-options-givewp', '' )[ 'formfeat_form_id' ],
			),
			'tbexgive_formfeat_priority' => array(
				'label' => __( 'Featured Form item priority', 'toolbar-extras-givewp' ),
				'value' => get_option( 'tbex-options-givewp', '1000' )[ 'formfeat_priority' ],
			),
			'tbexgive_formfeat_url' => array(
				'label' => __( 'Featured Form custom URL', 'toolbar-extras-givewp' ),
				'value' => get_option( 'tbex-options-givewp', '' )[ 'formfeat_url' ],
			),
			'tbexgive_testmode_use_tweaks' => array(
				'label' => __( 'Use Add-On Test Mode tweaks', 'toolbar-extras-givewp' ),
				'value' => get_option( 'tbex-options-givewp', ddw_tbex_string_yes( 'return' ) )[ 'testmode_use_tweaks' ],
			),
			'tbexgive_remove_tbex_build_group' => array(
				'label' => __( 'Remove TBEX Build Group', 'toolbar-extras-givewp' ),
				'value' => get_option( 'tbex-options-givewp', ddw_tbex_string_no( 'return' ) )[ 'remove_tbex_build_group' ],
			),

			/** GiveWP specific */
			'GIVE_VERSION' => array(
				'label' => 'Give Donations: GIVE_VERSION',
				'value' => ( ! defined( 'GIVE_VERSION' ) ? ddw_tbex_string_uninstalled() : GIVE_VERSION ),
			),
			'tbexgive_is_give_test_mode_active' => array(
				'label' => __( 'Give Test Mode active', 'toolbar-extras-givewp' ),
				'value' => ( ddw_tbexgive_is_give_test_mode() ? ddw_tbex_string_yes( 'return' ) : ddw_tbex_string_no( 'return' ) ),
			),
			'tbexgive_give_cpt_permalinks_active' => array(
				'label' => __( 'Give Forms Single Permalinks active', 'toolbar-extras-givewp' ),
				'value' => get_option( 'give_settings', 'enabled' )[ 'forms_singular' ],
			),

		),  // end array
	);

	/** Return modified Debug Info array */
	return $debug_info;

}  // end function


/**
 * Inline CSS fix for Plugins page update messages.
 *
 * @since 1.0.0
 *
 * @see ddw_tbex_plugin_update_message()
 * @see ddw_tbex_multisite_subsite_plugin_update_message()
 */
function ddw_tbexgive_plugin_update_message_style_tweak() {

	?>
		<style type="text/css">
			.tbexgive-update-message p:before,
			.update-message.notice p:empty {
				display: none !important;
			}
		</style>
	<?php

}  // end function


add_action( 'in_plugin_update_message-' . TBEXGIVE_PLUGIN_BASEDIR . 'toolbar-extras-givewp.php', 'ddw_tbexgive_plugin_update_message', 10, 2 );
/**
 * On Plugins page add visible upgrade/update notice in the overview table.
 *   Note: This action fires for regular single site installs, and for Multisite
 *         installs where the plugin is activated Network-wide.
 *
 * @since 1.0.0
 *
 * @param object $data
 * @param object $response
 * @return string Echoed string and markup for the plugin's upgrade/update
 *                notice.
 */
function ddw_tbexgive_plugin_update_message( $data, $response ) {

	if ( isset( $data[ 'upgrade_notice' ] ) ) {

		ddw_tbexgive_plugin_update_message_style_tweak();

		printf(
			'<div class="update-message tbexgive-update-message">%s</div>',
			wpautop( $data[ 'upgrade_notice' ] )
		);

	}  // end if

}  // end function


add_action( 'after_plugin_row_wp-' . TBEXGIVE_PLUGIN_BASEDIR . 'toolbar-extras-givewp.php', 'ddw_tbexgive_multisite_subsite_plugin_update_message', 10, 2 );
/**
 * On Plugins page add visible upgrade/update notice in the overview table.
 *   Note: This action fires for Multisite installs where the plugin is
 *         activated on a per site basis.
 *
 * @since 1.0.0
 *
 * @param string $file
 * @param object $plugin
 * @return string Echoed string and markup for the plugin's upgrade/update
 *                notice.
 */
function ddw_tbexgive_multisite_subsite_plugin_update_message( $file, $plugin ) {

	if ( is_multisite() && version_compare( $plugin[ 'Version' ], $plugin[ 'new_version' ], '<' ) ) {

		$wp_list_table = _get_list_table( 'WP_Plugins_List_Table' );

		ddw_tbexgive_plugin_update_message_style_tweak();

		printf(
			'<tr class="plugin-update-tr"><td colspan="%s" class="plugin-update update-message notice inline notice-warning notice-alt"><div class="update-message tbexgive-update-message"><h4 style="margin: 0; font-size: 14px;">%s</h4>%s</div></td></tr>',
			$wp_list_table->get_column_count(),
			$plugin[ 'Name' ],
			wpautop( $plugin[ 'upgrade_notice' ] )
		);

	}  // end if

}  // end function


/**
 * Optionally tweaking Plugin API results to make more useful recommendations to
 *   the user.
 *
 * @since 1.0.0
 */

add_filter( 'ddwlib_plir/filter/plugins', 'ddw_tbexgive_register_extra_plugin_recommendations_givewp' );
/**
 * Register specific plugins for the class "DDWlib Plugin Installer
 *   Recommendations".
 *   Note: The top-level array keys are plugin slugs from the WordPress.org
 *         Plugin Directory.
 *
 * @since 1.0.0
 *
 * @param array $plugins Array holding all plugin recommendations, coming from
 *                       the class and the filter.
 * @return array Filtered and merged array of all plugin recommendations.
 */
function ddw_tbexgive_register_extra_plugin_recommendations_givewp( array $plugins ) {

	/** Remove our own slug when we are already active :) */
	if ( isset( $plugins[ 'toolbar-extras-givewp' ] ) ) {
		$plugins[ 'toolbar-extras-givewp' ] = null;
	}

	/** Add new keys to recommendations */
	$plugins[ 'give' ] = array(
		'featured'    => 'yes',
		'recommended' => 'yes',
		'popular'     => 'yes',
	);

	/** Return tweaked array of plugins */
	return $plugins;

}  // end function
