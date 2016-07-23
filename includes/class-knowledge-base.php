<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://glocal.coop
 * @since      0.1.1-alpha
 *
 * @package    Knowledge_Base
 * @subpackage Knowledge_Base/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.1.1-alpha
 * @package    Knowledge_Base
 * @subpackage Knowledge_Base/includes
 * @author     Pea, Glocal <pea@glocal.coop>
 */
class Knowledge_Base {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.1.1-alpha
	 * @access   protected
	 * @var      Knowledge_Base_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.1.1-alpha
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.1.1-alpha
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    0.1.1-alpha
	 */
	public function __construct() {

		$this->plugin_name = 'knowledge-base';
		$this->version = '0.1.2';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		$this->register_post_type();
		$this->register_taxonomy();
		$this->register_shortcode();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Knowledge_Base_Loader. Orchestrates the hooks of the plugin.
	 * - Knowledge_Base_i18n. Defines internationalization functionality.
	 * - Knowledge_Base_Admin. Defines all hooks for the admin area.
	 * - Knowledge_Base_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.1.1-alpha
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * Helper functions.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/helpers.php';

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-knowledge-base-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-knowledge-base-i18n.php';

		/**
		 * The class responsible for defining custom post
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-knowledge-base-post.php';

		/**
		 * The class responsible for defining custom taxonomy
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-knowledge-base-taxonomy.php';

		/**
		 * The class responsible for defining shortcode
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-knowledge-base-shortcode.php';

		/**
		 * The class responsible for defining custom walker
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-knowledge-base-walker.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-knowledge-base-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-knowledge-base-public.php';

		$this->loader = new Knowledge_Base_Loader();

	}

	/**
	 * Register Custom Class
	 *
	 * Uses the register_post_type function to register a custom 
	 * post with WordPress.
	 *
	 * @since    0.1.2
	 * @access   private
	 *
	 * @link https://codex.wordpress.org/Function_Reference/register_post_type
	 */
	private function register_post_type() {
		$cpt = new Knowledge_Base_Entry();
	}

	/**
	 * Register Custom Taxonomy
	 *
	 * Uses the `register_taxonomy` function to register a custom 
	 * taxonomy with WordPress.
	 *
	 * @since    0.1.2
	 * @access   private
	 *
	 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	private function register_taxonomy() {
		$taxonomy = new Knowledge_Base_Taxonomy();
	}

	/**
	 * Register Shortcode
	 *
	 *
	 * @since    0.1.2
	 * @access   private
	 *
	 * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	private function register_shortcode() {
		$shortcode = new Knowledge_Base_Shortcodes();
	}


	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Knowledge_Base_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.1.1-alpha
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Knowledge_Base_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.1.1-alpha
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Knowledge_Base_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.1.1-alpha
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Knowledge_Base_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.1.1-alpha
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.1.1-alpha
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.1.1-alpha
	 * @return    Knowledge_Base_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.1.1-alpha
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
