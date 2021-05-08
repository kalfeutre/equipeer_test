<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');
 
/**
 * Get all log activities from admin
 * This method return array to display
 * 
 * @return array
 */
function eqspy_list() {
	global $wpdb;
	$eqspy_tbl = $wpdb->prefix . 'eqactivity_log';
	
	$result = $wpdb->get_results( "SELECT * FROM $eqspy_tbl ORDER BY date DESC" );
	
	return $result;
}

?>