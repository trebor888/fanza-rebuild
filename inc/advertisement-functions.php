<?php
add_action( 'sportspress_event_comment_after', 'sportspress_event_comment_after',10,1 );
function sportspress_event_comment_after($arg1){
    $event_id = $arg1->comment_post_ID;

    global $loop_counter;
    $loop_counter++;
    $args = array(
        'post_type'  => 'fan_advertisement',
        'posts_per_page'=>-1,
        'meta_key'   => 'event_id',
        'meta_query' => array(
            array(
                'key'     => 'event_id',
                'value'   => array( $event_id, 'all' ),
                'compare' => 'IN',
            ),
        ),
    );
    // The Loop
    global $post;
    $the_query = new WP_Query( $args );
    if ( $the_query->have_posts() ) {
        $count=1;
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            ?>
            <?php $adv_position_into_comment = get_post_meta($post->ID,'adv_position_into_comment',true)?>

            <?php if($loop_counter==$adv_position_into_comment) { ?>

                <?php $ads_expire_date = get_post_meta($post->ID, 'ads_expire_date', true) ?>
                <?php if ($ads_expire_date) { ?>
                    <?php if ($ads_expire_date >= date('Y-m-d')) { ?>
                        <?php if (!empty(get_the_content())) { ?>
                            <div class="advertisement_section">

                                <?php echo get_the_content(); ?>
                            </div>
                        <?php }
                    }
                } else {
                    if (!empty(get_the_content())) {
                        ?>
                        <div class="advertisement_section">

                            <?php echo get_the_content(); ?>
                        </div>
                    <?php }
                }
            }

            $count++;
        }
    }

    wp_reset_postdata();
}


add_filter( 'before_title', 'fanzalive_before_title' );
function fanzalive_before_title($before) {
    $title='';
    $cat_is=array();
    if ( in_the_loop() && ( is_page() || is_singular('sp_team') ) ) {
       $categories = get_the_terms(get_the_ID(),'sp_league');
       if (empty($categories)) {
           return $before;
       }

       foreach ($categories as $category){
           $cat_is[]= $category->term_id;
       }
        $args = array(
            'post_type'  => 'fan_advertisement',
            'posts_per_page'=>1,
            'meta_key'   => 'page_id',
            'meta_query' => array(
                array(
                    'key'     => 'page_id',
                    'value'   => array( get_the_ID() ),
                    'compare' => 'IN',
                ),
            ),
        );
        if(is_singular('sp_team')){

            $args = array(
                'post_type'  => 'fan_advertisement',
                'posts_per_page'=>1,
                'meta_query' => array(
                        'relation' => 'OR',
                    'team_clause'=>array(
                        'key'     => 'team_id',
                        'value'   =>  get_the_ID() ,
                        'compare' => 'EXISTS',
                    ),
                    'league_clause'=>array(
                        'key'     => 'league_id',
                        'value'   => $cat_is,
                        'compare' => 'IN',
                    ),
                ),
                'orderby' => array(
                    'team_clause' => 'DESC',
                    'league_clause' => 'DESC',
                ),
            );
        }
        // The Loop
        global $post;
        $the_query = new WP_Query( $args );
        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();
                ?>
                <?php $ads_expire_date = get_post_meta($post->ID,'ads_expire_date',true)?>
                <?php if($ads_expire_date){?>
                    <?php if ($ads_expire_date >= date('Y-m-d')){?>
                        <?php if (!empty( get_the_content())){?>

                            <?php $advHtml = '<div class="advertisement_section">'.get_the_content().'</div>';?>
                        <?php }
                    }
                }else{
                    if (!empty( get_the_content())){?>

                        <?php $advHtml = '<div class="advertisement_section">'.get_the_content().'</div>';?>
                    <?php }
                }
            }
        }
        wp_reset_postdata();

        $title = $advHtml.$title;
    }
    echo $title;
}
