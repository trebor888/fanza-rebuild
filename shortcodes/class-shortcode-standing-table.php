<?php
/**
 * Shortcode - Matches
 * displays matches group by league
 **/


class Fanzalive_Shortcode_Standing_Table
{
    public static function init()
    {
        // new instance
        $instance = new self();

        // shortcode callback
        add_shortcode('fanzalive_standing_table', [$instance, 'render'], 10, 2);

        // cron event handler
        add_action('fanzalive_cache_standing_table_data', [$instance, 'cache_standing_table_data'], 10);
    }

    public function cache_standing_table_data($attrs)
    {
        extract($attrs);

        if (! $league_id || ! get_term($league_id, 'sp_league')) {
            return '';
        }

        $cache_key = 'fanzalive_standing_'. md5(serialize($attrs));

        // gather standing data
        $standings = $this->get_standings_data($league_id, $limit);

        if (! empty($standings)) {
            // basic store
            set_transient($cache_key, $standings, (MINUTE_IN_SECONDS * rand(10, 30)));

            // this is a backup for longer period
            set_transient($cache_key . '_long', $standings, MONTH_IN_SECONDS);
        } else {
            // if standing doesn't return anything, store that for a minute
            set_transient($cache_key, [], MINUTE_IN_SECONDS);
        }

    }


    public function render($attrs, $content)
    {
        global $standings;

        $attrs = wp_parse_args($attrs, [
            'league_id' => 0,
            'limit' => 0,
            'title' => false,
            'link' => false
        ]);
        extract($attrs);


        if (! $league_id || ! get_term($league_id, 'sp_league')) {
            return '';
        }

        $league_id = (int) $league_id;

        $cache_key = 'fanzalive_standing_'. md5(serialize($attrs));
        $standings = get_transient($cache_key);


        if (false === $standings) {
            if (! wp_next_scheduled('fanzalive_cache_standing_table_data', array($attrs))) {
                wp_schedule_single_event(time(), 'fanzalive_cache_standing_table_data', array($attrs));
            }

            // get data which were save for longer period
            $standings = get_transient($cache_key . '_long');
            if (false === $standings) {
                return;
            }
        }


        if (empty($standings)) {
            return '';
        }


        ob_start();
        if(get_field('below_table_tab', get_the_ID()) == 'Yes' || get_field('below_table_tab', get_the_ID()) == '') {
            if(get_field('below_table_tab_content', get_the_ID())) {
                echo '<div class="tbal-ads">'.get_field('below_table_tab_content', get_the_ID()).'</div>';
            }else {
                if(get_option('fixture_below_tables_tab', true) == 'Yes'){
                    if(get_option('fixture_below_tables_tab_desc', true)){
                        echo '<div class="tbal-ads">'.get_option('fixture_below_tables_tab_desc', true).'</div>';
                    }
                }
            } 
        }
        ?><div class="fanzalive-standing">
        <?php        
        if ($title) {
            printf(
                '<div class="standing-title">%s</div>',
                $standings['league']['name']
            );
        }

        get_template_part('template-parts/standing-table');

        if ($link) {
            printf(
                '<div class="standing-footer"><a href="%s#table">%s Table <i class="fa fa-chevron-right"></i></a></div>',
                $standings['league']['url'],
                $standings['league']['name']
            );
        }
        echo '</div>';

        return ob_get_clean();
    }

    private function get_standings_data($league_id, $limit = false)
    {
        $league = get_term($league_id, 'sp_league');
        if (! $league) {
            return [];
        }

        $results = $this->get_league_results($league_id);
        if (empty($results)) {
            return $results;
        }

        $headers = [
            'pos' => [
                'value' => 'Pos',
                'css_class' => 'col-pos'
            ],
            'team' => [
                'value' => 'Team',
                'css_class' => 'col-team'
            ],
            'played' => [
                'value' => 'P',
                'css_class' => 'col-played'
            ],
            'won' => [
                'value' => 'W',
                'css_class' => 'col-won'
            ],
            'draw' => [
                'value' => 'D',
                'css_class' => 'col-draw'
            ],
            'lost' => [
                'value' => 'L',
                'css_class' => 'col-lost'
            ],
            'goalfor' => [
                'value' => 'GF',
                'css_class' => 'col-goalfor'
            ],
            'goalagainst' => [
                'value' => 'GA',
                'css_class' => 'col-goalagainst'
            ],
            'points' => [
                'value' => 'PTS',
                'css_class' => 'col-points'
            ],
            'form' => [
                'value' => 'Form',
                'css_class' => 'col-form'
            ]
        ];

        $rows = [];
        foreach ($results as $result) {
            if (empty($result['team_home']['id']) || empty($result['team_home']['id'])) {
                continue;
            }

            if (! isset($rows[$result['team_home']['id']])) {
                $rows[$result['team_home']['id']] = array_fill_keys(array_keys($headers), 0);
            }
            if (! isset($rows[$result['team_away']['id']])) {
                $rows[$result['team_away']['id']] = array_fill_keys(array_keys($headers), 0);
            }

            ++ $rows[$result['team_home']['id']]['played'];
            ++ $rows[$result['team_away']['id']]['played'];

            if ($result['team_home']['score'] > $result['team_away']['score']) {
                ++ $rows[$result['team_home']['id']]['won'];
                ++ $rows[$result['team_away']['id']]['lost'];

                $rows[$result['team_home']['id']]['points'] += 3;

            } elseif ($result['team_home']['score'] < $result['team_away']['score']) {
                ++ $rows[$result['team_home']['id']]['lost'];
                ++ $rows[$result['team_away']['id']]['won'];

                $rows[$result['team_away']['id']]['points'] += 3;
            } else {
                ++ $rows[$result['team_home']['id']]['draw'];
                ++ $rows[$result['team_away']['id']]['draw'];

                $rows[$result['team_home']['id']]['points'] += 1;
                $rows[$result['team_away']['id']]['points'] += 1;
            }

            $rows[$result['team_home']['id']]['goalfor'] += $result['team_home']['score'];
            $rows[$result['team_away']['id']]['goalfor'] += $result['team_away']['score'];

            $rows[$result['team_home']['id']]['goalagainst'] += $result['team_away']['score'];
            $rows[$result['team_away']['id']]['goalagainst'] += $result['team_home']['score'];
        }

        uasort($rows, function($a, $b){
            if ($a['points'] > $b['points']) {
                return -1;
            } else if ($a['points'] < $b['points']) {
                return 1;
            } else {
                if ($a['goalfor'] > $b['goalfor']) {
                    return -1;
                } else if ($a['goalfor'] < $b['goalfor']) {
                    return 1;
                }
                return 0;
            }
        });

        if (! empty($rows) && $limit) {
            $rows = array_slice($rows, 0, $limit, true);
        }

        $pos = 0;
        foreach ($rows as $team_id => $row) {
            ++ $pos;

            $rows[$team_id]['pos'] = $pos;
            $rows[$team_id]['team'] = get_the_title($team_id);
            $rows[$team_id]['team_id'] = $team_id;
            $rows[$team_id]['form'] = $this->team_forms_template($team_id, $league_id);
        }

        $standings = [
            'league' => [
                'name' => $league->name,
                'url' => get_term_link($league),
            ],
            'headers' => $headers,
            'rows' => array_values($rows)
        ];

        return $standings;
    }

    private function team_forms_template($team_id, $league_id)
    {
        $results = $this->get_team_results($team_id, $league_id);
        if (empty($results)) {
            return '';
        }

        $forms = [];
        foreach ($results as $result) {
            $outcome = fanzalive_get_event_team_goals($result['id'], $team_id, 'outcome');

            if ('win' === $outcome) {
                $forms[] = '<span class="result-win">W</span>';
            } elseif ('loss' == $outcome) {
                $forms[] = '<span class="result-loss">L</span>';
            } elseif ('draw' == $outcome) {
                $forms[] = '<span class="result-draw">D</span>';
            } else {
                $forms[] = '<span class="result-what">?</span>';
            }
        }

        return implode('', $forms);
    }

    private function get_team_results($team_id, $league_id, $limit = 5)
    {
        $query_args = [
            'post_type'         => 'sp_event',
            'post_status'       => 'publish',
            'posts_per_page'    => $limit,
            'order'             => 'ASC',
            'orderby'           => 'date',
            'order'             => 'ASC',
            'meta_query' => [
                'relation' => 'AND',
                [
                    'key' => '_status',
                    'value' => 'completed'
                ],
                [
                    'key' => 'sp_team',
                    'value' => $team_id
                ]
            ],
            'tax_query' => [
                [
                    'taxonomy' => 'sp_league',
                    'terms' => $league_id
                ]
            ]
        ];

        $events = get_posts($query_args);
        if (empty($events)) {
            return [];
        }

        $results = [];
        foreach ($events as $event) {
            $event_id = $event->ID;

            $results[] = [
                'id' => $event_id,
                'team_home' => [
                    'id' => fanzalive_get_event_team_id($event_id, 'home'),
                    'name' => fanzalive_get_event_team_name($event_id, 'home'),
                    'score' => fanzalive_get_event_team_goals($event_id, 'home'),
                ],
                'team_away' => [
                    'id' => fanzalive_get_event_team_id($event_id, 'away'),
                    'name' => fanzalive_get_event_team_name($event_id, 'away'),
                    'score' => fanzalive_get_event_team_goals($event_id, 'away')
                ]
            ];
        }

        return $results;
    }


    private function get_league_results($league_id)
    {
        $season_id = get_term_meta($league_id, 'faaf_season_id', true);
        if (! $season_id) {
            return [];
        }

        $query_args = [
            'post_type'         => 'sp_event',
            'post_status'       => 'publish',
            'posts_per_page'    => -1,
            'order'             => 'ASC',
            'orderby'           => 'date',
            'order'             => 'ASC',
            'meta_query' => [
                [
                    'key' => '_status',
                    'value' => 'completed'
                ]
            ],
            'tax_query' => [
                'relation' => 'AND',
                [
                    'taxonomy' => 'sp_league',
                    'terms' => $league_id
                ],
                [
                    'taxonomy' => 'sp_season',
                    'terms' => $season_id
                ]
            ]
        ];

        $events = get_posts($query_args);
        if (empty($events)) {
            return [];
        }

        $results = [];
        foreach ($events as $event) {
            $event_id = $event->ID;

            $results[] = [
                'id' => $event_id,
                'team_home' => [
                    'id' => fanzalive_get_event_team_id($event_id, 'home'),
                    'name' => fanzalive_get_event_team_name($event_id, 'home'),
                    'score' => fanzalive_get_event_team_goals($event_id, 'home'),
                ],
                'team_away' => [
                    'id' => fanzalive_get_event_team_id($event_id, 'away'),
                    'name' => fanzalive_get_event_team_name($event_id, 'away'),
                    'score' => fanzalive_get_event_team_goals($event_id, 'away')
                ]
            ];
        }

        return $results;
    }
}
