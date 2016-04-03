<?php
/**
 * Class Custom Post Type
 *
 * @package 
 */

/**
 * Custom Post Type tests
 */
class CustomPostTypeTests extends WP_UnitTestCase {

    /**
     * Sets up the testing environment before each test.
     *
     * @link https://phpunit.de/manual/current/en/fixtures.html
     */
    public function setUp () {
        parent::setUp();
    }

    /**
     * Test that the custom post type exists
     */
    public function test_kb_post_type_exists() {
        $this->assertTrue( post_type_exists( 'knowledge_base' ) );
    }

    /**
     * Test that the post is created and has correct type and author
     */
    public function test_kb_post_created() {
        $user_id = 5;
        $post_type = 'knowledge_base';
        $post = $this->factory->post->create_and_get(
            array( 
                'post_author'   => $user_id, 
                'post_type'     => $post_type 
            )
        );
        $this->assertNotEmpty( $post );
        $this->assertTrue( $user_id == $post->post_author );
        $this->assertTrue( $post_type == $post->post_type );
    }
}