<?php

// includes/admin/views/settings-tab-givewp

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * 1) All SECTION INFOS callbacks (rendering)
 * -----------------------------------------------------------------------------
 */

/**
 * Tab GiveWP - 1st settings section: Description.
 *
 * @since 1.0.0
 */
function ddw_tbexgive_settings_section_info_donations() {

	?>
		<p>
			<?php _e( 'Set options for the main, top-level Donations for GiveWP in the Toolbar', 'toolbar-extras-givewp' ); ?>
		</p>
	<?php

}  // end function


/**
 * Tab GiveWP - 2nd settings section: Description.
 *
 * @since 1.0.0
 */
function ddw_tbexgive_settings_section_info_givewp() {

	?>
		<p>
			<?php _e( 'Set some things for Give Donations itself.', 'toolbar-extras-givewp' ); ?>
		</p>
	<?php

}  // end function


/**
 * Tab GiveWP - 3rd settings section: Description.
 *
 * @since 1.0.0
 */
function ddw_tbexgive_settings_section_info_featured_form() {

	?>
		<p>
			<?php _e( 'Optionally display one specific form campaign as featured top-level item in the Toolbar.', 'toolbar-extras-givewp' ); ?>
		</p>
	<?php

}  // end function


/**
 * Tab GiveWP - 4th settings section: Description.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_is_give_test_mode()
 */
function ddw_tbexgive_settings_section_info_testmode() {

	$settings_link = sprintf(
		'<a href="%s">%s</a>',
		esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gateways' ) ),
		__( 'in the GiveWP settings', 'toolbar-extras-givewp' )
	);

	$settings_string = sprintf(
		/* translators: %s - label for "in the GiveWP settings" (linked) */
		__( 'You can easily switch between Live and Test Mode %s.', 'toolbar-extras-givewp' ),
		$settings_link
	);

	$output = sprintf(
		'<p%s>%s %s</p>',
		! ddw_tbexgive_is_give_test_mode() ? ' class="tbex-remove-settings-section-description"' : '',
		__( 'Set a few tweaks for the Give Test Mode.', 'toolbar-extras-givewp' ),
		$settings_string
	);

	echo $output;

}  // end function


/**
 * Tab GiveWP - 5th settings section: Description.
 *
 * @since 1.0.0
 */
function ddw_tbexgive_settings_section_info_givewp_tweaks() {

	?>
		<p>
			<?php _e( 'Determine which menu items should be removed and set other additional tweaks.', 'toolbar-extras-givewp' ); ?>
		</p>
	<?php

}  // end function



/**
 * 2) All SETTING FIELDS callbacks (rendering)
 * -----------------------------------------------------------------------------
 */

/**
 * 1st section: Donations top-level item:
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/**
 * Setting (Input, Text): Donations Name
 *
 * @since 1.0.0
 */
function ddw_tbexgive_settings_cb_donations_tl_name() {

	$tbex_options = get_option( 'tbex-options-givewp' );

	?>
		<input type="text" class="regular-text tbex-input" id="tbex-options-givewp-donations_tl_name" name="tbex-options-givewp[donations_tl_name]" value="<?php echo wp_filter_nohtml_kses( $tbex_options[ 'donations_tl_name' ] ); ?>" />
		<label for="tbex-options-givewp[donations_tl_name]">
			<span class="description">
				<?php echo sprintf(
					__( 'Default: %s', 'toolbar-extras-givewp' ),
					'<code>' . __( 'Donations', 'toolbar-extras-givewp' ) . '</code>'
				); ?>
			</span>
		</label>
	<?php

}  // end function


/**
 * Setting (Select): Which icon to use for the Donations Item
 *
 * @since 1.0.0
 */
function ddw_tbexgive_settings_cb_donations_tl_use_icon() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<select name="tbex-options-givewp[donations_tl_use_icon]" id="tbex-options-givewp-donations_tl_use_icon">
			<option value="none" <?php selected( sanitize_key( $tbexgive_options[ 'donations_tl_use_icon' ] ), 'none' ); ?>><?php _e( 'None', 'toolbar-extras-givewp' ); ?></option>
			<option value="givewp" <?php selected( sanitize_key( $tbexgive_options[ 'donations_tl_use_icon' ] ), 'givewp' ); ?>><?php _e( 'GiveWP Logo Icon', 'toolbar-extras-givewp' ); ?></option>
			<option value="dashicon" <?php selected( sanitize_key( $tbexgive_options[ 'donations_tl_use_icon' ] ), 'dashicon' ); ?>><?php _e( 'Dashicon Icon', 'toolbar-extras-givewp' ); ?></option>
		</select>
		<label for="tbex-options-givewp[donations_tl_use_icon]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				'<code>' . __( 'GiveWP Logo Icon', 'toolbar-extras-givewp' ) . '</code>'
			); ?></span>
		</label>
	<?php

}  // end function


/**
 * Setting (Dashicon picker): Donations Item Icon
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_choose_icon()
 */
function ddw_tbexgive_settings_cb_donations_tl_icon() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<input class="regular-text tbex-input" type="text" id="tbex-options-givewp-donations_tl_icon" name="tbex-options-givewp[donations_tl_icon]" value="<?php echo strtolower( sanitize_html_class( $tbexgive_options[ 'donations_tl_icon' ] ) ); ?>" />
		<button class="button dashicons-picker" type="button" data-target="#tbex-options-givewp-donations_tl_icon"><span class="dashicons-before dashicons-plus-alt"></span> <?php ddw_tbex_string_choose_icon( 'echo' ); ?></button>
		<br />
		<label for="tbex-options-givewp[donations_tl_icon]">
			<p class="description">
				<?php
					$current = sprintf(
						'<code><span class="dashicons-before %1$s"></span> %1$s</code>',
						$tbexgive_options[ 'donations_tl_icon' ]
					);

					echo sprintf(
						/* translators: %s - a Dashicons CSS class name */
						__( 'Current: %s', 'toolbar-extras-givewp' ),
						$current
					);
					echo '<br />';
					echo sprintf(
						/* translators: %s - a Dashicons CSS class name */
						__( 'Default: %s', 'toolbar-extras-givewp' ),
						'<code><span class="dashicons-before dashicons-heart"></span> dashicons-heart</code>'
					);
				?>
			</p>
		</label>
	<?php

}  // end function


/**
 * Setting (Number): Donations Item Priority
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_explanation_toolbar_structure()
 */
function ddw_tbexgive_settings_cb_donations_tl_priority() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<input type="number" class="small-text tbex-input" id="tbex-options-givewp-donations_tl_priority" name="tbex-options-givewp[donations_tl_priority]" value="<?php echo absint( $tbexgive_options[ 'donations_tl_priority' ] ); ?>" step="1" min="0" />
		<label for="tbex-options-givewp[donations_tl_priority]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				'<code>72</code>'
			); ?></span>
		</label>
		<p class="description tbex-align-middle">
			<?php _e( 'The default value means display at far right of the left Toolbar section/ column.', 'toolbar-extras-givewp' ); ?> <?php _e( 'The smaller the value gets the more on the left the item will be displayed.', 'toolbar-extras-givewp' ); ?> <?php ddw_tbex_explanation_toolbar_structure(); ?>
		</p>
	<?php

}  // end function


/**
 * Setting (Input, URL): Donations Item URL
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_custom_url_test()
 * @uses ddw_tbex_string_no_custom_url()
 * @uses ddw_tbex_string_ensure_input_https()
 */
function ddw_tbexgive_settings_cb_donations_tl_url() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	$default_link = sprintf(
		'<a href="%s">%s</a>',
		esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-payment-history' ) ),
		__( 'Donations History Admin URL', 'toolbar-extras-givewp' )
	);

	?>
		<input type="url" class="regular-text tbex-input" id="tbex-options-givewp-donations_tl_url" name="tbex-options-givewp[donations_tl_url]" placeholder="https://" value="<?php echo esc_url( $tbexgive_options[ 'donations_tl_url' ] ); ?>" /> <?php echo ddw_tbex_custom_url_test( 'givewp', 'donations_tl_url' ); ?>
		<label for="tbex-options-givewp[donations_tl_url]">
			<span class="description">
				<?php echo sprintf(
					__( 'Default: %s', 'toolbar-extras-givewp' ),
					ddw_tbex_string_no_custom_url()
				); ?>
			</span>
		</label>
		<p class="description">
			<?php echo sprintf(
				/* translators: %s - string "Donations History Admin URL" (linked) */
				__( 'When you let the above field empty the default %s will be used. Only when you enter a valid custom URL, that will actually be used. That could be a full external URL or even a (full) frontend or backend URL from your WordPress install. In most cases it should be efficient to use the default behavior.', 'toolbar-extras-givewp' ),
				$default_link
			); ?>
		</p>
		<p class="description">
			<?php echo ddw_tbex_string_ensure_input_https(); ?>
		</p>
	<?php

}  // end function


/**
 * Setting (Select): Donations Item link target
 *
 * @since 1.0.0
 */
function ddw_tbexgive_settings_cb_donations_tl_target() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<select class="tbex-input" name="tbex-options-givewp[donations_tl_target]" id="tbex-options-givewp-donations_tl_target">
			<option value="_self" <?php selected( sanitize_key( $tbexgive_options[ 'donations_tl_target' ] ), '_self' ); ?>><?php _e( 'Same Tab/ Window', 'toolbar-extras-givewp' ); ?></option>
			<option value="_blank" <?php selected( sanitize_key( $tbexgive_options[ 'donations_tl_target' ] ), '_blank' ); ?>><?php _e( 'New Tab/ Window', 'toolbar-extras-givewp' ); ?></option>
		</select>
		<label for="tbex-options-givewp[donations_tl_target]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				'<code>' . __( 'Same Tab/ Window', 'toolbar-extras-givewp' ) . '</code>'
			); ?></span>
		</label>
	<?php

}  // end function


/**
 * 2nd section: GiveWP name etc.:
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/**
 * Setting (Input, Text): GiveWP Name
 *
 * @since 1.0.0
 */
function ddw_tbexgive_settings_cb_givewp_name() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<input type="text" class="regular-text tbex-input" id="tbex-options-givewp-givewp_name" name="tbex-options-givewp[givewp_name]" value="<?php echo wp_filter_nohtml_kses( $tbexgive_options[ 'givewp_name' ] ); ?>" />
		<label for="tbex-options-givewp[givewp_name]">
			<span class="description">
				<?php echo sprintf(
					__( 'Default: %s', 'toolbar-extras-givewp' ),
					'<code>' . __( 'Give', 'toolbar-extras-givewp' ) . '</code>'
				); ?>
			</span>
		</label>
		<p class="description">
			<?php _e( 'This label will be used on various locations for the Toolbar items of this Add-On.', 'toolbar-extras-givewp' ); ?>
		</p>
	<?php

}  // end function


/**
 * Setting (Select): Display GiveWP Shortcode Pages items?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexgive_settings_cb_givewp_shortcode_pages() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	$shortcodes_link = sprintf(
		'<a href="%s" target="%s" rel="%s">%s</a>',
		ddw_tbex_get_info_url( 'url_give_shortcodes', 'givewp' ),
		ddw_tbex_meta_target(),
		ddw_tbex_meta_rel(),
		sprintf(
			/* translators: %s - label, "GiveWP" */
			__( '%s Shortcodes', 'toolbar-extras-givewp' ),
			'GiveWP'
		)
	);

	$description = sprintf(
		/* translators: 1 - label, "GiveWP Shortcodes" (linked) / 2 - Shortcode, <code>[give_login]</code> / 3 - Shortcode, <code>[give_donor_wall]</code> */
		__( 'With this setting enabled you can optionally list pages which contain special %1$s, like, for example %2$s or %3$s.', 'toolbar-extras-givewp' ),
		$shortcodes_link,
		'<code>[give_login]</code>',
		'<code>[give_donor_wall]</code>'
	);

	$description .= ' ' . sprintf(
		/* translators: %s - label, "Pages (<code>page</code>)" */
		__( 'This applies only for the %s post type, and if there are actually pages that have one of these Shortcodes in their content.', 'toolbar-extras-givewp' ),
		__( 'Pages', 'toolbar-extras-givewp' ) . ' (<code>page</code>)'
	);

	$note = sprintf(
		__( 'Note: If you have hundreds or even thousands of pages, it is recommended to deactivate this feature (set to %s), to avoid any potential performance issues.', 'toolbar-extras-givewp' ),
		ddw_tbex_string_no( 'return', 'code' )
	);

	?>
		<select name="tbex-options-givewp[givewp_shortcode_pages]" id="tbex-options-givewp-givewp_shortcode_pages">
			<option value="yes" <?php selected( sanitize_key( $tbexgive_options[ 'givewp_shortcode_pages' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexgive_options[ 'givewp_shortcode_pages' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-givewp[givewp_shortcode_pages]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				ddw_tbex_string_yes( 'return', 'code' )
			); ?></span>
		</label>
		<p class="description">
			<?php echo $description; ?>
		</p>
		<p class="description">
			<?php echo $note; ?>
		</p>
	<?php

}  // end function


/**
 * Setting (Select): Display Post State for GiveWP Shortcode Pages?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexgive_settings_cb_givewp_shortcode_state() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<select name="tbex-options-givewp[givewp_shortcode_state]" id="tbex-options-givewp-givewp_shortcode_state">
			<option value="yes" <?php selected( sanitize_key( $tbexgive_options[ 'givewp_shortcode_state' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexgive_options[ 'givewp_shortcode_state' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-givewp[givewp_shortcode_state]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				ddw_tbex_string_yes( 'return', 'code' )
			); ?></span>
		</label>
	<?php

}  // end function


/**
 * Setting (Select): Display Views filter for GiveWP Pages?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexgive_settings_cb_givewp_pages_views_filter() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<select name="tbex-options-givewp[givewp_pages_views_filter]" id="tbex-options-givewp-givewp_pages_views_filter">
			<option value="yes" <?php selected( sanitize_key( $tbexgive_options[ 'givewp_pages_views_filter' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexgive_options[ 'givewp_pages_views_filter' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-givewp[givewp_pages_views_filter]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				ddw_tbex_string_yes( 'return', 'code' )
			); ?></span>
		</label>
	<?php

}  // end function


/**
 * Setting (Select): Use Admin submenu tweak?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexgive_settings_cb_givewp_admin_menu_tweak() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<select name="tbex-options-givewp[givewp_admin_menu_tweak]" id="tbex-options-givewp-givewp_admin_menu_tweak">
			<option value="yes" <?php selected( sanitize_key( $tbexgive_options[ 'givewp_admin_menu_tweak' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexgive_options[ 'givewp_admin_menu_tweak' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-givewp[givewp_admin_menu_tweak]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				ddw_tbex_string_yes( 'return', 'code' )
			); ?></span>
		</label>
		<p class="description">
			<?php echo sprintf(
				/* translators: 1 - label, "Add-Ons" / 2 - label, "Changelog" */
				__( 'If enabled, this will swap out the (promotional) %1$s submenu with the (more useful) %2$s submenu - within the left-hand %3$s Admin menu.', 'toolbar-extras-givewp' ),
				'<strong>' . __( 'Add-Ons', 'toolbar-extras-givewp' ) . '</strong>',
				'<strong>' . __( 'Changelog', 'toolbar-extras-givewp' ) . '</strong>',
				__( 'Donations', 'toolbar-extras-givewp' )
			); ?>
		</p>
	<?php

}  // end function


/**
 * 3rd section: Featured Form item:
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/**
 * Setting (Select): Display Featured Form item?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexgive_settings_cb_formfeat_display() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<select name="tbex-options-givewp[formfeat_display]" id="tbex-options-givewp-formfeat_display">
			<option value="yes" <?php selected( sanitize_key( $tbexgive_options[ 'formfeat_display' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexgive_options[ 'formfeat_display' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-givewp[formfeat_display]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				ddw_tbex_string_no( 'return', 'code' )
			); ?></span>
		</label>
	<?php

}  // end function


/**
 * Setting (Select): Which Featured Form to display?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexgive_settings_cb_formfeat_form_id() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	/** Set post type arguments for WP_Query */
	$givewp_posttype_args = array(
		'post_type'      => 'give_forms',
		'posts_per_page' => -1,
	);

	/** Query GiveWP Forms (Campaigns) */
	$give_forms = get_posts( $givewp_posttype_args );

	/** Build the <option> items for select tag */
	$select_options = sprintf(
		'<option value="0" %s>--- %s ---</option>',
		selected( sanitize_key( $tbexgive_options[ 'formfeat_form_id' ] ), 0, FALSE ),
		__( 'Please select a form', 'toolbar-extras-givewp' )
	);

	if ( $give_forms ) {

		foreach ( $give_forms as $give_form ) {

			$form_title = esc_attr( $give_form->post_title );
			$form_id    = (int) $give_form->ID;

			$select_options .= sprintf(
				'<option value="%1$s" %2$s>%3$s</option>',
				$form_id,
				selected( sanitize_key( $tbexgive_options[ 'formfeat_form_id' ] ), $form_id, FALSE ),
				$form_title
			);

		}  // end foreach

	} else {

		$select_options .= sprintf(
			'<option value="0" %s>(%s)</option>',
			selected( sanitize_key( $tbexgive_options[ 'formfeat_form_id' ] ), 0, FALSE ),
			__( 'No GiveWP Donation forms available', 'toolbar-extras-givewp' )
		);

	}  // end if/else

	?>
		<select name="tbex-options-givewp[formfeat_form_id]" id="tbex-options-givewp-formfeat_form_id"><?php echo $select_options; ?></select>
		<label for="tbex-options-givewp[formfeat_form_id]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				'<code>' . __( '(none)', 'toolbar-extras-givewp' ) . '</code>'
			); ?></span>
		</label>
	<?php

}  // end function


/**
 * Setting (Select): Which title for Featured Form item?
 *
 * @since 1.0.0
 */
function ddw_tbexgive_settings_cb_formfeat_title() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<select name="tbex-options-givewp[formfeat_title]" id="tbex-options-givewp-formfeat_title">
			<option value="form_title" <?php selected( sanitize_key( $tbexgive_options[ 'formfeat_title' ] ), 'form_title' ); ?>><?php _e( 'Form Title', 'toolbar-extras-givewp' ); ?></option>
			<option value="custom_title" <?php selected( sanitize_key( $tbexgive_options[ 'formfeat_title' ] ), 'custom_title' ); ?>><?php _e( 'Use a Custom Title', 'toolbar-extras-givewp' ); ?></option>
		</select>
		<label for="tbex-options-givewp[formfeat_title]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				'<code>' . __( 'Form Title', 'toolbar-extras-givewp' ) . '</code>'
			); ?></span>
		</label>
	<?php

}  // end function


/**
 * Setting (Input, Text): Featured form custom Name
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_none_empty()
 */
function ddw_tbexgive_settings_cb_formfeat_name() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<input type="text" class="regular-text tbex-input" id="tbex-options-givewp-formfeat_name" name="tbex-options-givewp[formfeat_name]" value="<?php echo wp_filter_nohtml_kses( $tbexgive_options[ 'formfeat_name' ] ); ?>" />
		<label for="tbex-options-givewp[formfeat_name]">
			<span class="description">
				<?php echo sprintf(
					__( 'Default: %s', 'toolbar-extras-givewp' ),
					'<code>' . ddw_tbex_string_none_empty( 'return' ) . '</code>'
				); ?>
			</span>
		</label>
	<?php

}  // end function


/**
 * Setting (Select): Display income (earnings) after form title?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexgive_settings_cb_formfeat_income() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<select name="tbex-options-givewp[formfeat_income]" id="tbex-options-givewp-formfeat_income">
			<option value="yes" <?php selected( sanitize_key( $tbexgive_options[ 'formfeat_income' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexgive_options[ 'formfeat_income' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-givewp[formfeat_income]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				ddw_tbex_string_yes( 'return', 'code' )
			); ?></span>
		</label>
		<p class="description">
			<?php _e( 'Show the the complete donation income the above chosen featured form has generated so far. So you can immediately see the current status of your campaign - in the Admin Dashboard and on the frontend. Very useful.', 'toolbar-extras-givewp' ); ?>
		</p>
	<?php

}  // end function


/**
 * Setting (Select): Which icon to use for the featured form item?
 *
 * @since 1.0.0
 */
function ddw_tbexgive_settings_cb_formfeat_use_icon() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<select name="tbex-options-givewp[formfeat_use_icon]" id="tbex-options-givewp-formfeat_use_icon">
			<option value="none" <?php selected( sanitize_key( $tbexgive_options[ 'formfeat_use_icon' ] ), 'none' ); ?>><?php _e( 'None', 'toolbar-extras-givewp' ); ?></option>
			<option value="givewp" <?php selected( sanitize_key( $tbexgive_options[ 'formfeat_use_icon' ] ), 'givewp' ); ?>><?php _e( 'GiveWP Logo Icon', 'toolbar-extras-givewp' ); ?></option>
			<option value="dashicon" <?php selected( sanitize_key( $tbexgive_options[ 'formfeat_use_icon' ] ), 'dashicon' ); ?>><?php _e( 'Dashicon Icon', 'toolbar-extras-givewp' ); ?></option>
		</select>
		<label for="tbex-options-givewp[formfeat_use_icon]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				'<code>' . __( 'GiveWP Logo Icon', 'toolbar-extras-givewp' ) . '</code>'
			); ?></span>
		</label>
	<?php

}  // end function


/**
 * Setting (Dashicon picker): Featured Form Item Icon
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_choose_icon()
 */
function ddw_tbexgive_settings_cb_formfeat_icon() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<input class="regular-text tbex-input" type="text" id="tbex-options-givewp-formfeat_icon" name="tbex-options-givewp[formfeat_icon]" value="<?php echo strtolower( sanitize_html_class( $tbexgive_options[ 'formfeat_icon' ] ) ); ?>" />
		<button class="button dashicons-picker" type="button" data-target="#tbex-options-givewp-formfeat_icon"><span class="dashicons-before dashicons-plus-alt"></span> <?php ddw_tbex_string_choose_icon( 'echo' ); ?></button>
		<br />
		<label for="tbex-options-givewp[formfeat_icon]">
			<p class="description">
				<?php
					$current = sprintf(
						'<code><span class="dashicons-before %1$s"></span> %1$s</code>',
						$tbexgive_options[ 'formfeat_icon' ]
					);

					echo sprintf(
						/* translators: %s - a Dashicons CSS class name */
						__( 'Current: %s', 'toolbar-extras-givewp' ),
						$current
					);
					echo '<br />';
					echo sprintf(
						/* translators: %s - a Dashicons CSS class name */
						__( 'Default: %s', 'toolbar-extras-givewp' ),
						'<code><span class="dashicons-before dashicons-star-filled"></span> dashicons-star-filled</code>'
					);
				?>
			</p>
		</label>
	<?php

}  // end function


/**
 * Setting (Number): Featured Form Item Priority
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_explanation_toolbar_structure()
 */
function ddw_tbexgive_settings_cb_formfeat_priority() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<input type="number" class="small-text tbex-input" id="tbex-options-givewp-formfeat_priority" name="tbex-options-givewp[formfeat_priority]" value="<?php echo absint( $tbexgive_options[ 'formfeat_priority' ] ); ?>" step="1" min="0" />
		<label for="tbex-options-givewp[formfeat_priority]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				'<code>1000</code>'
			); ?></span>
		</label>
		<p class="description tbex-align-middle">
			<?php _e( 'The default value means display at far right of the left Toolbar section/ column.', 'toolbar-extras-givewp' ); ?> <?php _e( 'The smaller the value gets the more on the left the item will be displayed.', 'toolbar-extras-givewp' ); ?> <?php ddw_tbex_explanation_toolbar_structure(); ?>
		</p>
	<?php

}  // end function


/**
 * Setting (Color Picker): Post state label color
 *
 * @since 1.0.0
 */
function ddw_tbexgive_settings_cb_formfeat_bgcolor() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<input type="text" class="tbex-color-picker tbex-input" id="tbex-options-givewp-formfeat_bgcolor" name="tbex-options-givewp[formfeat_bgcolor]" value="<?php echo sanitize_hex_color( $tbexgive_options[ 'formfeat_bgcolor' ] ); ?>" data-default-color="" />
		<?php
			do_action( 'tbex_settings_color_picker_items' );
		?>
	<?php

}  // end function


/**
 * Setting (Select): Which URL to use for featured form item?
 *
 * @since 1.0.0
 */
function ddw_tbexgive_settings_cb_formfeat_use_url() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<select name="tbex-options-givewp[formfeat_use_url]" id="tbex-options-givewp-formfeat_use_url">
			<option value="form_default" <?php selected( sanitize_key( $tbexgive_options[ 'formfeat_use_url' ] ), 'form_default' ); ?>><?php _e( 'Form Default', 'toolbar-extras-givewp' ); ?></option>
			<option value="custom_url" <?php selected( sanitize_key( $tbexgive_options[ 'formfeat_use_url' ] ), 'custom_url' ); ?>><?php _e( 'Custom URL', 'toolbar-extras-givewp' ); ?></option>
		</select>
		<label for="tbex-options-givewp[formfeat_use_url]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				'<code>' . __( 'Form Default', 'toolbar-extras-givewp' ) . '</code>'
			); ?></span>
		</label>
	<?php

}  // end function


/**
 * Setting (Input, URL): Featured form item custom URL
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_custom_url_test()
 * @uses ddw_tbex_string_no_custom_url()
 * @uses ddw_tbex_string_ensure_input_https()
 */
function ddw_tbexgive_settings_cb_formfeat_url() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	$feat_form_id = $tbexgive_options[ 'formfeat_form_id' ];

	$default_link = sprintf(
		'<a href="%s">%s</a>',
		esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-payment-history&form_id=' . $feat_form_id ) ),
		__( 'Form Donation History Admin URL', 'toolbar-extras-givewp' )
	);

	?>
		<input type="url" class="regular-text tbex-input" id="tbex-options-givewp-formfeat_url" name="tbex-options-givewp[formfeat_url]" placeholder="https://" value="<?php echo esc_url( $tbexgive_options[ 'formfeat_url' ] ); ?>" /> <?php echo ddw_tbex_custom_url_test( 'givewp', 'formfeat_url' ); ?>
		<label for="tbex-options-givewp[formfeat_url]">
			<span class="description">
				<?php echo sprintf(
					__( 'Default: %s', 'toolbar-extras-givewp' ),
					ddw_tbex_string_no_custom_url()
				); ?>
			</span>
		</label>
		<p class="description">
			<?php echo sprintf(
				/* translators: %s - string "Form Donation History Admin URL" (linked) */
				__( 'When you let the above field empty the default %s will be used. Only when you enter a valid custom URL, that will actually be used. That could be a full external URL or even a (full) frontend or backend URL from your WordPress install. In most cases it should be efficient to use the default behavior.', 'toolbar-extras-givewp' ),
				$default_link
			); ?>
		</p>
		<p class="description">
			<?php echo ddw_tbex_string_ensure_input_https(); ?>
		</p>
	<?php

}  // end function


/**
 * Setting (Select): Featured form item link target
 *
 * @since 1.0.0
 */
function ddw_tbexgive_settings_cb_formfeat_target() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<select class="tbex-input" name="tbex-options-givewp[formfeat_target]" id="tbex-options-givewp-formfeat_target">
			<option value="_self" <?php selected( sanitize_key( $tbexgive_options[ 'formfeat_target' ] ), '_self' ); ?>><?php _e( 'Same Tab/ Window', 'toolbar-extras-givewp' ); ?></option>
			<option value="_blank" <?php selected( sanitize_key( $tbexgive_options[ 'formfeat_target' ] ), '_blank' ); ?>><?php _e( 'New Tab/ Window', 'toolbar-extras-givewp' ); ?></option>
		</select>
		<label for="tbex-options-givewp[formfeat_target]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				'<code>' . __( 'Same Tab/ Window', 'toolbar-extras-givewp' ) . '</code>'
			); ?></span>
		</label>
	<?php

}  // end function


/**
 * 4th section: Test Mode item:
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/**
 * Setting (Select): Use Test Mode tweaks?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexgive_settings_cb_testmode_use_tweaks() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<select name="tbex-options-givewp[testmode_use_tweaks]" id="tbex-options-givewp-testmode_use_tweaks">
			<option value="yes" <?php selected( sanitize_key( $tbexgive_options[ 'testmode_use_tweaks' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexgive_options[ 'testmode_use_tweaks' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-givewp[testmode_use_tweaks]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				ddw_tbex_string_yes( 'return', 'code' )
			); ?></span>
		</label>
	<?php

}  // end function


/**
 * Setting (Input, Text): Test Mode custom Name
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_none_empty()
 */
function ddw_tbexgive_settings_cb_testmode_name() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<input type="text" class="regular-text tbex-input" id="tbex-options-givewp-testmode_name" name="tbex-options-givewp[testmode_name]" value="<?php echo wp_filter_nohtml_kses( $tbexgive_options[ 'testmode_name' ] ); ?>" />
		<label for="tbex-options-givewp[testmode_name]">
			<span class="description">
				<?php echo sprintf(
					__( 'Default: %s', 'toolbar-extras-givewp' ),
					'<code>' . esc_attr_x( 'Give Test Mode Active', 'Toolbar item label', 'toolbar-extras-givewp' ) . '</code>'
				); ?>
			</span>
		</label>
	<?php

}  // end function


/**
 * Setting (Select): Which icon to use for the Test Mode item?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_none_empty()
 */
function ddw_tbexgive_settings_cb_testmode_use_icon() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<select name="tbex-options-givewp[testmode_use_icon]" id="tbex-options-givewp-testmode_use_icon">
			<option value="none" <?php selected( sanitize_key( $tbexgive_options[ 'testmode_use_icon' ] ), 'none' ); ?>><?php _e( 'None', 'toolbar-extras-givewp' ); ?></option>
			<option value="givewp" <?php selected( sanitize_key( $tbexgive_options[ 'testmode_use_icon' ] ), 'givewp' ); ?>><?php _e( 'GiveWP Logo Icon', 'toolbar-extras-givewp' ); ?></option>
			<option value="dashicon" <?php selected( sanitize_key( $tbexgive_options[ 'testmode_use_icon' ] ), 'dashicon' ); ?>><?php _e( 'Dashicon Icon', 'toolbar-extras-givewp' ); ?></option>
		</select>
		<label for="tbex-options-givewp[testmode_use_icon]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				'<code>' . ddw_tbex_string_none_empty( 'return' ) . '</code>'
			); ?></span>
		</label>
	<?php

}  // end function


/**
 * Setting (Dashicon picker): Test Mode Item Icon
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_choose_icon()
 */
function ddw_tbexgive_settings_cb_testmode_icon() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<input class="regular-text tbex-input" type="text" id="tbex-options-givewp-testmode_icon" name="tbex-options-givewp[testmode_icon]" value="<?php echo strtolower( sanitize_html_class( $tbexgive_options[ 'testmode_icon' ] ) ); ?>" />
		<button class="button dashicons-picker" type="button" data-target="#tbex-options-givewp-testmode_icon"><span class="dashicons-before dashicons-plus-alt"></span> <?php ddw_tbex_string_choose_icon( 'echo' ); ?></button>
		<br />
		<label for="tbex-options-givewp[testmode_icon]">
			<p class="description">
				<?php
					$current = sprintf(
						'<code><span class="dashicons-before %1$s"></span> %1$s</code>',
						$tbexgive_options[ 'testmode_icon' ]
					);

					echo sprintf(
						/* translators: %s - a Dashicons CSS class name */
						__( 'Current: %s', 'toolbar-extras-givewp' ),
						$current
					);
					echo '<br />';
					echo sprintf(
						/* translators: %s - a Dashicons CSS class name */
						__( 'Default: %s', 'toolbar-extras-givewp' ),
						'<code><span class="dashicons-before dashicons-info"></span> dashicons-info</code>'
					);
				?>
			</p>
		</label>
	<?php

}  // end function


/**
 * 5th section: Tweaks:
 * ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

/**
 * Setting (Select): Display "Build" group of Toolbar Extras?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexgive_settings_cb_remove_tbex_build_group() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<select name="tbex-options-givewp[remove_tbex_build_group]" id="tbex-options-givewp-remove_tbex_build_group">
			<option value="yes" <?php selected( sanitize_key( $tbexgive_options[ 'remove_tbex_build_group' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexgive_options[ 'remove_tbex_build_group' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-givewp[remove_tbex_build_group]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				ddw_tbex_string_no( 'return', 'code' )
			); ?></span>
		</label>
		<p class="description">
			<?php echo sprintf(
				/* translators: %s - label, "Build Group" */
				__( 'For focussing fully on donation management you can even remove Toolbar Extras\' own %s top-level item. Otherwise it is recommended to keep this item.', 'toolbar-extras-givewp' ),
				'<em>' . __( 'Build Group', 'toolbar-extras-givewp' ) . '</em>'
			); ?>
		</p>
	<?php

}  // end function


/**
 * Setting (Select): Unload the Give Donations translations?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 * @uses ddw_tbexgive_get_givewp_textdomains()
 */
function ddw_tbexgive_settings_cb_unload_td_givewp() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<select name="tbex-options-givewp[unload_td_givewp]" id="tbex-options-givewp-unload_td_givewp">
			<option value="yes" <?php selected( sanitize_key( $tbexgive_options[ 'unload_td_givewp' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexgive_options[ 'unload_td_givewp' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-givewp[unload_td_givewp]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				ddw_tbex_string_no( 'return', 'code' )
			); ?></span>
		</label>
		<p class="description">
			<?php _e( 'This tweak unloads the translations for Give Donations. So all strings fall back to their English default strings.', 'toolbar-extras-givewp' ); ?>
		</p>
		<p class="description">
			<?php echo sprintf(
				/* translators: %s - text domain strings, for example 'givewp' */
				__( 'Effected text domains: %s', 'toolbar-extras-givewp' ),
				'<code>' . implode( ', ', ddw_tbexgive_get_givewp_textdomains() ) . '</code>'
			); ?>
		</p>
	<?php

}  // end function


/**
 * Setting (Select): Unload the Toolbar Extras for Give Donations translations?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_yes()
 * @uses ddw_tbex_string_no()
 */
function ddw_tbexgive_settings_cb_unload_td_tbexgive() {

	$tbexgive_options = get_option( 'tbex-options-givewp' );

	?>
		<select name="tbex-options-givewp[unload_td_tbexgive]" id="tbex-options-givewp-unload_td_tbexgive">
			<option value="yes" <?php selected( sanitize_key( $tbexgive_options[ 'unload_td_tbexgive' ] ), 'yes' ); ?>><?php ddw_tbex_string_yes( 'echo' ); ?></option>
			<option value="no" <?php selected( sanitize_key( $tbexgive_options[ 'unload_td_tbexgive' ] ), 'no' ); ?>><?php ddw_tbex_string_no( 'echo' ); ?></option>
		</select>
		<label for="tbex-options-givewp[unload_td_tbexgive]">
			<span class="description"><?php echo sprintf(
				__( 'Default: %s', 'toolbar-extras-givewp' ),
				ddw_tbex_string_no( 'return', 'code' )
			); ?></span>
		</label>
		<p class="description">
			<?php _e( 'This tweak unloads the translations for Toolbar Extras for Give Donations Add-On, so it falls back to the English default strings.', 'toolbar-extras-givewp' ); ?>
		</p>
		<p class="description">
			<?php echo sprintf(
				/* translators: %s - a text domain string, 'toolbar-extras-givewp' */
				__( 'Effected text domain: %s', 'toolbar-extras-givewp' ),
				'<code>toolbar-extras-givewp</code>'
			); ?>
		</p>
	<?php

}  // end function
