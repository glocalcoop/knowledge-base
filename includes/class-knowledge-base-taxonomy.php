<?php
/**
 * A Taxonomy for the Knowledge Base post type.
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package WordPress\Plugin\Knowledge_Base
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
    private $rewrite = array(
        'slug'  => 'knowledge-base-category',
    );

    /**
     * Constructor.
     */
    public function __construct() {
        $this->labels = apply_filters( 'kb_category_taxonomy_labels', array(
            'name'              => __( 'Categories', 'knowledge-base' ),
            'singular_name'     => _x( 'Category', 'taxonomy general name', 'knowledge-base' ),
        ) );
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
                'rewrite'               => $this->rewrite,
                'hierarchical'          => true,
                'show_in_rest'          => true,
                'rest_base'             => self::name,
                'rest_controller_class' => 'WP_REST_Terms_Controller',
            )
        ) );
    }
}
