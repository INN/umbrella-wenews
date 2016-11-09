<?php
/**
 * Functions related to the partners taxonomy user bios
 */

/**
 * Copies from largo_byline() in inc/post-tags.php
 * Modified to output Investigate West Partners for Archives / Sidebars
 * Also used in Women's eNews
 *
 * @link https://github.com/INN/Largo/issues/415
 * @since Largo 0.5.4
 */
	function largo_byline( $echo = true, $exclude_date = false, $post = null ) {
		if (!empty($post)) {
			if (is_object($post)) {
				$post_id = $post->ID;
			} else if (is_numeric($post)) {
				$post_id = $post;
			}
		} else {
			$post_id = get_the_ID();
		}

		$values = get_post_custom( $post_id );

		/* coauthors_posts_links should not be used outside the Loop. see comment on https://github.com/INN/Largo/issues/415 */
		$authors = '';
		// The following logic only applies if the Co-Authors Plus plugin is activated
		if ( function_exists( 'coauthors_posts_links' ) && !isset( $values['largo_byline_text'] ) ) {
			$coauthors = get_coauthors( $post_id );
			foreach( $coauthors as $author ) {
				$byline_text = $author->display_name;
				$show_job_titles = of_get_option('show_job_titles');
				if ( $org = $author->organization )
					$byline_text .= ' (' . $org . ')';

				$byline_temp = '<a class="url fn n" href="' . get_author_posts_url( $author->ID, $author->user_nicename ) . '" title="' . esc_attr( sprintf( __( 'Read All Posts By %s', 'largo' ), $author->display_name ) ) . '" rel="author">' . esc_html( $byline_text ) . '</a>';
				if ( $show_job_titles && $job = $author->job_title ) {
					// Use parentheses in case of multiple guest authorss. Comma separators would be nonsensical: Firstname lastname, Job Title, Secondname Thirdname, and Fourthname Middle Fifthname
					$byline_temp .= ' <span class="job-title"><span class="paren-open">(</span>' . $job . '<span class="paren-close">)</span></span>';
				}

				$out[] = $byline_temp;
		}
			if ( count($out) > 1 ) {
				end($out);
				$key = key($out);
				reset($out);
				$authors = implode( ', ', array_slice( $out, 0, -1 ) );
				$authors .= ' <span class="and">' . __( 'and', 'largo' ) . '</span> ' . $out[$key];
			} else {
				$authors = $out[0];
			}
		// Otherwise, do the Largo thing.
		} else {
			$authors = largo_author_link( false, $post_id );
			$author_id = get_post_meta( $post_id, 'post_author', true );
			$show_job_titles = of_get_option('show_job_titles');
			if ( !isset($values['largo_byline_text']) && $show_job_titles && $job = get_the_author_meta( 'job_title' , $author_id ) ) {
				$authors  .= '<span class="job-title"><span class="comma">,</span>' . $job . '</span>';
			}
		}

		// Don't output the date if $exclude_date is true
		if ( $exclude_date ) {
			$output = sprintf( __('<span class="by-author"><span class="by">By:</span> <span class="author vcard" itemprop="author">%1$s</span></span>', 'largo'),
				$authors
			);
		} else {
			$output = sprintf( __('<span class="by-author"><span class="by">By:</span> <span class="author vcard" itemprop="author">%1$s</span></span><span class="sep"> | </span><time class="entry-date updated dtstamp pubdate" datetime="%2$s">%3$s</time>', 'largo'),
				$authors,
				esc_attr( get_the_date( 'c', $post_id ) ),
				largo_time( false, $post_id )
			);
		}

		if ( current_user_can( 'edit_post', $post_id ) ) {
			$output .=  sprintf( __('<span class="sep"> | </span><span class="edit-link"><a href="%1$s">Edit This Post</a></span>', 'largo'), get_edit_post_link( $post_id ) );
		}

		if ( is_single() && of_get_option( 'clean_read' ) === 'byline' ) {
			$output .=	__('<a href="#" class="clean-read">View as "Clean Read"</a>');
		}

		/*
		 * Historical note
		 *
		 * This function's code is mainly copied from INVW, with some differences.
		 * Where theme-invw hooked invw_partners() on largo_after_post_header action
		 * to output the partners on single posts, and limited this byline addition to
		 * only display on archive pages. That didn't work :(
		 * The byline and largo_after_post_header are separated by the post social buttons
		 * if they are enabled, so the "with Partners" statement is separate.
		 * Thus, we set this conditional to True, and it will now output everywhere, always.
		 *
		 * @link https://bitbucket.org/projectlargo/theme-invw/src/2c3f53bfab5104037d34249f556cad11a14e77ae/functions.php?at=master&fileviewer=file-view-default#functions.php-75
		 * @link https://bitbucket.org/projectlargo/theme-invw/src/2c3f53bfab5104037d34249f556cad11a14e77ae/inc/post-tags.php?at=master&fileviewer=file-view-default
		 */
		if (true) {
			$partners = '';
			$partners_terms_feat = wp_get_object_terms( array($post_id),  'partners' );
			if ( ! empty( $partners_terms_feat ) ) {
				if ( ! is_wp_error( $partners_terms_feat ) ) {
					$partners .= '<div class="partner-byline"><span>From our partner</span> ';
					$counter = 0;
					foreach( $partners_terms_feat as $term_feat ) {
						if($counter > 0 ) {
							$partners .= ', <a href="' . get_term_link( $term_feat->slug, 'partners' ) . '"> ' . esc_html( $term_feat->name ) . '</a>'; 
						} else {
							$partners .= '<a href="' . get_term_link( $term_feat->slug, 'partners' ) . '"> ' . esc_html( $term_feat->name ) . '</a>'; 
						}
						$counter++;
					}
					$partners .= '</div>';
				}
			}
			$output .= $partners;
		}

		if ( $echo ) {
			echo $output;
		}

		return $output;
	}
