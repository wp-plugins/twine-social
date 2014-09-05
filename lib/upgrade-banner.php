<?php if ($twinesocial_appdata && $twinesocial_appdata_json->accountStatus!=1) { ?>
<!-- start callout -->
<div class="twine-upgrade callout callout-danger">
<div class="row-fluid">
	<div class="span10">
		<H4>It's time to upgrade your TwineSocial Plugin!</H4>
		<p>Extend standard plugin functionality with 20+ awesome features like Custom CSS, Analytics, Advanced Rules & Routing, no "Powered By Twine" branding, User Security and more! Starting at only $19/month.</p>
	</div>
	<div class="span2">
		<a href="http://<?php echo TWINE_CUSTOMER_URL?>/account/choosePlan" class="btn btn-sm">Upgrade Now</a><BR>
		<a href="http://wordpress.org/support/view/plugin-reviews/twine-social" target="_blank" class="btn btn-sm">Rate Plugin</a>
	</div>
</div>
</div>
<!-- end callout -->
<?php } ?>