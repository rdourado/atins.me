<?php
/*
Template name: Flickr Gallery
*/
require_once( 'inc/phpFlickr.php' );
?>
<?php get_header() ?>
  <main class="main media">
    <?php while ( have_posts() ) : the_post(); ?>
    <div class="wrap">
      <?php breadcrumb() ?>
      <div class="header">
        <h1 class="heading"><?php the_title() ?></h1>
        <?php if (function_exists('sharing_display')) sharing_display('', true) ?>
        <?php get_template_part('partial', 'links') ?>
      </div>
      <?php

      $key = get_field('flickr_key');
      if (!$key) $key = '2926a701327d02571c68efacf6406bf0';
      $username = get_field('flickr_user');
      // $page = isset($_GET['page']) ? $_GET['page'] : 1;

      $f = new phpFlickr( $key );
      $f->enableCache( 'fs', TEMPLATEPATH . '/inc/cache' );

      $result = $f->people_findByUsername( $username );
      $nsid = $result['id'];
      // $photos = $f->people_getPublicPhotos( $nsid, NULL, NULL, 100, $page );
      $photos = $f->favorites_getPublicList( $nsid, NULL, NULL, NULL, NULL, NULL, $page );

      // $pages = $photos[photos][pages];
      // $total = $photos[photos][total];

      ?>
      <div class="content">
        <div class="gallery">
          <?php foreach ( $photos['photos']['photo'] as $photo ) : ?>
          <div class="gallery-item"><a href="<?php echo $f->buildPhotoURL($photo, 'large'); ?>" class="fancy" rel="photos"><img class="lazy" data-original="<?php echo $f->buildPhotoURL($photo, 'square_150'); ?>" alt="<?php echo $photo['title']; ?>"></a></div>
          <?php endforeach; ?>
        </div>
        <?php get_template_part('partial', 'links') ?>
      </div>
    </div>
    <?php endwhile; ?>
  </main>
<?php get_footer() ?>