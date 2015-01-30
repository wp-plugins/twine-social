<?php $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? "https://" : "http://"; ?>

<div class="row-fluid">
	<div class="span12" style="text-align:center;">
		<a href="<?php echo TWINE_PUBLIC_URL?>/signup/new?network=Twitter&redirect=<?php echo urlencode($protocol . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"])?>" class="btn btn-default twitter"><i class="fa fa-twitter"></i> Connect Twitter Account</a>						
		<a href="<?php echo TWINE_PUBLIC_URL?>/signup/new?network=Facebook&redirect=<?php echo urlencode($protocol . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"])?>" class="btn btn-default facebook"><i class="fa fa-facebook"></i> Connect Facebook Account</a>				
	</div>
</div>

<HR>

<div class="row-fluid">
	<div class="span7">
		<div class="form-group <?php echo $twinesocial_accountid && !$twinesocial_appdata ? "has-error" : ""?>">
			<label>Already have a TwineSocial account? Add your Account # here:</label>
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
			<div class="alert alert-danger">That is not a valid TwineSocial Account #. You can find your Account # by logging into your account and clicking Settings in the upper right corner.</div>
		<?php } ?>
		
	</div>
	<div class="span5 <?php echo $twinesocial_appdata ? 'hide' : ''?>">
		<img class="img-thumbnail" src="<?php echo plugin_dir_url( __FILE__ ) . '../images/find-my-account-id.png'?>">
		<P><span class="help-block"><i class="fa fa-exclamation-circle"></i> Find your TwineSocial Account # by <a href="<?php echo TWINE_CUSTOMER_URL?>/" target="_new">logging in</a>. Click on settings in the top right hand corner. </span></p>
	</div>

</div>


