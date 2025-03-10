<?php
/**
 * Template Name: Home
**/
?>
<?php get_header(); ?>

<div id="content">
    <div id="primary">
        <ul class="tabs-menu visible-mobile home-tabs" data-target="#home-tab-contents">
            <li class="active"><a href="#leagues">Leagues</a></li>
            <li><a href="#latest-news">Latest News</a></li>
        </ul>
        <div id="home-tab-contents" class="tab-content-wrap tab-mobile">
            <div class="home-cols">
                <div id="leagues" class="home-col home-col-one tab-content active">
                    <?php if (is_active_sidebar('home-col-one')) : ?>
                        <?php  dynamic_sidebar('home-col-one'); ?>
                    <?php endif; ?>
                </div>
                <div id="latest-news" class="home-col home-col-two tab-content">
                    <div class="home-cols">
                        <div class="home-col home-col-three">
                            <?php if (is_active_sidebar('home-col-two')) : ?>
                                <?php  dynamic_sidebar('home-col-two'); ?>
                            <?php endif; ?>
                        </div>
                        <div class="home-col home-col-four">
                            <?php if (is_active_sidebar('home-col-three')) : ?>
                                <?php  dynamic_sidebar('home-col-three'); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
