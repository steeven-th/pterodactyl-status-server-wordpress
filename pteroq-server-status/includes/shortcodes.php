<?php

function sthomas_game_servers_shortcode($atts, $message = null) {
    global $wpdb, $table_name_table_pteroq, $plugin_path_pteroq_server, $urlApiPteroqServer, $apiKeyClient, $apiKeyServer, $apiServerIp;

    $data = shortcode_atts(
        array('server_identifier' => '1', 'display' => 'all'),
        $atts
    );

    global $content;
    $content = null;

    /* Get the server data */
    $server = $wpdb->get_row("SELECT * FROM `{$table_name_table_pteroq}` WHERE `server_identifier` = '{$data['server_identifier']}'");

    /* Make sure the server exists, else display a notice message */
    if ($server) {

        $idServer = $server->server_identifier;

        /* Display the widget content */

        if (searchParamServer($idServer, 'state') == '404') {
            displayShortCode($data, 'SERVER NOT FOUND - CHECK ID', searchParamServer($idServer, 'state'), searchParamServer($idServer, 'gamename'), $apiServerIp, searchParamServer($idServer, 'port'), searchParamServer($idServer, 'otherports'), 'down');
        } else if (searchParamServer($idServer, 'state') == 'offline') {
            displayShortCode($data, searchParamServer($idServer, 'name'), searchParamServer($idServer, 'state'), searchParamServer($idServer, 'gamename'), $apiServerIp, searchParamServer($idServer, 'port'), searchParamServer($idServer, 'otherports'), 'offline');
        } else if (searchParamServer($idServer, 'state') == 'online' || 'running') {
            displayShortCode($data, searchParamServer($idServer, 'name'), searchParamServer($idServer, 'state'), searchParamServer($idServer, 'gamename'), $apiServerIp, searchParamServer($idServer, 'port'), searchParamServer($idServer, 'otherports'), 'online');
        }


    } else {

        $content .= __('Your selected server does not exist anymore !', 'pteroq-game-server-status');
    }

    return $content;
}

/* HTML & CSS code for display shortcode */
function displayShortCode($data, $name, $state, $game_engine, $server_ip, $connectionPort, $otherPorts, $class) {

    global $content;

    /* Display the widget content */
    switch ($data['display']) {
        case 'server_name'        :
            $content .= '<div class="server-box-' . $class . ' is-' . $class . '"><h3 class="servertitle-' . $class . '">' . $name . ' - (Game : ' . $game_engine . ')</h3><br />';
            break;
        case 'server_status'    :
            $content .= '<strong>' . __('Status : ', 'pteroq-game-server-status') . '</strong> ' . $state . '<br />';
            break;
        case 'server_address'    :
            $content .= '<strong>' . __('Server IP : ', 'pteroq-game-server-status') . '</strong> ' . $server_ip . ':' . $connectionPort . '<br />';
            break;
        case 'server_other_ports'            :
            $content .= '<strong>' . __('Other ports : ', 'pteroq-game-server-status') . '</strong><br><div style="margin-left: 20px"> ' . $otherPorts . '</div><br /></div>';
            break;

        default:
            $content .= '<div class="server-box-' . $class . ' is-' . $class . '"><h3 class="servertitle-' . $class . '">' . $name . ' - (Game : ' . $game_engine . ')</h3><br />';
            $content .= '<strong>' . __('Status : ', 'pteroq-game-server-status') . '</strong> ' . $state . '<br />';
            $content .= '<strong>' . __('Server IP : ', 'pteroq-game-server-status') . '</strong> ' . $server_ip . ':' . $connectionPort . '<br />';
            $content .= '<strong>' . __('Other ports : ', 'pteroq-game-server-status') . '</strong><br><div style="margin-left: 20px"> ' . $otherPorts . '</div></div><br />';
            break;
    }
}

/* Register the ShortCodes */
add_shortcode('pteroq-game-servers', 'sthomas_game_servers_shortcode');

?>