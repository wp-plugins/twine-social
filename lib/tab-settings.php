<div class="tab-pane" id="twine-tab-settings">
	<div class="row-fluid">
		<div class="span12">

			<div class="twine-widget">
				<div class="twine-widget-title">
					My Collections
					<div class="twine-widget-close" data-toggle="collapse">X</div>
				</div>
				<div class="twine-widget-content">
					<div class="form-group <?php echo $twinesocial_accountid && !$twinesocial_appdata ? "has-error" : ""?>">
						<label>Twine Social Account #:</label>
						<input type="text" name="accountid" value="<?php echo $twinesocial_accountid ?>" class="form-control input-lg" placeholder="13-AQBHZM">
					</div>			
					<div class="form-group">

						<input type="submit" name="submit_button" class="btn btn-sm btn-default" value="Update Account #">
						<a class="btn btn-default btn-sm" href="http://<?php echo TWINE_CUSTOMER_URL?>/">Manage My TwineSocial Account</a>

					</div>

					<?php if ($twinesocial_accountid && !$twinesocial_appdata) {?>
						<div class="alert alert-danger">That is not a valid Twine Social account ID. You can find your Account ID by logging into your account and clicking Settings in the upper right corner.</div>
					<?php } ?>

			</div>
		</div>
		</div>
	</div>
</div>

