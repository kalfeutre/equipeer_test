<?php
/**
 * Plugin Name: Equipeer - Post Status
 * Description: EQUIPEER Addon - Post status
 * Version: 1.0.1
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: INFORMATUX (Patrice BOUTHIER)
 * Author URI: https://informatux.com
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: equipeer
 * Domain Path: /languages
 * Tested up to: 5.2
 */

/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Define all constants
 */
defined( 'EQUIPEER_ADDON_PS_DIR' ) or define( 'EQUIPEER_ADDON_PS_DIR', plugin_dir_path( __FILE__ ) ); // OR dirname( __FILE__ )
defined( 'EQUIPEER_ADDON_PS_URL' ) or define( 'EQUIPEER_ADDON_PS_URL', plugin_dir_url( __FILE__ ) );
defined( 'EQUIPEER_ADDON_PS_BASE' ) or define( 'EQUIPEER_ADDON_PS_BASE', plugin_basename( __FILE__ ) );
defined( 'EQUIPEER_ADDON_PS_DIRNAME_FILE' ) or define( 'EQUIPEER_ADDON_PS_DIRNAME_FILE', dirname( EQUIPEER_ADDON_PS_BASE ) );
defined( 'EQUIPEER_ADDON_PS_FILE' ) or define( 'EQUIPEER_ADDON_PS_FILE', __FILE__ );
defined( 'EQUIPEER_ADDON_PS_ID' ) or define( 'EQUIPEER_ADDON_PS_ID', 'equipeer');

/**
 * Equipeer class
 *
 * @class Equipeer - The class that holds the entire Equipeer plugin
 */
if(!class_exists('Equipeer_Addon_Post_Status')) {
	class Equipeer_Addon_Post_Status {
		
		/**
		 * Instance of self
		 *
		 * @var Equipeer
		 */
		private static $instance = null;
		
		/**
		 * Post type Equipeer
		 *
		 * @var string
		 */
		private $post_type = 'equine';
	
		/**
		 * Constructor for the Equipeer_Addon_Post_Status class
		 *
		 * Sets up all the appropriate hooks and actions
		 * within our plugin.
		 */
		public function __construct() {
			// Check if is admin
			if ( !is_admin() ) return;
			/**
			 * New POST STATUS : OFF
			 * Initialize post status (register)
			 * Add custom post status in list table with counter
			 * Add custom post status in status select in quick edit
			 * Add custom post status in status select in quick edit (Other method)
			 */
			add_action( 'init', array( $this, 'custom_post_status_off' ) );
			add_action( 'admin_footer-post.php', array( $this, 'custom_post_status_off_select' ) );
			add_action( 'admin_footer-edit.php', array( $this, 'custom_post_status_off_script' ) );
			add_filter( 'display_post_states', array( $this, 'custom_post_status_off_statuses' ) );
			/**
			 * New POST STATUS : TO MODERATE
			 * Initialize post status (register)
			 * Add custom post status in list table with counter
			 * Add custom post status in status select in quick edit
			 * Add custom post status in status select in quick edit (Other method)
			 */
			add_action( 'init', array( $this, 'custom_post_status_to_moderate' ) );
			add_action( 'admin_footer-post.php', array( $this, 'custom_post_status_to_moderate_select' ) );
			add_action( 'admin_footer-edit.php', array( $this, 'custom_post_status_to_moderate_script' ) );
			add_filter( 'display_post_states', array( $this, 'custom_post_status_to_moderate_statuses' ) );
			// Plugin infos (Extensions)
	        add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta'), 10, 2 );
		}
	
		/**
		 * Initializes the Equipeer_Addon_Post_Status() class
		 *
		 * Checks for an existing Equipeer_Addon_Post_Status() instance
		 * and if it doesn't find one, creates it.
		 */
		public static function init_addon_post_status() {
			if ( self::$instance === null ) {
				self::$instance = new self();
			}
	
			return self::$instance;
		}
		
		/**
		 * Plugin row meta links
		 *
		 * @param   array   $links
		 * @param   string  $file
		 *
		 * @return array
		 */
		function plugin_row_meta( $links, $file ) {
			if (stripos($file, EQUIPEER_ADDON_PS_BASE) !== false) {
				$new_links = array(
					'doc' => '<a href="https://codex.equipeer.com/" target="_blank"><span class="dashicons dashicons-book-alt" style="font-size: 1.3em;"></span>' . __( 'Documentation', EQUIPEER_ID ) . '</a>'
				);
				
				$links = array_merge($links, $new_links);
			}
			
			return $links;
		}
		
		/**
		 * Register Equipeer Custom Post Status (OFF)
		 *
		 * @link https://codex.wordpress.org/Function_Reference/register_post_status
		 *
		 * Return void
		 */
		function custom_post_status_off() {
			register_post_status( 'off', array(
				'label'                     => _x( 'Off', EQUIPEER_ID ),
				'public'                    => false,
				'exclude_from_search'       => true,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'_builtin'                  => false,
				'label_count'               => _n_noop( 'Off <span class="count">(%s)</span>', 'Off <span class="count">(%s)</span>' ),
			) );
		}
		
		/**
		 * Add custom post status in Select status (Post edit: OFF)
		 *
		 * @return string html
		 */
		function custom_post_status_off_select() {
			global $post;
			$complete = '';
			$label    = '';
		
			if ( $post->post_type == $this->post_type ) {
		
				if ( $post->post_status == 'off' ) {
					$complete = ' selected=\"selected\"';
					$label    = 'Off';
				}
		
				$script = <<<SD
		
			   jQuery(document).ready(function($){
				   $("select#post_status").append("<option value=\"off\" '.$complete.'>Off</option>");
		
				   if( "{$post->post_status}" == "off" ) {
						$("span#post-status-display").html("$label");
						$("input#save-post").val("Save off");
				   }
				   var jSelect = $("select#post_status");
		
				   $("a.save-post-status").on("click", function(){
		
						if( jSelect.val() == "off" ){
		
							$("input#save-post").val("Save off");
						}
				   });
			  });
SD;
				echo '<script type="text/javascript">' . $script . '</script>';
			}
		}
		
		/**
		 * Add custom post status in Select status (quick edit: OFF)
		 *
		 * @return string html
		 */
		function custom_post_status_off_script() {
			global $post;
			if ( $post->post_type == $this->post_type ) {
				$script = <<<SD
					<script>
						jQuery(document).ready( function($) {
							$( 'select[name="_status"]' ).append( '<option value=\"off\">Off</option>' );
						});
					</script>
SD;
				echo $script;
			}
		}
		
		/**
		 * Add custom post status in status select in quick edit (Other method : OFF)
		 *
		 * @return array
		 */
		function custom_post_status_off_statuses( $statuses ) {
			global $post;
		
			if ( $post->post_type == $this->post_type ) {
				if ( get_query_var( 'post_status' ) != 'off' ) { // not for pages with all posts of this status
					if ( $post->post_status == 'off' ) {
						return array( 'Off' );
					}
				}
			}
			return $statuses;
		}
		
		/**
		 * Register Equipeer Custom Post Status (TO MODERATE)
		 *
		 * @link https://codex.wordpress.org/Function_Reference/register_post_status
		 *
		 * Return void
		 */
		function custom_post_status_to_moderate() {
			register_post_status( 'moderate', array(
				'label'                     => _x( 'A Modérer', EQUIPEER_ID ),
				'public'                    => false,
				'exclude_from_search'       => true,
				'show_in_admin_all_list'    => true,
				'show_in_admin_status_list' => true,
				'_builtin'                  => false,
				'label_count'               => _n_noop( 'A Modérer <span class="count">(%s)</span>', 'A Modérer <span class="count">(%s)</span>' ),
			) );
		}
		
		/**
		 * Add custom post status in Select status (Post edit: TO MODERATE)
		 *
		 * @return string html
		 */
		function custom_post_status_to_moderate_select() {
			global $post;
			$complete = '';
			$label    = '';
		
			if ( $post->post_type == $this->post_type ) {
		
				if ( $post->post_status == 'moderate' ) {
					$complete = ' selected=\"selected\"';
					$label    = 'A Modérer';
				}
		
				$script = <<<SD
		
			   jQuery(document).ready(function($){
				   $("select#post_status").append("<option value=\"moderate\" '.$complete.'>A Modérer</option>");
				   $("select#post_status option[value='pending']").remove();
		
				   if( "{$post->post_status}" == "moderate" ) {
						$("span#post-status-display").html("$label");
						$("input#save-post").val("Save moderate");
				   }
				   var jSelect = $("select#post_status");
		
				   $("a.save-post-status").on("click", function(){
		
						if( jSelect.val() == "moderate" ){
		
							$("input#save-post").val("Save moderate");
						}
				   });
			  });
SD;
				echo '<script type="text/javascript">' . $script . '</script>';
			}
		}
		
		/**
		 * Add custom post status in Select status (quick edit: TO MODERATE)
		 *
		 * @return string html
		 */
		function custom_post_status_to_moderate_script() {
			global $post;
			if ( $post->post_type == $this->post_type ) {
				$script = <<<SD
					<script>
						jQuery(document).ready( function($) {
							$( 'select[name="_status"]' ).append( '<option value=\"moderate\">A Modérer</option>' );
						});
					</script>
SD;
				echo $script;
			}
		}
		
		/**
		 * Add custom post status in status select in quick edit (Other method : TO MODERATE)
		 *
		 * @return array
		 */
		function custom_post_status_to_moderate_statuses( $statuses ) {
			global $post;
		
			if ( $post->post_type == $this->post_type ) {
				if ( get_query_var( 'post_status' ) != 'moderate' ) { // not for pages with all posts of this status
					if ( $post->post_status == 'moderate' ) {
						return array( 'A Modérer' );
					}
				}
			}
			return $statuses;
		}
		
	}
}

/**
 * Load EQUIPEER Plugin when all plugins loaded
 *
 * @return void
 */
function Equipeer_Addon_Post_Status() {
    return Equipeer_Addon_Post_Status::init_addon_post_status();
}

/**
 * Loading plugin...
 */
Equipeer_Addon_Post_Status();

?>