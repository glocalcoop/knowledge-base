<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://glocal.coop
 * @since      0.1.2
 *
 * @package    Knowledge_Base
 * @subpackage Knowledge_Base/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      0.1.2
 * @package    Knowledge_Base
 * @subpackage Knowledge_Base/includes
 * @author     Pea, Glocal <pea@glocal.coop>
 */
class Knowledge_Base_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    0.1.2
	 */
	public static function deactivate() {

        flush_rewrite_rules();

	}

}
