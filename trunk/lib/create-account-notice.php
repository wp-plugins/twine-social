<?php if ($twinesocial_appdata == null) { ?>

<!-- Unfortunately, we have to use all this ugly CSS because this loads before our main CSS. -->
<style>
	.close {
	  float: right;
	  font-size: 20px;
	  font-weight: bold;
	  line-height: 18px;
	  color: #000000;
	  text-shadow: 0 1px 0 #ffffff;
	  opacity: 0.2;
	  filter: alpha(opacity=20);
	}
	.close:hover {
	  color: #000000;
	  text-decoration: none;
	  opacity: 0.4;
	  filter: alpha(opacity=40);
	  cursor: pointer;
	}

	.alert {
	  padding: 8px 35px 8px 14px;
	  margin-bottom: 18px;
	  text-shadow: 0 1px 0 rgba(255, 255, 255, 0.5);
	  background-color: #fcf8e3;
	  border: 1px solid #fbeed5;
	  -webkit-border-radius: 4px;
	  -moz-border-radius: 4px;
	  border-radius: 4px;
	  color: #c09853;
	  margin-right: 20px;
	  margin-top: 40px;	  
	  margin-bottom: 40px;	  	  
	}

	.alert a:hover {	
		text-decoration: underline !important;
	}
	
	.alert-heading {
	  color: inherit;
	}
	.alert .close {
	  position: relative;
	  top: -2px;
	  right: -21px;
	  line-height: 18px;
	}
	.alert-success {
	  background-color: #dff0d8;
	  border-color: #d6e9c6;
	  color: #468847;
	}
	.alert-danger,
	.alert-error {
	  background-color: #f2dede;
	  border-color: #eed3d7;
	  color: #b94a48;
	}
	.alert-info {
	  background-color: #d9edf7;
	  border-color: #bce8f1;
	  color: #3a87ad;
	}
	.alert-block {
	  padding-top: 14px;
	  padding-bottom: 14px;
	}
	.alert-block > p,
	.alert-block > ul {
	  margin-bottom: 0;
	}
	.alert-block p + p {
	  margin-top: 5px;
	}
</style>

<!-- Get the guy's username -->
<?php 
global $current_user;
get_currentuserinfo();
?>

<div class="alert alert-error">
  <a class="close" data-dismiss="alert">×</a>
  <strong>Hi <?php echo "<span style='text-transform:capitalize;'>" . $current_user->user_login . "</span>" ?>, </strong>you're minutes away from a beautiful social media hub from Twine.  
  <?php echo
  '<a style="color: #b94a48; font-weight: bold;text-decoration: none;" href="'. get_admin_url(null, 'admin.php?page=twinesocial-key-setting') .'">
  	Jump over to your plugin to get started.  
  </a>';
  echo $twinesocial_appdata
  ?>
  
  
</div>
<?php } ?>