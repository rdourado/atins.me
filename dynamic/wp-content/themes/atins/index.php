<?php get_header() ?>
  <main class="main blog">
    <div class="wrap">
      <?php breadcrumb() ?>
      <header class="header">
        <h1 class="heading"><?php _e('From the blog!', 'atins') ?></h1>
      </header>
      <div class="posts" id="container">
        <?php if (have_posts()) while ( have_posts() ) : the_post(); ?>
        <?php get_template_part('content') ?>
        <?php endwhile; ?>
      </div>
      <?php get_sidebar() ?>
    </div>
  </main>
<?php get_footer() ?>