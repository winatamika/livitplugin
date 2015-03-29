<?php
/*
Plugin Name:  InstaLivit-Mick
Description:
Version: 1.0
Author: mika@mickrabbit.com
Author URI: http://mickrabbit.net
----------------API INSTAGRAM CLIENT INFO---------------------------
CLIENT ID	83ef90c1159b499aa2c34ac9d710ab88
CLIENT SECRET	33e76a67cbe14c029772b9b99a1efba3
ACCESS TOKEN 339106837.83ef90c.0304c7c5d76f402596ff00d5e6c3b547
WEBSITE URL	http://mickrabbit.com
REDIRECT URI	http://mickrabbit.com
--------------------------------------------------------------------
*/



if (!defined('ROOTDIR'))
	define('ROOTDIR', plugin_dir_path(__FILE__));

if (!defined('PLUGIN_BASENAME'))
    define('PLUGIN_BASENAME', plugin_basename(__FILE__));

if (!defined('PLUGIN_NAME'))
    define('PLUGIN_NAME', trim(dirname(PLUGIN_BASENAME), '/'));

if (!defined('PLUGIN_DIR'))
    define('PLUGIN_DIR', untrailingslashit(dirname(__FILE__)));

if (!defined('PLUGIN_URL'))
    define('PLUGIN_URL', untrailingslashit(plugins_url('', __FILE__)));

//for template frontend 
if ( ! defined( 'WPINC' ) ) {
	die;
} // end if

require_once( plugin_dir_path( __FILE__ ) . 'class-page-template.php' );
add_action( 'plugins_loaded', array( 'Page_Template_Plugin', 'get_instance' ) );
//end


require_once(ROOTDIR . 'hello.php');
require_once(ROOTDIR . 'setting.php');




add_shortcode('instalivit', 'liv_shortcode'); 
function liv_shortcode($atts, $content = null) {
require_once(ROOTDIR . 'frontend.php');
}

add_action('admin_menu','liv_modifymenu');
function liv_modifymenu() {

	add_menu_page('Instalivit Module', //page title
	'Instalivit Plugin', //menu title
	'manage_options', //capabilities
	'insta', //menu slug
	 'hello'
	);

	add_submenu_page('insta', //parent slug  PANGGIL FUNCTION NYA 
	'Setting', //page title
	'Setting ', //menu title
	'manage_options', //capability
	'settinginsta', //menu slug
	'settinginsta'); //function


}

function callInstagram($url)
{
	$ch = curl_init();
	curl_setopt_array($ch, array(
	CURLOPT_URL => $url,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_SSL_VERIFYPEER => false,
	CURLOPT_SSL_VERIFYHOST => 2
	));

	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

if( !function_exists('instalivit_install')){
	function instalivit_install(){
		global $wpdb;

			$table_name = 'wp_instagram_comment';
			$sql = "CREATE TABLE $table_name (
			  id_comment int(10) NOT NULL AUTO_INCREMENT,
			  id_media varchar(255) NOT NULL,
			  name varchar (50) NOT NULL,
			  email varchar (50) NOT NULL,
			  comment varchar(255) NOT NULL,
			  rate varchar(50) NOT NULL,
			  UNIQUE KEY id_comment (id_comment)
			);";
			$wpdb->get_results($sql);

			$table_name = 'wp_instagram_setting';
			$sql = "CREATE TABLE $table_name (
			  id_setting int(10) NOT NULL AUTO_INCREMENT,
			  client_id varchar (255) NOT NULL,
			  client_secret varchar (255) NOT NULL,
			  access_token varchar(255) NOT NULL,
			  UNIQUE KEY id_setting (id_setting)
			);";
			$wpdb->get_results($sql);

			$table_name = 'wp_instagram_setting';
			$sql = "INSERT INTO $table_name (client_id, client_secret, access_token)
			VALUES ('83ef90c1159b499aa2c34ac9d710ab88', '33e76a67cbe14c029772b9b99a1efba3', '339106837.83ef90c.0304c7c5d76f402596ff00d5e6c3b547');";
			$wpdb->get_results($sql);

	}


}


if( !function_exists('instalivit_uninstall')){
	function instalivit_uninstall(){
		global $wpdb;
				$table_name = 'wp_instagram_comment';
				$sql = "DROP table $table_name;";
				$wpdb->get_results($sql);

				$table_name = 'wp_instagram_setting';
				$sql = "DROP table $table_name;";
				$wpdb->get_results($sql);

	}
}

register_activation_hook( __FILE__, 'instalivit_install' );
register_deactivation_hook( __FILE__, 'instalivit_uninstall' );
?>