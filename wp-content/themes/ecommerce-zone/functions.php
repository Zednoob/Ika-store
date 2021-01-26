<?php
/**
 * Ecommerce Zone functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Ecommerce Zone
 */

include get_theme_file_path( 'vendor/wptrt/autoload/src/Ecommerce_Zone_Loader.php' );

$ecommerce_zone_loader = new \WPTRT\Autoload\Ecommerce_Zone_Loader();

$ecommerce_zone_loader->ecommerce_zone_add( 'WPTRT\\Customize\\Section', get_theme_file_path( 'vendor/wptrt/customize-section-button/src' ) );

$ecommerce_zone_loader->ecommerce_zone_register();

if ( ! function_exists( 'ecommerce_zone_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ecommerce_zone_setup() {

		add_theme_support( 'woocommerce' );
		
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

        add_image_size('ecommerce-zone-featured-header-image', 2000, 660, true);

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus( array(
            'primary' => esc_html__( 'Primary','ecommerce-zone' ),
	        'footer'=> esc_html__( 'Footer Menu','ecommerce-zone' ),
        ) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'ecommerce_zone_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 50,
			'width'       => 50,
			'flex-width'  => true,
		) );

		add_editor_style( array( '/editor-style.css' ) );

		add_theme_support( 'align-wide' );
	}
endif;
add_action( 'after_setup_theme', 'ecommerce_zone_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ecommerce_zone_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ecommerce_zone_content_width', 1170 );
}
add_action( 'after_setup_theme', 'ecommerce_zone_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ecommerce_zone_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'ecommerce-zone' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Add widgets here.', 'ecommerce-zone' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'Home Sidebar', 'ecommerce-zone' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Add widgets here.', 'ecommerce-zone' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h5 class="widget-title">',
		'after_title'   => '</h5>',
	) );
}
add_action( 'widgets_init', 'ecommerce_zone_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ecommerce_zone_scripts() {
    // load bootstrap css
    wp_enqueue_style( 'flatly-css', esc_url(get_template_directory_uri()) . '/assets/css/flatly.css');

    wp_enqueue_style( 'ecommerce-zone-block-editor-style', get_theme_file_uri('/assets/css/block-editor-style.css') );

	// fontawesome
	wp_enqueue_style( 'fontawesome', esc_url(get_template_directory_uri()).'/assets/css/fontawesome/css/all.css' );

	wp_enqueue_style( 'owl.carousel', esc_url(get_template_directory_uri()).'/assets/css/owl.carousel.css' );

    wp_enqueue_style( 'ecommerce-zone-style', get_stylesheet_uri() );

    wp_enqueue_script('jquery-js', esc_url(get_template_directory_uri()) . '/assets/js/jquery.js', array(), '', true );

    wp_enqueue_script('owl.carousel', esc_url(get_template_directory_uri()) . '/assets/js/owl.carousel.js', array(), '', true );

    wp_enqueue_script('ecommerce-zone-theme-js', esc_url(get_template_directory_uri()) . '/assets/js/theme-script.js', array(), '', true );
    
    wp_enqueue_script('ecommerce-zone-skip-link-focus-fix', esc_url(get_template_directory_uri()) . '/assets/js/skip-link-focus-fix.js', array(), '20151215', true);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ecommerce_zone_scripts' );

function ecommerce_zone_styles() {
	if ( !class_exists( 'Theme_Font' ) ) {
		wp_enqueue_style( 'theme-font', 'https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i', array(), null );
	}
}
add_action( 'enqueue_block_editor_assets', 'ecommerce_zone_styles' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/*dropdown page sanitization*/
function ecommerce_zone_sanitize_dropdown_pages( $page_id, $setting ) {
	// Ensure $input is an absolute integer.
	$page_id = absint( $page_id );
	// If $page_id is an ID of a published page, return it; otherwise, return the default.
	return ( 'publish' == get_post_status( $page_id ) ? $page_id : $setting->default );
}

/*radio button sanitization*/
function ecommerce_zone_sanitize_choices( $input, $setting ) {
    global $wp_customize; 
    $control = $wp_customize->get_control( $setting->id ); 
    if ( array_key_exists( $input, $control->choices ) ) {
        return $input;
    } else {
        return $setting->default;
    }
}

//select sanitization function
function ecommerce_zone_sanitize_select( $input, $setting ){
  
    //input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
    $input = sanitize_key($input);

    //get the list of possible select options 
    $choices = $setting->manager->get_control( $setting->id )->choices;
                      
    //return input if valid or return default option
    return ( array_key_exists( $input, $choices ) ? $input : $setting->default );                
      
}

function ecommerce_zone_sanitize_number_absint( $number, $setting ) {
	// Ensure $number is an absolute integer (whole number, zero or greater).
	$number = absint( $number );
	
	// If the input is an absolute integer, return it; otherwise, return the default
	return ( $number ? $number : $setting->default );
}

function ecommerce_zone_sanitize_phone_number( $phone ) {
	return preg_replace( '/[^\d+]/', '', $phone );
}

function ecommerce_zone_sanitize_email( $email, $setting ) {
	// Strips out all characters that are not allowable in an email address.
	$email = sanitize_email( $email );
	
	// If $email is a valid email, return it; otherwise, return the default.
	return ( ! is_null( $email ) ? $email : $setting->default );
}

/**
 * Fix skip link focus in IE11.
 *
 * This does not enqueue the script because it is tiny and because it is only for IE11,
 * thus it does not warrant having an entire dedicated blocking script being loaded.
 *
 * @link https://git.io/vWdr2
 */
function ecommerce_zone_skip_link_focus_fix() {
	?>
	<script>
	/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",function(){var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())},!1);
	</script>
	<?php
}
add_action( 'wp_print_footer_scripts', 'ecommerce_zone_skip_link_focus_fix' );