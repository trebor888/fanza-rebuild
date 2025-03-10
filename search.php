<?php get_header(); ?>

<div id="content" class="clearfix">

    <div id="primary">

        <div class="entry notsingle" style="margin-bottom:24px">
            <form method="get" id="searchform" action="<?php echo home_url(); ?>/">
                <input type="text" class="txt" name="s" id="s" value="<?php esc_html_e('Search','fanzalive'); ?>" onblur="if (this.value == '') {this.value = '<?php esc_html_e('Search','fanzalive'); ?>';}" onfocus="if (this.value == '<?php esc_html_e('Search','fanzalive'); ?>') {this.value = '';}" />
            </form>
        </div>

        <?php if(have_posts()) : ?>
        <?php while(have_posts()) : the_post(); ?>

        <div class="entry single">
    
            <h1><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
            <?php the_excerpt(); ?>

        </div>

        <?php endwhile; ?>
        <?php else : ?>

        <div class="entry single">

            <h1><?php esc_html_e('Nothing Found','fanzalive'); ?></h1>

        </div>

        <?php endif; ?>

    </div>

</div>

<?php get_footer(); ?>
