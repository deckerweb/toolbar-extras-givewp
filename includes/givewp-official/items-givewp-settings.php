<?php

// includes/givewp-official/items-givewp-settings

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_items_givewp_options', 99 );
/**
 * Give Donations items for "Settings", "Tools" and "Updates".
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_string_give_settings()
 * @uses ddw_tbexgive_string_give_tools()
 * @uses ddw_tbexgive_string_give_updates()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_items_givewp_options( $admin_bar ) {

	/** Bail early if no proper permissions */
	/*
	if ( ! current_user_can( 'manage_give_settings' ) ) {
		return;
	}
	*/

	$type = 'give_forms';

	/** 1) Give Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'givewp-settings',
			'parent' => 'group-donation-options',
			'title'  => ddw_tbexgive_string_give_settings(),
			'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbexgive_string_give_settings(),
			)
		)
	);

		/** Tab: General */
		$admin_bar->add_node(
			array(
				'id'     => 'givewp-settings-general',
				'parent' => 'givewp-settings',
				'title'  => esc_attr__( 'General', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=general' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'General', 'toolbar-extras-givewp' ),
				)
			)
		);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-general-settings',
					'parent' => 'givewp-settings-general',
					'title'  => esc_attr__( 'General Settings', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=general&section=general-settings' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'General Settings', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-general-currency',
					'parent' => 'givewp-settings-general',
					'title'  => esc_attr__( 'Currency Settings', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=general&section=currency-settings' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Currency Settings', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-general-access-control',
					'parent' => 'givewp-settings-general',
					'title'  => esc_attr__( 'Access Control', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=general&section=access-control' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Access Control Settings', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-general-sequential-ordering',
					'parent' => 'givewp-settings-general',
					'title'  => esc_attr__( 'Sequential Ordering', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=general&section=sequential-ordering' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Sequential Ordering Settings', 'toolbar-extras-givewp' ),
					)
				)
			);

		/** Tab: Payment Gateways */
		$admin_bar->add_node(
			array(
				'id'     => 'givewp-settings-payment-gateways',
				'parent' => 'givewp-settings',
				'title'  => esc_attr__( 'Payment Gateways', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=gateways' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Payment Gateways', 'toolbar-extras-givewp' ),
				)
			)
		);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-payment-gateways-settings',
					'parent' => 'givewp-settings-payment-gateways',
					'title'  => esc_attr__( 'Gateways Settings', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=gateways&section=gateways-settings' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Gateways Settings', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-payment-gateways-paypal-standard',
					'parent' => 'givewp-settings-payment-gateways',
					'title'  => esc_attr__( 'PayPal Standard', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=gateways&section=paypal-standard' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'PayPal Standard Settings', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-payment-gateways-offline-donations',
					'parent' => 'givewp-settings-payment-gateways',
					'title'  => esc_attr__( 'Offline Donations', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=gateways&section=offline-donations' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Offline Donations Settings', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-payment-gateways-stripe',
					'parent' => 'givewp-settings-payment-gateways',
					'title'  => esc_attr__( 'Stripe Settings', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=gateways&section=stripe-settings' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Stripe Settings', 'toolbar-extras-givewp' ),
					)
				)
			);

			/** Group: Stripe Add-On */
			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-settings-payment-addons-stripe',
					'parent' => 'givewp-settings-payment-gateways',
				)
			);

			/** Group: PayPal Pro Add-On */
			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-settings-payment-addons-paypalpro',
					'parent' => 'givewp-settings-payment-gateways',
				)
			);

			/** Group: Misc. Add-Ons */
			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-settings-payment-addons-misc',
					'parent' => 'givewp-settings-payment-gateways',
				)
			);

		/** Tab: Display Options */
		$admin_bar->add_node(
			array(
				'id'     => 'givewp-settings-display',
				'parent' => 'givewp-settings',
				'title'  => esc_attr__( 'Display Options', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=display' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Display Options', 'toolbar-extras-givewp' ),
				)
			)
		);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-display-settings',
					'parent' => 'givewp-settings-display',
					'title'  => esc_attr__( 'Display Settings', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=display&section=display-settings' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Display Settings', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-display-post-types',
					'parent' => 'givewp-settings-display',
					'title'  => esc_attr__( 'Post Types', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=display&section=post-types' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Post Types', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-display-taxonomies',
					'parent' => 'givewp-settings-display',
					'title'  => esc_attr__( 'Taxonomies', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=display&section=taxonomies' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Taxonomies', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-display-terms-conditions',
					'parent' => 'givewp-settings-display',
					'title'  => esc_attr__( 'Terms and Conditions', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=display&section=term-and-conditions' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Terms and Conditions', 'toolbar-extras-givewp' ),
					)
				)
			);

		/** Tab: Emails */
		$admin_bar->add_node(
			array(
				'id'     => 'givewp-settings-emails',
				'parent' => 'givewp-settings',
				'title'  => esc_attr__( 'Emails', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=emails' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Edit and Customize Email Templates', 'toolbar-extras-givewp' ),
				)
			)
		);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-emails-donors',
					'parent' => 'givewp-settings-emails',
					'title'  => esc_attr__( 'Donor Emails', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=emails&section=donor-email' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Edit and Customize Donor Emails', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-emails-admin',
					'parent' => 'givewp-settings-emails',
					'title'  => esc_attr__( 'Admin Emails', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=emails&section=admin-email' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Edit and Customize Admin Emails', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-emails-settings',
					'parent' => 'givewp-settings-emails',
					'title'  => esc_attr__( 'Email Settings', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=emails&section=email-settings' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Email Settings', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-emails-contact',
					'parent' => 'givewp-settings-emails',
					'title'  => esc_attr__( 'Contact Information', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=emails&section=contact' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Contact Information', 'toolbar-extras-givewp' ),
					)
				)
			);


		/** Tab: Advanced */
		$admin_bar->add_node(
			array(
				'id'     => 'givewp-settings-advanced',
				'parent' => 'givewp-settings',
				'title'  => esc_attr__( 'Advanced', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=advanced' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Advanced Settings', 'toolbar-extras-givewp' ),
				)
			)
		);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-advanced-options',
					'parent' => 'givewp-settings-advanced',
					'title'  => esc_attr__( 'Advanced Options', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=advanced&section=advanced-options' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Advanced Options', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-advanced-stripe',
					'parent' => 'givewp-settings-advanced',
					'title'  => esc_attr__( 'Stripe', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=advanced&section=stripe' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Stripe', 'toolbar-extras-givewp' ),
					)
				)
			);

		/** Tab: Licenses */
		$admin_bar->add_node(
			array(
				'id'     => 'givewp-settings-licenses',
				'parent' => 'givewp-settings',
				'title'  => esc_attr__( 'Licenses', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=licenses' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Licenses', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** via TBEX: Toolbar settings */
		if ( current_user_can( 'manage_options' ) ) {

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-settings-tbex-toolbar',
					'parent' => 'givewp-settings',
					'title'  => esc_attr__( 'Toolbar Options', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'options-general.php?page=toolbar-extras&tab=givewp' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Toolbar Options and Tweaks', 'toolbar-extras-givewp' ),
					)
				)
			);

		}  // end if


	/** 2) Give Tools */
	$admin_bar->add_node(
		array(
			'id'     => 'givewp-tools',
			'parent' => 'group-donation-options',
			'title'  => ddw_tbexgive_string_give_tools(),
			'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-tools' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbexgive_string_give_tools(),
			)
		)
	);

		/** Tab: Export */
		$admin_bar->add_node(
			array(
				'id'     => 'givewp-tools-export',
				'parent' => 'givewp-tools',
				'title'  => esc_attr__( 'Export', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-tools&tab=export' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Export', 'toolbar-extras-givewp' ),
				)
			)
		);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-tools-export-tasks',
					'parent' => 'givewp-tools-export',
					'title'  => esc_attr__( 'All Tasks', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-tools&tab=export' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'All Export Tasks', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-tools-export-donation-history-csv',
					'parent' => 'givewp-tools-export',
					'title'  => esc_attr__( 'Donation History as CSV', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-tools&type=export_donations' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Export Donation History as CSV File', 'toolbar-extras-givewp' ),
					)
				)
			);

			$give_pdf_url = add_query_arg(
				array( 'give-action' => 'generate_pdf' ),
				admin_url( 'edit.php?post_type=' . $type . '&page=give-tools' )
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-tools-export-donations-income-pdf',
					'parent' => 'givewp-tools-export',
					'title'  => esc_attr__( 'Donations &amp; Income as PDF', 'toolbar-extras-givewp' ),
					'href'   => wp_nonce_url( $give_pdf_url, 'give_generate_pdf' ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Export Donations and Income as PDF File', 'toolbar-extras-givewp' ),
					)
				)
			);

		/** Tab: Import */
		$admin_bar->add_node(
			array(
				'id'     => 'givewp-tools-import',
				'parent' => 'givewp-tools',
				'title'  => esc_attr__( 'Import', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-tools&tab=import' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Import', 'toolbar-extras-givewp' ),
				)
			)
		);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-tools-import-donations',
					'parent' => 'givewp-tools-import',
					'title'  => esc_attr__( 'Import Donations', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-tools&tab=import&importer-type=import_donations' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Import Donations from CSV File', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-tools-import-settings',
					'parent' => 'givewp-tools-import',
					'title'  => esc_attr__( 'Import Give Settings', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-tools&tab=import&importer-type=import_core_setting' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Import Give Settings from JSON File', 'toolbar-extras-givewp' ),
					)
				)
			);

		/** Tab: Logs */
		$admin_bar->add_node(
			array(
				'id'     => 'givewp-tools-logs',
				'parent' => 'givewp-tools',
				'title'  => esc_attr__( 'Logs', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-tools&tab=logs' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Logs', 'toolbar-extras-givewp' ),
				)
			)
		);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-tools-logs-payment-errors',
					'parent' => 'givewp-tools-logs',
					'title'  => esc_attr__( 'Payment Errors', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-tools&tab=logs&section=gateway_errors' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Logs of Payment Gateway Errors', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-tools-logs-api-requests',
					'parent' => 'givewp-tools-logs',
					'title'  => esc_attr__( 'API Requests', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-tools&tab=logs&section=api_requests' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Logs of API Requests', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-tools-logs-updates',
					'parent' => 'givewp-tools-logs',
					'title'  => esc_attr__( 'Updates', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-tools&tab=logs&section=updates' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Logs of Updates', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-tools-logs-stripe',
					'parent' => 'givewp-tools-logs',
					'title'  => esc_attr__( 'Stripe', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-tools&tab=logs&section=stripe' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Logs of Stripe Payment Gateway', 'toolbar-extras-givewp' ),
					)
				)
			);

		/** Tab: API */
		$admin_bar->add_node(
			array(
				'id'     => 'givewp-tools-api',
				'parent' => 'givewp-tools',
				'title'  => esc_attr__( 'Generate API Keys', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-tools&tab=api' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Generate API Keys', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** Tab: Data */
		$admin_bar->add_node(
			array(
				'id'     => 'givewp-tools-data',
				'parent' => 'givewp-tools',
				'title'  => esc_attr__( 'Data Tools', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-tools&tab=data' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Data Tools (Recounts etc.)', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** Tab: System Info */
		$admin_bar->add_node(
			array(
				'id'     => 'givewp-tools-system-info',
				'parent' => 'givewp-tools',
				'title'  => esc_attr__( 'System Info', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-tools&tab=system-info' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Get System Report for Support and Debugging', 'toolbar-extras-givewp' ),
				)
			)
		);


	/** 3) Give Updates */
	$admin_bar->add_node(
		array(
			'id'     => 'givewp-updates',
			'parent' => 'group-donation-options',
			'title'  => ddw_tbexgive_string_give_updates(),
			'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-updates' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbexgive_string_give_updates(),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-updates-listing',
				'parent' => 'givewp-updates',
				'title'  => esc_attr__( 'Updates', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-updates' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'List of available Add-On Updates', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-updates-run',
				'parent' => 'givewp-updates',
				'title'  => esc_attr__( 'Run Updates', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'plugins.php?plugin_status=give' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Run Add-On Updates Now', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-updates-logs',
				'parent' => 'givewp-updates',
				'title'  => esc_attr__( 'Update Logs', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-tools&tab=logs&section=updates' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Update Logs', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-updates-licenses',
				'parent' => 'givewp-updates',
				'title'  => esc_attr__( 'Add-On Licenses', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-settings&tab=licenses' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Add-On Licenses', 'toolbar-extras-givewp' ),
				)
			)
		);

}  // end function
