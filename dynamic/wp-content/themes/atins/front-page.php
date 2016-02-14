<?php get_header() ?>
  <main class="main">
    <?php while ( have_rows( 'builder' ) ) : the_row(); ?>
    <?php get_template_part( 'layout', get_row_layout() ); ?>
    <?php endwhile; ?>
  </main>
<?php get_footer() ?>