<?php

// Instagram

$instagram_token   = trim(get_field('instagram_token', 'option'));
$instagram_user_id = trim(get_field('instagram_user_id', 'option'));
// $instagram_link    = trim(get_field('instagram_link', 'option'));
if (!$instagram_token) $instagram_token     = 'MY_TOKEN';
if (!$instagram_user_id) $instagram_user_id = 'MY_ID';
// if (!$instagram_link) $instagram_link       = 'http://instagram.com/rdourado/';

function fetchData($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 20);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

// $result = fetchData("https://api.instagram.com/v1/users/{$instagram_user_id}/media/recent/?access_token={$instagram_token}");
$result = fetchData("https://api.instagram.com/v1/tags/atins/media/recent/?access_token={$instagram_token}");
$result = json_decode($result);

?>
<footer class="sidebar">
	<?php get_template_part( 'partial', 'twitter' ); ?>

	<?php if ( $result->data ) : ?>
  <aside class="widget instagram">
    <h3 class="title"><i class="icon-instagram"></i><?php _e('Atins on Instagram', 'atins') ?></h3>
    <ol class="instagram-list">
    	<?php foreach ( array_slice($result->data, 0, 3) as $gram ) : ?>
    	<li><a href="<?php echo $gram->link; ?>" target="_blank"><img src="<?php echo $gram->images->low_resolution->url; ?>" alt=""></a></li>
	    <?php endforeach; ?>
    </ol>
    <a href="https://www.instagram.com/explore/tags/atins/" class="more"><i class="icon-instagram"></i><?php _e('More photos', 'atins') ?></a>
  </aside>
	<?php endif; ?>
</footer>