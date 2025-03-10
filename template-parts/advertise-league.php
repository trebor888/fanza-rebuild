<?php

if(isset($_REQUEST['league_ads_buttn'])) {
    update_option('league_header_top', stripslashes($_REQUEST['league_header_top']));
    update_option('league_header_top_desc', stripslashes($_REQUEST['league_header_top_desc']));

    update_option('league_header_bottom', stripslashes($_REQUEST['league_header_bottom']));
    update_option('league_header_bottom_desc', stripslashes($_REQUEST['league_header_bottom_desc']));

    update_option('league_right_tables_tab', stripslashes($_REQUEST['league_right_tables_tab']));
    update_option('league_right_tables_tab_desc', stripslashes($_REQUEST['league_right_tables_tab_desc'])); 
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
                        <input type="radio" name="league_header_top" value="Yes" <?= ((get_option('league_header_top') == 'Yes' || get_option('league_header_top') == '' ) ? "checked" : "");?> >Yes
                        <input type="radio" name="league_header_top" value="No" <?= ((get_option('league_header_top') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('league_header_top') == 'No') ? "display:none" : "");?>">
                        	<textarea name="league_header_top_desc"><?= get_option('league_header_top_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Header Bottom advertise</label>
                    </th>
                    <td>
                        <input type="radio" name="league_header_bottom" value="Yes" <?= ((get_option('league_header_bottom') == 'Yes' || get_option('league_header_bottom') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="league_header_bottom" value="No" <?= ((get_option('league_header_bottom') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('league_header_bottom') == 'No') ? "display:none" : "");?>">
                        	<textarea name="league_header_bottom_desc"><?= get_option('league_header_bottom_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Right Side of Leagues in Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="league_right_tables_tab" value="Yes" <?= ((get_option('league_right_tables_tab') == 'Yes' || get_option('league_right_tables_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="league_right_tables_tab" value="No" <?= ((get_option('league_right_tables_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('league_right_tables_tab') == 'No') ? "display:none" : "");?>">
                            <textarea name="league_right_tables_tab_desc"><?= get_option('league_right_tables_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="league_ads_buttn" id="league_ads_buttn" class="button button-primary">
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>