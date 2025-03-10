<?php
/**
 * Template Name: Home V2
**/
?>
<?php get_header(); ?>
<script>
    jQuery(document).ready(function ($) {
        setInterval(function () {
        $.ajax({
            type: 'GET',
            dataType: "html",
            url: '?action=load_comments_widget',
            success: function (response) {
                $('#latest-news').html(response);
            }
        });
    }, 2000);
    });
</script>
<style type="text/css">
div.widget_fanzalive_leagues li {
  background-color:#001a39;
}
@media (min-width:768px) {
    .home-col-one{
        min-width: 26% !important;
    }
    .home-col-two{
        min-width: 72% !important;
    }
    .home-col-three{
        min-width: 49% !important;
    }
    .home-col-four{
        min-width: 49% !important;
    }
}
</style>
<div id="content">
    <div id="primary">
        <ul class="tabs-menu visible-mobile home-tabs" data-target="#home-tab-contents">
            <li class="active"><a href="#leagues">Leagues</a></li>
            <li><a href="#latest-news">Latest News</a></li>
        </ul>
        <div id="home-tab-contents" class="tab-content-wrap tab-mobile">
            <div class="home-cols">
                <div id="leagues" class="home-col home-col-one tr2 tab-content active">
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
