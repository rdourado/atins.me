<?php get_header() ?>
  <article class="main entry">
    <?php while ( have_posts() ) : the_post(); ?>
    <div class="wrap">
      <?php breadcrumb() ?>
      <header class="header">
        <h1 class="heading"><?php the_title() ?></h1>
        <time class="date">
          <?php _e('Published on', 'atins') ?>
          <?php the_time('d/m/Y') ?>
        </time>
        <?php if (function_exists('sharing_display')) sharing_display('', true) ?>
      </header>
      <div class="content">
        <?php the_content() ?>
        <?php the_tags( '<p class="tags">' . __('Related subjects: ', 'atins'), ', ', '</p>' ); ?>
        <?php if (function_exists('sharing_display')) sharing_display('', true) ?>
        <p class="copyright"><?php printf(__('© 2012 - %s - Atreídes Venturas Ltda, CNPJ 23.039.044/0001-20. Todos os direitos reservados.', 'atins'), date('Y')) ?></p>
        <div class="fb-comments" data-href="<?php the_permalink() ?>" data-numposts="5" data-width="100%"></div>
      </div>
      <footer class="footer">
        <?php previous_post_link( '%link', '<i class="caret alt"></i> %title', false ) ?>
        <?php next_post_link( '%link', '%title <i class="caret"></i>', false ) ?>
      </footer>
    </div>
    <?php endwhile; ?>
  </article>
<?php get_footer() ?>