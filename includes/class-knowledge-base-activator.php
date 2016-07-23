<?php

/**
 * Fired during plugin activation
 *
 * @link       https://glocal.coop
 * @since      0.1.2
 *
 * @package    Knowledge_Base
 * @subpackage Knowledge_Base/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.1.2
 * @package    Knowledge_Base
 * @subpackage Knowledge_Base/includes
 * @author     Pea, Glocal <pea@glocal.coop>
 */
class Knowledge_Base_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    0.1.2
	 */
	public static function activate() {

        flush_rewrite_rules();

	}

}
