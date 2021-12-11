<?php

defined('ABSPATH') or die('Get out.');

/*----------------------*/
// VARIABLES
/*----------------------*/

global $table_name_table_pteroq_api_settings, $wpdb, $apiKeyServer, $apiKeyClient, $apiServerAddress;

$api_key_server = $api_key_client = $api_server_address = $api_server_port = null;

/*----------------------*/
// CHECK IF THE GET SERVER ID IS PASSED
/*----------------------*/

if (!empty($_GET['api_key_id'])) {

    /* Try to get the server data */
    $server = $wpdb->get_row("SELECT * FROM `{$table_name_table_pteroq_api_settings}` WHERE `api_key_id` = {$_GET['api_key_id']}", ARRAY_A);

    /* If the server exists, extract the data, if not then delete the GET parameter */
    if ($server) {
        extract($server);
    } else {
        unset($_GET['api_key_id']);
    }

}

/*----------------------*/
// ADD NEW SETTINGS
/*----------------------*/

if (!empty($_POST)) {

    /* Possible error checks */
    $fields = array('api_key_server', 'api_key_client', 'api_server_address', 'api_server_protocol', 'api_server_port');

    foreach ($_POST as $key => $value) {
        if (empty($value) && in_array($key, $fields) == true) {
            $errors[] = __('All the fields are required !', 'pteroq-game-server-status');
            break 1;
        }
    }

    if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'add-settings')) {
        $errors[] = __('Your nonce did not verify !', 'pteroq-game-server-status');
    }

    /* If there are no errors then proceed */
    if (empty($errors)) {

        /* Check if settings exists */
        /* Get the settings from the database */
        $servers = $wpdb->get_results("SELECT * FROM `$table_name_table_pteroq_api_settings` ORDER BY `api_key_id` DESC LIMIT 1");

        if ($servers || !empty($_GET['api_key_id'])) {


            if (empty($_GET['api_key_id'])) {
                $apiId = $servers[0]->api_key_id;
            } else {
                $apiId = $_GET['api_key_id'];
            }


            $wpdb->update(
                $table_name_table_pteroq_api_settings,
                array(
                    'api_key_server' => $_POST['api_key_server'],
                    'api_key_client' => $_POST['api_key_client'],
                    'api_server_protocol' => $_POST['api_server_protocol'],
                    'api_server_address' => $_POST['api_server_address'],
                    'api_server_port' => $_POST['api_server_port']
                ),
                array(
                    'api_key_id' => $apiId
                )
            );

            /* Refresh the current variables */
            $server = $wpdb->get_row("SELECT * FROM `{$table_name_table_pteroq_api_settings}` WHERE `api_key_id` = {$apiId}", ARRAY_A);
            extract($server);

            /* Display a success message */
            echo '<div class="updated"><p>' . __('The settings was successfully updated !', 'pteroq-game-server-status') . '</p></div>';

            /* redirect to the list after update server */
            echo '<script> setTimeout(function () { location.replace("' . admin_url() . 'admin.php?page=pteroq-server-status' . '")}, 1000); </script>';

        } else {

            $wpdb->insert(
                $table_name_table_pteroq_api_settings,
                array(
                    'api_key_server' => $_POST['api_key_server'],
                    'api_key_client' => $_POST['api_key_client'],
                    'api_server_protocol' => $_POST['api_server_protocol'],
                    'api_server_address' => $_POST['api_server_address'],
                    'api_server_port' => $_POST['api_server_port']
                )
            );

            /* Display a success message */
            echo '<div class="updated"><p>' . __('The settings was successfully added to the database !', 'pteroq-game-server-status') . '</p></div>';

            /* redirect to the list after add server */
            echo '<script> setTimeout(function () { location.replace("' . admin_url() . 'admin.php?page=pteroq-server-status' . '")}, 1000); </script>';

        }

    } else {
        sthomas_pteroq_display_errors($errors);
    }
}

/* Get the settings from the database */
$servers = $wpdb->get_results("SELECT * FROM `$table_name_table_pteroq_api_settings` ORDER BY `api_key_id` DESC LIMIT 1");

?>

<div id="col-container" class="wp-clearfix">
    <div id="col-left">
        <div class="wrap">
            <h2><?php echo __('Edit API settings', 'pteroq-game-server-status'); ?></h2>

            <!-- Form for add settings -->
            <form method="post" action="">
                <table class="form-table">

                    <tr valign="top">
                        <th scope="row">
                            <label for=""><?php _e('Server API key', 'pteroq-game-server-status'); ?></label>
                        <td>
                            <input type="text" name="api_key_server" class="regular-text"
                                   value="<?php echo $api_key_server; ?>"/>
                        </td>
                        </th>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for=""><?php _e('Client API key', 'pteroq-game-server-status'); ?></label>
                        <td>
                            <input type="text" name="api_key_client" class="regular-text"
                                   value="<?php echo $api_key_client; ?>"/>
                        </td>
                        </th>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for=""><?php _e('Server protocol adress', 'pteroq-game-server-status'); ?></label>
                        <td>
                            <select name="api_server_protocol" class="regular-text">
                                <option value="http">
                                    http
                                </option>
                                <option value="https">
                                    https
                                </option>
                            </select>
                        </td>
                        </th>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for=""><?php _e('Server API adress', 'pteroq-game-server-status'); ?></label>
                        <td>
                            <input type="text" name="api_server_address" class="regular-text"
                                   value="<?php echo $api_server_address; ?>"/>
                            <p class="add-server-ip"><?php _e('ATTENTION :', 'pteroq-game-server-status'); ?></p>
                            <p class="add-server-ip"><?php _e('Please insert just your IP of Pterodactyl Panel, without protocol', 'pteroq-game-server-status'); ?></p>
                            <p class="add-server-ip"><?php _e('Like this example : 80.70.60.50', 'pteroq-game-server-status'); ?></p>
                        </td>
                        </th>
                    </tr>

                    <tr valign="top">
                        <th scope="row">
                            <label for=""><?php _e('Server port address', 'pteroq-game-server-status'); ?></label>
                        <td>
                            <input type="text" name="api_server_port" class="regular-text"
                                   value="<?php if (!empty($_GET['api_key_id'])) echo $api_server_port; ?>"/>
                            <p class="add-server-ip"><?php _e('ATTENTION : if you use port 80, leave this option blank', 'pteroq-game-server-status'); ?></p>
                        </td>
                        </th>
                    </tr>

                </table>

                <?php wp_nonce_field('add-settings'); ?>
                <?php submit_button(__('Submit', 'pteroq-game-server-status')); ?>
            </form>

        </div>
    </div>
    <div id="col-right">
        <div class="wrap">
            <h2>
                <?php _e('Pterodactyl API settings', 'pteroq-game-server-status'); ?>
            </h2>

            <?php if ($servers) { ?>
                <table class="wp-list-table widefat fixed striped table-view-list tags">

                    <!-- Head of the board -->
                    <thead>
                    <tr>
                        <th><?php _e('Server API key', 'pteroq-game-server-status'); ?></th>
                        <th><?php _e('Client API key', 'pteroq-game-server-status'); ?></th>
                        <th><?php _e('Server API adress', 'pteroq-game-server-status'); ?></th>
                        <th class="actions_td"><?php _e('Actions', 'pteroq-game-server-status'); ?></th>
                    </tr>
                    </thead>

                    <!-- Body of the board -->
                    <tbody>
                    <tr>
                        <td><?php echo $apiKeyServer; ?></td>
                        <td><?php echo $apiKeyClient; ?></td>
                        <td><?php echo $apiServerAddress; ?></td>
                        <td class="actions_td">
                            <a href="<?php echo wp_nonce_url(admin_url() . 'admin.php?page=pteroq-settings&api_key_id=' . $servers[0]->api_key_id, 'add-settings'); ?>"><?php _e('Edit', 'pteroq-game-server-status'); ?></a>
                        </td>
                    </tr>
                    </tbody>

                </table>

                <!-- Error message -->
            <?php } else echo '<div class="error"><p>' . __('There are no settings added in the database at the moment !', 'game-server-status') . '</p></div>'; ?>
        </div>
    </div>
</div>