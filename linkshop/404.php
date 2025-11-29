<?php
/**
 * 404 template
 *
 * @package LinkShop
 */

get_header();
?>
<div class="ls-container ls-404">
    <h1><?php esc_html_e( 'صفحه یافت نشد', 'linkshop' ); ?></h1>
    <p><?php esc_html_e( 'متاسفانه صفحه‌ای که دنبال آن هستید وجود ندارد.', 'linkshop' ); ?></p>
    <a class="button button-primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'بازگشت به صفحه اصلی', 'linkshop' ); ?></a>
</div>
<?php
get_footer();
