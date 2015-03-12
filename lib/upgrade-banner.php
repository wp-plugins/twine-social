<!-- start callout -->
<?php if ($twinesocial_appdata && $twinesocial_appdata_json->accountStatus==2) { ?>
	<div class="twine-upgrade callout callout-info">
	<div class="row-fluid">
		<div class="span10">
			<H4>Welcome to TwineSocial!</H4>
			<p>Your free 30-day TwineSocial trial is active for another <?php echo $twinesocial_appdata_json->daysLeftInTrial?> days. Questions? We're here to answer any questions, or help with your implementation. </p>
		</div>
		<div class="span2">
			<a href="http://support.twinesocial.com" target="_blank" class="btn btn-sm btn-default">Get Help</a>
			<a href="http://<?php echo TWINE_CUSTOMER_URL?>/account/choosePlan" class="btn btn-sm btn-primary">Upgrade Now</a><BR>
		</div>
	</div>
	</div>
<?php } else if ($twinesocial_appdata && $twinesocial_appdata_json->accountStatus==3) { ?>
	<div class="twine-upgrade callout callout-danger">
	<div class="row-fluid">
		<div class="span10">
			<H4>Upgrade Now to Remove TwineSocial Ads</H4>
			<p>Your free 30-day TwineSocial trial is over, and your account has been automatically downgraded to the Free Plan. Continue to use the ad-supported version of TwineSocial, or upgrade now to remove ads and unlock more features. No contracts, cancel anytime.</p>
		</div>
		<div class="span2">
			<a href="http://<?php echo TWINE_CUSTOMER_URL?>/account/choosePlan" class="btn btn-sm btn-primary">Upgrade Now</a><BR>
			<a href="http://support.twinesocial.com" target="_blank" class="btn btn-sm btn-default">Get Help</a>
		</div>
	</div>
	</div>
<?php } else if ($twinesocial_appdata && $twinesocial_appdata_json->accountStatus==6) { ?>
	<div class="twine-upgrade callout callout-danger">
	<div class="row-fluid">
		<div class="span10">
			<H4>Whoops!</H4>
			<p>Something is wrong with the payment on your TwineSocial plan, so it has been placed on hold. Please login to your TwineSocial account to fix and unlock your account.</p>
		</div>
		<div class="span2">
			<a href="http://<?php echo TWINE_CUSTOMER_URL?>" class="btn btn-sm btn-primary">Fix Now</a><BR>
			<a href="http://support.twinesocial.com" target="_blank" class="btn btn-sm btn-default">Get Help</a>
		</div>
	</div>
	</div>
<?php } else if ($twinesocial_appdata && $twinesocial_appdata_json->accountStatus==8) { ?>
	<div class="twine-upgrade callout callout-danger">
	<div class="row-fluid">
		<div class="span10">
			<H4>Whoops!</H4>
			<p>This TwineSocial account has been closed and is no longer active. Sign up again with a new trial account to continue.</p>
		</div>
		<div class="span2">
			<a href="http://<?php echo TWINE_PUBLIC_URL?> target="_blank" class="btn btn-sm btn-default">Sign Up</a>
		</div>
	</div>
	</div>
<?php } ?>
<!-- end callout -->

