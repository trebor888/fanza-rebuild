<?php get_header(); ?>
<div id="content">
    <?php if(have_posts()) : ?>
        <div  class="imagegrid">
            <?php while(have_posts()) : the_post(); ?>
            <div class="entry box" id="post-<?php the_ID(); ?>">
                <?php if ( has_post_thumbnail() ) {
                    the_post_thumbnail('square-large');
                } ?>
                <h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h2>
            </div>
            <?php endwhile; ?>
        </div>
        <div class="navigation nextpages"><?php posts_nav_link(); ?></div>
    <?php else : ?>
        <div class="entry single">
            <h1><?php esc_html_e('Nothing to see here','fanzalive'); ?></h1>
        </div>
    <?php endif; ?>
</div>
<?php get_footer(); ?>
