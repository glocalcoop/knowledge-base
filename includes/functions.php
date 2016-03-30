<?php
/**
 * Convenience functions and templating wrappers.
 *
 * @license https://www.gnu.org/licenses/gpl-3.0.en.html
 *
 * @copyright Copyright (c) 2016 TK-TODO
 *
 * @package WordPress\Plugin\Knowledge_Base
 */

if ( !function_exists( 'get_knowledge_base_terms' ) ) :
    /**
     * Gets all categories in the knowledge base.
     *
     * @uses get_terms()
     *
     * @return array|false|WP_Error
     */
    function get_knowledge_base_terms() {
        $terms = get_terms( Knowledge_Base_Taxonomy::name, array(
            'hide_empty' => true,
        ) );
        return $terms;
    }
endif;

if ( !function_exists( 'get_entry_terms' ) ) :
    /**
     * Gets the categories assigned to a given blog in the network directory.
     *
     * @param int $blog_id Optional. The ID of the site in question. Default is the blog ID of the current directory entry.
     *
     * @uses get_the_terms()
     *
     * @return array|false|WP_Error
     */
    function get_entry_terms( $post_id = 0 ) {
        $cpt = new Knowledge_Base_Entry();
        if ( !$post_id ) {
            global $post;
            $post_id = $post->ID;
        }
        $terms = get_the_terms( $post_id, Knowledge_Base_Taxonomy::name );
        return $terms;
    }
endif;

if ( !function_exists( 'get_entries_by_term' ) ) :
    /**
     * Retrieves the details of sites in the directory assigned the given term.
     *
     * @param WP_Term $term
     * @param array $args
     *
     * @return array
     */
    function get_entries_by_term( $term, $args = array() ) {
        $args = wp_parse_args( $args, array(
            'numberposts' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => $term->taxonomy,
                    'field' => 'id',
                    'terms' => array( $term->term_id ),
                ),
            ),
        ));
        $cpt = new Knowledge_Base_Entry();
        $posts = $cpt->get_posts( $args );
        $details = array();
        foreach ( $posts as $post ) {
            $details[] = $post;
        }
        return $details;
    }
endif;
