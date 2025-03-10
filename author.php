<?php get_header();?>
<div id="content">
    <div id="primary">
<?php
// Set the Current Author Variable $curauth
global $current_user;
$curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
if (isset($_POST['action']) && 'fanzalive_update_follow' == $_POST['action'] && is_user_logged_in()) {
    $cuid=$_POST['current-user']; 
    $followers_id = explode( ',', get_user_meta( $curauth->ID, 'followers_id', true ) );  
    
    if(in_array($current_user->ID, $followers_id)) {
		
	}else {
		$followers_id[] = $current_user->ID;
    	$followers_id = implode( $followers_id,',');
		update_user_meta($curauth->ID,'followers_id',$followers_id); 
		$count_follow = get_user_meta($curauth->ID, 'user_count_follow', true);
		update_user_meta($curauth->ID,'user_count_follow',$count_follow+1);
	}
    

    //update_user_meta($curauth->ID,'followers_id', $followers_id);
    $get_follower = get_user_meta($curauth->ID, 'followers_id', true);    
}
$follower =  explode( ',',get_user_meta( $curauth->ID, 'followers_id', true ));


if(in_array($current_user->ID, $follower)) {
	$disabled = 'disabled';
	$followed = 'Followed';
}

?>
<?php 
	if(get_option('author_header_bottom', true) == 'Yes'){
        if(get_option('author_header_bottom_desc', true)) {
            echo get_option('author_header_bottom_desc', true);
        }
    }
?>
<?php if(is_user_logged_in()) { ?>
<div class="fanza-author-menu author-menu">
	<ul>
		<li>
			<a href="<?php echo home_url('/edit-profile'); ?>">Edit Profile</a>
		</li>
		<li>
			<a href="<?php echo home_url('/edit-team'); ?>">Change Team</a>
		</li>
		<li>
			<a href="<?php echo home_url('/add-posts'); ?>">Post News
				<?php 
					$today = getdate();
                    $args = array(
						'author'        =>  $curauth->ID, 
						'orderby'       =>  'post_date',
						'order'         =>  'ASC',
						'year' => $today['year'],
						'monthnum' => $today['mon'], 
	                );
	                $the_query = new WP_Query( $args );
	                if($the_query->post_count>=2) {
	                    echo '<span class="post-count green">'.$the_query->post_count.'</span>'; 
	              	}else{ 
	              		echo '<span class="post-count red">'.$the_query->post_count.'</span>';
	              	}				
	            ?>
			</a>
		</li>
		<li>
			<a href="<?php echo home_url('/messages'); ?>">Messages</a>
		</li>
		<li>
			<a href="#">Help</a>
		</li>
	</ul>
</div>
<?php } ?>
<div class="author-title-large"><h1> Fanzalive Reporter <?php echo ucwords($curauth->display_name);?></h1></div>

        <div <?php post_class('entry single'); ?>>
<div style="display: block; margin-bottom: 10px">

    <?php

    $count_viewer = get_user_meta($curauth->ID, 'count_viewer', true);
    update_user_meta($curauth->ID,'count_viewer',$count_viewer+1);
    $user_photo = get_user_meta($curauth->ID, 'user_photo', true);
    if ($user_photo) {
        $img = wp_get_attachment_image_src($user_photo, 'thumbnail');
        $url = $img[0];
        //$url = "https://www.fanzalive.co.uk/wp-content/uploads/profile-default.png";
    } else {
        $url = "https://www.fanzalive.co.uk/wp-content/uploads/profile-default.png";
    }
    ?>
    <img style="float:left; width:150px; margin-right:20px " src="<?php echo $url;?>" />

    <h1><?php echo ucwords($curauth->display_name);?></h1>
    <p><?php echo get_user_meta($curauth->ID, 'description', true);?></p>
    <p>
    <?php 
    	if(!is_user_logged_in()) { ?>
    		<form action="" method="post">
		        <input type="hidden" name="action" value="fanzalive_update_follow" /><input type="hidden" name="current-user" value="<?php echo get_current_user_id(); ?>" />
		        <button name="user_follow" type="button" id="follow_btn"><i class="fa fa-user-plus fa-2x"></i> </button> &nbsp;Follow &nbsp;<?php echo get_user_meta($curauth->ID, 'user_count_follow', true);?>

		        <a style="text-decoration: none;color:#000;text-align: right;width: 30%;display: inline-block;" href="#" disabled="disabled" id="follow_btn">Send Message</a>
		    </form>
    <?php	}else {
    ?>
	    <form action="" method="post">
	        <input type="hidden" name="action" value="fanzalive_update_follow" /><input type="hidden" name="current-user" value="<?php echo get_current_user_id(); ?>" />
	        <button name="user_follow" type="submit" <?= $disabled; ?>><i class="fa fa-user-plus fa-2x"></i> </button> &nbsp;<?= ($followed) ? $followed : 'Follow' ; ?> &nbsp;<?php echo get_user_meta($curauth->ID, 'user_count_follow', true);?>

	        <a style="text-decoration: none;color:#000;text-align: right;width: 30%;display: inline-block;" href="<?php echo home_url('/send-message'); ?>">Send Message</a>
	    </form>
	<?php } ?>
    </p>
    <div style=" clear: both"></div>
    <hr>
</div>
<div class="tab-all tab-style-three team-tabs">
<ul class="tabs-menu tabs-keep-history" data-target="#tab-contents">
                <li class="active"><a href="#author-news"><?php echo ucwords($curauth->display_name);?> News</a></li>
                <li><a href="#followers ">Followers </a></li>
                <li><a href="#reports">Reports</a></li>
 </ul>
  <div id="tab-contents" class="tab-content-wrap">
                <div id="author-news" class="tab-content active">
                   <?php   
			       		$post_per_pge = get_option('hlp_author_post_show',true);
			       		$hlp_ads_after_author_post = get_option('hlp_ads_after_author_post',true);
				      	$args = array(  
					        'post_type' => 'post',
					        'posts_per_page' => $post_per_pge, 
					        'author' =>  $curauth->ID,
					    );

					    $loop = new WP_Query( $args ); 
					    $i = '1';
					    while ( $loop->have_posts() ) : $loop->the_post();
					    	$author_teams = get_post_meta(get_the_ID(), 'reporter_team', true);
					    	if($i == $hlp_ads_after_author_post) {
					    ?>
					        <div class="news-section">
					        	<div class="news-img">
					        		<a href="<?= get_the_permalink($author_teams[0]); ?>">
					        			<img src="<?= get_the_post_thumbnail_url($post->ID); ?>" />
					        		</a>
					        	</div>
					        	<div class="news-details">
					        		<h1><a href="<?= get_the_permalink($author_teams[0]); ?>"><?= get_the_title(); ?></a></h1>
					        		<p><?php echo get_the_date('F j, Y');?></p>
					        	</div>
					        </div>
					        <?php 
	                            if(get_option('author_after_post_author_tab', true) == 'Yes'){
							        if(get_option('author_after_post_author_tab_desc', true)) {
							            echo get_option('author_after_post_author_tab_desc', true);
							        }
							    }
	                        ?>
							
					    <?php } else { ?> 
					    	<div class="news-section">
					        	<div class="news-img">
					        		<a href="<?= get_the_permalink($author_teams[0]); ?>">
					        			<img src="<?= get_the_post_thumbnail_url($post->ID); ?>" />
					        		</a>
					        	</div>
					        	<div class="news-details">
					        		<h1><a href="<?= get_the_permalink($author_teams[0]); ?>"><?= get_the_title(); ?></a></h1>
					        		<p><?php echo get_the_date('F j, Y');?></p>
					        	</div>
					        </div>
					    <?php } $i++; endwhile;

					    wp_reset_postdata();
				    ?> 
                </div>
                <div id="followers" class="tab-content">
                	<div class="follow-details">
	                   <?php  
	                   $show_follower =  get_option('hlp_follower_show', true);
	                   $Count = 0;
	                   foreach($follower as $follow) {
		                   	if($follow) {
			                   	$user_photo = get_user_meta($follow, 'user_photo', true);
							    if ($user_photo) {
							        $img = wp_get_attachment_image_src($user_photo, 'thumbnail');
							        $url = $img[0];
							        //$url = "https://www.fanzalive.co.uk/wp-content/uploads/profile-default.png";
							    } else {
							        $url = "https://www.fanzalive.co.uk/wp-content/uploads/profile-default.png";
							    }
						    ?>
						    <div class="author-followers">
						    	<img src="<?php echo $url;?>" />
		                   <?php
								$user = get_user_by( 'id', $follow );
								echo '<h1>'.ucwords($user->data->display_name).'</h1></div>';
								$Count++;
		               			if ($Count == $show_follower){
							        break; //stop foreach loop after 4th loop
							    }
	               			}
	               		}


					     ?>
					    
					</div>
                </div>
                 <div id="reports" class="tab-content">
                 	<table class="sp-event-blocks sp-data-table sp-paginated-table dataTable no-footer" data-sp-rows="15" id="DataTables_Table_0" role="grid">
						<tbody>
                 	<?php
                 		$reporter_show = get_option('hlp_reporters_show', true);
				      	$args_event = array(  
					        'post_type' => 'sp_event',
					        'posts_per_page' => $reporter_show, 
					        'meta_query' => array(
							       array(
							           'key' => '_reporter_home',
							           'value' => $curauth->ID,
							           'compare' => '=',
							       )
							   )
					    );
	                    $loop_event = new WP_Query( $args_event );
                        while ( $loop_event->have_posts() ) : $loop_event->the_post();
                        	$match_date = get_post_meta($post->ID, 'faaf_update_completed', true);
                			if ( ! isset( $id ) )
								$id = get_the_ID();

							$scrollable = get_option( 'sportspress_enable_scrollable_tables', 'yes' ) == 'yes' ? true : false;

							$data = array();

							if ( 'yes' === get_option( 'sportspress_event_show_date', 'yes' ) ) {
								$date = get_the_time( get_option('date_format'), $id );
								$data[ __( 'Date', 'sportspress' ) ] = $date;
							}

							if ( 'yes' === get_option( 'sportspress_event_show_time', 'yes' ) ) {
								$time = get_the_time( get_option('time_format'), $id );
								$data[ __( 'Time', 'sportspress' ) ] = apply_filters( 'sportspress_event_time', $time, $id );
							}

							$taxonomies = apply_filters( 'sportspress_event_taxonomies', array( 'sp_league' => null, 'sp_season' => null ) );

							foreach ( $taxonomies as $taxonomy => $post_type ):
								$terms = get_the_terms( $id, $taxonomy );
								if ( $terms ):
									$obj = get_taxonomy( $taxonomy );
									$term = array_shift( $terms );
									$data[ $obj->labels->singular_name ] = $term->name;
								endif;
							endforeach;

							if ( 'yes' === get_option( 'sportspress_event_show_day', 'yes' ) ) {
								$day = get_post_meta( $id, 'sp_day', true );
								if ( '' !== $day ) {
									$data[ __( 'Match Day', 'sportspress' ) ] = $day;
								}
							}

							if ( 'yes' === get_option( 'sportspress_event_show_full_time', 'yes' ) ) {
								$full_time = get_post_meta( $id, 'sp_minutes', true );
								if ( '' === $full_time ) {
									$full_time = get_option( 'sportspress_event_minutes', 90 );
								}
								$data[ __( 'Full Time', 'sportspress' ) ] = $full_time . '\'';
							}
							$data = apply_filters( 'sportspress_event_details', $data, $id );


						    $sdfsdf =  get_post_meta($post->ID, 'sp_results', true);

						        
							?>        	
                			<tr class="sp-row sp-post alternate odd" itemscope="" role="row">
								<td>						
									<time class="sp-event-date" itemprop="startDate">
										<a href="<?= get_the_permalink();?>" itemprop="url" content="<?= get_the_permalink();?>"><?= date('d-m-Y', strtotime($match_date));?></a>							
									</time>
									<h5 class="sp-event-results">
										<a href="<?= get_the_permalink();?>" itemprop="url" content="<?= get_the_permalink();?>">
											<?php 
												$goals = array();
												foreach($sdfsdf as $key => $sdfsd) {
													$goals[] = $sdfsd['goals'];	
										        }
												echo '<span class="sp-result ok">' . $goals[0] .'</span> - <span class="sp-result">' . $goals[1] .'</span>';
												
									        ?>
										</a>							
									</h5>
									<?php $i = 0; foreach( $data as $value ): if($i == '2') {?>
										<div class="sp-event-league"><?php echo $value; ?></div>
									<?php }elseif($i == '3') { ?>
										<div class="sp-event-season"><?php echo $value; ?></div>
									<?php } $i++; endforeach; ?>
									<h4 class="sp-event-title" itemprop="name">
										<a href="<?= get_the_permalink();?>"><?= get_the_title();?></a>	
									</h4>
								</td>
							</tr>
                        <?php endwhile;
                        wp_reset_postdata();
                        ?>
               			 </tbody>
					</table>
                </div>
            </div>


</div>

           <!--  <div>
                <div style="width: 60%; float: left" class="support-section">
                    <i class="fa fa-soccer-ball-o" aria-hidden="true"></i>&nbsp;&nbsp;Supports:
                    <?php
                    $args = array(
                        'post_type'=>'sp_team',
                        'post__in' => fanzalive_get_user_report_teams($curauth->ID)
                    );

                    $sp_teamss = get_posts($args);
                    foreach($sp_teamss as $sp_team){
                        ?>
                        <span style="color:#343838;"><?php echo $sp_team->post_title. '; ';?></span>
                    <?php }?>
                </div>
                <div style="width: 40%; float: left" class="viewer_section"><i class="fa fa-eye"></i> &nbsp;
                    <?php echo get_user_meta($curauth->ID, 'count_viewer', true). '  views';?>
                </div>
            </div> -->
        </div><!--.entry single-->
    </div><!--#primary-->
</div><!--#content-->
<?php get_footer(); ?>

