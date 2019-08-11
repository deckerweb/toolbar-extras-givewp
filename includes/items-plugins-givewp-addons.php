<?php

// includes/items-plugins-givewp-addons

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * 1st GROUP: Payments, Gateways, Subscriptions, Fees:
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Add-On: Give - Stripe Gateway (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( class_exists( 'Give_Stripe_Premium' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-payments-stripe.php';
}


/**
 * Add-On: Give - PayPal Pro Gateway (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( class_exists( 'Give_PayPal_Gateway' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-payments-paypal-pro.php';
}


/**
 * Add-On: Give - Recurring Donations (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( ddw_tbexgive_is_givewp_recurring_donations_active() ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-recurring-donations.php';
}


/**
 * Plugin: Give - Manual Donations (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( ddw_tbexgive_is_givewp_manual_donations_active() ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-manual-donations.php';
}


/**
 * Add-On: Give - Fee Recovery (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( ddw_tbexgive_is_givewp_fee_recovery_active() ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-fee-recovery.php';
}


/**
 * Add-On: Give - Sofort Payment Gateway (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( defined( 'GIVE_SOFORT_VERSION' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-payments-sofort.php';
}


/**
 * Add-On: Give - Paymill Payment Gateway (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( defined( 'GIVE_PAYMILL_VERSION' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-payments-paymill.php';
}



/**
 * 2nd GROUP: Various things:
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Plugin: Give - PDF Receipts (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( defined( 'GIVE_PDF_PLUGIN_VERSION' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-pdf-receipts.php';
}


/**
 * Plugin: Give - Annual Receipts (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( class_exists( 'Give_Annual_Receipts' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-annual-receipts.php';
}


/**
 * Plugin: Give - Gift Aid (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( ddw_tbexgive_is_givewp_gift_aid_active() ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-gift-aid.php';
}


/**
 * Plugin: Give - Tributes (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( ddw_tbexgive_is_givewp_tributes_active() ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-tributes.php';
}


/**
 * Plugin: Give - Form Field Manager (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( class_exists( 'Give_Form_Fields_Manager' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-form-field-manager.php';
}


/**
 * Plugin: Give - Currency Switcher (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( class_exists( 'Give_Currency_Switcher' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-currency-switcher.php';
}


/**
 * Plugin: Give Donation - Email Template (free, by Hannes Etzelstorfer/ codemiq KG)
 *   (including its base plugin "WP HTML Mail" by the same author)
 * @since 1.0.0
 */
if ( ddw_tbexgive_is_give_email_template_active() ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-email-template.php';
}


/**
 * Plugin: Give - Google Analytics Donation Tracking (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( defined( 'GIVE_GOOGLE_ANALYTICS_VERSION' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-google-analytics.php';
}


/**
 * Plugin: Give - Zapier (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( defined( 'GIVE_ZAPIER_VERSION' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-zapier.php';
}


/**
 * Plugin: Simple Social Shout for GiveWP (free, by Matt Cromwell)
 * @since 1.0.0
 */
if ( class_exists( 'SIMPLE_SOCIAL_SHARE_4_GIVEWP' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-simple-social-shout.php';
}


/**
 * Plugin: Members - GiveWP Integration (Premium, by Justin Tadlock)
 *   (including its base plugin "Members" by the same author, but free)
 * @since 1.0.0
 * @see plugin main file, /toolbar-extras-givewp.php
 */
if ( ddw_tbexgive_is_members_plugin_active() ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-members-permissions.php';
}


/**
 * Plugin: User Role Editor (free, by Vladimir Garagulya)
 * @since 1.0.0
 */
if ( defined( 'URE_VERSION' ) &&  ! ddw_tbexgive_is_members_plugin_active() ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-ure-permissions.php';
}



/**
 * 3rd GROUP: Marketing, Emails:
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Plugin: Give - Mailchimp (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( defined( 'GIVE_MAILCHIMP_VERSION' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-mailchimp.php';
}


/**
 * Plugin: Give - ConvertKit (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( defined( 'GIVE_CONVERTKIT_VERSION' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-convertkit.php';
}


/**
 * Plugin: Give - AWeber (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( defined( 'GIVE_AWEBER_VERSION' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-aweber.php';
}


/**
 * Plugin: Mailchimp for WordPress (free, by ibericode)
 * @since 1.0.0
 */
if ( class_exists( 'MC4WP_Form_Manager' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-mailchimp-for-wp.php';
}


/**
 * Plugin: Give - Constant Contact (Premium, by GiveWP/ Impress.org, LLC)
 * @since 1.0.0
 */
if ( defined( 'GIVE_CONSTANT_CONTACT_VERSION' ) ) {
	require_once TBEXGIVE_PLUGIN_DIR . 'includes/givewp-addons/items-constant-contact.php';
}



/**
 * Conditional Hook Position for Add-Ons
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

add_action( 'admin_bar_menu', 'ddw_tbexgive_givewp_addons_hook_place', 200 );
/**
 * Hook place for Add-On Plugins that provide settings, options, resources.
 *   Only displays conditionally if any of these Add-Ons are active or not.
 *   Controlled via filter 'tbexgive/filter/is_givewp_addon'
 *
 * @since 1.0.0
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_givewp_addons_hook_place( $admin_bar ) {

	if ( has_filter( 'tbexgive/filter/is_givewp_addon' ) ) {

		$admin_bar->add_node(
			array(
				'id'     => 'givewp-addons',
				'parent' => 'group-donation-options',
				'title'  => esc_attr__( 'Add-Ons', 'toolbar-extras-givewp' ),
				'href'   => '',
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Settings from Add-On Plugins', 'toolbar-extras-givewp' )
				)
			)
		);

	}  // end if

}  // end function
