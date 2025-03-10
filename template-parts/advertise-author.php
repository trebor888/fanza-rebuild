<?php

if(isset($_REQUEST['author_ads_buttn'])) {

    update_option('author_header_bottom', stripslashes($_REQUEST['author_header_bottom']));
    update_option('author_header_bottom_desc', stripslashes($_REQUEST['author_header_bottom_desc']));
    
    update_option('author_after_post_author_tab', stripslashes($_REQUEST['author_after_post_author_tab']));
    update_option('author_after_post_author_tab_desc', stripslashes($_REQUEST['author_after_post_author_tab_desc'])); 
}

?>

<div class="ads-section">
    <form method="post">
        <div class="hlp_advertise_setting">
            <table class="form-table">
                <tr>
                    <th>
                        <label>Header Bottom advertise</label>
                    </th>
                    <td>
                        <input type="radio" name="author_header_bottom" value="Yes" <?= ((get_option('author_header_bottom') == 'Yes' || get_option('author_header_bottom') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="author_header_bottom" value="No" <?= ((get_option('author_header_bottom') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('author_header_bottom') == 'No') ? "display:none" : "");?>">
                            <textarea name="author_header_bottom_desc"><?= get_option('author_header_bottom_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label>Show ads after posts</label>
                    </th>
                    <td>
                        <input type="radio" name="author_after_post_author_tab" value="Yes" <?= ((get_option('author_after_post_author_tab') == 'Yes' || get_option('author_after_post_author_tab') == '' ) ? "checked" : "");?>>Yes
                        <input type="radio" name="author_after_post_author_tab" value="No" <?= ((get_option('author_after_post_author_tab') == 'No') ? "checked" : "");?>>No

                        <div class="advertis" style="<?= ((get_option('author_after_post_author_tab') == 'No') ? "display:none" : "");?>">
                            <textarea name="author_after_post_author_tab_desc"><?= get_option('author_after_post_author_tab_desc');?></textarea>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="author_ads_buttn" id="author_ads_buttn" class="button button-primary">
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>