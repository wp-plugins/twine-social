<?php

// fix PHP Fatal error:  Call to undefined function wp_verify_nonce()
require_once( ABSPATH .'wp-includes/pluggable.php' );
// require template.php to use add_settings_error
require_once( ABSPATH .'wp-admin/includes/template.php' );
// to use theme functions
require_once( ABSPATH .'wp-includes/theme.php' );

add_action('admin_menu', 'twinesocial_create_setting_menu');

twinesocial_warnings();


/**
 * show error when:
 * we don't have permissions in theme directory and not have the template for fullwidth 
 * and to create home page.
 * 
 * show warning:
 * when don't have writable permission to create home page.
 */
function twinesocial_warnings() {

    $rembelmouse_template = get_template_directory() . '/' .  TWINESOCIAL_FULL_WIDTH_TEMPLATE;

    if ( ! file_exists( $rembelmouse_template ) ) {

        if ( ! is_writable( get_template_directory() ) )  {
            function twinesocial_alert() {
                global $twinesocial_admin_page;
                if ( get_current_screen()->id != $twinesocial_admin_page )
                    return;
                ?>
                <div class='error'>
					<p><strong>Twine Social Error</strong>: Theme directory is not writable.</p>
					<p><strong><?php echo get_template_directory();?></strong></p>
					<p>Please adjust its file permissions/ownership.</p>
				</div>
                <?php
            }
            add_action( 'admin_notices', 'twinesocial_alert' );
        } else {
            twinesocial_add_templates_to_theme();
        }
    }
}



/**
 * Setting link after install the plugin 
 * @return string
 */
function twinesocial_plugin_action_links( $links, $file ) {
    if ( $file == plugin_basename( dirname(__FILE__) . '/twinesocial-widget.php' ) ) {
        $links[] = '<a href="admin.php?page=twinesocial-key-setting">' . __('Settings') . '</a>';
    }

    return $links;
}
add_filter( 'plugin_action_links', 'twinesocial_plugin_action_links', 10, 2 );

function twine_load_js_and_css() {

//    wp_enqueue_script( 'twinesocial_widget_js1', plugins_url( '/js/jquery-1.8.2.min.js', __file__ ) );
//    wp_enqueue_script( 'twinesocial_widget_js2', plugins_url( '/js/bootstrap.min.js', __file__ ) );

//    wp_enqueue_style( 'twinesocial_widget_css2', plugins_url( '/css/bootstrap.min.css', __file__ ) );
}

//add_action( 'admin_enqueue_scripts', 'twine_load_js_and_css' );


/**
 * Create the setting menu link and register settings
 */
function twinesocial_create_setting_menu() {
    global $twinesocial_admin_page;
    
    $twinesocial_admin_page = add_options_page( 'Twine Social Settings', 'Twine Social Settings', 'manage_options', 'twinesocial-key-setting', 'twinesocial_settings_page' );
    add_action( 'admin_init', 'twinesocial_register_mysettings' );

}


function twinesocial_register_mysettings() {
    register_setting('twinesocial-settings-group', 'twinesocial_sitename' );
}


/**
 * The admin page for twinesocial settings.
 */
function twinesocial_settings_page() { 
    global $twinesocial_admin_page;

    if ( get_current_screen()->id != $twinesocial_admin_page)
        return;

    wp_nonce_field( plugin_basename( __FILE__ ), 'twinesocial_noncename' );

	$twinesocial_baseUrl        = get_option('twinesocial_baseUrl');
	$twinesocial_page_title        = get_option('twinesocial_page_title');
    $twinesocial_page_title    = ( !empty($twinesocial_page_title) )? $twinesocial_page_title: $twinesocial_baseUrl . ' Page Powered By Twine Social';

	$twinesocial_page_columns    = get_option('twinesocial_page_columns', '4');
	$twinesocial_page_auto_scroll = get_option('twinesocial_page_auto_scroll',1);

	$twinesocial_accountid = get_option('twinesocial_accountid');
	$twinesocial_appdata = get_option('twinesocial_appdata');

	// load up pretty stuff
    wp_enqueue_script('twinesocial_widget_js1', plugins_url('/js/jquery-1.8.2.min.js', __file__ ) );
    wp_enqueue_script('twinesocial_widget_js2', plugins_url('/js/bootstrap.min.js', __file__ ) );
    wp_enqueue_style('twinesocial_widget_css2', plugins_url('/css/bootstrap.min.css', __file__ ) );

   ?>
<div id="twinesocial_settings_content" class="twinesocial-settings">
    
    <div style="background-color:#25292c;width:100%"><img src="<?php echo plugin_dir_url( __FILE__ ) . 'images/header-short.jpg'?>" ></div>


<form role="form" method="post" action="options.php">

<?php 
settings_fields( 'twinesocial-settings-group' );
wp_nonce_field( plugin_basename( __FILE__ ), 'twinesocial_noncename' );
?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h1>Twine Social Plugin Settings</h1>
				<P>Twine Social makes a great front page for your Wordpress blog, instantly making it dynamic and social. If you haven't already, you'll need to get your free account at <a target="_blank" href="http://www.twinesocial.com/">Twine Social</a> to use this plugin. </P>
				<P>Already have an account? Sweet! Simply enter your Twine Social Account ID below. We'll show you a list of your active Twine Social apps. Pick one, and we'll make it your WordPress site home page. Or, embed the Short Code on any page, including a WordPress widget sidebar. </p>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-7">
			<div class="form-group <?php echo $twinesocial_accountid && !$twinesocial_appdata ? "has-error" : "has-success"?>">
				<label>Twine Social Account #:</label>
				<input type="text" name="accountid" value="<?php echo $twinesocial_accountid ?>" class="form-control input-lg" placeholder="13-AQBHZM">
			</div>			
			<div class="form-group">
				<input type="submit" name="submit_button" class="btn <?php echo !$twinesocial_appdata ? 'btn-primary' : ''?>" value="<?php _e('Link My Twine Account') ?>">
			</div>

			<?php if ($twinesocial_accountid && !$twinesocial_appdata) {?>
				<div class="alert alert-danger">That is not a valid Twine Social account ID. You can find your Account ID by logging into your account and clicking Settings in the upper right corner.</div>
			<?php } else if ($twinesocial_appdata) {?>
				<div class="alert alert-success">Your Twine Social Account is connected to this Wordpress blog.</div>
			<?php } ?>
			
		</div>
		<div class="col-md-5">
		<img class="img-thumbnail" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/find-my-account-id.png'?>">
	<P><span class="help-block">Looking for your Twine Social Account ID? You can find it by <a href="http://customer.twinesocial.com/" target="_new">logging in</a>. Click on settings in the top right hand corner Look for a short code, like <b>13-ICZ5I4</b>. </span>
		</div>

	</div>

	<div class="row <?php echo $twinesocial_appdata ? '' : 'hide'?>">
		<div class="col-md-12">

			<ul class="nav nav-tabs">
			  <li class="active"><a href="#twine-tab-home" data-toggle="tab">Add a Twine Social Page</a></li>
			  <li><a href="#twine-tab-faq" data-toggle="tab">Help & FAQ</a></li>
			</ul>

			<div class="tab-content">
			  <div class="tab-pane active" id="twine-tab-home">
			  	<div class="row">
					<div class="col-md-12">
                        <h3>Add a Twine Social Page</h3>
                        <p>Set Twine Social as your homepage. Just follow the steps below.</p>


						<div class="form-group">
							<label>Which Twine Social Application would you like to put on your Wordpress Home Page?</label>
							<?php 
							if ($twinesocial_appdata) {
								$js = json_decode($twinesocial_appdata);
								if ($js->success) {
									echo '<SELECT class="form-control input-lg" name="twinesocial_baseUrl" id="twinesocial_baseUrl">';
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
							<label>What would you like the Wordpress Page Title to be?</label>
	                        <input type="text" class="form-control input-lg" name="twinesocial_page_title" value="<?php echo $twinesocial_page_title; ?>"><br/>
	                    </div>

						<div class="form-group">
							<label>How many columns would you like to display?</label>
	                        <input type="text" class="form-control input-lg" name="twinesocial_page_columns" value="<?php echo $twinesocial_page_columns; ?>"><br/>
	                    </div>

						<div class="checkbox">
							<label>
			                <input type="checkbox" value="1" name="twinesocial_page_auto_scroll" <?php echo $twinesocial_page_auto_scroll ? "checked='checked'" : "" ?> />
							Use "Infinite Scrolling"</label>
	                    </div>


						<div class="form-group">

						<?php 
							$twinesocial_on_front = get_option( 'twinesocial_on_front', false );
							if ($twinesocial_on_front) { ?>
								<input type="submit" class="btn btn-default" name="submit_button" value="<?php _e('Remove current home') ?>" />
								<?php 
							} ?>
							<input type="submit" name="submit_button" class="btn btn-primary" value="<?php _e('Set as Home') ?>">
			                <input type="submit" name="submit_button" class="btn btn-default" value="<?php _e('Add page') ?>" />

						</div>


					</div>
			  	</div>
			  </div>

			  <div class="tab-pane fade" id="twine-tab-faq">
			  	<div class="row">
					<div class="col-md-12">

<P>&nbsp;</p>
<H3>About Twine Social Wordpress Plugin</H3>
<p class="lead">Showcase your brand's social media, beautifully presented on your Wordpress Blog.</p>
<P ><a href="http://www.twinesocial.com">Twine Social</a> provides the tools you need to grow and engage your social audience. Display any social media content on your digital properties, and drive massive social engagement.</p>
<P>This plugin makes it <b>super easy</b> to add your social media content (including #hashtags, @accounts and locations) from any social media network to your Wordpress Blog. [Twine Social] is richly interactive and engaging. Get beautiful presentation of your photos, videos, and other social media elements on your digital properties. Your customers see your brand in action, making Twine the perfect social media hub.</p>
<P>Twine Social is fully responsive, and supports infinite scroll.</p>

<img class="img-responsive img-thumbnail" src="<?php echo plugin_dir_url( __FILE__ ) . 'images/twine-wall.jpg'?>">

<HR>

<div class="alert alert-info">
<P>IMPORTANT: You will FIRST need to go to <a href="http://www.twinesocial.com">Twine Social</a>, sign up for a FREE account before you can embed it into your Wordpress site.
</div>

<P>If you have any questions or feedback, please visit our <a href="http://twinesocial.uservoice.com/">support forum</a>, or email us at support{at}twinesocial.com.</p>


<H3>Installation</H3>
<P>First, go to <a href="http://www.twinesocial.com">Twine Social</a> and sign up for a FREE account. Installing the plugin without a [Twine Social](http://www.twinesocial.com) account will not work properly.</p>

<P>Twine can be displayed on the Wordpress sidebar or embedded in your page as a shortcode.</p>

<HR>

<H4>Placing your Twine feed a Wordpress Page</H4>

<OL>
<LI>Download the plugin and upload it into your Wordpress Plugins folder OR search "Twine Social" in the plugin store and install it.</LI>
<LI>Activate the plugin through the 'Plugins' menu in WordPress.</LI>
<LI>Click on Settings -> Twine Social Settings.</LI>
<LI>You'll need to add your Twine Social Account #. You can find it by logging in to http://customer.twinesocial.com, using the account you previously created. Click on settings in the top right hand corner and the Account ID will be displayed. It's a short code, like 13-ICZ5I4.</LI>
<LI>You may have more than one Twine Social application - one for each brand you manage. Choose one.</LI>
<LI>You can publish your Twine Social application to your Wordpress Home Page, or to create a new Wordpress Page.</LI>
</OL>

<P><strong>That's it!</strong></p>

<HR>

<H4>Placing your Twine feed on the Sidebar/Widget</H4>

<OL>
<LI>Go to the Appearance -> Widgets, drag the "Twine Social" widget to your "Main Sidebar"</LI>
<LI>Choose from your list of available Twine Social applications.</LI>
<LI>Setup Height and number of columns. (Leave height blank for 100%).</LI>
</OL>


<HR>

<H4>Using Twine Social shortcodes</H4>

<OL>
<LI>Create a new Post and click on the HTML or Text option on the top-right hand side of the post.</LI>
<LI>Use the shortcode twine: Example [twinesocial app='SITE' cols=2] (Note: Replace SITE with your application name.)</LI>

<P>Arguments supported by the shortcode:</p>

<BLOCKQUOTE>
<UL>
<LI><B>app</b>: Your Twine Social application id</LI>
<LI><B>width</b>: width of the iframe</LI>
<LI><B>height</b>: height of the iframe</LI>
<LI><B>cols</b>: number of columns to show in the view (default: 4)</LI>
<LI><B>tab</b>: the specific tab/topic to filter</LI>
<LI><B>scroll=auto</b>: for infinite scrolling</LI>
</UL>
</BLOCKQUOTE>

<P>Shortcode example:</P>
<BLOCKQUOTE>
<P>[twinesocial site_name='WCD' cols=4 tab='Reviews']
</BLOCKQUOTE>

<P>Many column layouts are supported:

<BLOCKQUOTE>
<UL>
<LI><B>1</b>: 1 column wide</LI>
<LI><B>2</b>: 2 column wide, each 50% wide</LI>
<LI><B>3</b>: 3 column wide, each 33% wide</LI>
<LI><B>363</b>: 3 columns, 25%, 50%, and 25% wide</LI>
<LI><B>4</b>: each 25% wide (default)</LI>
<LI><B>336</b>: 3 columns, 25%, 25%, and 50% wide</LI>
</UL>
</BLOCKQUOTE>

<HR>

<H3>Frequently Asked Questions</H3>
 
<H4>What is Twine?</H4>

<P><A href="http://www.twinesocial.com">Twine Social</a> provides the tools you need to grow and engage your social audience. Display any social media content on your digital properties, and drive massive social engagement.</p>

<H3>What can I use Twine Social for?</h3>
<P>Connect any combination of social media feeds, including hashtags, from any social media network and Twine Social will aggregate your content onto one stunning destination on your website, TV, video wall, or display.</p>
<P>Twine Social is richly interactive and engaging. Get beautiful presentation of your photos, videos, and other social media elements on your digital properties.</p>

<H3>How do I start using Twine Social?</H3>

<P>First sign up for a free account at <a href="http://www.twinesocial.com">Twine Social</a>. This Wordpress plugin then allows you to embed your Twine Social feed into your WordPress site. Go to the Installation tab to easily learn how.</p>

<H3>Help, I'm having a problem!</H3>

<P>We apologize for any problems you may have. Feel free to Tweet us at @twinesocial, visit our <a href="http://www.facebook.com/TwineSocial">Facebook Page</a>, visit our <a href="http://twinesocial.uservoice.com">support forum</a>, or <a href="mailto:support@twinesocial.com">email us</a>.</p>

<HR>


<Code>
== Changelog ==<BR>
= 1.0 =<BR>
* Initial Version<BR>
<BR>
== Upgrade Notice ==<BR>
No problems should be encountered when upgrading.<BR>
</code>










					</div>
				</div>
			  </div>

			</div>


		</div>

	</div>
</div>

</form>
</div>
<?php 

}


/**
 * 
 * @param string $app
 * @param string $page_title
 * @param string $columns
 * @param string $autoscroll
 * @return int|boolean new page post_id, or false.
 */
function twinesocial_add_page( $app, $page_title, $columns, $autoscroll) {

    $c = (!empty( $columns ) ) ? ' cols="' . $columns . '"': '';
    $s = (!empty( $autoscroll ) ) ? ' scroll="auto"': '';
    
    $new_page_content = '[twinesocial app="' . $app . '" ' . $c . $s . ']';
    $new_page_template = TWINESOCIAL_FULL_WIDTH_TEMPLATE;
    
    $page_check = get_page_by_title($page_title);
    
    $new_page = array(
            'post_type'    => 'page',
            'post_title'   => $page_title,
            'post_content' => $new_page_content,
            'post_status'  => 'publish',
            'post_author'  => 1,
    );
    
    $GLOBALS['wp_rewrite'] = new WP_Rewrite();
    $new_page_id = wp_insert_post($new_page);
    if ( is_wp_error($revision_id) )
        add_settings_error( $twinesocial_admin_page, 'twinesocial_page_error', 'Something went wrong. Please try again.', 'error');
    elseif(!empty($new_page_template)){
        update_post_meta($new_page_id, '_wp_page_template', $new_page_template);
        return $new_page_id;
    }
    return false;
}



if ( isset($_POST['action']) && $_POST['action'] == 'update' && wp_verify_nonce( $_POST['twinesocial_noncename'], plugin_basename( __FILE__ ) ) ) {


	$twinesocial_baseUrl = esc_html( $_POST['twinesocial_baseUrl'] );
	$twinesocial_baseUrl = ( !empty($twinesocial_baseUrl) )? $twinesocial_baseUrl: 'twinesocial';
	$twinesocial_page_title    = esc_html( $_POST['twinesocial_page_title'] );
	$twinesocial_page_title    = ( !empty($twinesocial_page_title) )? $twinesocial_page_title: $twinesocial_baseUrl;
	$twinesocial_page_columns  = intval( esc_html( $_POST['twinesocial_page_columns'] ) );
	$twinesocial_page_auto_scroll  =  $_POST['twinesocial_page_auto_scroll'];


    if ( $_POST['submit_button'] === translate( 'Link My Twine Account' ) ){

        update_option('twinesocial_accountid', $_POST['accountid'] );

		//open connection
		$ch = curl_init();

		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, "http://www.twinesocial.com/api?method=accountinfo&accountId=" . $_POST['accountid']);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		//execute post
		$result = curl_exec($ch);
		$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

		if ($http_status==200) {

			$js = json_decode($result);
			if ($js->success==true) {
		        update_option('twinesocial_appdata', $result);
			} else {
		        delete_option('twinesocial_appdata');
			}
		}

    } elseif ( $_POST['submit_button'] === translate( 'Add page' ) ){

        update_option('twinesocial_page_auto_scroll', $twinesocial_page_auto_scroll );
        update_option('twinesocial_page_title', $twinesocial_page_title );

        $page_id = twinesocial_add_page($twinesocial_baseUrl, $twinesocial_page_title, $twinesocial_page_columns,$twinesocial_page_auto_scroll);
        
        if ( !empty($page_id) ){
            add_settings_error( $twinesocial_admin_page, 'twinesocial_home_created', sprintf('We created a new Wordpress Page for you, and installed your Twine Social page on it. <a href="%s">View it Now</a>.', get_bloginfo('url')), 'updated');
        }

    } elseif ( $_POST['submit_button'] === translate( 'Set as Home' ) ){

        update_option('twinesocial_baseUrl', esc_html( $_POST['twinesocial_baseUrl'] ) );
        update_option('twinesocial_page_title', $twinesocial_page_title );

        $twinesocial_page_columns = intval( esc_html( $_POST['twinesocial_page_columns'] ) );
        update_option('twinesocial_page_columns', $twinesocial_page_columns );
        update_option('twinesocial_page_auto_scroll', $twinesocial_page_auto_scroll );

        $page_id = twinesocial_add_page($twinesocial_baseUrl, $twinesocial_page_title, $twinesocial_page_columns, $twinesocial_page_auto_scroll);

        if ( !empty($page_id) ){

            update_option( 'show_on_front', 'page' );
            update_option( 'page_on_front', $page_id );
            update_option( 'twinesocial_on_front', $twinesocial_baseUrl );
            update_option( 'twinesocial_page_on_front', $page_id );
            
            add_settings_error( $twinesocial_admin_page, 'twinesocial_home_created', sprintf('We created a new Wordpress Home Page for you, and installed your Twine Social page on it. <a href="%s">View it Now</a>.', get_bloginfo('url')), 'updated');
        }

    } elseif ( $_POST['submit_button'] === translate( 'Remove current home' ) ){

        $homepage_id = get_option( 'page_on_front');
        
        update_option( 'show_on_front', 'posts' );
        update_option( 'page_on_front', 0 );
        update_option( 'twinesocial_on_front', '' );
        update_option( 'twinesocial_page_on_front', 0 );
        
        wp_delete_post( $homepage_id, true );
        
    }
}

?>
