<?php
/**
 * Moza Theme Customizer
 *
 * @package Moza
 */

//Sanitize Blog Layout Select Box
function moza_sanitize_style_select_box($value){ 
    if(!in_array($value, array('2','3'))){
        $value = '3';
    }
    return $value;
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function moza_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'moza_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'moza_customize_partial_blogdescription',
			)
		);
	}

	// Add Moza options section
	$wp_customize->add_section('moza_blog_options', array(
		'title'          => __('Blog Options', 'moza'),
		'capability'     => 'edit_theme_options',
		'description'    => __('Add blog section options', 'moza'),
		'priority'       => 20,
	));

	// Column Settings
    $wp_customize->add_setting('moza_column_settings', array(
        'default'           => '3',
        'capability'        => 'edit_theme_options',
        'type'              => 'theme_mod',
        'sanitize_callback' => 'moza_sanitize_style_select_box',
        'transport'         => 'refresh',
    ));
    $wp_customize->add_control('moza_column_settings_control', array(
        'label'             => esc_html__('Select blog column', 'moza'),
        'description'       => esc_html__('Select blog column from here.', 'moza'),
        'section'           => 'moza_blog_options',
        'settings'          => 'moza_column_settings',
        'type'              => 'select',
        'choices'           => array(
            '2'             => esc_html__('Two Column', 'moza'),
            '3'             => esc_html__('Three Column', 'moza'),
        ),
    ));


	$wp_customize->add_section('moza_social_options', array(
		'title'          => __('Social Options', 'moza'),
		'capability'     => 'edit_theme_options',
		'description'    => __('Add social section options', 'moza'),
		'priority'       => 21,

	));

	// Facebook Url
    $wp_customize->add_setting('fb_url', array(
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('fa_url_control', array(
        'label'      => __('Facebook Url', 'moza'),
        'description'=> __('Type your facebook profile link.', 'moza'),
        'section'    => 'moza_social_options',
        'settings'   => 'fb_url',
        'type'       => 'url',
    ));

	// Twitter Url
    $wp_customize->add_setting('tw_url', array(
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('tw_url_control', array(
        'label'      => __('Twitter Url', 'moza'),
        'description'=> __('Type your twitter profile link.', 'moza'),
        'section'    => 'moza_social_options',
        'settings'   => 'tw_url',
        'type'       => 'url',
    ));

	// Linkedin Url
    $wp_customize->add_setting('link_url', array(
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('link_url_control', array(
        'label'      => __('Linkedin Url', 'moza'),
        'description'=> __('Type your linkedin profile link.', 'moza'),
        'section'    => 'moza_social_options',
        'settings'   => 'link_url',
        'type'       => 'url',
    ));

	// instagram Url
    $wp_customize->add_setting('instagram_url', array(
        'capability'     => 'edit_theme_options',
        'type'           => 'theme_mod',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('instagram_url_control', array(
        'label'      => __('Instagram Url', 'moza'),
        'description'=> __('Type your instagram profile link.', 'moza'),
        'section'    => 'moza_social_options',
        'settings'   => 'instagram_url',
        'type'       => 'url',
    ));
}
add_action( 'customize_register', 'moza_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function moza_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function moza_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function moza_customize_preview_js() {
	wp_enqueue_script( 'moza-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'moza_customize_preview_js' );
require get_template_directory() . '/inc/moza-button/moza-customize.php';