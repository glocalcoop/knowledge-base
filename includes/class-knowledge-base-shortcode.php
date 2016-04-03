<?php
/**
 * The Multisite Directory Shortcode
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package WordPress\Plugin\Knowledge_Base
 */

/**
 * The shortcode implementation.
 *
 * Defines a shortcode called `multisite-directory` that accepts some
 * attributes with which to customize the display of a simple network
 * directory. Valid attributes and their values are:
 *
 * * `style` - An inline `style` attribute, useful for adding custom CSS to the container.
 * * `display` - A string describing how to display the sites. Can be either `list` or `map`. (Default: `map`.)
 * * `terms` - A space-separated list of term slugs to limit the directory to. Omit this to include all terms.
 * * `show_site_logo` - Whether or not to show site logos in output. Omit this not to show site logos.
 * * `logo_size` - A registered image size that your theme supports. Ignored if `show_site_logo` is not enabled. Defaults to 70px by 70px.
 *
 * @link https://codex.wordpress.org/Shortcode_API
 */
class Knowledge_Base_Shortcode {

    /**
     * The tag for the shortcode itself.
     *
     * @var string
     */
    const tagname = Knowledge_Base::text_domain;

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
        $this->atts = shortcode_atts( array(
            // Recognized shortcode attribute names and their values.
            'display' => 'list',
            'style'  => '',
            'terms' => array(),
            'hide_empty' => false,
        ), array_map( array( $this, 'parseJsonAttribute' ), $atts ) );
        $this->content = $content;
    }

    /**
     * Parses a complex shortcode attribute.
     *
     * Some attributes can be passed as JSON. This method detects the
     * ones that are and decodes their values.
     *
     * @param string $val
     * @return mixed
     */
    private function parseJsonAttribute( $val ) {
        $parsed = json_decode( $val );
        if ( JSON_ERROR_NONE === json_last_error() ) {
            return $parsed;
        } else {
            return $val;
        }
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

        // When displaying a map
        if ('list' === $this->atts['display']) {
            // Find all mappable terms
            $terms = get_terms( Knowledge_Base_Taxonomy::name );

            ob_start();


            if ( !is_wp_error( $terms ) && !empty( $terms ) ) {

            }

        } else if ('list' === $this->atts['display']) {
            ob_start();

            if ( !is_wp_error($terms) && !empty($terms) ) {
                // TODO: Refactor this so it's not embedded HTML.
                // I used output buffering just for now.
?>
<h1><?php esc_html_e('Similar sites', 'multisite-directory');?></h1>
<ul class="network-directory-similar-sites">
    <?php foreach ($terms as $term) { $similar_sites = get_sites_in_directory_by_term($term); ?>
    <li><?php print esc_html($term->name); ?>
        <ul>
        <?php foreach ($similar_sites as $site_detail) { if (get_current_blog_id() == $site_detail->blog_id) { continue; } ?>
        <li>
            <?php if (!empty($this->atts['show_site_logo'])) { the_site_directory_logo($site_detail->blog_id, $this->atts['logo_size']); } ?>
            <a href="<?php print esc_url($site_detail->siteurl);?>"><?php print esc_html($site_detail->blogname);?></a>
        </li>
        <?php } ?>
        </ul>
    </li>
    <?php } ?>
</ul>
<?php
            }
            $html = ob_get_contents();
            ob_end_clean();
        }

        // Save the HTML for later display.
        $this->html = $html;
    }

    /**
     * Prints the shortcode output to the browser.
     */
    private function display () {
        print $this->html;
    }

    /**
     * Registers the shortcode and its assets.
     */
    public static function register () {
        add_shortcode( $this->tagname, array(__CLASS__, 'doShortcode' ));

        // wp_register_style(
        //     'multisite-directory-map',
        //     plugins_url('public/css/multisite-directory-map.css', dirname(__FILE__))
        // );
        // wp_register_script(
        //     'multisite-directory-map',
        //     plugins_url('public/js/multisite-directory-map.js', dirname(__FILE__)),
        //     array('leaflet', 'jquery'),
        //     false,
        //     true
        // );
    }

    /**
     * Shortcode handler.
     *
     * @param array $atts
     * @param string $content
     */
    public static function doShortcode ( $atts, $content = null ) {
        self::$invocations++;
        $shortcode = new self($atts, $content);
        $shortcode->prepare();
        $shortcode->display();
    }

}
