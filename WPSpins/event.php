<?php
/*
Template Name: Event Template
*/
get_header();

$events_query = new WP_Query(array(
    'post_type' => 'event', // Replace 'event' with your actual custom post type slug
    'posts_per_page' => -1 // Retrieve all events
));

if ($events_query->have_posts()) :
    while ($events_query->have_posts()) : $events_query->the_post();
        // Display event information here
        ?>
        <a href="<?php the_permalink(); ?>" ><h2><?php the_title();?></h2></a>
        <?php
        the_content();
        // Add any other event details you want to display
    endwhile;
    wp_reset_postdata(); // Reset post data after the loop
else :
    echo 'No events found.';
endif;


get_footer();
?>

