<?php
/*
Template name: Region
*/
?>
<?php get_header() ?>
  <article class="main page">
    <?php while ( have_posts() ) : the_post(); ?>
    <div class="wrap">
      <?php breadcrumb() ?>
      <header class="header">
        <h1 class="heading"><?php the_title() ?></h1>
      </header>
      <div class="content">
        <?php if (function_exists('sharing_display')) sharing_display('', true) ?>
        <?php the_content() ?>
        <?php locations() ?>

        <?php if ( get_field('map_type') == 'gmaps' && get_field('gmaps') ) : ?>
          <div class="acf-map">
            <?php $location = get_field('gmaps'); ?>
            <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
          </div>

        <?php elseif ( get_field('map_type') == 'image' && get_field('image_file') ) : ?>
          <p>
            <?php if ( get_field('image_link') ) : ?>
              <a href="<?php the_field('image_link') ?>"><img src="<?php the_field('image_file') ?>" alt=""></a>
            <?php else : ?>
              <img src="<?php the_field('image_file') ?>" alt="">
            <?php endif; ?>
          </p>

        <?php elseif ( get_field('map_type') == 'code' && get_field('code') ) : ?>
          <div class="frame"><?php the_field('code') ?></div>
        <?php endif; ?>
        <?php if (function_exists('sharing_display')) sharing_display('', true) ?>
        <p class="copyright"><?php printf(__('© 2012 - %s - Atreídes Venturas Ltda, CNPJ 23.039.044/0001-20. Todos os direitos reservados.', 'atins'), date('Y')) ?></p>
      </div>
    </div>
    <?php endwhile; ?>
  </article>
<?php get_footer() ?>