<?php
/**
 * Create the setting menu link and register settings
 */

//include( plugin_dir_path( __FILE__ ) . '/create-account-notice.php'); 


 
function twinesocial_create_setting_menu() {
    global $twinesocial_admin_page;    
    $twinesocial_admin_page = add_menu_page( 'Twine Social Settings', 'TwineSocial', 'manage_options', 'twinesocial-key-setting', 'twinesocial_settings_page', plugins_url( 'twine-social/images/icon.png' ) );
    add_action( 'admin_init', 'twinesocial_register_mysettings' );
}

function twinesocial_register_mysettings() {
    register_setting('twinesocial-settings-group', 'twinesocial_sitename' );
    register_setting('twinesocial-settings-group', 'twinesocial_sent_welcome' );
}

function twine_remove_footer_admin () 
{
    echo '';
}

function twine_remove_footer_version () 
{
    echo '';
}

add_filter( 'update_footer', 'twine_remove_footer_version', 11 );
add_filter('admin_footer_text', 'twine_remove_footer_admin');
add_filter( 'plugin_action_links' , 'add_action_links' );

function add_action_links ( $links ) {
	$links[] = '<a href="'. get_admin_url(null, 'admin.php?page=twinesocial-key-setting') .'">Build My Hub</a>';
	$links[] = '<a href="' . TWINE_PUBLIC_URL . '" target="_blank">Learn More About Twine<a>';
	return $links;
}


?>