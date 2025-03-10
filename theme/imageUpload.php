<?php

get_header();
require( ABSPATH . 'wp-admin/includes/image.php' );
$uploaddir = wp_upload_dir();
$travel_dirname = $uploaddir['basedir'] . '/tiny-imags';
if(!file_exists($travel_dirname)) wp_mkdir_p($travel_dirname);
$galArr = '';
$attach_id = '';
$array_img = array();
$temp = current($_FILES);
print_r($temp);
die();
exit;
  $filename = basename($_FILES, null);
  $extName = md5(time());
  $uploadfile = $travel_dirname .'/'.$extName.'-'. $filename;
  $contents= file_get_contents($gallry);
  $savefile = fopen($uploadfile, 'w');
  fwrite($savefile, $contents);
  fclose($savefile);
  $wp_filetype = wp_check_filetype(basename($filename), null );
  $attachment = array(
      'post_mime_type' => $wp_filetype['type'],
      'post_title' => $filename,
      'post_content' => '',
      'post_status' => 'inherit'
  );
  $attach_id = wp_insert_attachment( $attachment, $uploadfile );
  $galArr .= $attach_id.',';
  $array_img[] = $attach_id;
  $imagenew = get_post( $attach_id );
  $fullsizepath = get_attached_file( $imagenew->ID );
  $attach_data = wp_generate_attachment_metadata( $attach_id, $fullsizepath );
  wp_update_attachment_metadata( $attach_id, $attach_data );
