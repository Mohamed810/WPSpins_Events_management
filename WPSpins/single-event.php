<?php
/*
Template Name: Single Event Template
*/
get_header(); 
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="event-details">
        <h1><?php the_title(); ?></h1>
        <div><?php the_content(); ?></div>
        <button class="popup-button">Popup</button>
    </div>

    
    <div class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <?php
            $current_user;
            if ( is_user_logged_in() ) {
                $current_user = wp_get_current_user();
                echo '<h1>Are you Interested ' . $current_user->user_login . ' ?</h1>';
                ?>
            
            
            <h2><?php the_title(); ?></h2>
            <div><?php the_content(); ?></div>
            
            <form method="post">
                <input type="hidden" name="action" value="handle_form_submission">
                <input type="hidden" name="event_id" value="<?php echo get_the_ID(); ?>"> <!-- hidden input for the event ID -->
                <input type="hidden" name="username" value="<?php echo $current_user->user_login; ?>"> <!-- hidden input for the username -->
                <input type="hidden" name="userID" value="<?php echo $current_user->ID; ?>"> <!-- hidden input for the userID -->
                
                Username: <?php echo $current_user->user_login; ?> 
                <?php
                $username = $current_user->user_login;
                $existing_users = get_post_meta(get_the_ID(), 'interested_users', true);
                if (!empty($username) && is_numeric(get_the_ID())) {
                    $existing_users = $existing_users ? explode(',', $existing_users) : array();
    
                    if (!in_array($username, $existing_users)) {
                        echo '<br><input type="submit" value="I am Interested">';
                    }else{
                        echo ' <br>You Are Interested !';
                    }
                }

                ?>
                
            </form>
            <div id="interested-users" class="interested-users">
                Interested Users: <span id="interested-list" class="interested-list">
                    <?php
                    $interestedUsers = get_post_meta(get_the_ID(), 'interested_users', true);
                    if ($interestedUsers) {
                        $users = explode(',', $interestedUsers);
                        foreach ($users as $user) {
                            echo '<span class="username">' . $user . '</span>, ';
                        }
                    }
                    ?>
                </span>
                <button class="see-more">See More</button>
                <button class="see-less">See Less</button>
            </div>

            
            <?php
            }else {
                echo '<h1>Sign in first <a href="#">Sign in</a> ?</h1>';
            }
            ?>
        </div>
    </div>

<?php endwhile; endif; ?>



<?php get_footer(); ?>
