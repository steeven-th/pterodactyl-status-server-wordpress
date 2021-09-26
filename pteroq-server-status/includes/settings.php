<?php

defined('ABSPATH') or die('Get out.');

/*----------------------*/
// ADD MENU IN ADMIN PANEL
/*----------------------*/


/* Default settings page */
function sthomas_pteroq_list_game_servers() {
    global $plugin_path_pteroq_server;

    include $plugin_path_pteroq_server . 'admin/templates/game_servers.php';
}

function sthomas_pteroq_add_game_servers() {

    global $plugin_path_pteroq_server;

    include $plugin_path_pteroq_server . 'admin/templates/add_game_servers.php';
}

function sthomas_pteroq_settings() {

    global $plugin_path_pteroq_server;

    include $plugin_path_pteroq_server . 'admin/templates/api_setup.php';
}

function sthomas_pteroq_documentation() {

    global $plugin_path_pteroq_server;

    include $plugin_path_pteroq_server . 'admin/templates/game_servers_documentation.php';
}

function sthomas_pteroq_server_status_setup_menu() {

    add_menu_page(
        __('Pterodactyl server status', 'pteroq-game-server-status'), // the page title
        __('Pterodactyl server status', 'pteroq-game-server-status'), //menu title
        'manage_options', //capability
        'pteroq-server-status', //menu slug
        'sthomas_pteroq_list_game_servers' //callback function
    );

    add_submenu_page(
        'pteroq-server-status',
        __('Pterodactyl server status', 'pteroq-game-server-status'),
        __('Game Server', 'pteroq-game-server-status'),
        'manage_options',
        'pteroq-server-status',
        'sthomas_pteroq_list_game_servers');

    add_submenu_page(
        'pteroq-server-status',
        __('Pterodactyl server status', 'pteroq-game-server-status'),
        __('Add Game Server', 'pteroq-game-server-status'),
        'manage_options',
        'pteroq-add-game-server',
        'sthomas_pteroq_add_game_servers');

    add_submenu_page(
        'pteroq-server-status',
        __('Pterodactyl server status', 'pteroq-game-server-status'),
        __('Settings', 'pteroq-game-server-status'),
        'manage_options',
        'pteroq-settings',
        'sthomas_pteroq_settings');

    add_submenu_page(
        'pteroq-server-status',
        __('Pterodactyl server status', 'pteroq-game-server-status'),
        __('Documentation', 'pteroq-game-server-status'),
        'manage_options',
        'pteroq-documentation',
        'sthomas_pteroq_documentation');
}

add_action('admin_menu', 'sthomas_pteroq_server_status_setup_menu');