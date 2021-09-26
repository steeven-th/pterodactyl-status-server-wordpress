<?php

defined('ABSPATH') or die('Get out.');
?>
<h2>Documentation</h2>

<h3><?php _e('Requirements', 'pteroq-game-server-status'); ?></h3>
<ol>
    <li>
        <strong><?php _e('Pterodactyl Panel - API key server', 'pteroq-game-server-status'); ?></strong>
        <ul><?php _e('You need to set up an API server key with read permission. Follow these
            steps', 'pteroq-game-server-status'); ?> :

            <li>- <?php _e('Go to <strong style="color: cornflowerblue">\'Administration
                    Panel / Application API\'</strong>', 'pteroq-game-server-status'); ?>
            </li>
            <li>
                - <?php _e('Click on <strong style="color: cornflowerblue">\'Create
                    New\'</strong>', 'pteroq-game-server-status'); ?>
            </li>
            <li>
                - <?php _e('Select <strong style="color: cornflowerblue">\'Read\'</strong> for <strong
                        style="color: cornflowerblue">Allocations, Eggs, Locations, Nests, Servers</strong>
                (you can select all if you prefer)', 'pteroq-game-server-status'); ?>
            </li>
            <li>
                - <?php _e('Make sure you register the key provided', 'pteroq-game-server-status'); ?>
            </li>
        </ul>
    </li>

    <br>

    <li>
        <strong><?php _e('Pterodactyl Panel - API key client', 'pteroq-game-server-status'); ?></strong>
        <ul><?php _e('You need to set up an API client key with read permission. Follow these steps', 'pteroq-game-server-status'); ?>
            :

            <li>
                - <?php _e('Click on your username at the top right', 'pteroq-game-server-status'); ?>
            </li>
            <li>
                - <?php _e('Click on <strong style="color: cornflowerblue">\'API
                    Credentials\'</strong>', 'pteroq-game-server-status'); ?>
            </li>
            <li>
                - <?php _e('Enter a description for your Key', 'pteroq-game-server-status'); ?>
            </li>
            <li>
                - <?php _e('Click on <strong
                        style="color: cornflowerblue">\'Create\'</strong>', 'pteroq-game-server-status'); ?>
            </li>
            <li>
                - <?php _e('Make sure you register the key provided', 'pteroq-game-server-status'); ?>
            </li>
        </ul>
    </li>

    <br>

    <li>
        <strong><?php _e('Pterodactyl Panel - informations', 'pteroq-game-server-status'); ?></strong>
        <ul><?php _e('You need the following information', 'pteroq-game-server-status'); ?> :

            <li>
                - <?php _e('The PROTOCOLE of your address of your Pterodactyl Panel', 'pteroq-game-server-status'); ?>
            </li>
            <li>
                - <?php _e('The IP address of your Pterodactyl Panel', 'pteroq-game-server-status'); ?>
            </li>
            <li>
                - <?php _e('The PORT of your Pterodactyl Panel', 'pteroq-game-server-status'); ?>
            </li>
        </ul>
    </li>
</ol>

<br>

<strong style="color: red"><?php _e('ATTENTION : make sure you know which is the server key and which is the client
    key', 'pteroq-game-server-status'); ?></strong>

<br>

<h2 style="color: cornflowerblue"><?php _e('To configure the plugin, go to Settings in the admin
    menu', 'pteroq-game-server-status'); ?></h2>

<br>

<h3>Shortcodes</h3>
<p><?php _e('Make sure you have at least 1 server added to the database before trying to add a shortcode
    !', 'pteroq-game-server-status'); ?></p>

<h4><?php _e('Basic Shortcode use', 'pteroq-game-server-status'); ?></h4>
<p><?php _e('You must specify the <strong style="color: cornflowerblue">\'server_id\'</strong> of the server you want to get
    details. You can find the <strong style="color: cornflowerblue">\'server_id\'</strong> in the <strong
            style="color: cornflowerblue">\'Game server\'</strong> menu in the admin
    panel.', 'pteroq-game-server-status'); ?></p>

<strong style="color: cornflowerblue">
    <code>
        [game-servers server_id="1"]
    </code>
</strong>

<h4><?php _e('Get specific details of a server', 'pteroq-game-server-status'); ?></h4>
<p><?php _e('If you want to get a specific data from a server you will need to specify the
    <strong>display</strong>
    parameter.', 'pteroq-game-server-status'); ?>
</p>

<strong style="color: cornflowerblue">
    <code>
        [game-servers server_id="1" display="server_name"]
    </code>
</strong>

<p><?php _e('That will only output the name of the server.Possible values for the <strong
            style="color: cornflowerblue">\'display\'</strong>
    parameter', 'pteroq-game-server-status'); ?> :
</p>
<ul>
    <strong style="color: cornflowerblue">
        <li>server_name</li>
        <li>server_status</li>
        <li>server_address</li>
        <li>server_other_ports</li>
    </strong>
</ul>

<h3>FAQ's</h3>
<ol>
    <li>
        <strong><?php _e('The server status is <span style="color: darkred">404</span> and the name is <span
                    style="color: darkred">SERVEUR NOT FOUND - CHECK ID</span>', 'pteroq-game-server-status'); ?>
        </strong>
    </li>
    <ul>
        <?php _e('Please check that the server ID is correct or that the server
        exists', 'pteroq-game-server-status'); ?>
    </ul>
    <br>
    <li>
        <strong><?php _e('Can I set up two Pterodactyl Panels ?', 'pteroq-game-server-status'); ?></strong>
    </li>
    <ul>
        <?php _e('Only one Pterodactyl Panel can be configured in the settings for the
        moment', 'pteroq-game-server-status'); ?>
    </ul>
</ol>

<h3>Contact</h3>
<p><?php _e('You can contact me for support or to submit your ideas by clicking on the
    icons', 'pteroq-game-server-status'); ?></p>

<div class="doc-icon">
    <a href="https://github.com/steeven-th/pterodactyl-status-server-wordpress" class="doc-link"
       target="_blank">
        <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Octicons-mark-github.svg"
             style="width: 50px">
    </a>
    <a href="https://steeven-th.dev" class="doc-link" target="_blank">
        <img src="https://avatars.githubusercontent.com/u/82022828?s=96&v=4" style="width: 50px">
    </a>
    <a href="https://twitter.com/ThomasSteeven2" class="doc-link" target="_blank">
        <img src="https://upload.wikimedia.org/wikipedia/fr/c/c8/Twitter_Bird.svg" style="width: 50px">
    </a>
</div>
