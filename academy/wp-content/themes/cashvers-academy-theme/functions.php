<?php
/**
 * Cashvers Academy Pro Theme Functions
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme setup
function cashvers_academy_pro_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo');
    add_theme_support('customize-selective-refresh-widgets');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'cashvers-academy-pro'),
        'footer' => __('Footer Menu', 'cashvers-academy-pro'),
    ));
}
add_action('after_setup_theme', 'cashvers_academy_pro_setup');

// Enqueue scripts and styles
function cashvers_academy_pro_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('cashvers-academy-pro-style', get_stylesheet_uri(), array(), '2.0.0');
    
    // Enqueue custom JavaScript
    wp_enqueue_script('cashvers-academy-pro-main', get_template_directory_uri() . '/js/main.js', array(), '2.0.0', true);
    
    // Enqueue comment reply script
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'cashvers_academy_pro_scripts');

// Reading time estimation
function estimate_reading_time() {
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // 200 words per minute
    return $reading_time;
}

// Remove WordPress version from head
remove_action('wp_head', 'wp_generator');

// Add custom body classes
function cashvers_academy_pro_body_classes($classes) {
    if (is_home()) {
        $classes[] = 'home-page';
    }
    if (is_single()) {
        $classes[] = 'single-post';
    }
    if (is_category()) {
        $classes[] = 'category-page';
    }
    return $classes;
}
add_filter('body_class', 'cashvers_academy_pro_body_classes');
