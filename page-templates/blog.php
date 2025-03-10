<?php
/**
 * Template Name: Blog Template
 */

if(get_field('header_top_advertise', get_the_ID()) == 'Yes' || get_field('header_top_advertise', get_the_ID()) == '') {
    if(get_field('header_top_advertise_content', get_the_ID())) {
        echo get_field('header_top_advertise_content', get_the_ID());
    }else {
        if(get_option('news_header_top', true) == 'Yes'){
            if(get_option('news_header_top_desc', true)) {
                echo get_option('news_header_top_desc', true);
            }
        }
    } 
}
$page_id =  get_the_ID();
get_header();
?>
<div id="content">
    <div id="primary">
        <?php 
            echo '<h1 class="heading">'.get_the_title().'</h1>';
            if(get_field('header_bottom_advertise', get_the_ID()) == 'Yes' || get_field('header_bottom_advertise', get_the_ID()) == '') {
                if(get_field('header_bottom_advertise_content', get_the_ID())) {
                    echo get_field('header_bottom_advertise_content', get_the_ID());
                }else {
                    if(get_option('news_header_bottom', true) == 'Yes'){
                        if(get_option('news_header_bottom_desc', true)) {
                            echo get_option('news_header_bottom_desc', true);
                        }
                    }
                } 
            }

        ?>
        <div class="tab-all tab-style-three">
            <ul class="tabs-menu tabs-keep-history" data-target="#tab-contents">
                <li><a href="#fixtures">Fixtures</a></li>
                <li class="active"><a href="#blog-news">News</a></li>
            </ul>
            <div id="tab-contents" class="tab-content-wrap">
                <div id="fixtures" class="tab-content">
                   <?php echo do_shortcode('[fanzalive_matches]') ?>  
                </div>
                <div id="blog-news" class="tab-content active">
                    <div class="home-cols">
                        <?php 
                            if(get_field('right_side_of_news_in_tab', get_the_ID()) == 'Yes' || get_field('right_side_of_news_in_tab', get_the_ID()) == '') {
                                if(get_field('right_side_of_news_in_tab_content', get_the_ID())) {
                                    $new_class = "col-md-9"; 
                                }else {
                                    if(get_option('news_right_news_tab', true) == 'Yes'){
                                        if(get_option('news_right_news_tab_desc', true)) {
                                            $new_class = "col-md-9"; 
                                        }
                                    }
                                } 
                            }
                        ?>
                        <div class="col-md-12 <?= $new_class; ?>">
                            <?php  
                                if(get_field('set_position_of_ads_between_news_tab', get_the_ID())){
                                    $displayads = explode(',', get_field('set_position_of_ads_between_news_tab', get_the_ID()));
                                }else {
                                    $displayads = explode(',', get_option('news_position_between_tables_tab', true));
                                }
                                
                                $displayposts = get_option('hlp_post_show', true);
                                $args = array(  
                                    'post_type' => 'post',
                                    'posts_per_page' => $displayposts,                                  
                                );

                                $loop = new WP_Query( $args ); 
                                $i = 1;
                                while ( $loop->have_posts() ) : $loop->the_post();
                                    $team_id = get_post_meta(get_the_ID(), 'reporter_team', true);
                                    if($team_id) {
                                        if(in_array($i, $displayads)) { ?>
                                            <?php 
                                                if(get_field('show_ads_before_posts', $page_id) == 'Yes' || get_field('show_ads_before_posts', $page_id) == '') {
                                                    if(get_field('show_ads_before_posts_content', $page_id)) {
                                                        echo get_field('show_ads_before_posts_content', $page_id);
                                                    }else {
                                                        if(get_option('news_before_post_news_tab', true) == 'Yes'){
                                                            if(get_option('news_before_post_news_tab_desc', true)) {
                                                                echo get_option('news_before_post_news_tab_desc', true);
                                                            }
                                                        }
                                                    } 
                                                }
                                            ?>
                                            <div class="news-section">
                                                <div class="news-img">
                                                    <a href="<?= get_the_permalink($team_id[0]); ?>">
                                                        <img src="<?= get_the_post_thumbnail_url($post->ID); ?>" />
                                                    </a>
                                                </div>
                                                <div class="news-details">
                                                    <h1><a href="<?= get_the_permalink($team_id[0]); ?>"><?= get_the_title(); ?></a></h1>
                                                    <p><?php echo get_the_date('F j, Y');?></p>
                                                </div>
                                            </div>
                                            <?php 
                                                if(get_field('show_ads_after_posts', $page_id) == 'Yes' || get_field('show_ads_after_posts', $page_id) == '') {
                                                    if(get_field('show_ads_after_posts_content', $page_id)) {
                                                        echo get_field('show_ads_after_posts_content', $page_id);
                                                    }else {
                                                        if(get_option('news_after_post_news_tab', true) == 'Yes'){
                                                            if(get_option('news_after_post_news_tab_desc', true)) {
                                                                echo get_option('news_after_post_news_tab_desc', true);
                                                            }
                                                        }
                                                    } 
                                                }
                                            ?>
                                    <?php  }else {  ?> 
                                        <div class="news-section">
                                            <div class="news-img">
                                                <a href="<?= get_the_permalink($team_id[0]); ?>">
                                                    <img src="<?= get_the_post_thumbnail_url($post->ID); ?>" />
                                                </a>
                                            </div>
                                            <div class="news-details">
                                                <h1><a href="<?= get_the_permalink($team_id[0]); ?>"><?= get_the_title(); ?></a></h1>
                                                <p><?php echo get_the_date('F j, Y');?></p>
                                            </div>
                                        </div>
                                        
                                    <?php } } $i++;  endwhile;

                                wp_reset_postdata();
                            ?>
                        </div>
                        <?php 
                            if(get_field('right_side_of_news_in_tab', get_the_ID()) == 'Yes' || get_field('right_side_of_news_in_tab', get_the_ID()) == '') {
                                if(get_field('right_side_of_news_in_tab_content', get_the_ID())) {
                                     echo '<div class="col-md-3">'.get_field('right_side_of_news_in_tab_content', get_the_ID()). '</div>';
                                }else {
                                    if(get_option('news_right_news_tab', true) == 'Yes'){
                                        if(get_option('news_right_news_tab_desc', true)) {
                                            echo '<div class="col-md-3">'.get_option('news_right_news_tab_desc', true). '</div>';
                                        }
                                    }
                                } 
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
