<?php
/**
 * Functions related to the partners page and the shortcode that powers it.
 */

/**
 * Output a list of terms in the Partners taxonomy, with top stories.
 *
 * Setting 'exclude=""' to a list of comma-separated IDs will exclude those partner IDs from the listing.
 * Setting 'include=""' to a list of comma-separated IDs will make the shortcode *only* return those partner IDs.
 *
 * @link https://developer.wordpress.org/reference/functions/get_terms/
 */
function partners_shortcode( $atts, $context, $tag ) {
	/*
	 * Gather the terms
	 */
	// For details of how these args work, see get_terms: https://developer.wordpress.org/reference/functions/get_terms/
	// get_terms is called by get_categories: https://developer.wordpress.org/reference/functions/get_categories/
	$tax_args = array(
		'orderby' 	=> 'name',
		'taxonomy' 	=> 'partners',
		'hide_empty' => false,
	);
	if ( isset($atts['exclude']) ) {
		$tax_args['exclude'] = $atts['exclude'];
	}
	if ( isset($atts['include']) ) {
		$tax_args['include'] = $atts['include'];
	}

	$partners = get_categories($tax_args);

	/*
	 * output the terms
	 */
	ob_start();
	echo '<div class="partners-listing">';
	foreach ( $partners as $out ) {

		$args = array(
			'tax_query' => array(
				array(
					'taxonomy' 	=> 'partners',
					'field' 	=> 'slug',
					'terms' 	=> $out->slug
				)
			),
			'showposts'	=> 1
		);
		$query = new WP_Query($args);
		if ( $query->have_posts() )  {
			while ( $query->have_posts() ) {
				$query->the_post();
				$thumbnail = sprintf(
					'<a href="%s">%s</a>',
					get_term_link( $out, $out->taxonomy ),
					get_the_post_thumbnail(get_the_ID())
				);
				$postlink = sprintf(
					'<p class="recent"><strong>%s</strong> <a href="%s">%s</a></p>',
					__('Latest Post:', 'wenews'),
					get_permalink(),
					get_the_title()
				);
			}
		} else {
			$thumbnail = '';
			$postlink = '';
		}
		?>
			<div class="item <?php echo $out->term_id; ?>">
				<?php echo $thumbnail; ?>
				<h3><a href="<?php echo get_term_link( $out, $out->taxonomy ); ?>"><?php echo $out->name; ?></a></h3>
				<?php if ($out->category_description) echo '<p>' . $out->category_description . '</p>'; ?>
				<?php echo $postlink; ?>
			</div>
		<?php
	}
	echo '</div>';

	$ret = ob_get_clean();
	return $ret;
}
add_shortcode('partners', 'partners_shortcode');
