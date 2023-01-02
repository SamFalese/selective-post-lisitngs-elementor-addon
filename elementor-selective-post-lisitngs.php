<?php
/**
 * Plugin Name: Elementor Selective Post Lisitngs Widget
 * Description: Select posts and list on front end 
 * Version:     1.0.0
 * Author:      Vishal Soni
 * Text Domain: elementor-selective-post-lisitngs-widget
 *
 * Elementor tested up to: 3.5.0
 * Elementor Pro tested up to: 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Register Widget.
 *
 * Include widget file and register widget class.
 *
 * @author multanishebaz@gmail.com
 * @since 1.0.0
 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
 * @return void
 */
function register_oembed_widget( $widgets_manager ) {

	require_once( __DIR__ . '/widgets/selective-post-lisitngs-widget.php' );

	$widgets_manager->register( new \Elementor_Selective_Post_Lisitngs_Widget() );

}
add_action( 'elementor/widgets/register', 'register_oembed_widget' );