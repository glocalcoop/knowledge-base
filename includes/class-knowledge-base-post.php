<?php
/**
 * A Knowledge Base Post
 *
 * @link       https://glocal.coop
 * @since      0.1.1-alpha
 *
 * @package    Knowledge_Base
 * @subpackage Knowledge_Base/includes
 */

/**
 * Class defining a "Knowledge_Base" custom post type.
 */
class Knowledge_Base_Entry {

    /**
     * Name of the custom post type.
     *
     * @since    0.1.1-alpha
     *
     * @var string
     */
    const name = 'knowledge_base';

    /**
     * Custom post type UI labels.
     *
     * @since    0.1.1-alpha
     *
     * @var array
     */
    private $labels;

    /**
     * Custom slug
     *
     * @since    0.1.2
     *
     * @var string
     */
    private $slug;


    /**
     * Capabilities needed to act on the custom post type.
     *
     * @since    0.1.1-alpha
     *
     * @var array
     *
     * @link https://codex.wordpress.org/Roles_and_Capabilities
     *
     * Added `delete_posts` to capabilities in order to fix error
     * `Notice: Undefined property: stdClass::$delete_posts /wp-admin/includes/class-wp-posts-list-table.php on line 403`
     *
     * @link https://wordpress.org/support/topic/custom-post-types-do-not-have-move-to-trash-bulk-action#post-6884627
     */
    private $capability_type = 'post';

    /**
     * Registers support of certain feature(s) for this post type
     *
     * @link https://codex.wordpress.org/Function_Reference/register_post_type#supports
     */
    private $supports = array(
        'title',
        'editor',
        'revisions',
        'excerpt',
        'thumbnail',
        'page-attributes'
    );


    /**
     * Constructor.
     *
     * @since    0.1.1-alpha
     */
    public function __construct () {
        $this->labels = apply_filters( 'kb_post_type_labels', array(
            'name'                  => $this->get_option( 'archive_label', __( 'Knowledge Base', 'knowledge-base' ) ),
            'singular_name'         => _x( 'Knowledge Base Item', 'Post Type Singular Name', 'knowledge-base' ),
            'name_admin_bar'        => __( 'Knowledge Base', 'knowledge-base' ),
            'archives'              => __( 'Knowledge Base', 'knowledge-base' ),
            'search_items'          => __( 'Search Knowledge Base', 'knowledge-base' ),
        ) );

        $this->slug = $this->get_option( 'post_slug' );

        add_action( 'init', array( $this, 'register' ) );
    }

    /**
     * Registers the custom post type with via WordPress API.
     *
     * @since    0.1.1-alpha
     *
     */
    public function register() {
        register_post_type(
            self::name,
            apply_filters( 'kb_register_custom_post_type', array(
                'labels'              => $this->labels,
                'supports'            => $this->supports,
                'capability_type'     => $this->capability_type,
                'public'              => true,
                'has_archive'         => $this->slug,
                'rewrite'             => array(
                    'slug'              => $this->slug,
                    'with_front'        => false
                ),
                'hierarchical'        => false,
                'menu_icon'           => 'dashicons-lightbulb',
                'show_in_rest'        => true,
                'rest_base'           => self::name,
                'rest_controller_class' => 'WP_REST_Posts_Controller',
                'taxonomies'          => array( Knowledge_Base_Taxonomy::name ),
            ) )
        );

    }

    /**
     * Gets posts of this post type from the Single Point of Truth.
     *
     * @link https://developer.wordpress.org/reference/functions/get_posts/
     *
     * @return array
     */
    public function get_posts( $args = null ) {
        if ( !is_null( $args ) ) {
            $args = wp_parse_args( $args, array(
                'post_type' => self::name
            ) );
        }
        $posts = get_posts( $args );
        return $posts;
    }

    /**
     * Get Rewrite Setting
     *
     * @since    0.1.2
     *
     * @link https://developer.wordpress.org/reference/functions/get_option/
     */
    public function get_option( $option ) {
        return knowledge_base_get_option( $option );
    }

    /**
     * Gets slug.
     *
     * @since    0.1.2
     *
     * @return string
     */
    public function get_slug() {
        $options = get_option( 'kb_settings' );
        return $options['kb_slug'];
    }

    /**
     * Sets slug.
     *
     * @since    0.1.2
     *
     * @return void
     */
    public function set_slug( $slug ) {
        update_option( $options['kb_slug'], $slug );
    }

}
