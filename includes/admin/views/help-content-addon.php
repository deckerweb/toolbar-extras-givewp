<?php

// includes/admin/views/help-content-addon

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * View: Content of the help tab.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_string_backtowp()
 * @uses ddw_tbex_info_values()
 * @uses ddw_tbex_get_info_link()
 * @uses ddw_tbex_meta_target()
 * @uses ddw_tbex_meta_rel()
 */
function ddw_tbexgive_help_tab_content() {

	$tbex_info = (array) ddw_tbex_info_values();

	$tbexgive_space_helper = '<div style="height: 10px;"></div>';

	/** Content: Toolbar Extras for GiveWP addon plugin */
	echo '<h3>' . __( 'Add-On', 'toolbar-extras-givewp' ) . ': ' . __( 'Toolbar Extras for Give Donations', 'toolbar-extras-givewp' ) . ' <small class="tbexgive-help-version">v' . TBEXGIVE_PLUGIN_VERSION . '</small></h3>';


	/** GiveWP Name */
	echo '<h5>' . __( 'Setting Give Name', 'toolbar-extras-givewp' ) . '</h5>';
	echo '<p class="tbex-help-info">' . __( 'This affects the Give name in various instances of the Toolbar and the Admin area.', 'toolbar-extras-givewp' ) . '</p>';


	/** Tooltips */
	$links_url = sprintf(
		'<a href="%1$s" target="%3$s" rel="%4$s">%2$s</a>',
		esc_url( admin_url( 'options-general.php?page=toolbar-extras&tab=general#tbex-settings-link-behavior' ) ),
		__( 'Settings > Toolbar Extras > Tab: General > Section: Links Behavior', 'toolbar-extras-givewp' ),
		ddw_tbex_meta_target(),
		ddw_tbex_meta_rel()
	);

	echo '<h5>' . __( 'How can I disable the link attributes (tooltips)?', 'toolbar-extras-givewp' ) . '</h5>';
	echo sprintf(
		'<p class="tbex-help-info"><strong>%1$s:</strong> <code style="font-size: 90%;">%2$s</code></p>',
		__( 'Go to', 'toolbar-extras-givewp' ),
		$links_url
	);


	/** Support notice */
	echo '<h5>' . __( 'Add-On Support Info', 'toolbar-extras-givewp' ) . '</h5>';
	echo sprintf(
		/* translators: 1 - plugin name, "Toolbar Extras for Give Donations" / 2 - company name, "GiveWP/ Impress.org, LLC" / 3 - product name, "Give Donations (GiveWP)" */
		'<p class="tbex-help-info description">' . __( 'Please note, the %1$s Add-On plugin is not officially endorsed by %2$s. It is an independently developed solution by the community for the community. Therefore our support is connected to the Add-On itself, to the Toolbar and the things around it, not the inner meanings of %3$s.', 'toolbar-extras-givewp' ) . '</p>',
		'<span class="noitalic">' . __( 'Toolbar Extras for Give Donations', 'toolbar-extras-givewp' ) . '</span>',
		'<span class="noitalic">' . __( 'GiveWP/ Impress.org, LLC', 'toolbar-extras-givewp' ) . '</span>',
		'<span class="noitalic">' . __( 'Give Donations (GiveWP)', 'toolbar-extras-givewp' ) . '</span>'
	);


	/** Further help content */
	echo $tbexgive_space_helper . '<p><h4 style="font-size: 1.1em;">' . __( 'Important plugin links:', 'toolbar-extras-givewp' ) . '</h4>' .

		ddw_tbex_get_info_link( 'url_plugin', esc_html__( 'Plugin website', 'toolbar-extras-givewp' ), 'button', 'givewp' ) .

		'&nbsp;&nbsp;' . ddw_tbex_get_info_link( 'url_plugin_faq', esc_html_x( 'FAQ', 'Help tab info', 'toolbar-extras-givewp' ), 'button', 'givewp' ) .

		'&nbsp;&nbsp;' . ddw_tbex_get_info_link( 'url_wporg_forum', esc_html_x( 'Support', 'Help tab info', 'toolbar-extras-givewp' ), 'button', 'givewp' ) .

		'&nbsp;&nbsp;' . ddw_tbex_get_info_link( 'url_fb_group', esc_html_x( 'Facebook Group', 'Help tab info', 'toolbar-extras-givewp' ), 'button' ) .

		'&nbsp;&nbsp;' . ddw_tbex_get_info_link( 'url_translate', esc_html_x( 'Translations', 'Help tab info', 'toolbar-extras-givewp' ), 'button', 'givewp' ) .

		'&nbsp;&nbsp;' . ddw_tbex_get_info_link( 'url_donate', esc_html_x( 'Donate', 'Help tab info', 'toolbar-extras-givewp' ), 'button tbex' ) .

		'&nbsp;&nbsp;' . ddw_tbex_get_info_link( 'url_newsletter', esc_html_x( 'Join our Newsletter', 'Help tab info', 'toolbar-extras-givewp' ), 'button button-primary tbex' ) .

		sprintf(
			'<p><a href="%1$s" target="_blank" rel="nofollow noopener noreferrer" title="%2$s">%2$s</a> &#x000A9; %3$s <a href="%4$s" target="_blank" rel="noopener noreferrer" title="%5$s">%5$s</a></p>',
			ddw_tbex_get_info_url( 'url_license' ),
			esc_attr( $tbex_info[ 'license' ] ),
			ddw_tbex_coding_years( '', 'givewp' ),
			esc_url( $tbex_info[ 'author_uri' ] ),
			esc_html( $tbex_info[ 'author' ] )
		);

}  // end function
