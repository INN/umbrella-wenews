<?php
/**
 * Partners Bio
 *
 * This widget can be used in the article-bottom zone to show informatino about the post's partners.
 * Copied from Largo's Author Bio widget
 *
 * @package Largo
 */
class wenews_partners_bio extends WP_Widget {

	/*
	 * Set up the widget
	 */
	function __construct() {
		$widget_ops = array(
			'classname' 	=> 'wenews-partners-bio',
			'description'	=> __('Display informatino about partners on a post', 'wenews')
		);
		parent::__construct( 'wenews-partners-bio', __('Partners Bio', 'wenews'), $widget_ops);
	}

	/*
	 * Render the widget output
	 */
	function widget( $args, $instance ) {

		global $post;

		extract( $args );

		$partners = array();
		$bios = '';

		if ( is_singular() ) {
			$partners = wp_get_object_terms( array($post->ID), 'partners' );
			foreach ( $partners as $partner ) {
				if ( !is_wp_error($partner) ) {
					$partners_meta = largo_get_term_meta_post('partners', $partner->term_id);
					echo '<div class="author-box row-fluid author vcard clearfix">';
					printf(
						__( '<h3 class="widgettitle">About <span class="fn n"><a class="url" href="%1$s" rel="author" title="See all posts by %2$s">%2$s</a></span></h3>', 'largo' ),
						get_term_link( $partner->term_id, $partner->taxonomy ),
						esc_attr( $partner->name )
					);

					// thumbnail image!
					if ( largo_has_featured_media( $partners_meta ) ) {
						$photo = get_the_post_thumbnail ( $partners_meta, array( 96,96 ) );
						$photo = str_replace( 'attachment-96x96 wp-post-image', 'avatar avatar-96 photo', $photo );
						echo '<div class="photo">' . $photo . '</div>';
					}

					// description
					if ( $partner->description ) {
						echo '<p>' . $partner->description . '</p>';
					}

					echo '</div>';
				}
			}
		}
	}


	/*
	 * Widget update function: sanitizes title.
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field( $new_instance['title'] );
		return $instance;
	}

	/*
	 * This widget has no configuration
	 */
	function form( $instance ) {
		return true;
	}
}
register_widget('wenews_partners_bio');
