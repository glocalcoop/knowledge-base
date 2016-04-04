<?php
/**
 * The Knowledge Base plugin for WordPress.
 *
 * WordPress plugin header information:
 *
 * Plugin Name: Knowledge Base
 * Plugin URI: https://github.com/glocalcoop/Knowledge_Base
 * Version: 0.1-alpha
 * Description: Simple plugin that creates a knowledge base with related taxonomies
 * Author: Pea, Glocal <pea@glocal.coop>
 * Author URI: https://glocal.coop/
 * License: GPL-3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.en.html
 * Text Domain: knowledge-base
 * Domain Path: /languages
 *
 * @link https://developer.wordpress.org/plugins/the-basics/header-requirements/
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @copyright Copyright (c) 2016 by My Name
 *
 * @package WordPress\Plugin\Knowledge_Base
 */

if (!defined('ABSPATH')) { exit; } // Disallow direct HTTP access.

/**
 * Base class that WordPress uses to register and initialize plugin.
 */
class Knowledge_Base {

    /**
     * String to prefix option names, settings, etc. in shared spaces.
     *
     * Some WordPress data storage areas are basically one globally
     * shared namespace. For example, names of options saved in WP's
     * options table must be globally unique. When saving data in any
     * such shared space, we need to prefix the name we use.
     *
     * @var string
     */
    public static $prefix = 'Knowledge_Base';

    /**
     * Entry point for the WordPress framework into plugin code.
     *
     * This is the method called when WordPress loads the plugin file.
     * It is responsible for "registering" the plugin's main functions
     * with the {@see https://codex.wordpress.org/Plugin_API WordPress Plugin API}.
     *
     * @uses add_action()
     * @uses register_activation_hook()
     * @uses register_deactivation_hook()
     *
     * @return void
     */
    public static function register () {
        require_once 'includes/class-knowledge-base.php';
        require_once 'includes/class-knowledge-base-taxonomy.php';
        require_once 'includes/class-knowledge-base-shortcode.php';
        require_once 'includes/class-knowledge-base-walker.php';
        add_action('plugins_loaded', array(__CLASS__, 'registerL10n'));
        add_action('init', array(__CLASS__, 'initialize'));

        register_activation_hook(__FILE__, array(__CLASS__, 'activate'));
        register_deactivation_hook(__FILE__, array(__CLASS__, 'deactivate'));
    }

    /**
     * Intialize
     *
     * @link https://developer.wordpress.org/reference/hooks/init/
     */
    public static function initialize () {
        $cpt = new Knowledge_Base_Entry();
        $cpt->register();

        $tax = new Knowledge_Base_Taxonomy();
        $tax->register();

        $shortcodes = new Knowledge_Base_Shortcode();

    }


    /**
     * Loads localization files from plugin's languages directory.
     *
     * @uses load_plugin_textdomain()
     *
     * @return void
     */
    public static function registerL10n () {
        load_plugin_textdomain('Knowledge_Base', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    /**
     * Method to run when the plugin is activated by a user in the
     * WordPress Dashboard admin screen.
     *
     * @uses Knowledge_Base::checkPrereqs()
     *
     * @return void
     */
    public static function activate () {
        self::checkPrereqs();
        self::initialize();

        $plugin = new self();
    }

    /**
     * Checks system requirements and exits if they are not met.
     *
     * This first checks to ensure minimum WordPress and PHP versions
     * have been satisfied. If not, the plugin deactivates and exits.
     *
     * @global $wp_version
     *
     * @uses $wp_version
     * @uses Knowledge_Base::get_minimum_wordpress_version()
     * @uses deactivate_plugins()
     * @uses plugin_basename()
     *
     * @return void
     */
    public static function checkPrereqs () {
        global $wp_version;
        $min_wp_version = self::get_minimum_wordpress_version();
        if (version_compare($min_wp_version, $wp_version) > 0) {
            deactivate_plugins(plugin_basename(__FILE__));
            wp_die(sprintf(
                __('Knowledge_Base requires at least WordPress version %1$s. You have WordPress version %2$s.', 'knowledge-base'),
                $min_wp_version, $wp_version
            ));
        }
    }

    /**
     * Returns the "Requires at least" value from plugin's readme.txt.
     *
     * @link https://wordpress.org/plugins/about/readme.txt WordPress readme.txt standard
     *
     * @return string
     */
    public static function get_minimum_wordpress_version () {
        $lines = @file(plugin_dir_path(__FILE__) . 'readme.txt');
        foreach ($lines as $line) {
            preg_match('/^Requires at least: ([0-9.]+)$/', $line, $m);
            if ($m) {
                return $m[1];
            }
        }
    }

    /**
     * Method to run when the plugin is deactivated by a user in the
     * WordPress Dashboard admin screen.
     *
     * @return void
     */
    public static function deactivate () {
        // TODO
    }

    /**
     * Prepares an error message for logging.
     *
     * @param string $message
     *
     * @return string
     */
    private static function error_msg ($message) {
        $dbt = debug_backtrace();
        // the "2" is so we get the name of the function that originally called debug_log()
        // This works so long as error_msg() is always called by debug_log()
        return '[' . get_called_class() . '::' . $dbt[2]['function'] . '()]: ' . $message;
    }

}

Knowledge_Base::register();
