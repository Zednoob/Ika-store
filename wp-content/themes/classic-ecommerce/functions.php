<?php
/**
 * Classic Ecommerce functions and definitions
 *
 * @package Classic Ecommerce
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */

if ( ! function_exists( 'classic_ecommerce_setup' ) ) : 
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 */
function classic_ecommerce_setup() {
	global $content_width;   
	if ( ! isset( $content_width ) )
		$content_width = 680; 

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'woocommerce' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'custom-header', array( 
		'default-text-color' => false,
		'header-text' => false,
	) );
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 100,
		'flex-height' => true,
	) );	
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'classic-ecommerce' ),
	) );
	add_theme_support( 'custom-background', array(
		'default-color' => 'ffffff'
	) );
	add_editor_style( 'editor-style.css' );
} 
endif; // classic_ecommerce_setup
add_action( 'after_setup_theme', 'classic_ecommerce_setup' );

function classic_ecommerce_widgets_init() {
	register_sidebar( array( 
		'name'          => __( 'Blog Sidebar', 'classic-ecommerce' ),
		'description'   => __( 'Appears on blog page sidebar', 'classic-ecommerce' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget 1', 'classic-ecommerce' ),
		'description'   => __( 'Appears on footer', 'classic-ecommerce' ),
		'id'            => 'footer-1',
		'before_widget' => '<aside id="%1$s" class="ftr-4-box widget-column-1 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Widget 2', 'classic-ecommerce' ),
		'description'   => __( 'Appears on footer', 'classic-ecommerce' ),
		'id'            => 'footer-2',
		'before_widget' => '<aside id="%1$s" class="ftr-4-box widget-column-2 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Widget 3', 'classic-ecommerce' ),
		'description'   => __( 'Appears on footer', 'classic-ecommerce' ),
		'id'            => 'footer-3',
		'before_widget' => '<aside id="%1$s" class="ftr-4-box widget-column-3 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
	
	register_sidebar( array(
		'name'          => __( 'Footer Widget 4', 'classic-ecommerce' ),
		'description'   => __( 'Appears on footer', 'classic-ecommerce' ),
		'id'            => 'footer-4',
		'before_widget' => '<aside id="%1$s" class="ftr-4-box widget-column-4 %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h5>',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'classic_ecommerce_widgets_init' );

function classic_ecommerce_add_google_fonts() {
	wp_enqueue_style( 'classic-ecommerce-google-fonts', 'https://fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700|Montserrat:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap', false ); 
}
add_action( 'wp_enqueue_scripts', 'classic_ecommerce_add_google_fonts' );

function classic_ecommerce_scripts() {	
	wp_enqueue_style( 'bootstrap-css', esc_url(get_template_directory_uri())."/css/bootstrap.css" );
	wp_enqueue_style( 'classic-ecommerce-style', get_stylesheet_uri() );
	wp_style_add_data('classic-ecommerce-style', 'rtl', 'replace');
	wp_enqueue_style( 'owl.carousel', esc_url(get_template_directory_uri())."/css/owl.carousel.css" );
	wp_enqueue_style( 'classic-ecommerce-responsive', esc_url(get_template_directory_uri())."/css/responsive.css" );
	wp_enqueue_style( 'classic-ecommerce-default', esc_url(get_template_directory_uri())."/css/default.css" );
	wp_enqueue_script( 'bootstrap-js', esc_url(get_template_directory_uri()). '/js/bootstrap.js', array('jquery') );
	wp_enqueue_script( 'owl.carousel', esc_url(get_template_directory_uri()). '/js/owl.carousel.js', array('jquery') );
	wp_enqueue_script( 'classic-ecommerce-theme', esc_url(get_template_directory_uri()) . '/js/theme.js' );
	wp_enqueue_script( 'jquery.superfish', esc_url(get_template_directory_uri()) . '/js/jquery.superfish.js' );
	wp_enqueue_style( 'font-awesome', esc_url(get_template_directory_uri())."/css/fontawesome-all.css" );	
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'classic_ecommerce_scripts' );

function classic_ecommerce_ie_stylesheet(){
	wp_enqueue_style('classic-ecommerce_ie', esc_url(get_template_directory_uri()).'/css/ie.css', array('classic-ecommerce-style'), '20161202');
	wp_style_add_data('classic-ecommerce-ie','conditional','IE');
	}
add_action('wp_enqueue_scripts','classic_ecommerce_ie_stylesheet');

// Footer Link
define('CLASSIC_ECOMMERCE_FOOTER_LINK',__('https://www.theclassictemplates.com/themes/free-wordpress-ecommerce-template/','classic-ecommerce'));

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * PRO Button Link
 */
require_once( trailingslashit( get_template_directory() ) . 'inc/button-link/class-button-link.php' );

if ( ! function_exists( 'classic_ecommerce_the_custom_logo' ) ) :
/**
 * Displays the optional custom logo.
 *
 * Does nothing if the custom logo is not available.
 *
 */
function classic_ecommerce_the_custom_logo() {
	if ( function_exists( 'the_custom_logo' ) ) {
		the_custom_logo();
	}
}
endif;