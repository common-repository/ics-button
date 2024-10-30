<?php
/**
 * Plugin Name: ICS Button
 * Plugin URI: http://wordpress.org/extend/plugins/ics-button/
 * Description: Create a button (link) for an ICS file that is generated on the fly via javascript.
 * Author: Joe Motacek
 * Version: 0.6
 * Requires at least: 3.3
 * Tested up to: 3.9.1
 **/

// Init
function ics_button() {
   // Check user permission
   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
     return;
 
   // Add only in Rich Editor mode
   if ( get_user_option('rich_editing') == 'true') {
     add_filter("mce_external_plugins", "ics_button_enable");
     add_filter('mce_buttons', 'ics_button_button');
   }
}

// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
function ics_button_enable($plugins)
{
   $plugins['icsbutton'] = plugins_url('', __FILE__) . '/plugin/editor_plugin.js';
   return $plugins;
}

//Add the button to the toolbar
function ics_button_button($buttons) {
   array_push($buttons, "separator", "icsbutton");
   return $buttons;
}
add_action('init', 'ics_button');

//open the dialog window
function ics_button_ajax_tinymce() {
    if (!current_user_can('edit_pages') && !current_user_can('edit_posts')) // check for rights
        die(__("You are not allowed to be here"));

    include_once( dirname(dirname(__FILE__)) . '/ics-button/plugin/dialog.php');
}
add_action('wp_ajax_ics_button_tinymce', 'ics_button_ajax_tinymce');

// Add the script to all pages
function ics_script($hook){
	wp_enqueue_script( 'ics-js', plugins_url('', __FILE__) . '/plugin/js/ics-min.js', array(), '0.2', true );
}
add_action( 'wp_enqueue_scripts', 'ics_script' );

// add the shortcode [ics_button subject="" description="" location="" start-date="" end-date=""]
function ics_shortcode( $atts, $content = NULL ) {
    $a = shortcode_atts( array(
		'subject' 		=> 'Example ICS',
		'description' 	=> 'A simple description...',
		'location' 		=> 'Event Location',
		'start-date' 	=> '2014-06-24 13:00',
		'end-date' 		=> '2014-06-24 14:00'
	), $atts);
	
	$startDate = date_parse($a['start-date']);
	$endDate = date_parse($a['end-date']);
	$output  = '<a class="button" href="#" onclick="javascript:download_ics(';
	$output .= "'event'" . ', ' . "'" . $a['subject'] . "', '" . $a['description'] . "', '" . $a['location'] . "', '";
	$output .= $startDate['year'] . "-" . $startDate['month'] . "-" . $startDate['day'] . "', '" . $startDate['hour'] . "', '" . $startDate['minute'] . "', '";
	$output .= $endDate['year'] . "-" . $endDate['month'] . "-" . $endDate['day'] . "', '" . $endDate['hour'] . "', '" . $endDate['minute'] . "'" . ')">';
	$output .= $content . '</a>';
	
    return $output;
}
add_shortcode( 'ics_button', 'ics_shortcode' );
?>