<?php
/*
 * Template Name: Syndication Content
 *
 * A feed of stories available to syndication parterns.
 * Use inn.org/?feed=member_stories for all stories in the "For Syndication" prominence taxonomy term
 */

$term = "for-syndication";

function rss_date( $timestamp = null ) {
  $timestamp = ($timestamp==null) ? time() : $timestamp;
  echo date(DATE_RSS, $timestamp);
}

$args = array (
	'showposts' => 20,
	'post_status' => 'publish',
	'tax_query' => array(
		array(
			'taxonomy' 	=> 'prominence',
			'field' 	=> 'slug',
			'terms' 	=> $term
		),
	),
);

$query = new WP_Query( $args );


	header("Content-Type: application/rss+xml; charset=UTF-8");
	echo '<?xml version="1.0" encoding="UTF-8" ?>';
	echo "\n";
?>
	<rss version="2.0" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:media="http://search.yahoo.com/mrss/">
	<channel>
		<title>Women's eNews: Syndication content</title>
		<link>http://womensenews.org/</link>
		<description>Stories available to Women's eNews syndication partners</description>
		<language>en-us</language>
<?php
if ( $query->have_posts() ) {
	while ( $query->have_posts() ) : $query->the_post();
		$permalink = get_permalink();
?>
		<item>
			<title><?php echo get_the_title($post->ID); ?></title>
			<link><?php echo $permalink; ?></link>
			<description><?php echo '<![CDATA[' . get_the_content() . ']]>';  ?></description>
			<pubDate><?php rss_date( strtotime( $post->post_date_gmt ) ); ?></pubDate>
			<guid><?php echo $permalink; ?></guid>
			<?php
				if ( get_the_post_thumbnail( $post->ID ) ) {
					$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ) );
					echo '<media:content url="' . $image[0] . '" medium="image" />';
					echo "\n";
				}
			?>
		</item>

	<?php endwhile; ?>
<?php
} else {
	header("Content-Type: application/rss+xml; charset=UTF-8");
	echo '<?xml version="1.0" encoding="UTF-8"?>';
} ?>
	</channel>
	</rss>
