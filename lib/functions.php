<?php
/**
 * Create the setting menu link and register settings
 */

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
?>