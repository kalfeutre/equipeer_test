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
function eqremove_list() {
	global $wpdb;
	$eqremove_tbl = $wpdb->prefix . 'eqremoval_request';
	
	$result = $wpdb->get_results( "SELECT * FROM $eqremove_tbl ORDER BY id DESC" );
	
	return $result;
}

?>