<?php

$current_user = wp_get_current_user();
if (is_user_logged_in() && $current_user->ID == $post->post_author) : ?>
	<div class="acf-style">
		<?php comment_id_fields(); ?>
		<?php
		$fields =  array(
			'author' => '<div class="acf-text-input"><input type="text" id="acfname1000" name="author" class="required" value=""><label for="acfname1000">'.esc_html__('Your name','fanzalive').'</label></div>',
			'email'  => '<div class="acf-text-input"><input type="text" id="acfname2000" name="email" class="required" value=""><label for="acfname2000">'.esc_html__('Your email','fanzalive').'</label></div>'
		);
		$defaults = array(
		    'comment_field' => '<div class="acf-text-input"><textarea  id="acfname4000" rows="5" name="comment" class="required" ></textarea><label for="acfname4000">'.esc_html__('Add Update','fanzalive').'</label></div>',
		    'comment_notes_before' => '',
		    'comment_notes_after' => '',
		    'fields'  => apply_filters('comment_form_default_fields', $fields ),
		    'label_submit' => esc_html__('Submit','fanzalive'),
		    'title_reply' => '',
		    'cancel_reply_link'  => ''
		);
		comment_form($defaults);
		?>
	</div>
<?php endif; ?>

<?php if ( have_comments() ) : ?>
<div id="comments">
	<ol class="commentlist">
  		<?php wp_list_comments(array('callback' => 'fanzalive_comment')); ?>
 	</ol>
 	<div class="navigation">
  		<?php paginate_comments_links(); ?>
	</div>
</div>
<?php endif; ?>
