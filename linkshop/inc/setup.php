<?php
/**
 * Theme setup functions.
 */

if ( ! function_exists( 'linkshop_setup' ) ) {
    function linkshop_setup() {
        load_theme_textdomain( 'linkshop', get_template_directory() . '/languages' );

        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'custom-logo', array(
            'height'      => 80,
            'width'       => 240,
            'flex-height' => true,
            'flex-width'  => true,
        ) );

        add_theme_support( 'woocommerce', array(
            'thumbnail_image_width' => 400,
            'single_image_width'    => 800,
            'product_grid'          => array(
                'default_rows'    => 4,
                'min_rows'        => 2,
                'max_rows'        => 6,
                'default_columns' => 3,
                'min_columns'     => 2,
                'max_columns'     => 4,
            ),
        ) );

        add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

        register_nav_menus( array(
            'primary' => __( 'منوی اصلی', 'linkshop' ),
            'footer'  => __( 'منوی فوتر', 'linkshop' ),
        ) );

        add_editor_style( 'assets/css/main.css' );

        // RTL support.
        if ( function_exists( 'is_rtl' ) && is_rtl() ) {
            add_theme_support( 'rtl' );
        }
    }
}
add_action( 'after_setup_theme', 'linkshop_setup' );
