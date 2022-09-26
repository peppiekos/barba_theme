<?php
/**
 * PE Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package PE_Theme
 */

if ( ! defined( '_PE_BASE_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_PE_BASE_VERSION', '1.0.0' );
}

if ( ! function_exists( 'pe_theme_setup' ) ) :

	function pe_theme_setup() {
		/*Translations can be filed in the /languages/ directory. */
		load_theme_textdomain( 'pe-theme', get_template_directory() . '/languages' );
		
		/*Let WordPress manage the document title. By adding theme support, we declare that this theme does not use a hard-coded <title> tag in the document head */
		add_theme_support( 'title-tag' );
		/* Enable support for Post Thumbnails on posts and pages. */
		add_theme_support( 'post-thumbnails' );
		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'pe-theme' ),
			)
		);
		/* Switch default core markup for search form, comment form, and comments to output valid HTML5.*/
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);
		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'pe_theme_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);
		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );
		/* Add support for core custom logo @link https://codex.wordpress.org/Theme_Logo */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		if(apply_filters('pe_theme_is_woocommerce', false)){
			add_theme_support( 'woocommerce' );
			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );
		}
	}
endif;
add_action( 'after_setup_theme', 'pe_theme_setup' );

/* Set the content width in pixels, based on the theme's design and stylesheet. @global int $content_width */
// function pe_theme_content_width() {
// 	$GLOBALS['content_width'] = apply_filters( 'pe_theme_content_width', 640 );
// }
// add_action( 'after_setup_theme', 'pe_theme_content_width', 0 );


/* Disable wordpress 6.0 styles and svg */
remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );

/* Disable Wordpress & Woocommerce blocks */
add_action( 'wp_enqueue_scripts', 'wps_deregister_styles', 100 );
function wps_deregister_styles() {
    wp_dequeue_style('wc-block-style');
    wp_dequeue_style('wc-blocks-style');
    wp_dequeue_style('wc-blocks-vendors-style');		
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
}
add_filter('use_block_editor_for_post_type', '__return_false', 10);

/* Disable base woo css */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/* Disable emojis for page speed */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );	
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/* Disable dashicons frontend*/
add_action( 'wp_enqueue_scripts', 'bs_dequeue_dashicons' );
function bs_dequeue_dashicons() {
    if ( ! is_user_logged_in() ) {
        wp_deregister_style( 'dashicons' );
    }
}

/* add defer to javascript files for page speed  */
function defer_parsing_of_js( $url , $handle) {
    if ( is_user_logged_in() ) return $url; //don't break WP Admin
    if ( FALSE === strpos( $url, '.js' ) ) return $url;
    if ( $handle == "jquery") return $url;
    return str_replace( 'src', ' defer src', $url );
}
add_filter( 'script_loader_tag', 'defer_parsing_of_js', 10, 3 );



// Load custom post types from child theme
if(file_exists(get_stylesheet_directory().'/custom_post_types.php'))
	require get_stylesheet_directory().'/custom_post_types.php';

// Shim for sites older than 5.2.
if ( ! function_exists( 'wp_body_open' ) ) :
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;


//Functions for child theme integration
class PE_ThemeConfig{
	public static $pe_theme_critical_css_location;
	public static $pe_theme_style_config;
	public static $javascripts = [];
}

function pe_theme_register_critical($location){
	PE_ThemeConfig::$pe_theme_critical_css_location = $location;
}
function pe_theme_register_style($location, $version){
	PE_ThemeConfig::$pe_theme_style_config = [
		'location' => $location,
		'version' => $version
	];
}
/* Inline critical CSS for page speed */
add_action('wp_head', 'pe_theme_critical_css');
function pe_theme_critical_css(){
	$location = PE_ThemeConfig::$pe_theme_critical_css_location;
	if(empty($location)) return;
    ?>
        <style><?=file_get_contents($location)?></style>
    <?php
}

/* Load main styles async for page speed */
function theme_async_css(){
	if(empty(PE_ThemeConfig::$pe_theme_style_config)) return;
	$location = PE_ThemeConfig::$pe_theme_style_config['location'];
	$version = PE_ThemeConfig::$pe_theme_style_config['version'];
	?>
		<link id="child-style" rel="stylesheet" href="<?=$location. '?ver='.$version?>" media="print" onload="this.media='all'; this.onload=null;"/>
	<?php
}
add_action('wp_head', 'theme_async_css');




add_filter('body_class', 'pe_theme_my_account_body_class', 10, 2);
function pe_theme_my_account_body_class($classes, $class){
	if (!class_exists( 'WooCommerce' )) return $classes;
    if(is_user_logged_in() && is_account_page() && !is_wc_endpoint_url())
        $classes[] = 'woocommerce-dashboard';
    if(!is_user_logged_in() && is_account_page())
        $classes[] = 'woocommerce-login';
    return $classes;
}

/* pe theme components */
function pe_theme_use_accordion(){
	PE_ThemeConfig::$javascripts[] = 'accordion';
}

function pe_theme_use_swiper(){
	PE_ThemeConfig::$javascripts[] = 'swiper';
}

add_action( 'wp_enqueue_scripts', 'pe_theme_load_scripts' );
function pe_theme_load_scripts(){
	if(in_array('accordion' ,PE_ThemeConfig::$javascripts))
		wp_enqueue_script( 'pe-accordion', get_template_directory_uri() . '/js/accordion.js', ['jquery'], _PE_BASE_VERSION, true );
	if(in_array('swiper' ,PE_ThemeConfig::$javascripts))
		wp_enqueue_script( 'swiper', get_template_directory_uri() . '/js/swiper.js', ['jquery'], _PE_BASE_VERSION, true );
}

function pe_theme_breadcrumbs(){
	if(function_exists('yoast_breadcrumb')){
		yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
		return;
	}
}

function pe_theme_sticky_checkout_page(){
	remove_action( 'woocommerce_checkout_shipping', array( WC_Checkout::instance(), 'checkout_form_shipping' ), 10);
	add_action( 'woocommerce_checkout_billing', array( WC_Checkout::instance(), 'checkout_form_shipping' ), 15);
	remove_action( 'woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20 );
	add_action( 'woocommerce_checkout_billing', 'woocommerce_checkout_payment', 20 );
	remove_action( 'woocommerce_checkout_order_review', 'woocommerce_order_review', 10 );
	add_action( 'woocommerce_checkout_shipping', 'woocommerce_order_review', 10 );
	add_action( 'woocommerce_checkout_shipping', function(){
		echo '<h3 id="order_review_heading">Jouw bestelling</h3>';
	}, 5);
}
