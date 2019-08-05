<?php

// includes/functions-conditionals

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * 1st GROUP: Active checks
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Is the Toolbar Extras plugin active or not?
 *
 * @since 1.0.0
 *
 * @return bool TRUE if plugin is active, FALSE otherwise.
 */
function ddw_tbexgive_is_toolbar_extras_active() {

	return defined( 'TBEX_PLUGIN_VERSION' );

}  // end function


/**
 * Is the Give Donations plugin active or not?
 *
 * @since 1.0.0
 *
 * @return bool TRUE if plugin is active, FALSE otherwise.
 */
function ddw_tbexgive_is_givewp_active() {

	return class_exists( 'Give' );

}  // end function


/**
 * Is the Give Recurring Donations Add-On plugin active or not?
 *
 * @since 1.0.0
 *
 * @return bool TRUE if Add-On plugin is active, FALSE otherwise.
 */
function ddw_tbexgive_is_givewp_recurring_donations_active() {

	return defined( 'GIVE_RECURRING_VERSION' );

}  // end function


/**
 * Is the Give Fee Recovery Add-On plugin active or not?
 *
 * @since 1.0.0
 *
 * @return bool TRUE if Add-On plugin is active, FALSE otherwise.
 */
function ddw_tbexgive_is_givewp_fee_recovery_active() {

	return class_exists( 'Give_Fee_Recovery' );

}  // end function


/**
 * Is the Give Gift Aid Add-On plugin active or not?
 *
 * @since 1.0.0
 *
 * @return bool TRUE if Add-On plugin is active, FALSE otherwise.
 */
function ddw_tbexgive_is_givewp_gift_aid_active() {

	return class_exists( 'Give_Gift_Aid' );

}  // end function


/**
 * Is the Give Tributes Add-On plugin active or not?
 *
 * @since 1.0.0
 *
 * @return bool TRUE if Add-On plugin is active, FALSE otherwise.
 */
function ddw_tbexgive_is_givewp_tributes_active() {

	return class_exists( 'Give_Tributes' );

}  // end function


/**
 * Are the WP HTML Mail & Give Donation - Email Template plugins active or not?
 *
 * @since 1.0.0
 *
 * @return bool TRUE if Add-On plugin is active, FALSE otherwise.
 */
function ddw_tbexgive_is_give_email_template_active() {

	return defined( 'HAET_MAIL_PATH' ) && function_exists( 'wphtmlmail_give_load' );

}  // end function


/**
 * Is the Give Test Mode active or not?
 *
 * @since 1.0.0
 *
 * @return bool TRUE if Give Test Mode is active, FALSE otherwise.
 */
function ddw_tbexgive_is_give_test_mode() {

	return function_exists( 'give_is_test_mode' ) && give_is_test_mode();

}  // end function



/**
 * 2nd GROUP: Settings (Checks)
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Display optional a Featured Form at all or not?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return bool TRUE if setting is on 'yes', FALSE otherwise.
 */
function ddw_tbexgive_display_featured_form() {

	return ( 'yes' === ddw_tbex_get_option( 'givewp', 'formfeat_display' ) );

}  // end function


/**
 * Display value of income for Featured Form?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return bool TRUE if setting is on 'yes', FALSE otherwise.
 */
function ddw_tbexgive_display_featured_form_income() {

	return ( 'yes' === ddw_tbex_get_option( 'givewp', 'formfeat_income' ) );

}  // end function


/**
 * Use our own Test Mode tweaks?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return bool TRUE if setting is on 'yes', FALSE otherwise.
 */
function ddw_tbexgive_testmode_use_tweaks() {

	return ( 'yes' === ddw_tbex_get_option( 'givewp', 'testmode_use_tweaks' ) );

}  // end function



/**
 * 3rd GROUP: Tweaks (Removings etc.)
 * @since 1.0.0
 * -----------------------------------------------------------------------------
 */

/**
 * Tweak: Remove (Toolbar Extras) "Build" group items from the top?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return bool TRUE if tweak should be used (setting 'yes'), FALSE otherwise.
 */
function ddw_tbexgive_use_tweak_tbex_build_group() {

	return ( 'yes' === ddw_tbex_get_option( 'givewp', 'remove_tbex_build_group' ) );

}  // end function


/**
 * Tweak: Unload GiveWP translations?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return bool TRUE if tweak should be used (setting 'yes'), FALSE otherwise.
 */
function ddw_tbexgive_use_tweak_unload_translations_givewp() {

	return ( 'yes' === ddw_tbex_get_option( 'givewp', 'unload_td_givewp' ) );

}  // end function


/**
 * Tweak: Unload Toolbar Extras for GiveWP translations?
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return bool TRUE if tweak should be used (setting 'yes'), FALSE otherwise.
 */
function ddw_tbexgive_use_tweak_unload_translations_tbexgive() {

	return ( 'yes' === ddw_tbex_get_option( 'givewp', 'unload_td_tbexgive' ) );

}  // end function