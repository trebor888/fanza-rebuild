<?php

if(isset($_REQUEST['news_ads_buttn'])) {
    update_option('news_header_top', stripslashes($_REQUEST['news_header_top']));
    update_option('news_header_top_desc', stripslashes($_REQUEST['news_header_top_desc']));

    update_option('news_position_between_tables_tab', stripslashes($_REQUEST['news_position_between_tables_tab']));
    
    update_option('news_header_bottom', stripslashes($_REQUEST['news_header_bottom']));
    update_option('news_header_bottom_desc', stripslashes($_REQUEST['news_header_bottom_desc']));

    update_option('news_right_news_tab', stripslashes($_REQUEST['news_right_news_tab']));
    update_option('news_right_news_tab_desc', stripslashes($_REQUEST['news_right_news_tab_desc'])); 

    update_option('news_after_post_news_tab', stripslashes($_REQUEST['news_after_post_news_tab']));
    update_option('news_after_post_news_tab_desc', stripslashes($_REQUEST['news_after_post_news_tab_desc'])); 

    update_option('news_before_post_news_tab', stripslashes($_REQUEST['news_before_post_news_tab']));
    update_option('news_before_post_news_tab_desc', stripslashes($_REQUEST['news_before_post_news_tab_desc'])); 
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
                        <input type="radio" name="news_header_top" value="Yes" <?= ((get_option('news_header_top') == 'Yes' || get_option('news_header_top') == '' ) ? "checked" : "");?> >Yes
                        <input type="radio" name="news_header_top" value="No" <?= ((get_option('news_header_top') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('news_header_top') == 'No') ? "display:none" : "");?>">
                        	<textarea name="news_header_top_desc"><?= get_option('news_header_top_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Header Bottom advertise</label>
                    </th>
                    <td>
                        <input type="radio" name="news_header_bottom" value="Yes" <?= ((get_option('news_header_bottom') == 'Yes' || get_option('news_header_bottom') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="news_header_bottom" value="No" <?= ((get_option('news_header_bottom') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('news_header_bottom') == 'No') ? "display:none" : "");?>">
                        	<textarea name="news_header_bottom_desc"><?= get_option('news_header_bottom_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Right Side of News in Tab</label>
                    </th>
                    <td>
                        <input type="radio" name="news_right_news_tab" value="Yes" <?= ((get_option('news_right_news_tab') == 'Yes' || get_option('news_right_news_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="news_right_news_tab" value="No" <?= ((get_option('news_right_news_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('news_right_news_tab') == 'No') ? "display:none" : "");?>">
                            <textarea name="news_right_news_tab_desc"><?= get_option('news_right_news_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Set Position of ads Between News Tab</label>
                    </th>
                    <td>
                        <input type="text" name="news_position_between_tables_tab" value="<?= get_option('news_position_between_tables_tab'); ?>" >
                        <span><em>Enter comma(,) seperated value </em></span>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Show ads after posts</label>
                    </th>
                    <td>
                        <input type="radio" name="news_after_post_news_tab" value="Yes" <?= ((get_option('news_after_post_news_tab') == 'Yes' || get_option('news_after_post_news_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="news_after_post_news_tab" value="No" <?= ((get_option('news_after_post_news_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('news_after_post_news_tab') == 'No') ? "display:none" : "");?>">
                            <textarea name="news_after_post_news_tab_desc"><?= get_option('news_after_post_news_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Show ads before posts</label>
                    </th>
                    <td>
                        <input type="radio" name="news_before_post_news_tab" value="Yes" <?= ((get_option('news_before_post_news_tab') == 'Yes' || get_option('news_before_post_news_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="news_before_post_news_tab" value="No" <?= ((get_option('news_before_post_news_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('news_before_post_news_tab') == 'No') ? "display:none" : "");?>">
                            <textarea name="news_before_post_news_tab_desc"><?= get_option('news_before_post_news_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="news_ads_buttn" id="news_ads_buttn" class="button button-primary">
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>