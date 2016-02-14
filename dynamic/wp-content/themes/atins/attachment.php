<?php

global $post;

$file = get_attached_file( $post->ID );
header( 'Content-Type:' . $post->post_mime_type );
header( 'Content-Length: ' . filesize($file) );
readfile( $file );