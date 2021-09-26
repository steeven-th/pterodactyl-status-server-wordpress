<?php

/*----------------------*/
// VARIABLES
/*----------------------*/

global $table_name_table_pteroq, $wpdb, $urlApiPteroqServer, $apiKeyClient, $apiKeyServer, $apiServerIp;

$server = $wpdb->get_row("SELECT * FROM `{$table_name_table_pteroq}` WHERE `server_id` = {$instance['server_id']}");

$idServer = $server->server_identifier;

/* Establish some needed variables */
$title = apply_filters('widget_title', searchParamServer($idServer, 'name') . " - (" . searchParamServer($idServer, 'gamename') . ")");


echo $before_widget;

echo $before_title . $title . $after_title;

/* Make sure the server exists, else display a notice message */
if ($server) {

    /* Display the widget content */

    echo '<strong>' . __('Status :', 'pteroq-game-server-status') . '</strong> ' . searchParamServer($idServer, 'state') . '<br />';

    echo '<strong>' . __('Server IP :', 'pteroq-game-server-statuss') . '</strong> ' . $apiServerIp . '<br />';

    echo '<strong>' . __('Server port :', 'pteroq-game-server-statuss') . '</strong> ' . searchParamServer($idServer, 'port') . '<br />';

    echo '<strong>' . __('Other ports :', 'pteroq-game-server-statuss') . '</strong><br><div style="margin-left: 20px"> ' . searchParamServer($idServer, 'otherports') . '</div><br />';


} else {

    _e('Your selected server does not exist anymore !', 'pteroq-game-server-status');

}

echo $after_widget;