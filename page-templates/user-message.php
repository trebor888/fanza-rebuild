<?php
/**
 * Template Name: User Message
**/



if (! is_user_logged_in()) {
    wp_redirect(fanzalive_login_page_url());
    exit;
}


$updated = isset($_REQUEST['updated']) ? true : false;
$form_error = '';
$user_id=get_current_user_id();
$userdata = get_userdata(get_current_user_id());

$msgs = get_user_meta( $user_id, 'user_message', true );

?>
<?php get_header(); ?>

<div id="content" class="clearfix">
    <div id="primary" >
    <?php
    if(have_posts()) :
        while(have_posts()) :
        the_post(); ?>

        <div class="entry single">
            <?php if(is_user_logged_in()) { ?>
                <div class="fanza-author-menu author-menu">
                    <ul>
                        <li>
                            <a href="<?php echo home_url('/edit-profile'); ?>">Edit Profile</a>
                        </li>
                        <li>
                            <a href="<?php echo home_url('/edit-team'); ?>">Change Team</a>
                        </li>
                        <li>
                            <a href="<?php echo home_url('/add-posts'); ?>">Post News
                                <?php 
                                    $today = getdate();
                                    $args = array(
                                        'author'        =>  $user_id, 
                                        'orderby'       =>  'post_date',
                                        'order'         =>  'ASC',
                                        'post_type'         =>  'post',
                                        'post_status'         =>  'publish',
                                        'year' => $today['year'],
                                        'monthnum' => $today['mon'], 
                                    );
                                    $the_query = new WP_Query( $args );
                                    if($the_query->post_count>=2) {
                                        echo '<span class="post-count green">'.$the_query->post_count.'</span>'; 
                                    }else{ 
                                        echo '<span class="post-count red">'.$the_query->post_count.'</span>';
                                    }               
                                ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo home_url('/messages'); ?>">Messages</a>
                        </li>
                        <li>
                            <a href="#">Help</a>
                        </li>
                    </ul>
                </div>
            <?php } ?>
            <?php the_title('<h1>', '</h1>'); ?>
            <?php

            the_content();

             ?>
                <div class="user-messages">
                    <?php 
                    if($msgs) {
                     foreach($msgs as $msg){
                        if($msg) {
                        foreach($msg as $key => $ms) {
                            $user = get_userdata($key);
                    ?>
                    <div class="messages-data">
                        <div class="user-img">
                            <h4><?= $userId = $user->data->display_name; ?></h4>
                        </div>
                        <div class="messag">
                            <?php 
                                $num = 1;
                                foreach($ms as $messg) {
                                    foreach($messg as $mess) {
                                        if($mess) {
                                            if($num % 2 == 0){ 
                                                echo '<div class="msg even">'.$mess. '</div>';
                                            }else {
                                                echo '<div class="msg odd">'.$mess. '</div>';
                                            }
                                        $num++;   
                                        }
                                    }
                                }
                            ?>
                        </div>
                    </div>
                <?php } } } } else { echo '<p>No Message Found.</p>';} ?>
                </div>
        </div><?php
        endwhile;
    endif; ?>
    </div>
</div>

<?php get_footer(); ?>
