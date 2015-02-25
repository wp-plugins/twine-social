<div class="tab-pane" id="twine-tab-feeds">

	<div class="row-fluid">
		<div class="span12">
			<div class="twine-widget">
				<div class="twine-widget-title">
					Data Feeds
					<div class="twine-widget-close" data-toggle="collapse">X</div>
				</div>
				<div class="twine-widget-content">
				
					<p>Import social media content into your hub by creating <b>feeds</b>. TwineSocial will automatically check each feed for posts. </p>
					
					<table class="table table-striped table-hover">
					<thead>
						<TH style="width:30px;">&nbsp;</TH>
						<TH>Type</TH>
						<TH>Keyword</TH>
						<TH>Posts</TH>
						<TH>Last Checked</TH>
						<TH>Next Check</TH>
						<TH>&nbsp;</TH>
					</thead>
					<tbody>
					<?php foreach ($twinesocial_appdata_json->campaigns as $campaign) { ?>
					<?php foreach ($campaign->feeds as $feed) { ?>
						<TR>
							<TD> 
								<i class="fa fa-<?php echo $feed->type->network->css_class?>"></i>
							</TD>
							<TD><?php echo $feed->type->name?></TD>
							<TD><?php echo $feed->keyword?></TD>
							<TD style="text-align:right;"><?php echo number_format($feed->count)?></TD>
							<TD><abbr class="timeago" title="<?php echo date("c",$feed->last_run)?>"></abbr></TD>
							<TD><abbr class="timeago" title="<?php echo date("c",$feed->next_run)?>"></abbr></TD>
							<TD><a target="_blank" class="btn btn-sm btn-default" href="http://<?php echo TWINE_CUSTOMER_URL?>/app/<?php echo $campaign->baseUrl?>/feed/index">Edit Feed</a></TD>
						</TR>
					<?php } ?>
					<?php } ?>
					</tbody>
					</table>
					<HR>
					<p><i class="fa fa-info-circle"></i> <a href="http://customer.twinesocial.com">Upgrade now</a> to import new social media posts to your WordPress page faster.</p>

					<a class="btn btn-sm btn-primary" target="_blank" href="http://<?php echo TWINE_CUSTOMER_URL?>/">Add Feed</a>



				</div>
			</div>
		</div>
	</div>
</div>

