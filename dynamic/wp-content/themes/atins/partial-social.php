<ul class="social">
  <?php $arr = array('facebook', 'googleplus', 'twitter', 'instagram', 'flickr', 'youtube', 'vimeo', 'tripadvisor'); ?>
  <?php foreach ( $arr as $item ) if ( get_field($item, 'option') ) : ?>
  <li class="menu-item"><a href="<?php the_field($item, 'option') ?>" class="icon-<?php echo $item; ?>" target="_blank"></a></li>
  <?php endif; ?>
  <!-- <li class="menu-item"><a href="<?php /*echo get_permalink(apply_filters('wpml_object_id', 4304, 'page', true));*/ ?>" target="_blank" class="icon-mail"></a></li> -->
</ul>