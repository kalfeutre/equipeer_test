<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Options
 *
 * @class Options
 */
class Equipeer_Admin_Options extends Equipeer {
	
    /**
     * Constructor for the Equipeer_Admin_Columns class
     *
     * Sets up all the appropriate hooks and actions
     */
	function __construct() {
		// Load script in the footer
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_main_enqueue_scripts' ) );
	}
	
	/**
	 * Quick Edit add admin JS script
	 *
	 * @return void
	 */
	function admin_main_enqueue_scripts( $hook ) {
	
		if ( isset( $_GET['post_type'] ) && $this->post_type === $_GET['post_type'] ) {
			// Quick Edit Populate fields
			wp_enqueue_script( 'admin_main_equipeer_script', EQUIPEER_URL . 'assets/js/admin.js', array( 'jquery' ) );
		}
	
	}
	
}