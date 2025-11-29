<?php
/**
 * Analytics helpers using WooCommerce data.
 */

if ( ! function_exists( 'linkshop_get_kpi_today_sales' ) ) {
    function linkshop_get_kpi_today_sales() {
        $orders = wc_get_orders( array(
            'status' => array( 'wc-completed', 'wc-processing' ),
            'limit'  => -1,
            'date_created' => array( strtotime( 'today' ), strtotime( 'tomorrow' ) ),
            'return' => 'ids',
        ) );

        $total = 0;
        foreach ( $orders as $order_id ) {
            $order  = wc_get_order( $order_id );
            $total += $order->get_total();
        }
        return $total;
    }
}

if ( ! function_exists( 'linkshop_get_kpi_month_sales' ) ) {
    function linkshop_get_kpi_month_sales() {
        $start = strtotime( 'first day of this month midnight' );
        $end   = strtotime( 'first day of next month midnight' );
        $orders = wc_get_orders( array(
            'status' => array( 'wc-completed', 'wc-processing' ),
            'limit'  => -1,
            'date_created' => array( $start, $end ),
            'return' => 'ids',
        ) );
        $total = 0;
        foreach ( $orders as $order_id ) {
            $order  = wc_get_order( $order_id );
            $total += $order->get_total();
        }
        return $total;
    }
}

if ( ! function_exists( 'linkshop_get_kpi_today_orders' ) ) {
    function linkshop_get_kpi_today_orders() {
        return wc_orders_count( 'today' );
    }
}

if ( ! function_exists( 'linkshop_get_kpi_month_orders' ) ) {
    function linkshop_get_kpi_month_orders() {
        $start = strtotime( 'first day of this month midnight' );
        $end   = strtotime( 'first day of next month midnight' );
        $orders = wc_get_orders( array(
            'status' => array_keys( wc_get_order_statuses() ),
            'limit'  => -1,
            'date_created' => array( $start, $end ),
            'return' => 'ids',
        ) );
        return count( $orders );
    }
}

if ( ! function_exists( 'linkshop_get_kpi_total_customers' ) ) {
    function linkshop_get_kpi_total_customers() {
        $user_query = new WP_User_Query( array(
            'role__in' => array( 'customer', 'subscriber' ),
            'fields'   => 'ID',
        ) );
        return $user_query->get_total();
    }
}

if ( ! function_exists( 'linkshop_get_kpi_new_customers_30d' ) ) {
    function linkshop_get_kpi_new_customers_30d() {
        $date = date( 'Y-m-d', strtotime( '-30 days' ) );
        $user_query = new WP_User_Query( array(
            'role__in'      => array( 'customer', 'subscriber' ),
            'fields'        => 'ID',
            'date_query'    => array(
                array(
                    'after' => $date,
                ),
            ),
        ) );
        return $user_query->get_total();
    }
}

function linkshop_get_recent_orders( $limit = 5 ) {
    return wc_get_orders( array(
        'limit'   => $limit,
        'orderby' => 'date',
        'order'   => 'DESC',
    ) );
}

function linkshop_get_low_stock_products( $limit = 5 ) {
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $limit,
        'meta_query'     => array(
            array(
                'key'     => '_stock',
                'value'   => wc_get_low_stock_amount(),
                'compare' => '<=',
                'type'    => 'NUMERIC',
            ),
        ),
    );
    return get_posts( $args );
}

function linkshop_get_best_sellers( $limit = 5 ) {
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => $limit,
        'meta_key'       => 'total_sales',
        'orderby'        => 'meta_value_num',
        'order'          => 'DESC',
    );
    return get_posts( $args );
}
