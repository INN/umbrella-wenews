<?php
/*
 * Largo Header
 *
 * Calls largo_header() output function and displays print header
 *
 * @package Largo
 * @see inc/header-footer.php
 */
if ( ! is_single() && ! is_singular() || ! of_get_option( 'main_nav_hide_article', false ) ) {
?>
 <header id="site-header" class="clearfix nocontent" itemscope itemtype="http://schema.org/Organization">
	<?php /* docs in inc/header-footer.php */
	largo_header();
	?>
	
		<!-- Begin MailChimp Signup Form -->
		<div id="mc_embed_signup" class="newsletter-signup">
			<form action="//womensenews.us12.list-manage.com/subscribe/post?u=f8aa48cf51fc5769dc5ce8dd9&amp;id=b4ab36a284" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
				<span>Subscribe to our mailing list</span>
				<fieldset>
					<label class="visuallyhidden" for="mce-EMAIL">Email Address</label>
					<input required type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Email address"/>
					<label class="visuallyhidden" for="mce-FNAME">First Name </label>
					<input type="text" value="" name="FNAME" class="hidden-start" id="mce-FNAME" placeholder="First name"/>
					<label class="visuallyhidden" for="mce-LNAME">Last Name </label>
					<input type="text" value="" name="LNAME" class="hidden-start" id="mce-LNAME" placeholder="Last name"/>
					<ul class="hidden-start">
						<li><input type="checkbox" value="1" name="group[3181][1]" id="mce-group[3181]-3181-0" checked><label for="mce-group[3181]-3181-0">Women's eNews</label></li>
					</ul>
				<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
					<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text" name="b_f8aa48cf51fc5769dc5ce8dd9_b4ab36a284" tabindex="-1" value=""></div>
					<div class="clear "><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
				</fieldset>
			</form>
		</div>
		<!--End mc_embed_signup-->
</header>
<header class="print-header nocontent">
	<p>
		<strong><?php echo esc_html( get_bloginfo( 'name' ) ); ?></strong>
		(<?php echo esc_url(largo_get_current_url()); ?>)
	</p>
</header>
<?php }
