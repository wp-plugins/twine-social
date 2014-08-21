<div class="tab-pane" id="twine-tab-collections">
	<div class="row-fluid">
	<div class="span12">

			<!-- start callout -->
			<div class="callout callout-info">
				<H4>About Collections</H4>
				<p>TwineSocial has a extremely powerful and flexible <b>Collections</b> feature. Collections can be individually displayed throughout your Wordpress Site. A collection could be:</p>
				<UL>
					<LI>All posts that contain the hashtag #superbowl</LI>
					<LI>All Tweets from @brettfavre</LI>
					<LI>All Videos with at least 25 Views</LI>
					<LI>All Facebook Posts containing the phrase "great service" or "awesome"</LI>
				</UL>
			</div>
			<!-- end callout -->


			<div class="twine-widget">
				<div class="twine-widget-title">
					My Collections
					<div class="twine-widget-close" data-toggle="collapse">X</div>
				</div>
				<div class="twine-widget-content">
					<table class="table table-striped table-hover">
					<thead>
						<TH>Social Hub Name</TH>
						<TH>Collection Name</TH>
						<TH>&nbsp;</TH>
					</thead>
					<tbody>
					<?php foreach ($twinesocial_appdata_json->apps as $app) { ?>
					<?php foreach ($app->collections as $collection) { ?>
						<TR>
							<TD> <?php echo $app->name?></TD>
							<TD> <?php echo $collection->name?></TD>
							<TD><a target="_blank" class="btn btn-sm btn-default" href="http:<?php echo TWINE_CUSTOMER_URL?>/app/<?php echo $app->baseUrl?>/collection">Edit Collection</a></TD>
						</TR>
					<?php } ?>
					<?php } ?>
					</tbody>
					</table>
					<a target="_blank" id="btn-rules" class="btn btn-primary btn-sm" href="http:<?php echo TWINE_CUSTOMER_URL?>/app/<?php echo $twinesocial_appdata_json->apps[0]->baseUrl?>/rules/index">Add New Collection</a>
				</div>
			</div>
		</div>
	</div>
</div>

