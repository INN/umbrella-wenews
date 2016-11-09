<?php

include_once get_template_directory() . '/homepages/homepage-class.php';
include_once get_stylesheet_directory() . '/homepages/zones/wenews_zones.php';

class wenews_layout extends Homepage {
	function __construct( $options = array() ) {
		$defaults = array(
			'name' => __("Women's eNews", 'wenews'),
			'type' => 'wenews',
			'description' => __('Homepage layout for Womens eNews', 'wenews'),
			'template' => get_stylesheet_directory() . '/homepages/templates/wenews_template.php',
			'assets' => array(
				array(
					'wenews_homepage_css',
					get_stylesheet_directory_uri() . '/homepages/assets/css/homepage.css',
					array()
				)
			),
			'prominenceTerms' => array(
				array(
					'name' => __('Top Story', 'largo'),
					'description' => __('If you are using a "Big story" homepage layout, add this label to a post to make it the top story on the homepage', 'largo'),
					'slug' => 'top-story'
				)
			)
		);
		$options = array_merge($defaults, $options);
		parent::__construct($options);
	}

	/*
	 * List of zones for this theme:
	 * 
	 * - big story
	 * - three posts below big story
	 * - recent posts widget: three stories, no widget headline
	 * - recent posts widget: one story, widget headline, big thumbnail, "more from "
	 * - ad widget
	 * - end of custom stuff I think
	 * - More wenews stories: three stories horizontally, LMP button
	 */
	function bigStory() {
		return zone_bigStory();
	}

	function bigStoryBelow() {
		return zone_bigStoryBelow();
	}
}


/**
 * Adds the front-page widget areas
 *
 * @since 0.1
 */
function wenews_add_homepage_widget_areas() {
	$sidebars = array(
		array(
			'name' => 'Homepage Left Featured Area',
			'id' => 'homepage-left-widget-area',
			'description' => __('The left-hand of the two widgets that appear on the homepage beneath the three featured posts. Place one widget here.', 'wenews'),
			'before_widget' => '<div class="widget">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="center visuallyhidden">',
			'after_title' => '</h3>',
		),
		array(
			'name' => 'Homepage Right Featured Area',
			'id' => 'homepage-right-widget-area',
			'description' => __('The right-hand of the two widgets that appear on the homepage beneath the three featured posts. Place one widget here.', 'wenews'),
			'before_widget' => '<div class="widget">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="center">',
			'after_title' => '</h3>',
		),
		array(
			'name' => 'Homepage Ad Widget',
			'id' => 'homepage-ad-widget',
			'description' => __('You should put one advertisement widget here.', 'wenews'),
			'before_widget' => '',
			'after_widget' => '',
			'before_title' => '<h3 class="visuallyhidden">',
			'after_title' => '</h3>',
		),
	);
	foreach ($sidebars as $sidebar) {
		register_sidebar($sidebar);
	}
}
add_action('widgets_init', 'wenews_add_homepage_widget_areas');
