<?php

// includes/givewp-addons/items-recurring-donations

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_recurring_donations', 100 );
/**
 * Items for Add-On:
 *   Give - Recurring Donations (Premium, by GiveWP/ Impress.org, LLC)
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_string_premium_addon_title_attr()
 * @uses ddw_tbex_display_items_resources()
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_aoitems_recurring_donations( $admin_bar ) {

	/** Use Add-On hook place */
	add_filter( 'tbexgive/filter/is_givewp_addon', '__return_empty_string' );

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-recurringdonations',
			'parent' => 'givewp-addons',
			'title'  => esc_attr__( 'Recurring Donations', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-subscriptions' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_premium_addon_title_attr( __( 'PayPal Pro Payment Gateway', 'toolbar-extras-givewp' ) ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-recurringdonations-subscriptions',
				'parent' => 'ao-givewp-recurringdonations',
				'title'  => esc_attr__( 'Subscriptions', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-subscriptions' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Subscriptions - Recurring Donations Overview', 'toolbar-extras-givewp' ),
				)
			)
		);

		if ( current_user_can( 'view_give_reports' ) ) {

			$admin_bar->add_node(
				array(
					'id'     => 'ao-givewp-recurringdonations-report',
					'parent' => 'ao-givewp-recurringdonations',
					'title'  => esc_attr__( 'Report: Renewal Donations', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-reports&tab=subscriptions' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Report: All Renewal Donations', 'toolbar-extras-givewp' ),
					)
				)
			);

		}  // end if

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-recurringdonations-logs-emails',
				'parent' => 'ao-givewp-recurringdonations',
				'title'  => esc_attr__( 'Logs: Recurring Emails', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-tools&tab=logs&section=recurring_email_notices' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Logs: Recurring Emails', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-recurringdonations-logs-synchronizer',
				'parent' => 'ao-givewp-recurringdonations',
				'title'  => esc_attr__( 'Logs: Synchronizer', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-tools&tab=logs&section=recurring_sync_logs' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Logs: Synchronizer', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-recurringdonations-help',
				'parent' => 'ao-givewp-recurringdonations',
				'title'  => esc_attr__( 'Help Docs', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=recurring' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Help Docs', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-recurringdonations-resources',
					'parent' => 'ao-givewp-recurringdonations',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-recurringdonations-docs',
				'group-givewp-recurringdonations-resources',
				'https://givewp.com/documentation/add-ons/recurring-donations/'
			);

		}  // end if

}  // end function
