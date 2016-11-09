<?php
/**
 * The default template for displaying content
 */
$tags = of_get_option('tag_display');
$values = get_post_custom($post->ID);
$entry_classes = 'entry-content';
$thumbnail = get_the_post_thumbnail( $post->ID, 'full' ); 

wp_enqueue_script('category-interviews', get_stylesheet_directory_uri() . '/js/category-interviews.js', array('jquery'), 0.1, true);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix span4'); ?>>
	<div class="post-lead <?php echo $thumbnail ? 'has-thumbnail' : ''?> ">
		<h5 class="top-tag"><?php largo_top_term(array('post'=> $post->ID)); ?></h5>
		
		<?php if( has_post_thumbnail() ){ ?>
			<header>
				<div>
				<?php 	
					echo( '<a href="' . get_permalink() . '" title="' . the_title_attribute( array( 'before' => __( 'Permalink to', 'largo' ) . ' ', 'echo' => false ) ) . '" rel="bookmark">' );
					the_post_thumbnail( 'full' );
					echo( '</a>' ); 
				?>
				</div>
			</header>	
		<?php } //endif ?>
		
			<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>"
				title="<?php the_title_attribute( array( 'before' => __( 'Permalink to', 'largo' ) . ' ' ) )?>"
				rel="bookmark"><?php the_title(); ?></a>
			</h2>

		<h5 class="byline"><?php largo_byline(true, false, $post); ?></h5>

	</div><!-- .entry-content -->
</article><!-- #post-<?php the_ID(); ?> -->
