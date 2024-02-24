<?php
/**
 * Astra Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {

	wp_enqueue_style( 'astra-child-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_VERSION, 'all' );

}

add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );
// Limit Heartbeat API 
function limit_heartbeat() {
    wp_deregister_script('heartbeat');
}
add_action('init', 'limit_heartbeat', 1);
// Combine and Minify CSS and JavaScript Files
    function combine_and_minify_assets() {
        wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/custom.min.css');
        wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/custom.min.js', array('jquery'), null, true);
    }
    add_action('wp_enqueue_scripts', 'combine_and_minify_assets');
    // Force SSL/HTTPS
    if ($_SERVER['HTTPS'] !== 'on') {
        wp_redirect('https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], 301);
        exit();
    }
    // Optimize Comment Queries
function limit_comment_queries($comments) {
    if (is_single() && comments_open() && get_option('thread_comments')) {
        return get_comments(array('number' => 10)); // Change the number as needed
    }
    return $comments;
}
add_filter('comments_array', 'limit_comment_queries');
// Lazy Load comments 
function lazy_load_comments($content) {
    if (is_singular() && is_comments_popup()) {
        return $content;
    } elseif (is_singular() && comments_open() && get_option('thread_comments')) {
        return $content . get_comments_number();
    } else {
        return $content;
    }
}
add_filter('the_content', 'lazy_load_comments');