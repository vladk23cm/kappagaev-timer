<?php
/**
* Plugin Name: Kappagave Timer
* Plugin URI: https://www.yourwebsiteurl.com/
* Description: This is the very first plugin I ever created.
* Version: 1.0
* Author: Vladk23cm
* Author URI: http://yourwebsiteurl.com/
**/

function timer_shortcode( $atts ){
	$time =  $atts['time'];
	$source = '<div class="countdown" time="'. $time .'">

			  <p class="timer">
			    <span class="days"></span>
			    <span class="hours"></span>
			    <span class="minutes"></span>
			    <span class="seconds"></span>
			  </p>
			</div>';
 	return $source;
}
add_shortcode('timer', 'timer_shortcode');


add_action( 'wp_enqueue_scripts', 'kappagev_timer_scripts' );
// add_action('wp_print_styles', 'theme_name_scripts'); // можно использовать этот хук он более поздний
function kappagev_timer_scripts() {
	wp_enqueue_style( 'timer-style', plugin_dir_url( __FILE__ ) . '/css/style.css' );
	wp_enqueue_script( 'kappagev-timer-script', plugin_dir_url( __FILE__ ) . '/js/main.js', array('jquery'), '1.0.0', true );
}