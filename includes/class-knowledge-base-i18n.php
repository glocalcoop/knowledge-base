<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://glocal.coop
 * @since      0.1.2
 *
 * @package    Knowledge_Base
 * @subpackage Knowledge_Base/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      0.1.2
 * @package    Knowledge_Base
 * @subpackage Knowledge_Base/includes
 * @author     Pea, Glocal <pea@glocal.coop>
 */
class Knowledge_Base_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    0.1.2
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'knowledge-base',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
