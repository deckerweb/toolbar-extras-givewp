<?php

// includes/givewp-addons/items-ure-permissions

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_tbexgive_aoitems_ure_permissions', 100 );
/**
 * Items for Add-On: User Role Editor (free, by Vladimir Garagulya)
 *
 * @since 1.0.0
 *
 * @uses ddw_tbexgive_string_give_permissions_roles()
 * @uses ddw_tbex_string_addon_title_attr()
 * @uses ddw_tbexgive_is_givewp_recurring_donations_active()
 * @uses ddw_tbex_display_items_resources()
 * @uses ddw_tbex_resource_item()
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_tbexgive_aoitems_ure_permissions( $admin_bar ) {

	/** Bail early if no proper permissions */
	if ( ! current_user_can( 'edit_users' ) || ! current_user_can( 'delete_users' ) ) {
		return;
	}

	/** Plugin's Settings */
	$admin_bar->add_node(
		array(
			'id'     => 'ao-givewp-urepermissions',
			'parent' => 'group-donation-options',
			'title'  => ddw_tbexgive_string_give_permissions_roles(),
			'href'   => esc_url( admin_url( 'users.php?page=users-user-role-editor.php' ) ),
			'meta'   => array(
				'target' => '',
				'title'  => ddw_tbex_string_addon_title_attr( ddw_tbexgive_string_give_permissions_roles() ),
			)
		)
	);

		/** Add group as "virtual hook place" */
		$admin_bar->add_group(
			array(
				'id'     => 'group-givewp-urepermissions-roles',
				'parent' => 'ao-givewp-urepermissions',
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

		if ( $give_roles ) {

			foreach ( $give_roles as $give_role ) {

				if ( ! empty( $give_role ) && ! is_null( get_role( $give_role ) ) ) {

					if ( ! ddw_tbexgive_is_givewp_recurring_donations_active() && 'give_subscriber' === $give_role ) {
						continue;
					}

					$give_role_name = translate_user_role( WP_Roles()->roles[ $give_role ][ 'name' ] );

					$admin_bar->add_node(
						array(
							'id'     => 'ao-givewp-urepermissions-edit-' . $give_role,
							'parent' => 'group-givewp-urepermissions-roles',
							'title'  => $give_role_name,
							'href'   => esc_url( admin_url( 'users.php?page=users-user-role-editor.php&user_role=' . $give_role ) ),
							'meta'   => array(
								'target' => '',
								'title'  => esc_attr__( 'Edit Capabilities for this User Role', 'toolbar-extras-givewp' ) . ': ' . $give_role_name,
							)
						)
					);

						$admin_bar->add_node(
							array(
								'id'     => 'ao-givewp-urepermissions-edit-' . $give_role . '-caps',
								'parent' => 'ao-givewp-urepermissions-edit-' . $give_role,
								'title'  => esc_attr__( 'Edit Capabilities', 'toolbar-extras-givewp' ),
								'href'   => esc_url( admin_url( 'users.php?page=users-user-role-editor.php&user_role=' . $give_role ) ),
								'meta'   => array(
									'target' => '',
									'title'  => esc_attr__( 'Edit Capabilities for this User Role', 'toolbar-extras-givewp' ) . ': ' . $give_role_name,
								)
							)
						);

						$admin_bar->add_node(
							array(
								'id'     => 'ao-givewp-urepermissions-edit-' . $give_role . '-users',
								'parent' => 'ao-givewp-urepermissions-edit-' . $give_role,
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
				'id'     => 'ao-givewp-urepermissions-settings',
				'parent' => 'ao-givewp-urepermissions',
				'title'  => esc_attr__( 'User Role Editor Settings', 'toolbar-extras-givewp' ),
				'href'   => esc_url( admin_url( 'options-general.php?page=settings-user-role-editor.php' ) ),
				'meta'   => array(
					'target' => '',
					'title'  => esc_attr__( 'User Role Editor Settings', 'toolbar-extras-givewp' ),
				)
			)
		);

		/** Group: Plugin's resources */
		if ( ddw_tbex_display_items_resources() ) {

			$admin_bar->add_group(
				array(
					'id'     => 'group-givewp-urepermissions-resources',
					'parent' => 'ao-givewp-urepermissions',
					'meta'   => array( 'class' => 'ab-sub-secondary' ),
				)
			);

			ddw_tbex_resource_item(
				'documentation',
				'givewp-urepermissions-docs',
				'group-givewp-urepermissions-resources',
				'https://www.role-editor.com/documentation/'
			);

		}  // end if

}  // end function
