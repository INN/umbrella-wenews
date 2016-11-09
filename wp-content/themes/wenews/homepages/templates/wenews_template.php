<div class="row">
	<div class="span8">
		<?php 
			if (of_get_option('show_sticky_posts')) {
				get_template_part('partials/sticky-posts');
			}
		?>
		<div class="row clearfix">
			<div class="span12 topstory">
				<?php echo $bigStory; ?>
			</div>
		</div>
		<div class="row clearfix topstory-below">
			<?php echo $bigStoryBelow; ?>
		</div>
		<div class="row widget-area clearfix">
			<div class="span6">
				<?php if (!dynamic_sidebar('Homepage Left Featured Area')) { ?>
					<p>You need to add one "Recent Posts Widget" to the "Homepage Left Featured Area" sidebar.
				<?php } ?>
			</div>
			<div class="span6">
				<?php if (!dynamic_sidebar('Homepage Right Featured Area')) { ?>
					<p>You need to add one "Recent Posts Widget" to the "Homepage Right Featured Area" sidebar.
				<?php } ?>
			</div>
		</div>
	</div><!-- end of span8 main content -->

	<div id="sidebar" class="span4">
		<div class="widget-area">
			<?php if (!dynamic_sidebar('sidebar-main')) { ?>
				<p><?php _e('Please add widgets to this content area in the WordPress admin area under Appearance > Widgets.', 'largo'); ?></p>
			<?php } ?>
		</div>
	</div><!-- end of span4 sidebar -->
</div>

<?php /* the ad zone here is designed to cut across the entire page. Thus, it is outside the 8/4 split */ ?>
<div class="ad-zone center row-fluid clearfix">
	<div class="span12">
		
		<?php if (!dynamic_sidebar('Homepage Ad Widget')) { ?>
			<!--<div style="display:block;width:768px;height:90px;margin:0 auto;background-color:#ddd;color:#bb0000; text-align: center;"> Add an ad widget to the "Homepage Ad Widget" sidebar</div>-->
		<?php } ?>
	</div>
</div>
