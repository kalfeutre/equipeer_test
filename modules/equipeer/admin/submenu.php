<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Submenu
 *
 * @class Submenu
 */
class Equipeer_Submenu extends WP_List_Table {
 
    /**
     * Autoload method
     * @return void
     */
    public function __construct() {
        add_action( 'admin_menu', array(&$this, 'register_sub_menu') );
		// Create your menu outside the class
		add_action( 'admin_menu', array(&$this, 'table_list_menu' ) );
    }
 
    /**
     * Register submenu
     * @return void
     */
    public function register_sub_menu() {
		global $submenu;

		// Sub Menus
        //add_submenu_page( 
        //    'edit.php?post_type=equine',
		//	__( 'Categories', EQUIPEER_ID ),
		//	__( 'Categories', EQUIPEER_ID ),
		//	'equipeer_manage_categories',
		//	'submenu-categories',
		//	array( &$this, 'submenu_categories_callback' )
        //);
		
		// External links
		$submenu['edit.php?post_type=equine'][] = array(__( 'Cat&eacute;gories EQUIPEER', EQUIPEER_ID ), 'equipeer_manage_categories', admin_url() . 'edit-tags.php?taxonomy=equipeer_discipline&post_type=equine');
		$submenu['edit.php?post_type=equine'][] = array(__( 'Mod&eacute;rations', EQUIPEER_ID ), 'equipeer_manage_categories', admin_url() . 'edit.php?post_status=moderate&post_type=equine');
		$submenu['edit.php?post_type=equine'][] = array(__( 'EQUICODEX', EQUIPEER_ID ), 'equipeer_manage_categories', '//codex.equipeer.com/');
    }
 
    /**
     * Render submenu
     * @return void
     */
    public function submenu_categories_callback() {
		global $wpdb;
		
        echo '<div class="wrap">';
        echo '<h2>' . __( 'Categories', EQUIPEER_ID ) . '</h2>';

		$customPostTaxonomies = get_object_taxonomies('equine');

		if ($customPostTaxonomies) {

			echo '<p>';
		
			foreach($customPostTaxonomies as $tax) {
				
				// Exception WPML
				if ($tax == 'translation_priority') continue;
			   
				$taxomony_detail = get_taxonomy($tax);
				
				$args = array(
					'orderby'            => 'name',
					'order'              => 'ASC',
					'style'              => 'list',
					'child_of'           => 0,
					'show_count'         => 0,
					'pad_counts'         => 0,
					'hierarchical'       => 0,
					'number'             => NULL,
					'echo'               => 1,
					'depth'              => 0,
					'current_category'   => 0,
					'hide_empty'         => 0,
					'taxonomy'           => $tax,
					'use_desc_for_title' => 0,
					'title_li'           => '<span class="dashicons dashicons-admin-links"></span>&nbsp;<a class="equipeer_category_link" href="edit-tags.php?taxonomy='.$tax.'&post_type=equine">' . $taxomony_detail->label . '</a>',
					'show_option_none'   => __('No categories'),
				);

				 wp_list_categories( $args );
			}
			
			echo '</p>';
			
		}
		
        echo '</div>';
    }
 
}

?>