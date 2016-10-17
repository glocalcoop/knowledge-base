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
        'archive_label' => __( 'Knowledge Base', 'knowledge-base' ),
    );

    $options = get_option( 'kb_settings', $defaults );

    foreach( $options as $key => $value ) {
        if( empty( $options[$key] ) ) {
            $options[$key] = $defaults[$key];
        }
    }

    return $options[$option];
}
