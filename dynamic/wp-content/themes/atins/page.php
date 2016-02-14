<?php get_header() ?>
  <?php while ( have_posts() ) : the_post(); ?>
  <article class="main page">
    <div class="wrap">
      <?php breadcrumb() ?>
      <header class="header">
        <h1 class="heading"><?php the_title() ?></h1>
      </header>
      <div class="content">
        <?php /*if ( has_post_thumbnail() ) :*/ ?>
          <!-- <p><?php /*the_post_thumbnail('hor-1')*/ ?></p> -->
        <?php /*endif;*/ ?>
        <?php if (function_exists('sharing_display')) sharing_display('', true) ?>
        <?php the_content() ?>
        <?php if (function_exists('sharing_display')) sharing_display('', true) ?>
        <p class="copyright"><?php printf(__('© 2012 - %s - Atreídes Venturas Ltda, CNPJ 23.039.044/0001-20. Todos os direitos reservados.', 'atins'), date('Y')) ?></p>
      </div>
    </div>
  </article>
  <?php endwhile; ?>
<?php get_footer() ?>