<?php

// includes/items-formfeat

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * ???
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 */
function ddw_tbexgive_get_formfeat_id() {

	return absint( ddw_tbex_get_option( 'givewp', 'formfeat_form_id' ) );

}  // end function


add_action( 'admin_bar_menu', 'ddw_tbexgive_main_item_formfeat', ddw_tbexgive_formfeat_item_priority() );
/**
 * Add main item for "Donations", for Give Donations plugin
 *   (free, by GiveWP/ Impress.org, LLC).
 *
 * @since 1.0.0
 *
 * @see plugin file /includes/tbexgive-styles.php
 *
 * @uses ddw_tbexgive_get_formfeat_id()
 * @uses ddw_tbex_get_option()
 * @uses ddw_tbex_item_title_with_settings_icon()
 * @uses ddw_tbexgive_display_featured_form_income()
 * @uses ddw_tbex_meta_rel()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_main_item_formfeat( $admin_bar ) {

	/** Bail early if no proper form ID */
	if ( 0 >= ddw_tbexgive_get_formfeat_id() ) {
		return;
	}

	/** Prepare */
	$use_icon     = ddw_tbex_get_option( 'givewp', 'formfeat_use_icon' );
	$use_title    = ddw_tbex_get_option( 'givewp', 'formfeat_title' );
	$label_form   = esc_attr( get_the_title( ddw_tbexgive_get_formfeat_id() ) );
	$label_custom = esc_attr( ddw_tbex_get_option( 'givewp', 'formfeat_name' ) );
	$label        = ( 'custom_title' === $use_title ) ? $label_custom : $label_form;
	$title        = $label;
	$use_url      = ddw_tbex_get_option( 'givewp', 'formfeat_use_url' );
	$url_form     = admin_url( 'edit.php?post_type=give_forms&page=give-payment-history&form_id=' . ddw_tbexgive_get_formfeat_id() );	// get_permalink( ddw_tbexgive_get_formfeat_id() );
	$url_custom   = ddw_tbex_get_option( 'givewp', 'formfeat_url' );
	$class        = '';

	/** Build icon & title together */
	if ( 'givewp' === $use_icon ) {

		$class = 'tbex-node-givewp-logo';

		$title = sprintf(
			'<span class="dashicons-before ab-icon tbex-settings-icon tbexgive-givewp-logo"></span><span class="ab-label">%1$s</span>',
			$label
		);

	} elseif ( 'dashicon' === $use_icon ) {

		$class = 'tbex-node-givewp-dashicon';
		$title = ddw_tbex_item_title_with_settings_icon( $label, 'givewp', 'formfeat_icon' );

	}  // end if

	/** Optional income string */
	$income = '';

	if ( ddw_tbexgive_display_featured_form_income()
		&& ( function_exists( 'give_currency_filter' ) && function_exists( 'give_format_amount' ) && function_exists( 'give_get_form_earnings_stats' ) )
	) {

		$income = sprintf(
			' (%s)',
			give_currency_filter( give_format_amount( give_get_form_earnings_stats( ddw_tbexgive_get_formfeat_id() ) /*, array( 'sanitize' => false ) */ ) )
		);

	}  // end if

	/** Build title attribute */
	$title_attr = sprintf(
		/* translators: %s - label, form title or custom text */
		esc_attr__( 'Featured Donation Form Campaign: %s', 'toolbar-extras-givewp' ),
		$label
	);

	/** Set Donations URL */
	$formfeat_url = ( 'custom_url' === $use_url ) ? $url_custom : $url_form;
	$formfeat_url = ( ! empty( $formfeat_url ) ) ? $formfeat_url : $url_form;

	/** Get link target */
	$link_target = ddw_tbex_get_option( 'givewp', 'formfeat_target' );

	$admin_bar->add_node(
		array(
			'id'     => 'tbex-givewp-formfeat',
			'title'  => $title . $income,
			'href'   => esc_url( $formfeat_url ),
			'meta'   => array(
				'class'  => 'tbexgive-formfeat-toplevel ' . $class,
				'target' => sanitize_key( $link_target ),
				'rel'    => ddw_tbex_meta_rel(),
				'title'  => $title_attr,
			)
		)
	);

}  // end function


add_action( 'admin_bar_menu', 'ddw_tbexgive_sub_items_formfeat' );
/**
 * Add main item for "Donations", for Give Donations plugin
 *   (free, by GiveWP/ Impress.org, LLC).
 *
 * @since 1.0.0
 *
 * @see plugin file /includes/tbexgive-styles.php
 *
 * @uses ddw_tbexgive_get_formfeat_id()
 * @uses ddw_tbex_get_option()
 * @uses ddw_tbex_item_title_with_settings_icon()
 * @uses ddw_tbexgive_string_givewp()
 * @uses ddw_tbex_meta_rel()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_sub_items_formfeat( $admin_bar ) {

	/** Bail early if no proper form ID */
	if ( 0 >= ddw_tbexgive_get_formfeat_id() ) {
		return;
	}

	/** Set post type arguments for WP_Query */
	$givewp_posttype_args = array(
		'post_type'      => 'give_forms',
		'posts_per_page' => -1,
	);

	/** Query GiveWP Forms (Campaigns) */
	$give_forms = get_posts( $givewp_posttype_args );

	/** Get Give Options from DB */
	$give_options = get_option( 'give_settings' );

	/** Get Give time ranges for reports */
	$give_ranges = ddw_tbexgive_get_report_ranges();

	/** Donations (Transactions) */
	$admin_bar->add_node(
		array(
			'id'     => 'givewp-formfeat-donations',
			'parent' => 'tbex-givewp-formfeat',
			'title'  => esc_attr__( 'Donation Transactions', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-payment-history&form_id=' . ddw_tbexgive_get_formfeat_id() ) ),
			'meta'   => array(
				'target' => '',
				'title'  => esc_attr__( 'Donation Transactions - Payment History', 'toolbar-extras-givewp' ),
			)
		)
	);

	/** Donors */
	$admin_bar->add_node(
		array(
			'id'     => 'givewp-formfeat-donors',
			'parent' => 'tbex-givewp-formfeat',
			'title'  => esc_attr__( 'Donors', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'edit.php?s&form_id=' . ddw_tbexgive_get_formfeat_id() . '&post_type=give_forms&page=give-donors&view=donors' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => esc_attr__( 'All Donors - User Data', 'toolbar-extras-givewp' ),
			)
		)
	);

	/** Add-On: Recurring Donations (Subscriptions) */
	if ( ddw_tbexgive_is_givewp_recurring_donations_active() ) {

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-formfeat-subscriptions',
				'parent' => 'tbex-givewp-formfeat',
				'title'  => esc_attr__( 'Subscriptions', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-subscriptions&form_id=' . ddw_tbexgive_get_formfeat_id() ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'All Subscriptions - Recurring Donations', 'toolbar-extras-givewp' ),
				)
			)
		);

	}  // end if

	/** Reports */
	if ( current_user_can( 'view_give_reports', ddw_tbexgive_get_formfeat_id() ) ) {

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-formfeat-reports',
				'parent' => 'tbex-givewp-formfeat',
				'title'  => esc_attr__( 'Reports', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-reports&tab=forms&form-id=' . ddw_tbexgive_get_formfeat_id() ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'All Reports - Donation Statistics &amp; Analytics', 'toolbar-extras-givewp' ),
				)
			)
		);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-formfeat-reports-overview',
					'parent' => 'givewp-formfeat-reports',
					'title'  => esc_attr__( 'Overview', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-reports&tab=forms&form-id=' . ddw_tbexgive_get_formfeat_id() ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Overview', 'toolbar-extras-givewp' ),
					)
				)
			);

			/** List all time ranges (per form) */
			foreach ( $give_ranges as $give_range => $give_range_label ) {
			
				$admin_bar->add_node(
					array(
						'id'     => 'givewp-formfeat-reports-' . $give_range,
						'parent' => 'givewp-formfeat-reports',
						'title'  => esc_attr( $give_range_label ),
						'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-reports&tab=forms&form-id=' . ddw_tbexgive_get_formfeat_id() . '&range=' . $give_range ) ),
						'meta'   => array(
							'target' => '',
							'title'  => sprintf(
								/* translators: %s - label of time range, for example "Yesterday" */
								esc_attr__( 'Income %s', 'toolbar-extras-givewp' ),
								$give_range_label
							),
						)
					)
				);

			}  // end foreach

	}  // end if

	/** Edit Form */
	if ( current_user_can( 'edit_give_forms', ddw_tbexgive_get_formfeat_id() ) ) {

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-formfeat-edit',
				'parent' => 'tbex-givewp-formfeat',
				'title'  => esc_attr__( 'Edit Form Campaign', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'post.php?post=' . ddw_tbexgive_get_formfeat_id() . '&action=edit' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Edit Form Campaign', 'toolbar-extras-givewp' ),
				)
			)
		);

	}  // end if

	/** Optional: Frontend View */
	if ( 'enabled' === $give_options[ 'forms_singular' ] ) {

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-formfeat-view',
				'parent' => 'tbex-givewp-formfeat',
				'title'  => esc_attr__( 'View Frontend', 'toolbar-extras-givewp' ),
				'href'   => esc_url( get_permalink( ddw_tbexgive_get_formfeat_id() ) ),
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'View Form on Frontend (Live Preview)', 'toolbar-extras-givewp' ),
				)
			)
		);

	}  // end if

}  // end function
