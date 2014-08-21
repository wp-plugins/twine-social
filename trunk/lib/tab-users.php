<div class="tab-pane" id="twine-tab-users">
<div class="row">
	<div class="span12">

		<h3>Users & Security</h3>

			<!-- start callout -->
			<div class="callout callout-info">
				<H4>About Rules & Collections</H4>
				<p>TwineSocial has a extremely flexible <b>rules-based</b> Social Routing Engine. You can configure it to do many things, such as:</p>
				<UL>
					<LI>Route all social media that contains the hashtag #superbowl to the Superbowl Collection"</LI>
					<LI>Route all Tweets from @brettfavre to the Packers Collection"</LI>
					<LI>Route all Videos with at least 25 Views to the Top Videos Collection"</LI>
					<LI>Route all Facebook Posts containing the phrase "great service" or "awesome" to the "What Customers Say" Collection</LI>
				</UL>
			</div>
			<!-- end callout -->

			<p>Once you've setup your Rules and Collections to match your needs, embed your Collections seamlessly on your Wordpress blog.</p>

			<a id="btn-rules" class="btn btn-default btn-sm" href="http://<?php echo TWINE_CUSTOMER_URL?>/app<?php echo json_decode($twinesocial_appdata)->apps[0]->baseUrl?>/rules/index">Configure Rules</a>
			<a id="btn-collections" class="btn btn-default btn-sm" href="http://<?php echo TWINE_CUSTOMER_URL?>/app<?php echo json_decode($twinesocial_appdata)->apps[0]->baseUrl?>/collection/index">Manage Collections</a>
		</div>
	</div>
</div>

