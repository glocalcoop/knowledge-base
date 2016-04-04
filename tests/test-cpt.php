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

    /**
     * Test to see if `get_post` works.
     *
     * Compares a post ID (int) `$org_post_id` with post ID 
     * taken out of get_post `$new_post_id`.
     * If they don't match, `get_post` doesn't work, and it will 
     * return an error.
     */
    public function test_kb_get_post() {
        //Create new post using method provided by WP
        $org_post_id = $this->factory->post->create();

        //Get post object using the new post's ID
        $post_obj = get_post( $org_post_id );
     
        //Get the post ID as given to us by get_post
        $new_post_id = $post_obj->ID;
     
        //Use pre-defined method to test if the two IDs match
        $this->assertEquals( $org_post_id, $new_post_id );
             
    }
}