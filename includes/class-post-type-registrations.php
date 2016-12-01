<?php
/**
 * SSM Collections
 *
 * @package   SSM_Collections
 * @license   GPL-2.0+
 */

/**
 * Register post types and taxonomies.
 *
 * @package SSM_Collections
 */
class SSM_Collections_Registrations {

	public $post_type = 'collection';

	public $taxonomies = array( 'collection-category' );

	public function init() {
		// Add the SSM Collections and taxonomies
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Initiate registrations of post type and taxonomies.
	 *
	 * @uses SSM_Collections_Registrations::register_post_type()
	 * @uses SSM_Collections_Registrations::register_taxonomy_category()
	 */
	public function register() {
		$this->register_post_type();
		$this->register_taxonomy_category();
	}

	/**
	 * Register the custom post type.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 */
	protected function register_post_type() {
		$labels = array(
			'name'               => __( 'Collections', 'ssm-collections' ),
			'singular_name'      => __( 'Collection', 'ssm-collections' ),
			'add_new'            => __( 'Add Collection', 'ssm-collections' ),
			'add_new_item'       => __( 'Add Collection', 'ssm-collections' ),
			'edit_item'          => __( 'Edit Collection', 'ssm-collections' ),
			'new_item'           => __( 'New Collection', 'ssm-collections' ),
			'view_item'          => __( 'View Collection', 'ssm-collections' ),
			'search_items'       => __( 'Search Collections', 'ssm-collections' ),
			'not_found'          => __( 'No collections found', 'ssm-collections' ),
			'not_found_in_trash' => __( 'No collections in the trash', 'ssm-collections' ),
		);

		$supports = array(
			'title',
			'thumbnail',
			'genesis-layouts',
			'genesis-seo',
			'genesis-cpt-archives-settings',
		);

		$args = array(
			'labels'          => $labels,
			'supports'        => $supports,
			'public'          => true,
			'capability_type' => 'post',
			'rewrite'         => array( 'slug' => 'collection', ), // Permalinks format
			'menu_position'   => 30,
			'menu_icon'       => 'dashicons-admin-page',
		);

		$args = apply_filters( 'ssm_collections_args', $args );

		register_post_type( $this->post_type, $args );
	}

	/**
	 * Register a taxonomy for Project Categories.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/register_taxonomy
	 */
	protected function register_taxonomy_category() {
		$labels = array(
			'name'                       => __( 'Collection Categories', 'ssm-collections' ),
			'singular_name'              => __( 'Collection Category', 'ssm-collections' ),
			'menu_name'                  => __( 'Collection Categories', 'ssm-collections' ),
			'edit_item'                  => __( 'Edit Collection Category', 'ssm-collections' ),
			'update_item'                => __( 'Update Collection Category', 'ssm-collections' ),
			'add_new_item'               => __( 'Add New Collection Category', 'ssm-collections' ),
			'new_item_name'              => __( 'New Collection Category Name', 'ssm-collections' ),
			'parent_item'                => __( 'Parent Collection Category', 'ssm-collections' ),
			'parent_item_colon'          => __( 'Parent Collection Category:', 'ssm-collections' ),
			'all_items'                  => __( 'All Collection Categories', 'ssm-collections' ),
			'search_items'               => __( 'Search Collection Categories', 'ssm-collections' ),
			'popular_items'              => __( 'Popular Collection Categories', 'ssm-collections' ),
			'separate_items_with_commas' => __( 'Separate collection categories with commas', 'ssm-collections' ),
			'add_or_remove_items'        => __( 'Add or remove collection categories', 'ssm-collections' ),
			'choose_from_most_used'      => __( 'Choose from the most used collection categories', 'ssm-collections' ),
			'not_found'                  => __( 'No collection categories found.', 'ssm-collections' ),
		);

		$args = array(
			'labels'            => $labels,
			'public'            => true,
			'show_in_nav_menus' => true,
			'show_ui'           => true,
			'show_tagcloud'     => true,
			'hierarchical'      => true,
			'rewrite'           => array( 'slug' => 'collection-category' ),
			'show_admin_column' => true,
			'query_var'         => true,
		);

		$args = apply_filters( 'ssm_collections_category_args', $args );

		register_taxonomy( $this->taxonomies[0], $this->post_type, $args );
	}
}