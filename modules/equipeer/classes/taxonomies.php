<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Taxonomies
 *
 * @class Taxonomies
 */
class Equipeer_Taxonomies extends Equipeer {
	
	/**
	 * Capabilities for Categories (Taxonomies)
	 *
	 * @var array
	 */
	private $capabilities = array(
		'manage_terms' => 'equipeer_manage_categories',
		'edit_terms'   => 'equipeer_manage_categories',
		'delete_terms' => 'equipeer_manage_categories',
		'assign_terms' => 'equipeer_edit_options',
	);
	
	/**
	 * Equine Type
	 *
	 * @var string
	 */
	private $equine_type         = EQUIPEER_ID . '_select_taxonomy_parent_id';
	private $equine_discipline   = EQUIPEER_ID . '_select_discipline_taxonomy_parent_id';
	private $equine_discipline_2 = EQUIPEER_ID . '_select_discipline_2_taxonomy_parent_id';
	private $equine_discipline_3 = EQUIPEER_ID . '_select_discipline_3_taxonomy_parent_id';
	private $equine_prefix       = EQUIPEER_ID . '_prefix_taxonomy_parent_id';
	private $equine_image        = EQUIPEER_ID . '_image_taxonomy_parent_id';
	
	/**
	 * __construct
	 */
	function __construct() {
		// Create main taxonomy
		//add_action( 'init', array( &$this, 'create_main_taxonomy' ) );

		// Create general taxonomies
		add_action( 'init', array( &$this, 'create_age_taxonomy' ) );
		add_action( 'init', array( &$this, 'create_discipline_taxonomy' ) );
		add_action( 'init', array( &$this, 'create_gender_taxonomy' ) );
		add_action( 'init', array( &$this, 'create_group_taxonomy' ) );
		add_action( 'init', array( &$this, 'create_niveau_taxonomy' ) );
		add_action( 'init', array( &$this, 'create_potentiel_taxonomy' ) );
		add_action( 'init', array( &$this, 'create_race_taxonomy' ) );
		add_action( 'init', array( &$this, 'create_robe_taxonomy' ) );
		add_action( 'init', array( &$this, 'create_taille_taxonomy' ) );
		
		// Create equestrian taxonomies
		add_action( 'init', array( &$this, 'create_discipline_equestre_taxonomy' ) );
		add_action( 'init', array( &$this, 'create_niveau_equestre_taxonomy' ) );
		
		// Create rider taxonomies
		add_action( 'init', array( &$this, 'create_cavalier_age_taxonomy' ) );
		add_action( 'init', array( &$this, 'create_cavalier_comportement_taxonomy' ) );
		add_action( 'init', array( &$this, 'create_cavalier_genre_taxonomy' ) );
		add_action( 'init', array( &$this, 'create_cavalier_niveau_taxonomy' ) );
		
		// Create Column, add content (equipeer_group)
		add_filter('manage_edit-equipeer_group_columns', array( $this, 'add_equipeer_group_columns' ) );
		add_filter('manage_edit-equipeer_group_sortable_columns', array( $this, 'add_equipeer_group_columns' ) );
		add_filter('manage_equipeer_group_custom_column', array( $this, 'add_equipeer_group_column_content' ), 10, 3);

		// Create Column, add content (equipeer_discipline)
		add_filter('manage_edit-equipeer_discipline_columns', array( $this, 'add_equipeer_discipline_columns' ) );
		add_filter('manage_edit-equipeer_discipline_sortable_columns', array( $this, 'add_equipeer_discipline_columns' ) );
		add_filter('manage_equipeer_discipline_custom_column', array( $this, 'add_equipeer_discipline_column_content' ), 10, 3);

		// Create Column, add content (equipeer_equestrian_discipline)
		add_filter('manage_edit-equipeer_equestrian_discipline_columns', array( $this, 'add_equipeer_equestrian_discipline_columns' ) );
		add_filter('manage_edit-equipeer_equestrian_discipline_sortable_columns', array( $this, 'add_equipeer_equestrian_discipline_columns' ) );
		add_filter('manage_equipeer_equestrian_discipline_custom_column', array( $this, 'add_equipeer_equestrian_discipline_column_content' ), 10, 3);

		// Create Column, add content (equipeer_gender)
		add_filter('manage_edit-equipeer_gender_columns', array( $this, 'add_equipeer_gender_columns' ) );
		add_filter('manage_edit-equipeer_gender_sortable_columns', array( $this, 'add_equipeer_gender_columns' ) );
		add_filter('manage_equipeer_gender_custom_column', array( $this, 'add_equipeer_gender_column_content' ), 10, 3);

		// Create Column, add content (equipeer_age)
		add_filter('manage_edit-equipeer_age_columns', array( $this, 'add_equipeer_age_columns' ) );
		add_filter('manage_edit-equipeer_age_sortable_columns', array( $this, 'add_equipeer_age_columns' ) );
		add_filter('manage_equipeer_age_custom_column', array( $this, 'add_equipeer_age_column_content' ), 10, 3);

		// Create Column, add content (equipeer_level)
		add_filter('manage_edit-equipeer_level_columns', array( $this, 'add_equipeer_level_columns' ) );
		add_filter('manage_edit-equipeer_level_sortable_columns', array( $this, 'add_equipeer_level_columns' ) );
		add_filter('manage_equipeer_level_custom_column', array( $this, 'add_equipeer_level_column_content' ), 10, 3);

		// Create Column, add content (equipeer_equestrian_level)
		add_filter('manage_edit-equipeer_equestrian_level_columns', array( $this, 'add_equipeer_equestrian_level_columns' ) );
		add_filter('manage_edit-equipeer_equestrian_level_sortable_columns', array( $this, 'add_equipeer_equestrian_level_columns' ) );
		add_filter('manage_equipeer_equestrian_level_custom_column', array( $this, 'add_equipeer_equestrian_level_column_content' ), 10, 3);

		// Create Column, add content (equipeer_potential)
		add_filter('manage_edit-equipeer_potential_columns', array( $this, 'add_equipeer_potential_columns' ) );
		add_filter('manage_edit-equipeer_potential_sortable_columns', array( $this, 'add_equipeer_potential_columns' ) );
		add_filter('manage_equipeer_potential_custom_column', array( $this, 'add_equipeer_potential_column_content' ), 10, 3);

		// Create Column, add content (equipeer_breed)
		add_filter('manage_edit-equipeer_breed_columns', array( $this, 'add_equipeer_breed_columns' ) );
		add_filter('manage_edit-equipeer_breed_sortable_columns', array( $this, 'add_equipeer_breed_columns' ) );
		add_filter('manage_equipeer_breed_custom_column', array( $this, 'add_equipeer_breed_column_content' ), 10, 3);

		// Create Column, add content (equipeer_color)
		add_filter('manage_edit-equipeer_color_columns', array( $this, 'add_equipeer_color_columns' ) );
		add_filter('manage_edit-equipeer_color_sortable_columns', array( $this, 'add_equipeer_color_columns' ) );
		add_filter('manage_equipeer_color_custom_column', array( $this, 'add_equipeer_color_column_content' ), 10, 3);

		// Create Column, add content (equipeer_size)
		add_filter('manage_edit-equipeer_size_columns', array( $this, 'add_equipeer_size_columns' ) );
		add_filter('manage_edit-equipeer_size_sortable_columns', array( $this, 'add_equipeer_size_columns' ) );
		add_filter('manage_equipeer_size_custom_column', array( $this, 'add_equipeer_size_column_content' ), 10, 3);

		// Create Column, add content (equipeer_rider_age)
		add_filter('manage_edit-equipeer_rider_age_columns', array( $this, 'add_equipeer_rider_age_columns' ) );
		add_filter('manage_edit-equipeer_rider_age_sortable_columns', array( $this, 'add_equipeer_rider_age_columns' ) );
		add_filter('manage_equipeer_rider_age_custom_column', array( $this, 'add_equipeer_rider_age_column_content' ), 10, 3);

		// Create Column, add content (equipeer_rider_behavior)
		add_filter('manage_edit-equipeer_rider_behavior_columns', array( $this, 'add_equipeer_rider_behavior_columns' ) );
		add_filter('manage_edit-equipeer_rider_behavior_sortable_columns', array( $this, 'add_equipeer_rider_behavior_columns' ) );
		add_filter('manage_equipeer_rider_behavior_custom_column', array( $this, 'add_equipeer_rider_behavior_column_content' ), 10, 3);
		
		// Create Column, add content (equipeer_rider_gender)
		add_filter('manage_edit-equipeer_rider_gender_columns', array( $this, 'add_equipeer_rider_gender_columns' ) );
		add_filter('manage_edit-equipeer_rider_gender_sortable_columns', array( $this, 'add_equipeer_rider_gender_columns' ) );
		add_filter('manage_equipeer_rider_gender_custom_column', array( $this, 'add_equipeer_rider_gender_column_content' ), 10, 3);

		// Create Column, add content (equipeer_rider_level)
		add_filter('manage_edit-equipeer_rider_level_columns', array( $this, 'add_equipeer_rider_level_columns' ) );
		add_filter('manage_edit-equipeer_rider_level_sortable_columns', array( $this, 'add_equipeer_rider_level_columns' ) );
		add_filter('manage_equipeer_rider_level_custom_column', array( $this, 'add_equipeer_rider_level_column_content' ), 10, 3);
		
		// Admin notice in Taxonomy pages
		//add_action('admin_notices', array( $this, 'taxonomy_admin_notice' ) );
		
		$this->add_select_parent_field();
		$this->add_select_discipline_parent_field();
		$this->add_select_discipline_2_parent_field();
		$this->add_select_discipline_3_parent_field();
		$this->add_input_prefix_field();
		$this->add_image_prefix_field();
	}
	
	/**
	 * Add Fields in Taxonomy
	 *
	 * @return void
	 */
	function add_select_parent_field() {
		/* 
		 * Configure your meta box
		 */
		$config = array(
		  'id'             => $this->equine_type,        // Meta box id, unique per meta box
		  'title'          => EQUIPEER_ID . ' Meta Box', // Meta box title
		  // Taxonomy name, accept categories, post_tag and custom taxonomies
		  'pages'          => array(
									 'equipeer_group'
									,'equipeer_discipline'
									,'equipeer_gender'
									,'equipeer_age'
									,'equipeer_level'
									,'equipeer_potential'
									,'equipeer_breed'
									,'equipeer_color'
									,'equipeer_size'
									,'equipeer_equestrian_discipline'
									,'equipeer_equestrian_level'
									,'equipeer_rider_age'
									,'equipeer_rider_behavior'
									,'equipeer_rider_gender'
									,'equipeer_rider_level'
		  ),
		  'context'        => 'normal',  // Where the meta box appear: normal (default), advanced, side; optional
		  'fields'         => array(),   // List of meta fields (can be added by field arrays)
		  'local_images'   => false,     // Use local or hosted images (meta box images for add/remove)
		  'use_with_theme' => false      // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
		);
		/*
		 * Initiate your meta box
		 */
		$select_meta = new Tax_Meta_Class($config);
		/**
		 * Select field
		 */
		$select_meta->addSelect(
				$this->equine_type,
				array( '' => 'Choisissez', 'horse' => 'Cheval', 'pony' => 'Poney' ),
				array( 'name' => "Type d'équidés", 'std' => array('') )
		);
		/*
		 * Don't Forget to Close up the meta box declaration
		 * Finish Meta Box Declaration
		 */
		$select_meta->Finish();
	}
	
	/**
	 * Add Fields in Taxonomy
	 *
	 * @return void
	 */
	function add_select_discipline_parent_field() {
		/* 
		 * Configure your meta box
		 */
		$config = array(
		  'id'             => $this->equine_discipline,        // Meta box id, unique per meta box
		  'title'          => EQUIPEER_ID . ' Meta Box Discipline', // Meta box title
		  // Taxonomy name, accept categories, post_tag and custom taxonomies
		  'pages'          => array( 'equipeer_level' ),
		  'context'        => 'normal',  // Where the meta box appear: normal (default), advanced, side; optional
		  'fields'         => array(),   // List of meta fields (can be added by field arrays)
		  'local_images'   => false,     // Use local or hosted images (meta box images for add/remove)
		  'use_with_theme' => false      // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
		);
		/*
		 * Initiate your meta box
		 */
		$select_meta = new Tax_Meta_Class($config);
		/**
		 * Select field
		 */
		$array_select       = array();
		$array_select = array(
			 ''  => 'Choisissez la discipline'
			,35  => 'Autres'
			,31  => 'CCE'
			,28  => 'CSO'
			,30  => 'Dressage'
			,446 => 'Elevage'
			,449 => 'Hunter'
			,454 => 'Poney'
		);
		$select_meta->addSelect(
				$this->equine_discipline,
				$array_select,
				array( 'name' => "Discipline", 'std' => array('') )
		);
		/*
		 * Don't Forget to Close up the meta box declaration
		 * Finish Meta Box Declaration
		 */
		$select_meta->Finish();
	}
	
	/**
	 * Add Fields in Taxonomy
	 *
	 * @return void
	 */
	function add_select_discipline_2_parent_field() {
		/* 
		 * Configure your meta box
		 */
		$config = array(
		  'id'             => $this->equine_discipline_2,        // Meta box id, unique per meta box
		  'title'          => EQUIPEER_ID . ' Meta Box Discipline', // Meta box title
		  // Taxonomy name, accept categories, post_tag and custom taxonomies
		  'pages'          => array( 'equipeer_level' ),
		  'context'        => 'normal',  // Where the meta box appear: normal (default), advanced, side; optional
		  'fields'         => array(),   // List of meta fields (can be added by field arrays)
		  'local_images'   => false,     // Use local or hosted images (meta box images for add/remove)
		  'use_with_theme' => false      // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
		);
		/*
		 * Initiate your meta box
		 */
		$select_meta = new Tax_Meta_Class($config);
		/**
		 * Select field
		 */
		$array_select       = array();
		$array_select = array(
			 ''  => 'Choisissez la discipline'
			,35  => 'Autres'
			,31  => 'CCE'
			,28  => 'CSO'
			,30  => 'Dressage'
			,446 => 'Elevage'
			,449 => 'Hunter'
			,454 => 'Poney'
		);
		$select_meta->addSelect(
				$this->equine_discipline_2,
				$array_select,
				array( 'name' => "Discipline 2", 'std' => array('') )
		);
		/*
		 * Don't Forget to Close up the meta box declaration
		 * Finish Meta Box Declaration
		 */
		$select_meta->Finish();
	}
	
	/**
	 * Add Fields in Taxonomy
	 *
	 * @return void
	 */
	function add_select_discipline_3_parent_field() {
		/* 
		 * Configure your meta box
		 */
		$config = array(
		  'id'             => $this->equine_discipline_3,        // Meta box id, unique per meta box
		  'title'          => EQUIPEER_ID . ' Meta Box Discipline', // Meta box title
		  // Taxonomy name, accept categories, post_tag and custom taxonomies
		  'pages'          => array( 'equipeer_level' ),
		  'context'        => 'normal',  // Where the meta box appear: normal (default), advanced, side; optional
		  'fields'         => array(),   // List of meta fields (can be added by field arrays)
		  'local_images'   => false,     // Use local or hosted images (meta box images for add/remove)
		  'use_with_theme' => false      // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
		);
		/*
		 * Initiate your meta box
		 */
		$select_meta = new Tax_Meta_Class($config);
		/**
		 * Select field
		 */
		$array_select       = array();
		$array_select = array(
			 ''  => 'Choisissez la discipline'
			,35  => 'Autres'
			,31  => 'CCE'
			,28  => 'CSO'
			,30  => 'Dressage'
			,446 => 'Elevage'
			,449 => 'Hunter'
			,454 => 'Poney'
		);
		$select_meta->addSelect(
				$this->equine_discipline_3,
				$array_select,
				array( 'name' => "Discipline 3", 'std' => array('') )
		);
		/*
		 * Don't Forget to Close up the meta box declaration
		 * Finish Meta Box Declaration
		 */
		$select_meta->Finish();
	}
	
	/**
	 * Add Fields in Taxonomy
	 *
	 * @return void
	 */
	function add_input_prefix_field() {
		/* 
		 * Configure your meta box
		 */
		$config = array(
		  'id'             => $this->equine_prefix,      // Meta box id, unique per meta box
		  'title'          => EQUIPEER_ID . ' Meta Box Prefix', // Meta box title
		  // Taxonomy name, accept categories, post_tag and custom taxonomies
		  'pages'          => array( 'equipeer_discipline' ),
		  'context'        => 'normal',  // Where the meta box appear: normal (default), advanced, side; optional
		  'fields'         => array(),   // List of meta fields (can be added by field arrays)
		  'local_images'   => false,     // Use local or hosted images (meta box images for add/remove)
		  'use_with_theme' => false      // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
		);
		/*
		 * Initiate your meta box
		 */
		$prefix_meta = new Tax_Meta_Class($config);
		/**
		 * Select field
		 */
		$prefix_meta->addText(
				$this->equine_prefix,
				array( 'name' => "Préfixe de la discipline", 'desc' => "CSO => Ex: SO" )
		);
		/*
		 * Don't Forget to Close up the meta box declaration
		 * Finish Meta Box Declaration
		 */
		$prefix_meta->Finish();
	}
	
	/**
	 * Add Fields in Taxonomy
	 *
	 * @return void
	 */
	function add_image_prefix_field() {
		/* 
		 * Configure your meta box
		 */
		$config = array(
		  'id'             => $this->equine_image,      // Meta box id, unique per meta box
		  'title'          => EQUIPEER_ID . ' Meta Box Image', // Meta box title
		  // Taxonomy name, accept categories, post_tag and custom taxonomies
		  'pages'          => array( 'equipeer_discipline' ),
		  'context'        => 'normal',  // Where the meta box appear: normal (default), advanced, side; optional
		  'fields'         => array(),   // List of meta fields (can be added by field arrays)
		  'local_images'   => false,     // Use local or hosted images (meta box images for add/remove)
		  'use_with_theme' => false      // Change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
		);
		/*
		 * Initiate your meta box
		 */
		$image_meta = new Tax_Meta_Class($config);
		/**
		 * Select field
		 */
		$image_meta->addImage(
				$this->equine_image,
				array( 'name' => "Image discipline", 'desc' => "" )
		);
		/*
		 * Don't Forget to Close up the meta box declaration
		 * Finish Meta Box Declaration
		 */
		$image_meta->Finish();
	}
	
	/**
	 * Create MAIN Category Taxonomy
	 *
	 * @return void
	 */
	function create_main_taxonomy() {
		// Labels part for the GUI
		$labels = array(
			'name'                       => __( 'Equines', EQUIPEER_ID ),
			'singular_name'              => __( 'Equine', EQUIPEER_ID ),
			'search_items'               => __( 'Search Equines', EQUIPEER_ID  ),
			'popular_items'              => __( 'Popular Equines', EQUIPEER_ID  ),
			'all_items'                  => __( 'All Equines', EQUIPEER_ID  ),
			'parent_item'                => null, // __( 'Parent Category' )
			'parent_item_colon'          => null, // __( 'Parent Category:' )
			'edit_item'                  => __( 'Edit Equine', EQUIPEER_ID  ), 
			'update_item'                => __( 'Update Equine', EQUIPEER_ID  ),
			'add_new_item'               => __( 'Add New Equine', EQUIPEER_ID  ),
			'new_item_name'              => __( 'New Equine Name', EQUIPEER_ID  ),
			'separate_items_with_commas' => __( 'Separate Equines with commas', EQUIPEER_ID  ),
			'add_or_remove_items'        => __( 'Add or remove equines', EQUIPEER_ID  ),
			'choose_from_most_used'      => __( 'Choose from the most used equines', EQUIPEER_ID  ),
			'menu_name'                  => __( 'Equines', EQUIPEER_ID  ),
		);
		// Now register the non-hierarchical taxonomy like tag
		register_taxonomy('equipeer_main', $this->post_type, array(
			'hierarchical'       => false, // true if parent_item not null
			'labels'             => $labels,
			'show_ui'            => false,
            'show_in_menu'       => false,
			'show_admin_column'  => true,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'capabilities'       => $this->capabilities,
			'rewrite'            => array( 'slug' => 'equide' ),
		));
		register_taxonomy_for_object_type( 'equipeer_main', 'equine' );
	}
	
	/**
	 * Create GROUPS Taxonomy
	 *
	 * @return void
	 */
	function create_group_taxonomy() {
		// Labels part for the GUI
		$labels = array(
			'name'                       => __( 'Groups', EQUIPEER_ID ),
			'singular_name'              => __( 'Group', EQUIPEER_ID ),
			'search_items'               => __( 'Search Groups', EQUIPEER_ID  ),
			'popular_items'              => __( 'Popular Groups', EQUIPEER_ID  ),
			'all_items'                  => null, //__( 'All Groups', EQUIPEER_ID  ),
			'parent_item'                => null, //__( 'Parent Category' ),
			'parent_item_colon'          => __( 'Parent Category:' ),
			'edit_item'                  => __( 'Edit Group', EQUIPEER_ID  ), 
			'update_item'                => __( 'Update Group', EQUIPEER_ID  ),
			'add_new_item'               => __( 'Add New Group', EQUIPEER_ID  ),
			'new_item_name'              => __( 'New Group Name', EQUIPEER_ID  ),
			'separate_items_with_commas' => __( 'Separate Groups with commas', EQUIPEER_ID  ),
			'add_or_remove_items'        => __( 'Add or remove groups', EQUIPEER_ID  ),
			'choose_from_most_used'      => __( 'Choose from the most used groups', EQUIPEER_ID  ),
			'menu_name'                  => __( 'Groups', EQUIPEER_ID  ),
		);
		// Now register the non-hierarchical taxonomy like tag
		register_taxonomy('equipeer_group', $this->post_type, array(
			'hierarchical'          => false, // true if parent_item not null
			'labels'                => $labels,
			'show_ui'               => true,
            'show_in_menu'          => false,
			'show_admin_column'     => false,
			'query_var'             => true,
			'show_in_rest'          => true,
			'show_in_quick_edit'    => false,
			//'update_count_callback' => '_update_post_term_count',
			'capabilities'          => $this->capabilities,
			'rewrite'               => array( 'slug' => 'group' ),
		));
		register_taxonomy_for_object_type( 'equipeer_group', 'equine' );
	}
	/**
	 * Add column (equipeer_group)
	 * Add content (equipeer_group)
	 *
	 * Url: /wp-admin/edit-tags.php?taxonomy=equipeer_group&post_type=equine
	 *
	 * @return string
	 */
	function add_equipeer_group_columns($columns) {
		unset($columns['posts']);
		$columns[$this->equine_type] = __( 'Equine Type', EQUIPEER_ID );
		return $columns;
	}
	function add_equipeer_group_column_content($content, $column_name, $term_id) {
		// $term = get_term($term_id, 'equipeer_group');
		switch($column_name) {
			case $this->equine_type;
				return $this->get_data_translate( get_term_meta($term_id, $this->equine_type, true) );
			break;
			default:
				return $content;
			break;
		}
	}
	
	/**
	 * Create DISCIPLINES Taxonomy
	 *
	 * @return void
	 */
	function create_discipline_taxonomy() {
		// Labels part for the GUI
		$labels = array(
			'name'                       => __( 'Disciplines', EQUIPEER_ID ),
			'singular_name'              => __( 'Discipline', EQUIPEER_ID ),
			'search_items'               => __( 'Search Disciplines', EQUIPEER_ID  ),
			'popular_items'              => __( 'Popular Disciplines', EQUIPEER_ID  ),
			'all_items'                  => __( 'All Disciplines', EQUIPEER_ID  ),
			'parent_item'                => null, // __( 'Parent Category' )
			'parent_item_colon'          => null, // __( 'Parent Category:' )
			'edit_item'                  => __( 'Edit Discipline', EQUIPEER_ID  ), 
			'update_item'                => __( 'Update Discipline', EQUIPEER_ID  ),
			'add_new_item'               => __( 'Add New Discipline', EQUIPEER_ID  ),
			'new_item_name'              => __( 'New Discipline Name', EQUIPEER_ID  ),
			'separate_items_with_commas' => __( 'Separate Disciplines with commas', EQUIPEER_ID  ),
			'add_or_remove_items'        => __( 'Add or remove disciplines', EQUIPEER_ID  ),
			'choose_from_most_used'      => __( 'Choose from the most used disciplines', EQUIPEER_ID  ),
			'menu_name'                  => __( 'Disciplines', EQUIPEER_ID  ),
			'back_to_items'              => 'Retour aux disciplines'
		);
		// Now register the non-hierarchical taxonomy like tag
		register_taxonomy('equipeer_discipline', $this->post_type, array(
			'hierarchical'       => false, // true if parent_item not null
			'labels'             => $labels,
			'show_ui'            => true,
            'show_in_menu'       => false,
			'show_admin_column'  => false,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'capabilities'       => $this->capabilities,
			'rewrite'            => array( 'slug' => 'discipline' ),
		));
		register_taxonomy_for_object_type( 'equipeer_discipline', 'equine' );
	}
	/**
	 * Add column (equipeer_discipline)
	 * Add content (equipeer_discipline)
	 *
	 * Url: /wp-admin/edit-tags.php?taxonomy=equipeer_discipline&post_type=equine
	 *
	 * @return string
	 */
	function add_equipeer_discipline_columns($columns) {
		unset($columns['posts']);
		$columns[$this->equine_type] = __( 'Equine Type', EQUIPEER_ID );
		$columns['prefix']           = __( 'Reference Prefix', EQUIPEER_ID );
		$columns['image']            = __( 'Image', EQUIPEER_ID );
		return $columns;
	}
	function add_equipeer_discipline_column_content($content, $column_name, $term_id) {
		// $term = get_term($term_id, 'equipeer_discipline');
		switch($column_name) {
			case $this->equine_type;
				return $this->get_data_translate( get_term_meta($term_id, $this->equine_type, true) );
			break;
			case "prefix":
				return get_term_meta($term_id, $this->equine_prefix, true);
			break;
			case "image":
				// ["id"]  => string(4) "2114"
				// ["url"] => string(62) "https://equipeer.fr/medias/2019/12/discipline-thumbnail-AU.jpg"
				$image_size  = "width: 74px; height: 74px;";
				$image_infos = get_term_meta($term_id, $this->equine_image, true);
				if ($image_infos)
					return '<img style="' . $image_size . '" src="' . $image_infos['url'] . '" alt="">';
				else
					return '<img style="' . $image_size . '" src="' . get_stylesheet_directory_uri() . '/assets/images/discipline-thumbnail-XX.jpg" alt="">';
			break;
			default:
				return $content;
			break;
		}
	}
	
	/**
	 * Create DISCIPLINES EQUESTRES Taxonomy
	 *
	 * @return void
	 */
	function create_discipline_equestre_taxonomy() {
		// Labels part for the GUI
		$labels = array(
			'name'                       => __( 'Equestrian Disciplines', EQUIPEER_ID ),
			'singular_name'              => __( 'Equestrian Discipline', EQUIPEER_ID ),
			'search_items'               => __( 'Search Equestrian Disciplines', EQUIPEER_ID  ),
			'popular_items'              => __( 'Popular Equestrian Disciplines', EQUIPEER_ID  ),
			'all_items'                  => __( 'All Equestrian Disciplines', EQUIPEER_ID  ),
			'parent_item'                => null, // __( 'Parent Category' )
			'parent_item_colon'          => null, // __( 'Parent Category:' )
			'edit_item'                  => __( 'Edit Equestrian Discipline', EQUIPEER_ID  ), 
			'update_item'                => __( 'Update Equestrian Discipline', EQUIPEER_ID  ),
			'add_new_item'               => __( 'Add New Equestrian Discipline', EQUIPEER_ID  ),
			'new_item_name'              => __( 'New Equestrian Discipline Name', EQUIPEER_ID  ),
			'separate_items_with_commas' => __( 'Separate Equestrian Disciplines with commas', EQUIPEER_ID  ),
			'add_or_remove_items'        => __( 'Add or remove equestrian disciplines', EQUIPEER_ID  ),
			'choose_from_most_used'      => __( 'Choose from the most used equestrian discipline', EQUIPEER_ID  ),
			'menu_name'                  => __( 'Equestrian Disciplines', EQUIPEER_ID  ),
			'back_to_items'              => 'Retour aux disciplines équestres'
		);
		// Now register the non-hierarchical taxonomy like tag
		register_taxonomy('equipeer_equestrian_discipline', $this->post_type, array(
			'hierarchical'       => false, // true if parent_item not null
			'labels'             => $labels,
			'show_ui'            => true,
            'show_in_menu'       => false,
			'show_admin_column'  => false,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'capabilities'       => $this->capabilities,
			'rewrite'            => array( 'slug' => 'equestrian-discipline' ),
		));
		register_taxonomy_for_object_type( 'equipeer_equestrian_discipline', 'equine' );
	}
	/**
	 * Add column (equipeer_equestrian_discipline)
	 * Add content (equipeer_equestrian_discipline)
	 *
	 * Url: /wp-admin/edit-tags.php?taxonomy=equipeer_equestrian_discipline&post_type=equine
	 *
	 * @return string
	 */
	function add_equipeer_equestrian_discipline_columns($columns) {
		unset($columns['posts']);
		$columns[$this->equine_type] = __( 'Equine Type', EQUIPEER_ID );
		return $columns;
	}
	function add_equipeer_equestrian_discipline_column_content($content, $column_name, $term_id) {
		// $term = get_term($term_id, 'equipeer_equestrian_discipline');
		switch($column_name) {
			case $this->equine_type;
				return $this->get_data_translate( get_term_meta($term_id, $this->equine_type, true) );
			break;
			default:
				return $content;
			break;
		}
	}
	
	/**
	 * Create GENRES Category Taxonomy (Sexe)
	 *
	 * @return void
	 */
	function create_gender_taxonomy() {
		// Labels part for the GUI
		$labels = array(
			'name'                       => __( 'Genders', EQUIPEER_ID ),
			'singular_name'              => __( 'Gender', EQUIPEER_ID ),
			'search_items'               => __( 'Search Genders', EQUIPEER_ID  ),
			'popular_items'              => __( 'Popular Genders', EQUIPEER_ID  ),
			'all_items'                  => __( 'All Genders', EQUIPEER_ID  ),
			'parent_item'                => null, // __( 'Parent Category' )
			'parent_item_colon'          => null, // __( 'Parent Category:' )
			'edit_item'                  => __( 'Edit Gender', EQUIPEER_ID  ), 
			'update_item'                => __( 'Update Gender', EQUIPEER_ID  ),
			'add_new_item'               => __( 'Add New Gender', EQUIPEER_ID  ),
			'new_item_name'              => __( 'New Gender Name', EQUIPEER_ID  ),
			'separate_items_with_commas' => __( 'Separate Genders with commas', EQUIPEER_ID  ),
			'add_or_remove_items'        => __( 'Add or remove genders', EQUIPEER_ID  ),
			'choose_from_most_used'      => __( 'Choose from the most used genders', EQUIPEER_ID  ),
			'menu_name'                  => __( 'Genders', EQUIPEER_ID  ),
			'back_to_items'              => 'Retour aux sexes'
		);
		// Now register the non-hierarchical taxonomy like tag
		register_taxonomy('equipeer_gender', $this->post_type, array(
			'hierarchical'       => false, // true if parent_item not null
			'labels'             => $labels,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_admin_column'  => false,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'capabilities'       => $this->capabilities,
			'rewrite'            => array( 'slug' => 'gender' ),
		));
		register_taxonomy_for_object_type( 'equipeer_gender', 'equine' );
	}
	/**
	 * Add column (equipeer_gender)
	 * Add content (equipeer_gender)
	 *
	 * Url: /wp-admin/edit-tags.php?taxonomy=equipeer_gender&post_type=equine
	 *
	 * @return string
	 */
	function add_equipeer_gender_columns($columns) {
		unset($columns['posts']);
		$columns[$this->equine_type] = __( 'Equine Type', EQUIPEER_ID );
		return $columns;
	}
	function add_equipeer_gender_column_content($content, $column_name, $term_id) {
		// $term = get_term($term_id, 'equipeer_gender');
		switch($column_name) {
			case $this->equine_type;
				return $this->get_data_translate( get_term_meta($term_id, $this->equine_type, true) );
			break;
			default:
				return $content;
			break;
		}
	}
	
	/**
	 * Create AGE Category Taxonomy
	 *
	 * @return void
	 */
	function create_age_taxonomy() {
		// Labels part for the GUI
		$labels = array(
			'name'                       => __( 'Ages', EQUIPEER_ID ),
			'singular_name'              => __( 'Age', EQUIPEER_ID ),
			'search_items'               => __( 'Search Ages', EQUIPEER_ID  ),
			'popular_items'              => __( 'Popular Ages', EQUIPEER_ID  ),
			'all_items'                  => __( 'All Ages', EQUIPEER_ID  ),
			'parent_item'                => null, // __( 'Parent Category' )
			'parent_item_colon'          => null, // __( 'Parent Category:' )
			'edit_item'                  => __( 'Edit Age', EQUIPEER_ID  ), 
			'update_item'                => __( 'Update Age', EQUIPEER_ID  ),
			'add_new_item'               => __( 'Add New Age', EQUIPEER_ID  ),
			'new_item_name'              => __( 'New Age Name', EQUIPEER_ID  ),
			'separate_items_with_commas' => __( 'Separate Ages with commas', EQUIPEER_ID  ),
			'add_or_remove_items'        => __( 'Add or remove ages', EQUIPEER_ID  ),
			'choose_from_most_used'      => __( 'Choose from the most used ages', EQUIPEER_ID  ),
			'menu_name'                  => __( 'Ages', EQUIPEER_ID  ),
			'back_to_items'              => 'Retour aux ages'
		);
		// Now register the non-hierarchical taxonomy like tag
		register_taxonomy('equipeer_age', $this->post_type, array(
			'hierarchical'       => false, // true if parent_item not null
			'labels'             => $labels,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_admin_column'  => false,
			'query_var'          => true,
			'show_in_quick_edit' => false,
			'capabilities'       => $this->capabilities,
			'rewrite'            => array( 'slug' => 'age' ),
		));
		register_taxonomy_for_object_type( 'equipeer_age', 'equine' );
	}
	/**
	 * Add column (equipeer_age)
	 * Add content (equipeer_age)
	 *
	 * Url: /wp-admin/edit-tags.php?taxonomy=equipeer_age&post_type=equine
	 *
	 * @return string
	 */
	function add_equipeer_age_columns($columns) {
		unset($columns['posts']);
		$columns[$this->equine_type] = __( 'Equine Type', EQUIPEER_ID );
		return $columns;
	}
	function add_equipeer_age_column_content($content, $column_name, $term_id) {
		// $term = get_term($term_id, 'equipeer_age');
		switch($column_name) {
			case $this->equine_type;
				return $this->get_data_translate( get_term_meta($term_id, $this->equine_type, true) );
			break;
			default:
				return $content;
			break;
		}
	}
	
	/**
	 * Create NIVEAU Category Taxonomy
	 *
	 * @return void
	 */
	function create_niveau_taxonomy() {
		// Labels part for the GUI
		$labels = array(
			'name'                       => __( 'Levels', EQUIPEER_ID ),
			'singular_name'              => __( 'Level', EQUIPEER_ID ),
			'search_items'               => __( 'Search Levels', EQUIPEER_ID  ),
			'popular_items'              => __( 'Popular Levels', EQUIPEER_ID  ),
			'all_items'                  => __( 'All Levels', EQUIPEER_ID  ),
			'parent_item'                => null, // __( 'Parent Category' )
			'parent_item_colon'          => null, // __( 'Parent Category:' )
			'edit_item'                  => __( 'Edit Level', EQUIPEER_ID  ), 
			'update_item'                => __( 'Update Level', EQUIPEER_ID  ),
			'add_new_item'               => __( 'Add New Level', EQUIPEER_ID  ),
			'new_item_name'              => __( 'New Level Name', EQUIPEER_ID  ),
			'separate_items_with_commas' => __( 'Separate Levels with commas', EQUIPEER_ID  ),
			'add_or_remove_items'        => __( 'Add or remove levels', EQUIPEER_ID  ),
			'choose_from_most_used'      => __( 'Choose from the most used levels', EQUIPEER_ID  ),
			'menu_name'                  => __( 'Levels', EQUIPEER_ID  ),
			'back_to_items'              => 'Retour aux niveaux'
		);
		// Now register the non-hierarchical taxonomy like tag
		register_taxonomy('equipeer_level', $this->post_type, array(
			'hierarchical'       => false, // true if parent_item not null
			'labels'             => $labels,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_admin_column'  => false,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'capabilities'       => $this->capabilities,
			'rewrite'            => array( 'slug' => 'level' ),
		));
		register_taxonomy_for_object_type( 'equipeer_level', 'equine' );
	}
	/**
	 * Add column (equipeer_level)
	 * Add content (equipeer_level)
	 *
	 * Url: /wp-admin/edit-tags.php?taxonomy=equipeer_level&post_type=equine
	 *
	 * @return string
	 */
	function add_equipeer_level_columns($columns) {
		unset($columns['posts']);
		$columns[$this->equine_type]       = __( 'Equine Type', EQUIPEER_ID );
		$columns[$this->equine_discipline] = __( 'Disciplines', EQUIPEER_ID );
		return $columns;
	}
	function add_equipeer_level_column_content($content, $column_name, $term_id) {
		// $term = get_term($term_id, 'equipeer_level');
		switch($column_name) {
			case $this->equine_type:
				return $this->get_data_translate( get_term_meta($term_id, $this->equine_type, true) );
			break;
			case $this->equine_discipline:
				// Discipline 1
				$discipline_id = get_term_meta($term_id, $this->equine_discipline, true ); // Get ID
				$discipline    = get_term_by('id', $discipline_id, 'equipeer_discipline'); // Get Term INFOS
				// Discipline 2
				$discipline_2_id = get_term_meta($term_id, $this->equine_discipline_2, true ); // Get ID
				$discipline_2    = get_term_by('id', $discipline_2_id, 'equipeer_discipline'); // Get Term INFOS
				// Discipline 3
				$discipline_3_id = get_term_meta($term_id, $this->equine_discipline_3, true ); // Get ID
				$discipline_3    = get_term_by('id', $discipline_3_id, 'equipeer_discipline'); // Get Term INFOS
				
				return $discipline->name . ($discipline_2 ? '<br>'.$discipline_2->name : '') . ($discipline_3 ? '<br>'.$discipline_3->name : '');
			break;
			default:
				return $content;
			break;
		}
	}
	
	/**
	 * Create NIVEAU EQUESTRE Category Taxonomy
	 *
	 * @return void
	 */
	function create_niveau_equestre_taxonomy() {
		// Labels part for the GUI
		$labels = array(
			'name'                       => __( 'Equestrian Levels', EQUIPEER_ID ),
			'singular_name'              => __( 'Equestrian Level', EQUIPEER_ID ),
			'search_items'               => __( 'Search Equestrian Levels', EQUIPEER_ID  ),
			'popular_items'              => __( 'Popular Equestrian Levels', EQUIPEER_ID  ),
			'all_items'                  => __( 'All Equestrian Levels', EQUIPEER_ID  ),
			'parent_item'                => null, // __( 'Parent Category' )
			'parent_item_colon'          => null, // __( 'Parent Category:' )
			'edit_item'                  => __( 'Edit Equestrian Level', EQUIPEER_ID  ), 
			'update_item'                => __( 'Update Equestrian Level', EQUIPEER_ID  ),
			'add_new_item'               => __( 'Add New Equestrian Level', EQUIPEER_ID  ),
			'new_item_name'              => __( 'New Equestrian Level Name', EQUIPEER_ID  ),
			'separate_items_with_commas' => __( 'Separate Equestrian Levels with commas', EQUIPEER_ID  ),
			'add_or_remove_items'        => __( 'Add or remove equestrian levels', EQUIPEER_ID  ),
			'choose_from_most_used'      => __( 'Choose from the most used equestrian levels', EQUIPEER_ID  ),
			'menu_name'                  => __( 'Equestrian Levels', EQUIPEER_ID  ),
			'back_to_items'              => 'Retour aux niveaux équestres'
		);
		// Now register the non-hierarchical taxonomy like tag
		register_taxonomy('equipeer_equestrian_level', $this->post_type, array(
			'hierarchical'       => false, // true if parent_item not null
			'labels'             => $labels,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_admin_column'  => false,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'capabilities'       => $this->capabilities,
			'rewrite'            => array( 'slug' => 'equestrian-level' ),
		));
		register_taxonomy_for_object_type( 'equipeer_equestrian_level', 'equine' );
	}
	/**
	 * Add column (equipeer_equestrian_level)
	 * Add content (equipeer_equestrian_level)
	 *
	 * Url: /wp-admin/edit-tags.php?taxonomy=equipeer_equestrian_level&post_type=equine
	 *
	 * @return string
	 */
	function add_equipeer_equestrian_level_columns($columns) {
		unset($columns['posts']);
		$columns[$this->equine_type] = __( 'Equine Type', EQUIPEER_ID );
		return $columns;
	}
	function add_equipeer_equestrian_level_column_content($content, $column_name, $term_id) {
		// $term = get_term($term_id, 'equipeer_equestrian_level');
		switch($column_name) {
			case $this->equine_type;
				return $this->get_data_translate( get_term_meta($term_id, $this->equine_type, true) );
			break;
			default:
				return $content;
			break;
		}
	}
	
	/**
	 * Create POTENTIEL Category Taxonomy
	 *
	 * @return void
	 */
	function create_potentiel_taxonomy() {
		// Labels part for the GUI
		$labels = array(
			'name'                       => __( 'Potentials', EQUIPEER_ID ),
			'singular_name'              => __( 'Potential', EQUIPEER_ID ),
			'search_items'               => __( 'Search Potentials', EQUIPEER_ID  ),
			'popular_items'              => __( 'Popular Potentials', EQUIPEER_ID  ),
			'all_items'                  => __( 'All Potentials', EQUIPEER_ID  ),
			'parent_item'                => null, // __( 'Parent Category' )
			'parent_item_colon'          => null, // __( 'Parent Category:' )
			'edit_item'                  => __( 'Edit Potential', EQUIPEER_ID  ), 
			'update_item'                => __( 'Update Potential', EQUIPEER_ID  ),
			'add_new_item'               => __( 'Add New Potential', EQUIPEER_ID  ),
			'new_item_name'              => __( 'New Potential Name', EQUIPEER_ID  ),
			'separate_items_with_commas' => __( 'Separate Potentials with commas', EQUIPEER_ID  ),
			'add_or_remove_items'        => __( 'Add or remove potentials', EQUIPEER_ID  ),
			'choose_from_most_used'      => __( 'Choose from the most used potentials', EQUIPEER_ID  ),
			'menu_name'                  => __( 'Potentials', EQUIPEER_ID  ),
			'back_to_items'              => 'Retour aux potentiels'
		);
		// Now register the non-hierarchical taxonomy like tag
		register_taxonomy('equipeer_potential', $this->post_type, array(
			'hierarchical'       => false, // true if parent_item not null
			'labels'             => $labels,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_admin_column'  => false,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'capabilities'       => $this->capabilities,
			'rewrite'            => array( 'slug' => 'potential' ),
		));
		register_taxonomy_for_object_type( 'equipeer_potential', 'equine' );
	}
	/**
	 * Add column (equipeer_potential)
	 * Add content (equipeer_potential)
	 *
	 * Url: /wp-admin/edit-tags.php?taxonomy=equipeer_potential&post_type=equine
	 *
	 * @return string
	 */
	function add_equipeer_potential_columns($columns) {
		unset($columns['posts']);
		$columns[$this->equine_type] = __( 'Equine Type', EQUIPEER_ID );
		return $columns;
	}
	function add_equipeer_potential_column_content($content, $column_name, $term_id) {
		// $term = get_term($term_id, 'equipeer_potential');
		switch($column_name) {
			case $this->equine_type;
				return $this->get_data_translate( get_term_meta($term_id, $this->equine_type, true) );
			break;
			default:
				return $content;
			break;
		}
	}
	
	/**
	 * Create RACE Category Taxonomy
	 *
	 * @return void
	 */
	function create_race_taxonomy() {
		// Labels part for the GUI
		$labels = array(
			'name'                       => __( 'Breeds', EQUIPEER_ID ),
			'singular_name'              => __( 'Breed', EQUIPEER_ID ),
			'search_items'               => __( 'Search Breeds', EQUIPEER_ID  ),
			'popular_items'              => __( 'Popular Breeds', EQUIPEER_ID  ),
			'all_items'                  => __( 'All Breeds', EQUIPEER_ID  ),
			'parent_item'                => null, // __( 'Parent Category' )
			'parent_item_colon'          => null, // __( 'Parent Category:' )
			'edit_item'                  => __( 'Edit Breed', EQUIPEER_ID  ), 
			'update_item'                => __( 'Update Breed', EQUIPEER_ID  ),
			'add_new_item'               => __( 'Add New Breed', EQUIPEER_ID  ),
			'new_item_name'              => __( 'New Breed Name', EQUIPEER_ID  ),
			'separate_items_with_commas' => __( 'Separate Breeds with commas', EQUIPEER_ID  ),
			'add_or_remove_items'        => __( 'Add or remove breeds', EQUIPEER_ID  ),
			'choose_from_most_used'      => __( 'Choose from the most used breeds', EQUIPEER_ID  ),
			'menu_name'                  => __( 'Breeds', EQUIPEER_ID  ),
			'back_to_items'              => 'Retour aux races'
		);
		// Now register the non-hierarchical taxonomy like tag
		register_taxonomy('equipeer_breed', $this->post_type, array(
			'hierarchical'       => false, // true if parent_item not null
			'labels'             => $labels,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_admin_column'  => false,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'capabilities'       => $this->capabilities,
			'rewrite'            => array( 'slug' => 'breed' ),
		));
		register_taxonomy_for_object_type( 'equipeer_breed', 'equine' );
	}
	/**
	 * Add column (equipeer_breed)
	 * Add content (equipeer_breed)
	 *
	 * Url: /wp-admin/edit-tags.php?taxonomy=equipeer_breed&post_type=equine
	 *
	 * @return string
	 */
	function add_equipeer_breed_columns($columns) {
		unset($columns['posts']);
		$columns[$this->equine_type] = __( 'Equine Type', EQUIPEER_ID );
		return $columns;
	}
	function add_equipeer_breed_column_content($content, $column_name, $term_id) {
		// $term = get_term($term_id, 'equipeer_breed');
		switch($column_name) {
			case $this->equine_type;
				return $this->get_data_translate( get_term_meta($term_id, $this->equine_type, true) );
			break;
			default:
				return $content;
			break;
		}
	}
	
	/**
	 * Create ROBE Category Taxonomy
	 *
	 * @return void
	 */
	function create_robe_taxonomy() {
		// Labels part for the GUI
		$labels = array(
			'name'                       => __( 'Colors', EQUIPEER_ID ),
			'singular_name'              => __( 'Color', EQUIPEER_ID ),
			'search_items'               => __( 'Search Colors', EQUIPEER_ID  ),
			'popular_items'              => __( 'Popular Colors', EQUIPEER_ID  ),
			'all_items'                  => __( 'All Colors', EQUIPEER_ID  ),
			'parent_item'                => null, // __( 'Parent Category' )
			'parent_item_colon'          => null, // __( 'Parent Category:' )
			'edit_item'                  => __( 'Edit Color', EQUIPEER_ID  ), 
			'update_item'                => __( 'Update Color', EQUIPEER_ID  ),
			'add_new_item'               => __( 'Add New Color', EQUIPEER_ID  ),
			'new_item_name'              => __( 'New Color Name', EQUIPEER_ID  ),
			'separate_items_with_commas' => __( 'Separate Colors with commas', EQUIPEER_ID  ),
			'add_or_remove_items'        => __( 'Add or remove colors', EQUIPEER_ID  ),
			'choose_from_most_used'      => __( 'Choose from the most used colors', EQUIPEER_ID  ),
			'menu_name'                  => __( 'Colors', EQUIPEER_ID  ),
			'back_to_items'              => 'Retour aux robes'
		);
		// Now register the non-hierarchical taxonomy like tag
		register_taxonomy('equipeer_color', $this->post_type, array(
			'hierarchical'       => false, // true if parent_item not null
			'labels'             => $labels,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_admin_column'  => false,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'capabilities'       => $this->capabilities,
			'rewrite'            => array( 'slug' => 'color' ),
		));
		register_taxonomy_for_object_type( 'equipeer_color', 'equine' );
	}
	/**
	 * Add column (equipeer_color)
	 * Add content (equipeer_color)
	 *
	 * Url: /wp-admin/edit-tags.php?taxonomy=equipeer_color&post_type=equine
	 *
	 * @return string
	 */
	function add_equipeer_color_columns($columns) {
		unset($columns['posts']);
		$columns[$this->equine_type] = __( 'Equine Type', EQUIPEER_ID );
		return $columns;
	}
	function add_equipeer_color_column_content($content, $column_name, $term_id) {
		// $term = get_term($term_id, 'equipeer_breed');
		switch($column_name) {
			case $this->equine_type;
				return $this->get_data_translate( get_term_meta($term_id, $this->equine_type, true) );
			break;
			default:
				return $content;
			break;
		}
	}
	
	/**
	 * Create TAILLE Category Taxonomy
	 *
	 * @return void
	 */
	function create_taille_taxonomy() {
		// Labels part for the GUI
		$labels = array(
			'name'                       => __( 'Sizes', EQUIPEER_ID ),
			'singular_name'              => __( 'Size', EQUIPEER_ID ),
			'search_items'               => __( 'Search Sizes', EQUIPEER_ID  ),
			'popular_items'              => __( 'Popular Sizes', EQUIPEER_ID  ),
			'all_items'                  => __( 'All Sizes', EQUIPEER_ID  ),
			'parent_item'                => null, // __( 'Parent Category' )
			'parent_item_colon'          => null, // __( 'Parent Category:' )
			'edit_item'                  => __( 'Edit Size', EQUIPEER_ID  ), 
			'update_item'                => __( 'Update Size', EQUIPEER_ID  ),
			'add_new_item'               => __( 'Add New Size', EQUIPEER_ID  ),
			'new_item_name'              => __( 'New Size Name', EQUIPEER_ID  ),
			'separate_items_with_commas' => __( 'Separate Sizes with commas', EQUIPEER_ID  ),
			'add_or_remove_items'        => __( 'Add or remove sizes', EQUIPEER_ID  ),
			'choose_from_most_used'      => __( 'Choose from the most used sizes', EQUIPEER_ID  ),
			'menu_name'                  => __( 'Sizes', EQUIPEER_ID  ),
			'back_to_items'              => 'Retour aux tailles'
		);
		// Now register the non-hierarchical taxonomy like tag
		register_taxonomy('equipeer_size', $this->post_type, array(
			'hierarchical'       => false, // true if parent_item not null
			'labels'             => $labels,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_admin_column'  => false,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'capabilities'       => $this->capabilities,
			'rewrite'            => array( 'slug' => 'size' ),
		));
		register_taxonomy_for_object_type( 'equipeer_size', 'equine' );
	}
	/**
	 * Add column (equipeer_size)
	 * Add content (equipeer_size)
	 *
	 * Url: /wp-admin/edit-tags.php?taxonomy=equipeer_size&post_type=equine
	 *
	 * @return string
	 */
	function add_equipeer_size_columns($columns) {
		unset($columns['posts']);
		$columns[$this->equine_type] = __( 'Equine Type', EQUIPEER_ID );
		return $columns;
	}
	function add_equipeer_size_column_content($content, $column_name, $term_id) {
		// $term = get_term($term_id, 'equipeer_size');
		switch($column_name) {
			case $this->equine_type;
				return $this->get_data_translate( get_term_meta($term_id, $this->equine_type, true) );
			break;
			default:
				return $content;
			break;
		}
	}
	
	/**
	 * Create CAVALIER AGE Category Taxonomy
	 *
	 * @return void
	 */
	function create_cavalier_age_taxonomy() {
		// Labels part for the GUI
		$labels = array(
			'name'                       => __( 'Rider Ages', EQUIPEER_ID ),
			'singular_name'              => __( 'Rider Age', EQUIPEER_ID ),
			'search_items'               => __( 'Search Rider Ages', EQUIPEER_ID  ),
			'popular_items'              => __( 'Popular Rider Ages', EQUIPEER_ID  ),
			'all_items'                  => __( 'All Rider Ages', EQUIPEER_ID  ),
			'parent_item'                => null, // __( 'Parent Category' )
			'parent_item_colon'          => null, // __( 'Parent Category:' )
			'edit_item'                  => __( 'Edit Rider Age', EQUIPEER_ID  ), 
			'update_item'                => __( 'Update Rider Age', EQUIPEER_ID  ),
			'add_new_item'               => __( 'Add New Rider Age', EQUIPEER_ID  ),
			'new_item_name'              => __( 'New Rider Age Name', EQUIPEER_ID  ),
			'separate_items_with_commas' => __( 'Separate Rider Ages with commas', EQUIPEER_ID  ),
			'add_or_remove_items'        => __( 'Add or remove rider ages', EQUIPEER_ID  ),
			'choose_from_most_used'      => __( 'Choose from the most used rider ages', EQUIPEER_ID  ),
			'menu_name'                  => __( 'Rider Ages', EQUIPEER_ID  ),
			'back_to_items'              => 'Retour aux ages de cavaliers'
		);
		// Now register the non-hierarchical taxonomy like tag
		register_taxonomy('equipeer_rider_age', $this->post_type, array(
			'hierarchical'       => false, // true if parent_item not null
			'labels'             => $labels,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_admin_column'  => false,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'capabilities'       => $this->capabilities,
			'rewrite'            => array( 'slug' => 'rider-age' ),
		));
		register_taxonomy_for_object_type( 'equipeer_rider_age', 'equine' );
	}
	/**
	 * Add column (equipeer_rider_age)
	 * Add content (equipeer_rider_age)
	 *
	 * Url: /wp-admin/edit-tags.php?taxonomy=equipeer_rider_age&post_type=equine
	 *
	 * @return string
	 */
	function add_equipeer_rider_age_columns($columns) {
		unset($columns['posts']);
		$columns[$this->equine_type] = __( 'Equine Type', EQUIPEER_ID );
		return $columns;
	}
	function add_equipeer_rider_age_column_content($content, $column_name, $term_id) {
		// $term = get_term($term_id, 'equipeer_rider_age');
		switch($column_name) {
			case $this->equine_type;
				return $this->get_data_translate( get_term_meta($term_id, $this->equine_type, true) );
			break;
			default:
				return $content;
			break;
		}
	}
	
	/**
	 * Create CAVALIER COMPORTEMENT Category Taxonomy
	 *
	 * @return void
	 */
	function create_cavalier_comportement_taxonomy() {
		// Labels part for the GUI
		$labels = array(
			'name'                       => __( 'Rider Behaviors', EQUIPEER_ID ),
			'singular_name'              => __( 'Rider Behavior', EQUIPEER_ID ),
			'search_items'               => __( 'Search Rider Behaviors', EQUIPEER_ID  ),
			'popular_items'              => __( 'Popular Rider Behaviors', EQUIPEER_ID  ),
			'all_items'                  => __( 'All Rider Behaviors', EQUIPEER_ID  ),
			'parent_item'                => null, // __( 'Parent Category' )
			'parent_item_colon'          => null, // __( 'Parent Category:' )
			'edit_item'                  => __( 'Edit Rider Behavior', EQUIPEER_ID  ), 
			'update_item'                => __( 'Update Rider Behavior', EQUIPEER_ID  ),
			'add_new_item'               => __( 'Add New Rider Behavior', EQUIPEER_ID  ),
			'new_item_name'              => __( 'New Rider Behavior Name', EQUIPEER_ID  ),
			'separate_items_with_commas' => __( 'Separate Rider Behaviors with commas', EQUIPEER_ID  ),
			'add_or_remove_items'        => __( 'Add or remove rider behaviors', EQUIPEER_ID  ),
			'choose_from_most_used'      => __( 'Choose from the most used rider behaviors', EQUIPEER_ID  ),
			'menu_name'                  => __( 'Rider Behaviors', EQUIPEER_ID  ),
			'back_to_items'              => 'Retour aux comportements de cavaliers'
		);
		// Now register the non-hierarchical taxonomy like tag
		register_taxonomy('equipeer_rider_behavior', $this->post_type, array(
			'hierarchical'       => false, // true if parent_item not null
			'labels'             => $labels,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_admin_column'  => false,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'capabilities'       => $this->capabilities,
			'rewrite'            => array( 'slug' => 'rider-behavior' ),
		));
		register_taxonomy_for_object_type( 'equipeer_rider_behavior', 'equine' );
	}
	/**
	 * Add column (equipeer_rider_behavior)
	 * Add content (equipeer_rider_behavior)
	 *
	 * Url: /wp-admin/edit-tags.php?taxonomy=equipeer_rider_behavior&post_type=equine
	 *
	 * @return string
	 */
	function add_equipeer_rider_behavior_columns($columns) {
		unset($columns['posts']);
		$columns[$this->equine_type] = __( 'Equine Type', EQUIPEER_ID );
		return $columns;
	}
	function add_equipeer_rider_behavior_column_content($content, $column_name, $term_id) {
		// $term = get_term($term_id, 'equipeer_rider_behavior');
		switch($column_name) {
			case $this->equine_type;
				return $this->get_data_translate( get_term_meta($term_id, $this->equine_type, true) );
			break;
			default:
				return $content;
			break;
		}
	}
	
	/**
	 * Create CAVALIER GENRE Category Taxonomy
	 *
	 * @return void
	 */
	function create_cavalier_genre_taxonomy() {
		// Labels part for the GUI
		$labels = array(
			'name'                       => __( 'Rider Genders', EQUIPEER_ID ),
			'singular_name'              => __( 'Rider Gender', EQUIPEER_ID ),
			'search_items'               => __( 'Search Rider Genders', EQUIPEER_ID  ),
			'popular_items'              => __( 'Popular Rider Genders', EQUIPEER_ID  ),
			'all_items'                  => __( 'All Rider Genders', EQUIPEER_ID  ),
			'parent_item'                => null, // __( 'Parent Category' )
			'parent_item_colon'          => null, // __( 'Parent Category:' )
			'edit_item'                  => __( 'Edit Rider Gender', EQUIPEER_ID  ), 
			'update_item'                => __( 'Update Rider Gender', EQUIPEER_ID  ),
			'add_new_item'               => __( 'Add New Rider Gender', EQUIPEER_ID  ),
			'new_item_name'              => __( 'New Rider Gender Name', EQUIPEER_ID  ),
			'separate_items_with_commas' => __( 'Separate Rider Genders with commas', EQUIPEER_ID  ),
			'add_or_remove_items'        => __( 'Add or remove rider genders', EQUIPEER_ID  ),
			'choose_from_most_used'      => __( 'Choose from the most used rider genders', EQUIPEER_ID  ),
			'menu_name'                  => __( 'Rider Genders', EQUIPEER_ID  ),
			'back_to_items'              => 'Retour aux genres de cavalier'
		);
		// Now register the non-hierarchical taxonomy like tag
		register_taxonomy('equipeer_rider_gender', $this->post_type, array(
			'hierarchical'       => false, // true if parent_item not null
			'labels'             => $labels,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_admin_column'  => false,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'capabilities'       => $this->capabilities,
			'rewrite'            => array( 'slug' => 'rider-gender' ),
		));
		register_taxonomy_for_object_type( 'equipeer_rider_gender', 'equine' );
	}
	/**
	 * Add column (equipeer_rider_gender)
	 * Add content (equipeer_rider_gender)
	 *
	 * Url: /wp-admin/edit-tags.php?taxonomy=equipeer_rider_gender&post_type=equine
	 *
	 * @return string
	 */
	function add_equipeer_rider_gender_columns($columns) {
		unset($columns['posts']);
		$columns[$this->equine_type] = __( 'Equine Type', EQUIPEER_ID );
		return $columns;
	}
	function add_equipeer_rider_gender_column_content($content, $column_name, $term_id) {
		// $term = get_term($term_id, 'equipeer_rider_gender');
		switch($column_name) {
			case $this->equine_type;
				return $this->get_data_translate( get_term_meta($term_id, $this->equine_type, true) );
			break;
			default:
				return $content;
			break;
		}
	}
	
	/**
	 * Create CAVALIER NIVEAU Category Taxonomy
	 *
	 * @return void
	 */
	function create_cavalier_niveau_taxonomy() {
		// Labels part for the GUI
		$labels = array(
			'name'                       => __( 'Rider Levels', EQUIPEER_ID ),
			'singular_name'              => __( 'Rider Level', EQUIPEER_ID ),
			'search_items'               => __( 'Search Rider Levels', EQUIPEER_ID  ),
			'popular_items'              => __( 'Popular Rider Levels', EQUIPEER_ID  ),
			'all_items'                  => __( 'All Rider Levels', EQUIPEER_ID  ),
			'parent_item'                => null, // __( 'Parent Category' )
			'parent_item_colon'          => null, // __( 'Parent Category:' )
			'edit_item'                  => __( 'Edit Rider Level', EQUIPEER_ID  ), 
			'update_item'                => __( 'Update Rider Level', EQUIPEER_ID  ),
			'add_new_item'               => __( 'Add New Rider Level', EQUIPEER_ID  ),
			'new_item_name'              => __( 'New Rider Level Name', EQUIPEER_ID  ),
			'separate_items_with_commas' => __( 'Separate Rider Levels with commas', EQUIPEER_ID  ),
			'add_or_remove_items'        => __( 'Add or remove rider levels', EQUIPEER_ID  ),
			'choose_from_most_used'      => __( 'Choose from the most used rider levels', EQUIPEER_ID  ),
			'menu_name'                  => __( 'Rider Levels', EQUIPEER_ID  ),
			'back_to_items'              => 'Retour aux niveaux de cavaliers'
		);
		// Now register the non-hierarchical taxonomy like tag
		register_taxonomy('equipeer_rider_level', $this->post_type, array(
			'hierarchical'       => false, // true if parent_item not null
			'labels'             => $labels,
			'show_ui'            => true,
			'show_in_menu'       => false,
			'show_admin_column'  => false,
			'show_in_quick_edit' => false,
			'query_var'          => true,
			'capabilities'       => $this->capabilities,
			'rewrite'            => array( 'slug' => 'rider-level' ),
		));
		register_taxonomy_for_object_type( 'equipeer_rider_level', 'equine' );
	}
	/**
	 * Add column (equipeer_rider_level)
	 * Add content (equipeer_rider_level)
	 *
	 * Url: /wp-admin/edit-tags.php?taxonomy=equipeer_rider_level&post_type=equine
	 *
	 * @return string
	 */
	function add_equipeer_rider_level_columns($columns) {
		unset($columns['posts']);
		$columns[$this->equine_type] = __( 'Equine Type', EQUIPEER_ID );
		return $columns;
	}
	function add_equipeer_rider_level_column_content($content, $column_name, $term_id) {
		// $term = get_term($term_id, 'equipeer_rider_level');
		switch($column_name) {
			case $this->equine_type;
				return $this->get_data_translate( get_term_meta($term_id, $this->equine_type, true) );
			break;
			default:
				return $content;
			break;
		}
	}
	
	/**
	 * Get TEXT translation
	 *
	 * @return string
	 */
	function get_data_translate($data) {
		switch( strtolower($data) ) {
			case "horse":
				return __( 'Horse', EQUIPEER_ID );
			break;
			case "pony":
				return __( 'Pony', EQUIPEER_ID );
			break;
			default:
				return __( 'Unknown', EQUIPEER_ID );
			break;
		}
	}

	/**
	 * Add admin notice in taxonomies pages (equipeer only)
	 *
	 * @return string
	 */
	function taxonomy_admin_notice(){
		global $pagenow;
		$_get = @$_GET['taxonomy'];
		if ( $pagenow == 'edit-tags.php' && strpos($_get, 'equipeer_') !== false ) {
			echo '<div class="notice notice-warning is-dismissible">
					<p>
						<span class="dashicons dashicons-search"></span>
						Pour effectuer une recherche par "Type d\'équidés",<br>tapez \'horse\' pour Cheval et \'pony\' pour Poney
					</p>
				  </div>';
		}
	}
	
}