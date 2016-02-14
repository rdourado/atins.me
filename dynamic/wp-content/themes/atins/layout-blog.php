<section class="div">
  <div class="wrap">
    <h2 class="heading"><?php the_sub_field('title') ?></h2>
    <ul class="features">
      <?php $query = new WP_Query('posts_per_page=4') ?>
      <?php while ( $query->have_posts() ) : $query->the_post(); ?>
      <li style="<?php thumbnail_bg('ver-1') ?>" class="item">
        <a href="<?php the_permalink() ?>">
          <div class="body">
            <h3 class="title"><?php the_title() ?></h3>
            <?php excerpt() ?>
          </div>
        </a>
      </li>
      <?php endwhile; ?>
      <?php wp_reset_postdata() ?>
    </ul>
    <p class="txt-right">
      <a href="<?php page_for_posts() ?>" class="button">
        <?php the_sub_field('button_label') ?>
        <i class="caret"></i>
      </a>
    </p>
  </div>
</section>