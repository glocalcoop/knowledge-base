<?php
/**
 * A Knowledge Base Post
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package WordPress\Plugin\Knowledge_Base
 */

/**
 * Class defining a "Knowledge_Base" custom post type.
 */
class Knowledge_Base_Entry {

    /**
     * Name of the custom post type.
     *
     * @var string
     */
    const name = 'knowledge_base';

    /**
     * Custom post type UI labels.
     *
     * @var array
     */
    private $labels;

    /**
     * Capabilities needed to act on the custom post type.
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
     */
    public function __construct () {
        $this->labels = apply_filters( 'kb_post_type_labels', array(
            'name'                  => _x( 'Knowledge Base', 'Post Type General Name', Knowledge_Base::$text_domain ),
            'singular_name'         => _x( 'Knowledge Base Item', 'Post Type Singular Name', Knowledge_Base::$text_domain ),
        ) );
    }

    /**
     * Registers the custom post type with via WordPress API.
     */
    public function register() {
        register_post_type(
            self::name,
            apply_filters( 'kb_register_custom_post_type', array(
                'labels'              => $this->labels,
                'supports'            => $this->supports,
                'capability_type'     => $this->capability_type,
                'public'              => true,
                'has_archive'         => true,
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

}
