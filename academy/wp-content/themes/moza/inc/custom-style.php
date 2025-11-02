<?php 
function moza_custom_css() {
    wp_enqueue_style('moza-custom', get_template_directory_uri() . '/assets/css/custom-style.css' );
    $header_text_color = get_header_textcolor();
    $moza_custom_css = '';
    $moza_custom_css .= '
        .site-title a,
        .site-description {
            color: #'.esc_attr( $header_text_color ).' ;
        }
    ';
    wp_add_inline_style( 'moza-custom', $moza_custom_css );
}
add_action( 'wp_enqueue_scripts', 'moza_custom_css' );