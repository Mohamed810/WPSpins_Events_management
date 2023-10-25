<?php

function enqueue_custom_styles() {
    wp_enqueue_style('custom-style', get_template_directory_uri().'/style.css');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_styles');




function handle_interest_form() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'handle_form_submission') {
        // Check if both event ID and username are set
        if (isset($_POST['event_id']) && isset($_POST['username'])) {
            $event_id = $_POST['event_id'];
            $username = $_POST['username'];
            $userId = $_POST['userID'];

            $user_id = $userId; 
            $meta_key = 'interested_count'; 
            $meta_value = 0;
            $old_meta_value = get_user_meta( $user_id, $meta_key, true );

            if ( ! isset( $old_meta_value ) ) {
                    // Meta key doesn't exist, add it
                add_user_meta( $user_id, $meta_key, $meta_value );
            }
            if($old_meta_value != null){
                $new_meta_value = $old_meta_value + 1;
            }else{
                $new_meta_value = 1;
            }

            update_user_meta($user_id, $meta_key, $new_meta_value);
            

            $existing_users = get_post_meta($event_id, 'interested_users', true);

            if (!empty($username) && is_numeric($event_id)) {
                $existing_users = $existing_users ? explode(',', $existing_users) : array();

                if (!in_array($username, $existing_users)) {
                    $existing_users[] = $username;
                    $new_data = implode(',', $existing_users);
                    update_post_meta($event_id, 'interested_users', $new_data);
                }
            }

            // Redirect back to the event page or another appropriate page
            wp_redirect(get_permalink($event_id));
            exit();
        }
    }
}
add_action('init','handle_interest_form');

?>



