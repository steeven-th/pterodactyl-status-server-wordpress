<?php

defined('ABSPATH') or die('Get out.');

/*----------------------*/
// VARIABLES
/*----------------------*/

global $table_name_table_pteroq, $wpdb, $urlApiPteroqServer, $apiKeyClient, $apiKeyServer, $apiServerIp, $err;

$lastError = null;

/*----------------------*/
// DELETE SERVER
/*----------------------*/

/* Check if the GET server id is passed */
if (!empty($_GET['server_id'])) {

    /* Security check */
    if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'delete-server')) {
        $errors[] = __('Your nonce did not verify !', 'pteroq-game-server-status');
    }

    /* If there are no errors then proceed */
    if (empty($errors)) {

        $wpdb->delete(
            $table_name_table_pteroq,
            array('server_id' => $_GET['server_id'])
        );

        /* Display a success message */
        echo '<div class="updated"><p>' . __('The server was successfully deleted from the database !', 'pteroq-game-server-status') . '</p></div>';

    } else {
        display_errors($errors);
    }
}

/* Get the servers from the database */
$servers = $wpdb->get_results("SELECT * FROM `{$table_name_table_pteroq}` ORDER BY `server_id` DESC ");

/*----------------------*/
// GAME SERVER PANEL
/*----------------------*/

?>

    <div class="wrap">
        <h2>
            <?php _e('Pterodactyl Game Servers List', 'pteroq-game-server-status'); ?>
            <a href="<?php echo admin_url() . 'admin.php?page=pteroq-add-game-server'; ?>"
               class="add-new-h2"><?php _e('Add New', 'pteroq-game-server-status'); ?></a>
        </h2>
        <?php if ($servers) { ?>
            <table class="wp-list-table widefat fixed table-view-list tags">

                <!-- Head of the board -->
                <thead>
                <tr>
                    <th><?php _e('Server ID', 'pteroq-game-server-status'); ?></th>
                    <th><?php _e('Name', 'pteroq-game-server-status'); ?></th>
                    <th><?php _e('Server IP', 'pteroq-game-server-status'); ?></th>
                    <th><?php _e('Connection Port', 'pteroq-game-server-status'); ?></th>
                    <th><?php _e('Other Ports', 'pteroq-game-server-status'); ?></th>
                    <th><?php _e('Game Engine', 'pteroq-game-server-status'); ?></th>
                    <th><?php _e('Server State', 'pteroq-game-server-status'); ?></th>
                    <th><?php _e('Actions', 'pteroq-game-server-status'); ?></th>
                </tr>
                </thead>

                <!-- Body of the board -->
                <tbody>
                <?php

                foreach ($servers as $server) {

                    $idServer = $server->server_identifier;

                    if ($err && strcmp($lastError, $err) !== 0) {
                        display_errors($err);
                    }

                    $lastError = $err;

                    /* If state of server is 404 or null */
                    if (searchParamServer($idServer, 'state') == '404' || searchParamServer($idServer, 'state') == null) {

                        displayGameServer($server->server_identifier, $server->server_id, $apiServerIp, 'down');

                    } else if (searchParamServer($idServer, 'state') == 'offline') { // If state of server is offline

                        displayGameServer($server->server_identifier, $server->server_id, $apiServerIp, 'offline');

                    } else if (searchParamServer($idServer, 'state') == 'online' || searchParamServer($idServer, 'state') == 'running') { // If state of server is online or running

                        displayGameServer($server->server_identifier, $server->server_id, $apiServerIp, 'online');

                    }
                }
                ?>
                </tbody>

            </table>

            <!-- Error message -->
        <?php } else echo '<div class="error"><p>' . __('There are no games added in the database at the moment !', 'game-server-status') . '</p></div>'; ?>
    </div>

<?php

/* HTML & CSS code for display Game Server */
function displayGameServer($identifier, $id, $apiServerIp, $class) {
    ?>
    <tr class="server-box-<?php echo $class ?> is-<?php echo $class ?>">
        <td class="server-box is-<?php echo $class ?> is-<?php echo $class ?>-left"><?php echo $identifier; ?></td>
        <?php
        if ($class == 'down') {
            ?>
            <td class="is-<?php echo $class ?>"
                style="font-weight: bolder"><?php _e('<= SERVER NOT FOUND - CHECK ID', 'pteroq-game-server-status'); ?></td>
            <?php
        } else {
            ?>
            <td class="is-<?php echo $class ?>"><?php echo searchParamServer($identifier, 'name'); ?></td>
            <?php
        }
        ?>
        <td class="is-<?php echo $class ?>"><?php echo $apiServerIp; ?></td>
        <td class="is-<?php echo $class ?>"><?php echo searchParamServer($identifier, 'port'); ?></td>
        <td class="is-<?php echo $class ?>"><?php echo searchParamServer($identifier, 'otherports'); ?></td>
        <td class="is-<?php echo $class ?>"><?php echo searchParamServer($identifier, 'gamename'); ?></td>

        <?php
        if ($class == 'down') {
            ?>
            <td class="is-<?php echo $class ?>"><?php _e('ERROR', 'pteroq-game-server-status');
                echo ' ' . searchParamServer($identifier, 'state'); ?></td>
            <?php
        } else {
            ?>
            <td class="is-<?php echo $class ?>"><?php echo searchParamServer($identifier, 'state'); ?></td>
            <?php
        }
        ?>
        <td class="is-<?php echo $class ?>">
            <a href="<?php echo admin_url() . 'admin.php?page=pteroq-add-game-server&server_id=' . $id; ?>"><?php _e('Edit', 'pteroq-game-server-status'); ?></a>
            |
            <a href="<?php echo wp_nonce_url(admin_url() . 'admin.php?page=pteroq-server-status&server_id=' . $id, 'delete-server'); ?>"
               onclick="confirm('<?php _e('Are you sure you want to do this ?', 'pteroq-game-server-status'); ?>');"><?php _e('Delete', 'pteroq-game-server-status'); ?></a>
        </td>
    </tr>
    <?php
}