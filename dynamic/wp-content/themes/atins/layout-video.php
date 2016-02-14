<section class="videos div">
  <div class="wrap">
    <h2 class="heading"><?php the_sub_field('title') ?></h2>
    <p class="frame"><?php embed( get_sub_field('video') ) ?></p>
    <p class="txt-right">
      <?php if ( get_sub_field('show_youtube') && get_field('youtube', 'option') ) : ?>
      <a href="<?php the_field('youtube', 'option') ?>" class="button" target="_blank"><?php the_sub_field('youtube_label') ?> <img src="<?php echo f('img/youtube.png'); ?>" alt="Youtube" width="73" height="30"></a>
      <?php endif; ?>
      <?php if ( get_sub_field('show_vimeo') && get_field('vimeo', 'option') ) : ?>
      <a href="<?php the_field('vimeo', 'option') ?>" class="button" target="_blank"><?php the_sub_field('vimeo_label') ?> <img src="<?php echo f('img/vimeo.png'); ?>" alt="Vimeo" width="56" height="30"></a>
      <?php endif; ?>
  </div>
</section>