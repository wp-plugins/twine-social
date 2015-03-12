<div class="tab-pane" id="twine-tab-shortcode">
	<div class="row-fluid">
		<div class="span12">
			<div class="twine-widget">
				<div class="twine-widget-title">
					Wordpress ShortCode
					<div class="twine-widget-close" data-toggle="collapse">X</div>
				</div>
				<div class="twine-widget-content">

					<p>Generate a <a href="http://codex.wordpress.org/Shortcode">Wordpress Shortcode</a>, and paste it anywhere you'd like your TwineSocial hub to appear.</p>
					<h4>Choose Your Social Hub</h4>

					<div class="form-group">
						<?php 
						if ($twinesocial_appdata) {
							$js = json_decode($twinesocial_appdata);
							if ($js->success) {
								echo '<SELECT class="form-control" name="twinesocial_baseUrl" id="twinesocial_baseUrl">';
								foreach ($js->campaigns as $campaign) {
									echo '<OPTION value="' . $campaign->baseUrl . '">' . $campaign->name . '</option>';
								}
								echo '</SELECT>';
							} else {
								echo '<div class="alert alert-info">' . $js->message . '</div>';
							}
					} ?>

					</div>


					<?php if ($twinesocial_appdata) {
						$js = json_decode($twinesocial_appdata);
						if (isset($js->themes)) { ?>

						<HR>
						<h4>Choose a Theme</h4>

						<div class="row form-group twine-themes">

							<?php foreach ($js->themes as $theme) { ?>
								<div class="col-xs-2 <?php echo $theme->name=="classic" ? " active" : ''?> <?php echo $theme->available ? "" : "locked"?>" data-theme="<?php echo $theme->name?>">
									<img class="img-thumbnail" src="<?php echo $theme->thumbnail?>">
									<p><?php echo $theme->title?></p>
								</div>
							  <?php } ?>
						</div>
						<div class="alert alert-info upgrade-message hide">
							<i class="fa fa-lock"></i> <a href="https://customer.twinesocial.com/account/choosePlan" target="_blank">Upgrade to a Paid Plan</a> to unlock this theme!
						</div>
						<?php
						  }
						}
					?>					
						


					<HR>
					<h4>Optional/Advanced Settings</h4>


					<?php if ($twinesocial_appdata) {
						$js = json_decode($twinesocial_appdata);
						if (isset($js->colors)) { ?>

						<div class="row form-group">
							<label class="col-xs-3">Color Scheme</label>
							<div class="col-xs-6">
								<SELECT class="form-control" name="twinesocial_color" id="twinesocial_color">
								<?php foreach ($js->colors as $color) {
										echo '<OPTION value="' . $color->name . '">' . $color->title . '</option>';
								} ?>

								</SELECT>
							</div>
						</div>
						<?php
						  }
						}
					?>					

					<div class="row form-group">
						<label class="col-xs-3">Only show Posts</label>
						<div class="col-xs-6">
						<SELECT class="form-control" name="twinesocial_collection" id="twinesocial_collection">
							<OPTION value="0">Show All Items</OPTION>

							<?php 
							if ($twinesocial_appdata) {
								$js = json_decode($twinesocial_appdata);
								foreach ($js->campaigns as $campaign) {
									foreach ($campaign->collections as $collection) {
										if ($collection->name!="All") {
											echo '<OPTION value="' . $collection->id . '">Only display posts from my "' . $collection->name . '" Collection</option>';
										}
									}
									break;
								  }
								}
							?>

						</SELECT>
						</div>

					</div>



					<div class="row form-group">
						<label class="col-xs-3">Only Show:</label>
						<div class="col-xs-6">
							<SELECT class="form-control" name="twinesocial_pagesize" id="twinesocial_pagesize">
								<OPTION value="1">1 post</option>
								<OPTION value="5">5 posts</option>
								<OPTION value="10">10 posts</option>
								<OPTION selected value="20">20 posts (Recommended)</option>
								<OPTION value="50">50 posts</option>
							</SELECT>
						</div>
					</div>
					

					<div class="row form-group">
						<label class="col-xs-3">When scrolling to bottom of your hub:</label>
						<div class="col-xs-6">
							<SELECT class="form-control" name="twinesocial_scrolloptions" id="twinesocial_scrolloptions">
								<OPTION value="fixed">Do nothing</option>
								<OPTION selected value="autoload">Auto-load more posts</option>
								<OPTION value="showbutton">Show a "Load More Posts" button"</option>
							</SELECT>
						</div>
					</div>


					<div class="row form-group">
						<label class="col-xs-3">Widget UI Language</label>
						<div class="col-xs-6">
							<SELECT class="form-control" name="twinesocial_language" id="twinesocial_language">

							<?php 
							if ($twinesocial_appdata) {
								$js = json_decode($twinesocial_appdata);
								if (isset($js->languages)) {

									foreach ($js->languages as $language) {
											echo '<OPTION value="' . $language->culture . '">' . $language->name . '</option>';
									  }
								  }
								}
							?>

							</SELECT>
						</div>
					</div>


					<div class="row form-group">
						<label class="col-xs-3">Site Navigation</label>
						<div class="col-xs-8">
							<input type="checkbox" value="1" name="twinesocial_page_nav" />&nbsp;Enable navigation tabstrip at the top of your hub.
						</div>
					</div>

					<h4>Your Wordpress Shortcode</h4>
					<P>Copy and paste this shortcode on any Wordpress Page or Post:</p>

					<pre id="embed-code">[twinesocial app="<?php echo json_decode($twinesocial_appdata)->campaigns[0]->baseUrl?>" scrolloptions="autoload"]</pre>

				</div>
			</div>
		</div>
	</div>
</div>
