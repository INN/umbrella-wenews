## Theme Options:

- Basic Settings:
	- Show site name in sticky nav? No
- Layout Options:
	- Number of posts to display on the homepage: 3. No more, no less.
- Theme Options:
	- Sticky nav image is uploaded to Slack.
- Advanced:
	- Enable Series Taxonomy: Yes
	- Optional Leaderboard Ad Zone: Yes

## Widgets

This theme assumes the presence of these widgets in these places:

- Main Sidebar
	- Saved Links widget
		- Title: "Daily Digest"
	- Series widget
		- (This is a widget highlighting all the series (or the most-recently-updated)
		- 3-n series, with thumbnail and title of most-recent post in series, and link to the series
		- more series link at bottom
	- Call to action/events house ad
	- Newsletter signup form.
- Homepage Left Featured Area
	- Recent Posts Widget
		- Title: none
		- Count: 3
		- Avoid Duplicate: yes
		- Thumnail: none
		- Excerpt: none
		- Byline: yes
		- Top Term: no
		- Read more: no
		- Limits: none
		- More Link: none
- Homepage Right Featured Area
	- Recent Posts Widget
		- Title: Teen Voices
		- Count: 1
		- Avoid duplicates: yes
		- Thumbnail: Large
		- Excerpt: none
		- Excerpt lenght: 0
		- Byline: no
		- Top term: no
		- Read more: no
		- Limit by category: Teen Voices
		- More link text: More from Teen Voices
		- More link link: link for the Teen Voices category
		- Title link: link from Teen Voices category
- Homepage Ad Widget
	- DoubleClick for WordPress ad widget

## Syndication RSS feed

To add a post to the RSS feed read by syndication partners, mark it with the "For Syndication" prominence term in the post editor.


## Mailchimp Widget signup code

Paste the following into a text widget in the Main sidebar:

	<!-- Begin MailChimp Signup Form -->
	<div id="mc_embed_signup">
	<p>Get updates from Women's eNews in your inbox every day.</p>
	<form action="//womensenews.us12.list-manage.com/subscribe/post?u=f8aa48cf51fc5769dc5ce8dd9&amp;id=4295884df2" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
		<div id="mc_embed_signup_scroll">
	<div class="mc-field-group">
		<label for="mce-EMAIL">Email Address </label>
		<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" placeholder="Email">
	</div>
		<div id="mce-responses" class="clear">
			<div class="response" id="mce-error-response" style="display:none"></div>
			<div class="response" id="mce-success-response" style="display:none"></div>
		</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
		<div aria-hidden="true" class="visuallyhidden"><input type="text" name="b_f8aa48cf51fc5769dc5ce8dd9_4295884df2" tabindex="-1" value=""></div>
		<div class="clearfix"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button"></div>
		</div>
	</form>
	</div>
	<!--End mc_embed_signup-->

## The [partners] shortcode

To output a list of all partners, add `[partners]` to a page or post.

To exclude a partner, add it to the shortcode: `[partners exclude="73628"]`

To exclude multiple partners, separate them by commas: `[partners exclude="73628,2545"]`

To only show certain partners, use the `include` attribute: `[partners include="23034"]`

If `include` and `exclude` are both used, `include` overrides `exclude` and only the partners in `include` will be displayed.

To find a partner's ID, go to the Dashboard, click on Posts, then on Partners. Find the partner you wish to find the ID of, and click "Edit". Copy the URL from your browser. In the URL `http://womensenews.org/wp-admin/edit-tags.php?action=edit&taxonomy=partners&tag_ID=73628&post_type=post`, the useful part is `&tag_ID=73628`, where `73628` is the ID that you would add to `include=""` or `exclude=""`.
