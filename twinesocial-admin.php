<?php
require_once(ABSPATH . WPINC .'/pluggable.php' );
require_once(ABSPATH . WPINC .'/template.php' );

if (!defined('TWINE_PLUGIN_DIRNAME')) {
	define('TWINE_PLUGIN_DIRNAME',  plugin_basename(dirname(__FILE__)) );
}

if (!defined('TWINE_PUBLIC_URL')) { 
	define('TWINE_PUBLIC_URL',  '//www.twinesocial.com');
}

if (!defined('TWINE_APPS_URL')) {
	define('TWINE_APPS_URL',  '//apps.twinesocial.com');
}

if (!defined('TWINE_CUSTOMER_URL')) {
	define('TWINE_CUSTOMER_URL',  '//customer.twinesocial.com');
}
add_action('admin_menu', 'twinesocial_create_setting_menu');

/**
 * The admin page for twinesocial settings.
 */
function twinesocial_settings_page() { 

    global $twinesocial_admin_page;
    
    if ( get_current_screen()->id != $twinesocial_admin_page)
        return;

    wp_nonce_field( plugin_basename( __FILE__ ), 'twinesocial_noncename' );

	$twinesocial_baseUrl        = get_option('twinesocial_baseUrl');

	$twinesocial_accountid = get_option('twinesocial_accountid');

	// refresh the collections and apps from Twine
	if (get_option('twinesocial_accountid')) {
		$result = wp_remote_get('http:' . TWINE_PUBLIC_URL . "/api?method=accountinfo&accountId=" . get_option('twinesocial_accountid'));

		if (!is_wp_error( $result) ) {
			$js = json_decode(wp_remote_retrieve_body($result));
			if ($js->success==true) {
				update_option('twinesocial_appdata', wp_remote_retrieve_body($result));
			} else {
				delete_option('twinesocial_appdata');
			}
		}
	}

	$twinesocial_appdata = get_option('twinesocial_appdata');
	
	if ($twinesocial_appdata) {
		$twinesocial_appdata_json = json_decode($twinesocial_appdata);
	}

	// load up pretty stuff
    wp_enqueue_script('jquery');
    wp_enqueue_script('twinesocial_widget_js2', plugins_url('/js/bootstrap.min.js', __file__ ) );
    wp_enqueue_script('twinesocial_widget_js3', plugins_url('/js/twine.js', __file__ ) );
    wp_enqueue_script('twinesocial_widget_js4', plugins_url('/js/bootstrap-legacy.min.js', __file__ ) );    
    wp_enqueue_style('twinesocial_widget_css1', plugins_url('/css/twine.css', __file__ ) );
    wp_enqueue_style('twinesocial_widget_css2', plugins_url('/css/bootstrap-wpadmin-legacy.css', __file__ ) );
    wp_enqueue_style('twinesocial_widget_css3', plugins_url('/css/bootstrap-wpadmin-fixes.css', __file__ ) );
    wp_enqueue_style('twinesocial_widget_css4', plugins_url('/css/bootstrap-wpadmin.css', __file__ ) );
    wp_enqueue_style('twinesocial_widget_css5', plugins_url('/css/font-awesome.min.css', __file__ ) );
 
	?>

	<div class="bootstrap-wpadmin twine">
	<div class="container-fluid">
	<form role="form" method="post" action="options.php">

	<?php 
	settings_fields( 'twinesocial-settings-group' );
	wp_nonce_field( plugin_basename( __FILE__ ), 'twinesocial_noncename' );

	?>


		<?php 
			include_once ("lib/upgrade-banner.php"); 	
		?>

		<?php if (!isset($_POST)) {
			include_once ("lib/create-account-modal.php");			
		} ?>
		
					
		<div class="row-fluid">
			<div class="span12">
				<div class="page-header">
					<img src="http://static.twinesocial.com/website/aggregate-and-moderate-head.png" style="max-width:60%;padding:20px;">
					<h2>Display Official &amp; Fan-Posted Content<br>
						<small>In an Engaging Social Media Hub</small>
					</h2>					
					<P>Get a stunning social media hub for your Wordpress blog, instantly making it dynamic and social.  Include your entire brand story—from all your networks—on your hub. 				
				</div>				
			</div>				
		</div>
		


		<?php if ($twinesocial_appdata) { ?>
			<div class="row-fluid">
				<div class="span12">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#twine-tab-home" data-toggle="tab">Dashboard</a></li>
						<li><a href="#twine-tab-shortcode" data-toggle="tab">Short-Codes</a></li>
						<li><a href="#twine-tab-hubs" data-toggle="tab">My Hubs</a></li>
						<li><a href="#twine-tab-connections" data-toggle="tab">Connections</a></li>
						<li><a href="#twine-tab-rules" data-toggle="tab">Rules</a></li>
						<li><a href="#twine-tab-collections" data-toggle="tab">Collections</a></li>
						<?php if (false && $twinesocial_appdata_json->accountStatus>1) { ?>
							  <li><a href="#twine-tab-upgrade" data-toggle="tab">Purchase Pro Version</a></li>
						<?php } ?>
						<li><a href="#twine-tab-settings" data-toggle="tab">My Account</a></li>
						<li><a href="#twine-tab-faq" data-toggle="tab">Help & FAQ</a></li>
					</ul>
				</div>
			</div>

			<!-- Tab panes -->
			<div class="tab-content">
				<?php include_once ("lib/tab-overview.php"); ?>
				<?php include_once ("lib/tab-connections.php"); ?>
				<?php include_once ("lib/tab-shortcode.php"); ?>
				<?php include_once ("lib/tab-hubs.php"); ?>
				<?php include_once ("lib/tab-collections.php"); ?>
				<?php include_once ("lib/tab-users.php"); ?>
				<?php include_once ("lib/tab-rules.php"); ?>
				<?php include_once ("lib/tab-settings.php"); ?>
				<?php include_once ("lib/tab-faq.php"); ?>
			</div>
		<?php } else { ?>
				<?php include_once ("lib/start.php"); ?>
		<?php } ?>
	

	</form>
	</div>
	</div>

	<?php if ($twinesocial_appdata) { ?>
	<SCRIPT type="text/javascript">
		TwineSocialAppData = <?php echo $twinesocial_appdata?>;
	</SCRIPT>
	<?php } ?>


<?php  }


if ( isset($_POST['action']) && $_POST['action'] == 'update' && wp_verify_nonce( $_POST['twinesocial_noncename'], plugin_basename( __FILE__ ) ) ) {


	update_option('twinesocial_accountid', $_POST['accountid'] );

	$result = wp_remote_get(TWINE_PUBLIC_URL . "/api?method=accountinfo&accountId=" . $_POST['accountid']);

	if (!is_wp_error( $result) ) {
		$js = json_decode(wp_remote_retrieve_body($result));
		if ($js->success==true) {
			update_option('twinesocial_appdata', wp_remote_retrieve_body($result));
		} else {
			delete_option('twinesocial_appdata');
		}

	} else {
		if (function_exists( 'add_settings_error' )) {
			add_settings_error( $twinesocial_admin_page, 'twinesocial_home_created', sprintf('We were not able to retrieve your TwineSocial account setings because the following error occurred: ' .  $result->get_error_message(), get_bloginfo('url')), 'alert alert-danger');
		}
	}


}

?>