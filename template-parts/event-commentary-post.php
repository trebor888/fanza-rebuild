<?php
$i = '1';
foreach ($comments as $comment) :
$event_id   = $comment->comment_post_ID;
$score      = get_comment_meta($comment->comment_ID, 'score', true);
$team       = get_comment_meta($comment->comment_ID, 'team', true);
$image_id   = get_comment_meta($comment->comment_ID, 'image_id', true);
$time       = get_comment_meta($comment->comment_ID, 'time', true);
$commentaryPlayer = get_comment_meta($comment->comment_ID, 'commentary_player', true);


$league = '';
if ($leagues = wp_get_object_terms($event_id, 'sp_league')) {
    $league = array_shift($leagues);
}

if(get_field('display_ads_before_match_report', $event_id)) {
    $comment_before = get_field('display_ads_before_match_report', $event_id);
}else {
    if(get_option('event_before_match_report_desc', true)){
       $comment_before = get_option('event_before_match_report_desc', true);
    }
}

?>
    <?php do_action( 'sportspress_event_comment_after', $comment ); ?>
    <?php
    if($i == $comment_before) {
        if(get_field('before_match_reports', $event_id) == 'Yes' || get_field('before_match_reports', $event_id) == '') {
            if(get_field('before_match_reports_content', $event_id)) {
                echo get_field('before_match_reports_content', $event_id);
            }else {
                if(get_option('event_before_match_report_tab', true) == 'Yes'){
                    if(get_option('event_before_match_report_desc_data', true)) {
                        echo get_option('event_before_match_report_desc_data', true);
                    }
                }
            } 
        }  
    if($comment->comment_content != '') {
    ?>
    <div id="commentary-<?php echo $comment->comment_ID; ?>" class="event-commentary commentary-team-<?php echo $team; ?> commentary-type-<?php echo $comment->comment_type; ?>">
    <a class="event-link" href="<?php echo add_query_arg('team', $team, get_permalink($event_id)); ?>#commentary-<?php echo $comment->comment_ID; ?>"></a>

    <?php if (! empty($time)): ?>
        <div class="event-time"><?php echo $time; ?>"</div>
    <?php endif; ?>

    <div class="comment-author-wrap">
<!--        <div class="comment-author">--><?php //echo get_user_option('display_name', $comment->user_id); ?><!--</div>-->
        <div class="comment-time"><?php echo mysql2date('H:i a', $comment->comment_date); ?></div>
    </div>

    <?php if (isset($league->name)): ?>
    <!--<div class="event-league"><?php echo $league->name; ?></div>-->
    <?php endif; ?>

    <div class="comment-scores"><?php
        $home_team_id = fanzalive_get_event_team_id($event_id, 'home');
        $away_team_id = fanzalive_get_event_team_id($event_id, 'away');

        ?><span class="team-wrap home-team-wrap">
            <span class="team-name"><?php echo fanzalive_get_event_team_name($event_id, 'home'); ?></span>
            <span class="team-score"><?php echo isset($score[$home_team_id]) ? (int) $score[$home_team_id]['goals'] : 0; ?></span>
        </span>
        <span class="team-sep">:</span>
        <span class="team-wrap away-team-wrap">
            <span class="team-name"><?php echo fanzalive_get_event_team_name($event_id, 'away'); ?></span>
            <span class="team-score"><?php echo isset($score[$away_team_id]) ? (int) $score[$away_team_id]['goals'] : 0; ?></span>
        </span>
    </div>

    <?php if ('updates' !== $comment->comment_type) :
        ?><div class="comment-heading"><?php echo fanzalive_get_commentary_type_label($comment->comment_type); ?></div><?php
    endif; ?>
    <div class="comment-player"><?php echo get_the_title($commentaryPlayer); ?></div>
    
    <div class="comment-content" style="width:100%; margin-top:30px"><?php echo apply_filters('comment_text', $comment->comment_content, $comment); ?>
        <?php //edit_comment_link( __( 'Edit Comment', 'textdomain' ), '<p>', '</p>' ); ?>

      <?php 
if(is_user_logged_in()){
if($comment->user_id ==get_current_user_id()){
printf(
    '<a href="%s">%s</a>',
    wp_nonce_url(
        admin_url( "comment.php?c=$comment->comment_ID&action=deletecomment" ),
        'delete-comment_' . $comment->comment_ID
    ),
    esc_html__( 'Delete comment', 'textdomain' )
);
}
}
?>

    </div>
    <?php if (! empty($image_id)) : ?>
            <div class="comment-images"><?php
                echo wp_get_attachment_image($image_id, 'large');
            ?></div>
        <?php else:?>
            <div class="comment-images">
             <?php if($comment->comment_type=='gamestarted'){?>
                <img src="https://www.fanzalive.co.uk/wp-content/uploads/live-sm-v1.png" alt="Live reporting">
             <?php }?>
              <?php if($comment->comment_type=='goal'){?>
                <img src="https://www.fanzalive.co.uk/wp-content/uploads/goal-net-2.png" alt="Goal">
             <?php }?>
            </div>
        <?php endif; ?>
    <!-- <div class="social_icon_section" style="padding: 20px 15px 0;">
        <?php echo do_shortcode('[Sassy_Social_Share]');?>
    </div> -->
    <div class="social_icon_section" style="padding: 20px 15px 0;">
       <div class="heateor_sss_sharing_container heateor_sss_horizontal_sharing" ss-offset="0" heateor-sss-data-href="https://www.fanzalive.co.uk/tarun/"><ul class="heateor_sss_sharing_ul">
        <li class="heateorSssSharingRound">
            <i style="width:28px;height:28px;border-radius:999px;" alt="Facebook" title="Facebook" class="heateorSssSharing heateorSssFacebookBackground" onclick="heateorSssPopup(&quot;https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.fanzalive.co.uk%2Ftarun&quot;)">
                <ss style="display:block;border-radius:999px;" class="heateorSssSharingSvg heateorSssFacebookSvg"></ss>
            </i>
        </li>
        <li class="heateorSssSharingRound">
            <i style="width:28px;height:28px;border-radius:999px;" alt="Twitter" title="Twitter" class="heateorSssSharing heateorSssTwitterBackground" onclick="heateorSssPopup(&quot;http://twitter.com/intent/tweet?text=Home&amp;url=https%3A%2F%2Fwww.fanzalive.co.uk%2Ftarun&quot;)">
               <ss style="display:block;border-radius:999px;" class="heateorSssSharingSvg heateorSssTwitterSvg"></ss>
            </i>
        </li>
        <li class="heateorSssSharingRound">
            <i style="width:28px;height:28px;border-radius:999px;" alt="Whatsapp" title="Message" class="heateorSssSharing heateorSssWhatsappBackground">
                    <?php if(!is_user_logged_in()) { ?>
                            <a href="<?= site_url('/login'); ?>" rel="nofollow noopener" target="_blank">
                                <i class="fa fa-commenting-o"></i> <!--   <ss style="display:block" class="heateorSssSharingSvg heateorSssWhatsappSvg"></ss> -->
                            </a>
                        <?php }else { ?>
                            <a href="<?= get_permalink(); ?>" rel="nofollow noopener">
                                <i class="fa fa-commenting-o"></i> <!--   <ss style="display:block" class="heateorSssSharingSvg heateorSssWhatsappSvg"></ss> -->
                            </a>
                        <?php } ?>
            </i>
        </li>
       </ul>
       <div class="heateorSssClear"></div>
   </div>    
    </div>
</div>
<?php 

if(get_field('after_match_reports', $event_id) == 'Yes' || get_field('after_match_reports', $event_id) == '') {
            if(get_field('after_match_reports_content', $event_id)) {
                echo get_field('after_match_reports_content', $event_id);
            }else {
                if(get_option('event_after_match_report', true) == 'Yes'){
                    if(get_option('event_after_match_report_desc', true)) {
                        echo get_option('event_after_match_report_desc', true);
                    }
                }
            } 
        }  
}
}else { 
    if($comment->comment_content != '' ) {
    ?>
        <div id="commentary-<?php echo $comment->comment_ID; ?>" class="event-commentary commentary-team-<?php echo $team; ?> commentary-type-<?php echo $comment->comment_type; ?>">
        <a class="event-link" href="<?php echo add_query_arg('team', $team, get_permalink($event_id)); ?>#commentary-<?php echo $comment->comment_ID; ?>"></a>

        <?php if (! empty($time)): ?>
            <div class="event-time"><?php echo $time; ?>"</div>
        <?php endif; ?>

        <div class="comment-author-wrap">
    <!--        <div class="comment-author">--><?php //echo get_user_option('display_name', $comment->user_id); ?><!--</div>-->
            <div class="comment-time"><?php echo mysql2date('H:i a', $comment->comment_date); ?></div>
        </div>

        <?php if (isset($league->name)): ?>
        <!--<div class="event-league"><?php echo $league->name; ?></div>-->
        <?php endif; ?>

        <div class="comment-scores"><?php
            $home_team_id = fanzalive_get_event_team_id($event_id, 'home');
            $away_team_id = fanzalive_get_event_team_id($event_id, 'away');

            ?><span class="team-wrap home-team-wrap">
                <span class="team-name"><?php echo fanzalive_get_event_team_name($event_id, 'home'); ?></span>
                <span class="team-score"><?php echo isset($score[$home_team_id]) ? (int) $score[$home_team_id]['goals'] : 0; ?></span>
            </span>
            <span class="team-sep">:</span>
            <span class="team-wrap away-team-wrap">
                <span class="team-name"><?php echo fanzalive_get_event_team_name($event_id, 'away'); ?></span>
                <span class="team-score"><?php echo isset($score[$away_team_id]) ? (int) $score[$away_team_id]['goals'] : 0; ?></span>
            </span>
        </div>

        <?php if ('updates' !== $comment->comment_type) :
            ?><div class="comment-heading"><?php echo fanzalive_get_commentary_type_label($comment->comment_type); ?></div><?php
        endif; ?>
        <div class="comment-player"><?php echo get_the_title($commentaryPlayer); ?></div>
        
        <div class="comment-content" style="width:100%; margin-top:30px"><?php echo apply_filters('comment_text', $comment->comment_content, $comment); ?>
            <?php //edit_comment_link( __( 'Edit Comment', 'textdomain' ), '<p>', '</p>' ); ?>

          <?php 
    if(is_user_logged_in()){
    if($comment->user_id ==get_current_user_id()){
    printf(
        '<a href="%s">%s</a>',
        wp_nonce_url(
            admin_url( "comment.php?c=$comment->comment_ID&action=deletecomment" ),
            'delete-comment_' . $comment->comment_ID
        ),
        esc_html__( 'Delete comment', 'textdomain' )
    );
    }
    }
    ?>

        </div>
        <?php if (! empty($image_id)) : ?>
                <div class="comment-images"><?php
                    echo wp_get_attachment_image($image_id, 'large');
                ?></div>
            <?php else:?>
                <div class="comment-images">
                 <?php if($comment->comment_type=='gamestarted'){?>
                    <img src="https://www.fanzalive.co.uk/wp-content/uploads/live-sm-v1.png" alt="Live reporting">
                 <?php }?>
                  <?php if($comment->comment_type=='goal'){?>
                    <img src="https://www.fanzalive.co.uk/wp-content/uploads/goal-net-2.png" alt="Goal">
                 <?php }?>
                </div>
            <?php endif; ?>
        <!-- <div class="social_icon_section" style="padding: 20px 15px 0;">
            <?php echo do_shortcode('[Sassy_Social_Share]');?>
        </div> -->
        <div class="social_icon_section" style="padding: 20px 15px 0;">
           <div class="heateor_sss_sharing_container heateor_sss_horizontal_sharing" ss-offset="0" heateor-sss-data-href="https://www.fanzalive.co.uk/tarun/"><ul class="heateor_sss_sharing_ul">
            <li class="heateorSssSharingRound">
                <i style="width:28px;height:28px;border-radius:999px;" alt="Facebook" title="Facebook" class="heateorSssSharing heateorSssFacebookBackground" onclick="heateorSssPopup(&quot;https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fwww.fanzalive.co.uk%2Ftarun&quot;)">
                    <ss style="display:block;border-radius:999px;" class="heateorSssSharingSvg heateorSssFacebookSvg"></ss>
                </i>
            </li>
            <li class="heateorSssSharingRound">
                <i style="width:28px;height:28px;border-radius:999px;" alt="Twitter" title="Twitter" class="heateorSssSharing heateorSssTwitterBackground" onclick="heateorSssPopup(&quot;http://twitter.com/intent/tweet?text=Home&amp;url=https%3A%2F%2Fwww.fanzalive.co.uk%2Ftarun&quot;)">
                   <ss style="display:block;border-radius:999px;" class="heateorSssSharingSvg heateorSssTwitterSvg"></ss>
                </i>
            </li>
            <li class="heateorSssSharingRound">
                <i style="width:28px;height:28px;border-radius:999px;" alt="Whatsapp" title="Message" class="heateorSssSharing heateorSssWhatsappBackground">
                        <?php if(!is_user_logged_in()) { ?>
                            <a href="<?= site_url('/login'); ?>" rel="nofollow noopener" target="_blank">
                                <i class="fa fa-commenting-o"></i> <!--   <ss style="display:block" class="heateorSssSharingSvg heateorSssWhatsappSvg"></ss> -->
                            </a>
                        <?php }else { ?>
                            <a href="<?= get_permalink(); ?>" rel="nofollow noopener">
                                <i class="fa fa-commenting-o"></i> <!--   <ss style="display:block" class="heateorSssSharingSvg heateorSssWhatsappSvg"></ss> -->
                            </a>
                        <?php } ?>
                </i>
            </li>
           </ul>
           <div class="heateorSssClear"></div>
       </div>    
        </div>
    </div>
<?php  } }  $i++;  endforeach; ?>