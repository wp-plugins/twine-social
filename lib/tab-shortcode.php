<div class="tab-pane" id="twine-tab-shortcode">
	<div class="row-fluid">
		<div class="span12">
			<div class="twine-widget">
				<div class="twine-widget-title">
					Generate a Wordpress ShortCode
					<div class="twine-widget-close" data-toggle="collapse">X</div>
				</div>
				<div class="twine-widget-content">

					<h4>Choose Your Social Hub:</h4>

					<div class="form-group">
						<?php 
						if ($twinesocial_appdata) {
							$js = json_decode($twinesocial_appdata);
							if ($js->success) {
								echo '<SELECT class="form-control" name="twinesocial_baseUrl" id="twinesocial_baseUrl">';
								foreach ($js->apps as $app) {
									echo '<OPTION value="' . $app->baseUrl . '">' . $app->name . '</option>';
								}
								echo '</SELECT>';
							} else {
								echo '<div class="alert alert-info">' . $js->message . '</div>';
							}
					} ?>
		

					</div>

					<div class="form-group">
						<SELECT class="form-control" name="twinesocial_collection" id="twinesocial_collection">
							<OPTION value="0">Show All Items</OPTION>

							<?php 
							if ($twinesocial_appdata) {
								$js = json_decode($twinesocial_appdata);
								foreach ($js->apps as $app) {
									foreach ($app->collections as $collection) {
										echo '<OPTION value="' . $collection->id . '">Only display posts from my "' . $collection->name . '" Collection</option>';
									}
									break;
								  }
								}
							?>


						</SELECT>

					</div>



					<h4>Optional/Advanced Settings</h4>


					<div class="checkbox">
						<label>
						<input type="checkbox" value="yes" name="twinesocial_page_auto_scroll" checked="checked" />
						<B>Infinite Scroll</b></label>
						<BR>Auto-load additional tiles when your users navigate to the bottom of your social hub. Super slick!
					</div>

					<div class="checkbox">
						<label>
						<input type="checkbox" value="1" name="twinesocial_page_nav" />
						<B>Show Site Navigation</b></label>
						<BR>Show all of your collections as tabbed navigation at the top of your hub.
					</div>

					<h4>Embed Your Shortcode.</h4>
					<P>Copy and paste this Wordpress shortcode on any Wordpress Page or Post:</p>

					<pre id="embed-code">[twinesocial app="<?php echo json_decode($twinesocial_appdata)->apps[0]->baseUrl?>"]</pre>





				</div>
			</div>
		</div>
	</div>
</div>

