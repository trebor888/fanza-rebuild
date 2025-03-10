<?php
/**
 * Template Name: Page No Title
**/
?>
<?php 

if(get_field('header_top_advertise', get_the_ID()) == 'Yes' || get_field('header_top_advertise', get_the_ID()) == '') {
    if(get_field('header_top_advertise_content', get_the_ID())) {
        echo get_field('header_top_advertise_content', get_the_ID());
    }else {
        if(get_option('fixture_header_top', true) == 'Yes'){
            if(get_option('fixture_header_top_desc', true)){
                echo get_option('fixture_header_top_desc', true);
            }
        }
    } 
}

get_header();


if(get_field('header_bottom_advertise', get_the_ID()) == 'Yes' || get_field('header_bottom_advertise', get_the_ID()) == '') {
    if(get_field('header_bottom_advertise_content', get_the_ID())) {
        echo get_field('header_bottom_advertise_content', get_the_ID());
    }else {
        if(get_option('fixture_header_bottom', true) == 'Yes'){
            if(get_option('fixture_header_bottom_desc', true)){
                echo get_option('fixture_header_bottom_desc', true);
            }
        }
    } 
}

?>

<div id="content">
    <div id="primary">
        <?php if(have_posts()) : ?>
            <?php while(have_posts()) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>
