<?php
/**
 * Ecommerce Zone Theme Customizer
 *
 * @link: https://developer.wordpress.org/themes/customize-api/customizer-objects/
 *
 * @package Ecommerce Zone
 */

use WPTRT\Customize\Section\Ecommerce_Zone_Button;

add_action( 'customize_register', function( $manager ) {

    $manager->register_section_type( Ecommerce_Zone_Button::class );

    $manager->add_section(
        new Ecommerce_Zone_Button( $manager, 'ecommerce_zone_pro', [
            'title'       => __( 'Ecommerce Zone Pro', 'ecommerce-zone' ),
            'priority'    => 0,
            'button_text' => __( 'GET PREMIUM', 'ecommerce-zone' ),
            'button_url'  => esc_url( 'https://www.themagnifico.net/themes/ecommerce-wordpress-theme/', 'ecommerce-zone')
        ] )
    );

} );

// Load the JS and CSS.
add_action( 'customize_controls_enqueue_scripts', function() {

    $version = wp_get_theme()->get( 'Version' );

    wp_enqueue_script(
        'ecommerce-zone-customize-section-button',
        get_theme_file_uri( 'vendor/wptrt/customize-section-button/public/js/customize-controls.js' ),
        [ 'customize-controls' ],
        $version,
        true
    );

    wp_enqueue_style(
        'ecommerce-zone-customize-section-button',
        get_theme_file_uri( 'vendor/wptrt/customize-section-button/public/css/customize-controls.css' ),
        [ 'customize-controls' ],
        $version
    );

} );

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function ecommerce_zone_customize_register($wp_customize){
    $wp_customize->get_setting('blogname')->transport = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';

    if (isset($wp_customize->selective_refresh)) {
        // Site title
        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector' => '.site-title',
            'render_callback' => 'ecommerce_zone_customize_partial_blogname',
        ));
    }

    // Top Header
    $wp_customize->add_section('ecommerce_zone_social_info_block',array(
        'title' => esc_html__('Top Header','ecommerce-zone'),
        'description' => esc_html__('Topbar content','ecommerce-zone'),
    ));

    $wp_customize->add_setting('ecommerce_zone_phone_number_info',array(
        'default' => '',
        'sanitize_callback' => 'ecommerce_zone_sanitize_phone_number'
    )); 
    $wp_customize->add_control('ecommerce_zone_phone_number_info',array(
        'label' => esc_html__('Phone Number','ecommerce-zone'),
        'section' => 'ecommerce_zone_social_info_block',
        'setting' => 'ecommerce_zone_phone_number_info',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('ecommerce_zone_email_info',array(
        'default' => '',
        'sanitize_callback' => 'ecommerce_zone_sanitize_email'
    )); 
    $wp_customize->add_control('ecommerce_zone_email_info',array(
        'label' => esc_html__('Email Address','ecommerce-zone'),
        'section' => 'ecommerce_zone_social_info_block',
        'setting' => 'ecommerce_zone_email_info',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('ecommerce_zone_location_info',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    )); 
    $wp_customize->add_control('ecommerce_zone_location_info',array(
        'label' => esc_html__('Location','ecommerce-zone'),
        'section' => 'ecommerce_zone_social_info_block',
        'setting' => 'ecommerce_zone_location_info',
        'type'  => 'text'
    ));

    //Top Product Slider
    $wp_customize->add_section('ecommerce_zone_top_slider',array(
        'title' => esc_html__('Top Product Sale Slider','ecommerce-zone'),
        'description' => esc_html__('Here you have to add 3 different pages in below dropdown. Note: Image Dimensions 1200 x 400 px','ecommerce-zone')
    ));

    for ( $count = 1; $count <= 3; $count++ ) {

        $wp_customize->add_setting( 'ecommerce_zone_top_slider_page' . $count, array(
            'default'           => '',
            'sanitize_callback' => 'ecommerce_zone_sanitize_dropdown_pages'
        ) );
        $wp_customize->add_control( 'ecommerce_zone_top_slider_page' . $count, array(
            'label'    => __( 'Select Slide Page', 'ecommerce-zone' ),
            'section'  => 'ecommerce_zone_top_slider',
            'type'     => 'dropdown-pages'
        ) );
    }

    //Category Product
    $wp_customize->add_section('ecommerce_zone_cat_product',array(
        'title' => esc_html__('Top Category Product','ecommerce-zone'),
        'description' => esc_html__('Here you have to add 3 different pages in below dropdown. Note: Image Dimensions 260 x 160 px','ecommerce-zone')
    ));

    for ( $count = 1; $count <= 3; $count++ ) {

        $wp_customize->add_setting( 'ecommerce_zone_category_product_page' . $count, array(
            'default'           => '',
            'sanitize_callback' => 'ecommerce_zone_sanitize_dropdown_pages'
        ) );
        $wp_customize->add_control( 'ecommerce_zone_category_product_page' . $count, array(
            'label'    => __( 'Select category Page', 'ecommerce-zone' ),
            'section'  => 'ecommerce_zone_cat_product',
            'type'     => 'dropdown-pages'
        ) );
    }

    //Home Page Product Category
    $wp_customize->add_section('ecommerce_zone_home_product_category',array(
        'title' => esc_html__('Home Product Category','ecommerce-zone'),
        'description' => esc_html__('Here you have to select product category which will display perticular product category, products in the home page.','ecommerce-zone')
    ));

    $wp_customize->add_setting('ecommerce_zone_home_product_title',array(
        'default' => '',
        'sanitize_callback' => 'sanitize_text_field'
    )); 
    $wp_customize->add_control('ecommerce_zone_home_product_title',array(
        'label' => esc_html__('Section Title','ecommerce-zone'),
        'section' => 'ecommerce_zone_home_product_category',
        'setting' => 'ecommerce_zone_home_product_title',
        'type'  => 'text'
    ));

    $wp_customize->add_setting('ecommerce_zone_home_product_number',array(
        'default' => '',
        'sanitize_callback' => 'ecommerce_zone_sanitize_number_absint'
    ));
    $wp_customize->add_control('ecommerce_zone_home_product_number',array(
        'label' => __('No Of Products To Show','ecommerce-zone'),
        'section' => 'ecommerce_zone_home_product_category',
        'setting' => 'ecommerce_zone_home_product_number',
        'type'    => 'number'
    ));

    $args = array(
       'type'                     => 'product',
        'child_of'                 => 0,
        'parent'                   => '',
        'orderby'                  => 'term_group',
        'order'                    => 'ASC',
        'hide_empty'               => false,
        'hierarchical'             => 1,
        'number'                   => '',
        'taxonomy'                 => 'product_cat',
        'pad_counts'               => false
    );
    $categories = get_categories( $args );
    $cats = array();
    $i = 0;
    foreach($categories as $category){
        if($i==0){
            $default = $category->slug;
            $i++;
        } 
        $cats[$category->slug] = $category->name;
    }
    $wp_customize->add_setting('ecommerce_zone_home_product',array(
        'sanitize_callback' => 'ecommerce_zone_sanitize_select',
    ));
    $wp_customize->add_control('ecommerce_zone_home_product',array(
        'type'    => 'select',
        'choices' => $cats,
        'label' => __('Select Product Category','ecommerce-zone'),
        'section' => 'ecommerce_zone_home_product_category',
    ));

    // Footer
    $wp_customize->add_section('ecommerce_zone_site_footer_section', array(
        'title' => esc_html__('Footer', 'ecommerce-zone'),
    ));

    $wp_customize->add_setting('ecommerce_zone_footer_text_setting', array(
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('ecommerce_zone_footer_text_setting', array(
        'label' => __('Replace the footer text', 'ecommerce-zone'),
        'section' => 'ecommerce_zone_site_footer_section',
        'priority' => 1,
        'type' => 'text',
    ));
}
add_action('customize_register', 'ecommerce_zone_customize_register');

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function ecommerce_zone_customize_partial_blogname(){
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function ecommerce_zone_customize_partial_blogdescription(){
    bloginfo('description');
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function ecommerce_zone_customize_preview_js(){
    wp_enqueue_script('ecommerce-zone-customizer', esc_url(get_template_directory_uri()) . '/assets/js/customizer.js', array('customize-preview'), '20151215', true);
}
add_action('customize_preview_init', 'ecommerce_zone_customize_preview_js');