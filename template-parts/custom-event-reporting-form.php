<?php
global $match_report_team_side, $event_id;

$reporter_team_side = $match_report_team_side;
$reporter_team_id = fanzalive_get_event_team_id(get_the_ID(), $reporter_team_side);

$reporterTeam = get_post($reporter_team_id);
$results = get_post_meta(get_the_ID(), 'sp_results', true);
$team_results = is_array($results) && isset($results[$reporter_team_id]) ? $results[$reporter_team_id] : [];
$team_results = wp_parse_args($team_results, [
    'firsthalf'     => 0,
    'secondhalf'    => 0,
    'goals'         => 0
]);

if (fanzalive_has_event_ended($event_id, $reporter_team_side)) :
    ?><p><?php _e('Reporting has ended. You had reported for this match.'); ?></p><?php
else :
?>
<p style="margin-bottom:20px font-weight:bold; font-size:20px">You are reporting for <strong><?php echo $reporterTeam->post_title; ?></strong></p>
<?php
$hide_scoring_form = false;
$leagues = wp_get_object_terms($event_id, 'sp_league');
if (! empty($leagues)) {
    $league_id = $leagues[0]->term_id;
    if ('yes' == get_term_meta($league_id, 'hide_scoring_form', true)) {
        $hide_scoring_form = true;
    }
}

?>
<form method="post" class="fanzalive-form fanzalive-team-commentary-form" id="frm-<?php echo $reporter_team_side ?>" enctype="multipart/form-data" action="<?php echo fanzalive_get_event_team_report_url($event_id, $reporter_team_side); ?>">
    <h3>Commentary</h3>
    <div class="form-field custom_radio_button_section">
        <label for="commentary-type" style="color:#333;font-size:20px">Headlines </label>
           <div class="dropp">
            <div class="dropp-header"> <span class="dropp-header__title js-value"></span> <a href="#" class="dropp-header__btn js-dropp-action"><i class="icon"></i></a> </div>
            <div class="dropp-body">
                <label class="custom_radio_label" for="type_blank_<?php echo $reporter_team_side;?>"><input data-value="" class="custom_radio_button" id="type_blank_<?php echo $reporter_team_side;?>" type="radio" name="type" value=""></label><?php
                $types = fanzalive_get_commentary_types();
                if (fanzalive_has_event_started($event_id, $reporter_team_side)) {
                    //unset($types['gamestarted']);
                }
                if (fanzalive_has_event_ended($event_id, $reporter_team_side)) {
                    unset($types['gameended']);
                }

                $j = 0;
                foreach ($types as $k => $v) {
                    if ($v && $k) {
                        printf(
                            '<label class="custom_radio_label" for="'. $reporter_team_side .'_%s">%s <input data-value="%s" class="custom_radio_button" id="'.$reporter_team_side.'_%s" type="radio" name="type" value="%s"></label>',
                            $k, $v, $v, $k, $k
                        );
                    }
                    $j++;
                }
         ?>
  </div>
</div>

  </div>
    <div class="form-field">
<label for="commentary-type" style="color:#333;font-size:20px">Time</label>

        <input type="number" name="time" id="commentary-time" />
    </div>
    <div class="form-field">
        <label for="commentary-type" style="color:#333;font-size:20px">Comment</label>
        <textarea name="comment" id="commentary-comment"></textarea>
    </div>
    <div class="form-submit" style="text-align: right;">
        <input type="submit" value="Submit" />
    </div>
    <input type="hidden" name="id" value="<?php the_ID(); ?>" />
    <input type="hidden" name="team" value="<?php echo $reporter_team_side; ?>" />
    <input type="hidden" name="team_id" value="<?php echo $reporter_team_id; ?>" />
    <input type="hidden" name="action" value="fanzalive_insert_commentary_test_page" />
</form>
<?php endif; ?>
