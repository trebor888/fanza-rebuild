<?php
/*
** Update match score
*/
function fanzalive_assign_reporter($event_id, $data) {
	if (fanzalive_get_event_reporter_id($event_id, $data['team'])) {
		return new WP_Error('exists', 'There\'s already a reported assigned for this team.');
	}
	fanzalive_set_event_reporter_id($event_id, $data['team'], get_current_user_id());
	return true;
}

function fanzalive_update_scores($event_id, $data) {
	$user_id = get_current_user_id();
	if (! get_post_meta($event_id, '_reporter_'. $data['team'], true) || $user_id != get_post_meta($event_id, '_reporter_'. $data['team'], true)) {
		return new WP_Errpr('unauthor', 'Sorry, you can\'t report. Someone else is reporting for this team right now.');
	}
	$reporter_team_side = $data['team'];
    $reporter_team_id = $data['team_id'];

	$results = get_post_meta($event_id, 'sp_results', true);
	if (empty($results)) {
		$results = [];
	}
	foreach (['firsthalf', 'secondhalf', 'goals'] as $k) {
		if (array_key_exists($k, $data)) {
			$results[$reporter_team_id][$k] = $data[$k];
		}
	}

	$home_team_id = fanzalive_get_event_team_id($event_id, 'home');
	$away_team_id = fanzalive_get_event_team_id($event_id, 'away');

	// calculate outcome
	$results = fanzalive_calculate_results_outcome($home_team_id, $away_team_id, $results);
	#fanzalive_p($results);
	#die();

	update_post_meta($event_id, 'sp_results', $results);
	update_post_meta($event_id, '_last_report_time_'. $reporter_team_side, time());

	return true;
}

function fanzalive_calculate_results_outcome($home_team_id, $away_team_id, $results) {
	if (isset($results[$home_team_id]) && isset($results[$home_team_id]['goals']) && isset($results[$away_team_id]) && isset($results[$away_team_id]['goals'])) {
		if ($results[$home_team_id]['goals'] > $results[$away_team_id]['goals']) {
			$results[$home_team_id]['outcome'] = 'win';
			$results[$away_team_id]['outcome'] = 'loss';
		} else if ($results[$away_team_id]['goals'] > $results[$home_team_id]['goals']) {
			$results[$home_team_id]['outcome'] = 'loss';
			$results[$away_team_id]['outcome'] = 'win';
		} else {
			$results[$home_team_id]['outcome'] = 'draw';
			$results[$away_team_id]['outcome'] = 'draw';
		}
	} else if (isset($results[$home_team_id]) && isset($results[$home_team_id]['goals'])) {
		$results[$home_team_id]['outcome'] = 'win';
		$results[$away_team_id]['outcome'] = 'loss';
	} else if (isset($results[$away_team_id]) && isset($results[$away_team_id]['goals'])) {
		$results[$home_team_id]['outcome'] = 'loss';
		$results[$away_team_id]['outcome'] = 'win';
	}

	return $results;
}

function fanzalive_insert_commentary($event_id, $data) {
	$user_id = get_current_user_id();
	if (! fanzalive_get_event_reporter_id($event_id, $data['team']) || $user_id != fanzalive_get_event_reporter_id($event_id, $data['team'])) {
		return new WP_Errpr('unauthor', 'Sorry, you can\'t report. Someone else is reporting for this team right now.');
	}

	$score = get_post_meta($event_id, 'sp_results', true);

	$comment_id = wp_insert_comment([
		'comment_approved'		=> 1,
		'comment_post_ID' 		=> $event_id,
		'comment_content' 		=> $data['comment'],
		'comment_type'			=> $data['type'],
		'user_id'				=> $user_id,
		'comment_author'		=> get_user_option('display_name', $user_id),
		'comment_author_email'	=> get_user_option('user_email', $user_id)
	]);

	if (is_wp_error($comment_id)) {
		return $comment_id;
	}

    $results = get_post_meta($event_id, 'sp_results', true);
    if (empty($results)) {
        $results = [];
    }


    $reporter_team_side = $data['team'];
    $reporter_team_id = $data['team_id'];
    $reporter_team1 = $data['goals-team1'];
    $reporter_team2 = $data['goals-team2'];
    $home_team_id = $data['home_team_id'];
    $away_team_id = $data['away_team_id'];
    //print_r($results);

    if($data['team_id'] = $home_team_id) {
        $data['goals'] = $data['goals-team1'];
        foreach (['firsthalf','secondhalf','goals'] as $k) {
            if (array_key_exists($k, $data)) {
                $results[$home_team_id][$k] = $data[$k];
            }
        }
    }

    if($data['team_id'] != $away_team_id) {
        $data['goals'] = $data['goals-team2'];
        foreach (['firsthalf','secondhalf','goals'] as $k) {
            if (array_key_exists($k, $data)) {
                $results[$away_team_id][$k] = $data[$k];
            }
        }
    }

    update_post_meta($event_id, 'sp_results', $results);
    update_post_meta($event_id, '_last_report_time_'. $reporter_team_side, time());

	update_comment_meta($comment_id, 'team', $data['team']);
	update_comment_meta($comment_id, 'team_id', $data['team_id']);
	update_comment_meta($comment_id, 'score', $results);
	update_comment_meta($comment_id, 'event_commentary', 1);
    update_comment_meta($comment_id, 'commentary_player', $data['commentary_player']);


   

	if (! empty($data['time'])) {
		update_comment_meta($comment_id, 'time', $data['time']);
	}

	if ('gamestarted' == $data['type']) {
		if (! fanzalive_has_event_started($event_id, $data['team'])) {
			fanzalive_event_started($event_id, $data['team']);
		}
	} else if ('gameended' == $data['type']) {
		if (! fanzalive_has_event_ended($event_id, $data['team'])) {
			fanzalive_event_ended($event_id, $data['team']);
		}
	}

	#fanzalive_p($_FILES);
	#die('');

	if (isset($_FILES['image'])) {
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );

		$image_id = media_handle_upload('image', 0);
		if (! is_wp_error($image_id)) {
			update_comment_meta($comment_id, 'image_id', $image_id);
		}
	}

	return $comment_id;
}


function fanzalive_insert_user_commentary($event_id, $data) {
    echo $user_id = get_current_user_id();
    echo $event_id;
    $comment_id = wp_insert_comment([
        'comment_approved'      => 1,
        'comment_post_ID'       => $event_id,
        'comment_content'       => $data['comment'],
        'user_id'               => $user_id,
        'comment_author'        => get_user_option('display_name', $user_id),
        'comment_author_email'  => get_user_option('user_email', $user_id)
    ]);

    $reporter_team_side = $data['team'];
    $reporter_team_id = $data['team_id']; 

    if (is_wp_error($comment_id)) {
        return $comment_id;
    }

    $results = get_post_meta($event_id, 'sp_results', true);
    if (empty($results)) {
        $results = [];
    }
    
    update_comment_meta($comment_id, 'team', $data['team']);
    update_comment_meta($comment_id, 'team_id', $data['team_id']);
    update_comment_meta($comment_id, 'score', $results);
    update_comment_meta($comment_id, 'event_commentary', 1);

    return $comment_id;
}


function fanzalive_insert_commentary_test_page($event_id, $data) {
	$user_id = get_current_user_id();

	$score = get_post_meta($event_id, 'sp_results', true);

	$comment_id = wp_insert_comment([
		'comment_approved'		=> 1,
		'comment_post_ID' 		=> $event_id,
		'comment_content' 		=> $data['comment'],
		'comment_type'			=> $data['type'],
		'user_id'				=> $user_id,
		'comment_author'		=> get_user_option('display_name', $user_id),
		'comment_author_email'	=> get_user_option('user_email', $user_id)
	]);

	if (is_wp_error($comment_id)) {
		return $comment_id;
	}

	update_comment_meta($comment_id, 'team', $data['team']);
	update_comment_meta($comment_id, 'team_id', $data['team_id']);
	update_comment_meta($comment_id, 'score', $score);
	update_comment_meta($comment_id, 'event_commentary', 1);

	if (! empty($data['time'])) {
		update_comment_meta($comment_id, 'time', $data['time']);
	}

	if ('gamestarted' == $data['type']) {
		if (! fanzalive_has_event_started($event_id, $data['team'])) {
			fanzalive_event_started($event_id, $data['team']);
		}
	} else if ('gameended' == $data['type']) {
		if (! fanzalive_has_event_ended($event_id, $data['team'])) {
			fanzalive_event_ended($event_id, $data['team']);
		}
	}

	#fanzalive_p($_FILES);
	#die('');

	if (isset($_FILES['image'])) {
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );

		$image_id = media_handle_upload('image', 0);
		if (! is_wp_error($image_id)) {
			update_comment_meta($comment_id, 'image_id', $image_id);
		}
	}

	return $comment_id;
}


// Custom functions
function fanzalive_get_event_reporter_id($event_id, $side = 'home') {
    return get_post_meta($event_id, '_reporter_' . $side, true);
}
function fanzalive_set_event_reporter_id($event_id, $side = 'home', $reporter_id) {
    return update_post_meta($event_id, '_reporter_' . $side, $reporter_id);
}
function fanzalive_get_event_team_id($event_id, $side = 'home') {
    $teams = array_unique(get_post_meta($event_id, 'sp_team'));
    if ($side == 'home' && ! empty($teams[0])) {
        return (int) $teams[0];
    } elseif ($side == 'away' && ! empty($teams[1])) {
        return (int) $teams[1];
    } else {
        return 0;
    }
}

function fanzalive_has_event_started($event_id, $side = 'home') {
    return get_post_meta($event_id, '_event_started_' . $side, true);
}
function fanzalive_event_started($event_id, $side = 'home') {
    return update_post_meta($event_id, '_event_started_' . $side, time());
}
function fanzalive_has_event_ended($event_id, $side = 'home') {
    return get_post_meta($event_id, '_event_ended_' . $side, true);
}
function fanzalive_event_ended($event_id, $side = 'home') {
    return update_post_meta($event_id, '_event_ended_' . $side, time());
}
function fanzalive_event_status($event_id) {
    return get_post_meta($event_id, '_status', true);
}
function fanzalive_event_status_code($event_id) {
    return get_post_meta($event_id, 'faaf_status_code', true);
}
function fanzalive_event_status_text($event_id) {
    return get_post_meta($event_id, 'faaf_status', true);
}


/*
 * Get event team name
 * @param $event_id int - the post id
 * @param $side string|int - team id or side
 * @return string - the team name or To be announced
*/
function fanzalive_get_event_team_name($event_id, $side = 'home') {
    $teams = array_unique(get_post_meta($event_id, 'sp_team'));
    #fanzalive_p(get_post_meta($event_id));
    if (is_numeric($side)) {
        $team_id = $side;
    } else {
        $team_id = fanzalive_get_event_team_id($event_id, $side);
    }

    return $team_id > 0 ? get_the_title($team_id) : 'TBA';
}

/*
 * Get the goals for given event team
 * @param $event_id int - the post id
 * @param $side string|int - team id or side
 * @param $context string (goals|firsthalf|secondhalf) - context of goals
 * @return bool|int - false if there's no data, either numeric value of given context goals
*/
function fanzalive_get_event_team_goals($event_id, $side = 'home', $context = 'goals') {
    $results = get_post_meta($event_id, 'sp_results', true);
    #if (! empty($results)) {
        #fanzalive_p($results);
        #$results = array_unique($results);
    #}

    if (is_numeric($side)) {
        $team_id = $side;
    } else {
        $team_id = fanzalive_get_event_team_id($event_id, $side);
    }

    if (isset($results[$team_id])) {
        if ('outcome' === $context) {
            return $results[$team_id][$context];
        }
        return (int) $results[$team_id][$context];
    } else {
        return false;
    }
}


/*
 * Check the event status
 * @param $event_id int - the post id
 * @return fixture|live|result|cancelled string
*/

function fanzalive_get_event_status($event_id) {
	$status = get_post_meta($event_id, '_status', true);
	if (! $status) {
		$status = 'fixture';
	}

	return $status;
}


/*
 * Check the event status
 * @param $event_id int - the post id
 * @return fixture|live|result|cancelled string
*/
function fanzalive_get_event_timer($event_id) {
	return (int) get_post_meta($event_id, '_timer', true);
}

/*
 * Check if current user can report for given event team
 * @param $event_id int - the post id
 * @param $side string|int - team id or side
 * @return true|false bool - true if user can report for the team, either false
*/
function fanzalive_user_can_report_for_event_team($event_id, $side = 'home') {
    $results = array_unique(get_post_meta($event_id, 'sp_results'));
    if (is_numeric($side)) {
        $team_id = $side;
    } else {
        $team_id = fanzalive_get_event_team_id($event_id, $side);
    }

$user_team_ids= array();
   if(get_current_user_id()){
$user_team_ids = fanzalive_get_user_report_teams(get_current_user_id());
}





    return in_array($team_id, $user_team_ids);
}

/*
 * Get event team report direct url
 * @param $event_id int - the post id
 * @param $side string|int - team id or side
 * @return true|false bool - true if user can report for the team, either false
*/
function fanzalive_get_event_team_report_url($event_id, $side = 'home') {
    return add_query_arg('team', $side, get_permalink($event_id));
}

function fanzalive_get_user_report_teams($user_id) {
    return get_user_meta($user_id, 'fanzalive_report_team_id');
}

function fanzalive_set_user_report_teams($user_id, $team_ids = []) {
    delete_user_meta($user_id, 'fanzalive_report_team_id');
    foreach ($team_ids as $team_id) {
        add_user_meta($user_id, 'fanzalive_report_team_id', $team_id);
    }
}
function fanzalive_get_commentary_type_label($type) {
    $types = fanzalive_get_commentary_types();
    return $types[$type];
}
function fanzalive_get_commentary_types() {
    return [
		"updates"		=> "",
        "gamestarted"   => "Game Started",
        "goal"          => "Goal",
        "penalty"       => "Penalty",
        "yellowcard"    => "Yellow Card",
        "redcard"       => "Red Card",
        //"halftime"      => "Halftime",
        "var"      => "VAR",
        "sentoff"       => "Sent Off",
        "gameended"     => "Game Ended"
    ];
}

function fanzalive_get_current_league_event_date($league_id) {
    $date_today = date('Y-m-d', current_time('timestamp'));

    $parts  = explode('-', $date_today);
    $year   =  $parts[0];
    $month  =  $parts[1];
    $day    =  $parts[2];

    $posts = get_posts([
        'post_type'     => 'sp_event',
        'post_status'   => ['future', 'publish'],
        'date_query'    => [
            'year'          => $year,
            'month'         => $month,
            'day'           => $day
        ],
        'tax_query'     => [
            'relation' => 'AND',
            [
                'taxonomy'  => 'sp_league',
                'terms'     => $league_id
            ]
        ],
        'posts_per_page' => 1
    ]);

    # fanzalive_p($posts);
    # die();

    if (! empty($posts)) {
        return $date_today;
    }

    // get next scheduled date
	/*
    $posts = get_posts([
        'post_type'     => 'sp_event',
        'post_status'   => 'future',
        'tax_query'     => [
            'relation' => 'AND',
            [
                'taxonomy'  => 'sp_league',
                'terms'     => $league_id
            ]
        ],
        'posts_per_page' => 1
    ]);

    if (! empty($posts)) {
        return mysql2date('Y-m-d', $posts[0]->post_date);
    }
	*/

    if ($next_date = fanzalive_get_next_league_event_date($league_id, $date_today)) {
        return $next_date;
    }

    if ($prev_date = fanzalive_get_prev_league_event_date($league_id, $date_today)) {
        return $prev_date;
    }

    return false;
}

function fanzalive_get_next_league_event_date($league_id, $current_date) {
    $posts = get_posts([
        'post_type'         => 'sp_event',
        'post_status'       => ['future', 'publish'],
        'date_query'        => [
            'after'             => $current_date
        ],
        'tax_query' => [
            'relation' => 'AND',
            [
                'taxonomy'  => 'sp_league',
                'terms'     => $league_id
            ]
        ],
        'posts_per_page'    => 1,
        'orderby'           => 'date',
        'order'             => 'ASC'
    ]);

    if (! empty($posts)) {
        return mysql2date('Y-m-d', $posts[0]->post_date);
    } else {
        return false;
    }
}

function fanzalive_get_prev_league_event_date($league_id, $current_date) {
    $posts = get_posts([
        'post_type'         => 'sp_event',
        'post_status'       => ['future', 'publish'],
        'date_query'        => [
            'before'             => $current_date
        ],
        'tax_query' => [
            'relation' => 'AND',
            [
                'taxonomy'  => 'sp_league',
                'terms'     => $league_id
            ]
        ],
        'posts_per_page'    => 1,
        'orderby'           => 'date',
        'order'             => 'DESC'
    ]);

    if (! empty($posts)) {
        return mysql2date('Y-m-d', $posts[0]->post_date);
    } else {
        return false;
    }
}

function fanzalive_get_teams() {
    $posts = get_posts([
        'post_type'         => 'sp_team',
        'post_status'       => ['publish'],
        'posts_per_page'    => -1,
        'orderby'           => 'post_title',
        'order'             => 'ASC'
    ]);
    $arrayData = array();

    foreach ($posts as $post){
        $arrayData[$post->ID]= $post->post_title;
    }

    return $arrayData;

}

function fanzalive_get_leagues() {
    $terms = get_categories('taxonomy=sp_league');
    $arrayData = array();

    foreach ($terms as $term){
        $arrayData[$term->term_id]= $term->name;;
    }

    return $arrayData;

}

function fanzalive_get_events() {
    $posts = get_posts([
        'post_type'         => 'sp_event',
        'post_status'       => ['publish'],
        'posts_per_page'    => -1,
        'orderby'           => 'post_title',
        'order'             => 'ASC'
    ]);
    $arrayData = array();

    foreach ($posts as $post){
        $arrayData[$post->ID]= $post->post_title;
    }

    return $arrayData;

}
