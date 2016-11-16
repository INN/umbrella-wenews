<?php
/**
 * This is already wrapped in a div.span12
 *
 * @since 0.1
 */
function zone_bigStory() {
	global $shown_ids;

	$bigStoryPost = largo_home_single_top();

	$shown_ids[] = $bigStoryPost->ID;
	$thumbnail = get_the_post_thumbnail($bigStoryPost->ID, 'full');
	$excerpt = largo_excerpt($bigStoryPost, 2, false, '', false);

	ob_start();
	if ( ! empty($thumbnail)) {
		?>
			<a href="<?php echo esc_attr(get_permalink($bigStoryPost->ID)); ?>">
				<?php echo $thumbnail; ?>
			</a>
			<div class="has-thumbnail">
				<div class="has-thumbnail-inner">
					<h2><a href="<?php echo get_permalink($bigStoryPost->ID); ?>"><?php echo $bigStoryPost->post_title; ?></a></h2>
					<h5 class="byline"><?php largo_byline(true, false, $bigStoryPost); ?></h5>
					<section class="excerpt">
						<?php echo $excerpt; ?>
					</section>
				</div>
			</div>
		<?php
	} else {
		?>
			<div class="">
				<h2><a href="<?php echo get_permalink($bigStoryPost->ID); ?>"><?php echo $bigStoryPost->post_title; ?></a></h2>
				<h5 class="byline"><?php largo_byline(true, false, $bigStoryPost); ?></h5>
				<section class="excerpt">
					<?php echo $excerpt; ?>
				</section>
			</div>
		<?php
	}

	wp_reset_postdata();
	$ret = ob_get_contents();
	ob_end_clean();
	return $ret;
}
/**
 * This should emit three div.span4, each with a headline, thumbnail, and other accoutrements
 */
function zone_bigStoryBelow() {
	global $shown_ids;
	
	ob_start();
	$featured_stories = largo_home_featured_stories();

	if ( count($featured_stories) < 3) {
		$recent_stories = wp_get_recent_posts( array(
			'numberposts' => 3 - count($featured_stories),
			'offset' => 0,
			'cat' => 0,
			'orderby' => 'post_date',
			'order' => 'DESC',
			'post__not_in' => $shown_ids,
			'post_type' => 'post',
			'post_status' => 'publish',
		), 'OBJECT');

		$featured_stories = array_merge($featured_stories, $recent_stories);
	}

	foreach($featured_stories as $featured) {
		$shown_ids[] = $featured->ID;
		$thumbnail = get_the_post_thumbnail($featured->ID, 'full'); 
		?>
			<div class="span4">
				<div class="post-lead <?php echo $thumbnail ? 'has-thumbnail' : ''?> ">
					<h5 class="top-tag"><?php largo_top_term(array('post'=> $featured->ID)); ?></h5>
					<?php if (!empty($thumbnail)) { ?>
					<a href="<?php echo esc_attr(get_permalink($featured->ID)); ?>">
						<?php echo $thumbnail ?>
					</a>
					<?php } ?>
					<h3><a href="<?php echo esc_url(get_permalink($featured->ID)); ?>"><?php echo $featured->post_title; ?></a></h3>
					<h5 class="byline"><?php largo_byline(true, true, $featured); ?></h5>
				</div>
			</div>
		<?php
	}
	$ret = ob_get_contents();
	ob_end_clean();
	return $ret;
}

