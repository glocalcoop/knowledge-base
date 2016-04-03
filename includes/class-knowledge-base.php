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
     */
    private $capabilities = array(
        'edit_post'          => 'edit_posts',
        'read_post'          => 'edit_posts',
        'delete_post'        => 'edit_posts',
        'edit_posts'         => 'edit_posts',
        'edit_others_posts'  => 'edit_posts',
        'publish_posts'      => 'edit_posts',
        'read_private_posts' => 'edit_posts',
    );

    /**
     * Constructor.
     */
    public function __construct () {
        $this->labels = array(
            'name'                  => _x( 'Knowledge Base', 'Post Type General Name', Knowledge_Base::$text_domain ),
            'singular_name'         => _x( 'Knowledge Base Item', 'Post Type Singular Name', Knowledge_Base::$text_domain ),
        );
    }

    /**
     * Registers the custom post type with via WordPress API.
     */
    public function register () {
        register_post_type( self::name, array(
            'labels'       => apply_filters( 'kb_labels', $this->labels ),
            'public'       => true,
            'show_in_menu' => true,
            'hierarchical' => apply_filters( 'kb_hierarchical', false ),
            'has_archive'  => true,
            'capabilities' => apply_filters( 'kb_capabilities', $this->capabilities ),
            'supports'     => array(
                'title',
                'editor',
                'revisions',
                'excerpt',
                'thumbnail',
                'page-attributes'
            ),
            'menu_icon'    => apply_filters( 'kb_menu_icon', 'dashicons-lightbulb' ),
            'taxonomies'   => array( Knowledge_Base_Taxonomy::name ),
        ) );
    }

    /**
     * Gets posts of this post type from the Single Point of Truth.
     *
     * @link https://developer.wordpress.org/reference/functions/get_posts/
     *
     * @return array
     */
    public function get_posts ( $args = null ) {
        if ( !is_null( $args ) ) {
            $args = wp_parse_args( $args, array(
                'post_type' => self::name
            ) );
        }
        // TODO: We should consider making this a variable so the end
        //       user can determine which blog to save the site-wide
        //       directory metadata to.
        $posts = get_posts( $args );
        return $posts;
    }

}
