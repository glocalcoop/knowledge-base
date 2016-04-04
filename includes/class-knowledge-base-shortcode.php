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
class Knowledge_Base_Shortcode {

    /**
     * The tag for the shortcode itself.
     *
     * @var string
     */
    const tagname = 'knowledge-base';

    /**
     * How many times have we invoked the shortcode?
     *
     * @var int
     */
    public static $invocations = 0;

    /**
     * Attributes passed to the shortcode.
     *
     * @var array
     */
    private $atts;

    /**
     * Any content within the opening and closing tags.
     *
     * @var string
     */
    private $content;

    /**
     * Constructor.
     *
     * @param array $atts
     * @param string $content
     */
    public function __construct( $atts, $content = null ) {
        if ( empty( $atts ) ) { 
            $atts = array();
        }
        $this->atts = shortcode_atts( array(
            // Recognized shortcode attribute names and their values.
            'style'  => '',
            'terms' => array(),
            'hide_empty' => true,
        ), $atts );
        $this->content = $content;
    }

    /**
     * Gets data from WordPress based on shortcode attributes.
     *
     * This will set the `$html` member to the appropriate output.
     *
     * @return void
     */
    private function prepare() {
        $cpt = new Knowledge_Base_Entry();
        $html = ''; 

        $args = apply_filters( 'kb_shortcode_args', array( 
            'taxonomy'      => Knowledge_Base_Taxonomy::name,
            'show_count'    => 1,
            'walker'        => new Knowledge_Base_Walker_Class,
            'title_li'      => __( '', Knowledge_Base::$text_domain ),
            //'echo'          => 0
        ) );
        ?>

        <?php ob_start(); ?>

        <ul class="knowledge-base-list" id="instance-<?php print self::$invocations; ?>">

            <?php wp_list_categories( $args ); ?>

        </ul>

        <?php $html .= ob_get_contents(); ?>

        <?php ob_end_clean(); ?>

        <?php // Save the HTML for later display.
        $this->html = $html;
    }

    /**
     * Prints the shortcode output to the browser.
     */
    private function display() {
        print $this->html;
    }

    /**
     * Registers the shortcode and its assets.
     */
    public static function register() {
        add_shortcode( self::tagname, array( __CLASS__, 'doShortcode' ) );
    }

    /**
     * Shortcode handler.
     *
     * @param array $atts
     * @param string $content
     */
    public static function doShortcode( $atts, $content = null ) {
        self::$invocations++;
        $shortcode = new self( $atts, $content );
        $shortcode->prepare();
        $shortcode->display();
    }

}
