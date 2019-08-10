<?php

// includes/string-switcher

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Allow for string switching of the "Give" label.
 *
 * @since 1.0.0
 *
 * @uses get_option()
 *
 * @return string String of Give label, filterable, with default fallback.
 */
function ddw_tbexgive_string_givewp() {

	$give = __( 'Give', 'toolbar-extras-givewp' );

	return esc_attr(
		apply_filters(
			'tbexgive/filter/string/givewp',
			get_option( 'tbex-options-givewp', $give )[ 'givewp_name' ]
		)
	);

}  // end function


/**
 * Build "Give" Donations string.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_string_givewp()
 *
 * @return string Filterable and translateable string for "Give" Donations.
 */
function ddw_tbexgive_string_give_donations() {

	return esc_attr(
		apply_filters(
			'tbexgive/filter/string/give_donations',
			sprintf(
				/* translators: %s - Word Give */
				__( '%s Donations', 'toolbar-extras-givewp' ),
				ddw_tbexgive_string_givewp()
			)
		)
	);

}  // end function


/**
 * Build "Give" Resources string.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_string_givewp()
 *
 * @return string Filterable and translateable string for "Give" Resources.
 */
function ddw_tbexgive_string_give_resources() {

	return esc_attr(
		apply_filters(
			'tbexgive/filter/string/give_resources',
			sprintf(
				/* translators: %s - Word Give */
				__( '%s Resources', 'toolbar-extras-givewp' ),
				ddw_tbexgive_string_givewp()
			)
		)
	);

}  // end function


/**
 * Build "Give" Community string.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_string_givewp()
 *
 * @return string Filterable and translateable string for "Give" Community.
 */
function ddw_tbexgive_string_give_community() {

	return esc_attr(
		apply_filters(
			'tbexgive/filter/string/give_community',
			sprintf(
				/* translators: %s - Word Give */
				__( '%s Community', 'toolbar-extras-givewp' ),
				ddw_tbexgive_string_givewp()
			)
		)
	);

}  // end function


/**
 * Build "Give" Settings string.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_string_givewp()
 *
 * @return string Filterable and translateable string for "Give" Settings.
 */
function ddw_tbexgive_string_give_settings() {

	return esc_attr(
		apply_filters(
			'tbexgive/filter/string/give_settings',
			sprintf(
				/* translators: %s - Word Give */
				__( '%s Settings', 'toolbar-extras-givewp' ),
				ddw_tbexgive_string_givewp()
			)
		)
	);

}  // end function


/**
 * Build "Give" Tools string.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_string_givewp()
 *
 * @return string Filterable and translateable string for "Give" Tools.
 */
function ddw_tbexgive_string_give_tools() {

	return esc_attr(
		apply_filters(
			'tbexgive/filter/string/give_tools',
			sprintf(
				/* translators: %s - Word Give */
				__( '%s Tools', 'toolbar-extras-givewp' ),
				ddw_tbexgive_string_givewp()
			)
		)
	);

}  // end function


/**
 * Build "Give" Updates string.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_string_givewp()
 *
 * @return string Filterable and translateable string for "Give" Updates.
 */
function ddw_tbexgive_string_give_updates() {

	return esc_attr(
		apply_filters(
			'tbexgive/filter/string/give_updates',
			sprintf(
				/* translators: %s - Word Give */
				__( '%s Updates', 'toolbar-extras-givewp' ),
				ddw_tbexgive_string_givewp()
			)
		)
	);

}  // end function


/**
 * Build "Give" Permissions & Roles string.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_string_givewp()
 *
 * @return string Filterable and translateable string for "Give" Permissions & Roles.
 */
function ddw_tbexgive_string_give_permissions_roles() {

	return esc_attr(
		apply_filters(
			'tbexgive/filter/string/give_permission_roles',
			sprintf(
				/* translators: %s - Word Give */
				__( '%s Permissions &amp; Roles', 'toolbar-extras-givewp' ),
				ddw_tbexgive_string_givewp()
			)
		)
	);

}  // end function
