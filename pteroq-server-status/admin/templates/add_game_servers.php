<?php

defined('ABSPATH') or die('Get out.');

/*----------------------*/
// VARIABLES
/*----------------------*/

global $table_name_table_pteroq, $table_name_table_pteroq_game_list, $wpdb;

$server_identifier = null;

/*----------------------*/
// CHECK IF THE GET SERVER ID IS PASSED
/*----------------------*/

if (!empty($_GET['server_id'])) {

    /* Try to get the server data */
    $server = $wpdb->get_row("SELECT * FROM `{$table_name_table_pteroq}` WHERE `server_id` = {$_GET['server_id']}", ARRAY_A);

    /* If the server exists, extract the data, if not then delete the GET parameter */
    if ($server) {
        extract($server);
    } else {
        unset($_GET['server_id']);
    }

}

/*----------------------*/
// ADD NEW SERVER
/*----------------------*/

if (!empty($_POST)) {

    /* Possible error checks */
    $fields = array('server_identifier');

    foreach ($_POST as $key => $value) {
        if (empty($value) && in_array($key, $fields) == true) {
            $errors[] = __('All the fields are required !', 'pteroq-game-server-status');
            break 1;
        }
    }

    if (!wp_verify_nonce($_REQUEST['_wpnonce'], 'add-server')) {
        $errors[] = __('Your nonce did not verify !', 'pteroq-game-server-status');
    }

    /* If there are no errors then proceed */
    if (empty($errors)) {

        if (!empty($_GET['server_id'])) {

            $wpdb->update(
                $table_name_table_pteroq,
                array(
                    'server_identifier' => $_POST['server_identifier']
                ),
                array(
                    'server_id' => $_GET['server_id']
                )
            );

            /* Refresh the current variables */
            $server = $wpdb->get_row("SELECT * FROM `{$table_name_table_pteroq}` WHERE `server_id` = {$_GET['server_id']}", ARRAY_A);
            extract($server);

            /* Display a success message */
            echo '<div class="updated"><p>' . __('The server was successfully updated !', 'pteroq-game-server-status') . '</p></div>';

            /* redirect to the list after update server */
            echo '<script> setTimeout(function () { location.replace("' . admin_url() . 'admin.php?page=pteroq-server-status' . '")}, 1000); </script>';

        } else {

            $wpdb->insert(
                $table_name_table_pteroq,
                array(
                    'server_identifier' => $_POST['server_identifier']
                )
            );

            /* Display a success message */
            echo '<div class="updated"><p>' . __('The server was successfully added to the database !', 'pteroq-game-server-status') . '</p></div>';

            /* redirect to the list after add server */
            echo '<script> setTimeout(function () { location.replace("' . admin_url() . 'admin.php?page=pteroq-server-status' . '")}, 1000); </script>';

        }

    } else {
        sthomas_pteroq_display_errors($errors);
    }
}

/* Get the game list from the database */
$servers_game_list = $wpdb->get_results("SELECT * FROM `{$table_name_table_pteroq_game_list}` ORDER BY `game_id` DESC ");

?>

<div class="wrap">
    <h2><?php echo (!empty($_GET['server_id'])) ? __('Edit Server', 'pteroq-game-server-status') : __('Add Game Server', 'pteroq-game-server-status'); ?></h2>

    <!-- Form for add server -->
    <form method="post" action="">
        <table class="form-table">

            <tr valign="top">
                <th scope="row">
                    <label for=""><?php _e('Server Identifier', 'pteroq-game-server-status'); ?></label>
                <td>
                    <input type="text" name="server_identifier" class="regular-text"
                           value="<?php echo $server_identifier; ?>"/>
                    <p><?php _e('ATTENTION :', 'pteroq-game-server-status'); ?></p>
                    <p><?php _e('Please insert the first set of digits of the server UUID', 'pteroq-game-server-status'); ?></p>
                    <p><?php _e('Like this example : <span class="add-server-ip">7e3340f0</span>-acb6-4eb8-bf41-54a6938e80d2', 'pteroq-game-server-status'); ?></p>
                </td>
                </th>
            </tr>
        </table>

        <?php wp_nonce_field('add-server'); ?>
        <?php submit_button(__('Submit', 'pteroq-game-server-status')); ?>
    </form>

</div>