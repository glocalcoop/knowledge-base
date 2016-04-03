<?php
/**
 * The Knowledge Base Widget
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package WordPress\Plugin\Knowledge_Base
 */

/**
 * The widget implementation.
 *
 * @link https://developer.wordpress.org/reference/classes/WP_Widget/
 */
class Knowledge_Base_Widget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            strtolower(__CLASS__),
            __( 'Knowledge Base Categories Widget', Knowledge_Base::text_domain ),
            array(
                'description' => __( 'Shows categories in knowledge base.', Knowledge_Base::text_domain )
            )
        );
    }

    /**
     * Outputs the widget's settings form HTML.
     *
     * @param array $instance
     *
     * @return string
     */
    public function form( $instance ) {
        $instance = wp_parse_args( $instance, array(
            // Widget defaults.
            'display'       => 'list',
            'hide_empty'    => 1,
        ) );
?>
<p>
    <?php //Hide Empty ?>
    <input type="checkbox"
        id="<?php print $this->get_field_id( 'hide_empty' );?>"
        name="<?php print $this->get_field_name( 'hide_empty' )?>"
        value="1"
        <?php checked( $instance['hide_empty'] );?>
    />
    <label for="<?php print $this->get_field_id( 'hide_empty' );?>">
        <?php esc_html_e( 'Hide Empty', Knowledge_Base::text_domain );?>
    </label>

    <?php //Display ?>
    <label for="<?php print $this->get_field_id( 'display' );?>">
        <?php esc_html_e( 'Display As', Knowledge_Base::text_domain );
        ?>
    </label>
    <select
        id="<?php print $this->get_field_id( 'display' );?>"
        name="<?php print $this->get_field_name( 'display' );?>"
    >
        <option <?php selected( $instance['display'], 'list' );?>><?php print esc_html( 'List' );?></option>
        <option <?php selected( $instance['display'], 'block' );?>><?php print esc_html( 'Block' );?></option>
        
    </select>
</p>
<?php
    }

    /**
     * Updates the widget instance.
     *
     * @link https://developer.wordpress.org/reference/classes/wp_widget/update/
     *
     * @param array $new_instance
     * @param array $old_instance
     *
     * @return array|bool Settings to save or bool false to cancel saving.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();

        $instance['display'] = sanitize_text_field( $new_instance['display'] );
        $instance['hide_empty'] = (int) $new_instance['hide_empty'];

        return $instance;
    }

    /**
     * Outputs widget HTML.
     *
     * @link https://developer.wordpress.org/reference/classes/wp_widget/widget/
     *
     * @param array $args
     * @param array $instance
     *
     * @return void
     */
    public function widget( $args, $instance ) {
        $atts = '';
        foreach ( $instance as $key => $value ) {
            if( $value ) {
                $atts .= "$key='$value' ";
            }
        }
        print do_shortcode( '['.Knowledge_Base_Shortcode::tagname." $atts]" );
    }

}
