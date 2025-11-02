<?php
/**
 * Moza Blog functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Moza Blog
 */

if ( ! defined( 'MOZA_BLOG_VERSION' ) ) {
	$moza_blog_theme = wp_get_theme();
	define( 'MOZA_BLOG_VERSION', $moza_blog_theme->get( 'Version' ) );
}


/**
 * Enqueue scripts and styles.
 */
function moza_blog_scripts() {
    wp_enqueue_style( 'moza-blog-parent-style', get_template_directory_uri() . '/style.css',array('bootstrap','slicknav','moza-default-block','moza-style'), '', 'all');
    wp_enqueue_style( 'moza-blog-main-style',get_stylesheet_directory_uri() . '/assets/css/main-style.css',array('main-style'), MOZA_BLOG_VERSION, 'all');
}
add_action( 'wp_enqueue_scripts', 'moza_blog_scripts' );

/**
 * Load Moza Blog Tags files.
 */
require get_stylesheet_directory() . '/inc/customizer.php';

/**
 * Load Moza Blog Tags files.
 */
require get_stylesheet_directory() . '/inc/template-tags.php';