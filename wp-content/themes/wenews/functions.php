<?php

/**
 * Includes
 */
$includes = array(
	'/inc/taxonomies.php', // add custom taxonomies, sidebars
	'/inc/post-tags.php', // custom largo_byline for partners
	'/inc/partners-shortcode.php',
	'/inc/widgets/partners-bio.php'
);
// Perform load
foreach ( $includes as $include ) {
	require_once( get_stylesheet_directory() . $include );
}

/**
 * Include compiled style.css
 */
function wenews_stylesheet() {
	wp_dequeue_style( 'largo-child-styles' );

	wp_enqueue_style( 'wenews', get_stylesheet_directory_uri() . '/css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'wenews_stylesheet', 20 );

/**
 * Include fonts from Typekit
 */
function wenews_typekit() { ?>
	<script src="https://use.typekit.net/bzd6qmw.js"></script>
	<script>try{Typekit.load({ async: true });}catch(e){}</script>
<?php }
add_action( 'wp_head', 'wenews_typekit' );

/**
 * Add the mailchimp.js file.
 *
 * @since 1.0
 */
function mailchimp_enqueue_script() {
	$version = '0.1.0';
	wp_enqueue_script('current',get_stylesheet_directory_uri() . '/js/mailchimp.js',array('jquery'),$version,true);
}
add_action('wp_enqueue_scripts', 'mailchimp_enqueue_script');

/**
 * Register the custom homepage layout
 *
 * @since 0.1
 */
function wenews_register_custom_homepage_layout() {
	include_once __DIR__ . '/homepages/layouts/wenews_layout.php';
	register_homepage_layout('wenews_layout');
}
add_action('init', 'wenews_register_custom_homepage_layout', 0);

/**
 * Add the "Original Content for Syndication" prominence term
 *
 * For WE-21: per discussion there, we're making a Prominence Term that makes an RSS feed of posts
 * with full content included in the RSS feed. This is a way of marking posts for that feed.
 *
 * @since 0.1
 * See also YT-37, the JJIE ticket that this code is copied from.
 */
function wenews_add_homepage_large_image_prominence($termsDefinitions) {
	$termsDefinitions[] = array(
		'name' => __("For Syndication", 'wenews'),
		'description' => __("Add this label to posts to add them to the RSS feed that syndication partners check.", 'wenews'),
		'slug' => 'for-syndication',
	);
	return $termsDefinitions;
}
add_filter('largo_prominence_terms', 'wenews_add_homepage_large_image_prominence', 0);

/**
 * Add custom RSS feed for syndication content
 *
 * The filter on pre_option_rss_use_excerpt returns zero, making the option to use the excerpt in the RSS, in this instance, false.
 *
 * Template used is feed-syndication-content.php
 * @see https://codex.wordpress.org/Plugin_API/Filter_Reference/pre_option_(option_name)
 */
function wenews_syndication_rss() {
	add_filter('pre_option_rss_use_excerpt', '__return_zero');
	load_template( get_stylesheet_directory() . '/feed-syndication-content.php' );
}
add_feed( 'syndication', 'wenews_syndication_rss' );

/**
 * Use "recent news" instead of "saved links" for saved links archive page title
 */
function wenews_archive_rounduplink_title() {
	$title = __( 'Recent News', 'wenews' );
	return $title;
}
add_filter( 'largo_archive_rounduplink_title', 'wenews_archive_rounduplink_title' );

/**
 * Override Largo's Google Analytics function, adding some GA Classic suctom variables
 *
 * @link https://developers.google.com/analytics/devguides/collection/gajs/gaTrackingCustomVariables#overview
 * @see largo_google_analytics
 * @since Largo 0.5.4
 */
	function largo_google_analytics() {
		if ( !current_user_can('edit_posts') ) : // don't track editors ?>
			<script>
			    var _gaq = _gaq || [];
			<?php if ( of_get_option( 'ga_id', true ) ) : // make sure the ga_id setting is defined ?>
				_gaq.push(['_setAccount', '<?php echo of_get_option( "ga_id" ) ?>']);
				<?php
					/*
					 * Add the Teen Voices category as a custom variable on the Google Analytics Object
					 * This occurs in between _setAccount and _trackPageView because of order requirements.
					 */
					$catstring = '';

					// Find out if this page is in the Teen Voices category
					if ( is_category() ) {
						$category = get_queried_object();
						$catstring = $category->cat_name;
					} else if ( is_single() ) {
						$teen_voices = get_term_by('slug', 'teen-voices', 'category', 'ARRAY_A');
						if ( has_term( $teen_voices['term_id'], 'category', get_the_ID() ) ) {
							$catstring = $teen_voices['name'];
						}
					}

					// Generate the analytics output iff the post is in the Teen Voices category
					if ( !empty( $catstring ) ) {
						$gaq = sprintf(
							"_gaq.push(['_setCustomVar', 1, 'category', '%1\$s', 3 ]);",
							$catstring
						);
						echo $gaq;
					}

				?>
				_gaq.push(['_trackPageview']);
			<?php endif; ?>

				<?php if (defined('INN_MEMBER') && INN_MEMBER) { ?>
				_gaq.push(
					["inn._setAccount", "UA-17578670-2"],
					["inn._setCustomVar", 1, "MemberName", "<?php bloginfo('name') ?>"],
					["inn._trackPageview"]
				);
				<?php } ?>
			    _gaq.push(
					["largo._setAccount", "UA-17578670-4"],
					["largo._setCustomVar", 1, "SiteName", "<?php bloginfo('name') ?>"],
					["largo._setDomainName", "<?php echo parse_url( home_url(), PHP_URL_HOST ); ?>"],
					["largo._setAllowLinker", true],
					["largo._trackPageview"]
				);

			    (function() {
				    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
				})();
			</script>
	<?php endif;
	}
