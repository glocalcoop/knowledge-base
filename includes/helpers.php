<?php
/**
 * Helper Functions
 *
 * @link       https://glocal.coop
 * @since      0.1.2
 *
 * @package    Knowledge_Base
 * @subpackage Knowledge_Base/includes
 */

function knowledge_base_get_option( $option = false, $default = false ) {

    $defaults = array(
        'post_slug' => 'knowledge-base',
        'tax_slug' => 'knowledge-base-category',
    );

    $options = get_option( 'kb_settings', $defaults );
    $options = wp_parse_args( $options, $defaults );

    $options = apply_filters( 'kb_settings', $options );

    if ( false === $option ) {
        return $options;
    }

    if ( ! isset( $options[$option] ) ) {
        return $default;
    }

    return $options[$option];
}