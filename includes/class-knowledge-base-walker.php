<?php
/**
 * A Knowledge Base Walker Class
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @package WordPress\Plugin\Knowledge_Base
 */

/**
 * Extend the Walker_Class.
 */
class Knowledge_Base_Walker_Class extends Walker {

    /**
     * What the class handles.
     *
     * @see Walker::$tree_type
     * @since 2.1.0
     * @var string
     */
    public $tree_type = 'category';

    /**
     * Database fields to use.
     *
     * @see Walker::$db_fields
     * @since 2.1.0
     * @todo Decouple this
     * @var array
     */
    public $db_fields = array ( 'parent' => 'parent', 'id' => 'term_id');

    /**
     * Starts the list before the elements are added.
     *
     * @see Walker::start_lvl()
     *
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of category. Used for tab indentation.
     * @param array  $args   An array of arguments. Will only append content if style argument value is 'list'.
     *                       @see wp_list_categories()
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= "<ul class='children'>\n";
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     *
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param int    $depth  Depth of category. Used for tab indentation.
     * @param array  $args   An array of arguments. Will only append content if style argument value is 'list'.
     *                       @wsee wp_list_categories()
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $output .= "</ul>\n";
    }

    /**
     * Start the element output.
     *
     * @see Walker::start_el()
     *
     * @since 2.1.0
     *
     * @param string $output   Passed by reference. Used to append additional content.
     * @param object $category Category data object.
     * @param int    $depth    Depth of category in reference to parents. Default 0.
     * @param array  $args     An array of arguments. @see wp_list_categories()
     * @param int    $id       ID of the current category.
     */
    public function start_el( &$output, $category, $depth = 0, $args = array(), $id = 0 ) {
                $cat_name = apply_filters(
            'list_cats',
            esc_attr( $category->name ),
            $category
        );

        // Don't generate an element if the category name is empty.
        if ( ! $cat_name ) {
            return;
        }

        $link = '<a href="' . esc_url( get_term_link( $category ) ) . '" ';
        if ( $args['use_desc_for_title'] && ! empty( $category->description ) ) {
            /**
             * Filter the category description for display.
             *
             * @since 1.2.0
             *
             * @param string $description Category description.
             * @param object $category    Category object.
             */
            $link .= 'title="' . esc_attr( strip_tags( apply_filters( 'category_description', $category->description, $category ) ) ) . '"';
        }

        $link .= '>';
        $link .= $cat_name . '</a>';

        if ( ! empty( $args['show_count'] ) ) {
            $link .= ' <span class="count">' . number_format_i18n( $category->count ) . '</span>';
        }

        if ( 'list' == $args['style'] ) {
            $output .= "\t<li";
            $css_classes = array(
                'tax-item',
                'tax-item-' . $category->term_id,
            );

            if ( ! empty( $args['current_category'] ) ) {
                // 'current_category' can be an array, so we use `get_terms()`.
                $_current_terms = get_terms( $category->taxonomy, array(
                    'include' => $args['current_category'],
                    'hide_empty' => false,
                ) );

                foreach ( $_current_terms as $_current_term ) {
                    if ( $category->term_id == $_current_term->term_id ) {
                        $css_classes[] = 'current-cat';
                    } elseif ( $category->term_id == $_current_term->parent ) {
                        $css_classes[] = 'current-cat-parent';
                    }
                }
            }

            /**
             * Filter the list of CSS classes to include with each category in the list.
             *
             * @since 4.2.0
             *
             * @see wp_list_categories()
             *
             * @param array  $css_classes An array of CSS classes to be applied to each list item.
             * @param object $category    Category data object.
             * @param int    $depth       Depth of page, used for padding.
             * @param array  $args        An array of wp_list_categories() arguments.
             */
            $css_classes = implode( ' ', apply_filters( 'category_css_class', $css_classes, $category, $depth, $args ) );

            $output .=  ' class="' . $css_classes . '"';
            $output .= ">$link\n";
        } elseif ( isset( $args['separator'] ) ) {
            $output .= "\t$link" . $args['separator'] . "\n";
        } else {
            $output .= "\t$link<br />\n";
        }

        $category_posts = get_posts( array(
            'post_type' => Knowledge_Base_Entry::name,
            'tax_query' => array(
                array(
                    'taxonomy'          => Knowledge_Base_Taxonomy::name,
                    'field'             => 'slug',
                    'terms'             => $category->slug,
                    'include_children'  => false
                )
            )
        ) );

        if( !empty( $category_posts ) ) :


        $output .= '<ul class="post-list tax-' . $category->term_id . '">';

        foreach ( $category_posts as $post ) {

            $post_link = get_post_permalink( $post->ID );

            $output .= '<li>';
            $output .= '<a href="' . esc_url( $post_link ) . '" rel="bookmark">' .$post->post_title . '</a>';
            $output .= '</li>';
        }

        $output .= '</ul>';

        endif;

    }

    /**
     * Ends the element output, if needed.
     *
     * @see Walker::end_el()
     *
     * @since 2.1.0
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $page   Not used.
     * @param int    $depth  Depth of category. Not used.
     * @param array  $args   An array of arguments. Only uses 'list' for whether should append to output. @see wp_list_categories()
     */
    public function end_el( &$output, $page, $depth = 0, $args = array() ) { 
        $output .= "</li>\n";
    }


}
