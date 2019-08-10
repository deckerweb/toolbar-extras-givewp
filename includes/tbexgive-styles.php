<?php

// includes/tbexgive-styles

/**
 * Prevent direct access to this file.
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'wp_head', 'ddw_tbexgive_styles_givewp_logo', 100 );
add_action( 'admin_head', 'ddw_tbexgive_styles_givewp_logo', 100 );
/**
 * For the GiveWP Logo icon add the needed CSS styles inline. Plus CSS tweaks if
 *   the Dashicons option is set via Add-On's settings.
 *
 * @since 1.0.0
 *
 * @uses ddw_tbex_get_option()
 *
 * @return string CSS styling for selected Toolbar items.
 */
function ddw_tbexgive_styles_givewp_logo() {

	$bgcolor = ddw_tbex_get_option( 'givewp', 'formfeat_bgcolor' );

	?>
		<style type="text/css">
			.tbex-node-givewp-dashicon .dashicons-before:before,
			.tbex-node-givewp-logo .dashicons-before:before {
				margin-top: 2px;
			}
			.tbex-settings-icon.tbexgive-givewp-logo::before {
				font-family: 'give-icomoon';
				font-size: 18px;
				width: 18px;
				height: 18px;
				content: "\e800";
			}
			/* #d59e0a // rgba(203, 144, 0, 1) */
			#wpadminbar .give-test-mode-active > .ab-item {
				background-color: #ff8c00 !important;
			}
			#wpadminbar .give-test-mode-active:hover > .ab-item {
				background-color: #d59e0a !important;
			}
			#wpadminbar .give-test-mode-active:hover .ab-item,
			#wpadminbar .give-test-mode-active:hover .ab-icon:before,
			#wpadminbar .give-test-mode-active:hover .ab-label {
				color: inherit !important;
			}

			<?php if ( '' !== $bgcolor ) {
				echo sprintf(
					'.tbexgive-formfeat-toplevel { background-color: %s !important; }',
					sanitize_hex_color( $bgcolor )
				);
			} ?>

		</style>
	<?php

}  // end function
