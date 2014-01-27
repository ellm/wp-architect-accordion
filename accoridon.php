<?php
/**
 * @package wp_arch_accord
 * @version 1.0
 */
/*
Plugin Name: WP Architect Accordion
Description: Accordion Plugin for WP Architect Theme. Uses jQuery UI
Author: Matthew Ell
Version: 1
Author URI: http://www.matthewell.com
*/

function wp_arch_accord_init() {

    // Create Short Code for Wrapping Accordian
    function wp_arch_accord_wrap ( $atts, $content = null ) {
       return '<div class="accordion">' . do_shortcode($content) . '</div>';
    }

    add_shortcode( 'accordions', 'wp_arch_accord_wrap' );

    // Create Short Code for Accordian
    function wp_arch_accord_block( $atts ) {
        extract( shortcode_atts( array(
            'title' => 'accordion title',
            'content' => 'accordion content',
        ), $atts ) );

        return '<h3>'. $title . '</h3>' . '<div><p>' . $content . '</p></div>';
    }

    add_shortcode( 'accordion', 'wp_arch_accord_block' );

    // Hook into enqueue script action with plugin scritps and styles
    add_action( 'wp_enqueue_scripts', 'wp_arch_accord_scripts_styles', 999);

    // Create funtion to enqueue plugin scripts and styles
    function wp_arch_accord_scripts_styles() {
         
        wp_enqueue_script('jquery-ui-accordion');
         
        // enqueue script | @Dependents: jQuery
        wp_enqueue_script('wp_arch_accord_script', plugins_url('accordion.js', __FILE__), array('jquery','jquery-ui-accordion'), "1", true);

        // enqueue css
        wp_enqueue_style('wp_arch_accord_styles', 'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css', array(), '01', 'all');

    }
}

add_action( 'init' , 'wp_arch_accord_init');


?>
