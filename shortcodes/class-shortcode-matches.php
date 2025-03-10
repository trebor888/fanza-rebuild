<?php
/**
 * Shortcode - Matches
 * displays matches group by league
 **/


class Fanzalive_Shortcode_Matches
{
    public static function init()
    {
        // new instance
        $instance = new self();

        // shortcode callback
        add_shortcode('fanzalive_matches', [$instance, 'render'], 10, 2);

        // ajax call to facilate loading matches without reloading
        add_action('wp_ajax_fanzalive_get_matches_template', [$instance, 'get_matches_template_ajax']);
        add_action('wp_ajax_nopriv_fanzalive_get_matches_template', [$instance, 'get_matches_template_ajax']);
    }

    public function render($attrs, $content)
    {
        $attrs = wp_parse_args($attrs, [
            'date' => date('Y-m-d'),
            'league_id' => '',
            'loading' => __('Loading...')
        ]);
        extract($attrs);

        return '<div class="fanzalive-matches" data-date="'. $date .'" data-league_id="'. $league_id .'" data-loading="'. esc_attr($loading) .'">'
        . $this->get_calendar_template($date, $league_id)
        . $this->get_matches_template($date, $league_id)
        . '</div>';
    }

    public function get_matches_template_ajax()
    {
        if (! isset($_REQUEST['date'])) {
            wp_send_json([
                'success' => false,
                'message' => __('Missing data')
            ]);
        }

        $date = $_REQUEST['date'];
        $league_id = isset($_REQUEST['league_id']) ? $_REQUEST['league_id'] : '';

        wp_send_json([
            'success' => true,
            'message' => $this->get_matches_template($date, $league_id)
        ]);
    }

    private function get_calendar_template($date, $league_id)
    {
        $calendar_dates = $this->get_calendar_dates($date, $league_id);

        ob_start();
        ?>
        <div class="calendar">
            <div class="owl-carousel">
                <?php foreach ($calendar_dates as $calendar_date) {
                    printf(
                        '<div class="calendar-date%s" data-date="%s">
                            <div class="name">%s</div>
                            <div class="desc">%s</div>
                        </div>',
                        $calendar_date['date'] === $date ? ' date-active' : '',
                        $calendar_date['date'],
                        $calendar_date['name'],
                        $calendar_date['desc']
                    );
                } ?>
            </div>
        </div>
        <?php

        return ob_get_clean();
    }

    private function get_matches_template($date, $league_id)
    {
        global $league, $match;
        $league_matches = $this->get_league_matches($date, $league_id);

        ob_start();
        ?>
        <table class="matches">
        <tbody><?php
        if (empty($league_matches)) {
            get_template_part('template-parts/no-match-row');
        } else {
            foreach ($league_matches as $league_event) {
                if (empty($league_id)) {
                    $league = $league_event['league'];
                    get_template_part('template-parts/league-name-row');
                }

                foreach ($league_event['matches'] as $match) {
                    get_template_part('template-parts/match-row');
                }
            }
        }
        ?></tbody>
        </table>
        <?php

        return ob_get_clean();
    }

    private function get_calendar_dates($date, $league_id)
    {
        $current_ts =  current_time('timestamp');
        $date_ts = strtotime($date);

        $dates = [];

        for ($i=15; $i>0; --$i) {
            $date_now_ts = $date_ts - (DAY_IN_SECONDS * $i);
            $dates[] = [
                'name'  => date('Y-m-d', $date_now_ts) === date('Y-m-d', $current_ts) ? __('Today') : date('D', $date_now_ts),
                'desc'  => date('d M', $date_now_ts),
                'date'  => date('Y-m-d', $date_now_ts),
            ];
        }

        for ($i=0; $i<15; ++$i) {
            $date_now_ts = $date_ts + (DAY_IN_SECONDS * $i);
            $dates[] = [
                'name'  => date('Y-m-d', $date_now_ts) === date('Y-m-d', $current_ts) ? __('Today') : date('D', $date_now_ts),
                'desc'  => date('d M', $date_now_ts),
                'date'   => date('Y-m-d', $date_now_ts),
            ];
        }

        return $dates;
    }

    private function get_league_matches($date, $league_id)
    {
        $parts  = explode('-', $date);
        $year   =  $parts[0];
        $month  =  $parts[1];
        $day    =  $parts[2];

        $query_args = [
            'post_type'         => 'sp_event',
            'post_status'       => ['future', 'publish'],
            'posts_per_page'    => -1,
            'order'             => 'ASC',
            'date_query'    => [
                'year'          => $year,
                'month'         => $month,
                'day'           => $day
            ],
            'orderby'           => 'date',
            'order'             => 'ASC'
        ];

        if (! empty($league_id)) {
            $query_args['tax_query'] = [
                [
                    'taxonomy' => 'sp_league',
                    'terms' => wp_parse_id_list($league_id)
                ]
            ];
        }

        $events = get_posts($query_args);
        if (empty($events)) {
            return [];
        }

        $league_matches = [];
        foreach ($events as $event) {
            $event_id = $event->ID;

            $leagues = wp_get_object_terms($event_id, 'sp_league');
            if (! empty($leagues)) {
                $league = $leagues[0];
                $_league_id = $league->term_id;
                $league_name = $league->name;
            } else {
                $_league_id = 0;
                $league_name = __('Others');
            }

            if (! isset($league_matches[$_league_id])) {
                $league_matches[$_league_id] = [
                    'league'    => [
                        'id'        => $_league_id,
                        'name'      => $league_name,
                    ],
                    'matches'   => []
                ];
            }

            $league_matches[$_league_id]['matches'][] = [
                'id' => $event_id,
                'minutes_played' => get_post_meta($event_id, '_timer', true),
                'match_day' => get_post_meta($event_id, 'sp_day', true),
                'status' => fanzalive_event_status($event_id),
                'status_code' => fanzalive_event_status_code($event_id),
                'status_text' => fanzalive_event_status_text($event_id),
                'date' => $event->post_date,
                'url' => get_permalink($event),
                'team_home' => [
                    'id' => fanzalive_get_event_team_id($event_id, 'home'),
                    'name' => fanzalive_get_event_team_name($event_id, 'home'),
                    'score' => fanzalive_get_event_team_goals($event_id, 'home'),
                    'reporter' => fanzalive_get_event_reporter_id($event_id, 'home') ? get_user_option('display_name', fanzalive_get_event_reporter_id($event_id, 'home')) : '',
                    'can_report' => fanzalive_user_can_report_for_event_team($event_id, 'home') ? true : false,
                    'reporting_started' => fanzalive_has_event_started($event_id, 'home'),
                    'reporting_ended' => fanzalive_has_event_ended($event_id, 'home'),
                ],
                'team_away' => [
                    'id' => fanzalive_get_event_team_id($event_id, 'away'),
                    'name' => fanzalive_get_event_team_name($event_id, 'away'),
                    'score' => fanzalive_get_event_team_goals($event_id, 'away'),
                    'reporter' => fanzalive_get_event_reporter_id($event_id, 'away') ? get_user_option('display_name', fanzalive_get_event_reporter_id($event_id, 'away')) : '',
                    'can_report' => fanzalive_user_can_report_for_event_team($event_id, 'away') ? true : false,
                    'reporting_started' => fanzalive_has_event_started($event_id, 'away'),
                    'reporting_ended' => fanzalive_has_event_ended($event_id, 'away'),
                ]
            ];
        }

        return array_values($league_matches);
    }
}
