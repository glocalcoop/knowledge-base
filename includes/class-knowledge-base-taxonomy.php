<?php
/**
 * A Taxonomy for the Knowledge Base post type.
 *
 * @link       https://glocal.coop
 * @since      0.1.1-alpha
 *
 * @package    Knowledge_Base
 * @subpackage Knowledge_Base/includes
 */

/**
 * Class defining the taxonomy for the knowledge bases.
 */
class Knowledge_Base_Taxonomy {

    /**
     * Name of the taxonomy.
     *
     * @var string
     */
    const name = 'knowledge_base_category';

    /**
     * Capabilities needed to act on the taxonomy.
     * 
     * @var array
     *
     * @link https://codex.wordpress.org/Roles_and_Capabilities
     */
    private $capability_type = 'post';

    /**
     * Rewrite Options
     *
     * @link https://codex.wordpress.org/Function_Reference/register_taxonomy
     */
    private $rewrite;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->labels = apply_filters( 'kb_category_taxonomy_labels', array(
            'name'              => __( 'Categories', 'knowledge-base' ),
            'singular_name'     => _x( 'Category', 'taxonomy general name', 'knowledge-base' ),
        ) );

        $this->rewrite = $this->get_option();

        add_action( 'init', array( $this, 'register' ), 0 );
    }

    /**
     * Registers the taxonomy.
     */
    public function register() {
        register_taxonomy(
            self::name,
            Knowledge_Base_Entry::name,
            apply_filters( 'kb_register_category_taxonomy', array(
                'labels'                => $this->labels,
                'capability_type'       => $this->capability_type,
                'rewrite'               => array( 
                    'slug' => $this->rewrite, 
                    'with_front' => false
                    ),
                'hierarchical'          => true,
                'show_in_rest'          => true,
                'rest_base'             => self::name,
                'rest_controller_class' => 'WP_REST_Terms_Controller',
            )
        ) );
    }

    /**
     * Get Rewrite Setting
     *
     * @since    0.1.2
     *
     * @link https://developer.wordpress.org/reference/functions/get_option/
     */
    public function get_option() {
        return knowledge_base_get_option( 'tax_slug' );
    }

}
