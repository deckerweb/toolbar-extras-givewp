<?php

// includes/admin/tbexgive-settings

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Default values of the plugin's GiveWP Add-On options.
 *   Note: Option key for the settings array is 'tbex-options-givewp' - this is
 *         needed to be compatible with the function ddw_tbex_get_option() in
 *         Toolbar Extras (base plugin).
 *
 * @since 1.0.0
 *
 * @return array strings Parsed args of default options.
 */
function ddw_tbexgive_default_options_givewp() {

	/** Set the default values - make them filterable */
	$tbexgive_default_options = apply_filters(
		'tbexgive/filter/options/default_givewp',
		array(

			/** "Donations" top-level item */
			'donations_tl_name'       => esc_attr_x( 'Donations', 'Toolbar item label', 'toolbar-extras-givewp' ),	// "Donations"
			'donations_tl_use_icon'   => 'givewp',			// use GiveWP icon by default
			'donations_tl_icon'       => 'dashicons-heart',
			'donations_tl_priority'   => 72,
			'donations_tl_url'        => '',
			'donations_tl_target'     => '_self',

			/** GiveWP "Give" name/ label */
			'givewp_name'             => esc_attr_x( 'Give', 'Toolbar item label', 'toolbar-extras-givewp' ),		// "Give"

			/** Featured Give Form/ Campaign item */
			'formfeat_display'        => 'no',
			'formfeat_form_id'        => '',
			'formfeat_title'          => 'form_title',		// defaults to the title of the form
			'formfeat_name'           => '',
			'formfeat_income'         => 'yes',
			'formfeat_use_icon'       => 'givewp',			// use GiveWP icon by default
			'formfeat_icon'           => 'dashicons-star-filled',
			'formfeat_priority'       => '1000',
			'formfeat_bgcolor'        => '',
			'formfeat_use_url'        => 'form_default',
			'formfeat_url'			  => '',
			'formfeat_target'         => '_self',

			/** Give Test Mode item */
			'testmode_use_tweaks'     => 'yes',
			'testmode_name'           => esc_attr_x( 'Give Test Mode Active', 'Toolbar item label', 'toolbar-extras-givewp' ),		// "Give Test Mode Active"
			'testmode_use_icon'       => 'none',
			'testmode_icon'           => 'dashicons-info',

			/** Various tweaks */
			'note_for_coloring'       => '',				// Only for user note/guidance, just a "virtual setting"
			'remove_tbex_build_group' => 'no',
			'unload_td_givewp'        => 'no',
			'unload_td_tbexgive'      => 'no',

		)  // end of array
	);

	/** Parse settings default attributes */
	$tbexgive_defaults = wp_parse_args(
		get_option( 'tbex-options-givewp' ),
		$tbexgive_default_options
	);

	/** Return the GiveWP settings defaults */
	return $tbexgive_defaults;

}  // end function


add_action( 'admin_init', 'ddw_tbexgive_register_settings_givewp', 10 );
/**
 * Load plugin's settings for settings tab "GiveWP".
 *   Note: Option key for the settings array is 'tbex-options-givewp' - this is
 *         needed to be compatible with the function ddw_tbex_get_option() in
 *         Toolbar Extras (base plugin).
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_default_options_givewp()
 * @uses ddw_tbexgive_is_give_test_mode()
 */
function ddw_tbexgive_register_settings_givewp() {

	/** If options do not exist (on first run), update them with default values */
	if ( ! get_option( 'tbex-options-givewp' ) ) {
		update_option( 'tbex-options-givewp', ddw_tbexgive_default_options_givewp() );
	}

	/** Prepare conditional settings */
	$plugin_inactive = ' plugin-inactive';
	//$status_testmode = ddw_tbexgive_is_give_test_mode() ? ' plugin-give-test-mode' : $plugin_inactive;
	$status_testmode = ! ddw_tbexgive_is_give_test_mode() ? ' tbex-remove-settings-field' : '';

	$formfeat_status = ddw_tbex_get_option( 'givewp', 'formfeat_display' );

	/** Status for special sub settings */
	$status_special_subsettings = ( 'no' === $formfeat_status ) ? $plugin_inactive : '';

	/** Settings args */
	$tbexgive_settings_args = array( 'sanitize_callback' => 'ddw_tbexgive_validate_settings_givewp' );

	/** Register options group for GiveWP Add-On tab */
	register_setting(
		'tbexgive_group_givewp',
		'tbex-options-givewp',
		$tbexgive_settings_args
	);

		/** GiveWP: 1st section (for Donations top-level item) */
		add_settings_section(
			'tbexgive-section-donations',
			'<h3 class="tbex-settings-section first">' . __( 'For Donations Top-Level Item', 'toolbar-extras-givewp' ) . '</h3>',
			'ddw_tbexgive_settings_section_info_donations',
			'tbexgive_group_givewp'
		);

			add_settings_field(
				'donations_tl_name',
				__( 'Name of Donations Top-Level Item', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_donations_tl_name',
				'tbexgive_group_givewp',
				'tbexgive-section-donations',
				array( 'class' => 'tbexgive-setting-donations-tl-name' )
			);

			add_settings_field(
				'donations_tl_use_icon',
				__( 'Which icon to use for the Donations item?', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_donations_tl_use_icon',
				'tbexgive_group_givewp',
				'tbexgive-section-donations',
				array( 'class' => 'tbexgive-setting-donations-tl-use-icon' )
			);

			add_settings_field(
				'donations_tl_icon',
				__( 'Pick a Dashicon Icon for the Donations item', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_donations_tl_icon',
				'tbexgive_group_givewp',
				'tbexgive-section-donations',
				array( 'class' => 'tbexgive-setting-donations-tl-icon' )
			);

			add_settings_field(
				'donations_tl_priority',
				__( 'Priority of Donations item', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_donations_tl_priority',
				'tbexgive_group_givewp',
				'tbexgive-section-donations',
				array( 'class' => 'tbexgive-setting-donations-tl-priority' )
			);

			add_settings_field(
				'donations_tl_url',
				__( 'Use custom URL for Donations Item?', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_donations_tl_url',
				'tbexgive_group_givewp',
				'tbexgive-section-donations',
				array( 'class' => 'tbexgive-setting-donations-tl-url' )
			);

			add_settings_field(
				'donations_tl_target',
				__( 'Set link target?', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_donations_tl_target',
				'tbexgive_group_givewp',
				'tbexgive-section-donations',
				array( 'class' => 'tbexgive-setting-donations-tl-target' )
			);


		/** GiveWP: 2nd section (Give name) */
		add_settings_section(
			'tbexgive-section-givewp',
			'<h3 class="tbex-settings-section">' . __( 'For GiveWP', 'toolbar-extras-givewp' ) . '</h3>',
			'ddw_tbexgive_settings_section_info_givewp',
			'tbexgive_group_givewp'
		);

			add_settings_field(
				'givewp_name',
				__( 'Name of GiveWP', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_givewp_name',
				'tbexgive_group_givewp',
				'tbexgive-section-givewp',
				array( 'class' => 'tbexgive-setting-givewp-name' )
			);


		/** GiveWP: 3rd section (featured Form) */
		add_settings_section(
			'tbexgive-section-featured-form',
			'<h3 class="tbex-settings-section">' . __( 'Featured Form Campaign', 'toolbar-extras-givewp' ) . '</h3>',
			'ddw_tbexgive_settings_section_info_featured_form',
			'tbexgive_group_givewp'
		);

			add_settings_field(
				'formfeat_display',
				__( 'Display featured form campaign?', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_formfeat_display',
				'tbexgive_group_givewp',
				'tbexgive-section-featured-form',
				array( 'class' => 'tbexgive-setting-formfeat-display' )
			);

			add_settings_field(
				'formfeat_form_id',
				__( 'Select a featured form', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_formfeat_form_id',
				'tbexgive_group_givewp',
				'tbexgive-section-featured-form',
				array( 'class' => 'tbexgive-formfeat-group tbexgive-setting-formfeat-form-id' )
			);

			add_settings_field(
				'formfeat_title',
				__( 'Which title to use?', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_formfeat_title',
				'tbexgive_group_givewp',
				'tbexgive-section-featured-form',
				array( 'class' => 'tbexgive-formfeat-group tbexgive-setting-formfeat-title' )
			);

			add_settings_field(
				'formfeat_name',
				__( 'Set a custom title for top-level item', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_formfeat_name',
				'tbexgive_group_givewp',
				'tbexgive-section-featured-form',
				array( 'class' => 'tbexgive-setting-formfeat-name tbex-setting-conditional' . $status_special_subsettings )
			);

			add_settings_field(
				'formfeat_income',
				__( 'Display income (earnings) after Form title?', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_formfeat_income',
				'tbexgive_group_givewp',
				'tbexgive-section-featured-form',
				array( 'class' => 'tbexgive-formfeat-group tbexgive-setting-formfeat-income' )
			);

			add_settings_field(
				'formfeat_use_icon',
				__( 'Which icon to use for the featured form item?', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_formfeat_use_icon',
				'tbexgive_group_givewp',
				'tbexgive-section-featured-form',
				array( 'class' => 'tbexgive-formfeat-group tbexgive-setting-formfeat-use-icon' )
			);

			add_settings_field(
				'formfeat_icon',
				__( 'Pick a Dashicon Icon for the featured form item', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_formfeat_icon',
				'tbexgive_group_givewp',
				'tbexgive-section-featured-form',
				array( 'class' => 'tbexgive-setting-formfeat-icon tbex-setting-conditional' . $status_special_subsettings )
			);

			add_settings_field(
				'formfeat_priority',
				__( 'Priority of featured form item', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_formfeat_priority',
				'tbexgive_group_givewp',
				'tbexgive-section-featured-form',
				array( 'class' => 'tbexgive-formfeat-group tbexgive-setting-formfeat-priority' )
			);

			add_settings_field(
				'formfeat_bgcolor',
				__( 'Set custom background color for featured form item', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_formfeat_bgcolor',
				'tbexgive_group_givewp',
				'tbexgive-section-featured-form',
				array( 'class' => 'tbexgive-formfeat-group tbexgive-setting-formfeat-bgcolor' )
			);

			add_settings_field(
				'formfeat_use_url',
				__( 'Which URL to use for featured form item', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_formfeat_use_url',
				'tbexgive_group_givewp',
				'tbexgive-section-featured-form',
				array( 'class' => 'tbexgive-formfeat-group tbexgive-setting-formfeat-use-url' )
			);

			add_settings_field(
				'formfeat_url',
				__( 'Set a custom URL for featured form item', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_formfeat_url',
				'tbexgive_group_givewp',
				'tbexgive-section-featured-form',
				array( 'class' => 'tbexgive-setting-formfeat-url tbex-setting-conditional' . $status_special_subsettings )
			);

			add_settings_field(
				'formfeat_target',
				__( 'Set link target?', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_formfeat_target',
				'tbexgive_group_givewp',
				'tbexgive-section-featured-form',
				array( 'class' => 'tbexgive-setting-formfeat-target tbex-setting-conditional' . $status_special_subsettings )
			);


		/** GiveWP: 4th section (Give Test Mode) */
		$heading_testmode = sprintf(
			'<h3 class="tbex-settings-section%s">%s</h3>',
			! ddw_tbexgive_is_give_test_mode() ? ' tbex-remove-settings-section-title' : '',
			__( 'Give Test Mode', 'toolbar-extras-givewp' )
		);

		add_settings_section(
			'tbexgive-section-testmode',
			$heading_testmode,
			'ddw_tbexgive_settings_section_info_testmode',
			'tbexgive_group_givewp',
			array( 'class' => ! ddw_tbexgive_is_give_test_mode() ? 'tbex-remove-settings-section-title' : '' )
		);

			add_settings_field(
				'testmode_use_tweaks',
				__( 'Use tweaks for Test Mode?', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_testmode_use_tweaks',
				'tbexgive_group_givewp',
				'tbexgive-section-testmode',
				array( 'class' => 'tbexgive-setting-testmode-use-tweaks' . $status_testmode )
			);

			add_settings_field(
				'testmode_name',
				__( 'Set a custom title for top-level item', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_testmode_name',
				'tbexgive_group_givewp',
				'tbexgive-section-testmode',
				array( 'class' => 'tbexgive-testmode-group tbexgive-setting-testmode-name' . $status_testmode )
			);

			add_settings_field(
				'testmode_use_icon',
				__( 'Which icon to use for the Test Mode item?', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_testmode_use_icon',
				'tbexgive_group_givewp',
				'tbexgive-section-testmode',
				array( 'class' => 'tbexgive-testmode-group tbexgive-setting-testmode-use-icon' . $status_testmode )
			);

			add_settings_field(
				'testmode_icon',
				__( 'Pick a Dashicon Icon for the Test Mode item', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_testmode_icon',
				'tbexgive_group_givewp',
				'tbexgive-section-testmode',
				array( 'class' => 'tbexgive-setting-testmode-icon tbex-setting-conditional' . $status_special_subsettings . $status_testmode )
			);


		/** GiveWP: 5th section (various tweaks) */
		add_settings_section(
			'tbexgive-section-tweaks',
			'<h3 class="tbex-settings-section">' . __( 'Various Tweaks', 'toolbar-extras-givewp' ) . '</h3>',
			'ddw_tbexgive_settings_section_info_givewp_tweaks',
			'tbexgive_group_givewp'
		);

			add_settings_field(
				'note_for_coloring',
				__( 'Set background color, icon and special text for Toolbar', 'toolbar-extras-givewp' ),
				'ddw_tbex_addon_settings_cb_note_for_coloring',		// via base plugin!
				'tbexgive_group_givewp',
				'tbexgive-section-tweaks',
				array( 'class' => 'tbexgive-setting-note-for-coloring' )
			);

			add_settings_field(
				'remove_tbex_build_group',
				/* translators: %s - label, "Build" (for "Build Group") */
				sprintf( __( 'Remove %s Group from Toolbar Extras?', 'toolbar-extras-givewp' ), '<em>' . __( 'Build', 'toolbar-extras-givewp' ) . '</em>' ),
				'ddw_tbexgive_settings_cb_remove_tbex_build_group',
				'tbexgive_group_givewp',
				'tbexgive-section-tweaks',
				array( 'class' => 'tbexgive-setting-remove-tbex-build-group' )
			);

			add_settings_field(
				'unload_td_givewp',
				__( 'Unload all GiveWP Translations?', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_unload_td_givewp',
				'tbexgive_group_givewp',
				'tbexgive-section-tweaks',
				array( 'class' => 'tbexgive-setting-unload-td-givewp' )
			);

			add_settings_field(
				'unload_td_tbexgive',
				__( 'Unload Toolbar Extras for GiveWP Add-On Translations?', 'toolbar-extras-givewp' ),
				'ddw_tbexgive_settings_cb_unload_td_tbexgive',
				'tbexgive_group_givewp',
				'tbexgive-section-tweaks',
				array( 'class' => 'tbexgive-setting-unload-td-tbexgive' )
			);

}  // end function


/**
 * Validate GiveWP settings callback.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_default_options_general()
 *
 * @param mixed $input User entered value of settings field key.
 * @return string(s) Sanitized user inputs ("parsed").
 */
function ddw_tbexgive_validate_settings_givewp( $input ) {

	$tbexgive_default_options = ddw_tbexgive_default_options_givewp();

	$parsed = wp_parse_args( $input, $tbexgive_default_options );

	/** Save empty text fields with default options */
	$textfields = array(
		'donations_tl_name',
		'givewp_name',
		'formfeat_name',
		'testmode_name',
	);

	foreach( $textfields as $textfield ) {
		$parsed[ $textfield ] = wp_filter_nohtml_kses( $input[ $textfield ] );
	}

	/** Save URL fields */
	$url_fields = array(
		'donations_tl_url',
		'formfeat_url',
	);

	foreach( $url_fields as $url ) {
		$parsed[ $url ] = esc_url( $input[ $url ] );
	}

	/** Save CSS classes sanitized */
	$cssclasses_fields = array(
		'donations_tl_icon',
		'formfeat_icon',
		'testmode_icon',
	);

	foreach( $cssclasses_fields as $cssclass ) {
		$parsed[ $cssclass ] = strtolower( sanitize_html_class( $input[ $cssclass ] ) );
	}

	/** Save integer fields */
	$integer_fields = array(
		'donations_tl_priority',
		'formfeat_form_id',
		'formfeat_priority',
	);

	foreach ( $integer_fields as $integer ) {
		$parsed[ $integer ] = intval( $input[ $integer ] );
	}

	/** Save HEX color fields */
	$hexcolor_fields = array(
		'formfeat_bgcolor',
	);

	foreach ( $hexcolor_fields as $hexcolor ) {
		$parsed[ $hexcolor ] = sanitize_hex_color( $input[ $hexcolor ] );
	}

	/** Save select & key fields */
	$select_fields = array(
		'donations_tl_use_icon',
		'donations_tl_target',
		'formfeat_display',
		'formfeat_title',
		'formfeat_income',
		'formfeat_use_icon',
		'formfeat_target',
		'testmode_use_tweaks',
		'testmode_use_icon',
		'note_for_coloring',
		'remove_tbex_build_group',
		'unload_td_givewp',
		'unload_td_tbexgive',
	);

	foreach( $select_fields as $select ) {
		$parsed[ $select ] = sanitize_key( $input[ $select ] );
	}

	/** Return the sanitized user input value(s) */
	return $parsed;

}  // end function


add_filter( 'tbex_filter_settings_toggles', 'ddw_tbexgive_pass_toggable_settings_givewp' );
/**
 * Via TBEX Core 'tbex_filter_settings_toggles' filter telling the TBEX admin JS
 *   which from our settings are toggable (to reveal more sub settings).
 *
 * @since 1.0.0
 *
 * @param array $toggles Array that holds all current registered toggles.
 * @return array Modified array of toggles.
 */
function ddw_tbexgive_pass_toggable_settings_givewp( array $toggles ) {

	/** Merge our settings IDs with the TBEX core array */
	$toggles = array_merge(
		(array) $toggles,
		array(
			/** Donations Toolbar item */
			'donations_icon_ds' => array( '#tbex-options-givewp-donations_tl_use_icon', '.tbexgive-setting-donations-tl-icon', 'dashicon' ),

			/** Featured Form item */
			'formfeat_group'    => array( '#tbex-options-givewp-formfeat_display', '.tbexgive-formfeat-group', 'yes' ),
			'formfeat_label'    => array( '#tbex-options-givewp-formfeat_title', '.tbexgive-setting-formfeat-name', 'custom_title' ),
			'formfeat_icon_ds'  => array( '#tbex-options-givewp-formfeat_use_icon', '.tbexgive-setting-formfeat-icon', 'dashicon' ),
			'formfeat_url'      => array( '#tbex-options-givewp-formfeat_use_url', '.tbexgive-setting-formfeat-url', 'custom_url' ),
			'formfeat_target'   => array( '#tbex-options-givewp-formfeat_use_url', '.tbexgive-setting-formfeat-target', 'custom_url' ),

			/** Give Test Mode item */
			'testmode_group'    => array( '#tbex-options-givewp-testmode_use_tweaks', '.tbexgive-testmode-group', 'yes' ),
			'testmode_icon_ds'  => array( '#tbex-options-givewp-testmode_use_icon', '.tbexgive-setting-testmode-icon', 'dashicon' ),
		)
	);

	/** Return the merged array */
	return $toggles;

}  // end function


add_action( 'tbex_settings_tab_addons', 'ddw_tbexgive_settings_tab_title_givewp', 10, 1 );
/**
 * Build markup and logic for the "GiveWP" settings tab title.
 *
 * @since 1.0.0
 *
 * @param string $active_tab ID string of current active settings tab.
 * @return string Echoing HTML/ CSS markup, plus strings of settings tab title.
 */
function ddw_tbexgive_settings_tab_title_givewp( $active_tab ) {

	$url_givewp = esc_url(
		add_query_arg(
			array(
				'page' => 'toolbar-extras',
				'tab'  => 'givewp'
			),
			admin_url( 'options-general.php' )
		)
	);

	?>
		<a href="<?php echo $url_givewp; ?>" class="dashicons-before dashicons-heart nav-tab <?php echo ( 'givewp' === $active_tab ) ? 'nav-tab-active' : ''; ?>">
			<?php
				/* translators: Settings tab title in WP-Admin */
				_ex( 'GiveWP', 'Plugin settings tab title', 'toolbar-extras-givewp' );
			?>
		</a>
	<?php

}  // end function


add_action( 'tbex_settings_tab_addon_givewp', 'ddw_tbexgive_render_settings_tab_givewp' );
/**
 * Render the "GiveWP" settings tab on the Toolbar Extras settings page.
 *   This will setup all settings sections, settings fields, save button.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_save_changes()
 */
function ddw_tbexgive_render_settings_tab_givewp() {

	do_action( 'tbexgive/givewp_settings/before_view' );

	require_once TBEXGIVE_PLUGIN_DIR . 'includes/admin/views/settings-tab-givewp.php';

	settings_fields( 'tbexgive_group_givewp' );
	do_settings_sections( 'tbexgive_group_givewp' );

	do_action( 'tbexgive/givewp_settings/after_view' );

	submit_button( ddw_tbex_string_save_changes() );

}  // end function


add_action( 'tbexgive/givewp_settings/before_view', 'ddw_tbexgive_settings_before_view_givewp' );
/**
 * Add-On description and info on settings tab page.
 *
 * @since 1.0.0
 */
function ddw_tbexgive_settings_before_view_givewp() {

	?>
		<div class="tbex-addon-header dashicons-before dashicons-heart">
			<h3 class="tbex-addon-title">
				<?php _e( 'Add-On', 'toolbar-extras-givewp' ); ?>: <?php _e( 'Toolbar Extras for Give Donations', 'toolbar-extras-givewp' ); ?>
				<span class="tbex-version"><?php echo ( defined( 'TBEXGIVE_PLUGIN_VERSION' ) ) ? 'v' . TBEXGIVE_PLUGIN_VERSION : ''; ?></span>
			</h3>
			<p class="description">
				<?php echo sprintf(
					__( 'This Add-On brings the settings and items of the %s to your Toolbar, including current active GiveWP Add-Ons.', 'toolbar-extras-givewp' ),
					'<a href="' . esc_url( admin_url( 'edit.php?post_type=give_forms' ) ) . '">' . __( 'Give Donations', 'toolbar-extras-givewp' ) . '</a>'
				); ?>
				<br /><?php _e( 'Below you will find lots of settings to customize your experience for managing donation campaigns with GiveWP even faster.', 'toolbar-extras-givewp' ); ?>
			</p>
		</div>
	<?php

}  // end function


add_action( 'tbex_plugins_settings_addons', 'ddw_tbexgive_add_settings_tab_item_givewp' );
/**
 * This will add the GiveWP settings tab link item to Toolbar Extras' own
 *   settings group within the "Site Group".
 *
 * @since 1.0.0
 *
 * @global mixed $GLOBALS[ 'wp_admin_bar' ]
 */
function ddw_tbexgive_add_settings_tab_item_givewp() {

	$GLOBALS[ 'wp_admin_bar' ]->add_node(
		array(
			'id'     => 'tbex-settings-givewp',
			'parent' => 'tbex-settings',
			'title'  => esc_attr_x( 'GiveWP Add-On', 'For Toolbar Extras Plugin', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'options-general.php?page=toolbar-extras&tab=givewp' ) ),
			'meta'   => array(
				'target' => '',
				/* translators: Title attribute for Toolbar Extras "GiveWP Add-On" settings link */
				'title'  => esc_attr_x( 'GiveWP Add-On for Toolbar Extras', 'For Toolbar Extras Plugin', 'toolbar-extras-givewp' )
			)
		)
	);

}  // end function


add_filter( 'tbex_filter_user_profile_buttons', 'ddw_tbexgive_user_profile_button_givewp' );
/**
 * Add own "GiveWP" button to the Toolbar Extras section on the user profile
 *   page.
 *
 * @since 1.0.0
 *
 * @param array $settings_buttons Array of settings buttons.
 * @return array Modified array of settings buttons.
 */
function ddw_tbexgive_user_profile_button_givewp( $settings_buttons ) {

	$settings_buttons[ 'givewp' ] = array(
		'title_attr' => esc_attr__( 'Go to the Toolbar Extras GiveWP Add-On settings tab', 'toolbar-extras-givewp' ),
		'label'      => _x( 'GiveWP', 'Plugin settings tab title', 'toolbar-extras-givewp' ),
		'dashicon'   => 'heart',
	);

	return $settings_buttons;

}  // end function


add_action( 'admin_menu', 'ddw_tbexgive_add_submenu_for_givewp', 100 );
/**
 * Add additional admin menu items to make Toolbar settings more accessable.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_is_givewp_active()
 * @uses ddw_tbexgive_string_givewp()
 * @uses add_submenu_page()
 */
function ddw_tbexgive_add_submenu_for_givewp() {

	/** Bail early if Give Donations not active */
	if ( ! ddw_tbexgive_is_givewp_active() ) {
		return;
	}

	/** Add to Give's regular left-hand admin menu */
	$menu_title = sprintf(
		/* translators: %s - Word Give */
		esc_html_x( '%s Toolbar', 'Admin submenu title', 'toolbar-extras-givewp' ),
		ddw_tbexgive_string_givewp()
	);

	add_submenu_page(
		'edit.php?post_type=give_forms',
		$menu_title,
		$menu_title,
		'manage_options',
		esc_url( admin_url( 'options-general.php?page=toolbar-extras&tab=givewp' ) )
	);

}  // end function


add_filter( 'tbex_filter_color_items', 'ddw_tbexgive_add_color_item_givewp' );
/**
 * Add additional GiveWP color item all appearances of our color picker.
 *
 * @since 1.0.0
 *
 * @param array $color_items Array holding all color items.
 * @return array Modified array of color items.
 */
function ddw_tbexgive_add_color_item_givewp( $color_items ) {

	$color_items[ 'givewp' ] = array(
		'color' => '#66bc6b',
		'name'  => __( 'GiveWP Green', 'toolbar-extras-givewp' ),
	);

	return $color_items;

}  // end function



// ------------ Test ---------------------------


// Add Global Fee Recovery settings.
add_filter( 'give-settings_get_settings_pages', 'ddw_tbexgive_givewp_settings_tab', 10, 1 );
/**
 * Add Give Fee Recovery setting section.
 *
 * @since  1.0.0
 * @access public
 *
 * @param array $settings Give Settings.
 *
 * @return array $settings Give Settings.
 */
function ddw_tbexgive_givewp_settings_tab( $settings ) {

	$settings[] = include TBEXGIVE_PLUGIN_DIR . '/includes/admin/givewp-settings-tab.php';

	return $settings;
}
