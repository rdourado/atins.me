<?php

require "inc/TwitterOAuth/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

$twitter_screen_name = trim(get_field('twitter_screen_name', 'option'));

if ( false === ( $tweets = get_transient( "tweets_{$twitter_screen_name}" ) ) ) {
  $twitter_customer_key        = trim(get_field('twitter_customer_key', 'option'));
  $twitter_customer_secret     = trim(get_field('twitter_customer_secret', 'option'));
  $twitter_access_token        = trim(get_field('twitter_access_token', 'option'));
  $twitter_access_token_secret = trim(get_field('twitter_access_token_secret', 'option'));
  if (!$twitter_customer_key)
    $twitter_customer_key        = 'MY_KEY';
  if (!$twitter_customer_secret)
    $twitter_customer_secret     = 'MY_SECRET';
  if (!$twitter_access_token)
    $twitter_access_token        = 'MY_TOKEN';
  if (!$twitter_access_token_secret)
    $twitter_access_token_secret = 'MY_TOKEN';
  if (!$twitter_screen_name)
    $twitter_screen_name         = 'MY_NAMES';

  $twitter = new TwitterOAuth($twitter_customer_key, $twitter_customer_secret, $twitter_access_token, $twitter_access_token_secret);
  $tweets = $twitter->get('statuses/user_timeline', array('screen_name' => $twitter_screen_name, 'exclude_replies' => 'true', 'include_rts' => 'false', 'count' => 3));

  if ( $twitter && !isset($tweets->errors) )
    set_transient( "tweets_{$twitter_screen_name}", $tweets, 3 * HOUR_IN_SECONDS );
}

function makeClickableLinks($s) {
  return preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a target="blank" rel="nofollow" href="$1" target="_blank">$1</a>', $s);
}

if ( !isset($tweets->errors) && count($tweets) ) : ?>

<aside class="widget twitter">
  <h3 class="title"><i class="icon-twitter"></i><?php _e('Atins on Twitter', 'atins') ?></h3>
  <ol class="tweets-list">
  	<?php foreach ( $tweets as $tweet ) : ?>
  	<li>
  		<a href="http://twitter.com/<?php echo $tweet->user->screen_name; ?>" target=""><img src="<?php echo $tweet->user->profile_image_url; ?>" alt=""></a>
  		<p><?php echo $tweet->text; ?></p>
  		<p><?php echo date_i18n( get_option('date_format'), strtotime($tweet->created_at) ); ?></p>
  	</li>
    <?php endforeach; ?>
  </ol>
  <a href="http://twitter.com/<?php echo $twitter_screen_name; ?>" target="_blank" class="more"><i class="icon-twitter"></i><?php _e('More Tweets', 'atins') ?></a>
</aside>

<?php endif; ?>
