<?php

// includes/givewp-addons/items-members-permissions

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Check if Members GiveWP Add-On plugin is active or not.
 *
 * @since 1.0.0
 *
 * @return bool TRUE if function exists, FALSE otherwise.
 */
function ddw_tbexgive_is_members_givewp_integration_active() {

	return function_exists( '\Members\Integration\GiveWP\givewp_roles' );

}  // end if


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_members_permissions', 100 );
/**
 * Items for Add-On:
 *   Members - GiveWP Integration (Premium, by Justin Tadlock)
 *   (including its base plugin "Members" by the same author, but free)
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_string_give_permissions_roles()
 * @uses ddw_tbexgive_is_members_givewp_integration_active()
 * @uses ddw_tbex_string_addon_title_attr()
 * @uses \Members\Integration\GiveWP\givewp_roles()
 * @uses ddw_tbexgive_is_givewp_recurring_donations_active()
 * @uses ddw_tbex_display_items_resources()
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_aoitems_members_permissions( $admin_bar ) {

	/** Bail early if no proper permissions */
	if ( ! current_user_can( 'edit_users' ) || ! current_user_can( 'delete_users' ) ) {
		return;
	}

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-permissions',
			'parent' => 'group-donation-options',
			'title'  => ddw_tbexgive_string_give_permissions_roles(),	// esc_attr__( 'Give Permission &amp; Roles', 'toolbar-extras-givewp' ),
			'href'   => ddw_tbexgive_is_members_givewp_integration_active() ? esc_url( admin_url( 'users.php?page=roles&view=group-plugin-givewp' ) ) : esc_url( admin_url( 'users.php?page=roles' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_addon_title_attr( ddw_tbexgive_string_give_permissions_roles() ),
			)
		)
	);

		/** Add group as "virtual hook place" */
		$admin_bar->add_group(
			array(
				'id'     => 'group-givewp-permissions-roles',
				'parent' => 'ao-givewp-permissions',
			)
		);

		$give_roles = array(
			'administrator',
			'give_manager',
			'give_worker',
			'give_accountant',
			'give_donor',
			'give_subscriber',
		);

		$give_role_edit = '#members-tab-type-give_forms';

		if ( ddw_tbexgive_is_members_givewp_integration_active() ) {

			$give_roles     = \Members\Integration\GiveWP\givewp_roles();
			$give_role_edit = '#members-tab-plugin-givewp';

		}  // end if

		if ( $give_roles ) {

			foreach ( $give_roles as $give_role ) {

				if ( ! empty( $give_role ) ) {

					if ( ! ddw_tbexgive_is_givewp_recurring_donations_active() && 'give_subscriber' === $give_role ) {
						continue;
					}

					$give_role_name = translate_user_role( WP_Roles()->roles[ $give_role ][ 'name' ] );

					$admin_bar->add_node(
						array(
							'id'     => 'ao-givewp-permissions-edit-' . $give_role,
							'parent' => 'group-givewp-permissions-roles',
							'title'  => $give_role_name,
							'href'   => esc_url( admin_url( 'users.php?page=roles&action=edit&role=' . $give_role ) ),
							'meta'   => array(
								'target' => '',
								'title'  => esc_attr__( 'Edit Capabilities for this User Role', 'toolbar-extras-givewp' ) . ': ' . $give_role_name,
							)
						)
					);

						$admin_bar->add_node(
							array(
								'id'     => 'ao-givewp-permissions-edit-' . $give_role . '-caps',
								'parent' => 'ao-givewp-permissions-edit-' . $give_role,
								'title'  => esc_attr__( 'Edit Capabilities', 'toolbar-extras-givewp' ),
								'href'   => esc_url( admin_url( 'users.php?page=roles&action=edit&role=' . $give_role . $give_role_edit ) ),
								'meta'   => array(
									'target' => '',
									'title'  => esc_attr__( 'Edit Capabilities for this User Role', 'toolbar-extras-givewp' ) . ': ' . $give_role_name,
								)
							)
						);

						$admin_bar->add_node(
							array(
								'id'     => 'ao-givewp-permissions-edit-' . $give_role . '-users',
								'parent' => 'ao-givewp-permissions-edit-' . $give_role,
								'title'  => esc_attr__( 'List Users', 'toolbar-extras-givewp' ),
								'href'   => esc_url( admin_url( 'users.php?role=' . $give_role ) ),
								'meta'   => array(
									'target' => '',
									'title'  => esc_attr__( 'List all registered Users for this User Role', 'toolbar-extras-givewp' ) . ': ' . $give_role_name,
								)
							)
						);

				}  // end if

			}  // end foreach

		}  // end if roles check

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-permissions-all',
				'parent' => 'ao-givewp-permissions',
				'title'  => esc_attr__( 'All Roles', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'users.php?page=roles' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'All User Roles', 'toolbar-extras-givewp' ),
				)
			)
		);

		$admin_bar->add_node(
			array(
				'id'     => 'ao-givewp-permissions-new',
				'parent' => 'ao-givewp-permissions',
				'title'  => esc_attr__( 'New Role', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'users.php?page=role-new' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'Add New User Role', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-permissions-resources',
					'parent' => 'ao-givewp-permissions',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-permissions-docs',
				'group-givewp-permissions-resources',
				'https://themehybrid.com/plugins/members#faqs'
			);

		}  // end if

}  // end function
