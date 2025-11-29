<?php
/**
 * WooCommerce integration.
 */

// Ensure WooCommerce styles not fully disabled.
add_filter( 'woocommerce_enqueue_styles', 'linkshop_woocommerce_styles' );
function linkshop_woocommerce_styles( $styles ) {
    $styles['woocommerce-general']['deps'][] = 'linkshop-main';
    return $styles;
}

// Wrap shop content with container.
add_action( 'woocommerce_before_main_content', 'linkshop_wc_wrapper_start', 5 );
function linkshop_wc_wrapper_start() {
    echo '<div class="ls-container">';
}

add_action( 'woocommerce_after_main_content', 'linkshop_wc_wrapper_end', 50 );
function linkshop_wc_wrapper_end() {
    echo '</div>';
}

// Breadcrumb adjustments.
add_filter( 'woocommerce_breadcrumb_defaults', function( $defaults ) {
    $defaults['delimiter']   = ' / ';
    $defaults['wrap_before'] = '<nav class="ls-breadcrumb" aria-label="breadcrumb">';
    $defaults['wrap_after']  = '</nav>';
    return $defaults;
} );

// Products per page.
add_filter( 'loop_shop_per_page', function() {
    return 12;
}, 20 );

// Sale flash text.
add_filter( 'woocommerce_sale_flash', function( $html, $post, $product ) {
    return '<span class="onsale">' . __( 'تخفیف', 'linkshop' ) . '</span>';
}, 10, 3 );

// Mini tweaks for cart/checkout messages.
add_filter( 'woocommerce_add_to_cart_fragments', function( $fragments ) {
    ob_start();
    echo '<span class="ls-cart-count">' . WC()->cart->get_cart_contents_count() . '</span>';
    $fragments['span.ls-cart-count'] = ob_get_clean();
    return $fragments;
} );

// Remove downloads tab for physical products focus.
add_filter( 'woocommerce_product_data_tabs', function( $tabs ) {
    unset( $tabs['advanced'] );
    return $tabs;
} );
