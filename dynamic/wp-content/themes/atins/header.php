<!DOCTYPE html>
<html <?php language_attributes( 'html' ) ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head() ?>
  <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/img/favicon.ico">
</head>
<body>
<?php if (is_single()) : ?>
  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/<?php echo lang_code(); ?>/sdk.js#xfbml=1&version=v2.5&appId=1693281130957312";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>
<?php endif; ?>
  <header class="head">
    <div class="wrap">
      <?php logo() ?>
      <?php get_template_part( 'partial', 'social' ) ?>
    </div>
    <nav id="menu" class="nav">
      <div class="wrap"><a href="#menu" class="toggle-on"><span></span><span></span><span></span></a><a href="#" class="toggle-off"><span></span><span></span></a>
        <form action="<?php echo home_url( '/' ); ?>" method="get" class="search">
          <fieldset>
            <input type="search" name="s" required aria-required="true" placeholder="<?php _e('Search', 'atins') ?>" aria-label="<?php _e('Search', 'atins') ?>" value="<?php the_search_query() ?>">
            <button type="submit"><?php _e('Ok', 'atins') ?></button>
          </fieldset>
        </form>
        <?php menu() ?>
        <?php language_selector() ?>
      </div>
    </nav>
  </header>
  <hr>
