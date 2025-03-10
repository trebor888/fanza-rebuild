<?php

if(isset($_REQUEST['events_ads_buttn'])) {
	update_option('event_header_top', stripslashes($_REQUEST['event_header_top']));
	update_option('event_header_top_desc', stripslashes($_REQUEST['event_header_top_desc']));

	update_option('event_header_bottom', stripslashes($_REQUEST['event_header_bottom']));
	update_option('event_header_bottom_desc', stripslashes($_REQUEST['event_header_bottom_desc']));

	update_option('event_before_match_report',stripslashes($_REQUEST['event_before_match_report']));

    update_option('event_before_match_report_tab',stripslashes($_REQUEST['event_before_match_report_tab']));
	update_option('event_before_match_report_desc_data', stripslashes($_REQUEST['event_before_match_report_desc_data']));

    update_option('event_after_match_report',stripslashes($_REQUEST['event_after_match_report']));
    update_option('event_after_match_report_desc', stripslashes($_REQUEST['event_after_match_report_desc']));

    update_option('event_bottom_match_report',stripslashes($_REQUEST['event_bottom_match_report']));
    update_option('event_bottom_match_report_desc', stripslashes($_REQUEST['event_bottom_match_report_desc']));

    update_option('event_before_match_report_desc', stripslashes($_REQUEST['event_before_match_report_desc']));

	update_option('event_right_match_report', stripslashes($_REQUEST['event_right_match_report']));
	update_option('event_right_match_report_desc', stripslashes($_REQUEST['event_right_match_report_desc']));

	update_option('event_bottom_table_team', stripslashes($_REQUEST['event_bottom_table_team']));
	update_option('event_bottom_table_team_desc', stripslashes($_REQUEST['event_bottom_table_team_desc']));

    update_option('event_right_table_team', stripslashes($_REQUEST['event_right_table_team']));
    update_option('event_right_table_team_desc', stripslashes($_REQUEST['event_right_table_team_desc']));

	update_option('event_bottom_status_tab', stripslashes($_REQUEST['event_bottom_status_tab']));
	update_option('event_bottom_status_tab_desc',stripslashes($_REQUEST['event_bottom_status_tab_desc']));

    update_option('event_right_status_tab', stripslashes($_REQUEST['event_right_status_tab']));
    update_option('event_right_status_tab_desc', stripslashes($_REQUEST['event_right_status_tab_desc']));

	update_option('event_bottom_lineup_tab', stripslashes($_REQUEST['event_bottom_lineup_tab']));
	update_option('event_bottom_lineup_tab_desc',stripslashes($_REQUEST['event_bottom_lineup_tab_desc']));

    update_option('event_right_lineup_tab', stripslashes($_REQUEST['event_right_lineup_tab']));
    update_option('event_right_lineup_tab_desc', stripslashes($_REQUEST['event_right_lineup_tab_desc']));

	update_option('event_bottom_scores_tab', stripslashes($_REQUEST['event_bottom_scores_tab']));
	update_option('event_bottom_scores_tab_desc',stripslashes($_REQUEST['event_bottom_scores_tab_desc']));

    update_option('event_right_scores_tab', stripslashes($_REQUEST['event_right_scores_tab']));
    update_option('event_right_scores_tab_desc', stripslashes($_REQUEST['event_right_scores_tab_desc']));

	update_option('event_bottom_news_tab', stripslashes($_REQUEST['event_bottom_news_tab']));
	update_option('event_bottom_news_tab_desc',stripslashes($_REQUEST['event_bottom_news_tab_desc']));

	update_option('event_right_news_tab', stripslashes($_REQUEST['event_right_news_tab']));
	update_option('event_right_news_tab_desc',stripslashes($_REQUEST['event_right_news_tab_desc']));
}

?>

<div class="ads-section">
    <form method="post">
        <div class="hlp_advertise_setting">
            <table class="form-table">
                <tr>
                    <th>
                        <label>Header Top advertise</label>
                    </th>
                    <td>
                        <input type="radio" name="event_header_top" value="Yes" <?= ((get_option('event_header_top') == 'Yes' || get_option('event_header_top') == '' ) ? "checked" : "");?> >Yes
                        <input type="radio" name="event_header_top" value="No" <?= ((get_option('event_header_top') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('event_header_top') == 'No') ? "display:none" : "");?>">
                        	<textarea name="event_header_top_desc"><?= get_option('event_header_top_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Header Bottom advertise</label>
                    </th>
                    <td>
                        <input type="radio" name="event_header_bottom" value="Yes" <?= ((get_option('event_header_bottom') == 'Yes' || get_option('event_header_bottom') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="event_header_bottom" value="No" <?= ((get_option('event_header_bottom') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('event_header_bottom') == 'No') ? "display:none" : "");?>">
                        	<textarea name="event_header_bottom_desc"><?= get_option('event_header_bottom_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Bottom of Match Reports</label>
                    </th>
                    <td>
                        <input type="radio" name="event_bottom_match_report" value="Yes" <?= ((get_option('event_bottom_match_report') == 'Yes' || get_option('event_bottom_match_report') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="event_bottom_match_report" value="No" <?= ((get_option('event_bottom_match_report') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('event_bottom_match_report') == 'No') ? "display:none" : "");?>">
                            <textarea name="event_bottom_match_report_desc"><?= get_option('event_bottom_match_report_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Display ads before Match Report</label>
                    </th>
                    <td>
                    	<input type="text" name="event_before_match_report_desc" value="<?= get_option('event_before_match_report_desc');?>"/>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Before Match Reports</label>
                    </th>
                    <td>
                        <input type="radio" name="event_before_match_report_tab" value="Yes" <?= ((get_option('event_before_match_report_tab') == 'Yes' || get_option('event_before_match_report_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="event_before_match_report_tab" value="No" <?= ((get_option('event_before_match_report_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('event_before_match_report_tab') == 'No') ? "display:none" : "");?>">
                            <textarea name="event_before_match_report_desc_data"><?= get_option('event_before_match_report_desc_data');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>After Match Reports</label>
                    </th>
                    <td>
                        <input type="radio" name="event_after_match_report" value="Yes" <?= ((get_option('event_after_match_report') == 'Yes' || get_option('event_after_match_report') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="event_after_match_report" value="No" <?= ((get_option('event_after_match_report') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('event_after_match_report') == 'No') ? "display:none" : "");?>">
                            <textarea name="event_after_match_report_desc"><?= get_option('event_after_match_report_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Right Side of Match Reports</label>
                    </th>
                    <td>
                        <input type="radio" name="event_right_match_report" value="Yes" <?= ((get_option('event_right_match_report') == 'Yes' || get_option('event_right_match_report') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="event_right_match_report" value="No" <?= ((get_option('event_right_match_report') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('event_right_match_report') == 'No') ? "display:none" : "");?>">
                        	<textarea name="event_right_match_report_desc"><?= get_option('event_right_match_report_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Bottom of Table Team</label>
                    </th>
                    <td>
                        <input type="radio" name="event_bottom_table_team" value="Yes" <?= ((get_option('event_bottom_table_team') == 'Yes' || get_option('event_bottom_table_team') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="event_bottom_table_team" value="No" <?= ((get_option('event_bottom_table_team') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('event_bottom_table_team') == 'No') ? "display:none" : "");?>">
                        	<textarea name="event_bottom_table_team_desc"><?= get_option('event_bottom_table_team_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Right Side of Table Team</label>
                    </th>
                    <td>
                        <input type="radio" name="event_right_table_team" value="Yes" <?= ((get_option('event_right_table_team') == 'Yes' || get_option('event_right_table_team') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="event_right_table_team" value="No" <?= ((get_option('event_right_table_team') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('event_right_table_team') == 'No') ? "display:none" : "");?>">
                            <textarea name="event_right_table_team_desc"><?= get_option('event_right_table_team_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Bottom of Status Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="event_bottom_status_tab" value="Yes" <?= ((get_option('event_bottom_status_tab') == 'Yes' || get_option('event_bottom_status_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="event_bottom_status_tab" value="No" <?= ((get_option('event_bottom_status_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('event_bottom_status_tab') == 'No') ? "display:none" : "");?>">
                        	<textarea name="event_bottom_status_tab_desc"><?= get_option('event_bottom_status_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Right side of Status Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="event_right_status_tab" value="Yes" <?= ((get_option('event_right_status_tab') == 'Yes' || get_option('event_right_status_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="event_right_status_tab" value="No" <?= ((get_option('event_right_status_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('event_right_status_tab') == 'No') ? "display:none" : "");?>">
                            <textarea name="event_right_status_tab_desc"><?= get_option('event_right_status_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Bottom of Lineup Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="event_bottom_lineup_tab" value="Yes" <?= ((get_option('event_bottom_lineup_tab') == 'Yes' || get_option('event_bottom_lineup_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="event_bottom_lineup_tab" value="No" <?= ((get_option('event_bottom_lineup_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('event_bottom_lineup_tab') == 'No') ? "display:none" : "");?>">
                        	<textarea name="event_bottom_lineup_tab_desc"><?= get_option('event_bottom_lineup_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Right side of Lineup Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="event_right_lineup_tab" value="Yes" <?= ((get_option('event_right_lineup_tab') == 'Yes' || get_option('event_right_lineup_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="event_right_lineup_tab" value="No" <?= ((get_option('event_right_lineup_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('event_right_lineup_tab') == 'No') ? "display:none" : "");?>">
                            <textarea name="event_right_lineup_tab_desc"><?= get_option('event_right_lineup_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Bottom of Scores Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="event_bottom_scores_tab" value="Yes" <?= ((get_option('event_bottom_scores_tab') == 'Yes' || get_option('event_bottom_scores_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="event_bottom_scores_tab" value="No" <?= ((get_option('event_bottom_scores_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('event_bottom_scores_tab') == 'No') ? "display:none" : "");?>">
                        	<textarea name="event_bottom_scores_tab_desc"><?= get_option('event_bottom_scores_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Right side of Scores Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="event_right_scores_tab" value="Yes" <?= ((get_option('event_right_scores_tab') == 'Yes' || get_option('event_right_scores_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="event_right_scores_tab" value="No" <?= ((get_option('event_right_scores_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('event_right_scores_tab') == 'No') ? "display:none" : "");?>">
                            <textarea name="event_right_scores_tab_desc"><?= get_option('event_right_scores_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Bottom of News Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="event_bottom_news_tab" value="Yes" <?= ((get_option('event_bottom_news_tab') == 'Yes' || get_option('event_bottom_news_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="event_bottom_news_tab" value="No" <?= ((get_option('event_bottom_news_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('event_bottom_news_tab') == 'No') ? "display:none" : "");?>">
                        	<textarea name="event_bottom_news_tab_desc"><?= get_option('event_bottom_news_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Right Side of News Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="event_right_news_tab" value="Yes" <?= ((get_option('event_right_news_tab') == 'Yes' || get_option('event_right_news_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="event_right_news_tab" value="No" <?= ((get_option('event_right_news_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('event_right_news_tab') == 'No') ? "display:none" : "");?>">
                        	<textarea name="event_right_news_tab_desc"><?= get_option('event_right_news_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="events_ads_buttn" id="events_ads_buttn" class="button button-primary">
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>