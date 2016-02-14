<?php get_header() ?>
  <main class="main archive">
    <div class="wrap">
      <?php breadcrumb() ?>
      <div class="header">
        <h1 class="heading"><?php single_term_title('') ?></h1>
      </div>
      <div class="features alt" id="container">
        <?php while ( have_posts() ) : the_post(); ?>
          <?php get_template_part( 'content', 'directory' ) ?>
        <?php endwhile; ?>
      </div>
    </div>
  </main>
<?php get_footer() ?>