<?php
	
function wenews_custom_taxonomies() {
	register_taxonomy(
		'partners',
		'post',
		array(
			'hierarchical' => true,
			'labels' => array(
				'name' => _x( 'Partners', 'taxonomy general name' ),
				'singular_name' => _x( 'Partner', 'taxonomy singular name' ),
				'search_items' => __( 'Search Partners' ),
				'all_items' => __( 'All Partners' ),
				'parent_item' => __( 'Parent Partner' ),
				'parent_item_colon' => __( 'Parent Partner:' ),
				'edit_item' => __( 'Edit Partner' ),
				'view_item' => __( 'View Partner' ),
				'update_item' => __( 'Update Partner' ),
				'add_new_item' => __( 'Add New Partner' ),
				'new_item_name' => __( 'New Partners Name' ),
				'menu_name' => __( 'Partners' ),
			),
			'query_var' => true,
			'show_admin_column' => true,
			'rewrite' => true,
		)
	);
}
add_action( 'init', 'wenews_custom_taxonomies' );

/**
 * Register the Teen Voices Bottom widget area
 *
 * @link http://jira.inn.org/browse/WE-78
 */
function wenews_register_teen_voices_widget_area() {
	register_sidebar(array(
		'name' => 'Teen Voices Bottom',
		'id' => 'teen-voices-bottom',
		'before_widget' => '<aside id="%1$s" class="%2$s clearfix">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>'
	));
}
add_action( 'widgets_init', 'wenews_register_teen_voices_widget_area' );
/**
 * Function to output the Teen Voices Bottom widget area
 *
 * @action largo_after_post_content
 * @link http://jira.inn.org/browse/WE-78
 */
function wenews_teen_voices_widget_area() {
	if ( in_category('teen-voices') ) {
		echo '<div class="article-bottom nocontent">';
		dynamic_sidebar('teen-voices-bottom');
		echo "</div>";
	}
}
add_action( 'largo_before_post_bottom_widget_area', 'wenews_teen_voices_widget_area', 11 );
