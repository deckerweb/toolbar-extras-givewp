<?php

// includes/items-donations

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_items_givewp_donations', ddw_tbexgive_donations_item_priority() );
/**
 * Add main item for "Donations", for Give Donations plugin
 *   (free, by GiveWP/ Impress.org, LLC).
 *
 * @since 1.0.0
 *
 * @see plugin file /includes/tbexgive-styles.php
 *
 * @uses ddw_tbex_get_option()
 * @uses ddw_tbexgive_id_donations_item()
 * @uses ddw_tbex_item_title_with_settings_icon()
 * @uses ddw_tbexgive_string_givewp()
 * @uses ddw_tbex_meta_rel()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_items_givewp_donations( $admin_bar ) {

	/** Prepare */
	$use_icon = ddw_tbex_get_option( 'givewp', 'donations_tl_use_icon' );

	$class = '';
	$label = esc_attr( ddw_tbex_get_option( 'givewp', 'donations_tl_name' ) );
	$title = $label;

	/** Build icon & title together */
	if ( 'givewp' === $use_icon ) {

		$class = 'tbex-node-givewp-logo';

		$title = sprintf(
			'<span class="dashicons-before ab-icon tbex-settings-icon tbexgive-givewp-logo"></span><span class="ab-label">%1$s</span>',
			$label
		);

	} elseif ( 'dashicon' === $use_icon ) {

		$class = 'tbex-node-givewp-dashicon';
		$title = ddw_tbex_item_title_with_settings_icon( $label, 'givewp', 'donations_tl_icon' );

	}  // end if

	/** Build title attribute */
	$title_attr = sprintf(
		/* translators: 1 - label for "Give" / 2 - label for "Donations" */
		esc_attr__( '%1$s %2$s Management', 'toolbar-extras-givewp' ),
		ddw_tbexgive_string_givewp(),
		$label
	);

	/** Set Donations URL */
	$donations_url = ddw_tbex_get_option( 'givewp', 'donations_tl_url' );
	$donations_url = ( ! empty( $donations_url ) ) ? $donations_url : admin_url( 'edit.php?post_type=give_forms&page=give-payment-history' );

	/** Get link target */
	$link_target = ddw_tbex_get_option( 'givewp', 'donations_tl_target' );

	$admin_bar->add_node(
		array(
			'id'     => ddw_tbexgive_id_donations_item(),
			'title'  => $title,
			'href'   => esc_url( $donations_url ),
			'meta'   => array(
				'class'  => $class,
				'target' => sanitize_key( $link_target ),
				'rel'    => ddw_tbex_meta_rel(),
				'title'  => $title_attr,
			)
		)
	);

}  // end function


/** Set toolbar groups as base hook places */
add_action( 'admin_bar_menu', 'ddw_tbexgive_donation_items_base_groups', 99 );
/**
 * Set base groups for our Toolbar main item as "hook places".
 *   Set additional action hooks to enable custom groups.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_id_donations_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_donation_items_base_groups( $admin_bar ) {

	/** Group: Donation Campaigns (Transactions, Reports, Forms/ Campaigns) */
	$admin_bar->add_group(
		array(
			'id'     => 'group-donation-campaigns',
			'parent' => ddw_tbexgive_id_donations_item(),
		)
	);

	do_action( 'tbexgive/donation_campaigns/after_group' );

	/** Group: Donation Options (Settings, Tools, Add-Ons) */
	$admin_bar->add_group(
		array(
			'id'     => 'group-donation-options',
			'parent' => ddw_tbexgive_id_donations_item(),
		)
	);

	do_action( 'tbexgive/donation_options/after_group' );

	/** Group: Donation Resources */
	$admin_bar->add_group(
		array(
			'id'     => 'group-donation-resources',
			'parent' => ddw_tbexgive_id_donations_item(),
			'meta'   => array( 'class' => 'ab-sub-secondary' ),
		)
	);

	do_action( 'tbexgive/donation_resources/after_group' );

}  // end function
