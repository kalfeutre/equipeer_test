<?php
/**
 * Plugin Name: Equipeer - Spy
 * Description: EQUIPEER Addon - Trackers d'evenements sur admin
 * Version: 1.0.1
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * Author: INFORMATUX (Patrice BOUTHIER)
 * Author URI: https://informatux.com
 * License: GPL-3.0+
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain: equipeer-search
 * Tested up to: 5.4
 */

/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Define all constants
 */
defined( 'EQUIPEER_ADDON_SPY_PATH' ) or define( 'EQUIPEER_ADDON_SPY_PATH', plugin_dir_path( __FILE__ ) ); // OR dirname( __FILE__ )
defined( 'EQUIPEER_ADDON_SPY_URL' ) or define( 'EQUIPEER_ADDON_SPY_URL', plugin_dir_url( __FILE__ ) );
defined( 'EQUIPEER_ADDON_SPY_BASE' ) or define( 'EQUIPEER_ADDON_SPY_BASE', plugin_basename( __FILE__ ) );
defined( 'EQUIPEER_ADDON_SPY_DIRNAME_FILE' ) or define( 'EQUIPEER_ADDON_SPY_DIRNAME_FILE', dirname( EQUIPEER_ADDON_SPY_BASE ) );
defined( 'EQUIPEER_ADDON_SPY_FILE' ) or define( 'EQUIPEER_ADDON_SPY_FILE', __FILE__ );
defined( 'EQUIPEER_ADDON_SPY_ID' ) or define( 'EQUIPEER_ADDON_SPY_ID', 'equipeer-spy');

/**
 * ------------------------------------------------------
 * USAGE in admin files:
 * equipeer_activity_log($user_action, $description = '')
 * 
 * Ex: equipeer_activity_log('Moderate reject', 'Moderation : Refus de INFANT DU BOSSIS_2 - REF: 426')
 * ------------------------------------------------------
 */

/**
 * Load plugin files
 */
if ( ! function_exists( 'is_plugin_active' ) )
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Load classes
 */
//$eqspyClasses = ['lists'];
$eqspyClasses = false;
if ($eqspyClasses) {
    foreach ($eqspyClasses as $eqspyClass) {
        $class = EQUIPEER_ADDON_SPY_PATH . 'classes' . DIRECTORY_SEPARATOR . 'class-' . $eqspyClass . '.php';
        if (file_exists($class)) require_once($class);
    }
}

/**
 * Load include files
 */
$eqspyFiles = ['functions'];
if ($eqspyFiles) {
    foreach ($eqspyFiles as $eqspyFile) {
        $file = EQUIPEER_ADDON_SPY_PATH . 'includes' . DIRECTORY_SEPARATOR . $eqspyFile . '.php';
        if (file_exists($file)) require_once($file);
    }  
}

/**
 * Plugin row meta links
 *
 * @param   array   $links
 * @param   string  $file
 *
 * @return array
 */
add_filter( 'plugin_row_meta', 'eqspy_plugin_row_meta', 10, 2 );
if ( ! function_exists( 'eqspy_plugin_row_meta' ) ) {
	function eqspy_plugin_row_meta( $links, $file ) {
		if (stripos($file, EQUIPEER_ADDON_SPY_BASE) !== false) {
			$new_links = array(
				'doc' => '<a href="https://codex.equipeer.com/" target="_blank"><span class="dashicons dashicons-book-alt" style="font-size: 1.3em;"></span>' . __( 'Documentation', EQUIPEER_ID ) . '</a>'
			);
			
			$links = array_merge($links, $new_links);
		}
		
		return $links;
	}
}

/**
 * Get plugin infos
 */
if ( ! function_exists( 'get_plugin_data' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}
if ( ! function_exists( 'eqspy_get_version' ) ) {
    function eqspy_get_version( $iresa_infos = 'Version' ) {
        /**
         * 'Name' - Name of the plugin, must be unique.
         * 'Title' - Title of the plugin and the link to the plugin's web site.
         * 'Description' - Description of what the plugin does and/or notes from the author.
         * 'Author' - The author's name
         * 'AuthorURI' - The authors web site address.
         * 'Version' - The plugin version number.
         * 'PluginURI' - Plugin web site address.
         * 'TextDomain' - Plugin's text domain for localization.
         * 'DomainPath' - Plugin's relative directory path to .mo files.
         * 'Network' - Boolean. Whether the plugin can only be activated network wide.
         */
        $plugin_data = get_plugin_data( __FILE__ );
        $plugin_version = $plugin_data[ "$iresa_infos" ];
        return $plugin_version;
    }
}

/**
 * Register menu page
 */
add_action( 'admin_menu', 'eqspy_register_menu_page' );
function eqspy_register_menu_page() {
    add_menu_page(
        'Tracker Admin'
        ,'Tracker Admin'
        ,'manage_options'
        ,'equipeer-spy'
        ,'eqspy_page_callback'
        ,''
        ,10
    );
}

/**
 * Disply callback for the Unsub page.
 */
 function eqspy_page_callback() {
    ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    
    <div class="wrap">
        <h1 class="wp-heading-inline" style="font-size: 2em; border-bottom: 1px solid gray; width: 100%; margin-bottom: 1em; margin-top: 0;">Tracker Admin</h1>
        <?php $all_entries = eqspy_list(); ?>
        <table id="eqspy" class="display" style="width:100%" data-order="[[ 0, &quot;desc&quot; ]]">
         <thead>
          <tr>
           <th>Date</th>
           <th>User</th>
           <th>IP</th>
           <th>Action</th>
           <th>Description</th>
          </tr>
         </thead>
         <tbody>
          <?php foreach($all_entries as $row) { ?>
           <tr>
            <td data-order="<?php echo $row->date; ?>"><?php echo equipeer_convert_date( $row->date, 'FR3' ); ?></td>
            <td><?php echo $row->user_name; ?></td>
            <td><?php echo $row->user_ip; ?></td>
            <td><?php echo $row->user_action; ?></td>
            <td><?php echo $row->description; ?></td>
           </tr>
          <?php } ?>
        </table>
        
    </div>
    <script>
        jQuery(document).ready( function () {
            jQuery('#eqspy').DataTable( {
                "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
            } );
        } );
    </script>
    <?php
 }

?>