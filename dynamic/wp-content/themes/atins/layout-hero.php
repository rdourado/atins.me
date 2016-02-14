<div class="hero">
  <div class="list">
    <?php while ( have_rows('banners') ) : the_row(); ?>
    <div data-style="<?php image_bg('image') ?>" class="item">
      <a href="<?php the_sub_field('link') ?>#" style="color: <?php the_sub_field('color') ?>">
        <div class="wrap">
          <h1 class="heading"><?php the_sub_field('title') ?></h1>
          <p class="excerpt"><?php the_sub_field('excerpt') ?></p>
        </div>
      </a>
    </div>
    <?php endwhile; ?>
  </div>
</div>