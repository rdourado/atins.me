<div style="<?php thumbnail_bg('hor-2') ?>" class="item">
  <a href="<?php the_permalink() ?>">
    <div class="body">
      <h2 class="title"><?php the_title() ?></h2>
      <time class="date"><?php the_time('d/m/Y') ?></time>
      <?php the_excerpt() ?>
      <div class="button alt">
        <?php _e('More', 'atins') ?>
        <i class="caret"></i>
      </div>
    </div>
  </a>
</div>