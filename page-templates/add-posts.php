<?php
/**
 * Template Name: Add Posts
**/

if (! is_user_logged_in()) {
    wp_redirect(fanzalive_login_page_url());
    exit;
}

$updated = isset($_REQUEST['updated']) ? true : false;
$form_error = '';
$user_id=get_current_user_id();
$userdata = get_userdata(get_current_user_id());


if (isset($_POST['action']) && 'fanzalive_add_posts' == $_POST['action']) {
    $data = stripslashes_deep($_POST);
    unset($data['action']);
    $team = $_REQUEST['teams'];

    $upload = wp_upload_bits($_FILES["post_thumbnail"]["name"], null, file_get_contents($_FILES["post_thumbnail"]["tmp_name"]));

    $post_id = $posts; //set post id to which you need to set post thumbnail
    $filename = $upload['file'];

    $wp_filetype = wp_check_filetype($filename, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $filename, $posts );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $filename );

    wp_update_attachment_metadata( $attach_id, $attach_data );

    $id = wp_insert_post(array(
       'post_type' => 'post',
        'post_title' => $_REQUEST['post_title'],
        'post_content' => $_REQUEST['post_description'],
        'post_author' => $user_id,
        'post_status' => 'publish'
    ));

    if($id) {
        set_post_thumbnail( $id, $attach_id );
        update_post_meta($id, 'reporter_team', $team);
        $msg = '<p class="green">Post added successfully!</p>';
    }
    
}


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
                <legend>Add Posts</legend>
                <div class="form-field field-teams">
                    <div class="form-group">
                        <span class="field-label">Post Title</span>
                        <input type="text" name="post_title" id="post_title" required/>
                    </div>
                    <div class="form-group">
                        <span class="field-label">Post Image</span>
                        <input type="file" name="post_thumbnail" id="post_thumbnail" accept="image/*" required />
                    </div>
                    <div class="form-group">
                <div class="form-field field-teams">
                    <span class="field-label">Select teams you want to report for?</span>
                    <div class="tab-content-wrap tab-all"><?php
                        $leagues = get_terms([
                            'taxonomy'  => 'sp_league',
                            'orderby'   => 'meta_value_num',
                            'meta_key'  => 'sp_order',
                            'hide_empty'=> false
                        ]);
                        ?><select class="tabs-dropdown" data-target="#leagues-content" required><?php
                        foreach ($leagues as $league) {
                            printf(
                                '<option value="#league-%d">%s</option>',
                                $league->term_id,
                                $league->name
                            );
                        }
                        ?></select>
                        <div id="leagues-content"><?php
                            $active = false;
                            foreach ($leagues as $league) {
                                ?><div id="league-<?php echo $league->term_id; ?>" class="tab-content<?php if (! $active) {$active=true; echo ' active';} ?>">
                                    <div class="field-input-wrap">
                                    <?php
                                    $teams = get_posts([
                                        'post_type' => 'sp_team',
                                        'posts_per_page' => -1,
                                        'tax_query' => [
                                            [
                                                'taxonomy' => 'sp_league',
                                                'terms' => $league->term_id
                                            ]
                                        ]
                                    ]);
                                    foreach ($teams as $team) {
                                        printf(
                                            '<label><input type="checkbox" name="teams[]" value="%d"%s /> %s</label>',
                                            $team->ID,
                                            ! empty($data['teams']) && in_array($team->ID, $data['teams']) ? ' checked="checked"' : '',
                                            $team->post_title
                                        );
                                    }
                                    ?></div>
                                </div><?php
                                }
                            ?></div>
                        </div>
                    </div>
                    </div>
                    <div class="form-group">
                        <span class="field-label">Post Description</span>
                        <textarea type="text" name="post_description" id="post_description"></textarea>
                    </div>
                </div>
                </fieldset>

                <?= $msg; ?>
                <div class="form-field field-submit">
                    <input type="submit" id="submit" value="Update" />
                    <input type="hidden" name="action" value="fanzalive_add_posts" />
                </div>
            </form>
            </section>
        </div><?php
        endwhile;
    endif; ?>
    </div>
    <?php   
        $args = array(  
            'post_type' => 'post',
            'posts_per_page' => $post_per_pge, 
            'author' =>  $user_id,
        );

        $loop = new WP_Query( $args );
        while ( $loop->have_posts() ) : $loop->the_post();
            $author_teams = get_post_meta(get_the_ID(), 'reporter_team', true);
        ?>
            <div class="news-section">
                <div class="news-img">
                    <a href="<?= get_the_permalink($author_teams[0]); ?>">
                        <img src="<?= get_the_post_thumbnail_url($post->ID); ?>" />
                    </a>
                </div>
                <div class="news-details">
                    <h1><a href="<?= get_the_permalink(); ?>"><?= get_the_title(); ?></a></h1>
                    <p><?php echo get_the_date('F j, Y');?></p>
                </div>
                <div class="news-action">
                    <a href="<?= site_url()?>/edit-post/?action=<?= get_the_ID();?>" id="edit_news" >Edit</a>
                    <a href="javascript:void(0)" id="delete_news" data-id="<?= get_the_ID(); ?>">Delete</a>
                </div>
            </div>
             
        <?php  endwhile;

        wp_reset_postdata();
    ?> 
</div>

<?php get_footer(); ?>
