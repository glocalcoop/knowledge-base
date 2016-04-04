<?php
/**
 * Class Test Shortcode
 *
 * @package 
 */

/**
 * Shortcode Test Cases
 */
class ShortcodeTestCase extends WP_UnitTestCase {

    /**
     * Running the shortcode by itself should not raise any PHP warnings.
     */
     public function test_evoke_shortcode() {
        do_shortcode( '[knowledge-base]' );
    }

}