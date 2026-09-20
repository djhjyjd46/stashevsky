<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue scripts and styles.
 */
function stashevsky_scripts() {
    $dist_dir = get_template_directory() . '/dist';
    $dist_uri = get_template_directory_uri() . '/dist';

    $style_file = $dist_dir . '/style.css';
    $script_file = $dist_dir . '/main.js';

    if ( file_exists( $style_file ) ) {
        wp_enqueue_style( 'stashevsky-style', $dist_uri . '/style.css', array(), filemtime( $style_file ) );
    }

    if ( file_exists( $script_file ) ) {
        wp_enqueue_script( 'stashevsky-main', $dist_uri . '/main.js', array(), filemtime( $script_file ), true );
    }
}
add_action( 'wp_enqueue_scripts', 'stashevsky_scripts' );

/**
 * ACF JSON Support
 */
add_filter('acf/settings/save_json', 'stashevsky_acf_json_save_point');
function stashevsky_acf_json_save_point( $path ) {
    $path = get_template_directory() . '/acf-json';
    return $path;
}

add_filter('acf/settings/load_json', 'stashevsky_acf_json_load_point');
function stashevsky_acf_json_load_point( $paths ) {
    unset($paths[0]);
    $paths[] = get_template_directory() . '/acf-json';
    return $paths;
}

/**
 * Theme Support
 */
function stashevsky_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
    add_theme_support( 'custom-logo' );

    register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'demetra' ),
		)
	);
}
add_action( 'after_setup_theme', 'stashevsky_setup' );

// Disable Admin Bar
add_filter('show_admin_bar', '__return_false');

/**
 * Safely output ACF content with decoded HTML entities
 */
function stashevsky_kses_post_decode( $text ) {
	$text = wp_kses_post( $text );
	$text = html_entity_decode( $text, ENT_QUOTES | ENT_HTML5, 'UTF-8' );
	return $text;
}

/**
 * ACF Options Page
 */
if( function_exists('acf_add_options_page') ) {
    acf_add_options_page(array(
        'page_title' 	=> 'Theme General Settings',
        'menu_title'	=> 'Theme Settings',
        'menu_slug' 	=> 'theme-general-settings',
        'capability'	=> 'edit_posts',
        'redirect'		=> false
    ));
}

/**
 * Image helpers: WebP generation + <picture> replacement
 */
require_once get_template_directory() . '/inc/image-helpers.php';
