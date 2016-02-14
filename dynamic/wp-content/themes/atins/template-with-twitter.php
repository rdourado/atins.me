<?php
/*
Template name: Page w/ Twitter
*/
if ( function_exists( 'wpcf7_enqueue_scripts' ) )
  wpcf7_enqueue_scripts();
?>
<?php get_header() ?>
  <?php while ( have_posts() ) : the_post(); ?>
  <article class="main page with-sidebar">
    <div class="wrap">
      <?php breadcrumb() ?>
      <header class="header">
        <h1 class="heading"><?php the_title() ?></h1>
      </header>
      <div class="content">
        <?php /*if ( has_post_thumbnail() ) :*/ ?>
          <!-- <p><?php /*the_post_thumbnail('hor-1')*/ ?></p> -->
        <?php /*endif;*/ ?>
        <?php the_content() ?>
      </div>
      <footer class="sidebar">
        <?php get_template_part( 'partial', 'twitter' ) ?>
      </footer>
    </div>
  </article>
  <?php endwhile; ?>
<?php get_footer() ?>