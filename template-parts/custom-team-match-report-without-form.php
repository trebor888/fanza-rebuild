<?php
global $match_report_team_side, $event_id;

$team = $match_report_team_side;
$current_team_id = fanzalive_get_event_team_id($event_id, $team);

$comments = get_comments([
    'post_id' => $event_id,
    'meta_key' => 'team',
    'meta_value' => $team,
    'user_id' => get_current_user_id()
        ]);
?>

<div class="event-commentaries single-event-commentaries" id="team-comment-<?php echo $team ?>">
<?php
foreach ($comments as $comment) :
$event_id   = $comment->comment_post_ID;
$score      = get_comment_meta($comment->comment_ID, 'score', true);
$team       = get_comment_meta($comment->comment_ID, 'team', true);
$image_id   = get_comment_meta($comment->comment_ID, 'image_id', true);
$time       = get_comment_meta($comment->comment_ID, 'time', true);

$league = '';
if ($leagues = wp_get_object_terms($event_id, 'sp_league')) {
    $league = array_shift($leagues);
}

?><div id="commentary-<?php echo $comment->comment_ID; ?>" class="event-commentary commentary-team-<?php echo $team; ?> commentary-type-<?php echo $comment->comment_type; ?>">
    <a class="event-link" href="<?php echo add_query_arg('team', $team, get_permalink($event_id)); ?>#commentary-<?php echo $comment->comment_ID; ?>"></a>

    <?php if (! empty($time)): ?>
        <div class="event-time"><?php echo $time; ?>"</div>
    <?php endif; ?>

    <div class="comment-author-wrap">
        <div class="comment-author"><?php echo get_comment_author($comment->comment_ID); ?></div>
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
    <?php endif; ?>
<div class="social_icon_section" style="padding: 0px 15px; margin-bottom:25px">
       
        <span style="float: right; text-align: right;padding: 0.2em 0.6em;">
            <a target="_blank"  style="margin-right: 10px;z-index:99999;" href="https://www.facebook.com/fanzalive"><i style="color: #c10303; font-size: 1em" class="fa fa-facebook circle" aria-hidden="true"></i></a>
            <a target="_blank" style="margin-right: 10px;" href="https://twitter.com/Fanzalive1"><i style="color: #c10303; font-size: 1em" class="fa fa-twitter circle" aria-hidden="true"></i></a>
<a target="_blank" href=""><i style="color:green; font-size: 1.5em; padding:0.10em 0.27em 0.30em;" class="fa fa-whatsapp circle" aria-hidden="true"></i></a>
        </span>

    </div>
</div>
<?php    endforeach; ?>
</div>