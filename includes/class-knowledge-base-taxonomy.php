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
    const name = 'kb_category';

    /**
     * Capabilities needed to act on the taxonomy.
     *
     * @var array
     */
    private $capabilities = array(
        'manage_terms' => 'edit_posts',
        'edit_terms'   => 'edit_posts',
        'delete_terms' => 'edit_posts',
        'assign_terms' => 'edit_posts',
    );

    /**
     * Constructor.
     */
    public function __construct () {
    }

    /**
     * Registers the taxonomy.
     */
    public function register () {
        register_taxonomy( self::name, Knowledge_Base_Entry::name, array(
            'hierarchical' => true,
            'capabilities' => add_filter( 'kb_category_capabilities', $this->capabilities ),
        ) );

    }

}
