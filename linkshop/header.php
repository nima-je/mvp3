<?php
/**
 * Header template
 *
 * @package LinkShop
 */
?><!doctype html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
    <div class="ls-container site-header__inner">
        <div class="site-branding">
            <?php if ( has_custom_logo() ) { ?>
                <div class="site-logo"><?php the_custom_logo(); ?></div>
            <?php } else { ?>
                <div class="site-title">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a>
                </div>
                <p class="site-description"><?php bloginfo( 'description' ); ?></p>
            <?php } ?>
        </div>
        <nav class="primary-nav" aria-label="<?php esc_attr_e( 'منوی اصلی', 'linkshop' ); ?>">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'menu_class'     => 'menu',
                'container'      => false,
            ) );
            ?>
        </nav>
        <div class="header-actions">
            <?php if ( function_exists( 'wc_get_cart_url' ) ) : ?>
                <?php $cart_count = function_exists( 'WC' ) && WC()->cart ? WC()->cart->get_cart_contents_count() : 0; ?>
                <a class="cart-link" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
                    <span class="ls-cart-count"><?php echo intval( $cart_count ); ?></span>
                    <?php esc_html_e( 'سبد خرید', 'linkshop' ); ?>
                </a>
            <?php endif; ?>
            <a class="account-link" href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>"><?php esc_html_e( 'حساب کاربری', 'linkshop' ); ?></a>
        </div>
    </div>
</header>
<main class="site-main">
