<?php
// Register Custom Post Type
function league_post_type() {

    $labels = array(
        'name'                => _x( 'Leagues', 'Post Type General Name', 'ryanmasjid' ),
        'singular_name'       => _x( 'League', 'Post Type Singular Name', 'ryanmasjid' ),
        'menu_name'           => __( 'League', 'ryanmasjid' ),
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
        'label'               => __( 'hasan_league', 'ryanmasjid' ),
        'description'         => __( 'League Description', 'ryanmasjid' ),
        'labels'              => $labels,
        'supports'            => array(  'title', 'editor', 'page-attributes'),
        'rewrite'            => array( 'slug' => 'team' ),
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'             => 'dashicons-image-flip-horizontal',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
    );
    register_post_type( 'hasan_league', $args );
    flush_rewrite_rules();

}

// Hook into the 'init' action
add_action( 'init', 'league_post_type', 0 );



function add_league_metaboxes() {
    add_meta_box('league_info', 'Link Information', 'league_info', 'hasan_league', 'normal', 'low');
}
add_action( 'add_meta_boxes', 'add_league_metaboxes' );

// The Event Student Metabox

function league_info() {
    global $post;

    // Noncename needed to verify where the data originated
    echo '<input type="hidden" name="leaguemeta_noncename" id="leaguemeta_noncename" value="' .
        wp_create_nonce( plugin_basename(__FILE__) ) . '" />';

    $league = get_post_meta($post->ID, 'league_url', true);


    ?>
<table>
    <tr>
        <td><strong>Link</strong></td>
        <td> <input style="width: 200px; line-height: 20px" type="text" placeholder="http://example.com" name="league_url" value="<?php echo $league; ?>" class=""/>
        </td>

    </tr>

</table>
<?php

}

// Save the Metabox Data

function league_save_post_meta($post_id, $post) {

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( empty($_POST['leaguemeta_noncename']) || ! wp_verify_nonce( $_POST['leaguemeta_noncename'], plugin_basename(__FILE__) )) {
        return $post->ID;
    }

    // Is the user allowed to edit the post or page?
    if ( !current_user_can( 'edit_post', $post->ID ))
        return $post->ID;

    $league_meta['league_url'] = $_POST['league_url'];

    foreach ($league_meta as $key => $value) { // Cycle through the $events_meta array!
        if( $post->post_type == 'revision' ) return; // Don't store custom data twice
        $value = implode(',', (array)$value); // If $value is an array, make it a CSV (unlikely)
        if(get_post_meta($post->ID, $key, FALSE)) { // If the custom field already has a value
            update_post_meta($post->ID, $key, $value);
        } else { // If the custom field doesn't have a value
            add_post_meta($post->ID, $key, $value);
        }
    }

}

add_action('save_post', 'league_save_post_meta', 1, 2); // save the custom fields
