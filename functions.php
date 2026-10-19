<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'HOME', home_url( '/' ) );
define( 'T_DIRE', get_template_directory() );
define( 'S_DIRE', get_stylesheet_directory() );
define( 'T_DIRE_URI', get_template_directory_uri() );
define( 'S_DIRE_URI', get_stylesheet_directory_uri() );

require_once T_DIRE . '/inc/template-tags.php';
require_once T_DIRE . '/inc/seo.php';
require_once T_DIRE . '/inc/post-types.php';
require_once T_DIRE . '/inc/contact.php';
require_once T_DIRE . '/inc/seed.php';

add_action( 'after_setup_theme', 'fureasu_theme_setup' );
add_action( 'wp_enqueue_scripts', 'fureasu_enqueue_assets', 100 );
add_action( 'admin_enqueue_scripts', 'fureasu_enqueue_admin_assets' );
add_filter( 'user_can_richedit', 'fureasu_disable_page_visual_editor' );
add_filter( 'the_content', 'fureasu_disable_page_autop', 0 );
add_action( 'init', 'fureasu_disable_excerpt_autop' );
add_filter( 'the_content', 'fureasu_replace_image_paths' );
add_filter( 'upload_mimes', 'fureasu_allow_svg_uploads' );
add_filter( 'wp_terms_checklist_args', 'fureasu_term_checklist_args' );
add_filter( 'excerpt_length', 'fureasu_excerpt_length' );
add_filter( 'excerpt_more', 'fureasu_excerpt_more' );
add_filter( 'wpcf7_autop_or_not', '__return_false' );
add_filter( 'wpcf7_validate_configuration', '__return_false' );

function fureasu_theme_setup() {
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'thumbnail', 780, 516, true );
	add_editor_style( 'assets/font/fonts.css' );
	add_editor_style( 'assets/css/app.css' );
	add_editor_style( 'editor-style.css' );
}

function fureasu_enqueue_assets() {
	wp_enqueue_style( 'c-font', T_DIRE_URI . '/assets/font/fonts.css', array(), '1.0' );
	wp_enqueue_style( 'c-swiper-bundle', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11' );
	wp_enqueue_style( 'c-scroll-hint', 'https://unpkg.com/scroll-hint@latest/css/scroll-hint.css', array(), '1.0' );
	wp_enqueue_style( 'c-aos', 'https://unpkg.com/aos@2.3.0/dist/aos.css', array(), '2.3.0' );
	wp_enqueue_style( 'c-app', T_DIRE_URI . '/assets/css/app.css', array(), '1.2' );
	wp_enqueue_style( 'c-style', T_DIRE_URI . '/style.css', array(), '1.3' );
	wp_enqueue_style( 'c-theme', T_DIRE_URI . '/assets/css/theme.css', array(), '1.3' );

	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 's-jquery', T_DIRE_URI . '/assets/js/jquery.min.js', array(), '1.0', false );
	wp_enqueue_script( 's-swiper-bundle', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11', true );
	wp_enqueue_script( 's-scroll-hint', 'https://unpkg.com/scroll-hint@latest/js/scroll-hint.min.js', array(), '1.0', true );
	wp_enqueue_script( 's-aos', 'https://unpkg.com/aos@2.3.0/dist/aos.js', array(), '2.3.0', true );
	wp_enqueue_script( 's-app', T_DIRE_URI . '/assets/js/app.js', array(), '1.7', true );
	wp_enqueue_script( 's-theme', T_DIRE_URI . '/assets/js/theme.js', array(), '1.0', true );
}

function fureasu_enqueue_admin_assets() {
	wp_enqueue_script( 'theme-admin', T_DIRE_URI . '/admin/script.js', array( 'jquery' ), '1.0', true );
}

function fureasu_disable_page_visual_editor( $editor ) {
	global $typenow;
	if ( $typenow === 'page' ) {
		return false;
	}
	return $editor;
}

function fureasu_disable_page_autop( $content ) {
	if ( is_singular( 'page' ) ) {
		remove_filter( 'the_content', 'wpautop' );
	}
	return $content;
}

function fureasu_disable_excerpt_autop() {
	remove_filter( 'the_excerpt', 'wpautop' );
}

function fureasu_replace_image_paths( $content ) {
	$base = T_DIRE_URI . '/assets/image/';
	$pairs = array(
		'"images/'   => '"' . $base,
		'"/images/'  => '"' . $base,
		', images/'  => ', ' . $base,
		"('images/"  => "('" . $base,
	);
	return str_replace( array_keys( $pairs ), array_values( $pairs ), $content );
}

function fureasu_allow_svg_uploads( $mimes ) {
	if ( current_user_can( 'manage_options' ) ) {
		$mimes['svg'] = 'image/svg+xml';
	}
	return $mimes;
}

function fureasu_term_checklist_args( $args ) {
	$args['checked_ontop'] = false;
	if ( ! isset( $args['taxonomy'] ) || $args['taxonomy'] !== 'category' ) {
		return $args;
	}
	if ( ! empty( $args['walker'] ) && ! is_a( $args['walker'], 'Walker' ) ) {
		return $args;
	}
	if ( ! class_exists( 'Walker_Category_Checklist' ) ) {
		return $args;
	}
	if ( ! class_exists( 'Fureasu_Category_Radio_Walker' ) ) {
		class Fureasu_Category_Radio_Walker extends Walker_Category_Checklist {
			public function walk( $elements, $max_depth, ...$args ) {
				$output = parent::walk( $elements, $max_depth, ...$args );
				return str_replace(
					array( 'type="checkbox"', "type='checkbox'" ),
					array( 'type="radio"', "type='radio'" ),
					$output
				);
			}
		}
	}
	$args['walker'] = new Fureasu_Category_Radio_Walker();
	return $args;
}

function fureasu_excerpt_length() {
	return 100;
}

function fureasu_excerpt_more() {
	return '...';
}
