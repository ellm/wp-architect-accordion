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
    // Remove empty p tags for custom shortcodes
    // https://gist.github.com/bitfade/4555047
    // http://themeforest.net/forums/thread/how-to-add-shortcodes-in-wp-themes-without-being-rejected/98804?page=4#996848
    add_filter("the_content", "the_content_filter");
     
    function the_content_filter($content) {
     
        // array of custom shortcodes requiring the fix 
        $block = join("|",array("accordions","accordion-title","accordion-block"));
     
        // opening tag
        $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
            
        // closing tag
        $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);
     
        return $rep;
     
    }

    // Create ShortCode for Wrapping Accordian
    //$args is reserved to pass containing shortcodes
    function wp_arch_accord_wrap ( $args, $content = null ) {
        // do_shortcode() will seach through $content and filter through hooks
       return '<div class="accordion">' . do_shortcode($content) . '</div>';
    }
    add_shortcode( 'accordions', 'wp_arch_accord_wrap' );

    // Create Shortcode for Title of Accordion
    function wp_arch_accord_title ( $args, $content = null )  {
        return '<h3>' . $content . '</h3>';
    }
    add_shortcode( 'accordion-title', 'wp_arch_accord_title' );
    
    // Create Short Code for Content area of Accordion
    function wp_arch_accord_block( $args, $content = null ) {
        return '<div>' . wpautop($content) . '</div>';
    }
    add_shortcode( 'accordion-block', 'wp_arch_accord_block' );

    // Hook into enqueue script action with plugin scritps and styles
    add_action( 'wp_enqueue_scripts', 'wp_arch_accord_scripts_styles', 999);

    // Create funtion to enqueue plugin scripts and styles    
    function wp_arch_accord_scripts_styles() {
        
        // To access a global variable in your code, you first need to globalize the variable with
        // ref: http://codex.wordpress.org/Global_Variables
        global $post;
        // Check to make sure the $post object is available (Fixes notice when $post is not avialable)
        if ( !empty($post) ) {
        
            // If is not admin AND has accordion shortcode in post load scripts and styles
            if ( !is_admin() && has_shortcode( $post->post_content, 'accordions') ) {
         
                // enqueue script | WordPress jQuery Accordion 
                wp_enqueue_script('jquery-ui-accordion');
         
                // enqueue script | @Dependents: jQuery
                wp_enqueue_script('wp_arch_accord_script', plugins_url('accordion.js', __FILE__), array('jquery','jquery-ui-accordion'), "1", true);

                // enqueue css | External 
                // http://stackoverflow.com/questions/820412/downloading-jquery-ui-css-from-googles-cdn
                wp_enqueue_style('wp_arch_accord_styles', '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css', array(), '01', 'all');
    
            }
        }

    }
}

add_action( 'init' , 'wp_arch_accord_init');


?>
