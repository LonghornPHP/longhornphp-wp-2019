<?php

if ( ! function_exists( 'base_theme_setup' ) ) :
function base_theme_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );

	register_nav_menus( array(
		'primary' => esc_html__( 'Primary', 'base_theme' ),
		'home_buttons' => esc_html__( 'Home Page Buttons', 'base_theme' ),
	) );

	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	add_theme_support( 'customize-selective-refresh-widgets' );
}
endif;
add_action( 'after_setup_theme', 'base_theme_setup' );

function base_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'base_theme_content_width', 1200 );
}
add_action( 'after_setup_theme', 'base_theme_content_width', 0 );

function get_speakers_by_type($types = []) {
	$args = [
		'post_type' => 'speaker',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'order' => 'ASC',
		'orderby' => 'title',
		'tax_query' => ['relation' => 'OR'],
	];

	foreach ( $types as $type ) {
		$args['tax_query'][] = [
			'taxonomy' => 'speaker_type',
			'field' => 'slug',
			'terms' => $type,
		];
	}

	return get_posts( $args );
}

function fill_speakers_with_talks($speakers) {
	global $wpdb;

	// First, get the session IDs associated with the speakers
	$speaker_ids = array_map(function($speaker) {
		return $speaker->ID;
	}, $speakers);

	$query = 'SELECT post_id, meta_value from ' . $wpdb->prefix . 'postmeta ';
	$query .= 'WHERE meta_key = "speaker_session_relationship" ';
	$query .= 'AND meta_value != ""';
	$query .= 'AND post_id IN (' . implode(', ', array_fill(0, count($speaker_ids), '%d')) . ')';
	$results = $wpdb->get_results( $wpdb->prepare($query, $speaker_ids), ARRAY_A );
	$session_ids = [];
	foreach ($results as $result) {
		$session_ids[$result['post_id']] = unserialize($result['meta_value']);
	}
	$flattened_session_ids = empty($session_ids) ? [] : call_user_func_array('array_merge', $session_ids);

	$sessions = get_posts([
		'post_type' => 'session',
		'posts_per_page' => -1,
		'post__in' => $flattened_session_ids,
		'post_status' => 'publish',
	]);

	foreach ($speakers as $speaker) {
		$speaker->sessions = [];
	}

	foreach ($session_ids as $speaker_id => $speaker_session_ids) {
		foreach ($speakers as $speaker) {
			if ($speaker->ID === $speaker_id) {
				$speaker->sessions = array_filter($sessions, function($session) use ($speaker_session_ids) {
					if (in_array($session->ID, $speaker_session_ids)) {
						return true;
					}
				});
				break;
			}
		}
	}

	return $speakers;
}

function get_sessions_by_type($types = []) {
	$args = [
		'post_type' => 'session',
		'posts_per_page' => -1,
		'post_status' => 'publish',
		'order' => 'ASC',
		'orderby' => 'title',
		'tax_query' => ['relation' => 'OR'],
	];

	foreach ( $types as $type ) {
		$args['tax_query'][] = [
			'taxonomy' => 'session_type',
			'field' => 'slug',
			'terms' => $type,
		];
	}

	return get_posts( $args );
}

function fill_sessions_with_speakers($sessions) {
	if (!$sessions) {
		return $sessions;
	}

	global $wpdb;

	// First, get the speaker IDs associated with the sessions
	$session_ids = array_map(function($session) {
		return $session->ID;
	}, $sessions);

	$query = 'SELECT post_id, meta_value from ' . $wpdb->prefix . 'postmeta ';
	$query .= 'WHERE meta_key = "speaker_session_relationship" ';
	$query .= 'AND meta_value != ""';
	$query .= 'AND post_id IN (' . implode(', ', array_fill(0, count($session_ids), '%d')) . ')';
	$results = $wpdb->get_results( $wpdb->prepare($query, $session_ids), ARRAY_A );
	$speaker_ids = [];
	foreach ($results as $result) {
		$speaker_ids[$result['post_id']] = unserialize($result['meta_value']);
	}
	$flattened_speaker_ids = empty($speaker_ids) ? [] : call_user_func_array('array_merge', $speaker_ids);

	$speakers = get_posts([
		'post_type' => 'speaker',
		'posts_per_page' => -1,
		'post__in' => $flattened_speaker_ids,
		'post_status' => 'publish',
	]);

	foreach ($sessions as $session) {
		$session->speakers = [];
	}

	foreach ($speaker_ids as $session_id => $session_speaker_ids) {
		foreach ($sessions as $session) {
			if ($session->ID === $session_id) {
				$session->speakers = array_values(array_filter($speakers, function($speaker) use ($session_speaker_ids) {
					if (in_array($speaker->ID, $session_speaker_ids)) {
						return true;
					}
				}));
				break;
			}
		}
	}

	return $sessions;
}

function base_theme_widgets_init() {
	register_sidebar( array(
		'name'          => 'Primary Sidebar',
		'id'            => 'primary-sidebar',
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'base_theme_widgets_init' );

function modify_jquery() {
	if (!is_admin()) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js', [], null, true);
		wp_enqueue_script('jquery');
	}
}
add_action('init', 'modify_jquery');

/**
 * Enqueue scripts and styles.
 */
function base_theme_scripts() {
	$version = '20180321';
	$url = get_site_url();
	$webpack_paths = [];

	if (file_exists(get_template_directory() . '/mix-manifest.json')) {
		$webpack_paths = json_decode(file_get_contents(get_template_directory() . '/mix-manifest.json'), true);
	}

	if ( strpos( $url, '.test' ) !== false && file_exists( get_template_directory() . '/hot' ) ) {
		wp_enqueue_script( 'base_theme-main', '//localhost:8080/js/build/bundle.js', array( 'jquery' ), $version, true );
		wp_enqueue_style( 'base_theme-style', '//localhost:8080/css/style.css', array(), null );
	} else {
		foreach ($webpack_paths as $path) {
			if (strpos($path, '.js') === strlen($path) - 3) {
				wp_enqueue_script( 'base_theme-main', get_template_directory_uri() . $path, array( 'jquery' ), null, true );
			}
			if (strpos($path, '.css') === strlen($path) - 4) {
				wp_enqueue_style( 'base_theme-style', get_template_directory_uri() . $path, array(), null );
			}
		}
	}

	wp_enqueue_style( 'longhornphp-google-fonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,700|Lora:700' );

	if (is_page_template('page-templates/home.php') || is_page_template('page-templates/schedule.php')) {
		wp_enqueue_script( 'tito-js', 'https://js.tito.io/v1', [], null, true );
	}
}
add_action( 'wp_enqueue_scripts', 'base_theme_scripts' );

function lphp_menu_social_icons($items, $args) {
	$items = str_replace('>Facebook<', '><i title="Facebook" class="fab fa-facebook-f"></i><', $items);
	$items = str_replace('>Twitter<', '><i title="Twitter" class="fab fa-twitter"></i><', $items);
	$items = str_replace('>Wurstcon<', '><span class="hidden-accessible">Wurstcon </span>🌭<', $items);
	return $items;
}
add_filter( 'wp_nav_menu_items', 'lphp_menu_social_icons', 10, 2 );

function lphp_acf_init() {
	acf_add_options_page([
		'page_title' => 'Theme Options',
		'autoload' => true,
	]);

	acf_add_options_page([
		'page_title' => 'Schedule',
		'autoload' => true,
	]);
}
add_action( 'acf/init', 'lphp_acf_init' );

function lphp_get_sponsorship_tier_query($tier = '') {
	if (!$tier) {
		return null;
	}

	return [
		'posts_per_page' => 999,
		'post_type' => 'sponsor',
		'orderby' => 'title',
		'order' => 'ASC',
		'tax_query' => [[
			'taxonomy' => 'sponsorship_tier',
			'field' => 'slug',
			'terms' => $tier
		]]
	];
}

add_filter('acf/settings/remove_wp_meta_box', '__return_false');

function allow_svg_uploads($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter('upload_mimes', 'allow_svg_uploads');

add_filter( 'wpseo_metabox_prio', 'lower_yoast_priority' );
function lower_yoast_priority() {
	return 'low';
}

add_action( 'after_setup_theme', 'lphp_add_image_sizes' );
function lphp_add_image_sizes() {
	add_image_size( 'lphp-large-square', 600, 600, true );
	add_image_size( 'lphp-medium-square', 300, 300, true );
}

add_filter( 'gallery_style', 'lphp_add_gallery_classes');
function lphp_add_gallery_classes( $output ) {
	$output = str_replace('gallery-columns-5', 'gallery-columns-5 d-flex justify-content-start justify-content-lg-between flex-wrap', $output);
	return $output;
}

add_filter( 'lphp_post_content', 'wptexturize' );
add_filter( 'lphp_post_content', 'convert_smilies' );
add_filter( 'lphp_post_content', 'convert_chars' );
add_filter( 'lphp_post_content', 'wpautop' );
add_filter( 'lphp_post_content', 'shortcode_unautop' );
add_filter( 'lphp_post_content', 'do_shortcode' );

function lphp_get_stars_for_level($level) {
	$html = '';
	$counts = ['entry' => 1, 'intermediate' => 2, 'advanced' => 3];
	for ($i = 0; $i < ($counts[$level] ?? 0); $i++) {
		$html .= '<i class="fas fa-star"></i>';
	}

	return $html;
}

function img_lazify($img) {
	$img = str_replace('src=', 'data-src=', $img);
	$img = str_replace('srcset=', 'data-srcset=', $img);
	$img = str_replace('sizes=', 'data-sizes=', $img);

	return $img;
}

/**
 * Bootstrap menu walker
 */
require get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

require get_template_directory() . '/inc/acf-customizations.php';

require get_template_directory() . '/inc/sponsor-post-type.php';

require get_template_directory() . '/inc/speaker-post-type.php';

require get_template_directory() . '/inc/session-post-type.php';

require get_template_directory() . '/inc/invoice-post-type.php';
