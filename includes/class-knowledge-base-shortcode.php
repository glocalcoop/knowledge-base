<?php
/**
 * The Knowledge Base Shortcode
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package WordPress\Plugin\Knowledge_Base
 */

/**
 * The shortcode implementation.
 *
 * Defines a shortcode called `knowledge-base` that accepts some
 * attributes with which to customize the display of knowledge base categories and posts. Valid attributes and their values are:
 *
 * * `style` - An inline `style` attribute, useful for adding custom CSS to the container.
 * * `terms` - A space-separated list of `knowledge_base_category` slugs to limit knowledge base to. Omit this to include all terms.
 * * `hide_empty` - Whether or not to show empty categories (Default: `true`.).
 *
 * @link https://codex.wordpress.org/Shortcode_API
 */
class Knowledge_Base_Shortcodes {

    /**
     * How many times have we invoked the shortcode?
     *
     * @var int
     */
    public static $invocations = 0;

    /**
     * Constructor.
     *
     */
    function __construct() {

        add_shortcode( 'knowledge-base',  array( $this, 'get_category_list' ) );
        add_filter( 'widget_text', 'do_shortcode' );  
    }
 
    /**
     * Shortcode
     * Shortcode for displaying hierarchical list of taxonomy terms
     *
     * @param array $atts
     * @param string $content
     */
    public function get_category_list( $atts, $content = null ) {

        if ( empty( $atts ) ) { 
            $atts = array();
        }



        $this->atts = shortcode_atts( array(
            // Recognized shortcode attribute names and their values.
            'hide_empty'    => 1,
            'title_li'      => __( '', 'knowledge-base' ),
            'show_count'    => 1,
            'child_of'      => $atts['child_of']
        ), $atts );

        $this->args = apply_filters( 'kb_shortcode_args', array( 
            'taxonomy'      => Knowledge_Base_Taxonomy::name,
            'walker'        => new Knowledge_Base_Walker_Class,
            'echo'          => 0,
            'show_count'    => $this->atts['show_count'],
            'title_li'      => __( $this->atts['title_li'], 'knowledge-base' ),
            'child_of'      => $this->atts['child_of'],
        ) );

        $html = ''; 

        ?>

        <?php
        $html .= '<ul class="knowledge-base-list">';

        $html .= wp_list_categories( $this->args );

        $html .= '</ul>';
        ?>

        <?php
        return $html;
    }
 
}
