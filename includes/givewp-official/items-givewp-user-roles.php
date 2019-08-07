<?php

// includes/givewp-official/items-givewp-user-roles

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


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
