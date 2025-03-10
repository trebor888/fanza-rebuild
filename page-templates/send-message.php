<?php
/**
 * Template Name: Send Message
**/



if (! is_user_logged_in()) {
    wp_redirect(fanzalive_login_page_url());
    exit;
}


$updated = isset($_REQUEST['updated']) ? true : false;
$form_error = '';
$user_id=get_current_user_id();
$userdata = get_userdata(get_current_user_id());

//update_user_meta( '115', 'user_message', '');
if (isset($_POST['action']) && 'fanzalive_user_message' == $_POST['action']) {
    $data = stripslashes_deep($_POST);
    unset($data['action']);
    $author_id =  $_REQUEST['message_user_name'];
    $message_data = get_user_meta( $author_id, 'user_message', true );
    if(isset($message_data) && !empty($message_data) && count($message_data) > 0){
        $user_mess_text = $_REQUEST['user_message'];
        //$user_mess = array('id' => $user_id,'mess' => $user_mess_text);    
        $user_mess = array('mess' => $user_mess_text);    
        $next_key = count($message_data[$author_id][$user_id]);
        //$message_data[$author_id][$next_key] = $user_mess;
        $message_data[$author_id][$user_id][$next_key] = $user_mess;
    }else{
        $message_data = array();
        $user_mess_text = $_REQUEST['user_message'];
        //$message_data[$author_id][] = array('id' => $user_id,'mess' => $user_mess_text);    
        $message_data[$author_id][$user_id][] = array('mess' => $user_mess_text);    
    }    
    update_user_meta( $author_id, 'user_message', $message_data);    
    $msg = '<p class="green">Message sent successfully!</p>';
    
}
/*print_r(get_user_meta($user_id, 'message_user_id', true));
print_r(get_user_meta($user_id, 'user_message', true));
*/
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
            <section><?php

            the_content();

            if ($updated) { ?>
                <p>Profile updated.</p>
            <?php } ?>
            <?php if (! empty($form_error)) { ?>
                <p style="color:red;"><?php echo $form_error; ?></p>
            <?php } ?>
            <form method="post" class="fanzalive-form profile-edit-form" enctype="multipart/form-data">

            <fieldset>
                <legend>Message</legend>
                <div class="form-field">
                    <div class="form-group">
                        <span class="field-label">Reporter</span>
                        <select name="message_user_name">
                        <?php
                            $blogusers = get_users( );
                              foreach ( $blogusers as $user ) {
                              echo '<option value="'.esc_html( $user->id ).'">' . esc_html( $user->display_name ) . '</option>';
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <div class="form-field">
                    <div class="form-group">
                        <span class="field-label">Message</span>
                        <textarea type="text" name="user_message" id="user_message"></textarea>
                    </div>
                </div>
                </fieldset>

                <?= $msg; ?>
                <div class="form-field field-submit">
                    <input type="submit" id="submit" value="Send Message" />
                    <input type="hidden" name="action" value="fanzalive_user_message" />
                </div>
            </form>
            </section>
        </div><?php
        endwhile;
    endif; ?>
    </div>
</div>

<?php get_footer(); ?>
