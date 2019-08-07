<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'DDW_TBEXGIVE_GiveWP_Settings_Tab' ) ) :

	/**
	 * DDW_TBEXGIVE_GiveWP_Settings_Tab.
	 *
	 * @sine 1.0.0
	 */
	class DDW_TBEXGIVE_GiveWP_Settings_Tab extends Give_Settings_Page {

		/**
		 * Constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->id    = 'tbexgive';
			$this->label = __( 'Toolbar Extras', 'toolbar-extras-givewp' );

			parent::__construct();
		}

		/**
		 * Get settings array.
		 *
		 * @since  1.0.0
		 * @access public
		 *
		 * @return array
		 */
		public function get_settings() {

			$is_global = true; // Set Global flag.

			$settings = array();

			/**
			 * Filter the TBEX Give settings.
			 *
			 * @since  1.0.0
			 *
			 * @param  array $settings
			 */
			$settings = apply_filters( 'give_toolbar_get_settings_' . $this->id, $settings );

			// Output.
			return $settings;
		}

	}

endif;

return new DDW_TBEXGIVE_GiveWP_Settings_Tab();
