<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class
 *
 * @class Equipeer - The class that holds the entire Equipeer plugin
 */
class Equipeer {

    /**
     * Instance of self
     *
     * @var Equipeer
     */
    private static $instance = null;

    /**
     * Holds various infos
     *
     * @var string
     */
    public $slug       = 'annonces';
    public $post_type  = 'equine';
    public $single_tpl = 'equine-single.php';
    
    /**
     * Minimum PHP version required
     *
     * @var string
     */
    private $min_php = '7.2.0';

    /**
     * Holds various class instances
     *
     * @var array
     */
    private $container = array();
    
    /**
     * Constructor for the Equipeer class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     */
    public function __construct() {
        $this->init_plugin();

        register_activation_hook( EQUIPEER_FILE, array( $this, 'activate' ) );
        register_deactivation_hook( EQUIPEER_FILE, array( $this, 'deactivate' ) );
    }

    /**
     * Initializes the Equipeer() class
     *
     * Checks for an existing Equipeer() instance
     * and if it doesn't find one, creates it.
     */
    public static function instance() {
        if ( self::$instance === null ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Magic getter to bypass referencing objects
     *
     * @param $prop
     *
     * @return Class Instance
     */
    public function __get( $prop ) {
        if ( array_key_exists( $prop, $this->container ) ) {
            return $this->container[ $prop ];
        }
    }

    /**
     * Get the template path.
     *
     * @return string
     */
    public function template_path() {
        return apply_filters( 'equipeer_template_path', 'equipeer/' );
    }

    /**
     * Placeholder for activation function
     *
     * Nothing being called here yet.
     */
    public function activate() {

    }

    /**
     * Placeholder for deactivation function
     *
     * Nothing being called here yet.
     */
    public function deactivate() {

    }

    /**
     * Load the plugin after WP User Frontend is loaded
     *
     * @return void
     */
    public function init_plugin() {
        $this->includes();
        $this->init_hooks();

        //do_action( 'equipeer_loaded' );
    }

    /**
     * Include all the required files
     *
     * @return void
     */
    function includes() {
        // Functions
        require_once EQUIPEER_INC_DIR . '/functions.php';
        require_once EQUIPEER_INC_DIR . '/functions-medias.php';
        require_once EQUIPEER_INC_DIR . '/translations.php';
        
        // Helpers
        require_once EQUIPEER_HELPERS_DIR . '/equine-general.php';
        
        // Classes
        require_once EQUIPEER_CLASSES_DIR . '/ajax.php';
        require_once EQUIPEER_CLASSES_DIR . '/cron.php';
        require_once EQUIPEER_CLASSES_DIR . '/email.php';
        require_once EQUIPEER_CLASSES_DIR . '/metabox.php';
        require_once EQUIPEER_CLASSES_DIR . '/widgets.php';
        require_once EQUIPEER_CLASSES_DIR . '/options.php';
        
        // Vendor
        require_once EQUIPEER_VENDOR_DIR  . '/Tax-meta-class/Tax-meta-class.php';
        require_once EQUIPEER_CLASSES_DIR . '/taxonomies.php';
        
        require_once EQUIPEER_CLASSES_DIR . '/interface.php';
        require_once EQUIPEER_CLASSES_DIR . '/shortcodes.php';
        //require_once EQUIPEER_CLASSES_DIR . '/upgrade.php';
        
        if ( is_admin() ) {            
            // Submenus
            require_once EQUIPEER_ADMIN_DIR . '/submenu.php';
            
            // Functions
            require_once EQUIPEER_ADMIN_DIR . '/functions-admin.php';
            
            // Classes
            require_once EQUIPEER_ADMIN_DIR . '/user-profile.php';
            require_once EQUIPEER_ADMIN_DIR . '/options.php';
            require_once EQUIPEER_ADMIN_DIR . '/columns.php';
            require_once EQUIPEER_ADMIN_DIR . '/bulk-actions.php';
            
            // Metaboxes
            require_once EQUIPEER_ADMIN_DIR . '/metaboxes/metabox-general.php';
            require_once EQUIPEER_ADMIN_DIR . '/metaboxes/metabox-impression.php';
            require_once EQUIPEER_ADMIN_DIR . '/metaboxes/metabox-price.php';
            require_once EQUIPEER_ADMIN_DIR . '/metaboxes/metabox-images.php';
            require_once EQUIPEER_ADMIN_DIR . '/metaboxes/metabox-proprietaire.php';
            require_once EQUIPEER_ADMIN_DIR . '/metaboxes/metabox-origines.php';
            require_once EQUIPEER_ADMIN_DIR . '/metaboxes/metabox-descriptif-detail.php';
            require_once EQUIPEER_ADMIN_DIR . '/metaboxes/metabox-aptitudes-monte-plat.php';
            require_once EQUIPEER_ADMIN_DIR . '/metaboxes/metabox-aptitudes-monte-obstacle.php';
            require_once EQUIPEER_ADMIN_DIR . '/metaboxes/metabox-aptitudes-saut.php';
            require_once EQUIPEER_ADMIN_DIR . '/metaboxes/metabox-aptitudes-resultats-competition.php';
            require_once EQUIPEER_ADMIN_DIR . '/metaboxes/metabox-profil-cavalier.php';
            require_once EQUIPEER_ADMIN_DIR . '/metaboxes/metabox-veterinaire.php';
            require_once EQUIPEER_ADMIN_DIR . '/metaboxes/metabox-notes.php';
            //require_once EQUIPEER_ADMIN_DIR . '/metaboxes/metabox-divers.php';
            require_once EQUIPEER_ADMIN_DIR . '/metaboxes/metabox-videos.php';
        }
    }
    
    /**
     * Initialize the actions
     *
     * @return void
     */
    function init_hooks() {
        // Localize our plugin
        add_action( 'init', array( $this, 'localization_setup' ) );
        
        // initialize the classes
        add_action( 'init', array( $this, 'init_classes' ), 4 );
        add_action( 'init', array( $this, 'wpdb_table_shortcuts' ) );
        
        // Initialize menu / post
        add_action( 'init', array( $this, 'custom_post_type' ), 0 );
        add_filter( 'post_updated_messages', array( $this, 'custom_updated_messages' ) );
        add_action( 'admin_head', array( $this, 'custom_help_tab' ) );
        
        // New links in Admin BAR
        add_action( 'admin_menu', array( $this, 'hide_update_message' ) );
        add_action( 'admin_bar_menu', array( $this, 'admin_bar_menu' ) );
        
        // Initialize lock uploads to show only "Uploaded to this post" in media panel
        add_action( 'admin_footer-post-new.php', array( $this, 'mediapanel_lock_uploaded' ) );
        add_action( 'admin_footer-post.php', array( $this, 'mediapanel_lock_uploaded' ) );
        
        // Plugin infos (Extensions)
        add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta'), 10, 2 );
        
        // Register widgets
        add_action( 'widgets_init', array( $this, 'register_widgets' ) );

        // Call TITAN Frameworks OPTIONS
        add_action( 'tf_create_options', array( $this, 'create_options' ) );

        // Load Front STYLES (CSS)
        add_action( 'wp_enqueue_scripts', array( $this, 'front_styles' ), 100 );
        
        // Load Admin STYLES (CSS)
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ), 100 );
        
        // Default SINGLE Template (Detail equide)
        add_filter( 'single_template', array( $this, 'default_single_template' ) );

        // Add shortcode support to Yoast Meta Title using 'wpseo_title' filter
        add_filter('wpseo_title', array( $this, 'equipeer_filter_wpseo_title' ) );
        
    }
    
    /**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'equipeer', false, EQUIPEER_DIRNAME_FILE . '/languages/' );
    }
    
    /**
     * Init all the classes
     *
     * @return void
     */
    function init_classes() {
        // Classes (Front & Admin)
        new Equipeer();
        new Equipeer_Email();
        new Equipeer_Shortcodes();
        new Equipeer_Taxonomies();
        new Equipeer_Ajax();
        new Equipeer_Cron();
        new Equipeer_Options();

        //$this->container['email']     = Equipeer_Email::init();
        //$this->container['shortcode'] = new Equipeer_Shortcodes();
        //
        //$this->container = apply_filters( 'equipeer_get_class_container', $this->container );

        // Classes (Only for Admins)
        if ( is_admin() ) {
            // Submenu
            new Equipeer_Submenu();
            // Custom fields in User profile
            new Equipeer_Admin_User_Profile();
            // Options
            new Equipeer_Admin_Options();
            // Ajax
            //Equipeer_Ajax::init_ajax();
            // Upgrade
            //new Equipeer_Upgrade();
            // Metabox
            new Equipeer_Metabox();
            // Columns
            new Equipeer_Admin_Columns();
            // Bulk Actions
            new Equipeer_Admin_Bulk_Actions();
            // Metaboxes
            new Equipeer_Metabox_General();
            new Equipeer_Metabox_Impression();
            new Equipeer_Metabox_Price();
            new Equipeer_Metabox_Images();
            new Equipeer_Metabox_Proprietaire();
            new Equipeer_Metabox_Origines();
            new Equipeer_Metabox_Descriptif_Detail();
            new Equipeer_Metabox_Aptitudes_Plat();
            new Equipeer_Metabox_Aptitudes_Obstacle();
            new Equipeer_Metabox_Notes();
            //new Equipeer_Metabox_Misc();
            new Equipeer_Metabox_Profil_Cavalier();
            new Equipeer_Metabox_Veto();
            new Equipeer_Metabox_Aptitudes_Saut();
            new Equipeer_Metabox_Resultats_Competition();
            new Equipeer_Metabox_Videos();
            // Helpers
            new Equipeer_Helper_Equine_General();
        }
        
        // Classes (Only for Front)
        if ( ! is_admin() && is_user_logged_in() ) {
            //Equipeer_Template_Main::init();
            //Equipeer_Template_Dashboard::init();
            //Equipeer_Template_Products::init();
            //Equipeer_Template_Orders::init();
            //Equipeer_Template_Settings::init();
        }

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            //Equipeer_Ajax::init()->init_ajax();
        }
    }

    /**
     * Load table prefix for withdraw and orders table
     *
     * @return void
     */
    function wpdb_table_shortcuts() {
        global $wpdb;

        //$this->tbl_equipeer_annonce                             = $wpdb->prefix . 'equipeer_annonce';
        //$this->tbl_equipeer_category                            = $wpdb->prefix . 'equipeer_category';
        //$this->tbl_equipeer_equestrian_discipline               = $wpdb->prefix . 'equipeer_equestrian_discipline';
        //$this->tbl_equipeer_equestrian_level                    = $wpdb->prefix . 'equipeer_equestrian_level';
        //$this->tbl_equipeer_group                               = $wpdb->prefix . 'equipeer_group';
        //$this->tbl_tbl_equipeer_selectionneur_age               = $wpdb->prefix . 'equipeer_selectionneur_age';
        //$this->tbl_equipeer_selectionneur_cavalier_age          = $wpdb->prefix . 'equipeer_selectionneur_cavalier_age';
        //$this->tbl_equipeer_selectionneur_cavalier_comportement = $wpdb->prefix . 'equipeer_selectionneur_cavalier_comportement';
        //$this->tbl_equipeer_selectionneur_cavalier_genre        = $wpdb->prefix . 'equipeer_selectionneur_cavalier_genre';
        //$this->tbl_equipeer_selectionneur_cavalier_niveau       = $wpdb->prefix . 'equipeer_selectionneur_cavalier_niveau';
        //$this->tbl_equipeer_selectionneur_discipline            = $wpdb->prefix . 'equipeer_selectionneur_discipline';
        //$this->tbl_equipeer_selectionneur_niveau                = $wpdb->prefix . 'equipeer_selectionneur_niveau';
        //$this->tbl_equipeer_selectionneur_potentiel             = $wpdb->prefix . 'equipeer_selectionneur_potentiel';
        //$this->tbl_equipeer_selectionneur_race                  = $wpdb->prefix . 'equipeer_selectionneur_race';
        //$this->tbl_equipeer_selectionneur_robe                  = $wpdb->prefix . 'equipeer_selectionneur_robe';
        //$this->tbl_equipeer_selectionneur_sexe                  = $wpdb->prefix . 'equipeer_selectionneur_sexe';
        //$this->tbl_equipeer_selectionneur_taille                = $wpdb->prefix . 'equipeer_selectionneur_taille';
        $this->tbl_equipeer_user_save_search                    = $wpdb->prefix . 'eqsearch_save';
        $this->tbl_equipeer_user_search                         = $wpdb->prefix . 'eqsearch';
        $this->tbl_equipeer_selection_sport                     = $wpdb->prefix . 'equipeer_selection_sport';
        $this->tbl_equipeer_ville                               = $wpdb->prefix . 'equipeer_ville';
        $this->tbl_equipeer_removal_request                     = $wpdb->prefix . 'eqremoval_request';
        $this->tbl_equipeer_selections_sent                     = $wpdb->prefix . 'equipeer_selections_sent';
        $this->tbl_equipeer_pdf_client                          = $wpdb->prefix . 'equipeer_pdf_client';
    }
    
    /**
     * Default SINGLE Template
     *
     * @return array
     */
    function default_single_template($single) {
        global $post;
        $post_name = $post->post_name;
        $post_type = $post->post_type;
        
        // Only for "equine" Post Type
        if ($post_type == $this->post_type) {
            $template = locate_template( $this->single_tpl );
            if ($template && !empty($template)) return $template;
        }
        
        return $single;
    }
    
    /**
     * Add shortcode support to Yoast Meta Title using 'wpseo_title' filter
     *
     * @param string $title The original title
     * 
     * @return string The title width do_shortcode function activated
     */
    function equipeer_filter_wpseo_title($title) {
        $title = do_shortcode($title);  
        return $title;
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
		if (stripos($file, EQUIPEER_BASE) !== false) {
			$new_links = array(
                'doc' => '<a href="https://codex.equipeer.com/" target="_blank"><span class="dashicons dashicons-book-alt" style="font-size: 1.3em;"></span>' . __( 'Documentation', EQUIPEER_ID ) . '</a>'
			);
			
			$links = array_merge($links, $new_links);
		}
		
		return $links;
	}

    /**
     * Register widgets
     *
     * @return void
     */
    public function register_widgets() {
        register_widget( 'Equipeer_Widgets' );
    }
    
    /**
     * Create options for SETTINGS
     * Framework: Titan Framework
     *
     * @return void
     */
    function create_options() {
        if ( !is_admin() )
            return;
        
        if ( !$this->is_supported_php() ) {
            add_action( 'admin_notices', array( $this, 'render_missing_php_notice' ) );
        }

        if ( !in_array( 'titan-framework/titan-framework.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            add_action( 'admin_notices', array( $this, 'render_missing_titan_notice' ) );
            return;
        }
        
        remove_filter( 'admin_footer_text', 'addTitanCreditText' );
    
        // Launch options framework instance
        $equipeer_options = TitanFramework::getInstance( EQUIPEER_ID );

        // ===============================================
        // Create PANEL menu item
        // ===============================================
        $panel = $equipeer_options->createAdminPanel( array(
            'name'       => __( 'Admin Settings', EQUIPEER_ID ),
            'id'         => EQUIPEER_ID . '_options',
            'capability' => 'equipeer_edit_options',
            'desc'       => '',
            'parent'     => 'edit.php?post_type=' . $this->post_type
        ) );
        // Create OPTIONS panel tabs
        //$options = $panel->createTab( array(
        //    'name' => 'Options',
        //    'id'   => EQUIPEER_ID . '_options',
        //) );
        // Create PREFIX panel tabs
        //$prefixes = $panel->createTab( array(
        //    'name' => 'Préfixes',
        //    'id'   => EQUIPEER_ID . '_prefix',
        //) );
        // Create EMAILS panel tabs
        //$email = $panel->createTab( array(
        //    'name' => 'Emails',
        //    'id'   => EQUIPEER_ID . '_email',
        //) );
        // Create CONTACT CLIENT panel tabs
        //$email_send = $panel->createTab( array(
        //    'name' => 'Contact client',
        //    'id'   => EQUIPEER_ID . '_email_send',
        //) );
        // Create FEATURED ADS panel tabs
        $featured_ads = $panel->createTab( array(
            'name' => 'A la une',
            'id'   => EQUIPEER_ID . '_featured_ads',
        ) );
        // Create ADMIN options panel tabs
        $admin_options = $panel->createTab( array(
            'name' => 'Admin',
            'id'   => EQUIPEER_ID . '_admin_options',
        ) );
        // Create XML FEED Facebook panel tabs
        $xml_feed = $panel->createTab( array(
            'name' => 'Flux XML FB',
            'id'   => EQUIPEER_ID . '_xml_feed_fb',
        ) );
        // Create HELPERS panel tabs
        $helpers = $panel->createTab( array(
            'name' => 'Aides',
            'id'   => EQUIPEER_ID . '_helpers',
        ) );
        // Create CREDITS panel tabs
        $credits = $panel->createTab( array(
            'name' => 'Crédits',
            'id'   => EQUIPEER_ID . '_credits',
        ) );
        // ===============================================
        //$equipeer_tt_files = array( 'prefixes', 'helpers', 'options', 'email', 'email-send', 'widget-featured-ads', 'xml-feed-facebook', 'credits' );
        //$equipeer_tt_files = array( 'helpers', 'options', 'email', 'email-send', 'widget-featured-ads', 'xml-feed-facebook', 'credits' );
        //$equipeer_tt_files = array( 'helpers', 'email', 'email-send', 'widget-featured-ads', 'admin-options', 'xml-feed-facebook', 'credits' );
        $equipeer_tt_files = array( 'helpers', 'widget-featured-ads', 'admin-options', 'xml-feed-facebook', 'credits' );
        foreach( $equipeer_tt_files as $equipeer_tt_file ) {
            $equipeer_tt_file_exist = EQUIPEER_INC_DIR . '/titan-inc-' . $equipeer_tt_file . '.php';
            if ( file_exists( $equipeer_tt_file_exist ) )
                include( $equipeer_tt_file_exist );
        }
        // ===============================================
        $helpers->createOption( array(
            'type' => 'save',
            'save' => __( 'Save Changes', EQUIPEER_ID ),
            'reset' => __( 'Reset to Defaults', EQUIPEER_ID ),
        ) );
        //$prefixes->createOption( array(
        //    'type' => 'save',
        //    'save' => __( 'Save Changes', EQUIPEER_ID ),
        //    'reset' => __( 'Reset to Defaults', EQUIPEER_ID ),
        //) );
        //$options->createOption( array(
        //    'type' => 'save',
        //    'save' => __( 'Save Changes', EQUIPEER_ID ),
        //    'reset' => __( 'Reset to Defaults', EQUIPEER_ID ),
        //) );
        $admin_options->createOption( array(
            'type' => 'save',
            'save' => __( 'Save Changes', EQUIPEER_ID ),
            'reset' => __( 'Reset to Defaults', EQUIPEER_ID ),
        ) );
        //$email->createOption( array(
        //    'type' => 'save',
        //    'save' => __( 'Save Changes', EQUIPEER_ID ),
        //    'reset' => __( 'Reset to Defaults', EQUIPEER_ID ),
        //) );
        $xml_feed->createOption( array(
            'type' => 'save',
            'save' => __( 'Save Changes', EQUIPEER_ID ),
            'reset' => false
        ) );
        // ===============================================        
    }
    
    /**
     * Register Equipeer Custom Post Type (CPT) 
     *
     * @link https://codex.wordpress.org/Function_Reference/register_post_type
     *
     * Return void
     */
    function custom_post_type() {
        // Set UI labels for Custom Post Type
        $labels = [
            'name'                   => _x( 'Annonces', 'Post Type General Name', EQUIPEER_ID ),
            'singular_name'          => _x( 'Annonce', 'Post Type Singular Name', EQUIPEER_ID ),
            'menu_name'              => __( 'Annonces', EQUIPEER_ID ),
            'name_admin_bar'         => _x( 'Annonce', 'add new on admin bar', EQUIPEER_ID ),
            'add_new'                => __( 'Ajouter une annonce', EQUIPEER_ID ),
            'add_new_item'           => __( 'Ajouter une nouvelle annonce', EQUIPEER_ID ),
            'new_item'               => __( 'Nouvelle annonce', EQUIPEER_ID ),
            'edit_item'              => __( 'Modifier une annonce', EQUIPEER_ID ),
            'update_item'            => __( "Mise &agrave; jour d'une annonce", EQUIPEER_ID ),
            'view_item'              => __( "Voir une annonce", EQUIPEER_ID ),
            'all_items'              => __( 'Toutes les annonces', EQUIPEER_ID ),
            'search_items'           => __( 'Recherche', EQUIPEER_ID ),
            'parent_item_colon'      => __( 'Parent Equine', EQUIPEER_ID ),
            'not_found'              => __( 'Not Found', EQUIPEER_ID ),
            'not_found_in_trash'     => __( 'Not found in Trash', EQUIPEER_ID ),
            'item_updated'           => __( 'Equine updated', EQUIPEER_ID ),
            'item_scheduled'         => __( 'Equine scheduled', EQUIPEER_ID ),
            'item_reverted_to_draft' => __( 'Equine drafted', EQUIPEER_ID ),
            'item_published_privately' => __( 'Equine published privately', EQUIPEER_ID )
    ];
         
        // Set other options for Custom Post Type
        $args = [
            'label'               => __( 'equines', EQUIPEER_ID ),
            'description'         => __( 'Equine listing', EQUIPEER_ID ),
            'labels'              => $labels,
            // Features this CPT supports in Post Editor
            // 'title'
            // 'editor' (content)
            // 'author'
            // 'thumbnail' (featured image, current theme must also support post-thumbnails)
            // 'excerpt'
            // 'trackbacks'
            // 'custom-fields'
            // 'comments' (also will see comment count balloon on edit screen)
            // 'revisions' (will store revisions)
            // 'page-attributes' (menu order, hierarchical must be true to show Parent option)
            // 'post-formats' add post formats, see Post Formats
            'supports'            => [
                'title',
                //'editor',
                //'author',
                //'thumbnail',
                //'comments',
                //'excerpt',
                //'trackbacks',
                'custom-fields',
                //'comments',
                'revisions',
                'page-attributes',
                //'post-formats'
            ],
            // You can associate this CPT with a taxonomy or custom taxonomy. 
            'taxonomies'          => [ ],
            /* A hierarchical CPT is like Pages and can have
            * Parent and child items. A non-hierarchical CPT
            * is like Posts.
            */ 
            'hierarchical'        => true,
            'public'              => true,
            'query_var'           => true,
            /** Rewrite
             * $args array
             * 'slug' => string Customize the permalink structure slug. Defaults to the $post_type value. Should be translatable.
             * 'with_front' => bool Should the permalink structure be prepended with the front base. (example: if your permalink structure is /blog/, then your links will be: false->/news/, true->/blog/news/). Defaults to true
             * 'feeds' => bool Should a feed permalink structure be built for this post type. Defaults to has_archive value.
             * 'pages' => bool Should the permalink structure provide for pagination. Defaults to true
             * 'ep_mask' => const As of 3.4 Assign an endpoint mask for this post type. For more info see Rewrite API/add_rewrite_endpoint, and Make WordPress Plugins summary of endpoints.
             * If not specified, then it inherits from permalink_epmask(if permalink_epmask is set), otherwise defaults to EP_PERMALINK.
             */
            'rewrite'             => [
                'slug' => $this->slug
            ],
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            /** Menu Position
             * 5   - below Posts
             * 10  - below Media
             * 15  - below Links
             * 20  - below Pages
             * 25  - below comments
             * 60  - below first separator
             * 65  - below Plugins
             * 70  - below Users
             * 75  - below Tools
             * 80  - below Settings
             * 100 - below second separator
             */
            'menu_position'       => 5,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'can_export'          => true,
            'capabilities'        => [
                'edit_post'          => 'equipeer_edit_equine', 
                'read_post'          => 'equipeer_read_equine', 
                'delete_post'        => 'equipeer_delete_equine', 
                'edit_posts'         => 'equipeer_edit_equines', 
                'edit_others_posts'  => 'equipeer_edit_others_equines', 
                'publish_posts'      => 'equipeer_publish_equines',       
                'read_private_posts' => 'equipeer_read_private_equines', 
                'create_posts'       => 'equipeer_add_equine', 
            ],
            'capability_type'     => 'post',
            'menu_icon'           => 'dashicons-buddicons-activity',
        ];
        // Registering Equipeer Custom Post Type
        register_post_type( $this->post_type, $args );
    }
    
    /**
     * Hide update Wordpress NAG
     */
    function hide_update_message() {
        remove_action( 'admin_notices', 'update_nag', 3 );
        remove_filter( 'update_footer', 'core_update_footer' );
    }
    
    /**
     * Equipeer Custom Post Type update messages.
     *
     * See /wp-admin/edit-form-advanced.php
     *
     * @param array $messages Existing post update messages.
     *
     * @return array Amended post update messages with new CPT update messages.
     */
    function custom_updated_messages( $messages ) {
        $post             = get_post();
        $post_type        = get_post_type( $post );
        $post_type_object = get_post_type_object( $post_type );
    
        $messages[$this->post_type] = array(
            0  => '', // Unused. Messages start at index 1.
            1  => __( 'Equine updated.', EQUIPEER_ID ),
            2  => __( 'Custom field updated.', EQUIPEER_ID ),
            3  => __( 'Custom field deleted.', EQUIPEER_ID ),
            4  => __( 'Equine updated.', EQUIPEER_ID ),
            /* translators: %s: date and time of the revision */
            5  => isset( $_GET['revision'] ) ? sprintf( __( 'Equine restored to revision from %s', EQUIPEER_ID ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
            6  => __( 'Equine published.', EQUIPEER_ID ),
            7  => __( 'Equine saved.', EQUIPEER_ID ),
            8  => __( 'Equine submitted.', EQUIPEER_ID ),
            9  => sprintf(
                __( 'Equine scheduled for: <strong>%1$s</strong>.', EQUIPEER_ID ),
                // translators: Publish box date format, see http://php.net/date
                date_i18n( __( 'M j, Y @ G:i', EQUIPEER_ID ), strtotime( $post->post_date ) )
            ),
            10 => __( 'Equine draft updated.', EQUIPEER_ID )
        );
    
        if ( $post_type_object->publicly_queryable && $this->post_type === $post_type ) {
            $permalink = get_permalink( $post->ID );
    
            $view_link = sprintf( ' <a href="%s">%s</a>', esc_url( $permalink ), __( 'View equine', EQUIPEER_ID ) );
            $messages[ $post_type ][1] .= $view_link;
            $messages[ $post_type ][6] .= $view_link;
            $messages[ $post_type ][9] .= $view_link;
    
            $preview_permalink = add_query_arg( 'preview', 'true', $permalink );
            $preview_link = sprintf( ' <a target="_blank" href="%s">%s</a>', esc_url( $preview_permalink ), __( 'Preview equine', EQUIPEER_ID ) );
            $messages[ $post_type ][8]  .= $preview_link;
            $messages[ $post_type ][10] .= $preview_link;
        }
    
        return $messages;
    }
    
    /**
     * Construct Help Tab (Aides)
     *
     * @return void
     */
    function custom_help_tab() {
    
        $screen = get_current_screen();
      
        // Return early if we're not on the equine post type.
        if ( $this->post_type != $screen->post_type )
          return;

        // Get Helpers
        $helpers = new Equipeer_Helper_Equine_General();
      
        $equipeer_options = TitanFramework::getInstance( EQUIPEER_ID );

        $add_new_equine_content    = @$equipeer_options->getOption('helper_add_new_equine_content');
        $edit_equine_content       = @$equipeer_options->getOption('helper_edit_equine_content');
        $taxonomies_equine_content = @$equipeer_options->getOption('helper_taxonomies_equine_content');
        $email_equine_content      = @$equipeer_options->getOption('helper_email_equine_content');
        $faq_equine_content        = @$equipeer_options->getOption('helper_faq_equine_content');
        
        // Setup help tab args.
        $args1 = array(
            'id'      => 'help_tab_add-new-equine', // Unique id for the tab
            'title'   => 'Ajouter une annonce',       // Unique visible title for the tab
            'content' => $add_new_equine_content    // Actual help text
        );
        $screen->add_help_tab( $args1 ); // Add the help tab
        
        $args2 = array(
            'id'      => 'help_tab_edit-equine', // Unique id for the tab
            'title'   => 'Modifier une annonce',   // Unique visible title for the tab
            'content' => $edit_equine_content    // Actual help text
        );
        $screen->add_help_tab( $args2 ); // Add the help tab
        
        $args3 = array(
            'id'      => 'help_tab_edit-taxonomies', // Unique id for the tab
            'title'   => 'Catégories',               // Unique visible title for the tab
            'content' => $taxonomies_equine_content  // Actual help text
        );
        $screen->add_help_tab( $args3 ); // Add the help tab
        
        $args4 = array(
            'id'      => 'help_tab_email-equine', // Unique id for the tab
            'title'   => 'Emails',                // Unique visible title for the tab
            'content' => $email_equine_content    // Actual help text
        );
        $screen->add_help_tab( $args4 ); // Add the help tab$
        
        $args5 = array(
            'id'      => 'help_tab_faq-equine', // Unique id for the tab
            'title'   => 'F.A.Q.',              // Unique visible title for the tab
            'content' => $faq_equine_content    // Actual help text
        );
        $screen->add_help_tab( $args5 ); // Add the help tab
        
        // Add the help sidebar
        $link_equine_content = @$equipeer_options->getOption('helper_link_equine_content');
        $screen->set_help_sidebar("<p>Plus d'informations</p>$link_equine_content");
    
    }
    
    /**
     * Lock uploads to show only "Uploaded to this post" in media panel
     *
     * @return void
     */
    function mediapanel_lock_uploaded() { ?>
      <script type="text/javascript">
        jQuery(document).on("DOMNodeInserted", function(){
            // Lock uploads to "Uploaded to this post"
            jQuery('select.attachment-filters [value="uploaded"]').attr( 'selected', true ).parent().trigger('change');
        });
      </script>
    <?php }
    
    /**
     * Front styles CSS
     *
     * Return void
     */
    function front_styles() {
        wp_enqueue_style( 'equipeer-range-slider-css', EQUIPEER_URL . 'assets/vendors/Ion-range-slider/css/ion.rangeSlider.min.css', false, $this->get_plugin_infos( 'Version' ) );
        wp_enqueue_script( 'equipeer-range-slider-js', EQUIPEER_URL . 'assets/vendors/Ion-range-slider/js/ion.rangeSlider.min.js', false, $this->get_plugin_infos( 'Version' ) );
    }
    
    /**
     * Admin styles CSS
     *
     * Return void
     */
    function admin_styles() {
        if ( is_admin() ) {
            wp_register_style( 'equipeer-admin-css', EQUIPEER_URL . 'assets/css/style-admin.css', false, $this->get_plugin_infos( 'Version' ) );
            wp_enqueue_style( 'equipeer-admin-css' );
            // Only on EDIT Equine Page
            $screen = get_current_screen();
            if ( $screen->post_type == $this->post_type ) {
                wp_register_style( 'equipeer-admin-equine-css', EQUIPEER_URL . 'assets/css/style-admin-equine.css', false, $this->get_plugin_infos( 'Version' ) );
                wp_enqueue_style( 'equipeer-admin-equine-css' );
            } 
        }
    }
    
    /**
     * Get Equine Taxonomy
     */
    function admin_get_taxonomy($term_slug) {
        return equipeer_get_terms('equipeer_discipline');
        //return $term_object;
    }
    
    /**
     * Admin bar menu
     *
     * @param
     *
     * Return array
     */
    function admin_bar_menu() {
        if ( is_admin() ) {
            global $wp_admin_bar;
    
            // Wordpress MENU (Site name)
            $args = array(
                'parent' => 'site-name',
                'id'     => 'media-libray',
                'title'  => __( 'Media Library', EQUIPEER_ID ),
                'href'   => esc_url( admin_url( 'upload.php' ) ),
                'meta'   => false
            );
            $wp_admin_bar->add_node( $args );
            $args = array(
                'parent' => 'site-name',
                'id'     => 'plugins',
                'title'  => __( 'Plugins', EQUIPEER_ID ),
                'href'   => esc_url( admin_url( 'plugins.php' ) ),
                'meta'   => false
            );
            $wp_admin_bar->add_node( $args );
            $args = array(
                'parent' => 'site-name',
                'id'     => 'users',
                'title'  => __( 'Users', EQUIPEER_ID ),
                'href'   => esc_url( admin_url( 'users.php' ) ),
                'meta'   => false
            );
            $wp_admin_bar->add_node( $args );
            
            // Equipeer MENU        
            $args = array(
                'id'     => 'equipeer-menu',
                'title'  => '<span class="ab-icon dashicons dashicons-buddicons-activity" style="margin-top:2px"></span>' . __( 'EQUIPEER', EQUIPEER_ID ),
                'href'   => '#',
                'meta'   => array(
                    'class' => 'equipeer-adminbar'
                )
            );
            $wp_admin_bar->add_node( $args );
                $args = array(
                    'parent' => 'equipeer-menu',
                    'id'     => 'equipeer-add',
                    'title'  => '<span class="ab-icon dashicons dashicons-plus equipeer-adminbar-submenu"></span> Ajouter une annonce',
                    'href'   => admin_url() . 'post-new.php?post_type=equine',
                    'meta'   => false
                );
                $wp_admin_bar->add_node( $args );
                $args = array(
                    'parent' => 'equipeer-menu',
                    'id'     => 'equipeer-list',
                    'title'  => 'Toutes les annonces',
                    'href'   => admin_url() . 'edit.php?post_type=equine',
                    'meta'   => false
                );
                $wp_admin_bar->add_node( $args );
                // CATEGORIES (Taxonomies)
                $args = array(
                    'parent' => 'equipeer-menu',
                    'id'     => 'equipeer-categories',
                    'title'  => __( 'Categories', EQUIPEER_ID ),
                    'href'   => '#',
                    'meta'   => false
                );
                $wp_admin_bar->add_node( $args );
                    // Main category
                    $args = array(
                        'parent' => 'equipeer-categories',
                        'id'     => 'equipeer-category-main',
                        'title'  => __( 'Equines', EQUIPEER_ID ),
                        'href'   => admin_url() . 'edit-tags.php?taxonomy=equipeer_main&post_type=equine',
                        'meta'   => false
                    );
                    //$wp_admin_bar->add_node( $args );
                    // AGES
                    $args = array(
                        'parent' => 'equipeer-categories',
                        'id'     => 'equipeer-category-ages',
                        'title'  => __( 'Ages', EQUIPEER_ID ),
                        'href'   => admin_url() . 'edit-tags.php?taxonomy=equipeer_age&post_type=equine',
                        'meta'   => false
                    );
                    $wp_admin_bar->add_node( $args );
                    // DISCIPLINES
                    $args = array(
                        'parent' => 'equipeer-categories',
                        'id'     => 'equipeer-category-disciplines',
                        //'title'  => __( 'Disciplines', EQUIPEER_ID ),
                        'title'  => __( 'Cat&eacute;gories EQUIPEER', EQUIPEER_ID ),
                        'href'   => admin_url() . 'edit-tags.php?taxonomy=equipeer_discipline&post_type=equine',
                        'meta'   => false
                    );
                    $wp_admin_bar->add_node( $args );
                    // GENDERS (Sexe)
                    $args = array(
                        'parent' => 'equipeer-categories',
                        'id'     => 'equipeer-category-genders',
                        'title'  => __( 'Genders', EQUIPEER_ID ),
                        'href'   => admin_url() . 'edit-tags.php?taxonomy=equipeer_gender&post_type=equine',
                        'meta'   => false
                    );
                    $wp_admin_bar->add_node( $args );
                    // GROUPES
                    $args = array(
                        'parent' => 'equipeer-categories',
                        'id'     => 'equipeer-category-groups',
                        'title'  => __( 'Groups', EQUIPEER_ID ),
                        'href'   => admin_url() . 'edit-tags.php?taxonomy=equipeer_group&post_type=equine',
                        'meta'   => false
                    );
                    $wp_admin_bar->add_node( $args );
                    // NIVEAUX
                    $args = array(
                        'parent' => 'equipeer-categories',
                        'id'     => 'equipeer-category-levels',
                        'title'  => __( 'Levels', EQUIPEER_ID ),
                        'href'   => admin_url() . 'edit-tags.php?taxonomy=equipeer_level&post_type=equine',
                        'meta'   => false
                    );
                    $wp_admin_bar->add_node( $args );
                    // POTENTIELS
                    $args = array(
                        'parent' => 'equipeer-categories',
                        'id'     => 'equipeer-category-potentials',
                        'title'  => __( 'Potentials', EQUIPEER_ID ),
                        'href'   => admin_url() . 'edit-tags.php?taxonomy=equipeer_potential&post_type=equine',
                        'meta'   => false
                    );
                    $wp_admin_bar->add_node( $args );
                    // RACES
                    $args = array(
                        'parent' => 'equipeer-categories',
                        'id'     => 'equipeer-category-breeds',
                        'title'  => __( 'Breeds', EQUIPEER_ID ),
                        'href'   => admin_url() . 'edit-tags.php?taxonomy=equipeer_breed&post_type=equine',
                        'meta'   => false
                    );
                    $wp_admin_bar->add_node( $args );
                    // ROBES
                    $args = array(
                        'parent' => 'equipeer-categories',
                        'id'     => 'equipeer-category-colors',
                        'title'  => __( 'Colors', EQUIPEER_ID ),
                        'href'   => admin_url() . 'edit-tags.php?taxonomy=equipeer_color&post_type=equine',
                        'meta'   => false
                    );
                    $wp_admin_bar->add_node( $args );
                    // TAILLES
                    $args = array(
                        'parent' => 'equipeer-categories',
                        'id'     => 'equipeer-category-sizes',
                        'title'  => __( 'Sizes', EQUIPEER_ID ),
                        'href'   => admin_url() . 'edit-tags.php?taxonomy=equipeer_size&post_type=equine',
                        'meta'   => false
                    );
                    $wp_admin_bar->add_node( $args );
                    // DISCIPLINES EQUESTRES
                    $args = array(
                        'parent' => 'equipeer-categories',
                        'id'     => 'equipeer-category-equestrian-disciplines',
                        'title'  => __( 'Equestrian Disciplines', EQUIPEER_ID ),
                        'href'   => admin_url() . 'edit-tags.php?taxonomy=equipeer_equestrian_discipline&post_type=equine',
                        'meta'   => false
                    );
                    $wp_admin_bar->add_node( $args );
                    // NIVEAUX EQUESTRES
                    $args = array(
                        'parent' => 'equipeer-categories',
                        'id'     => 'equipeer-category-equestrian-levels',
                        'title'  => __( 'Equestrian Levels', EQUIPEER_ID ),
                        'href'   => admin_url() . 'edit-tags.php?taxonomy=equipeer_equestrian_level&post_type=equine',
                        'meta'   => false
                    );
                    $wp_admin_bar->add_node( $args );
                    // CAVALIER AGES
                    $args = array(
                        'parent' => 'equipeer-categories',
                        'id'     => 'equipeer-category-rider-ages',
                        'title'  => __( 'Rider Ages', EQUIPEER_ID ),
                        'href'   => admin_url() . 'edit-tags.php?taxonomy=equipeer_rider_age&post_type=equine',
                        'meta'   => false
                    );
                    $wp_admin_bar->add_node( $args );
                    // CAVALIER COMPORTEMENTS
                    $args = array(
                        'parent' => 'equipeer-categories',
                        'id'     => 'equipeer-category-rider-behaviors',
                        'title'  => __( 'Rider Behaviors', EQUIPEER_ID ),
                        'href'   => admin_url() . 'edit-tags.php?taxonomy=equipeer_rider_behavior&post_type=equine',
                        'meta'   => false
                    );
                    $wp_admin_bar->add_node( $args );
                    // CAVALIER GENRES
                    $args = array(
                        'parent' => 'equipeer-categories',
                        'id'     => 'equipeer-category-rider-genders',
                        'title'  => __( 'Rider Genders', EQUIPEER_ID ),
                        'href'   => admin_url() . 'edit-tags.php?taxonomy=equipeer_rider_gender&post_type=equine',
                        'meta'   => false
                    );
                    $wp_admin_bar->add_node( $args );
                    // CAVALIER NIVEAUX
                    $args = array(
                        'parent' => 'equipeer-categories',
                        'id'     => 'equipeer-category-rider-levels',
                        'title'  => __( 'Rider Levels', EQUIPEER_ID ),
                        'href'   => admin_url() . 'edit-tags.php?taxonomy=equipeer_rider_level&post_type=equine',
                        'meta'   => false
                    );
                    $wp_admin_bar->add_node( $args );
                // CODEX
                $args = array(
                    'parent' => 'equipeer-menu',
                    'id'     => 'equipeer-codex',
                    'title'  => __( 'EQUICODEX', EQUIPEER_ID ),
                    'href'   => 'https://codex.equipeer.com',
                    'meta'   => array(
                        'target' => '_blank'
                    )
                );
                $wp_admin_bar->add_node( $args );
        }
    }

    /**
     * Plugin infos
     *
     * @param   string  $infos
     *
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
     *
     * @return string
     */
	function get_plugin_infos( $infos = 'Version' ) {
        //if (!function_exists("get_plugin_data")) include admin_url() . 'includes/plugin.php';
		$plugin_data = get_plugin_data( EQUIPEER_FILE );
		$plugin_version = $plugin_data[ "$infos" ];
		return $plugin_version;
	}
    
    /**
     * Missing Titan Framework notice
     *
     * @since 1.0.1
     *
     * @return void
     */
    public function render_missing_titan_notice() {
        $plugin_url = self_admin_url( 'plugin-install.php?s=titan+framework&tab=search&type=term' );
        $message    = sprintf( esc_html__( 'requires Titan Framework to be installed and active. You can activate %s here.', EQUIPEER_ID ), '<a href="' . $plugin_url . '">Titan Framework</a>' );
        printf( '<div class="notice notice-error is-dismissible"><p style="overflow: hidden;"><img src="'.EQUIPEER_URL.'/assets/images/Titan-Framework-800x800.png" style="width: 45px; float: left; margin: 0 1em 0 0;"><strong>'.ucfirst(EQUIPEER_ID).' %1$s</strong></p></div>', $message );
    }
    
    /**
     * Check whether Titan Framework is installed or not
     *
     * @since 1.0.1
     *
     * @return boolean
     */
    public function has_titan_framework() {
        if ( in_array( 'titan-framework/titan-framework.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Check PHP Version notice
     *
     * @since 1.0.1
     *
     * @return void
     */
    public function render_missing_php_notice() {
        $message = sprintf( esc_html__( 'Equipeer requires minimum PHP Version %s. You must upgrade PHP.', EQUIPEER_ID ), $this->min_php );
        printf( '<div class="notice notice-error is-dismissible"><p><strong>%1$s</strong></p></div>', $message );
    }
    
    /**
     * Check if the PHP version is supported
     *
     * @since 1.0.1
     *
     * @return bool
     */
    public function is_supported_php() {
        if ( version_compare( PHP_VERSION, $this->min_php, '<=' ) ) {
            return false;
        }

        return true;
    }
    
    /**
     * Maybe perform updates
     *
     * @since 1.1
     *
     * @return void
     */
    public function maybe_perform_updates() {
        //$updater = new Equipeer_Upgrade;
        //$updater->do_updates();
    }
    
} // EQUIPEER Class

?>