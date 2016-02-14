<?php
$actions = array(
	'en' => '//app.mailerlite.com/webforms/landing/t9p4d9',
	'pt-br' => '//app.mailerlite.com/webforms/landing/a5p7v9',
	'de' => '//app.mailerlite.com/webforms/landing/o2a4z3',
);
if (array_key_exists(ICL_LANGUAGE_CODE, $actions)) {
	$action = $actions[ICL_LANGUAGE_CODE];
} else {
	$action = $actions['en'];
}
?>
<form action="<?php echo $action; ?>" method="post" class="newsletter" style="<?php
$image = get_sub_field( 'image' );
if ( $image ) {
  if ( is_array( $image ) )
    $image = $image['url'];
  echo "background-image: url(".f('img/pattern.png')."), url({$image});";
}
?>" target="_blank">
  <fieldset class="wrap">
    <legend class="heading"><?php the_sub_field('title') ?></legend>
    <input type="hidden" name="ml-submit" value="1">
    <input type="email" name="fields[email]" autocapitalize="off" autocorrect="off" placeholder="<?php the_sub_field('placeholder') ?>" aria-label="<?php the_sub_field('placeholder') ?>" required aria-required="true">
    <button type="submit" class="button"><?php the_sub_field('submit_label') ?></button>
  </fieldset>
</form>
