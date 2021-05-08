<?php
/**
 * Plugin Name: Equipeer
 * Description: EQUIPEER - Gestion d'un catalogue d'équidés
 * Version: 1.2.269
 * Requires at least: 5.4
 * Requires PHP: 7.2
 * Author: INFORMATUX
 * Author URI: https://informatux.com
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: equipeer
 * Domain Path: /languages
 * Tested up to: 5.4
 */

/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Define all constants
 */
defined( 'EQUIPEER_DIR' ) or define( 'EQUIPEER_DIR', plugin_dir_path( __FILE__ ) ); // OR dirname( __FILE__ )
defined( 'EQUIPEER_URL' ) or define( 'EQUIPEER_URL', plugin_dir_url( __FILE__ ) );
defined( 'EQUIPEER_BASE' ) or define( 'EQUIPEER_BASE', plugin_basename( __FILE__ ) );
defined( 'EQUIPEER_DIRNAME_FILE' ) or define( 'EQUIPEER_DIRNAME_FILE', dirname( EQUIPEER_BASE ) );
defined( 'EQUIPEER_FILE' ) or define( 'EQUIPEER_FILE', __FILE__ );
defined( 'EQUIPEER_ID' ) or define( 'EQUIPEER_ID', 'equipeer');
defined( 'INFORMATUX_PLUGIN_NAME' ) or define( 'INFORMATUX_PLUGIN_NAME', EQUIPEER_DIRNAME_FILE );
defined( 'EQUIPEER_ADMIN_DIR' ) or define( 'EQUIPEER_ADMIN_DIR', EQUIPEER_DIR . 'admin' );
defined( 'EQUIPEER_ASSETS_DIR' ) or define( 'EQUIPEER_ASSETS_DIR', EQUIPEER_DIR . 'assets' );
defined( 'EQUIPEER_CLASSES_DIR' ) or define( 'EQUIPEER_CLASSES_DIR', EQUIPEER_DIR . 'classes' );
defined( 'EQUIPEER_HELPERS_DIR' ) or define( 'EQUIPEER_HELPERS_DIR', EQUIPEER_DIR . 'helpers' );
defined( 'EQUIPEER_INC_DIR' ) or define( 'EQUIPEER_INC_DIR', EQUIPEER_DIR . 'includes' );
defined( 'EQUIPEER_LIB_DIR' ) or define( 'EQUIPEER_LIB_DIR', EQUIPEER_DIR . 'lib' );
defined( 'EQUIPEER_VENDOR_DIR' ) or define( 'EQUIPEER_VENDOR_DIR', EQUIPEER_ASSETS_DIR . '/vendors' );
defined( 'EQUIPEER_VIEWS_DIR' ) or define( 'EQUIPEER_VIEWS_DIR', EQUIPEER_DIR . 'views' );

/**
 * Check if EQUIPEER Class is loaded
 */
if ( !class_exists( 'Equipeer' ) ) {
	require_once EQUIPEER_DIR . 'core/class-equipeer.php';
}

/**
 * Load EQUIPEER Plugin when all plugins loaded
 *
 * @return void
 */
function Equipeer() {
    return Equipeer::instance();
}

/**
 * Loading plugin...
 */
Equipeer();

?>