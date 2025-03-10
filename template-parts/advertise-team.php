<?php

if(isset($_REQUEST['team_ads_buttn'])) {
	update_option('team_header_top', stripslashes($_REQUEST['team_header_top']));
	update_option('team_header_top_desc', stripslashes($_REQUEST['team_header_top_desc']));

	update_option('team_header_bottom', stripslashes($_REQUEST['team_header_bottom']));
	update_option('team_header_bottom_desc', stripslashes($_REQUEST['team_header_bottom_desc']));

	update_option('team_bottom_news_tab', stripslashes($_REQUEST['team_bottom_news_tab']));
	update_option('team_bottom_news_tab_desc', stripslashes($_REQUEST['team_bottom_news_tab_desc']));

	update_option('team_right_news_tab', stripslashes($_REQUEST['team_right_news_tab']));
	update_option('team_right_news_tab_desc', stripslashes($_REQUEST['team_right_news_tab_desc']));
    
    update_option('team_between_news_tab', stripslashes($_REQUEST['team_between_news_tab']));
    update_option('team_between_news_tab_desc', stripslashes($_REQUEST['team_between_news_tab_desc']));

	update_option('team_bottom_fixture_tab', stripslashes($_REQUEST['team_bottom_fixture_tab']));
	update_option('team_bottom_fixture_tab_desc',stripslashes($_REQUEST['team_bottom_fixture_tab_desc']));

	update_option('team_right_fixture_tab', stripslashes($_REQUEST['team_right_fixture_tab']));
	update_option('team_right_fixture_tab_desc',stripslashes($_REQUEST['team_right_fixture_tab_desc']));

	update_option('team_bottom_result_tab', stripslashes($_REQUEST['team_bottom_result_tab']));
	update_option('team_bottom_result_tab_desc',stripslashes($_REQUEST['team_bottom_result_tab_desc']));

	update_option('team_right_result_tab', stripslashes($_REQUEST['team_right_result_tab']));
	update_option('team_right_result_tab_desc',stripslashes($_REQUEST['team_right_result_tab_desc']));

	update_option('team_bottom_tables_tab', stripslashes($_REQUEST['team_bottom_tables_tab']));
	update_option('team_bottom_tables_tab_desc',stripslashes($_REQUEST['team_bottom_tables_tab_desc']));
	
	update_option('team_right_tables_tab', stripslashes($_REQUEST['team_right_tables_tab']));
	update_option('team_right_tables_tab_desc',stripslashes($_REQUEST['team_right_tables_tab_desc']));

    update_option('team_bottom_reporter_tab', stripslashes($_REQUEST['team_bottom_reporter_tab']));
    update_option('team_bottom_reporter_tab_desc',stripslashes($_REQUEST['team_bottom_reporter_tab_desc']));

    update_option('team_right_reporter_tab', stripslashes($_REQUEST['team_right_reporter_tab']));
    update_option('team_right_reporter_tab_desc',stripslashes($_REQUEST['team_right_reporter_tab_desc']));
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
                        <input type="radio" name="team_header_top" value="Yes" <?= ((get_option('team_header_top') == 'Yes' || get_option('team_header_top') == '' ) ? "checked" : "");?> >Yes
                        <input type="radio" name="team_header_top" value="No" <?= ((get_option('team_header_top') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('team_header_top') == 'No') ? "display:none" : "");?>">
                        	<textarea name="team_header_top_desc"><?= get_option('team_header_top_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Header Bottom advertise</label>
                    </th>
                    <td>
                        <input type="radio" name="team_header_bottom" value="Yes" <?= ((get_option('team_header_bottom') == 'Yes' || get_option('team_header_bottom') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="team_header_bottom" value="No" <?= ((get_option('team_header_bottom') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('team_header_bottom') == 'No') ? "display:none" : "");?>">
                        	<textarea name="team_header_bottom_desc"><?= get_option('team_header_bottom_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Bottom of News Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="team_bottom_news_tab" value="Yes" <?= ((get_option('team_bottom_news_tab') == 'Yes' || get_option('team_bottom_news_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="team_bottom_news_tab" value="No" <?= ((get_option('team_bottom_news_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('team_bottom_news_tab') == 'No') ? "display:none" : "");?>">
                            <textarea name="team_bottom_news_tab_desc"><?= get_option('team_bottom_news_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Right Side of News Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="team_right_news_tab" value="Yes" <?= ((get_option('team_right_news_tab') == 'Yes' || get_option('team_right_news_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="team_right_news_tab" value="No" <?= ((get_option('team_right_news_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('team_right_news_tab') == 'No') ? "display:none" : "");?>">
                            <textarea name="team_right_news_tab_desc"><?= get_option('team_right_news_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Between of News Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="team_between_news_tab" value="Yes" <?= ((get_option('team_between_news_tab') == 'Yes' || get_option('team_between_news_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="team_between_news_tab" value="No" <?= ((get_option('team_between_news_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('team_between_news_tab') == 'No') ? "display:none" : "");?>">
                            <textarea name="team_between_news_tab_desc"><?= get_option('team_between_news_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Bottom of Fixture Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="team_bottom_fixture_tab" value="Yes" <?= ((get_option('team_bottom_fixture_tab') == 'Yes' || get_option('team_bottom_fixture_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="team_bottom_fixture_tab" value="No" <?= ((get_option('team_bottom_fixture_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('team_bottom_fixture_tab') == 'No') ? "display:none" : "");?>">
                        	<textarea name="team_bottom_fixture_tab_desc"><?= get_option('team_bottom_fixture_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Right Side of Fixture Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="team_right_fixture_tab" value="Yes" <?= ((get_option('team_right_fixture_tab') == 'Yes' || get_option('team_right_fixture_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="team_right_fixture_tab" value="No" <?= ((get_option('team_right_fixture_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('team_right_fixture_tab') == 'No') ? "display:none" : "");?>">
                            <textarea name="team_right_fixture_tab_desc"><?= get_option('team_right_fixture_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Bottom of Result Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="team_bottom_result_tab" value="Yes" <?= ((get_option('team_bottom_result_tab') == 'Yes' || get_option('team_bottom_result_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="team_bottom_result_tab" value="No" <?= ((get_option('team_bottom_result_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('team_bottom_result_tab') == 'No') ? "display:none" : "");?>">
                        	<textarea name="team_bottom_result_tab_desc"><?= get_option('team_bottom_result_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Right Side of Result Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="team_right_result_tab" value="Yes" <?= ((get_option('team_right_result_tab') == 'Yes' || get_option('team_right_result_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="team_right_result_tab" value="No" <?= ((get_option('team_right_result_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('team_right_result_tab') == 'No') ? "display:none" : "");?>">
                            <textarea name="team_right_result_tab_desc"><?= get_option('team_right_result_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Bottom of Tables Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="team_bottom_tables_tab" value="Yes" <?= ((get_option('team_bottom_tables_tab') == 'Yes' || get_option('team_bottom_tables_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="team_bottom_tables_tab" value="No" <?= ((get_option('team_bottom_tables_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('team_bottom_tables_tab') == 'No') ? "display:none" : "");?>">
                        	<textarea name="team_bottom_tables_tab_desc"><?= get_option('team_bottom_tables_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Right Side of Tables Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="team_right_tables_tab" value="Yes" <?= ((get_option('team_right_tables_tab') == 'Yes' || get_option('team_right_tables_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="team_right_tables_tab" value="No" <?= ((get_option('team_right_tables_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('team_right_tables_tab') == 'No') ? "display:none" : "");?>">
                            <textarea name="team_right_tables_tab_desc"><?= get_option('team_right_tables_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Bottom of Reporter Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="team_bottom_reporter_tab" value="Yes" <?= ((get_option('team_bottom_reporter_tab') == 'Yes' || get_option('team_bottom_reporter_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="team_bottom_reporter_tab" value="No" <?= ((get_option('team_bottom_reporter_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('team_bottom_reporter_tab') == 'No') ? "display:none" : "");?>">
                            <textarea name="team_bottom_reporter_tab_desc"><?= get_option('team_bottom_reporter_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Right Side of Reporter Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="team_right_reporter_tab" value="Yes" <?= ((get_option('team_right_reporter_tab') == 'Yes' || get_option('team_right_reporter_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="team_right_reporter_tab" value="No" <?= ((get_option('team_right_reporter_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('team_right_reporter_tab') == 'No') ? "display:none" : "");?>">
                            <textarea name="team_right_reporter_tab_desc"><?= get_option('team_right_reporter_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="team_ads_buttn" id="team_ads_buttn" class="button button-primary">
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>