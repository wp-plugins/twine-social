<div class="tab-pane" id="twine-tab-rules">
	<div class="row-fluid">
	<div class="span12">

		<?php if (!$twinesocial_appdata_json->features->hasRules) {?>

				<!-- start callout -->
				<div class="callout callout-info">
					<H4>About Rules & Collections</H4>
					<p>TwineSocial has a extremely powerful and flexible <b>rules-based</b> Social Routing Engine. You can configure it to do many things, such as:</p>
					<UL>
						<LI>Route all social media that contains the hashtag #superbowl to the Superbowl Collection"</LI>
						<LI>Route all Tweets from @brettfavre to the Packers Collection"</LI>
						<LI>Route all Videos with at least 25 Views to the Top Videos Collection"</LI>
						<LI>Route all Facebook Posts containing the phrase "great service" or "awesome" to the "What Customers Say" Collection</LI>
					</UL>
					<p>Rules are available during your Free Trial, and on our more advanced plans.</p>
					<a class="btn btn-danger" href="http://<?php echo TWINE_CUSTOMER_URL?>/account/choosePlan">Upgrade Now</a>
				</div>
				<!-- end callout -->
			<?php } ?>



			<div class="twine-widget">
				<div class="twine-widget-title">
					Rules
					<div class="twine-widget-close" data-toggle="collapse">X</div>
				</div>
				<div class="twine-widget-content">
					<table class="table table-striped table-hover">
					<thead>
						<TH>Social Hub Name</TH>
						<TH>Rule</TH>
						<TH>&nbsp;</TH>
					</thead>
					<tbody>
					<?php foreach ($twinesocial_appdata_json->apps as $app) { ?>
					<?php foreach ($app->rules as $rule) { ?>
						<TR>
							<TD> <?php echo $app->name?></TD>
							<TD> <?php echo $rule->name?></TD>
							<TD><a target="_blank" class="btn btn-sm btn-default" href="http://<?php echo TWINE_CUSTOMER_URL?>/app/<?php echo $app->baseUrl?>/rules">Edit Rule</a></TD>
						</TR>
					<?php } ?>
					<?php } ?>
					</tbody>
					</table>
				</div>
			</div>


			<a id="btn-rules" class="btn btn-primary btn-sm" href="http://<?php echo TWINE_CUSTOMER_URL?>/app/<?php echo $twinesocial_appdata_json->apps[0]->baseUrl?>/rules/index">Add New Rule</a>
		</div>
	</div>
</div>

