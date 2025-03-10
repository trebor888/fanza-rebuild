<div class="home-cols">
    <div class="home-col home-col-three">
        <?php if (is_active_sidebar('home-col-two')) : ?>
            <?php dynamic_sidebar('home-col-two'); ?>
        <?php endif; ?>
    </div>
    <div class="home-col home-col-four">
        <?php if (is_active_sidebar('home-col-three')) : ?>
            <?php dynamic_sidebar('home-col-three'); ?>
        <?php endif; ?>
    </div>
</div>