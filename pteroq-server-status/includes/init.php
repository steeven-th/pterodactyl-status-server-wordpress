<?php

defined('ABSPATH') or die('Get out.');


/*----------------------*/
// INTERNATIONALIZATION
/*----------------------*/

$languageDirectory = plugin_basename(dirname(__FILE__, 2));
load_plugin_textdomain('pteroq-game-server-status', false, "$languageDirectory/languages/");

/*----------------------*/
// VARIABLES & SEARCH SERVER
/*----------------------*/

$errors = array();
$table_name_table_pteroq = $wpdb->prefix . 'pteroq_game_servers';
$table_name_table_pteroq_api_settings = $wpdb->prefix . 'pteroq_api_settings';

function searchParamServer($id, $type) {
    global $urlApiPteroqServer, $apiKeyClient, $apiKeyServer;

    if ($type == 'name') {
        return serverAttributes($urlApiPteroqServer, $apiKeyClient, $id, 'name');
    } else if ($type == 'port') {
        return serverAttributes($urlApiPteroqServer, $apiKeyClient, $id, 'connectionport');
    } else if ($type == 'otherports') {
        return serverAttributes($urlApiPteroqServer, $apiKeyClient, $id, 'otherports');
    } else if ($type == 'state') {
        return serverState($urlApiPteroqServer, $apiKeyClient, $id);
    } else if ($type == 'gamename') {
        return eggName($urlApiPteroqServer, $apiKeyServer, $id, '', 'id_egg');
    }
}

/*----------------------*/
// CUSTOM ERROR DISPLAY
/*----------------------*/

function sthomas_pteroq_display_errors($errors) {

    if (!is_array($errors)) $errors = array($errors);

    foreach ($errors as $error) {
        echo '<div class="error"><p>' . $error . '</p></div>';
    }

}