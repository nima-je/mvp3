<?php
/**
 * Theme Customizer additions.
 */

function linkshop_customize_register( $wp_customize ) {
    // Primary color setting.
    $wp_customize->add_setting( 'linkshop_primary_color', array(
        'default'           => '#e51f55',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'linkshop_primary_color', array(
        'label'    => __( 'رنگ اصلی', 'linkshop' ),
        'section'  => 'colors',
        'settings' => 'linkshop_primary_color',
    ) ) );
}
add_action( 'customize_register', 'linkshop_customize_register' );

/**
 * Output custom styles based on customizer settings.
 */
function linkshop_output_custom_styles() {
    $primary = get_theme_mod( 'linkshop_primary_color', '#e51f55' );
    if ( ! $primary ) {
        return;
    }
    echo '<style>:root{--ls-primary-color:' . esc_attr( $primary ) . ';}</style>' . "\n";
}
add_action( 'wp_head', 'linkshop_output_custom_styles' );
