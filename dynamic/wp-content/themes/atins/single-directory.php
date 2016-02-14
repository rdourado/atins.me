<?php get_header() ?>
  <article class="main directory">
    <?php while ( have_posts() ) : the_post(); ?>
    <div class="wrap">
      <?php breadcrumb() ?>
      <header class="header">
        <h1 class="heading"><?php the_title() ?></h1>
      </header>
      <div class="content">
        <?php if (function_exists('sharing_display')) sharing_display('', true) ?>
        <?php the_content() ?>
        <?php if (get_field('map')) : ?>
          <div class="acf-map">
            <?php $location = get_field('map'); ?>
            <div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
          </div>
        <?php endif; ?>
      </div>
      <section class="sidebar">
        <div class="widget">
          <h3 class="title"><?php _e('Information', 'atins') ?></h3>
          <!-- <div id="trip-wrap"></div> -->
          <?php the_field( 'tripadvisor', $post->ID ); ?>
          <?php if ( get_field('contact_text') || get_field('contact_phones') ) : ?>
            <h4><?php _e('Contact', 'atins') ?></h4>
            <p>
              <?php the_field('contact_text') ?>
              <?php while ( have_rows('contact_phones') ) : the_row(); ?>
                <?php switch ( get_sub_field('type') ) { case 'phone' : ?>
                  <br><i class="icon-<?php the_sub_field('type') ?>"></i><?php the_sub_field('value') ?>
                <?php break; case 'skype' : ?>
                  <br><i class="icon-<?php the_sub_field('type') ?>"></i><a href="skype:<?php the_sub_field('value') ?>?call"><?php _e('Call via Skype', 'atins') ?></a>
                <?php break; case 'email' : ?>
                  <br><i class="icon-<?php the_sub_field('type') ?>"></i><a href="mailto:<?php the_sub_field('value') ?>"><?php the_sub_field('value') ?></a>
                <?php break; default : ?>
                  <br><i class="icon-<?php the_sub_field('type') ?>"></i><?php the_sub_field('value') ?>
                <?php break; } ?>
              <?php endwhile; ?>
            </p>
          <?php endif; ?>

          <?php if ( get_field('payment_text') || get_field('payment_cards') ) : ?>
            <h4><?php _e('Price', 'atins') ?></h4>
            <p>
              <?php the_field('payment_text') ?><br>
              <?php $field_obj = get_field_object('payment_cards'); ?>
              <?php if (get_field('payment_cards')) foreach ( get_field('payment_cards') as $card ) : ?>
                <img src="<?php echo f("img/{$card}.png"); ?>" alt="<?php echo $field_obj['choices'][$card]; ?>" width="26">
              <?php endforeach; ?>
            </p>
          <?php endif; ?>

          <?php if ( get_field('rooms') ) : ?>
            <h4><?php _e('Rooms', 'atins') ?></h4>
            <?php the_field('rooms'); ?>
          <?php endif; ?>

          <?php if ( get_field('size') ) : ?>
            <h4><?php _e('Size', 'atins') ?></h4>
            <?php the_field('size'); ?>
          <?php endif; ?>

          <?php if ( get_field('location') ) : ?>
            <h4><?php _e('Opening hours', 'atins') ?></h4>
            <?php the_field('location'); ?>
          <?php endif; ?>

          <?php if ( get_field('languages') ) : ?>
            <h4><?php _e('Languages', 'atins') ?></h4>
            <p>
              <?php $field_obj = get_field_object('languages'); ?>
              <?php $langs = array('en', 'pt-br', 'fr', 'de', 'it', 'es', 'da', 'nb', 'nl'); ?>
              <?php foreach ( $langs as $lang ) : ?>
                <?php if (in_array($lang, get_field('languages'))) { ?>
                  <img src="<?php echo f("img/{$lang}.png"); ?>" alt="<?php echo $field_obj['choices'][$lang]; ?>" width="26">
                <?php } ?>
              <?php endforeach; ?>
            </p>
          <?php endif; ?>

          <?php if ( get_field('amenities') ) : ?>
            <h4><?php _e('Amenities', 'atins') ?></h4>
            <ul>
              <?php $field_obj = get_field_object('amenities'); ?>
              <?php foreach ( get_field('amenities') as $item ) : ?>
                <li><i class="icon-<?php echo $item; ?>"></i><?php echo $field_obj['choices'][$item]; ?></li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>

          <?php $ok = false; $sites = array('link', 'facebook', 'googleplus', 'airbnb', 'booking', 'tripadvisor'); ?>
          <?php foreach ( $sites as $site ) if ( get_field("external_{$site}") ) $ok = true; ?>
          <?php if ( $ok ) : ?>
            <h4><?php _e('On the Web', 'atins') ?></h4>
            <p>
              <?php foreach ( $sites as $site ) if ( get_field("external_{$site}") ) : ?>
                <a href="<?php the_field("external_{$site}") ?>" class="icon-<?php echo $site; ?>" target="_blank"></a>
              <?php endif; ?>
            </p>
          <?php endif; ?>
        </div>
      </section>
    </div>
    <?php endwhile; ?>
  </article>
<?php get_footer() ?>