<?php
$event_id   = $comment->comment_post_ID;
$score      = get_comment_meta($comment->comment_ID, 'score', true);
$team       = get_comment_meta($comment->comment_ID, 'team', true);
$image_id   = get_comment_meta($comment->comment_ID, 'image_id', true);
$time       = get_comment_meta($comment->comment_ID, 'time', true);

$league = '';
if ($leagues = wp_get_object_terms($event_id, 'sp_league')) {
    $league = array_shift($leagues);
}
$reporter_id = fanzalive_get_event_reporter_id($event_id, $team);


$user_photo = get_user_meta($comment->user_id, 'user_photo', true);
if ($user_photo) {
    $img = wp_get_attachment_image_src($user_photo, 'thumbnail');
    $url = $img[0];
} else {
    $url = "https://www.fanzalive.co.uk/wp-content/uploads/profile-default.png";
}


$ads_comment = get_option('hlp_ads_after_comment_box', true);
?>
    <div id="commentary-<?php echo $comment->comment_ID; ?>" class="event-commentary commentary-team-<?php echo $team; ?> commentary-type-<?php echo $comment->comment_type; ?>">

        <a style="text-decoration: none;" href="<?php echo get_author_posts_url($comment->user_id);?>">
            <img class="avatar" style="float:left; width:40px; border-radius:50%; margin-right:20px " src="<?php echo $url;?>" />

            <?php if (! empty($time)): ?>
                <div class="event-time"><?php echo $time; ?>"</div>
            <?php endif; ?>

            <div class="comment-author-wrap">
                <div class="comment-author" style="color:#c10303; font-size: 20px; text-transform: capitalize; font-weight: bold"><?php echo get_comment_author( $comment->comment_ID ); ?></div>
                <div class="comment-time"><?php echo mysql2date('H:i a', $comment->comment_date); ?></div>
            </div>
        </a>

        <a class="event-link" href="<?php echo add_query_arg('team', $team, get_permalink($event_id)); ?>#commentary-<?php echo $comment->comment_ID; ?>">

            <?php if (isset($league->name)): ?>
            <!--<div class="event-league"><?php echo $league->name; ?></div>-->
            <?php endif; ?>

            <div class="comment-scores"><?php
                $home_team_id = fanzalive_get_event_team_id($event_id, 'home');
                $away_team_id = fanzalive_get_event_team_id($event_id, 'away');

                ?><span class="team-wrap home-team-wrap">
                    <span class="team-name" <?=($team == 'home') ? 'style="color:#000;"' : 'style="color:#999;"' ;?>><?php echo fanzalive_get_event_team_name($event_id, 'home'); ?></span>
                    <span class="team-score" <?=($team == 'home') ? 'style="color:#000;"' : 'style="color:#999;"' ;?>><?php echo isset($score[$home_team_id]) ? (int) $score[$home_team_id]['goals'] : 0; ?></span>
                </span>
                <span class="team-sep">:</span>
                <span class="team-wrap away-team-wrap">
                    <span class="team-name" <?=($team == 'away') ? 'style="color:#000;"' : 'style="color:#999;"' ;?>style="color:#999"><?php echo fanzalive_get_event_team_name($event_id, 'away'); ?></span>
                    <span class="team-score" <?=($team == 'away') ? 'style="color:#000;"' : 'style="color:#999;"' ;?>><?php echo isset($score[$away_team_id]) ? (int) $score[$away_team_id]['goals'] : 0; ?></span>
                </span>
            </div>

            <?php if ('updates' !== $comment->comment_type) :
                ?><div class="comment-heading"><?php echo fanzalive_get_commentary_type_label($comment->comment_type); ?></div><?php
            endif; ?>

            <div class="comment-content"><?php echo word_limiter( apply_filters('comment_text', $comment->comment_content, $comment),15); ?></div>
            <?php if (! empty($image_id)) : ?>
                <div class="comment-images"><?php
                    echo wp_get_attachment_image($image_id, 'large');
                ?></div>
            <?php endif;?>
                <div class="comment-images">
                 <?php if($comment->comment_type=='gamestarted'){?>
                    <img src="https://www.fanzalive.co.uk/wp-content/uploads/live-sm-v1.png" alt="">
                 <?php }?>
                  <?php if($comment->comment_type=='goal'){?>
                    <img src="https://www.fanzalive.co.uk/wp-content/uploads/goal-net-2.png" alt="">
                 <?php }?>
                </div>
        </a>
        <!-- <div class="social_icon_section" style="padding: 20px 15px 0;">
           <?php echo do_shortcode('[Sassy_Social_Share]');?>
        </div> -->
        <div class="social_icon_section" style="padding: 20px 15px 0;">
           <div class="heateor_sss_sharing_container heateor_sss_horizontal_sharing" ss-offset="0" heateor-sss-data-href="https://www.fanzalive.co.uk/tarun/"><ul class="heateor_sss_sharing_ul"><li class="heateorSssSharingRound"><i style="width:28px;height:28px;border-radius:999px;" alt="Facebook" title="Facebook" class="heateorSssSharing heateorSssFacebookBackground" onclick="heateorSssPopup(&quot;https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.fanzalive.co.uk%2Ftarun&quot;)"><ss style="display:block;border-radius:999px;" class="heateorSssSharingSvg heateorSssFacebookSvg"></ss></i></li><li class="heateorSssSharingRound"><i style="width:28px;height:28px;border-radius:999px;" alt="Twitter" title="Twitter" class="heateorSssSharing heateorSssTwitterBackground" onclick="heateorSssPopup(&quot;http://twitter.com/intent/tweet?text=Home&amp;url=https%3A%2F%2Fwww.fanzalive.co.uk%2Ftarun&quot;)"><ss style="display:block;border-radius:999px;" class="heateorSssSharingSvg heateorSssTwitterSvg"></ss></i></li><li class="heateorSssSharingRound"><i style="width:28px;height:28px;border-radius:999px;" alt="Whatsapp" title="Whatsapp" class="heateorSssSharing heateorSssWhatsappBackground"><a href="https://web.whatsapp.com/send?text=Home https%3A%2F%2Fwww.fanzalive.co.uk%2Ftarun" rel="nofollow noopener" target="_blank"><ss style="display:block" class="heateorSssSharingSvg heateorSssWhatsappSvg"></ss></a></i></li></ul><div class="heateorSssClear"></div></div>    
        </div>
    </div>