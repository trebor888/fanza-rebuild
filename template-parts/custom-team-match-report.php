<?php
global $match_report_team_side, $event_id;

$team = $match_report_team_side;
$current_team_id = fanzalive_get_event_team_id($event_id, $team);

if (is_user_logged_in()) {

 get_template_part('template-parts/custom-event-reporting-form');
}



//$comments = get_comments([
//    'post_id' => get_the_ID(),
//    'meta_key' => 'team',
//    'meta_value' => $team
//        ]);
?>

<div class="event-commentaries single-event-commentaries" id="team-comment-<?php echo $team ?>">

    <?php
//    foreach ($comments as $comment) :
//        get_template_part('template-parts/event-commentary');
//    endforeach;
    ?></div>
<script>
    jQuery(document).ready(function ($) {
        
        $(document).on('submit', 'form#frm-<?php echo $team; ?>', function (e) {
            e.preventDefault();
            $("#LoadingImage-<?php echo $team ?>").show();
            $form = $(this);
            var formData = new FormData($(this)[0]);
            $.ajax({
                type: 'post',
                url: $form.attr('action'),
                enctype: 'multipart/form-data',
                processData: false,  // Important!
                contentType: false,
                cache: false,
                data: formData,//$form.serialize(),
                success: function () {
                    $.ajax({
                        type: 'GET',
                        dataType: "html",
                        url: '?action=load_comments&team=<?php echo $team; ?>&post_id=<?php echo get_the_ID() ?>',
                        //data: jQuery(this).serialize(),
                        success: function (response) {
                            $('#frm-<?php echo $team; ?>').get(0).reset();
                        }
                    });
                }
            });
        });
    });
</script>