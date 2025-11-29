<?php
/**
 * Owner dashboard shortcode and hook.
 */

function linkshop_render_owner_dashboard() {
    if ( ! current_user_can( 'manage_woocommerce' ) && ! current_user_can( 'manage_options' ) ) {
        echo '<p>' . esc_html__( 'شما به این بخش دسترسی ندارید.', 'linkshop' ) . '</p>';
        return;
    }

    $today_sales   = linkshop_get_kpi_today_sales();
    $month_sales   = linkshop_get_kpi_month_sales();
    $today_orders  = linkshop_get_kpi_today_orders();
    $month_orders  = linkshop_get_kpi_month_orders();
    $total_customers = linkshop_get_kpi_total_customers();
    $new_customers   = linkshop_get_kpi_new_customers_30d();
    $recent_orders   = linkshop_get_recent_orders();
    $low_stock       = linkshop_get_low_stock_products();
    $best_sellers    = linkshop_get_best_sellers();
    $license         = linkshop_get_license_status();

    echo '<section class="ls-owner-dashboard">';
    echo '<h2>' . esc_html__( 'داشبورد صاحب فروشگاه', 'linkshop' ) . '</h2>';

    echo '<div class="ls-kpi-grid">';
    linkshop_dashboard_card( __( 'فروش امروز', 'linkshop' ), wc_price( $today_sales ) );
    linkshop_dashboard_card( __( 'فروش ماه', 'linkshop' ), wc_price( $month_sales ) );
    linkshop_dashboard_card( __( 'سفارش‌های امروز', 'linkshop' ), intval( $today_orders ) );
    linkshop_dashboard_card( __( 'سفارش‌های ماه', 'linkshop' ), intval( $month_orders ) );
    linkshop_dashboard_card( __( 'کل مشتریان', 'linkshop' ), intval( $total_customers ) );
    linkshop_dashboard_card( __( 'مشتریان ۳۰ روز اخیر', 'linkshop' ), intval( $new_customers ) );
    echo '</div>';

    echo '<div class="ls-flex-grid">';
    echo '<div class="ls-panel">';
    echo '<h3>' . esc_html__( 'سفارش‌های اخیر', 'linkshop' ) . '</h3>';
    if ( $recent_orders ) {
        echo '<ul class="ls-list">';
        foreach ( $recent_orders as $order ) {
            echo '<li>' . sprintf( '%s - %s - %s', esc_html( $order->get_order_number() ), esc_html( wc_price( $order->get_total() ) ), esc_html( wc_get_order_status_name( $order->get_status() ) ) ) . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>' . esc_html__( 'سفارشی وجود ندارد.', 'linkshop' ) . '</p>';
    }
    echo '</div>';

    echo '<div class="ls-panel">';
    echo '<h3>' . esc_html__( 'هشدار موجودی', 'linkshop' ) . '</h3>';
    if ( $low_stock ) {
        echo '<ul class="ls-list">';
        foreach ( $low_stock as $product ) {
            $stock = get_post_meta( $product->ID, '_stock', true );
            echo '<li>' . esc_html( get_the_title( $product ) ) . ' - ' . sprintf( __( 'موجودی: %s', 'linkshop' ), esc_html( $stock ) ) . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p>' . esc_html__( 'محصول کم موجودی یافت نشد.', 'linkshop' ) . '</p>';
    }
    echo '</div>';
    echo '</div>';

    echo '<div class="ls-flex-grid">';
    echo '<div class="ls-panel">';
    echo '<h3>' . esc_html__( 'پرفروش‌ها', 'linkshop' ) . '</h3>';
    if ( $best_sellers ) {
        echo '<ol class="ls-list">';
        foreach ( $best_sellers as $product ) {
            echo '<li>' . esc_html( get_the_title( $product ) ) . '</li>';
        }
        echo '</ol>';
    } else {
        echo '<p>' . esc_html__( 'داده‌ای موجود نیست.', 'linkshop' ) . '</p>';
    }
    echo '</div>';

    echo '<div class="ls-panel">';
    echo '<h3>' . esc_html__( 'وضعیت لایسنس', 'linkshop' ) . '</h3>';
    echo '<p>' . sprintf( __( 'وضعیت: %s', 'linkshop' ), esc_html( $license['status'] ) ) . '</p>';
    if ( ! empty( $license['message'] ) ) {
        echo '<p>' . esc_html( $license['message'] ) . '</p>';
    }
    echo '<p><a class="button" href="' . esc_url( admin_url( 'themes.php?page=linkshop-license' ) ) . '">' . esc_html__( 'مدیریت لایسنس', 'linkshop' ) . '</a></p>';
    echo '</div>';
    echo '</div>';

    echo '<div class="ls-panel">';
    echo '<h3>' . esc_html__( 'اقدامات سریع', 'linkshop' ) . '</h3>';
    echo '<div class="ls-actions">';
    echo '<a class="button button-primary" href="' . esc_url( admin_url( 'post-new.php?post_type=product' ) ) . '">' . esc_html__( 'افزودن محصول', 'linkshop' ) . '</a>';
    echo '<a class="button" href="' . esc_url( admin_url( 'edit.php?post_type=shop_order' ) ) . '">' . esc_html__( 'مشاهده سفارش‌ها', 'linkshop' ) . '</a>';
    echo '<a class="button" href="' . esc_url( wc_get_account_endpoint_url( 'orders' ) ) . '">' . esc_html__( 'حساب من', 'linkshop' ) . '</a>';
    echo '</div>';
    echo '</div>';

    echo '</section>';
}

function linkshop_dashboard_card( $title, $value ) {
    echo '<div class="ls-card">';
    echo '<p class="ls-card-title">' . esc_html( $title ) . '</p>';
    echo '<p class="ls-card-value">' . esc_html( $value ) . '</p>';
    echo '</div>';
}

function linkshop_owner_dashboard_shortcode() {
    ob_start();
    linkshop_render_owner_dashboard();
    return ob_get_clean();
}
add_shortcode( 'linkshop_owner_dashboard', 'linkshop_owner_dashboard_shortcode' );

function linkshop_owner_dashboard_account_block() {
    if ( current_user_can( 'manage_woocommerce' ) || current_user_can( 'manage_options' ) ) {
        linkshop_render_owner_dashboard();
    }
}
add_action( 'woocommerce_account_dashboard', 'linkshop_owner_dashboard_account_block', 5 );
