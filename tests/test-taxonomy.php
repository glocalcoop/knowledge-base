<?php
/**
 * Class Custom Taxonomy
 *
 * @package 
 */

/**
 * Custom Taxonomy tests
 */
class CustomTaxonomyTests extends WP_UnitTestCase {

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
    public function test_kb_taxonomy_exists() {
        $this->assertTrue( taxonomy_exists( Knowledge_Base_Taxonomy::name ) );
    }

    /**
     * Test that taxonomy terms can be added
     */
    public function test_kb_can_add_tax_terms() {
        $kb_cat_ids = $this->factory->term->create_many( 10 );
        $this->assertTrue( 10 == count( $kb_cat_ids ) );
    }

    
}