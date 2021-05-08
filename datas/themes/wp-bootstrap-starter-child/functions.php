<?php
/*
 *  ------------------------------------------------
 *	Equipeer Functions - Child Theme
 *	------------------------------------------------
 *	These functions will override the parent theme
 *	functions. We have provided some examples below.
 */

/* LOAD PARENT THEME STYLES
================================================== */
add_action( 'wp_enqueue_scripts', 'equipeer_child_styles' );
if (!function_exists("equipeer_child_styles")) {
	function equipeer_child_styles() {
		wp_enqueue_style( 'equipeer-child-style', get_stylesheet_directory_uri() . '/style.css', array(), Equipeer()->get_plugin_infos('Version') );
	}
}

/* LOAD PARENT THEME STYLES (Special GG)
================================================== */
add_action( 'wp_enqueue_scripts', 'equipeer_child_styles_gg', 100 );
if (!function_exists("equipeer_child_styles_gg")) {
	function equipeer_child_styles_gg() {
		wp_enqueue_style( 'equipeer-child-style-gg', get_stylesheet_directory_uri() . '/style-gg.css', array(), Equipeer()->get_plugin_infos('Version') );
	}
}

/* LOAD PARENT THEME STYLES
================================================== */
add_action( 'wp_enqueue_scripts', 'equipeer_child_styles_print' );
if (!function_exists("equipeer_child_styles_print")) {
	function equipeer_child_styles_print() {
		wp_enqueue_style( 'equipeer-child-style-print', get_stylesheet_directory_uri() . '/style-print.css', array(), Equipeer()->get_plugin_infos('Version'), 'print' );
	}
}

/* LOAD PARENT THEME JS
================================================== */
add_action( 'wp_enqueue_scripts', 'equipeer_scripts' );
if (!function_exists("equipeer_scripts")) {
	function equipeer_scripts() {
		wp_enqueue_script(
			'equipeer-child-script1',
			get_stylesheet_directory_uri() . '/assets/js/extend.js',
			array( 'jquery' ),
			Equipeer()->get_plugin_infos('Version')
		);
		wp_enqueue_script(
			'equipeer-child-script2',
			get_stylesheet_directory_uri() . '/vendor/cycle/jquery.cycle.all.js',
			array( 'jquery' ),
			Equipeer()->get_plugin_infos('Version')
		);
	}
}

/* LOAD SHORTCODES
 * Usage:
 * [equipeer_dateY]
================================================== */
add_shortcode('equipeer_dateY', 'equipeer_shortcode_date');
if (!function_exists("equipeer_shortcode_date")) {
	function equipeer_shortcode_date( $param, $content ) {
		return date('Y');
	}
}

/* LOAD SIDEBARS
================================================== */
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
        'name' => 'BLOG EQUIPEER',
		'id' => 'equipeer-blog',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
	register_sidebar(array(
        'name' => 'KIT MEDIA',
		'id' => 'equipeer-kit-media',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    register_sidebar(array(
        'name' => 'COLOPHON',
		'id' => 'equipeer-colophon',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    register_sidebar(array(
        'name' => 'EQUINE Single',
		'id' => 'equipeer-equine-single',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    register_sidebar(array(
        'name' => 'EQUINE Archive',
		'id' => 'equipeer-equine-archive',
        'before_widget' => '<div class="mt-3 mb-3">',
        'after_widget' => '</div>',
        'before_title' => '',
        'after_title' => '',
    ));
    register_sidebar(array(
        'name' => 'EQUINE Archive (Header)',
		'id' => 'equipeer-equine-archive-header',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    register_sidebar(array(
        'name' => 'EQUINE Archive (Header - Image)',
		'id' => 'equipeer-equine-archive-header-image',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
    register_sidebar(array(
        'name' => 'EQUINE Archive (Footer)',
		'id' => 'equipeer-equine-archive-footer',
        'before_widget' => '',
        'after_widget' => '',
        'before_title' => '',
        'after_title' => '',
    ));
//    register_sidebar(array(
//        'name' => 'EQUINE Dépot Annonce',
//		'id' => 'equipeer-equine-putad',
//        'before_widget' => '',
//        'after_widget' => '',
//        'before_title' => '',
//        'after_title' => '',
//    ));
};

/**
 * Check if cron job exists
 * @Check cron after WP Update or others
================================================== */
// -----------------------------------------------
// --- Check if Facebook FEED (XML) CRON is active
// -----------------------------------------------
if ( ! wp_next_scheduled( 'equipeer_xml_feed_fb' ) ) {
	$recurrence_feed = Equipeer_Cron::static_value("feedfb");
	// Facebook FEED (XML)
	wp_schedule_event( time(), $recurrence_feed, 'equipeer_xml_feed_fb' );
}
// --- Facebook FEED (XML)
add_action( 'equipeer_xml_feed_fb', 'equipeer_xml_feed_fb_function' );
if (!function_exists("equipeer_xml_feed_fb_function")) {
	function equipeer_xml_feed_fb_function() {
		Equipeer_Cron::xml_feed_fb();
	}
}
// ----------------------------------------------------------
// --- Check if Auto validate AD not moderated CRON is active
// ----------------------------------------------------------
if ( ! wp_next_scheduled( 'equipeer_ad_auto_validate_48' ) ) {
	$recurrence_auto_validate = Equipeer_Cron::static_value("autovalidate");
	// Auto validate AD not moderated
	wp_schedule_event( time(), $recurrence_auto_validate, 'equipeer_ad_auto_validate_48' );
}
// --- Auto validate AD not moderated
add_action( 'equipeer_ad_auto_validate_48', 'equipeer_ad_auto_validate_48_function' );
if (!function_exists("equipeer_ad_auto_validate_48_function")) {
	function equipeer_ad_auto_validate_48_function() {
		Equipeer_Cron::auto_validate_ad_48();
	}
}
// ----------------------------------------------------------
// --- Check if new ads exist to notify the customer who has chosen to be notified 
// ----------------------------------------------------------
if ( ! wp_next_scheduled( 'equipeer_new_ads_be_warned' ) ) {
	$recurrence_be_warned = Equipeer_Cron::static_value("bewarned");
	// Auto validate AD not moderated
	wp_schedule_event( time(), $recurrence_be_warned, 'equipeer_new_ads_be_warned' );
}
// --- Notify the customer who has chosen to be notified (New Ads)
add_action( 'equipeer_new_ads_be_warned', 'equipeer_new_ads_be_warned_function' );
if (!function_exists("equipeer_new_ads_be_warned_function")) {
	function equipeer_new_ads_be_warned_function() {
		Equipeer_Cron::get_new_ads_alert_be_warned();
	}
}

/**
 * Change text strings
 *
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 *    DON'T UPDATE THE PLUGIN WP-USER-MANAGER
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * Email content (password reset / register):
 * @file /modules/wp-user-manager/includes/wpum-emails/class-wpum-emails-customizer.php 241 (register)
 * @file /modules/wp-user-manager/includes/wpum-emails/class-wpum-emails-customizer.php 247 (password reset)
 * And more...
 *
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference/gettext
================================================== */
add_filter( 'gettext', 'equipeer_text_strings', 20, 3 );
add_filter( 'ngettext', 'equipeer_text_strings', 20, 3 );
if (!function_exists("equipeer_text_strings")) {
	function equipeer_text_strings( $translated_text, $text, $domain ) {
		switch ( $translated_text ) {
			case 'Lost your password?': $translated_text = __( "Mot de passe oubli&eacute; ?", 'wp-user-manager' ); break;
			case 'Current password': case 'Current Password': $translated_text = __( "Mot de passe actuel", 'wp-user-manager' ); break;
			case 'Change password': $translated_text = __( "Modifier mon mot de passe", 'wp-user-manager' ); break;
			case 'Repeat password': case 'Repeat Password': $translated_text = __( "Retapez votre mot de passe", 'wp-user-manager' ); break;
			case 'Error: incorrect current password.': $translated_text = __( "Erreur : Mot de passe actuel incorrect", 'wp-user-manager' ); break;
			case 'The password you entered is incorrect.': $translated_text = __( "Le mot de passe que vous avez saisi est incorrect", 'wp-user-manager' ); break;
			case 'A confirmation email has been sent to %s. Click the link within the email ': case 'A confirmation email has been sent to %s. Click the link within the email': $translated_text = __( "Le mot de passe que vous avez saisi est incorrect", 'wp-user-manager' ); break;
			case "Sorry, that username already exists!": $translated_text = "Désolé, cet identifiant existe déjà ! Connectez vous !"; break;
		}
		return $translated_text;
	}
}

/* New Equipeer Widget
================================================== */
add_action( 'widgets_init', 'equipeer_h2_register_widget' );
if (!function_exists("equipeer_h2_register_widget")) {
	function equipeer_h2_register_widget() {
		register_widget( 'equipeer_h2_widget' );
	}
}

if (!class_exists("equipeer_h2_widget")) {
	class equipeer_h2_widget extends WP_Widget {
		function __construct() {
			parent::__construct(
				// widget ID
				'equipeer_h2_widget',
				// widget name
				__('Equipeer Title H2 Widget', 'wp-bootstrap-starter'),
				// widget description
				array( 'description' => __( 'Equipeer Title H2 Widget', 'wp-bootstrap-starter' ), )
			);
		}
		public function widget( $args, $instance ) {
			$title = apply_filters( 'widget_title', $instance['title'] );
			echo $args['before_widget'];
			// if title is present
			if ( ! empty( $title ) ) {
				//echo $args['before_title'] . $title . $args['after_title'];
				echo '<h2 class="equine-header-h2">' . $title . '</h2>';
			}
			// output
			echo $args['after_widget'];
		}
		public function form( $instance ) {
			if ( isset( $instance[ 'title' ] ) )
				$title = $instance[ 'title' ];
			else
				$title = __( 'Default Title', 'wp-bootstrap-starter' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<?php
		}
		public function update( $new_instance, $old_instance ) {
			$instance = array();
			$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
			return $instance;
		}
	}
}

/**
 * Add style to login page
 */
add_action( 'login_head', 'equipeer_custom_login_head' );
function equipeer_custom_login_head() {
     $html = '<style>div#login p { background: white; padding: 5px; }</style>';
     echo $html;
}


/**
 * Save additional profile fields.      
 *
 * @param  int $user_id Current user ID.
 */        
add_action( 'personal_options_update', 'equipeer_save_profile_fields' );        
add_action( 'edit_user_profile_update', 'equipeer_save_profile_fields' );
if (!function_exists("equipeer_save_profile_fields")) {
	function equipeer_save_profile_fields( $user_id ) {
	
		if ( ! current_user_can( 'edit_usefr', $user_id ) ) {    
			return false;
		}
	
		update_usermeta( $user_id, 'equipeer_user_social_network', $_POST['equipeer_user_social_network'] );
		update_usermeta( $user_id, 'equipeer_user_social_id', $_POST['equipeer_user_social_id'] );
		update_usermeta( $user_id, 'equipeer_user_newsletter', $_POST['equipeer_user_newsletter'] );
		update_usermeta( $user_id, 'equipeer_user_sex', $_POST['equipeer_user_sex'] );
		update_usermeta( $user_id, 'equipeer_user_civility', $_POST['equipeer_user_civility'] );
		update_usermeta( $user_id, 'equipeer_user_group', $_POST['equipeer_user_group'] );
		update_usermeta( $user_id, 'equipeer_user_businessname', $_POST['equipeer_user_businessname'] );
		update_usermeta( $user_id, 'equipeer_user_siret', $_POST['equipeer_user_siret'] );
		update_usermeta( $user_id, 'equipeer_user_address_1', $_POST['equipeer_user_address_1'] );
		update_usermeta( $user_id, 'equipeer_user_address_2', $_POST['equipeer_user_address_2'] );
		update_usermeta( $user_id, 'equipeer_user_zip', $_POST['equipeer_user_zip'] );
		update_usermeta( $user_id, 'equipeer_user_city', $_POST['equipeer_user_city'] );
		update_usermeta( $user_id, 'equipeer_user_country', $_POST['equipeer_user_country'] );
		update_usermeta( $user_id, 'equipeer_user_club', $_POST['equipeer_user_club'] );
		update_usermeta( $user_id, 'equipeer_user_equestrian_level', $_POST['equipeer_user_equestrian_level'] );
		update_usermeta( $user_id, 'equipeer_user_equestrian_discipline', $_POST['equipeer_user_equestrian_discipline'] );
		update_usermeta( $user_id, 'equipeer_user_equestrian_discipline_2', $_POST['equipeer_user_equestrian_discipline_2'] );
		update_usermeta( $user_id, 'equipeer_user_equestrian_discipline_3', $_POST['equipeer_user_equestrian_discipline_3'] );
		update_usermeta( $user_id, 'equipeer_user_telephone', $_POST['equipeer_user_telephone'] );
		update_usermeta( $user_id, 'equipeer_user_birthday', $_POST['equipeer_user_birthday'] );
		update_usermeta( $user_id, 'equipeer_user_activity', $_POST['equipeer_user_activity'] );
		update_usermeta( $user_id, 'equipeer_user_activity_desc', $_POST['equipeer_user_activity_desc'] );
	}
}

/**
 * **************************************************************
 * ADVANCED TUTORIALS FOR WP USER MANAGER
 * https://docs.wpusermanager.com/category/83-advanced-tutorials
 * **************************************************************
 * Change the profile settings header text on the Account page
 */
add_filter( 'wpum_account_tabs', 'equipeer_wpum_profile_settings_title' );
if (!function_exists("equipeer_wpum_profile_settings_title")) {
	function equipeer_wpum_profile_settings_title( $tabs ) {
		$tabs['account']['name'] = __('My profile', EQUIPEER_ID);
		return $tabs;
	}
}

/** Create a new tab on the Profile page
================================================== */
add_filter( 'wpum_get_registered_profile_tabs', 'equipeer_wpum_get_registered_profile_tabs' );
if (!function_exists("equipeer_wpum_get_registered_profile_tabs")) {
	function equipeer_wpum_get_registered_profile_tabs( $tabs ) {
		$tabs['bookings'] = [
			'name'     => esc_html( 'Bookings' ),
			'priority' => 3,
		];
	
		return $tabs;
	}
}
add_filter( 'wpum_template_paths', 'equipeer_wpum_template_paths' );
if (!function_exists("equipeer_wpum_template_paths")) {
	function equipeer_wpum_template_paths( $paths) {
		$paths[] = dirname( __FILE__ ). '/wpum-templates';
	
		return $paths;
	}
}

/** How to add new links to the Account page tabs
================================================== */
add_filter( 'wpum_get_account_page_tabs', 'wpum_account_add_new_links' );
if (!function_exists("wpum_account_add_new_links")) {
	function wpum_account_add_new_links( $tabs ) {
		$tabs['address'] = array(
			'name'     => __('Address / Phone', EQUIPEER_ID) . ' / Newsletter',
			'priority' => 801,
		);
		$tabs['searches'] = array(
			'name'     => __('Saved searches', EQUIPEER_ID),
			'priority' => 802,
		);
		$tabs['selection'] = array(
			'name'     => __('My selection', EQUIPEER_ID),
			'priority' => 803,
		);
		$tabs['selections_sent'] = array(
			'name'     => __('Selections sent', EQUIPEER_ID),
			'priority' => 804,
		);
		$tabs['messaging'] = array(
			'name'     => __('My messages', EQUIPEER_ID),
			'priority' => 805,
		);
		$tabs['ads'] = array(
			'name'     => __('My ads', EQUIPEER_ID),
			'priority' => 806,
		);
		$tabs['document'] = array(
			'name'     => __('My documents', EQUIPEER_ID),
			'priority' => 807,
		);
		return $tabs;
	}
}

/** Specific content to new links on the Account page tabs
================================================== */
// --- ADDRESS
add_action( 'wpum_account_page_content_address', 'equipeer_account_tab_content_address' );
if (!function_exists("equipeer_account_tab_content_address")) {
	function equipeer_account_tab_content_address() {
		// render content
		include( get_stylesheet_directory() . '/wpum/forms/form-address.php' );
	}
}
// --- SEARCHES
add_action( 'wpum_account_page_content_searches', 'equipeer_account_tab_content_searches' );
if (!function_exists("equipeer_account_tab_content_searches")) {
	function equipeer_account_tab_content_searches() {
		// render content
		include( get_stylesheet_directory() . '/wpum/forms/form-searches.php' );
	}
}
// --- ADS
add_action( 'wpum_account_page_content_ads', 'equipeer_account_tab_content_ads' );
if (!function_exists("equipeer_account_tab_content_ads")) {
	function equipeer_account_tab_content_ads() {
		// render content
		include( get_stylesheet_directory() . '/wpum/forms/form-ads.php' );
	}
}
// --- SELECTION
add_action( 'wpum_account_page_content_selection', 'equipeer_account_tab_content_selection' );
if (!function_exists("equipeer_account_tab_content_selection")) {
	function equipeer_account_tab_content_selection() {
		// render content
		include( get_stylesheet_directory() . '/wpum/forms/form-selection.php' );
	}
}
// --- SELECTIONS SENT
add_action( 'wpum_account_page_content_selections_sent', 'equipeer_account_tab_content_selections_sent' );
if (!function_exists("equipeer_account_tab_content_selections_sent")) {
	function equipeer_account_tab_content_selections_sent() {
		// render content
		include( get_stylesheet_directory() . '/wpum/forms/form-selections-sent.php' );
	}
}
// --- MESSAGING
add_action( 'wpum_account_page_content_messaging', 'equipeer_account_tab_content_messaging' );
if (!function_exists("equipeer_account_tab_content_messaging")) {
	function equipeer_account_tab_content_messaging() {
		// render content
		include( get_stylesheet_directory() . '/wpum/forms/form-messaging.php' );
	}
}
// --- DOCUMENT
add_action( 'wpum_account_page_content_document', 'equipeer_account_tab_content_document' );
if (!function_exists("equipeer_account_tab_content_document")) {
	function equipeer_account_tab_content_document() {
		// render content
		include( get_stylesheet_directory() . '/wpum/forms/form-document.php' );
	}
}

/** Change tabs name
================================================== */
add_filter( 'wpum_get_account_page_tabs', 'wpum_account_change_settings_tab_name' );
function wpum_account_change_settings_tab_name( $tabs ) {
	$tabs['messaging']['name'] = esc_html__( 'My messages', EQUIPEER_ID );
	//$tabs['messaging']['name'] = html_entity_decode('My messages<br>toto'); // . do_shortcode('[yobro_chat_notification]');
	$tabs['settings']['name'] = esc_html__( 'My profile', EQUIPEER_ID );
	$tabs['password']['name'] = esc_html__( 'Manage my password', EQUIPEER_ID );
	
	return $tabs;
}

/** Redirect the login and register pages for logged in users to the account page
================================================== */
add_action( 'template_redirect', 'wpum_logged_in_login_redirect' );
if (!function_exists("wpum_logged_in_login_redirect")) {
	function wpum_logged_in_login_redirect() {
		if ( ! is_user_logged_in() ) {
			return;
		}
		
		// Check if option datas required activated
		if ( get_option('equine_profil_redirect_if_datas_required') == 1 ) {
	
			if ( is_page( wpum_get_core_page_id( 'login' ) ) || is_page( wpum_get_core_page_id( 'register' ) ) ) {
	
				/** Redirect user after login successful if incomplete datas
				================================================== */
				// Get required datas
				$user_info = get_userdata($user->ID);
				$firstname = $user_info->first_name;
				$lastname  = $user_info->last_name;
				$phone     = $user_info->equipeer_user_telephone;
				$address   = $user_info->equipeer_user_address_1;
				$zip       = $user_info->equipeer_user_zip;
				$city      = $user_info->equipeer_user_city;
				$country   = $user_info->equipeer_user_country;
				// Check if missing infos
				if ($firstname == '' || $lastname == '' || $phone == '' || $address == '' || $zip == '' || $city == '' || $country == '') {
					// Go to this page
					wp_redirect( get_permalink( wpum_get_core_page_id( 'account' ) ) . 'settings' );
				} elseif (isset($_GET['redirect_to']) && $_GET['redirect_to'] != '') {
					// Redirect to the referer page
					wp_redirect( get_site_url() . $_GET['redirect_to'] );
				}
			
				exit;
			}
			
		} else {
			// No redirect required
			return;
		}
	}
}

/** Redirect logged in users to the account page if DATAS REQUIRED are empty
================================================== */
add_action('init', 'equipeer_check_user_datas');
if (!function_exists("equipeer_check_user_datas")) {
	function equipeer_check_user_datas() {
		// --- Check if user is logged in
		if (is_user_logged_in()) {
			
			// Check if option datas required activated
			if ( get_option('equine_profil_redirect_if_datas_required') == 1 ) {
			
				// Debug
				$debug_init = false;
				if ($debug_init) equipeer_log_start();
				if ($debug_init) equipeer_log('Check user datas');
				// --- Get required datas
				$user_info = get_userdata( get_current_user_id() );
				$firstname = $user_info->first_name;
				$lastname  = $user_info->last_name;
				$phone     = $user_info->equipeer_user_telephone;
				$address   = $user_info->equipeer_user_address_1;
				$zip       = $user_info->equipeer_user_zip;
				$city      = $user_info->equipeer_user_city;
				$country   = $user_info->equipeer_user_country;
				// Check if missing infos
				if ($firstname == '' || $lastname == '' || $phone == '' || $address == '' || $zip == '' || $city == '' || $country == '') {
	
					// Get url
					$mystring = equipeer_current_url();
					$findme   = '/account';
					$pos      = strpos($mystring, $findme);
					if ($pos === false) {
						// Chaine non trouve - Redirection demandee
						if ($debug_init) equipeer_log('Redirect demandé - User id: '.get_current_user_id() . ' - Current URL: '.equipeer_current_url());
						wp_redirect( get_permalink( wpum_get_core_page_id( 'account' ) ) . 'settings' );
						exit;
					} else {
						// Chaine trouvee - Pas de redirection
						if ($debug_init) equipeer_log('Pas de redirection ('.$mystring.')');
					}
	
				} else {
					if ($debug_init) equipeer_log('Tous les champs requis sont présents');
				}
				
			}
				
		} else {
			if ($debug_init) equipeer_log_start();
			if ($debug_init) equipeer_log('--- User not logged in ---');
		}
	}
}

/** SEND IN BLUE Tracking - Register user
 ================================================= */
add_action( 'user_register', 'equipeer_registration_tracking', 10, 1 );
function equipeer_registration_tracking( $user_id ) {
	// -------------------------------------------------
	//  $_POST
	//  'user_email' => 'testregistration@domaine.com',
	//  'robo' => '',
	//  'user_password' => 'fdsqfdsqfMPOL8!',
	//  'wpum_field_16_ans_et_plus' => 
	//  array (
	//	0 => '16',
	//  ),
	//  'terms' => '1',
	//  'privacy' => '1',
	//  'wpum_form' => 'registration',
	//  'step' => '0',
	//  'registration_nonce' => '2261c42aed',
	//  '_wp_http_referer' => '/register/',
	//  'submit_registration' => 'Créer un compte',
	// -------------------------------------------------
	$email = trim($_POST['user_email']);	
	?>
		<script>
			// --------------------------
			// SEND IN BLUE
			// --------------------------
			sendinblue.identify('<?php echo $email; ?>', {
			  "PRENOM": "",
			  "NOM" : ""
			});
			// --------------------------
			// ----- SEND IN BLUE -----
			// --------------------------
			sendinblue.track(
			  'signed_up', {
				"PRENOM": "",
				"NOM" : "",
				"EMAIL" : "<?php echo $email; ?>"
			  }
			);
		</script>
	<?php

}

/** Add to activity log (SPY)
================================================== */
add_action('wp_login', 'equipeer_spy_wp_login', 10, 2);
function equipeer_spy_wp_login( $user_login, $user ) {
	// Check if login from groups to register in activity log
	$user_array = ['equipeer_expert', 'administrator', 'wpseo_manager', 'wpseo_editor']; // equipeer_expert | administrator | wpseo_manager | wpseo_editor
	$user_group = $user->roles[0];
	if (in_array($user_group, $user_array)) {
		// Check if login in front page
		if (!is_admin()) {
			equipeer_activity_log('Connexion', "Connexion à l'administration par $user_login - $user_group"); // depuis Site
		} else {
			equipeer_activity_log('Connexion', "Connexion à l'administration par $user_login - $user_group"); // depuis ADMIN
		}
	}
}

	
?>