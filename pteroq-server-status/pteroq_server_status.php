<?php
/*
Plugin Name: Pterodactyl games servers status
Plugin URI: https://github.com/steeven-th/pterodactyl-status-server-wordpress
Description: Allows you to see all the information of your game servers from the Pterodactyl Panel
Author: Steeven
Version: 1.0.1
Author URI: https://steeven-th.dev
Text Domain: pteroq-game-server-status
Domain Path: /languages/
*/

defined('ABSPATH') or die('Get out.');

/* Define a path variable */
$plugin_path_pteroq_server = plugin_dir_path(__FILE__);


/*----------------------*/
// UPDATE DATABASE TABLE WHEN THE PLUGIN IS ACTIVATED
/*----------------------*/

function sthomas_pteroq_update_table() {
    global $wpdb;

    $table_name_table_pteroq = $wpdb->prefix . 'pteroq_game_servers';
    $table_name_table_pteroq_api_settings = $wpdb->prefix . 'pteroq_api_settings';


    if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name_table_pteroq}'") != $table_name_table_pteroq) {

        $charset_collate = $wpdb->get_charset_collate();

        $table_pteroq = "CREATE TABLE $table_name_table_pteroq (
			`server_id` INT( 11 ) NOT NULL AUTO_INCREMENT,
			`server_identifier` varchar(64) NOT NULL,
			PRIMARY KEY (`server_id`)
		) $charset_collate;";

        $table_pteroq_api_settings = "CREATE TABLE $table_name_table_pteroq_api_settings (
			`api_key_id` INT( 11 ) NOT NULL AUTO_INCREMENT,
			`api_key_server` varchar(64) NOT NULL,
			`api_key_client` varchar(64) NOT NULL,
			`api_server_protocol` varchar(64) NOT NULL,
			`api_server_address` varchar(64) NOT NULL,
			`api_server_port` varchar(64) NOT NULL,
			PRIMARY KEY (`api_key_id`)
		) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($table_pteroq);
        dbDelta($table_pteroq_api_settings);
    }
}

register_activation_hook(__FILE__, 'sthomas_pteroq_update_table');


/*----------------------*/
// CSS
/*----------------------*/
function addCss() {

    echo '<style>';
    include 'admin/css/pteroq.css';
    echo '</style>';
}

add_action('admin_head', 'addCss');

function addCssShortCode() {
    wp_register_style('css-shortcode', plugins_url('public/css/pteroq.css', __FILE__));
    wp_enqueue_style('css-shortcode');
}

// Register style sheet.
add_action('wp_enqueue_scripts', 'addCssShortCode');

/*----------------------*/
// INCLUDE ALL THE REQUIRED FILES
/*----------------------*/

require_once $plugin_path_pteroq_server . 'includes/init.php';
require_once $plugin_path_pteroq_server . 'includes/settings.php';
require_once $plugin_path_pteroq_server . 'includes/api_connection.php';
require_once $plugin_path_pteroq_server . 'includes/curl_request.php';
require_once $plugin_path_pteroq_server . 'includes/shortcodes.php';
require_once $plugin_path_pteroq_server . 'admin/templates/widget.php';