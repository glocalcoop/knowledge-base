<?php
/**
 * Class Test Shortcode
 *
 * @package 
 */

/**
 * Custom Post Type tests
 */
class ShortcodeTestCase extends WP_UnitTestCase {

    /**
     * Sets up the testing environment before each test.
     *
     * @link https://phpunit.de/manual/current/en/fixtures.html
     */
    public function setUp() {
        parent::setUp();
        Knowledge_Base_Shortcode::$invocations = 0;
    }

    /**
     * Running the shortcode by itself should not raise any PHP warnings.
     */
     public function test_evoke_shortcode() {
        do_shortcode( '[knowledge-base]' );
    }

    /**
     * Ensure that the shortcode can correctly count how many times it's been invoked.
     */
    public function test_correctly_count_invocations() {
        for ($i = 0; $i < 5; $i++) {
            do_shortcode('[knowledge-base]');
        }
        $this->assertSame( 5, Knowledge_Base_Shortcode::$invocations );
    }

}