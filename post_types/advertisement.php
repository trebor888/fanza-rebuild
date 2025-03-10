<?php
// Register Custom Post Type
function advertisement_post_type() {

    $labels = array(
        'name'                => _x( 'Advertisements', 'Post Type General Name', 'ryanmasjid' ),
        'singular_name'       => _x( 'Advertisement', 'Post Type Singular Name', 'ryanmasjid' ),
        'menu_name'           => __( 'Advertisement', 'ryanmasjid' ),
        'parent_item_colon'   => __( 'Parent Item:', 'ryanmasjid' ),
        'all_items'           => __( 'All Items', 'ryanmasjid' ),
        'view_item'           => __( 'View Item', 'ryanmasjid' ),
        'add_new_item'        => __( 'Add New Item', 'ryanmasjid' ),
        'add_new'             => __( 'Add New', 'ryanmasjid' ),
        'edit_item'           => __( 'Edit Item', 'ryanmasjid' ),
        'update_item'         => __( 'Update Item', 'ryanmasjid' ),
        'search_items'        => __( 'Search Item', 'ryanmasjid' ),
        'not_found'           => __( 'Not found', 'ryanmasjid' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'ryanmasjid' ),
    );
    $args = array(
        'label'               => __( 'fan_advertisement', 'ryanmasjid' ),
        'description'         => __( 'Advertisement Description', 'ryanmasjid' ),
        'labels'              => $labels,
        'supports'            => array(  'title', 'editor', 'page-attributes'),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'             => 'dashicons-universal-access-alt',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
    register_post_type( 'fan_advertisement', $args );

}

// Hook into the 'init' action
add_action( 'init', 'advertisement_post_type', 0 );



function add_advertisement_metaboxes() {
    add_meta_box('advertisement_info', 'Advertisement Information', 'advertisement_info', 'fan_advertisement', 'normal', 'low');
}
add_action( 'add_meta_boxes', 'add_advertisement_metaboxes' );

// The Event Student Metabox

function advertisement_info() {
    global $post;

    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="advertisementmeta_noncename" id="advertisementmeta_noncename" value="' .
        wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

    $advertisement = get_post_meta($post->ID, 'advertisement_url', true);
    $team_id = get_post_meta($post->ID, 'team_id', true);
    $league_id = get_post_meta($post->ID, 'league_id', true);
    $event_id = get_post_meta($post->ID, 'event_id', true);
    $page_id = get_post_meta($post->ID, 'page_id', true);
    $ads_expire_date = get_post_meta($post->ID, 'ads_expire_date', true);
    $adv_position_into_comment = get_post_meta($post->ID, 'adv_position_into_comment', true);


    ?>
<table style="width: 100%">
    <tr>
        <td><strong>Link</strong></td>
        <td>
            <input style="width: 200px; line-height: 20px" type="text" placeholder="http://example.com" name="advertisement_url" value="<?php echo $advertisement; ?>" class=""/>
        </td>
        <td><strong>Expire Date</strong> (Y-m-d)</td>
        <td>
            <input style="width: 200px; line-height: 20px" type="text" placeholder="2020-01-01" name="ads_expire_date" value="<?php echo $ads_expire_date; ?>" class=""/>
        </td>

    </tr>
    <tr>

        <td><strong>Events</strong></td>
        <td>
            <select name="event_id" id="">
                <option value="">Select Event</option>
                <option value="all" <?php echo 'all'==$event_id?'selected="selected"':'';?>>All</option>
                <?php foreach (fanzalive_get_events() as $key=>$item){?>
                    <option value="<?php echo $key?>" <?php echo $key==$event_id?'selected="selected"':'';?>><?php echo $item;?></option>
                <?php }?>
            </select>
        </td>
        <td><strong>Position</strong></td>
        <td>
            <input type="number" min="0" name="adv_position_into_comment" value="<?php echo $adv_position_into_comment?$adv_position_into_comment:'';?>">
        </td>
    </tr>
    <tr>
        <td><strong>Teams</strong></td>
        <td>
            <select name="team_id" id="">
                <option value="">Select Team</option>
                <?php foreach (fanzalive_get_teams() as $key=>$item){?>
                    <option value="<?php echo $key?>" <?php echo $key==$team_id?'selected="selected"':'';?>><?php echo $item;?></option>
                <?php }?>
            </select>
        </td>
        <td><strong>Pages</td>
        <td>
            <?php
            $selected = $page_id?$page_id:'';
            wp_dropdown_pages("selected=$selected&name=page_id&hierarchical=1&show_option_none=Select Page");
            ?>
        </td>

    </tr>
    <tr>
        <td><strong>League</strong></td>
        <td>
            <select name="league_id" id="">
                <option value="">Select League</option>
                <?php foreach (fanzalive_get_leagues() as $key=>$item){?>
                    <option value="<?php echo $key?>" <?php echo $key==$league_id?'selected="selected"':'';?>><?php echo $item;?></option>
                <?php }?>
            </select>
        </td>
        <td></td>
        <td>

        </td>

    </tr>

</table>
<?php

}

// Save the Metabox Data

function advertisement_save_post_meta($post_id, $post) {

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( empty($_POST['advertisementmeta_noncename']) || !wp_verify_nonce( $_POST['advertisementmeta_noncename'], plugin_basename(__FILE__) )) {
        return $post->ID;
    }

    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;

    $advertisement_meta['advertisement_url'] = $_POST['advertisement_url'];
    $advertisement_meta['team_id'] = $_POST['team_id']?$_POST['team_id']:'';
    $advertisement_meta['league_id'] = $_POST['league_id']?$_POST['league_id']:'';
    $advertisement_meta['event_id'] = $_POST['event_id']? $_POST['event_id']:'';
    $advertisement_meta['page_id'] = $_POST['page_id']? $_POST['page_id']:'';
    $advertisement_meta['ads_expire_date'] = $_POST['ads_expire_date'];
    $advertisement_meta['adv_position_into_comment'] = $_POST['adv_position_into_comment'];

    foreach ($advertisement_meta as $key => $value) { // Cycle through the $events_meta array!
        if( $post->post_type == 'revision' ) return; // Don't store custom data twice
        $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
        if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
            update_post_meta($post->ID, $key, $value);
        } else { // If the custom field doesn't have a value
            add_post_meta($post->ID, $key, $value);
        }
    }

}

add_action('save_post', 'advertisement_save_post_meta', 1, 2); // save the custom fields
