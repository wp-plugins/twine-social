<div class="row-fluid">
	<div class="span12">
		<P>If you haven't already, you'll need to get your free account at <a target="_blank" href="<?php echo TWINE_PUBLIC_URL?>/">Twine Social</a> to use this plugin. Already have an account? Sweet! Simply enter your Twine Social Account ID below. We'll show you a list of your active Twine Social apps. Pick one, and embed the Short Code on any page, including a WordPress widget sidebar. </p>
	</div>
</div>

<div class="row-fluid">
	<div class="span7">
		<div class="form-group <?php echo $twinesocial_accountid && !$twinesocial_appdata ? "has-error" : ""?>">
			<label>Twine Social Account #:</label>
			<input type="text" name="accountid" value="<?php echo $twinesocial_accountid ?>" class="form-control input-lg" placeholder="13-AQBHZM">
		</div>			
		<div class="form-group">

			<?php if ($twinesocial_appdata) { ?>
				<a class="btn btn-default btn-sm" href="http://<?php echo TWINE_CUSTOMER_URL?>/">Manage My TwineSocial Account</a>
				<input type="submit" name="submit_button" class="btn btn-sm btn-default" value="Update Account #">
			<?php } else { ?>
				<input type="submit" name="submit_button" class="btn btn-sm btn-primary" value="Link to Account">
			<?php } ?>

		</div>

		<?php if ($twinesocial_accountid && !$twinesocial_appdata) {?>
			<div class="alert alert-danger">That is not a valid Twine Social account ID. You can find your Account ID by logging into your account and clicking Settings in the upper right corner.</div>
		<?php } ?>
		
	</div>
	<div class="span5 <?php echo $twinesocial_appdata ? 'hide' : ''?>">
		<img class="img-thumbnail" src="<?php echo plugin_dir_url( __FILE__ ) . '../images/find-my-account-id.png'?>">
		<P><span class="help-block">Looking for your Twine Social Account ID? You can find it by <a href="<?php echo TWINE_CUSTOMER_URL?>/" target="_new">logging in</a>. Click on settings in the top right hand corner Look for a short code, like <b>13-ICZ5I4</b>. </span></p>
	</div>

</div>


