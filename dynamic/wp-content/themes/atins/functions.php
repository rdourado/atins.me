<?php

// require_once TEMPLATEPATH . '/inc/menu-item-custom-fields.php';

function breadcrumb() {
	if ( function_exists('yoast_breadcrumb') ) {
		yoast_breadcrumb( '<nav class="breadcrumb">', '</nav>' );
	}
}

function embed( $url ) {
	global $wp_embed;
	$embed = $wp_embed->run_shortcode("[embed]{$url}[/embed]");
	echo $embed;
}

function excerpt() {
	global $post;
	add_filter( 'excerpt_more', '_excerpt_more' );
	add_filter( 'excerpt_length', '_excerpt_length' );
	the_excerpt();
	remove_filter( 'excerpt_more', '_excerpt_more' );
	remove_filter( 'excerpt_length', '_excerpt_length' );
}

function _excerpt_more() {
	return '<br><em class="more">' . __('More', 'atins') . ' &gt;</em>';
}

function _excerpt_length() {
	return 20;
}

function f( $path ) {
	return get_template_directory_uri() . '/' . $path;
}

function ft( $path ) {
	return filemtime( TEMPLATEPATH . '/' . $path );
}

function image_bg( $field_name ) {
	global $post;
	$image = get_sub_field( $field_name );
	if ( $image ) {
		if ( is_array( $image ) )
			$image = $image['url'];
		echo "background-image: url({$image});";
	}
}

function lang_code() {
	switch ( ICL_LANGUAGE_CODE ) {
	 	case 'pt-br': return 'pt_BR'; break;
	 	case 'de': return 'de_DE'; break;
	 	case 'fr': return 'fr_FR'; break;
	 	case 'it': return 'it_IT'; break;
	 	case 'es': return 'es_LA'; break;
	 	default: return 'en_US'; break;
	 }
}

function language_selector() {
	$languages = icl_get_languages();
	if ( ! empty($languages) ) {
		echo '<ul class="lang">';
		foreach ( $languages as $l ) {
			$css = array('menu-item', 'lang-' . $l['code']);
			if ( ICL_LANGUAGE_CODE === $l['code'] ) $css[] = 'current';
			echo '<li class="' . implode(' ', $css) . '">';
			if ( ! $l['active'] ) echo '<a href="' . $l['url'] . '">';
			// echo $l['native_name'];
			echo '<img src="' . $l['country_flag_url'] . '" alt="' . $l['language_code'] . '">';
			if ( ! $l['active'] ) echo '</a>';
			echo '</li>';
		}
		echo '</ul>';
	}
}

function locations() {
	global $post;
	$query = new WP_Query( "post_type=page&posts_per_page=6&post_parent={$post->ID}" );
	if ( $query->have_posts() ) {
		echo '<ul class="locations">';
		while ( $query->have_posts() ) {
			$query->the_post();
			?><li style="<?php thumbnail_bg('ver-1') ?>" class="item">
			<a href="<?php the_permalink() ?>"><p class="title"><?php the_title() ?></p></a>
			</li><?php
		}
		echo '</ul>';
	}
	wp_reset_postdata();
}

function logo() {
	$link = home_url( '/' );
	$logo = f('img/logo@2x.png');
	$name = get_bloginfo( 'name' );
	$tag  = is_front_page() ? 'h1' : 'div';
	echo "<{$tag} class='logo'><a href='{$link}'><img src='{$logo}' alt='{$name}' width='213'></a></{$tag}>";
}

function menu( $theme_location = 'menu', $depth = 3 ) {
	wp_nav_menu( array(
		'theme_location' 	=> $theme_location,
		'menu_class' 			=> $theme_location,
		'depth' 					=> $depth,
		'container' 			=> '',
		'fallback_cb' 		=> false,
	) );
}

function page_for_posts() {
	echo get_permalink( get_option( 'page_for_posts' ) );
}

function the_thumb_src( $size = 'thumbnail' ) {
	global $post;
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), $size );
	echo $thumb[0];
}

function thumbnail_bg( $size = 'full' ) {
	global $post;
	$thumb_id = get_post_thumbnail_id( $post->ID );
	if ( ! $thumb_id ) return;
	$thumb_obj = wp_get_attachment_image_src( $thumb_id, $size );
	if ( ! $thumb_obj ) return;
	echo 'background-image: url(' . $thumb_obj[0] . ')';
}

// Setup

define( 'ICL_DONT_LOAD_LANGUAGES_JS', 				 true );
define( 'ICL_DONT_LOAD_NAVIGATION_CSS', 			 true );
define( 'ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true );

add_action( 'after_setup_theme', 'atins_setup' );
add_action( 'init', 'wpc_head_cleanup' );

function atins_setup() {
	load_theme_textdomain( 'atins', get_template_directory() . '/languages' );

	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails', array('post', 'page', 'directory') );
	add_theme_support( 'infinite-scroll', array(
		'type'           => 'scroll',
		'container'      => 'container',
		'render'         => 'my_infinite_scroll_render',
		'posts_per_page' => 8,
		'footer'         => 'footer',
	) );

	add_image_size( 'hor-1', 952, 350, true );
	add_image_size( 'hor-2', 682, 266, true );
	add_image_size( 'ver-1', 225, 375, true );
	add_image_size( 'prop-4-3', 250, 187, true );
	set_post_thumbnail_size( 225, 375, true );

	register_nav_menus( array(
		'menu' => __('Primary Menu', 'atins'),
	) );

	if ( ! function_exists('acf_add_options_page') ) return;
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Social Media Settings',
		'menu_title'	=> 'Social Links',
		'parent_slug'	=> 'options-general.php',
	));
}

function my_infinite_scroll_render() {
	while( have_posts() ) {
		the_post();
		get_template_part( 'content', get_post_type() );
	}
}

function wpc_head_cleanup() {
	add_filter( 'wpcf7_load_css', '__return_false' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
}

// Scripts & Styles

add_action( 'init', 'modify_jquery' );
add_action( 'wp_enqueue_scripts', 'atins_scripts' );
add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

function modify_jquery() {
	if ( !is_admin() ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', '//code.jquery.com/jquery-2.2.0.min.js', false, null, true );
		wp_enqueue_script( 'jquery' );
	}
}

function atins_scripts() {
	global $post, $sitepress, $sitepress_settings;
	// CSS
	wp_enqueue_style( 'atins-style', f('css/style.css'), array(), ft('css/style.css') );

	// JS - Redirect
	$languages = $sitepress->get_ls_languages( array(
		'skip_missing' => intval( true )
	) );
	$language_urls = array();

	foreach( $languages as $language ) {
		if ( isset( $language['default_locale'] ) && $language['default_locale'] ) {
			$language_urls[ $language['default_locale'] ] = $language['url'];
			$language_parts = explode( '_', $language['default_locale'] );
			if ( count( $language_parts ) > 1 )
				foreach ( $language_parts as $language_part )
					if ( ! isset( $language_urls[$language_part] ) )
						$language_urls[$language_part] = $language['url'];
		}
		$language_urls[ $language['language_code'] ] = $language['url'];
  }

	$http_host = $_SERVER['HTTP_HOST'] == 'localhost' ? '' : $_SERVER['HTTP_HOST'];
	$cookie = array(
		'name'       => '_icl_visitor_lang_js',
		'domain'     => (defined('COOKIE_DOMAIN') && COOKIE_DOMAIN ? COOKIE_DOMAIN : $http_host),
		'path'       => (defined('COOKIEPATH') && COOKIEPATH ? COOKIEPATH : '/'),
		'expiration' => $sitepress_settings['remember_language'],
	);
	$params = array(
		'pageLanguage' => defined('ICL_LANGUAGE_CODE') ? ICL_LANGUAGE_CODE : get_bloginfo('language'),
		'languageUrls' => $language_urls,
		'cookie'       => $cookie,
	);
	wp_register_script( 'browser-redirect', f('js/redirect.js'), array(), ft('js/redirect.js') );
  wp_localize_script( 'browser-redirect', 'browser_redirect_params', $params );
  wp_enqueue_script( 'browser-redirect' );

	// JS - Scripts
	wp_register_script( 'atins-script', f('js/scripts.js'), array('jquery'), ft('js/scripts.js'), true );
	// if ( is_singular( 'directory' ) ) {
	// 	$code = get_field( 'tripadvisor', $post->ID );
	// 	if ( $code )
	// 		wp_localize_script( 'atins-script', 'tripadvisor', json_encode($code) );
	// }
	wp_enqueue_script( 'atins-script' );

	// JS - Maps
	if ( is_singular('directory') || is_page_template('template-region.php') ) {
		wp_enqueue_script( 'gmaps-api', 'https://maps.googleapis.com/maps/api/js?v=3.exp', array('jquery'), null, true );
		wp_enqueue_script( 'atins-gmaps', f('js/gmaps.js'), array('jquery', 'gmaps-api'), ft('js/gmaps.js'), true );
	}
}

// Filters

add_filter( 'excerpt_more', 'new_excerpt_more' );
add_filter( 'embed_defaults', 'change_embed_size' );
add_filter( 'shortcode_atts_gallery', 'my_atts_gallery' );
add_filter( 'infinite_scroll_js_settings', 'filter_jetpack_infinite_scroll_js_settings' );
add_filter( 'acf/fields/wysiwyg/toolbars' , 'my_toolbars'  );
add_action( 'loop_start', 'remove_jetpack_share' );

function new_excerpt_more( $more ) {
	return '…';
}

function change_embed_size() {
	return array( 'width' => 853, 'height' => 480 );
}

function my_atts_gallery( $out ) {
	global $post;
	$out['link'] = 'file';
	if ( is_singular( 'directory' ) || is_page_template( 'template-with-sidebar.php' ) || is_page_template( 'template-with-twitter.php' ) ) {
		$out['columns'] = 4;
		$out['size']    = 'thumbnail';
	} else {
		$out['columns'] = 3;
		$out['size']    = 'prop-4-3';
	}
	return $out;
}

function filter_jetpack_infinite_scroll_js_settings( $settings ) {
	$settings['text'] = __('+ Posts', 'atins');
	return $settings;
}

function my_toolbars( $toolbars ) {
	// var_dump($toolbars);die();
	$tools = array('underline', 'blockquote', 'strikethrough', 'bullist', 'numlist', 'undo', 'redo', 'fullscreen');
	foreach ( $tools as $i => $value ) {
		if ( ($key = array_search($value, $toolbars['Basic'][1])) !== false ) {
			unset( $toolbars['Basic'][1][$key] );
		}
	}
	array_push( $toolbars['Basic'], array('formatselect') );
	return $toolbars;
}

function remove_jetpack_share() {
	remove_filter( 'the_content', 'sharing_display', 19 );
	remove_filter( 'the_excerpt', 'sharing_display', 19 );
}

// Shortcodes

add_shortcode( 'box', 'shortcode_box' );
add_shortcode( 'bus', 'shortcode_bus' );
add_shortcode( 'jeep', 'shortcode_jeep' );
add_shortcode( 'boat', 'shortcode_boat' );
add_shortcode( 'taxi', 'shortcode_taxi' );
add_shortcode( 'minibus', 'shortcode_minibus' );

function shortcode_box( $atts, $content = '' ) {
	extract( shortcode_atts( array(
		'title'   => __('Bus', 'atins'),
		'icon'    => 'none',
		'css'     => 'gray',
		'color'   => '',
		'bgcolor' => '',
	), $atts ) );

	$style = '';
	if ($color) $style .= "color:{$color};border-color:{$color};";
	if ($bgcolor) $style .= "background-color:{$bgcolor};";
	if ($style != '') $style = "style='{$style}'";

	$html  = "<div class='box {$css}' {$style}>";
	$html .= "<h3 class='title'><i class='icon-{$icon}'></i>{$title}</h3>";
	$html .= wpautop( $content );
	$html .= "</div>";

	return $html;
}

function shortcode_bus( $atts, $content = '' ) {
	$atts = shortcode_atts( array(
		'title' => __('Bus', 'atins'),
		'icon'  => 'bus',
		'css'   => 'green',
	), $atts );
	return shortcode_box( $atts, $content );
}

function shortcode_taxi( $atts, $content = '' ) {
	$atts = shortcode_atts( array(
		'title' => __('Taxi', 'atins'),
		'icon'  => 'taxi',
		'css'   => 'yellow',
	), $atts );
	return shortcode_box( $atts, $content );
}

function shortcode_jeep( $atts, $content = '' ) {
	$atts = shortcode_atts( array(
		'title' => __('4x4', 'atins'),
		'icon'  => 'jeep',
		'css'   => 'yellow',
	), $atts );
	return shortcode_box( $atts, $content );
}

function shortcode_boat( $atts, $content = '' ) {
	$atts = shortcode_atts( array(
		'title' => __('Boat', 'atins'),
		'icon'  => 'boat',
		'css'   => 'gray',
	), $atts );
	return shortcode_box( $atts, $content );
}

function shortcode_minibus( $atts, $content = '' ) {
	$atts = shortcode_atts( array(
		'title' => __('Minibus', 'atins'),
		'icon'  => 'minibus',
		'css'   => 'green',
	), $atts );
	return shortcode_box( $atts, $content );
}

// Custom Menu

/*add_filter( 'nav_menu_link_attributes', 'my_nav_menu_link', 10, 4 );

function my_nav_menu_link( $atts, $item, $args, $depth ) {
	if ( isset( $item->ID ) ) {
		$hook = get_post_meta( $item->ID, 'menu-item-hook', true );
		if ( $hook ) $atts['href'] .= "#{$hook}";
	}
	return $atts;
}

class Menu_Item_Target {

	protected static $fields = array();

	public static function init() {
		add_action( 'wp_nav_menu_item_custom_fields', array( __CLASS__, '_fields' ), 10, 4 );
		add_action( 'wp_update_nav_menu_item', array( __CLASS__, '_save' ), 10, 3 );
		add_filter( 'manage_nav-menus_columns', array( __CLASS__, '_columns' ), 99 );

		self::$fields = array(
			'hook' => 'Target (#)',
		);
	}

	public static function _save( $menu_id, $menu_item_db_id, $menu_item_args ) {
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) return;

		check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );

		foreach ( self::$fields as $_key => $label ) {
			$key = sprintf( 'menu-item-%s', $_key );

			if ( ! empty( $_POST[ $key ][ $menu_item_db_id ] ) ) {
				$value = sanitize_title( $_POST[ $key ][ $menu_item_db_id ] );
			} else {
				$value = null;
			}

			// Update
			if ( ! is_null( $value ) ) {
				update_post_meta( $menu_item_db_id, $key, $value );
			} else {
				delete_post_meta( $menu_item_db_id, $key );
			}
		}
	}

	public static function _fields( $id, $item, $depth, $args ) {
		foreach ( self::$fields as $_key => $label ) :
			$key   = sprintf( 'menu-item-%s', $_key );
			$id    = sprintf( 'edit-%s-%s', $key, $item->ID );
			$name  = sprintf( '%s[%s]', $key, $item->ID );
			$value = get_post_meta( $item->ID, $key, true );
			$class = sprintf( 'field-%s', $_key );
			?>
				<p class="description description-wide <?php echo esc_attr( $class ) ?>">
					<?php printf(
						'<label for="%1$s">%2$s<br /><input type="text" id="%1$s" class="widefat %1$s" name="%3$s" value="%4$s" /></label>',
						esc_attr( $id ),
						esc_html( $label ),
						esc_attr( $name ),
						esc_attr( $value )
					) ?>
				</p>
			<?php
		endforeach;
	}

	public static function _columns( $columns ) {
		$columns = array_merge( $columns, self::$fields );
		return $columns;
	}

}
Menu_Item_Target::init();*/

// Admin

add_action( 'admin_head', 'my_custom_admin_css' );

function my_custom_admin_css() {
?><style>
#add_box_howto,
.metabox-prefs label[for="add_box_howto-hide"] {
	display: none !important;
}
</style><?php
}