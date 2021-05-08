<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Shortcodes
 *
 * @class Shortcodes
 */
class Equipeer_Upgrade extends Equipeer {

    /**
     * Constructor loader function
     *
     * Load autometically when class instantiate.
     *
     * @since 1.1
     */
    function __construct() {
		// Check if needs upadate
		if ( $this->is_needs_update() ) add_action( 'admin_init', array( $this, 'do_updates' ) );
    }

    /**
     * Check if need any update
     *
     * @since 1.1
     *
     * @return boolean
     */
    public function is_needs_update() {
		// Old version
		$installed_version = get_option( 'equipeer_plugin_version' );
		
		// New version
		$plugin_version    = $this->get_plugin_infos('Version');
		
		// Compare version
		return ( is_admin() && $installed_version != $plugin_version ) ? true : false;
    }
	
    /**
     * Perform all updates
     *
     * @since 1.1
     *
     * @return void
     */
    public function do_updates() {
        // Update Version
		update_option( 'equipeer_plugin_version', $this->get_plugin_infos('Version') );
		
		// Update Roles / DB
        $this->user_roles();
		$this->create_tables();

		// Force Rules / Links (permanent)		
		flush_rewrite_rules();
    }
	
    /**
     * Init Equipeer user roles
     *
     * @since 1.2
     *
     * @global WP_Roles $wp_roles
     */
    function user_roles() {
        global $wp_roles;

        if ( class_exists( 'WP_Roles' ) && ! isset( $wp_roles ) ) {
            $wp_roles = new WP_Roles();
        }
		
        add_role( 'equipeer_client', __( 'Client EQUIPEER', EQUIPEER_ID ), array(
            'read'                      => true,
            'publish_posts'             => false,
            'edit_posts'                => false,
            'delete_published_posts'    => false,
            'edit_published_posts'      => false,
            'delete_posts'              => false,
            'manage_categories'         => false,
            'moderate_comments'         => false,
            'unfiltered_html'           => false,
            'upload_files'              => false,
            'edit_shop_orders'          => false,
            'edit_product'              => false,
            'read_product'              => false,
            'delete_product'            => false,
            'edit_products'             => false,
            'publish_products'          => false,
            'read_private_products'     => false,
            'delete_products'           => false,
            'delete_products'           => false,
            'delete_private_products'   => false,
            'delete_published_products' => false,
            'delete_published_products' => false,
            'edit_private_products'     => false,
            'edit_published_products'   => false,
            'manage_product_terms'      => false,
            'delete_product_terms'      => false,
            'assign_product_terms'      => false
        ) );

		// Capabilities for roles
		$roles = [
			'administrator',
			'editor',
			'author'
		];
		foreach ( $roles as $role ) {
			$role = get_role( $role );
			if ( empty( $role ) ) {
				continue;
			}

			// From get_post_type_capabilities()
			$role->add_cap( 'equipeer_read_equine' );
			$role->add_cap( 'equipeer_edit_equine' );
			$role->add_cap( 'equipeer_edit_others_equines' );
			$role->add_cap( 'equipeer_delete_equine' );
			$role->add_cap( 'equipeer_delete_others_equines' );

			// Custom capabilities
			$role->add_cap( 'equipeer_list_tables' );
			$role->add_cap( 'equipeer_add_equine' );
			$role->add_cap( 'equipeer_copy_equines' );
			$role->add_cap( 'equipeer_access_options_screen' );
			$role->add_cap( 'equipeer_access_about_screen' );
		}

		// Capabilities for single roles
		$role = get_role( 'administrator' );
		if ( ! empty( $role ) ) {
			$role->add_cap( 'equipeer_import_equines' );
			$role->add_cap( 'equipeer_edit_options' );
			$role->add_cap( 'equipeer_manage_categories' );
		}

		// Refresh current set of capabilities of the user, to be able to directly use the new caps.
		$user = wp_get_current_user();
		$user->get_role_caps();
    }
	
    /**
     * Create necessary tables
     *
     * @since 1.1
     *
     * @return void
     */
    function create_tables() {
        include_once ABSPATH . 'wp-admin/includes/upgrade.php';

        $this->create_annonce_table();
        $this->create_equestrian_discipline_table();
        $this->create_equestrian_level_table();
		$this->create_group_table();
		$this->create_selectionneur_age_table();
		$this->create_selectionneur_cavalier_age_table();
		$this->create_selectionneur_cavalier_comportement_table();
		$this->create_selectionneur_cavalier_genre_table();
		$this->create_selectionneur_cavalier_niveau_table();
		$this->create_selectionneur_discipline_table();
		$this->create_selectionneur_niveau_table();
		$this->create_selectionneur_potentiel_table();
		$this->create_selectionneur_race_table();
		$this->create_selectionneur_robe_table();
		$this->create_selectionneur_sexe_table();
		$this->create_selectionneur_taille_table();
		$this->create_selection_sport_table();
		$this->create_ville_table();	
    }
	
    /**
     * Create ANNONCE table
     *
     * @return void
     */
    function create_annonce_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_annonce}` (
				`id` bigint(20) NOT NULL AUTO_INCREMENT,
				`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`date_maj` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`reference` int(11) NOT NULL,
				`sire` varchar(30) DEFAULT NULL,
				`nom` text NOT NULL,
				`phone` varchar(20) DEFAULT NULL,
				`proprietaire` text,
				`photo_licol` varchar(255) DEFAULT NULL,
				`photo_plat` varchar(255) DEFAULT NULL,
				`video_plat` text,
				`video_tour` text,
				`video_saut` text,
				`video_html5` varchar(255) DEFAULT NULL,
				`localisation_adresse` varchar(255) DEFAULT NULL,
				`localisation_ville` varchar(100) DEFAULT NULL,
				`localisation_code_postal` varchar(10) DEFAULT NULL,
				`localisation_latitude` varchar(50) DEFAULT NULL,
				`localisation_longitude` varchar(50) DEFAULT NULL,
				`lieux_essais` text,
				`discipline` int(11) DEFAULT NULL,
				`niveau` int(11) DEFAULT NULL,
				`niveau_text` text,
				`race` int(11) DEFAULT NULL,
				`taille` int(11) DEFAULT NULL,
				`taille_cm` int(11) DEFAULT NULL,
				`age` int(11) DEFAULT NULL,
				`robe` int(11) DEFAULT NULL,
				`sexe` int(11) DEFAULT NULL,
				`price` tinyint(4) NOT NULL DEFAULT '5' COMMENT '1 a 5',
				`price_real` int(11) DEFAULT NULL,
				`impression` text,
				`descriptif_detail_1` text,
				`descriptif_detail_2` text,
				`modele` text,
				`aplomb` text,
				`allure` text,
				`comportement` text,
				`plat_souplesse` tinyint(4) DEFAULT NULL,
				`plat_sang` tinyint(4) DEFAULT NULL,
				`plat_disponibilite` tinyint(4) DEFAULT NULL,
				`plat_bouche` tinyint(4) DEFAULT NULL,
				`plat_confort` tinyint(4) DEFAULT NULL,
				`plat_caractere` tinyint(4) DEFAULT NULL,
				`plat_stabilite` tinyint(4) DEFAULT NULL,
				`impression_plat` text,
				`obstacle_caractere` tinyint(4) DEFAULT NULL,
				`obstacle_disponibilite` tinyint(4) DEFAULT NULL,
				`obstacle_equilibre` tinyint(4) DEFAULT NULL,
				`obstacle_style` tinyint(4) DEFAULT NULL,
				`obstacle_experience` tinyint(4) DEFAULT NULL,
				`obstacle_stabilite` tinyint(4) DEFAULT NULL,
				`obstacle_7` tinyint(4) DEFAULT NULL,
				`obstacle_8` tinyint(4) DEFAULT NULL,
				`impression_obstacle` text,
				`saut_envergure` tinyint(4) DEFAULT NULL,
				`saut_moyen` tinyint(4) DEFAULT NULL,
				`saut_style` tinyint(4) DEFAULT NULL,
				`saut_equilibre` tinyint(4) DEFAULT NULL,
				`saut_intelligence` tinyint(4) DEFAULT NULL,
				`saut_respect` tinyint(4) DEFAULT NULL,
				`saut_7` tinyint(4) DEFAULT NULL,
				`saut_8` tinyint(4) DEFAULT NULL,
				`saut_9` tinyint(4) DEFAULT NULL,
				`saut_10` tinyint(4) DEFAULT NULL,
				`saut_11` tinyint(4) DEFAULT NULL,
				`saut_12` tinyint(4) DEFAULT NULL,
				`impression_saut` text,
				`competition_100` text,
				`competition_110` text,
				`competition_115` text,
				`competition_120` text,
				`competition_130` text,
				`competition_135` text,
				`competition_140` text,
				`competition_140_plus` text,
				`competition_9` text,
				`potentiel` varchar(5) DEFAULT NULL,
				`potentiel_text` text,
				`cavalier_genre` int(11) DEFAULT NULL,
				`cavalier_niveau` int(11) DEFAULT NULL,
				`cavalier_age` int(11) DEFAULT NULL,
				`cavalier_comportement` int(11) DEFAULT NULL,
				`cavalier_profil` text,
				`date_veto` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
				`antecedent` text NOT NULL,
				`essai` text NOT NULL,
				`cavalier_anterieur` text,
				`origin_sire` varchar(255) NOT NULL,
				`origin_sire_sire` varchar(255) NOT NULL,
				`origin_sire_dam` varchar(255) NOT NULL,
				`origin_dam` varchar(255) DEFAULT NULL,
				`origin_dam_sire` varchar(255) DEFAULT NULL,
				`origin_dam_dam` varchar(255) DEFAULT NULL,
				`active` tinyint(4) NOT NULL DEFAULT '1',
				`vendu` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: non vendu, 1: vendu',
				PRIMARY KEY (id)
			  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        dbDelta( $sql );
    }

    /**
     * Create EQUESTRIAN DISCIPLINE table
     *
     * @return void
     */
    function create_equestrian_discipline_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_equestrian_discipline}` (
				`id` int(11) NOT NULL,
				`catid` int(11) NOT NULL DEFAULT '1' COMMENT 'Category ID',
				`title` varchar(255) NOT NULL,
				`description` varchar(255) DEFAULT NULL,
				`sort` int(11) NOT NULL DEFAULT '0',
				`active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: inactive, 1: active',
				PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Disciplines equestres' AUTO_INCREMENT=1;";

        dbDelta( $sql );
    }
	
    /**
     * Create EQUESTRIAN DISCIPLINE table
     *
     * @return void
     */
    function create_equestrian_level_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_equestrian_level}` (
				`id` int(11) NOT NULL,
				`catid` int(11) NOT NULL DEFAULT '1' COMMENT 'Category ID',
				`title` varchar(255) NOT NULL,
				`description` varchar(255) DEFAULT NULL,
				`sort` int(11) NOT NULL DEFAULT '0',
				`active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: inactive, 1: active',
				PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Niveaux equestres' AUTO_INCREMENT=1;";

        dbDelta( $sql );
    }
	
    /**
     * Create GROUP table
     *
     * @return void
     */
    function create_group_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_group}` (
				`id` int(11) NOT NULL,
				`catid` int(11) NOT NULL DEFAULT '1' COMMENT 'Category ID',
				`name` varchar(255) NOT NULL,
				`description` text DEFAULT NULL,
				`active` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0: inactive, 1: active',
				PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Groupes' AUTO_INCREMENT=1;";

        dbDelta( $sql );
    }
	
    /**
     * Create SELECTIONNEUR CAVALIER AGE table
     *
     * @return void
     */
    function create_category_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_selectionneur_cavalier_age}` (
				`id` int(11) NOT NULL,
				`catid` int(11) NOT NULL DEFAULT '1' COMMENT 'Category ID',
				`name` text NOT NULL,
				`description` text DEFAULT NULL,
				`active` tinyint(4) NOT NULL,
				`sort` int(11) NOT NULL,
				PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        dbDelta( $sql );
    }

    /**
     * Create SELECTIONNEUR AGE table
     *
     * @return void
     */
    function create_selectionneur_age_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_selectionneur_age}` (
				`id` int(11) NOT NULL,
				`catid` int(11) NOT NULL DEFAULT '1' COMMENT 'Category ID',
				`name` text NOT NULL,
				`description` text DEFAULT NULL,
				`active` tinyint(4) NOT NULL,
				`sort` int(11) NOT NULL,
				PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Groupes' AUTO_INCREMENT=1;";

        dbDelta( $sql );
    }

    /**
     * Create SELECTIONNEUR CAVALIER AGE table
     *
     * @return void
     */
    function create_selectionneur_cavalier_age_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_selectionneur_cavalier_age}` (
				`id` int(11) NOT NULL,
				`catid` int(11) NOT NULL DEFAULT '1' COMMENT 'Category ID',
				`name` text NOT NULL,
				`description` text DEFAULT NULL,
				`active` tinyint(4) NOT NULL,
				`sort` int(11) NOT NULL,
				PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        dbDelta( $sql );
    }
	
    /**
     * Create SELECTIONNEUR CAVALIER COMPORTEMENT table
     *
     * @return void
     */
    function create_selectionneur_cavalier_comportement_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_selectionneur_cavalier_comportement}` (
				`id` int(11) NOT NULL,
				`catid` int(11) NOT NULL DEFAULT '1' COMMENT 'Category ID',
				`name` text NOT NULL,
				`description` text DEFAULT NULL,
				`active` tinyint(4) NOT NULL,
				`sort` int(11) NOT NULL,
				PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        dbDelta( $sql );
    }

    /**
     * Create SELECTIONNEUR CAVALIER GENRE table
     *
     * @return void
     */
    function create_selectionneur_cavalier_genre_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_selectionneur_cavalier_genre}` (
				`id` int(11) NOT NULL,
				`catid` int(11) NOT NULL DEFAULT '1' COMMENT 'Category ID',
				`name` text NOT NULL,
				`description` text DEFAULT NULL,
				`active` tinyint(4) NOT NULL,
				`sort` int(11) NOT NULL,
				PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        dbDelta( $sql );
    }
	
	/**
     * Create SELECTIONNEUR CAVALIER NIVEAU table
     *
     * @return void
     */
    function create_selectionneur_cavalier_niveau_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_selectionneur_cavalier_niveau}` (
				`id` int(11) NOT NULL,
				`catid` int(11) NOT NULL DEFAULT '1' COMMENT 'Category ID',
				`name` text NOT NULL,
				`description` text DEFAULT NULL,
				`active` tinyint(4) NOT NULL,
				`sort` int(11) NOT NULL,
				PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        dbDelta( $sql );
    }
	
	/**
     * Create SELECTIONNEUR DISCIPLINE table
     *
     * @return void
     */
    function create_selectionneur_discipline_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_selectionneur_discipline}` (
				`id` int(11) NOT NULL,
				`catid` int(11) NOT NULL DEFAULT '1' COMMENT 'Category ID',
				`name` text NOT NULL,
				`description` text DEFAULT NULL,
				`prefix` varchar(2) NOT NULL,
				`active` tinyint(4) NOT NULL,
				`sort` int(11) NOT NULL,
				PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        dbDelta( $sql );
    }
	
	/**
     * Create SELECTIONNEUR NIVEAU table
     *
     * @return void
     */
    function create_selectionneur_niveau_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_selectionneur_niveau}` (
				`id` int(11) NOT NULL,
				`catid` int(11) NOT NULL DEFAULT '1' COMMENT 'Category ID',
				`name` text NOT NULL,
				`description` text DEFAULT NULL,
				`active` tinyint(4) NOT NULL,
				`sort` int(11) NOT NULL,
				PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        dbDelta( $sql );
    }
	
	/**
     * Create SELECTIONNEUR POTENTIEL table
     *
     * @return void
     */
    function create_selectionneur_potentiel_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_selectionneur_potentiel}` (
				`id` int(11) NOT NULL,
				`catid` int(11) NOT NULL DEFAULT '1' COMMENT 'Category ID',
				`name` text NOT NULL,
				`description` text DEFAULT NULL,
				`active` tinyint(4) NOT NULL,
				`sort` int(11) NOT NULL,
				PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        dbDelta( $sql );
    }
	
	/**
     * Create SELECTIONNEUR RACE table
     *
     * @return void
     */
    function create_selectionneur_race_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_selectionneur_race}` (
				`id` int(11) NOT NULL,
				`catid` int(11) NOT NULL DEFAULT '1' COMMENT 'Category ID',
				`name` text NOT NULL,
				`description` text DEFAULT NULL,
				`active` tinyint(4) NOT NULL,
				`sort` int(11) NOT NULL,
				PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        dbDelta( $sql );
    }

	/**
     * Create SELECTIONNEUR ROBE table
     *
     * @return void
     */
    function create_selectionneur_robe_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_selectionneur_robe}` (
				`id` int(11) NOT NULL,
				`catid` int(11) NOT NULL DEFAULT '1' COMMENT 'Category ID',
				`name` text NOT NULL,
				`description` text DEFAULT NULL,
				`active` tinyint(4) NOT NULL,
				`sort` int(11) NOT NULL,
				PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        dbDelta( $sql );
    }

	/**
     * Create SELECTIONNEUR SEXE table
     *
     * @return void
     */
    function create_selectionneur_sexe_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_selectionneur_sexe}` (
				`id` int(11) NOT NULL,
				`catid` int(11) NOT NULL DEFAULT '1' COMMENT 'Category ID',
				`name` text NOT NULL,
				`description` text DEFAULT NULL,
				`active` tinyint(4) NOT NULL,
				`sort` int(11) NOT NULL,
				PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        dbDelta( $sql );
    }
	
	/**
     * Create SELECTIONNEUR TAILLE table
     *
     * @return void
     */
    function create_selectionneur_taille_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_selectionneur_taille}` (
				`id` int(11) NOT NULL,
				`catid` int(11) NOT NULL DEFAULT '1' COMMENT 'Category ID',
				`name` text NOT NULL,
				`description` text DEFAULT NULL,
				`active` tinyint(4) NOT NULL,
				`sort` int(11) NOT NULL,
				PRIMARY KEY (id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

        dbDelta( $sql );
    }

	/**
     * Create SELECTION SPORT table
     *
     * @return void
     */
    function create_selection_sport_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_selection_sport}` (
				`uid` int(11) NOT NULL COMMENT 'ID User',
				`pid` int(11) NOT NULL COMMENT 'ID Product'
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

        dbDelta( $sql );
    }
	
	/**
     * Create VILLE table
     *
     * @return void
     */
    function create_ville_table() {
        global $wpdb;
			
		$sql = "CREATE TABLE `{$wpdb->equipeer_ville}` (
				`ville_id` bigint(20) UNSIGNED NOT NULL,
				`ville_departement` varchar(3) DEFAULT NULL,
				`ville_slug` varchar(255) DEFAULT NULL,
				`ville_nom` varchar(45) DEFAULT NULL,
				`ville_nom_simple` varchar(45) DEFAULT NULL,
				`ville_nom_reel` varchar(45) DEFAULT NULL,
				`ville_nom_soundex` varchar(20) DEFAULT NULL,
				`ville_nom_metaphone` varchar(22) DEFAULT NULL,
				`ville_code_postal` varchar(255) DEFAULT NULL,
				`ville_commune` varchar(3) DEFAULT NULL,
				`ville_code_commune` varchar(5) NOT NULL,
				`ville_arrondissement` smallint(3) UNSIGNED DEFAULT NULL,
				`ville_canton` varchar(4) DEFAULT NULL,
				`ville_amdi` smallint(5) UNSIGNED DEFAULT NULL,
				`ville_population_2010` mediumint(11) UNSIGNED DEFAULT NULL,
				`ville_population_1999` mediumint(11) UNSIGNED DEFAULT NULL,
				`ville_population_2012` mediumint(10) UNSIGNED DEFAULT NULL COMMENT 'approximatif',
				`ville_densite_2010` int(11) DEFAULT NULL,
				`ville_surface` float DEFAULT NULL,
				`ville_longitude_deg` float DEFAULT NULL,
				`ville_latitude_deg` float DEFAULT NULL,
				`ville_longitude_grd` varchar(9) DEFAULT NULL,
				`ville_latitude_grd` varchar(8) DEFAULT NULL,
				`ville_longitude_dms` varchar(9) DEFAULT NULL,
				`ville_latitude_dms` varchar(8) DEFAULT NULL,
				`ville_zmin` mediumint(4) DEFAULT NULL,
				`ville_zmax` mediumint(4) DEFAULT NULL,
				PRIMARY KEY (ville_id)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
				ALTER TABLE `9h7Jo_sb_equi_ville`
				ADD UNIQUE KEY `ville_code_commune_2` (`ville_code_commune`),
				ADD UNIQUE KEY `ville_slug` (`ville_slug`),
				ADD KEY `ville_departement` (`ville_departement`),
				ADD KEY `ville_nom` (`ville_nom`),
				ADD KEY `ville_nom_reel` (`ville_nom_reel`),
				ADD KEY `ville_code_commune` (`ville_code_commune`),
				ADD KEY `ville_code_postal` (`ville_code_postal`),
				ADD KEY `ville_longitude_latitude_deg` (`ville_longitude_deg`,`ville_latitude_deg`),
				ADD KEY `ville_nom_soundex` (`ville_nom_soundex`),
				ADD KEY `ville_nom_metaphone` (`ville_nom_metaphone`),
				ADD KEY `ville_population_2010` (`ville_population_2010`),
				ADD KEY `ville_nom_simple` (`ville_nom_simple`);";

        dbDelta( $sql );
    }
	
}