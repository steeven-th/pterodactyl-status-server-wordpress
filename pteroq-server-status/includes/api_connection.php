<?php

defined('ABSPATH') or die('Get out.');

global $wpdb, $table_name_table_pteroq_api_settings;

/* Get settings from the database */
$servers = $wpdb->get_results("SELECT * FROM `{$table_name_table_pteroq_api_settings}` ORDER BY `api_key_id` DESC LIMIT 1");

if ($servers) {

    $apiKeyServer = $servers[0]->api_key_server;
    $apiKeyClient = $servers[0]->api_key_client;
    $apiServerIp = $servers[0]->api_server_address;
    $apiServerAddress = $apiServerIp . ':' . $servers[0]->api_server_port;

    if (empty($servers[0]->api_server_port)) {
        $urlApiPteroqServer = $servers[0]->api_server_protocol . '://' . $apiServerIp . '/api';
    } else {
        $urlApiPteroqServer = $servers[0]->api_server_protocol . '://' . $apiServerIp . ':' . $servers[0]->api_server_port . '/api';
    }
}