<?php
/**
 * This file contain the style/scripts and general theme settings.
 * @since 1.0.0
 */

/**
 * Load child theme CSS and optional Scripts
 *
 * @return void
 */
function mccain_enqueue_scripts() {

	/** * * * * 
	 * Styles
	 ** * * * */
	
	// Child theme style sheet for theme information
	wp_enqueue_style( 'mccain-style', MCCAIN_DIR_URI . 'style.css', array( 'hello-elementor-theme-style' ), MCCAIN	);

	// Main CSS file which holds most of the style for the site.
	wp_enqueue_style( 'mccain-main-css', MCCAIN_DIR_URI . 'assets/css/main.css', array(), MCCAIN );

	
	/** * * * * 
	 * Scripts
	 ** * * * */
	
	// iscroll for main navigation dropdown on mobiles.
	wp_enqueue_script( 'mccain-iscroll-js', MCCAIN_DIR_URI . 'assets/js/iscroll.min.js', array( 'jquery' ), MCCAIN, true );
	
	// McCain theme main JS file.
	wp_enqueue_script( 'mccain-main-js', MCCAIN_DIR_URI . 'assets/js/main.js', array( 'jquery' ), MCCAIN, true );

	// Enqueue addevent script https://www.addevent.com/documentation/add-to-calendar-button-for-calendars
	if ( is_singular( 'mccain-event' ) ){
		wp_enqueue_script( 'addevent', 'https://addevent.com/libs/atc/1.6.1/atc.min.js', array(), '1.6.1', true );
	}
	
}

add_action( 'wp_enqueue_scripts', 'mccain_enqueue_scripts', 200 );