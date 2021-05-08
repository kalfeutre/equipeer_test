<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Get all users from specific group
 *
 * @param	$group	Specific WP group
 *
 * @return array
 */
if ( !function_exists("equipeer_admin_get_users") ) {
	function equipeer_admin_get_users( $group = 'equipeer_client' ) {
		$args = array(
			'blog_id'      => $GLOBALS['blog_id'],
			'role'         => $group,
			'role__in'     => array(),
			'role__not_in' => array(),
			'meta_key'     => '',
			'meta_value'   => '',
			'meta_compare' => '',
			'meta_query'   => array(),
			'date_query'   => array(),        
			'include'      => array(),
			'exclude'      => array(),
			'orderby'      => 'nicename', // ID | login | nicename | email | url | registered | display_name | post_count | include | meta_value
			'order'        => 'ASC',      // ASC | DESC
			'offset'       => '',
			'search'       => '',
			'number'       => '',
			'count_total'  => false,
			'fields'       => 'all',
			'who'          => '',
		 ); 
		$users = get_users( $args );
		
		return $users;
	}
}

?>