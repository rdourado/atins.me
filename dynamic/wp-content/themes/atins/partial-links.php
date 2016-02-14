<div class="links">
  <?php if ( get_field('flickr', 'option') ) : ?>
  <a href="<?php the_field('flickr', 'option') ?>" class="button alt pink">
    <i class="icon-flickr"></i><?php _e('More on Flickr', 'atins') ?>
  </a>
  <?php endif; ?>

  <?php if ( get_field('instagram', 'option') ) : ?>
  <a href="<?php the_field('instagram', 'option') ?>" class="button alt brown">
    <i class="icon-instagram"></i><?php _e('More on Instagram', 'atins') ?>
  </a>
  <?php endif; ?>
</div>