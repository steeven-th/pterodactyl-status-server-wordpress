<?php

if (!defined('WP_UNINSTALL_PLUGIN')) exit();

global $wpdb;

$table_name_table_pteroq = $wpdb->prefix . 'pteroq_game_servers';
$table_name_table_pteroq_api_settings = $wpdb->prefix . 'pteroq_api_settings';

if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name_table_pteroq}'") == $table_name_table_pteroq) {
    $wpdb->query("DROP TABLE `{$table_name_table_pteroq}`;");
}

if ($wpdb->get_var("SHOW TABLES LIKE '{$table_name_table_pteroq_api_settings}'") == $table_name_table_pteroq_api_settings) {
    $wpdb->query("DROP TABLE `{$table_name_table_pteroq_api_settings}`;");
}