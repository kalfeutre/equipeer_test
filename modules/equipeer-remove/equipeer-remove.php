<?php
/**
 * Plugin Name: Equipeer - Remove
 * Description: EQUIPEER Addon - Liste des demandes de suppression d'annonces
 * Version: 1.0.2
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
defined( 'EQUIPEER_ADDON_REMOVE_PATH' ) or define( 'EQUIPEER_ADDON_REMOVE_PATH', plugin_dir_path( __FILE__ ) ); // OR dirname( __FILE__ )
defined( 'EQUIPEER_ADDON_REMOVE_URL' ) or define( 'EQUIPEER_ADDON_REMOVE_URL', plugin_dir_url( __FILE__ ) );
defined( 'EQUIPEER_ADDON_REMOVE_BASE' ) or define( 'EQUIPEER_ADDON_REMOVE_BASE', plugin_basename( __FILE__ ) );
defined( 'EQUIPEER_ADDON_REMOVE_DIRNAME_FILE' ) or define( 'EQUIPEER_ADDON_REMOVE_DIRNAME_FILE', dirname( EQUIPEER_ADDON_REMOVE_BASE ) );
defined( 'EQUIPEER_ADDON_REMOVE_FILE' ) or define( 'EQUIPEER_ADDON_REMOVE_FILE', __FILE__ );
defined( 'EQUIPEER_ADDON_REMOVE_ID' ) or define( 'EQUIPEER_ADDON_REMOVE_ID', 'equipeer-remove');

/**
 * Load plugin files
 */
if ( ! function_exists( 'is_plugin_active' ) )
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Load classes
 */
//$eqremoveClasses = ['lists'];
$eqremoveClasses = false;
if ($eqremoveClasses) {
    foreach ($eqremoveClasses as $eqremoveClass) {
        $class = EQUIPEER_ADDON_REMOVE_PATH . 'classes' . DIRECTORY_SEPARATOR . 'class-' . $eqremoveClass . '.php';
        if (file_exists($class)) require_once($class);
    }
}

/**
 * Load include files
 */
$eqremoveFiles = ['functions'];
if ($eqremoveFiles) {
    foreach ($eqremoveFiles as $eqremoveFile) {
        $file = EQUIPEER_ADDON_REMOVE_PATH . 'includes' . DIRECTORY_SEPARATOR . $eqremoveFile . '.php';
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
add_filter( 'plugin_row_meta', 'eqremove_plugin_row_meta', 10, 2 );
if ( ! function_exists( 'eqremove_plugin_row_meta' ) ) {
	function eqremove_plugin_row_meta( $links, $file ) {
		if (stripos($file, EQUIPEER_ADDON_REMOVE_BASE) !== false) {
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
if ( ! function_exists( 'eqremove_get_version' ) ) {
    function eqremove_get_version( $iresa_infos = 'Version' ) {
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
add_action( 'admin_menu', 'eqremove_register_menu_page' );
function eqremove_register_menu_page() {
    add_menu_page(
        'Demande de suppressions'
        ,'Demande de suppressions'
        ,'manage_options'
        ,'equipeer-remove'
        ,'eqremove_page_callback'
        ,''
        ,10
    );
}

/**
 * Disply callback for the Unsub page.
 */
 function eqremove_page_callback() {
    ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    
    <div class="wrap">
        <h1 class="wp-heading-inline" style="font-size: 2em; border-bottom: 1px solid gray; width: 100%; margin-bottom: 1em; margin-top: 0;">Demandes de suppression d'annonces</h1>
        <?php $all_entries = eqremove_list(); ?>
        <table id="eqremove" class="display" style="width:100%" data-order="[[ 0, &quot;desc&quot; ]]">
         <thead>
          <tr>
           <th>ID</th>
           <th>User</th>
           <th>Cheval</th>
           <th>Raison</th>
           <th>Action</th>
          </tr>
         </thead>
         <tbody>
          <?php foreach($all_entries as $row) { ?>
           <?php $user_info = get_userdata( $row->uid ); ?>
           <tr>
            <td><?php echo $row->id; ?></td>
            <td><?php echo ucfirst($user_info->first_name) . ' ' . strtoupper($user_info->last_name) . ' - ' . $user_info->user_email; ?></td>
            <td><?php echo get_the_title($row->pid); ?></td>
            <td><?php echo wp_unslash(esc_html($row->reason)); ?></td>
            <td><?php echo '<a href="'.get_admin_url().'post.php?post='.$row->pid.'&action=edit&lang=fr&classic-editor" target="_blank">voir le cheval (admin)</a><br><a href="'.get_permalink($row->pid).'" target="_blank">voir le cheval (site)</a>'; ?></td>
           </tr>
          <?php } ?>
        </table>
        
    </div>
    <script>
        jQuery(document).ready( function () {
            jQuery('#eqremove').DataTable( {
                "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]]
            } );
        } );
    </script>
    <?php
 }

?>