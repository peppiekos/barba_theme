<?php

if ( ! defined( '_PE_CHILD_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_PE_CHILD_VERSION', '1.0.0' );
}


add_action('init', 'pe_child_register_scripts');
function pe_child_register_scripts(){
    pe_theme_register_critical(get_stylesheet_directory().'/critical.min.css');
    pe_theme_register_style(get_stylesheet_directory_uri().'/style.min.css', _PE_CHILD_VERSION);
}

function child_scripts() {
	wp_enqueue_script( 'jquery-ui-accordion' );	
	wp_enqueue_script ( 'barba', '/wp-content/themes/pe-theme-child/js/barba.js', array('jquery'), _PE_CHILD_VERSION, true  );
	wp_enqueue_script ( 'gsap', '/wp-content/themes/pe-theme-child/js/gsap.js', array('barba'), _PE_CHILD_VERSION, true  );
	wp_enqueue_script ( 'main', '/wp-content/themes/pe-theme-child/js/main.js', array('gsap'), _PE_CHILD_VERSION, true  );	
}
add_action( 'wp_enqueue_scripts', 'child_scripts' );