<?php
/**
 * Plugin Name: Events Manager
 * Description: Managing events and tracking user interest.
 * Version: 1.0
 * Author: Mohamed Magdy
 * License: GPL2
*/




function enqueue_interest_script() {
    wp_enqueue_script('interest-script', plugins_url('interest-script.js', __FILE__), array('jquery'), '1.0', true);
}
add_action('wp_enqueue_scripts', 'enqueue_interest_script');


 // Define the custom post type for events
 function create_event_post_type() {
    // set up Event labels
    $labels = array(
        'name' => 'Events',
        'singular_name' => 'event',
        'add_new' => 'Add New Event',
        'add_new_item' => 'Add New Event',
        'edit_item' => 'Edit Event',
        'new_item' => 'New Event',
        'all_items' => 'All Events',
        'view_item' => 'View Event',
        'search_items' => 'Search Events',
        'not_found' =>  'No Events Found',
        'not_found_in_trash' => 'No Events found in Trash', 
        'parent_item_colon' => '',
        'menu_name' => 'Events',
    );
    
    // register post type
    $args = array(
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'Event'),
        'query_var' => true,
        'menu_icon' => 'dashicons-calendar-alt',
        'supports' => array(
            'title',
            'thumbnail',
        )
    );
    register_post_type( 'Event', $args );

}
add_action('init', 'create_event_post_type');



// Add event details metabox
function add_event_details_metabox() {
    add_meta_box('event-details', 'Event Details', 'event_details_metabox_callback', 'event', 'normal', 'high');
}
add_action('add_meta_boxes', 'add_event_details_metabox');

// Metabox callback function
function event_details_metabox_callback($post) {
    $event_date = get_post_meta($post->ID, '_event_date', true);
    $event_location = get_post_meta($post->ID, '_event_location', true);
    $event_description = get_post_meta($post->ID, '_event_description', true);
    $interested_users = get_post_meta($post->ID, '_interested_users', true);

    ?>
    <label for="event-date">Event Date:</label>
    <input type="date" id="event-date" name="event_date" value="<?php echo esc_attr($event_date); ?>"><br><br>

    <label for="event-location">Event Location:</label>
    <input type="text" id="event-location" name="event_location" value="<?php echo esc_attr($event_location); ?>"><br><br>

    <label for="event-description">Event Description:</label><br>
    <textarea id="event-description" name="event_description" cols="30" rows="5"><?php echo esc_textarea($event_description); ?></textarea>
    <?php
}

// Save event details
function save_event_details($post_id) {
    if (isset($_POST['event_date'])) {
        update_post_meta($post_id, '_event_date', sanitize_text_field($_POST['event_date']));
    }

    if (isset($_POST['event_location'])) {
        update_post_meta($post_id, '_event_location', sanitize_text_field($_POST['event_location']));
    }

    if (isset($_POST['event_description'])) {
        update_post_meta($post_id, '_event_description', sanitize_textarea_field($_POST['event_description']));
    }

    if (isset($_POST['interested_users'])) {
        update_post_meta($post_id, '_interested_users', sanitize_textarea_field($_POST['interested_users']));
    }

}
add_action('save_post_event', 'save_event_details');


// Add custom column to Events post type
function add_event_date_column($columns) {
    $columns['event_date'] = 'Event Date';
    return $columns;
}
add_filter('manage_event_posts_columns', 'add_event_date_column');

// Display custom field content in the custom column
function display_event_date_column_content($column, $post_id) {
    if ($column === 'event_date') {
        $event_date = get_post_meta($post_id, '_event_date', true);
        echo $event_date;
    }
}
add_action('manage_event_posts_custom_column', 'display_event_date_column_content', 10, 2);




function add_users_meta_key(){
    $meta_key = 'interested_count';
    $meta_value = 0;
    $users = get_users();

    foreach ($users as $user) {
        add_user_meta( $user->ID, $meta_key, $meta_value ); 
    }
    
}
add_action('init','add_users_meta_key');




function export_top_interested_users() {

    $meta_key = 'interested_count'; 
    $user_args = array(
        'meta_key' => $meta_key,
        'number' => 10,
        'orderby' => 'meta_value_num',
        'order' => 'DESC'
    );

    $top_users = get_users($user_args);
    if ($top_users) {
        $data = array();
        foreach ($top_users as $user) {
            $user_meta_value = get_user_meta( $user->ID, $meta_key, true );
            $data[] = array(
                'username' => $user->user_login,
                'email' => $user->user_email,
                'interested_count' => $user_meta_value,
            );
        }
    } else {
        echo 'No users found with the specified meta key.';
    }

    $csv_data = implode(',', array('Username', 'Email', 'Interested Events Count')) . "\n";
    foreach ($data as $row) {
        $csv_data .= implode(',', $row) . "\n";
    }

    $file_path = plugin_dir_path(__FILE__) . 'Events-Top-Interested-users/exported_users.csv';
    file_put_contents($file_path, $csv_data);

    return $file_path;
}

//add_action('init','export_top_interested_users');



// Corn Job
if (!wp_next_scheduled('export_top_interested_users_event')) {
    wp_schedule_event(time(), 'twicedaily', 'export_top_interested_users_event');
}

add_action('export_top_interested_users_event', 'export_top_interested_users');









