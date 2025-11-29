<?php
/**
 * SMS abstraction layer.
 */

function linkshop_send_sms( $event, $data ) {
    $message = sprintf( 'SMS Event: %s | Data: %s', $event, wp_json_encode( $data ) );
    if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
        error_log( $message );
    }

    // Placeholder for external API call.
    $endpoint = apply_filters( 'linkshop_sms_endpoint', '' );
    if ( ! empty( $endpoint ) ) {
        wp_remote_post( $endpoint, array(
            'timeout' => 10,
            'body'    => $data,
        ) );
    }
}

// WooCommerce hooks.
add_action( 'woocommerce_new_order', function( $order_id ) {
    $order = wc_get_order( $order_id );
    if ( ! $order ) {
        return;
    }

    linkshop_send_sms( 'order_created', array(
        'order_id' => $order_id,
        'phone'    => $order->get_billing_phone(),
        'message'  => sprintf( __( 'سفارش #%d ثبت شد.', 'linkshop' ), $order_id ),
    ) );
}, 10, 1 );

add_action( 'woocommerce_order_status_changed', function( $order_id, $old_status, $new_status ) {
    $order = wc_get_order( $order_id );
    if ( ! $order ) {
        return;
    }

    linkshop_send_sms( 'order_status_changed', array(
        'order_id'    => $order_id,
        'phone'       => $order->get_billing_phone(),
        'old_status'  => $old_status,
        'new_status'  => $new_status,
        'message'     => sprintf( __( 'وضعیت سفارش #%d به %s تغییر کرد.', 'linkshop' ), $order_id, wc_get_order_status_name( $new_status ) ),
    ) );
}, 10, 3 );

add_action( 'user_register', function( $user_id ) {
    $user = get_userdata( $user_id );
    if ( ! $user ) {
        return;
    }

    $phone = get_user_meta( $user_id, 'billing_phone', true );
    linkshop_send_sms( 'user_registered', array(
        'user_id' => $user_id,
        'phone'   => $phone,
        'message' => __( 'حساب کاربری شما ایجاد شد.', 'linkshop' ),
    ) );
} );

add_action( 'woocommerce_low_stock', function( $product ) {
    linkshop_send_sms( 'low_stock', array(
        'product_id' => $product->get_id(),
        'name'       => $product->get_name(),
        'stock'      => $product->get_stock_quantity(),
        'message'    => sprintf( __( 'هشدار کمبود موجودی: %s', 'linkshop' ), $product->get_name() ),
    ) );
} );

add_action( 'woocommerce_no_stock', function( $product ) {
    linkshop_send_sms( 'out_of_stock', array(
        'product_id' => $product->get_id(),
        'name'       => $product->get_name(),
        'message'    => sprintf( __( 'محصول ناموجود شد: %s', 'linkshop' ), $product->get_name() ),
    ) );
} );
