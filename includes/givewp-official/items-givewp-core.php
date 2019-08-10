<?php

// includes/givewp-official/items-givewp-core

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_items_givewp_core', 99 );
/**
 * Give Donations items for "Donations", "Donors", "Reports" and
 *   "Campaigns/ Forms".
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_is_givewp_manual_donations_active()
 * @uses ddw_tbexgive_is_givewp_recurring_donations_active()
 * @uses ddw_tbex_is_btcplugin_active()
 * @uses ddw_btc_string_template()
 * @uses ddw_tbexgive_get_report_ranges()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_items_givewp_core( $admin_bar ) {

	/** Set post type */
	$type = 'give_forms';

	/** Set post type arguments for WP_Query */
	$givewp_posttype_args = array(
		'post_type'      => $type,
		'posts_per_page' => -1,
	);

	/** Query GiveWP Forms (Campaigns) */
	$give_forms = get_posts( $givewp_posttype_args );

	/** Get Give Options from DB */
	$give_options = get_option( 'give_settings' );


	/** 1) Donations - Payment History */
	if ( current_user_can( 'edit_give_payments' ) ) {

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-donations',
				'parent' => 'group-donation-campaigns',
				'title'  => esc_attr__( 'Donation Transactions', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-payment-history' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Donation Transactions - Payment History', 'toolbar-extras-givewp' ),
				)
			)
		);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-donations-all',
					'parent' => 'givewp-donations',
					'title'  => esc_attr__( 'All Donations', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-payment-history' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'All Donations', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-donations-abandoned',
					'parent' => 'givewp-donations',
					'title'  => esc_attr__( 'Abandoned Donations', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-payment-history&status=abandoned' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Abandoned Donations', 'toolbar-extras-givewp' ),
					)
				)
			);

			/** Add-On: Add Manual Donation */
			if ( ddw_tbexgive_is_givewp_manual_donations_active() ) {

				$admin_bar->add_node(
					array(
						'id'     => 'givewp-donations-add-manual-donation',
						'parent' => 'givewp-donations',
						'title'  => esc_attr__( 'Add Manual Donation', 'toolbar-extras-givewp' ),
						'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-manual-donation' ) ),
						'meta'   => array(
							'target' => '',
							'title'  => esc_attr__( 'Add new Manual Donation Payment', 'toolbar-extras-givewp' ),
						)
					)
				);

			}  // end if

			if ( current_user_can( 'manage_give_settings' ) ) {

				$admin_bar->add_node(
					array(
						'id'     => 'givewp-donations-import',
						'parent' => 'givewp-donations',
						'title'  => esc_attr__( 'Import Donations', 'toolbar-extras-givewp' ),
						'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-tools&tab=import&importer-type=import_donations' ) ),
						'meta'   => array(
							'target' => '',
							'title'  => esc_attr__( 'Import Donations from CSV File', 'toolbar-extras-givewp' ),
						)
					)
				);

			}  // end if

			/**
			 * Donations per Form/ Campaign.
			 *   Proceed only if there are any Forms/ Campaigns.
			 */
			if ( $give_forms ) {

				/** Add group */
				$admin_bar->add_group(
					array(
						'id'     => 'group-givewp-donations-forms',
						'parent' => 'givewp-donations',
					)
				);

					$admin_bar->add_node(
						array(
							'id'     => 'givewp-donations-per-form',
							'parent' => 'group-givewp-donations-forms',
							'title'  => '<em>' . esc_attr__( 'List Donations per Form', 'toolbar-extras-givewp' ) . ':</em>',
							'href'   => FALSE,
							'meta'   => array(
								'target' => '',
								'title'  => esc_attr__( 'List all Donations per Form Campaign', 'toolbar-extras-givewp' ),
							)
						)
					);

					foreach ( $give_forms as $give_form ) {

						$form_title = esc_attr( $give_form->post_title );
						$form_id    = (int) $give_form->ID;

						$admin_bar->add_node(
							array(
								'id'     => 'givewp-donations-per-form-' . $form_id,
								'parent' => 'group-givewp-donations-forms',
								'title'  => '&nbsp;&bull; ' . $form_title,
								'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-payment-history&form_id=' . $form_id ) ),
								'meta'   => array(
									'target' => '',
									'title'  => esc_attr__( 'All Donors for Form Campaign', 'toolbar-extras-givewp' ) . ': ' . $form_title,
								)
							)
						);

					}  // end foreach

			}  // end if (forms check)

	}  // end if (permission check)

	/** Action Hook: After Give Donations (Transactions) */
	do_action( 'tbexgive/givewp_donations/after' );


	/** 2) Donors */
	if ( current_user_can( 'view_give_reports' ) ) {

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-donors',
				'parent' => 'group-donation-campaigns',
				'title'  => esc_attr__( 'Donors', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-donors' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'All Donors - User Data', 'toolbar-extras-givewp' ),
				)
			)
		);

			/** Donors as Give donor pages */
			$admin_bar->add_node(
				array(
					'id'     => 'givewp-donors-all',
					'parent' => 'givewp-donors',
					'title'  => esc_attr__( 'All Donors', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-donors' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'All Donors for any Campaign - User Data', 'toolbar-extras-givewp' ),
					)
				)
			);

			/** Donors as WP user accounts */
			if ( current_user_can( 'edit_users' ) && current_user_can( 'delete_users' ) ) {

				$give_donors = get_users( array( 'role' => 'give_donor' ) );

				if ( ! empty( $give_donors ) ) {

					$admin_bar->add_node(
						array(
							'id'     => 'givewp-donors-wpaccounts',
							'parent' => 'givewp-donors',
							'title'  => esc_attr__( 'Donor Users (WP)', 'toolbar-extras-givewp' ),
							'href'   => esc_url( admin_url( 'users.php?role=give_donor' ) ),
							'meta'   => array(
								'target' => '',
								'title'  => esc_attr__( 'All Give Donors - WordPress User Accounts', 'toolbar-extras-givewp' ),
							)
						)
					);

				}  // end if

			}  // end if

			/**
			 * Donors per Form/ Campaign.
			 *   Proceed only if there are any Forms/ Campaigns.
			 */
			if ( $give_forms ) {

				/** Add group */
				$admin_bar->add_group(
					array(
						'id'     => 'group-givewp-donors-forms',
						'parent' => 'givewp-donors',
					)
				);

					$admin_bar->add_node(
						array(
							'id'     => 'givewp-donors-per-form',
							'parent' => 'group-givewp-donors-forms',
							'title'  => '<em>' . esc_attr__( 'List Donors per Form', 'toolbar-extras-givewp' ) . ':</em>',
							'href'   => FALSE,
							'meta'   => array(
								'target' => '',
								'title'  => esc_attr__( 'List all Donors per Form Campaign', 'toolbar-extras-givewp' ),
							)
						)
					);

					foreach ( $give_forms as $give_form ) {

						$form_title = esc_attr( $give_form->post_title );
						$form_id    = (int) $give_form->ID;

						$admin_bar->add_node(
							array(
								'id'     => 'givewp-donors-per-form-' . $form_id,
								'parent' => 'group-givewp-donors-forms',
								'title'  => '&nbsp;&bull; ' . $form_title,
								'href'   => esc_url( admin_url( 'edit.php?s&form_id=' . $form_id . '&post_type=' . $type . '&page=give-donors&view=donors' ) ),
								'meta'   => array(
									'target' => '',
									'title'  => esc_attr__( 'All Donors for Form Campaign', 'toolbar-extras-givewp' ) . ': ' . $form_title,
								)
							)
						);

					}  // end foreach

			}  // end if (forms check)

	}  // end if (permission check)

	/** Action Hook: After Give Donations Donors */
	do_action( 'tbexgive/givewp_donors/after' );


	/** Add-On: Recurring Donations (Subscriptions) */
	if ( ddw_tbexgive_is_givewp_recurring_donations_active() && current_user_can( 'view_give_reports' ) ) {

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-subscriptions',
				'parent' => 'group-donation-campaigns',
				'title'  => esc_attr__( 'Subscriptions', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-subscriptions' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'All Subscriptions - Recurring Donations', 'toolbar-extras-givewp' ),
				)
			)
		);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-subscriptions-all',
					'parent' => 'givewp-subscriptions',
					'title'  => esc_attr__( 'All Subscriptions', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-subscriptions' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'All Subscriptions - Recurring Donations Overview', 'toolbar-extras-givewp' ),
					)
				)
			);

			/**
			 * Subscriptions per Form/ Campaign.
			 *   Proceed only if there are any Forms/ Campaigns.
			 */
			if ( $give_forms ) {

				/** Add group */
				$admin_bar->add_group(
					array(
						'id'     => 'group-givewp-subscriptions-forms',
						'parent' => 'givewp-subscriptions',
					)
				);

					$admin_bar->add_node(
						array(
							'id'     => 'givewp-subscriptions-per-form',
							'parent' => 'group-givewp-subscriptions-forms',
							'title'  => '<em>' . esc_attr__( 'List Subscriptions per Form', 'toolbar-extras-givewp' ) . ':</em>',
							'href'   => FALSE,
							'meta'   => array(
								'target' => '',
								'title'  => esc_attr__( 'View all Subscriptions per Form Campaign', 'toolbar-extras-givewp' ),
							)
						)
					);

					foreach ( $give_forms as $give_form ) {

						$form_title = esc_attr( $give_form->post_title );
						$form_id    = (int) $give_form->ID;

						$admin_bar->add_node(
							array(
								'id'     => 'givewp-subscriptions-per-form-' . $form_id,
								'parent' => 'group-givewp-subscriptions-forms',
								'title'  => '&nbsp;&bull; ' . $form_title,
								'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-subscriptions&form_id=' . $form_id ) ),
								'meta'   => array(
									'target' => '',
									'title'  => esc_attr__( 'All Subscriptions for Form Campaign', 'toolbar-extras-givewp' ) . ': ' . $form_title,
								)
							)
						);

					}  // end foreach

			}  // end if

	}  // end if


	/** 3) Reports */
	if ( current_user_can( 'view_give_reports' ) ) {

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-reports',
				'parent' => 'group-donation-campaigns',
				'title'  => esc_attr__( 'Reports', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'All Reports - Donation Statistics &amp; Analytics', 'toolbar-extras-givewp' ),
				)
			)
		);

			$give_ranges__test = array(
				'today'        => _x( 'Today', 'Time range for filtering', 'toolbar-extras-givewp' ),
				'yesterday'    => _x( 'Yesterday', 'Time range for filtering', 'toolbar-extras-givewp' ),
				'this_week'    => _x( 'This Week', 'Time range for filtering', 'toolbar-extras-givewp' ),
				'last_week'    => _x( 'Last Week', 'Time range for filtering', 'toolbar-extras-givewp' ),
				'this_month'   => _x( 'This Month', 'Time range for filtering', 'toolbar-extras-givewp' ),
				'last_month'   => _x( 'Last Month', 'Time range for filtering', 'toolbar-extras-givewp' ),
				'this_quarter' => _x( 'This Quarter', 'Time range for filtering', 'toolbar-extras-givewp' ),
				'last_quarter' => _x( 'Last Quarter', 'Time range for filtering', 'toolbar-extras-givewp' ),
				'this_year'    => _x( 'This Year', 'Time range for filtering', 'toolbar-extras-givewp' ),
				'last_year'    => _x( 'Last Year', 'Time range for filtering', 'toolbar-extras-givewp' ),
			);

			$give_ranges = ddw_tbexgive_get_report_ranges();

			/** Income (earnings) */
			$admin_bar->add_node(
				array(
					'id'     => 'givewp-reports-income',
					'parent' => 'givewp-reports',
					'title'  => esc_attr__( 'Income', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=earnings' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Income - Earnings', 'toolbar-extras-givewp' ),
					)
				)
			);

				$admin_bar->add_node(
					array(
						'id'     => 'givewp-reports-income-overview',
						'parent' => 'givewp-reports-income',
						'title'  => esc_attr__( 'Overview', 'toolbar-extras-givewp' ),
						'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=earnings' ) ),
						'meta'   => array(
							'target' => '',
							'title'  => esc_attr__( 'Overview', 'toolbar-extras-givewp' ),
						)
					)
				);

				/** List all time ranges (global) */
				foreach ( $give_ranges as $give_range => $give_range_label ) {
				
					$admin_bar->add_node(
						array(
							'id'     => 'givewp-reports-income-' . $give_range,
							'parent' => 'givewp-reports-income',
							'title'  => esc_attr( $give_range_label ),
							'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=earnings&view=earnings&form-id=0&range=' . $give_range ) ),
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

			/** Add-On: Recurring Donations */
			if ( ddw_tbexgive_is_givewp_recurring_donations_active() ) {

				/** Renewal Donations */
				$admin_bar->add_node(
					array(
						'id'     => 'givewp-reports-renewaldonations',
						'parent' => 'givewp-reports',
						'title'  => esc_attr__( 'Renewal Donations', 'toolbar-extras-givewp' ),
						'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=subscriptions' ) ),
						'meta'   => array(
							'target' => '',
							'title'  => esc_attr__( 'All Renewal Donations', 'toolbar-extras-givewp' ),
						)
					)
				);

					$admin_bar->add_node(
						array(
							'id'     => 'givewp-reports-renewaldonations-overview',
							'parent' => 'givewp-reports-renewaldonations',
							'title'  => esc_attr__( 'Overview', 'toolbar-extras-givewp' ),
							'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=subscriptions' ) ),
							'meta'   => array(
								'target' => '',
								'title'  => esc_attr__( 'Overview', 'toolbar-extras-givewp' ),
							)
						)
					);

					/** List all time ranges (global) */
					foreach ( $give_ranges as $give_range => $give_range_label ) {
					
						$admin_bar->add_node(
							array(
								'id'     => 'givewp-reports-renewaldonations-' . $give_range,
								'parent' => 'givewp-reports-renewaldonations',
								'title'  => esc_attr( $give_range_label ),
								'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=subscriptions&range=' . $give_range ) ),
								'meta'   => array(
									'target' => '',
									'title'  => sprintf(
										/* translators: %s - label of time range, for example "Yesterday" */
										esc_attr__( 'Renewal Donations %s', 'toolbar-extras-givewp' ),
										$give_range_label
									),
								)
							)
						);

					}  // end foreach

			}  // end if

			/** Donation Methods */
			$admin_bar->add_node(
				array(
					'id'     => 'givewp-reports-donation-methods',
					'parent' => 'givewp-reports',
					'title'  => esc_attr__( 'Donation Methods', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=gateways' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Donation Methods - Payment Gateways', 'toolbar-extras-givewp' ),
					)
				)
			);

			/** Forms/ Campaigns */
			$admin_bar->add_node(
				array(
					'id'     => 'givewp-reports-forms',
					'parent' => 'givewp-reports',
					'title'  => esc_attr__( 'All Forms', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=forms' ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'All Forms Overview - Per Form Reports', 'toolbar-extras-givewp' ),
					)
				)
			);

			/** Add-On: Fee Recovery */
			if ( ddw_tbexgive_is_givewp_fee_recovery_active() ) {

				/** Fee Income */
				$admin_bar->add_node(
					array(
						'id'     => 'givewp-reports-feeincome',
						'parent' => 'givewp-reports',
						'title'  => esc_attr__( 'Fee Recovery: Income', 'toolbar-extras-givewp' ),
						'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=fee&section=give-fee-income' ) ),
						'meta'   => array(
							'target' => '',
							'title'  => esc_attr__( 'Fee Recovery: Income Reports', 'toolbar-extras-givewp' ),
						)
					)
				);

					$admin_bar->add_node(
						array(
							'id'     => 'givewp-reports-feeincome-overview',
							'parent' => 'givewp-reports-feeincome',
							'title'  => esc_attr__( 'Overview', 'toolbar-extras-givewp' ),
							'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=fee&section=give-fee-income' ) ),
							'meta'   => array(
								'target' => '',
								'title'  => esc_attr__( 'Overview', 'toolbar-extras-givewp' ),
							)
						)
					);

					/** List all time ranges (global) */
					foreach ( $give_ranges as $give_range => $give_range_label ) {
					
						$admin_bar->add_node(
							array(
								'id'     => 'givewp-reports-feeincome-' . $give_range,
								'parent' => 'givewp-reports-feeincome',
								'title'  => esc_attr( $give_range_label ),
								'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=fee&section=give-fee-income&range=' . $give_range ) ),
								'meta'   => array(
									'target' => '',
									'title'  => sprintf(
										/* translators: %s - label of time range, for example "Yesterday" */
										esc_attr__( 'Fee Recovery Income %s', 'toolbar-extras-givewp' ),
										$give_range_label
									),
								)
							)
						);

					}  // end foreach

				/** Fee Conversion */
				$admin_bar->add_node(
					array(
						'id'     => 'givewp-reports-feeconversion',
						'parent' => 'givewp-reports',
						'title'  => esc_attr__( 'Fee Recovery: Conversion', 'toolbar-extras-givewp' ),
						'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=fee&section=give-fee-conversion' ) ),
						'meta'   => array(
							'target' => '',
							'title'  => esc_attr__( 'Fee Recovery: Conversion Reports', 'toolbar-extras-givewp' ),
						)
					)
				);

					$admin_bar->add_node(
						array(
							'id'     => 'givewp-reports-feeconversion-overview',
							'parent' => 'givewp-reports-feeconversion',
							'title'  => esc_attr__( 'Overview', 'toolbar-extras-givewp' ),
							'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=fee&section=give-fee-conversion' ) ),
							'meta'   => array(
								'target' => '',
								'title'  => esc_attr__( 'Overview', 'toolbar-extras-givewp' ),
							)
						)
					);

					/** List all time ranges (global) */
					foreach ( $give_ranges as $give_range => $give_range_label ) {
					
						$admin_bar->add_node(
							array(
								'id'     => 'givewp-reports-feeconversion-' . $give_range,
								'parent' => 'givewp-reports-feeconversion',
								'title'  => esc_attr( $give_range_label ),
								'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=fee&section=give-fee-conversion&range=' . $give_range ) ),
								'meta'   => array(
									'target' => '',
									'title'  => sprintf(
										/* translators: %s - label of time range, for example "Yesterday" */
										esc_attr__( 'Fee Recovery Conversion %s', 'toolbar-extras-givewp' ),
										$give_range_label
									),
								)
							)
						);

					}  // end foreach

			}  // end if

			/** Add-On: Gift Aid */
			if ( ddw_tbexgive_is_givewp_gift_aid_active() ) {

				/** Gift Aid Donations */
				$admin_bar->add_node(
					array(
						'id'     => 'givewp-reports-giftaid',
						'parent' => 'givewp-reports',
						'title'  => esc_attr__( 'Gift Aid Donations', 'toolbar-extras-givewp' ),
						'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=gift-aid' ) ),
						'meta'   => array(
							'target' => '',
							'title'  => esc_attr__( 'All Gift Aid Donations', 'toolbar-extras-givewp' ),
						)
					)
				);

			}  // end if

			/** Add-On: Tributes */
			if ( ddw_tbexgive_is_givewp_tributes_active() ) {

				$admin_bar->add_node(
					array(
						'id'     => 'givewp-reports-tributes',
						'parent' => 'givewp-reports',
						'title'  => esc_attr__( 'Tributes', 'toolbar-extras-givewp' ),
						'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-reports&tab=tributes&section=give-tributes-donations' ) ),
						'meta'   => array(
							'target' => '',
							'title'  => esc_attr__( 'All Tributes related Reports', 'toolbar-extras-givewp' ),
						)
					)
				);

					/** Tribute Donations */
					$admin_bar->add_node(
						array(
							'id'     => 'givewp-reports-tributes-donations',
							'parent' => 'givewp-reports-tributes',
							'title'  => esc_attr__( 'Tribute Donations', 'toolbar-extras-givewp' ),
							'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-reports&tab=tributes&section=give-tributes-donations' ) ),
							'meta'   => array(
								'target' => '',
								'title'  => esc_attr__( 'All Tribute Donations', 'toolbar-extras-givewp' ),
							)
						)
					);

					/** Mail a Card */
					$admin_bar->add_node(
						array(
							'id'     => 'givewp-reports-tributes-mailacard',
							'parent' => 'givewp-reports-tributes',
							'title'  => esc_attr__( 'Mail a Card', 'toolbar-extras-givewp' ),
							'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-reports&tab=tributes&section=give-tributes-mail-card' ) ),
							'meta'   => array(
								'target' => '',
								'title'  => esc_attr__( 'Mail a Card', 'toolbar-extras-givewp' ),
							)
						)
					);

					/** eCards */
					$admin_bar->add_node(
						array(
							'id'     => 'givewp-reports-tributes-ecards',
							'parent' => 'givewp-reports-tributes',
							'title'  => esc_attr__( 'eCards', 'toolbar-extras-givewp' ),
							'href'   => esc_url( admin_url( 'edit.php?post_type=give_forms&page=give-reports&tab=tributes&section=give-tributes-ecard' ) ),
							'meta'   => array(
								'target' => '',
								'title'  => esc_attr__( 'eCards', 'toolbar-extras-givewp' ),
							)
						)
					);

			}  // end if

			/**
			 * Reports per Form/ Campaign.
			 *   Proceed only if there are any Forms/ Campaigns.
			 */
			if ( $give_forms ) {

				/** Add group */
				$admin_bar->add_group(
					array(
						'id'     => 'group-givewp-reports-forms',
						'parent' => 'givewp-reports',
					)
				);

					$admin_bar->add_node(
						array(
							'id'     => 'givewp-reports-per-form',
							'parent' => 'group-givewp-reports-forms',
							'title'  => '<em>' . esc_attr__( 'List Reports per Form', 'toolbar-extras-givewp' ) . ':</em>',
							'href'   => FALSE,
							'meta'   => array(
								'target' => '',
								'title'  => esc_attr__( 'View full Reports per Form Campaign', 'toolbar-extras-givewp' ),
							)
						)
					);

					foreach ( $give_forms as $give_form ) {

						$form_title = esc_attr( $give_form->post_title );
						$form_id    = (int) $give_form->ID;

						if ( current_user_can( 'view_give_reports', $form_id ) ) {

							$admin_bar->add_node(
								array(
									'id'     => 'givewp-reports-per-form-' . $form_id,
									'parent' => 'group-givewp-reports-forms',
									'title'  => '&nbsp;&bull; ' . $form_title,
									'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=forms&form-id=' . $form_id ) ),
									'meta'   => array(
										'target' => '',
										'title'  => esc_attr__( 'Full Report for Form Campaign', 'toolbar-extras-givewp' ) . ': ' . $form_title,
									)
								)
							);

								$admin_bar->add_node(
									array(
										'id'     => 'givewp-reports-per-form-' . $form_id . '-overview',
										'parent' => 'givewp-reports-per-form-' . $form_id,
										'title'  => esc_attr__( 'Overview', 'toolbar-extras-givewp' ),
										'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=forms&form-id=' . $form_id ) ),
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
											'id'     => 'givewp-reports-per-form-' . $form_id . '-' . $give_range,
											'parent' => 'givewp-reports-per-form-' . $form_id,
											'title'  => esc_attr( $give_range_label ),
											'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=forms&form-id=' . $form_id . '&range=' . $give_range ) ),
											'meta'   => array(
												'target' => '',
												'title'  => sprintf(
													/* translators: %s - label of time range, for example "Yesterday" */
													esc_attr__( 'Income %s for', 'toolbar-extras-givewp' ),
													$give_range_label
												) . ': ' . $form_title,
											)
										)
									);

								}  // end foreach (Income ranges)

						}  // end if (permission check per form ID)

					}  // end foreach (Forms listing)

			}  // end if (forms check)

	}  // end if (permission check)

	/** Action Hook: After Give Donations Reports */
	do_action( 'tbexgive/givewp_reports/after' );


	/** 4) Forms - Campaigns */
	$admin_bar->add_node(
		array(
			'id'     => 'givewp-campaigns',
			'parent' => 'group-donation-campaigns',
			'title'  => esc_attr__( 'Campaigns (Forms)', 'toolbar-extras-givewp' ),
			'href'   => current_user_can( 'edit_give_forms' ) ? esc_url( admin_url( 'edit.php?post_type=' . $type ) ) : FALSE,
			'meta'   => array(
				'target' => '',
				'title'  => esc_attr__( 'Campaigns - Donation Forms', 'toolbar-extras-givewp' ),
			)
		)
	);

		if ( current_user_can( 'edit_give_forms' ) ) {

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-campaigns-all',
					'parent' => 'givewp-campaigns',
					'title'  => esc_attr__( 'All Donation Forms', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'All Donation Forms', 'toolbar-extras-givewp' ),
					)
				)
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-campaigns-new',
					'parent' => 'givewp-campaigns',
					'title'  => esc_attr__( 'New Donation Form', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'post-new.php?post_type=' . $type ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'New Donation Form', 'toolbar-extras-givewp' ),
					)
				)
			);

			/** Taxonomy: Categories */
			if ( 'enabled' === $give_options[ 'categories' ] ) {

				$admin_bar->add_node(
					array(
						'id'     => 'givewp-campaigns-categories',
						'parent' => 'givewp-campaigns',
						'title'  => esc_attr__( 'Campaign Categories', 'toolbar-extras-givewp' ),
						'href'   => esc_url( admin_url( 'edit-tags.php?taxonomy=give_forms_category&post_type=' . $type ) ),
						'meta'   => array(
							'target' => '',
							'title'  => esc_attr__( 'Campaign Categories', 'toolbar-extras-givewp' ),
						)
					)
				);

			}  // end if

			/** Taxonomy: Tags */
			if ( 'enabled' === $give_options[ 'tags' ] ) {

				$admin_bar->add_node(
					array(
						'id'     => 'givewp-campaigns-tags',
						'parent' => 'givewp-campaigns',
						'title'  => esc_attr__( 'Campaign Tags', 'toolbar-extras-givewp' ),
						'href'   => esc_url( admin_url( 'edit-tags.php?taxonomy=give_forms_tag&post_type=' . $type ) ),
						'meta'   => array(
							'target' => '',
							'title'  => esc_attr__( 'Campaign Tags', 'toolbar-extras-givewp' ),
						)
					)
				);

			}  // end if

			/** Form categories, via BTC plugin */
			if ( ddw_tbex_is_btcplugin_active() ) {

				$admin_bar->add_node(
					array(
						'id'     => 'givewp-campaigns-btc-categories',
						'parent' => 'givewp-campaigns',
						'title'  => ddw_btc_string_template( 'template' ),
						'href'   => esc_url( admin_url( 'edit-tags.php?taxonomy=builder-template-category&post_type=' . $type ) ),
						'meta'   => array(
							'target' => '',
							'title'  => esc_html( ddw_btc_string_template( 'template' ) ),
						)
					)
				);

			}  // end if

			/** For: Manage Content */
			$admin_bar->add_node(
				array(
					'id'     => 'manage-content-give-forms',
					'parent' => 'manage-content',
					'title'  => esc_attr__( 'Edit Donation Forms', 'toolbar-extras-givewp' ),
					'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type ) ),
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Edit Give Donation Forms', 'toolbar-extras-givewp' ),
					)
				)
			);

			/** Per Campaign/ Form Goal */
			$admin_bar->add_node(
				array(
					'id'     => 'givewp-campaigns-goals',
					'parent' => 'givewp-campaigns',
					'title'  => esc_attr__( 'Filter Per Goal', 'toolbar-extras-givewp' ),
					'href'   => FALSE,
					'meta'   => array(
						'target' => '',
						'title'  => esc_attr__( 'Filter Per Campaign Goal', 'toolbar-extras-givewp' ),
					)
				)
			);

				$admin_bar->add_node(
					array(
						'id'     => 'givewp-campaigns-goals-achieved',
						'parent' => 'givewp-campaigns-goals',
						'title'  => esc_attr__( 'Goal Achieved', 'toolbar-extras-givewp' ),
						'href'   => esc_url( admin_url( 'edit.php?s&post_status=all&post_type=' . $type . '&give-forms-goal-filter=goal_achieved' ) ),
						'meta'   => array(
							'target' => '',
							'title'  => esc_attr__( 'Campaign Goal Achieved', 'toolbar-extras-givewp' ),
						)
					)
				);

				$admin_bar->add_node(
					array(
						'id'     => 'givewp-campaigns-goals-in-progress',
						'parent' => 'givewp-campaigns-goals',
						'title'  => esc_attr__( 'Goal In Progress', 'toolbar-extras-givewp' ),
						'href'   => esc_url( admin_url( 'edit.php?s&post_status=all&post_type=' . $type . '&give-forms-goal-filter=goal_in_progress' ) ),
						'meta'   => array(
							'target' => '',
							'title'  => esc_attr__( 'Campaign Goal In Progress', 'toolbar-extras-givewp' ),
						)
					)
				);

				$admin_bar->add_node(
					array(
						'id'     => 'givewp-campaigns-goals-not-set',
						'parent' => 'givewp-campaigns-goals',
						'title'  => esc_attr__( 'Goal Not Set', 'toolbar-extras-givewp' ),
						'href'   => esc_url( admin_url( 'edit.php?s&post_status=all&post_type=' . $type . '&give-forms-goal-filter=goal_not_set' ) ),
						'meta'   => array(
							'target' => '',
							'title'  => esc_attr__( 'Campaign Goal Not Set', 'toolbar-extras-givewp' ),
						)
					)
				);

				$admin_bar->add_node(
					array(
						'id'     => 'givewp-campaigns-goals-any-status',
						'parent' => 'givewp-campaigns-goals',
						'title'  => esc_attr__( 'Any Goal Status', 'toolbar-extras-givewp' ),
						'href'   => esc_url( admin_url( 'edit.php?s&post_status=all&post_type=' . $type . '&give-forms-goal-filter=any_goal_status' ) ),
						'meta'   => array(
							'target' => '',
							'title'  => esc_attr__( 'Any Campaign Goal Status', 'toolbar-extras-givewp' ),
						)
					)
				);

		}  // end if (permission check)

		/**
		 * List individual Forms/ Campaigns.
		 *   Proceed only if there are any Forms/ Campaigns.
		 */
		if ( $give_forms ) {

			/** Add group */
			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-forms',
					'parent' => 'givewp-campaigns',
				)
			);

				foreach ( $give_forms as $give_form ) {

					$form_title = esc_attr( $give_form->post_title );
					$form_id    = (int) $give_form->ID;

					$admin_bar->add_node(
						array(
							'id'     => 'givewp-edit-forms-' . $form_id,
							'parent' => 'group-givewp-forms',
							'title'  => $form_title,
							'href'   => current_user_can( 'edit_give_forms', $form_id ) ? esc_url( admin_url( 'post.php?post=' . $form_id . '&action=edit' ) ) : FALSE,
							'meta'   => array(
								'target' => '',
								'title'  => esc_attr__( 'Edit Form', 'toolbar-extras-givewp' ) . ': ' . $form_title,
							)
						)
					);

						/** Edit Form/ Campaign */
						if ( current_user_can( 'edit_give_forms', $form_id ) ) {

							$admin_bar->add_node(
								array(
									'id'     => 'givewp-edit-forms-' . $form_id . '-edit',
									'parent' => 'givewp-edit-forms-' . $form_id,
									'title'  => esc_attr__( 'Edit Form', 'toolbar-extras-givewp' ),
									'href'   => esc_url( admin_url( 'post.php?post=' . $form_id . '&action=edit' ) ),
									'meta'   => array(
										'target' => '',
										'title'  => esc_attr__( 'Edit Form in Campaign Form Builder', 'toolbar-extras-givewp' ),
									)
								)
							);

						}  // end if

						/** Optional: Frontend View */
						if ( 'enabled' === $give_options[ 'forms_singular' ] ) {

							$admin_bar->add_node(
								array(
									'id'     => 'givewp-edit-forms-' . $form_id . '-view',
									'parent' => 'givewp-edit-forms-' . $form_id,
									'title'  => esc_attr__( 'View Frontend', 'toolbar-extras-givewp' ),
									'href'   => esc_url( get_permalink( $form_id ) ),
									'meta'   => array(
										'target' => ddw_tbex_meta_target(),
										'title'  => esc_attr__( 'View Form on Frontend (Live Preview)', 'toolbar-extras-givewp' ),
									)
								)
							);

						}  // end if

						/** Donations for Form/ Campaign */
						$admin_bar->add_node(
							array(
								'id'     => 'givewp-edit-forms-' . $form_id . '-donations',
								'parent' => 'givewp-edit-forms-' . $form_id,
								'title'  => esc_attr__( 'Donations for this Form', 'toolbar-extras-givewp' ),
								'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-payment-history&form_id=' . $form_id ) ),
								'meta'   => array(
									'target' => '',
									'title'  => esc_attr__( 'Donations for this specific Form', 'toolbar-extras-givewp' ),
								)
							)
						);

						/** Donors for Form/ Campaign */
						$admin_bar->add_node(
							array(
								'id'     => 'givewp-edit-forms-' . $form_id . '-donors',
								'parent' => 'givewp-edit-forms-' . $form_id,
								'title'  => esc_attr__( 'Donors for this Form', 'toolbar-extras-givewp' ),
								'href'   => esc_url( admin_url( 'edit.php?s&form_id=' . $form_id . '&post_type=' . $type . '&page=give-donors&view=donors' ) ),
								'meta'   => array(
									'target' => '',
									'title'  => esc_attr__( 'Donors for this specific Form', 'toolbar-extras-givewp' ),
								)
							)
						);

						/** Optional: Subscriptions for Form/ Campaign (Add-On) */
						if ( ddw_tbexgive_is_givewp_recurring_donations_active() ) {

							$admin_bar->add_node(
								array(
									'id'     => 'givewp-edit-forms-' . $form_id . '-subscriptions',
									'parent' => 'givewp-edit-forms-' . $form_id,
									'title'  => esc_attr__( 'Subscriptions for this Form', 'toolbar-extras-givewp' ),
									'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-subscriptions&form_id=' . $form_id ) ),
									'meta'   => array(
										'target' => '',
										'title'  => esc_attr__( 'Subscriptions for this specific Form', 'toolbar-extras-givewp' ),
									)
								)
							);

						}  // end if

						/** Reports for Form/ Campaign */
						$admin_bar->add_node(
							array(
								'id'     => 'givewp-edit-forms-' . $form_id . '-reports',
								'parent' => 'givewp-edit-forms-' . $form_id,
								'title'  => esc_attr__( 'Reports for this Form', 'toolbar-extras-givewp' ),
								'href'   => esc_url( admin_url( 'edit.php?post_type=' . $type . '&page=give-reports&tab=forms&form-id=' . $form_id ) ),
								'meta'   => array(
									'target' => '',
									'title'  => esc_attr__( 'Reports for this specific Form', 'toolbar-extras-givewp' ),
								)
							)
						);

				}  // end foreach (Forms listing)

		}  // end if

	/** Action Hook: After Give Donations Campaigns */
	do_action( 'tbexgive/givewp_campaigns/after' );

}  // end function


/**
 * Load GiveWP special Pages items
 * @since 1.0.0
 */
if ( current_user_can( 'edit_pages' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-official/items-givewp-pages.php';
}


/**
 * Load GiveWP Settings & Tools items
 * @since 1.0.0
 */
if ( current_user_can( 'manage_give_settings' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-official/items-givewp-settings.php';
}


/**
 * Load GiveWP Resources items
 * @since 1.0.0
 */
if ( ddw_tbex_display_items_resources() ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-official/items-givewp-resources.php';
}


/**
 * Load GiveWP About items
 * @since 1.0.0
 */
if ( current_user_can( 'manage_options' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-official/items-givewp-about.php';
}


/**
 * Load GiveWP New Content items
 * @since 1.0.0
 */
if ( ddw_tbex_display_items_new_content() && ! is_network_admin() ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-official/items-givewp-new-content.php';
}


/**
 * Load GiveWP User Roles items
 * @since 1.0.0
 */
if ( current_user_can( 'edit_users' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-official/items-givewp-user-roles.php';
}
