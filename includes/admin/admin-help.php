<?php

// includes/admin/admin-help

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


//add_action( 'admin_enqueue_scripts', 'ddw_tbexgive_register_styles_help_tabs', 20 );
/**
 * Register CSS styles for our help tabs.
 *
 * @since 1.0.0
 */
function ddw_tbexgive_register_styles_help_tabs() {

	wp_register_style(
		'tbexgive-help-tabs',
		plugins_url( '/assets/css/tbexgive-help.css', dirname( dirname( __FILE__ ) ) ),
		array(),
		TBEXGIVE_PLUGIN_VERSION,
		'screen'
	);

	wp_enqueue_style( 'tbexgive-help-tabs' );

}  // end function


add_action( 'load-edit.php', 'ddw_tbexgive_prepare_help_tab', 100 );
add_action( 'load-post.php', 'ddw_tbexgive_prepare_help_tab', 100 );
/**
 * Add the plugin's help tab also on GiveWP Form edit screens.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_help_tab()
 */
function ddw_tbexgive_prepare_help_tab() {

	$screen = get_current_screen();

    $screen_ids = array( 'edit-give_forms', 'give_forms' );

    if ( in_array( $screen->id, $screen_ids ) ) {
        ddw_tbexgive_help_tab();
    }

}  // end function


add_action( 'load-settings_page_toolbar-extras', 'ddw_tbexgive_help_tab', 15 );			// Toolbar Extras settings
add_action( 'load-give_forms_page_give-settings', 'ddw_tbexgive_help_tab', 100 );		// GiveWP Settings
add_action( 'load-give_forms_page_give-tools', 'ddw_tbexgive_help_tab', 100 );			// GiveWP Tools
add_action( 'load-plugins_page_toolbar-extras-suggested-plugins', 'ddw_tbexgive_help_tab', 100 );
/**
 * Build the help tab for this add-on plugin.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_content_help_sidebar()
 *
 * @global object $GLOBALS[ 'tbexgive_screen' ]
 */
function ddw_tbexgive_help_tab() {

	$GLOBALS[ 'tbexgive_screen' ] = get_current_screen();

	/** Check for proper admin screen & permissions */
	if ( ! $GLOBALS[ 'tbexgive_screen' ]
		|| ! is_super_admin()
	) {
		return;
	}

	/** Add the new help tab */
	$GLOBALS[ 'tbexgive_screen' ]->add_help_tab(
		array(
			'id'       => 'tbexgive-addon-help',
			'title'    => esc_html__( 'Add-On: GiveWP', 'toolbar-extras-givewp' ),
			'callback' => apply_filters(
				'tbexgive/filter/content/help_tab',
				'ddw_tbexgive_help_tab_content'
			),
		)
	);

	/** Load the actual help content view */
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/admin/views/help-content-addon.php';

	$screens_for_sidebar = array(
		'toplevel_page_ct_dashboard_page',
		'edit-ct_template',
		'givewp_page_givewp_vsb_settings',
		'plugins_page_toolbar-extras-suggested-plugins'
	);

	/** Add help sidebar from TBEX */
	if ( 'plugins_page_toolbar-extras-suggested-plugins' === $GLOBALS[ 'tbexgive_screen' ]->id
		|| in_array( $GLOBALS[ 'tbexgive_screen' ]->id, $screens_for_sidebar )
	) {

		require_once TBEX_PLUGIN_DIR . 'includes/admin/views/help-content-sidebar.php';

		$GLOBALS[ 'tbexgive_screen' ]->set_help_sidebar( ddw_tbex_content_help_sidebar() );

	}  // end if

	/** CSS style tweaks */
	add_action( 'admin_enqueue_scripts', 'ddw_tbexgive_register_styles_help_tabs', 20 );

}  // end function
