<?php
/**
 * LinkShop theme functions.
 *
 * @package LinkShop
 */

define( 'LINKSHOP_VERSION', '1.0.0' );

autoload_once();

/**
 * Load theme setup and helpers.
 */
function autoload_once() {
    $inc_path = get_template_directory() . '/inc';
    $files    = array(
        'setup.php',
        'customizer.php',
        'woocommerce-setup.php',
        'sms.php',
        'license.php',
        'analytics.php',
        'owner-dashboard.php',
    );

    foreach ( $files as $file ) {
        $full = $inc_path . '/' . $file;
        if ( file_exists( $full ) ) {
            require_once $full;
        }
    }
}

/**
 * Enqueue scripts and styles.
 */
function linkshop_enqueue_assets() {
    $theme_uri = get_template_directory_uri();

    wp_enqueue_style( 'linkshop-main', $theme_uri . '/assets/css/main.css', array(), LINKSHOP_VERSION );

    // RTL styles handled via CSS logical properties and body direction.
    wp_style_add_data( 'linkshop-main', 'rtl', 'replace' );

    wp_enqueue_script( 'linkshop-main', $theme_uri . '/assets/js/main.js', array( 'jquery' ), LINKSHOP_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'linkshop_enqueue_assets' );

/**
 * Set content width.
 */
function linkshop_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'linkshop_content_width', 1200 );
}
add_action( 'after_setup_theme', 'linkshop_content_width', 0 );

/**
 * Register widget areas.
 */
function linkshop_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'نوار کناری', 'linkshop' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'این ناحیه برای ابزارک‌های عمومی استفاده می‌شود.', 'linkshop' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'linkshop_widgets_init' );
