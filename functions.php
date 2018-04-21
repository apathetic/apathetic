<?php
include_once('inc/general.php');			// set up and do the stuff
include_once('inc/helpers.php');
include_once('inc/types.php');

function apathetic_engage() {

	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('wp_print_styles', 'print_emoji_styles');

	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	
	if ( ! is_admin() ) {

		// scripts
		wp_deregister_script( 'l10n' );
		wp_deregister_script( 'jquery');
		wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', false, '1.7.1');
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'isotope', get_bloginfo('template_url').'/js/isotope.min.js', 'jquery' );
		wp_enqueue_script( 'lazyload', get_bloginfo('template_url').'/js/lazyload.min.js', 'jquery' );
		wp_enqueue_script( 'apathetic', get_bloginfo('template_url').'/js/apathetic.js', 'jquery' );

		// stylesheets
		wp_enqueue_style( 'style', get_bloginfo('stylesheet_url') );

	}

}
add_action( 'init', 'apathetic_engage' );



?>
