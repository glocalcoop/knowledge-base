<?php
/**
 * Knowledge Base uninstaller.
 *
 * @link https://developer.wordpress.org/plugins/the-basics/uninstall-methods/#uninstall-php
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @copyright Copyright (c) 2016 by Pea, Glocal
 *
 * @package WordPress\Plugin\Knowledge_Base\Uninstaller
 */

// Don't execute any uninstall code unless WordPress core requests it.
if (!defined('WP_UNINSTALL_PLUGIN')) { exit(); }

require_once plugin_dir_path( __FILE__ ) . 'knowledge-base.php';

$my_prefix = Knowledge_Base::$prefix;

// Delete plugin options.
delete_option( "{$my_prefix}_settings" );

foreach ( get_users() as $user ) {
    // Delete all custom user profile data.
}
