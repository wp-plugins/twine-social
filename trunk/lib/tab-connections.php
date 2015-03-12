<div class="tab-pane" id="twine-tab-connections">
	<div class="row-fluid">
		<div class="span12">


			<?php if (!$twinesocial_appdata_json->features->hasRules) {?>

				<!-- start callout -->
				<div class="callout callout-info">
					<H4>About Social Network Connections</H4>
					<p>You'll need to let TwineSocial connect to each of your social networks on your behalf to import your content. TwineSocial supports all major social media networks, like Facebook, Twitter, Instagram, Flickr, and more.</p>
				</div>
				<!-- end callout -->
			<?php } ?>


			<div class="twine-widget">
				<div class="twine-widget-title">
					Social Network Connections
					<div class="twine-widget-close" data-toggle="collapse">X</div>
				</div>
				<div class="twine-widget-content">

					<table class="table table-striped table-hover">
					<thead>
						<TH>Social Network</TH>
						<TH>Name</TH>
						<TH>Active</TH>
						<TH>&nbsp;</TH>
					</thead>
					<tbody>
					<?php foreach ($twinesocial_appdata_json->campaigns as $campaign) { ?>
					<?php foreach ($campaign->connections as $connection) { ?>
						<TR>
							<TD><i class="fa fa-<?php echo $connection->cssClass?>"></i> <?php echo $connection->network?></TD>
							<TD>
								<?php echo $connection->fullName ? $connection->fullName : $connection->username?>
							</TD>
							<TD>
								<?php if ($connection->isActive) { ?>
									<i class="fa fa-check"></i>
								<?php } ?>
							</TD>
							<TD><a target="_blank" class="btn btn-sm btn-default" href="http:<?php echo TWINE_CUSTOMER_URL?>/app/<?php echo $campaign->baseUrl?>/connection">Edit Connection</a></TD>
						</TR>
					<?php } ?>
					<?php } ?>
					</tbody>
					</table>
					<a id="btn-rules" class="btn btn-primary btn-sm" href="http:<?php echo TWINE_CUSTOMER_URL?>/app/<?php echo $twinesocial_appdata_json->campaigns[0]->baseUrl?>/connection/index">Add New Social Connection</a>
				</div>
			</div>
		</div>
	</div>
</div>

