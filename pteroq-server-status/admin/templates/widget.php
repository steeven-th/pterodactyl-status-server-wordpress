<?php

/* Create the Widget */

class sthomas_game_server_status extends WP_Widget {

    function __construct() {

        parent::__construct(
            'pteroq_game_server_status_widget',
            __('Pterodactyl game Server', 'pteroq-game-server-status'),
            array('description' => __('Display live statistics for your game server of Pterodactyl Panel', 'pteroq-game-server-status'))
        );

    }

    /* Displaying the form in the admin panel */
    function form($instance) {
        global $wpdb, $table_name_table_pteroq;

        $defaults = array(
            'server_id' => ''
        );

        $instance = wp_parse_args((array) $instance, $defaults);

        ?>

        <p>
            <label for="<?php echo $this->get_field_id('server_id'); ?>"><?php _e('Server', 'pteroq-game-server-status'); ?></label>
            <select id="<?php echo $this->get_field_id('server_id'); ?>"
                    name="<?php echo $this->get_field_name('server_id'); ?>" class="widefat">
                <?php
                $servers = $wpdb->get_results("SELECT * FROM `{$table_name_table_pteroq}` ORDER BY `server_id` DESC");

                foreach ($servers as $server) {
                    echo '<option value="' . $server->server_id . '" ' . (($instance['server_id'] == $server->server_id) ? 'selected' : '') . '>' . $server->server_identifier . '</option>';
                }
                ?>
            </select>
        </p>

        <?php
    }


    /* The update function */
    function update($new_instance, $old_instance) {

        return array_map('esc_attr', $new_instance);

    }


    /* Displaying the widget */
    function widget($args, $instance) {
        global $wpdb, $table_name_table_pteroq, $plugin_path_pteroq_server;
        extract($args);

        include $plugin_path_pteroq_server . 'public/templates/widget.php';
    }
}

/* Register the widget */
add_action('widgets_init', function () {
    register_widget('sthomas_game_server_status');
});