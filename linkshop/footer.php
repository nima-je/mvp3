<?php
/**
 * Footer template
 *
 * @package LinkShop
 */
?>
</main>
<footer class="site-footer">
    <div class="ls-container site-footer__inner">
        <div class="footer-branding">
            <p><?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?></p>
        </div>
        <nav class="footer-nav" aria-label="<?php esc_attr_e( 'منوی فوتر', 'linkshop' ); ?>">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer',
                'menu_class'     => 'menu',
                'container'      => false,
            ) );
            ?>
        </nav>
    </div>
    <div class="ls-container site-footer__bottom">
        <p><?php echo esc_html__( 'قدرت گرفته از لینک‌شاپ', 'linkshop' ); ?></p>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
