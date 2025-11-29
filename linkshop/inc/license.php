<?php
/**
 * License management.
 */

const LINKSHOP_LICENSE_OPTION = 'linkshop_license_data';
const LINKSHOP_LICENSE_ENDPOINT = 'https://license.example.com/validate';

function linkshop_get_license_status() {
    $data = get_option( LINKSHOP_LICENSE_OPTION, array() );
    return wp_parse_args( $data, array(
        'key'          => '',
        'status'       => 'inactive',
        'last_checked' => '',
        'message'      => '',
    ) );
}

function linkshop_license_menu() {
    add_theme_page( __( 'لایسنس لینک‌شاپ', 'linkshop' ), __( 'لایسنس لینک‌شاپ', 'linkshop' ), 'manage_options', 'linkshop-license', 'linkshop_license_page' );
}
add_action( 'admin_menu', 'linkshop_license_menu' );

function linkshop_license_page() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    $status = linkshop_get_license_status();

    if ( isset( $_POST['linkshop_license_key'] ) && check_admin_referer( 'linkshop_save_license' ) ) {
        $key = sanitize_text_field( wp_unslash( $_POST['linkshop_license_key'] ) );
        $response = wp_remote_post( LINKSHOP_LICENSE_ENDPOINT, array(
            'timeout' => 10,
            'body'    => array(
                'license_key' => $key,
                'site_url'    => home_url(),
            ),
        ) );

        $status_message = '';
        $status_code    = 'inactive';

        if ( is_wp_error( $response ) ) {
            $status_message = __( 'عدم اتصال به سرور لایسنس. لطفا بعدا تلاش کنید.', 'linkshop' );
        } else {
            $body = wp_remote_retrieve_body( $response );
            $json = json_decode( $body, true );
            if ( isset( $json['status'] ) ) {
                $status_code    = sanitize_text_field( $json['status'] );
                $status_message = isset( $json['message'] ) ? sanitize_text_field( $json['message'] ) : '';
            } else {
                $status_message = __( 'پاسخ نامعتبر از سرور لایسنس.', 'linkshop' );
            }
        }

        $status = array(
            'key'          => $key,
            'status'       => $status_code,
            'last_checked' => current_time( 'mysql' ),
            'message'      => $status_message,
        );
        update_option( LINKSHOP_LICENSE_OPTION, $status );
        echo '<div class="updated"><p>' . esc_html__( 'وضعیت لایسنس به‌روزرسانی شد.', 'linkshop' ) . '</p></div>';
    }

    echo '<div class="wrap">';
    echo '<h1>' . esc_html__( 'مدیریت لایسنس لینک‌شاپ', 'linkshop' ) . '</h1>';
    echo '<form method="post">';
    wp_nonce_field( 'linkshop_save_license' );
    echo '<table class="form-table">';
    echo '<tr><th><label for="linkshop_license_key">' . esc_html__( 'کلید لایسنس', 'linkshop' ) . '</label></th>'; 
    echo '<td><input type="text" class="regular-text" id="linkshop_license_key" name="linkshop_license_key" value="' . esc_attr( $status['key'] ) . '" /></td></tr>';
    echo '<tr><th>' . esc_html__( 'وضعیت فعلی', 'linkshop' ) . '</th><td>' . esc_html( $status['status'] ) . '</td></tr>';
    echo '<tr><th>' . esc_html__( 'آخرین بررسی', 'linkshop' ) . '</th><td>' . esc_html( $status['last_checked'] ) . '</td></tr>';
    if ( ! empty( $status['message'] ) ) {
        echo '<tr><th>' . esc_html__( 'پیام', 'linkshop' ) . '</th><td>' . esc_html( $status['message'] ) . '</td></tr>';
    }
    echo '</table>';
    submit_button( __( 'فعال‌سازی لایسنس', 'linkshop' ) );
    echo '</form>';
    echo '</div>';
}

function linkshop_license_admin_notice() {
    $status = linkshop_get_license_status();
    if ( 'active' !== $status['status'] ) {
        echo '<div class="notice notice-warning"><p>' . esc_html__( 'لایسنس LinkShop فعال نیست. لطفا آن را در تنظیمات لایسنس بررسی کنید.', 'linkshop' ) . '</p></div>';
    }
}
add_action( 'admin_notices', 'linkshop_license_admin_notice' );
