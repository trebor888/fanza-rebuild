<?php
if ( function_exists('yoast_breadcrumb') ) {
  yoast_breadcrumb('<div class="breadcrumbs">','</div>');
} else if (is_singular('sp_event')) {
    $breadcrumbs = '<a href="'.esc_url( home_url( '/' ) ).'">Home</a>';
    $leagues = wp_get_object_terms(get_the_ID(), 'sp_league');
    if (! empty($leagues)) {
        foreach ($leagues as $league) {
            $breadcrumbs .= ' / <a href="'. get_term_link($league) .'">' . $league->name . '</a>';
        }
    }

    $breadcrumbs .= ' / '. get_the_title();
    ?><div class="breadcrumbs"><?php echo $breadcrumbs; ?></div><?php
}
