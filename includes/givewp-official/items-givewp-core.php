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

		}  // end if

	/** Action Hook: After Give Donations (Transactions) */
	do_action( 'tbexgive/givewp_donations/after' );


	/** 2) Donors */
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

		}  // end if

	/** Action Hook: After Give Donations Donors */
	do_action( 'tbexgive/givewp_donors/after' );


	/** Add-On: Recurring Donations (Subscriptions) */
	if ( ddw_tbexgive_is_givewp_recurring_donations_active() ) {

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
	if ( ! current_user_can( 'manage_give_settings' ) ) {
		return;
	}

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


add_action( 'admin_bar_menu', 'ddw_tbexgive_items_givewp_core_resources', 99 );
/**
 * Give Donations external resources items
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_display_items_resources()
 * @uses ddw_tbexgive_string_give_resources()
 * @uses ddw_tbex_get_resource_url()
 * @uses ddw_tbex_meta_rel()
 * @uses ddw_tbex_meta_target()
 * @uses ddw_tbex_resource_item()
 * @uses ddw_tbexgive_string_givewp()
 *
 * @param object $admin_bar Holds all nodes of the Toolbar.
 */
function ddw_tbexgive_items_givewp_core_resources( $admin_bar ) {

	/** Bail early if resources display is disabled */
	if ( ! ddw_tbex_display_items_resources() ) {
		return;
	}

	$admin_bar->add_node(
		array(
			'id'     => 'givewp-resources',
			'parent' => 'group-donation-resources',
			'title'  => ddw_tbexgive_string_give_resources(),
			'href'   => ddw_tbex_get_resource_url( 'givewp', 'url_docs' ),
			'meta'   => array(
				'rel'    => ddw_tbex_meta_rel(),
				'target' => ddw_tbex_meta_target(),
				'title'  => ddw_tbexgive_string_give_resources(),
			)
		)
	);

		ddw_tbex_resource_item(
			'documentation',
			'givewp-resources-docs',
			'givewp-resources',
			ddw_tbex_get_resource_url( 'givewp', 'url_docs' )
		);

		ddw_tbex_resource_item(
			'tutorials',
			'givewp-resources-tutorials',
			'givewp-resources',
			ddw_tbex_get_resource_url( 'givewp', 'url_tutorials' ),
			sprintf(
				/* translators: %s - Word "Give" */
				esc_attr__( 'Getting Started - Learn %s Tutorials', 'toolbar-extras-givewp' ),
				ddw_tbexgive_string_givewp()
			)
		);

		ddw_tbex_resource_item(
			'youtube-channel',
			'givewp-resources-youtube',
			'givewp-resources',
			ddw_tbex_get_resource_url( 'givewp', 'url_videos' )
		);

		ddw_tbex_resource_item(
			'support-contact',
			'givewp-resources-support-contact',
			'givewp-resources',
			ddw_tbex_get_resource_url( 'givewp', 'url_support_contact' )
		);

		ddw_tbex_resource_item(
			'official-blog',
			'givewp-resources-blog',
			'givewp-resources',
			ddw_tbex_get_resource_url( 'givewp', 'url_blog' )
		);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-resources-bugs-features',
				'parent' => 'givewp-resources',
				'title'  => esc_attr__( 'Bug Reports &amp; Feature Requests', 'toolbar-extras-givewp' ),
				'href'   => ddw_tbex_get_resource_url( 'givewp', 'url_github_issues' ),
				'meta'   => array(
					'rel'    => ddw_tbex_meta_rel(),
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Bug Reports &amp; Feature Requests via GitHub Issues', 'toolbar-extras-givewp' ),
				)
			)
		);

		ddw_tbex_resource_item(
			'my-account',
			'givewp-resources-account-portal',
			'givewp-resources',
			ddw_tbex_get_resource_url( 'givewp', 'url_myaccount' )
		);

		/** Developer documentation */
		if ( ddw_tbex_display_items_dev_mode() && current_user_can( 'manage_options' ) ) {

			ddw_tbex_resource_item(
				'documentation-dev',
				'givewp-resources-developer-docs',
				'givewp-resources',
				ddw_tbex_get_resource_url( 'givewp', 'url_docs_developer' )
			);

			$admin_bar->add_node(
				array(
					'id'     => 'givewp-resources-snippet-library',
					'parent' => 'givewp-resources',
					'title'  => esc_attr__( 'Snippet Library', 'toolbar-extras-givewp' ),
					'href'   => ddw_tbex_get_resource_url( 'givewp', 'url_snippet_library' ),
					'meta'   => array(
						'rel'    => ddw_tbex_meta_rel(),
						'target' => ddw_tbex_meta_target(),
						'title'  => esc_attr__( 'Snippet Library for Customizing Give Donations', 'toolbar-extras-givewp' ),
					)
				)
			);

		}  // end if

	/** Action Hook: After Give Donations Resources */
	do_action( 'tbexgive/givewp_resources/after' );

	$admin_bar->add_node(
		array(
			'id'     => 'givewp-community',
			'parent' => 'group-donation-resources',
			'title'  => ddw_tbexgive_string_give_community(),
			'href'   => ddw_tbex_get_resource_url( 'givewp', 'url_fb_group' ),
			'meta'   => array(
				'rel'    => ddw_tbex_meta_rel(),
				'target' => ddw_tbex_meta_target(),
				'title'  => ddw_tbexgive_string_give_community(),
			)
		)
	);

		ddw_tbex_resource_item(
			'facebook-group',
			'givewp-community-fbgroup',
			'givewp-community',
			ddw_tbex_get_resource_url( 'givewp', 'url_fb_group' )
		);

		ddw_tbex_resource_item(
			'translations-community',
			'givewp-community-translations',
			'givewp-community',
			ddw_tbex_get_resource_url( 'givewp', 'url_translations' )
		);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-community-give-stories',
				'parent' => 'givewp-community',
				'title'  => esc_attr__( 'Give Stories', 'toolbar-extras-givewp' ),
				'href'   => ddw_tbex_get_resource_url( 'givewp', 'url_give_stories' ),
				'meta'   => array(
					'rel'    => ddw_tbex_meta_rel(),
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Give Stories', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-community-giving-tuesday',
				'parent' => 'givewp-community',
				'title'  => esc_attr__( 'Giving Tuesday', 'toolbar-extras-givewp' ),
				'href'   => ddw_tbex_get_resource_url( 'givewp', 'url_giving_tuesday' ),
				'meta'   => array(
					'rel'    => ddw_tbex_meta_rel(),
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Giving Tuesday', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-community-nonprofit-101',
				'parent' => 'givewp-community',
				'title'  => esc_attr__( 'Nonprofit 101', 'toolbar-extras-givewp' ),
				'href'   => ddw_tbex_get_resource_url( 'givewp', 'url_nonprofit_101' ),
				'meta'   => array(
					'rel'    => ddw_tbex_meta_rel(),
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Nonprofit 101', 'toolbar-extras-givewp' ),
				)
			)
		);

}  // end function


add_action( 'admin_bar_menu', 'ddw_tbexgive_items_givewp_about', 30 );
/**
 * "About" items for Give Donations, under WP Logo Group.
 *
 * @since 1.0.0
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_items_givewp_about( $admin_bar ) {

	$admin_bar->add_node(
		array(
			'id'     => 'givewp-about',
			'parent' => 'wp-logo',
			'title'  => esc_attr__( 'About Give Donations', 'toolbar-extras-givewp' ),
			'href'   => esc_url( admin_url( 'index.php?page=give-getting-started' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => esc_attr__( 'About Give Donations - Getting Started', 'toolbar-extras-givewp' ),
			)
		)
	);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-about-getting-started',
				'parent' => 'givewp-about',
				'title'  => esc_attr__( 'Getting Started', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'index.php?page=give-getting-started' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Getting Started with Give Donations', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-about-getting-started',
				'parent' => 'givewp-about',
				'title'  => esc_attr__( 'Getting Started', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'index.php?page=give-getting-started' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Getting Started with Give Donations', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-about-whats-new',
				'parent' => 'givewp-about',
				'title'  => esc_attr__( 'What\'s New', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'index.php?page=give-changelog' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'What\'s New - Changelog', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-about-credits',
				'parent' => 'givewp-about',
				'title'  => esc_attr__( 'Credits &amp; Contributors', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'index.php?page=give-credits' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Credits &amp; Contributors', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-about-translations',
				'parent' => 'givewp-about',
				'title'  => esc_attr__( 'Translations', 'toolbar-extras-givewp' ),
				'href'   => ddw_tbex_get_resource_url( 'givewp', 'url_translations' ),
				'meta'   => array(
					'target' => ddw_tbex_meta_target(),
					'title'  => esc_attr__( 'Help Translate Give Donations Plugin', 'toolbar-extras-givewp' ),
				)
			)
		);

}  // end function


add_filter( 'admin_bar_menu', 'ddw_tbexgive_items_new_content_give_form', 100 );
/**
 * Item for New Content Group: New Give Form (Campaign)
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_display_items_new_content()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_items_new_content_give_form( $admin_bar ) {

	/** Bail early if items display is not wanted */
	if ( ! ddw_tbex_display_items_new_content() ) {
		return;
	}

	$admin_bar->add_node(
		array(
			'id'     => 'new-give_forms',		// same as original!
			//'parent' => 'givewp-about',
			'title'  => esc_attr__( 'Give Donation Form', 'toolbar-extras-givewp' ),
			//'href'   => esc_url( admin_url( 'index.php?page=give-credits' ) ),
			'meta'   => array(
				'title'  => esc_attr__( 'Give Donation Form/ Campaign', 'toolbar-extras-givewp' ),
			)
		)
	);

}  // end if


add_action( 'admin_bar_menu', 'ddw_tbexgive_user_items_give_roles', 15 );
/**
 * User items for Plugin: GiveWP
 *
 * @since 1.0.0
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_user_items_give_roles( $admin_bar ) {

	/** Optional: Give Manager Users (GiveWP) */
	$give_manager = get_users( array( 'role' => 'give_manager' ) );

	if ( ! empty( $give_manager ) ) {

		$admin_bar->add_node(
			array(
				'id'     => 'user-give-manager',
				'parent' => 'group-tbex-users',
				'title'  => ddw_tbex_item_title_with_icon( esc_attr__( 'Donation Managers', 'toolbar-extras-givewp' ) ),
				'href'   => esc_url( admin_url( 'users.php?role=give_manager' ) ),
				'meta'   => array(
					'class'  => 'tbex-users',
					'target' => '',
					'title'  => esc_attr__( 'Give Donation Managers', 'toolbar-extras-givewp' )
				)
			)
		);

	}  // end if

	/** Optional: Give Worker Users (GiveWP) */
	$give_worker = get_users( array( 'role' => 'give_worker' ) );

	if ( ! empty( $give_worker ) ) {

		$admin_bar->add_node(
			array(
				'id'     => 'user-give-worker',
				'parent' => 'group-tbex-users',
				'title'  => ddw_tbex_item_title_with_icon( esc_attr__( 'Donation Workers', 'toolbar-extras-givewp' ) ),
				'href'   => esc_url( admin_url( 'users.php?role=give_worker' ) ),
				'meta'   => array(
					'class'  => 'tbex-users',
					'target' => '',
					'title'  => esc_attr__( 'Give Donation Workers', 'toolbar-extras-givewp' )
				)
			)
		);

	}  // end if

	/** Optional: Give Accountant Users (GiveWP) */
	$give_accountant = get_users( array( 'role' => 'give_accountant' ) );

	if ( ! empty( $give_accountant ) ) {

		$admin_bar->add_node(
			array(
				'id'     => 'user-give-accountant',
				'parent' => 'group-tbex-users',
				'title'  => ddw_tbex_item_title_with_icon( esc_attr__( 'Donation Accountants', 'toolbar-extras-givewp' ) ),
				'href'   => esc_url( admin_url( 'users.php?role=give_accountant' ) ),
				'meta'   => array(
					'class'  => 'tbex-users',
					'target' => '',
					'title'  => esc_attr__( 'Give Donation Accountants', 'toolbar-extras-givewp' )
				)
			)
		);

	}  // end if

	/** Optional: Give Donor Users (GiveWP) */
	$give_donor = get_users( array( 'role' => 'give_donor' ) );

	if ( ! empty( $give_donor ) ) {

		$admin_bar->add_node(
			array(
				'id'     => 'user-give-donors',
				'parent' => 'group-tbex-users',
				'title'  => ddw_tbex_item_title_with_icon( esc_attr__( 'Donors', 'toolbar-extras-givewp' ) ),
				'href'   => esc_url( admin_url( 'users.php?role=give_donor' ) ),
				'meta'   => array(
					'class'  => 'tbex-users',
					'target' => '',
					'title'  => esc_attr__( 'Give Donors', 'toolbar-extras-givewp' )
				)
			)
		);

	}  // end if

}  // end function
