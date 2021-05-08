<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Ajax
 *
 * @class Ajax
 */
class Equipeer_Ajax extends Equipeer {
	
    /**
     * Constructor for the Equipeer_Metabox class
     *
     * Sets up all the appropriate hooks and actions
     */
    function __construct() {
		// Enqueue script AJAX
        add_action( 'wp_print_scripts', array( $this, 'ajax_load_scripts' ) );
  		// ---------------------------------
		// Add SCRIPTS
		// ---------------------------------
		add_action( 'wp_ajax_selected_video', array( $this, 'selected_video' ) );
		add_action( 'wp_ajax_nopriv_selected_video', array( $this, 'selected_video' ) );
		// ---------------------------------
		add_action( 'wp_ajax_video_is', array( $this, 'video_is' ) );
		add_action( 'wp_ajax_nopriv_video_is', array( $this, 'video_is' ) );
		// ---------------------------------
		add_action( 'wp_ajax_equipeer_to_selection', array( $this, 'equipeer_to_selection' ) );
		add_action( 'wp_ajax_nopriv_equipeer_to_selection', array( $this, 'equipeer_to_selection' ) );
		// ---------------------------------
		add_action( 'wp_ajax_equipeer_selection_menu', array( $this, 'equipeer_selection_menu' ) );
		add_action( 'wp_ajax_nopriv_equipeer_selection_menu', array( $this, 'equipeer_selection_menu' ) );
		// ---------------------------------
		add_action( 'wp_ajax_equipeer_questionnaire_achat', array( $this, 'equipeer_questionnaire_achat' ) );
		add_action( 'wp_ajax_nopriv_equipeer_questionnaire_achat', array( $this, 'equipeer_questionnaire_achat' ) );
		// ---------------------------------
		add_action( 'wp_ajax_equipeer_save_search', array( $this, 'equipeer_save_search' ) );
		add_action( 'wp_ajax_nopriv_equipeer_save_search', array( $this, 'equipeer_save_search' ) );
		// ---------------------------------
        add_action( 'wp_ajax_equipeer_get_search_counter', array( $this, 'equipeer_get_search_counter' ) );
		add_action( 'wp_ajax_nopriv_equipeer_get_search_counter', array( $this, 'equipeer_get_search_counter' ) );
		// ---------------------------------
        add_action( 'wp_ajax_equipeer_ajax_search', array( $this, 'equipeer_ajax_search' ) );
		add_action( 'wp_ajax_nopriv_equipeer_ajax_search', array( $this, 'equipeer_ajax_search' ) );
        // ---------------------------------
        add_action( 'wp_ajax_equipeer_putad', array( $this, 'equipeer_putad' ) );
		add_action( 'wp_ajax_nopriv_equipeer_putad', array( $this, 'equipeer_putad' ) );
        // ---------------------------------
        add_action( 'wp_ajax_equipeer_moderate', array( $this, 'equipeer_moderate' ) );
		add_action( 'wp_ajax_nopriv_equipeer_moderate', array( $this, 'equipeer_moderate' ) );
        // ---------------------------------
        add_action( 'wp_ajax_equipeer_send_my_selection', array( $this, 'equipeer_send_my_selection' ) );
		add_action( 'wp_ajax_nopriv_equipeer_send_my_selection', array( $this, 'equipeer_send_my_selection' ) );
        // ---------------------------------
        add_action( 'wp_ajax_equipeer_contact', array( $this, 'equipeer_contact' ) );
		add_action( 'wp_ajax_nopriv_equipeer_contact', array( $this, 'equipeer_contact' ) );
        // ---------------------------------
        add_action( 'wp_ajax_equipeer_removal_request', array( $this, 'equipeer_removal_request' ) );
		add_action( 'wp_ajax_nopriv_equipeer_removal_request', array( $this, 'equipeer_removal_request' ) );
        // ---------------------------------
        add_action( 'wp_ajax_equipeer_contact_remove', array( $this, 'equipeer_contact_remove' ) );
		add_action( 'wp_ajax_nopriv_equipeer_contact_remove', array( $this, 'equipeer_contact_remove' ) );        
        // ---------------------------------
        add_action( 'wp_ajax_equipeer_pdf_add_file', array( $this, 'equipeer_pdf_add_file' ) );
		add_action( 'wp_ajax_nopriv_equipeer_pdf_add_file', array( $this, 'equipeer_pdf_add_file' ) );        
        // ---------------------------------
        add_action( 'wp_ajax_equipeer_pdf_send_files', array( $this, 'equipeer_pdf_send_files' ) );
		add_action( 'wp_ajax_nopriv_equipeer_pdf_send_files', array( $this, 'equipeer_pdf_send_files' ) );        
        // ---------------------------------
        
	}
	
	/**
	 * Ajax load scripts (Admin & Front)
	 *
	 * @return void
	 */
	function ajax_load_scripts() {
		if ( is_admin() ) {
			// load our jquery file that sends the $.post request (ADMIN)
			wp_enqueue_script( "equipeer-admin-ajax-script", EQUIPEER_URL . 'assets/js/admin-ajax.js', array( 'jquery' ) );
			// --- Initialize infos to pass
			// make the ajaxurl var available to the above script
			$equipeer_admin_options_to_ajax = [
				'ajaxurl'  => admin_url( 'admin-ajax.php'),  // equipeer_admin_ajax.ajaxurl
				'adminurl' => get_admin_url(),               // equipeer_admin_ajax.adminurl
			];
			wp_localize_script( 'equipeer-admin-ajax-script', 'equipeer_admin_ajax', $equipeer_admin_options_to_ajax );
		}
		// load our jquery file that sends the $.post request (FRONT)
		wp_enqueue_script( 'equipeer-ajax-script', EQUIPEER_URL . 'assets/js/ajax.js', array( 'jquery' ) );
		// make the ajaxurl var available to the above script
		$equipeer_options_to_ajax = [
			 'ajaxurl'                 => admin_url( 'admin-ajax.php')                                          // equipeer_ajax.ajaxurl
			,'ajaxloader_red'          => get_stylesheet_directory_uri() . '/assets/images/ajax-loader-red.gif' // equipeer_ajax.ajaxloader_red
			,'txt_addtoselection'      => __( 'Add to my selection', EQUIPEER_ID )                              // equipeer_ajax.txt_addtoselection
			,'txt_removefromselection' => __( 'Remove from my selection', EQUIPEER_ID )                         // equipeer_ajax.txt_removefromselection
			,'txt_next'                => __( 'Next', EQUIPEER_ID )                                             // equipeer_ajax.txt_next
			,'txt_previous           ' => __( 'Previous', EQUIPEER_ID )                                         // equipeer_ajax.txt_previous
		];
		wp_localize_script( 'equipeer-ajax-script', 'equipeer_ajax', $equipeer_options_to_ajax );
	}
	
	/**
	 * Populate Masthead Selection Menu
	 *
	 * @return html
	 */
	function equipeer_selection_menu() {
		//echo equipeer_get_selection('', $_POST['uid'], $limit = 3, $selection = true, $menu = true);
		echo equipeer_get_selection('', get_current_user_id(), $limit = 3, $selection = true, $menu = true);
		wp_die();
	}
	
	/**
	 * Get ADD / DEL Function (Selection)
	 *
	 * @return string
	 */
	function equipeer_to_selection() {
		global $wpdb;
		// Initialize
		$table   = Equipeer()->tbl_equipeer_selection_sport;
		$post_id = intval($_POST['pid']);
		$user_id = intval($_POST['uid']);
		$switch  = trim( $_POST['op'] );
		// Check if infos
		if ( (isset($user_id) && $user_id > 0) && (isset($post_id) && $post_id > 0) ) {
			// Switch OP
			switch($switch) {
				case "add":
					// Add selection in DB
					$add_result = $wpdb->insert( $table, array( 'uid' => $user_id, 'pid' => $post_id ), array( '%d', '%d' ) );
					//$add_result = true;
					if ($add_result) {
						$status      = "0";
						$title       = __( 'Bravo', EQUIPEER_ID );
						$description = __( 'Horse added to your selection', EQUIPEER_ID );

					} else {
						$status      = "1";
						$title       = __( 'Error', EQUIPEER_ID );
						$description = __( 'Inserting your selection failed', EQUIPEER_ID );
					}
					echo "$status|$title|$description|" . equipeer_count_selection(get_current_user_id());
				break;
				case "del":
					$del_result = $wpdb->delete( $table, array( 'uid' => $user_id, 'pid' => $post_id ), array( '%d', '%d' ) );
					//$del_result = true;
					if ($del_result) {
						$status      = "0";
						$title       = __( 'Selection', EQUIPEER_ID );
						$description = __( 'Horse removed from your selection', EQUIPEER_ID );
					} else {
						$status      = "1";
						$title       = __( 'Error', EQUIPEER_ID );
						$description = __( 'Removing your selection failed', EQUIPEER_ID );
					}
					echo "$status|$title|$description|" . equipeer_count_selection(get_current_user_id());
				break;
				default:
					$title       = __( 'Sorry', EQUIPEER_ID );
					$description = __( 'We did not understand your request', EQUIPEER_ID );
					echo "1|$title|$description|" . equipeer_count_selection(get_current_user_id());
				break;
			}
		} else {
			// ERROR
			$title       = __( 'Error', EQUIPEER_ID );
			$description = __( 'Saving your selection failed', EQUIPEER_ID );
			echo "1|$title|$description|" . equipeer_count_selection(get_current_user_id());
		}
	
		wp_die();
	}

    /**
     * Add file to client account
     *
     * @return bool
     */
    function equipeer_pdf_add_file() {
        global $wpdb;
        // -----------------------------
		// Initialize
        // -----------------------------
		$table     = Equipeer()->tbl_equipeer_pdf_client;
		$uid       = intval( $_POST['uid'] );
		$file_link = trim( $_POST['file_link'] );
		$file_size = trim( $_POST['file_size'] );
        // -----------------------------
        // User infos
        // -----------------------------
        $client = get_user_by('id', $uid);
        // -----------------------------
        $insert_search = $wpdb->insert( $table, 
            array( 
                 'uid'       => $uid
                ,'file_link' => $file_link
                ,'file_size' => $file_size
            ), 
            array( '%d', '%s', '%s' ) 
        );
        // -----------------------------
        equipeer_activity_log('PDF', "Ajout d'un fichier à un compte client (<a target='_blank' href='$file_link'>Fichier client</a>) - Client : ".esc_html($client->user_nicename)." ({$client->user_email})");
        // -----------------------------
        echo 1;
        // -----------------------------
        wp_die();
        // -----------------------------
    }
    
    /**
     * Send email to client / expert / admins
     * For PDF file selections
     *
     * @return bool
     */
    function equipeer_pdf_send_files() {
        // -----------------------------
        // --- Initialization
        // -----------------------------
        $email_client  = trim($_POST['email_client']);
        $email_expert  = trim($_POST['email_expert']);
        // -----------------------------
        // --- Subject
        // -----------------------------
        $email_subject = trim($_POST['email_subject']);
        // -----------------------------
        // --- Body
        // -----------------------------
        $email_lang         = (ICL_LANGUAGE_CODE == 'fr') ? 'fr' : 'en';
        $_email_client_body = get_option("equine_email_client_message_pdf_".$email_lang);
        $email_body         = trim($_POST['email_body']);
        // -----------------------------
        // --- Files (attachments)
        // -----------------------------
        // Paths : $_POST['path_client'] / $_POST['path_expert']
        // URLs : $_POST['link_client'] / $_POST['link_expert']
        $attachments_client = array( $_POST['path_client'] );
        $attachments_expert = array( $_POST['path_expert'] );
        // -----------------------------
        // --- Client infos
        // -----------------------------
        $client = get_user_by( 'email', $email_client );
        // -----------------------------
        // -----------------------------
        // --- Send Email to CLIENT
        // -----------------------------
        // -----------------------------
        add_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
        // -----------------------------
        // --- Get EMAIL template
        // -----------------------------
        ob_start();
        include(get_stylesheet_directory() . '/templates/emails/email-equipeer.php');
        $email_client_body = $email_admin_body = ob_get_contents();
        ob_end_clean();
        // -----------------------------
        // --- Replace Variables in email body
        // -----------------------------
        $_email_client_body = @preg_replace("/{CLIENT_NAME}/", esc_html($client->first_name . ' ' . $client->last_name), $_email_client_body);
        $_email_client_body = @preg_replace("/{CLIENT_MESSAGE}/", stripslashes($email_body), $_email_client_body);
        $_email_client_body = @preg_replace("/{CLIENT_LINK}/", '<a href="'.$_POST['link_client'].'">PDF</a>', $_email_client_body);
        $email_client_body  = @preg_replace("/{EMAIL_CONTENT}/", stripslashes_deep(nl2br($_email_client_body)), $email_client_body);
        // --- Send email (Headers)
        $headers   = ["From: EQUIPEER <noreply@equipeer.com>", "Content-Type: text/html; charset=UTF-8"];
        $to_client = $email_client;
        $body      = $email_client_body;
        // --------------------------------------
        $client_email_result = wp_mail( $to_client, $email_subject, stripslashes($body), $headers, $attachments_client );
        // -----------------------------
        // -----------------------------
        // Send Email to EXPERT / ADMIN
        // -----------------------------
        // -----------------------------
        $admin_message  = "Bonjour EXPERT,<br><br>Voici le fichier de sélections expertisées que vous avez envoyé à votre client ainsi que votre fichier Expert :<br><br>Client : <a href='".$_POST['link_client']."'>".$_POST['link_client']."</a><br>Expert : <a href='".$_POST['link_expert']."'>".$_POST['link_expert']."</a><br>Client: ".esc_html($client->first_name . ' ' . $client->last_name)." - $email_client<br><br>Message à l'attention d'un EXPERT";
        $email_admin_body = @preg_replace("/{EMAIL_CONTENT}/", $admin_message, $email_admin_body);
        // --- Send email (Headers)
        // (string|array) (Required) Array or comma-separated list of email addresses to send message
        $emails    = (get_option('equine_email_admin_pdf') != '') ? get_option('equine_email_admin_pdf') : get_option('admin_email');
        $emails    = $emails . ',' . $email_expert;
        $comma     = strpos($emails, ","); // Search if several emails
        $to_admins = ($comma === false) ? $emails : explode(",", $emails);
        $subject   = "Envoi de sélections PDFs EQUIPEER.COM";
        $body      = $email_admin_body;
        // -----------------------------
        $admin_email_result = wp_mail( $to_admins, $subject, $body, $headers );
        // Reset content-type to avoid conflicts -- https://core.trac.wordpress.org/ticket/23578
        remove_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
        // -----------------------------
        equipeer_activity_log('PDF', "Envoi des fichiers PDFs (<a target='_blank' href='".$_POST['link_client']."'>Client</a> - <a target='_blank' href='".$_POST['link_expert']."'>Expert</a>) au client ".esc_html($client->first_name . ' ' . $client->last_name)." ($email_client)<br>Sujet : $email_subject<br>Message : ".stripslashes($email_body));
        // -----------------------------
        echo '1';
        // -----------------------------
        wp_die();
        // -----------------------------
    }
    
	/**
	 * Moderate AD in Admin
	 *
	 * @return string
	 */
	function equipeer_moderate() {
        global $sitepress, $wpdb;
        $email_lang        = (ICL_LANGUAGE_CODE == 'fr') ? 'fr' : 'en';
        $op                = trim($_POST['op']);
        $post_id           = intval($_POST['pid']);
        $email             = trim($_POST['email']);
        $reject_cause      = trim($_POST['cause']);
        $reject_subject    = trim($_POST['cause_subject']);
        $user              = get_user_by( 'email', $email );
        $client            = ucfirst(strtolower($user->first_name)) . ' ' . strtoupper($user->last_name);
        $url               = get_permalink($post_id);
        $price             = number_format( get_post_meta( $post_id, 'price_equipeer', true ), 0, ",", " ");
        $horse_name        = get_the_title($post_id);
        $the_prefix        = @get_term_meta( @get_post_meta( $post_id, 'discipline', true ), 'equipeer_prefix_taxonomy_parent_id', true );
        $the_reference     = equipeer_get_format_reference( @get_post_meta( $post_id, 'reference', true ) );                
        $horse_reference   = $the_prefix . '-' . $the_reference;
        $horse_photo_id    = get_post_meta($post_id, 'photo_1', true);
        $email_photo_1     = wp_get_attachment_image_url( $horse_photo_id, 'thumbnail');
        $horse_age_total   = (date('Y') - get_post_meta($post_id, 'birthday', true));
        $horse_age         = ($horse_age_total < 1) ? 'Foal' : ( ($horse_age_total > 1) ? $horse_age_total . ' ' . __('years', EQUIPEER_ID) : $horse_age_total . ' ' . __('year', EQUIPEER_ID) );
        $horse_discipline  = get_term_by( 'id', absint( get_post_meta($post_id, 'discipline', true) ), 'equipeer_discipline' );
        // Switch
        switch($op) {
            case "accept":
                // --------------------------------------
                // Publish post
                // --------------------------------------
                $wpdb->update( $wpdb->prefix . 'posts', array( 'post_status' => 'publish' ), array( 'ID' => $post_id ) );
                // --------------------------------------
                // Publish Translations
                // --------------------------------------
                $duplicate_status = apply_filters('wpml_element_translation_type', NULL, $post_id, Equipeer()->post_type);
                if ($duplicate_status == 1 ) {
                    // Get Translation ID (trid)
                    $trid        = $sitepress->get_element_trid($post_id);
                    $translation = $sitepress->get_element_translations($trid);
                    // update post_status for all translations except the current language
                    foreach( $translation as $language_code => $post_details ) {
                        if( ICL_LANGUAGE_CODE != $language_code ) {
                             $wpdb->update( $wpdb->prefix . 'posts', array( 'post_status' => $post->post_status ), array( 'ID' => $post_details->element_id ) );
                        }
                    }
                }
                // --------------------------------------
                // Send Email Client (Initialize)
                // --------------------------------------
                $_email_client_body = get_option('equine_email_client_moderate_ok_'.$email_lang);
                $subject           = __("Great, your ad is published on EQUIPEER.COM", EQUIPEER_ID);
                //$subject   = @preg_replace("/{MODERATE_HORSE_NAME}/", esc_html($data['horse_name']), $subject);
                // --------------------------------------
                // Log activity
                // --------------------------------------
                equipeer_activity_log('Moderate accept', "Moderation : Mise en ligne de $horse_name - REF: $horse_reference");
            break;
            case "reject":
                // --------------------------------------
                // Delete post
                // --------------------------------------
                $wpdb->delete( $wpdb->prefix . 'posts', array( 'ID' => $post_id ) );
                // --------------------------------------
                // Delete Translations
                // --------------------------------------
                $duplicate_status = apply_filters('wpml_element_translation_type', NULL, $post_id, Equipeer()->post_type);
                if ($duplicate_status == 1 ) {
                    // Get Translation ID (trid)
                    $trid        = $sitepress->get_element_trid($post_id);
                    $translation = $sitepress->get_element_translations($trid);
                    // Delete posts for all translations except the current language
                    foreach( $translation as $language_code => $post_details ) {
                        if( ICL_LANGUAGE_CODE != $language_code ) {
                             $wpdb->delete( $wpdb->prefix . 'posts', array( 'ID' => $post_details->element_id ) );
                        }
                    }
                }
                // --------------------------------------
                // Send Email Client (Initialize)
                // --------------------------------------
                $_email_client_body = get_option('equine_email_client_moderate_ko_'.$email_lang);
                //$subject           = __("Sorry, your ad cannot be published on EQUIPEER.COM", EQUIPEER_ID);
                $subject           = esc_html($reject_subject);
                //$subject   = @preg_replace("/{MODERATE_HORSE_NAME}/", esc_html($data['horse_name']), $subject);
                // --------------------------------------
                // Log activity
                // --------------------------------------
                equipeer_activity_log('Moderate reject', "Moderation : Refus de $horse_name - REF: $horse_reference");
            break;
        }
        
        if ($op == 'accept' || $op == 'reject') {
            // --- Send Email to CLIENT
            add_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
            // --------------------------------------
            // --- Get EMAIL template
            // --------------------------------------
            ob_start();
            include(get_stylesheet_directory() . '/templates/emails/email-equipeer.php');
            $email_client_body = ob_get_contents();
            ob_end_clean();
            // --------------------------------------
            // --- Replace Variables in email body
            // --------------------------------------
            $_email_client_body = @preg_replace("/{MODERATE_CLIENT}/", esc_html($client), $_email_client_body);
             if ($op == 'accept') {
                $_email_client_body = @preg_replace("/{MODERATE_HORSE_IMAGE}/", '<div style="border: 1px solid #d1023e; float: left; margin: 0 5px 5px 0; width: 160px; height: 210px;"><a href="' . get_permalink( $post_id ) . '"><img style="object-fit: cover; height: 160px; width: 100%;" src="' . esc_url($email_photo_1) . '" alt="" /></a><p style="text-align: center; color: #0e2d4c;">' . $horse_reference . '</p></div><div style="clear: both;">&nbsp;</div>', $_email_client_body);
             } else {
                $_email_client_body = @preg_replace("/{MODERATE_HORSE_IMAGE}/", '<div style="border: 1px solid #d1023e; float: left; margin: 0 5px 5px 0; width: 160px; height: 160px;"><img style="object-fit: cover; height: 160px; width: 100%;" src="' . esc_url($email_photo_1) . '" alt="" /></div><div style="clear: both;">&nbsp;</div>', $_email_client_body);
             }
            $_email_client_body = @preg_replace("/{MODERATE_HORSE_REF}/", esc_html($horse_reference), $_email_client_body);
            $_email_client_body = @preg_replace("/{MODERATE_HORSE_NAME}/", esc_html($horse_name), $_email_client_body);
            $_email_client_body = @preg_replace("/{MODERATE_HORSE_AGE}/", esc_html($horse_age), $_email_client_body);
            $_email_client_body = @preg_replace("/{MODERATE_HORSE_PRICE}/", esc_html($price . ' euros'), $_email_client_body);
            $_email_client_body = @preg_replace("/{MODERATE_HORSE_DISCIPLINE}/", esc_html($horse_discipline->name), $_email_client_body);
            $_email_client_body = @preg_replace("/{MODERATE_HORSE_URL}/", '<a href="'.esc_html($url).'">'.esc_html($url).'</a>', $_email_client_body);
            $_email_client_body = @preg_replace("/{MODERATE_REJECT_CAUSE}/", esc_html($reject_cause), $_email_client_body);
            $email_client_body  = @preg_replace("/{EMAIL_CONTENT}/", stripslashes_deep(nl2br($_email_client_body)), $email_client_body);
            // --- Send email (Headers)
            $headers   = ["From: EQUIPEER <noreply@equipeer.com>", "Content-Type: text/html; charset=UTF-8"];
            $to_client = $email;
            $body      = $email_client_body;
            // --------------------------------------
            $client_email_result = wp_mail( $to_client, $subject, $body, $headers );
            // Reset content-type to avoid conflicts -- https://core.trac.wordpress.org/ticket/23578
            remove_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
        }
        
        //echo '';
        wp_die();
    }
	
	/**
	 * Find you horse Form
	 *
	 * @return form
	 */
	function equipeer_questionnaire_achat() {
		global $wpdb;
		// Initialize
		$step       = $_POST['step'];
		$step_next  = $_POST['step_next'];
		$step_total = $_POST['step_total'];
		// Display Content
		echo do_shortcode("[equine-questionnaire-projet step=$step_next]");
		
		wp_die();
	}
    
    /**
     * Save my search
     *
     * @return bool
     */
    function equipeer_save_search() {
		global $wpdb, $wp;
		// Initialize
        $table  = Equipeer()->tbl_equipeer_user_save_search;
        $name   = (isset($_POST['search_name']) && $_POST['search_name'] != '') ? equipeer_stop_XSS($_POST['search_name']) : 'Search ' . time();
        $warned = ($_POST['search_be_warned'] == 'true') ? '1' : '0';
        $string = trim($_POST['search_string']);
        $uid    = get_current_user_id();
        // ---------------------------------------
        $full_url = trim($_POST['search_url']);
        list($_start, $_args) = explode('?', $full_url);
        // ---------------------------------------        
        $insert_search = $wpdb->insert( $table, 
            array( 
                 'uid'       => $uid
                ,'name'      => $name
                ,'url'       => $full_url
                ,'args'      => $_args
                ,'be_warned' => $warned
            ), 
            array( '%d', '%s', '%s', '%s', '%d' ) 
        );
        
        // -----------------------------
        // -----------------------------
        // Send Email to ADMIN
        // -----------------------------
        // -----------------------------
        add_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
        // -----------------------------
		$user_info    = get_userdata(get_current_user_id());
		$client_name  = ucfirst(strtolower($user_info->first_name)) . ' ' . strtoupper($user_info->last_name);
		$client_email = $user_info->user_email;
        // -----------------------------
        $email_admin_body = "Bonjour ADMIN,<br><br>Un client a sauvegardé une recherche :<br><br>Client : $client_name - $client_email<br>Recherche : $string<br>Url de recherche : $full_url<br><br>Message automatique provenant du site EQUIPEER";
        // --- Send email (Headers)
        // (string|array) (Required) Array or comma-separated list of email addresses to send message
        $emails    = (get_option('equine_email_admin_save_search') != '') ? get_option('equine_email_admin_save_search') : get_option('admin_email');
        $comma     = strpos($emails, ","); // Search if several emails
        $to_admins = ($comma === false) ? $emails : explode(",", $emails);
        $subject   = "Sauvegarde d'une recherche sur EQUIPEER.COM";
        $body      = nl2br($email_admin_body);
        // -----------------------------
        $admin_email_result = wp_mail( $to_admins, $subject, $body, $headers );
        // Reset content-type to avoid conflicts -- https://core.trac.wordpress.org/ticket/23578
        remove_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
        
        // Return result request
        $return_query = ($insert_search) ? '1' : '0';
        echo $return_query;
        
        wp_die();
    }
    
    /**
     * Send email to admin to remove an ad
     *
     * @return bool
     */
    function equipeer_removal_request() {
        global $wpdb;
        $post_id          = intval($_POST['pid']);
        $user_id          = intval($_POST['uid']);
        $reason_to_remove = trim($_POST['remove']);
        // -----------------------------
        $post  = get_post( $post_id );
        $title = $post->post_title;
        $ref   = get_post_meta( $post_id, 'reference', true);
        $link  = get_permalink( $post_id );
        // -----------------------------
		$user_info    = get_userdata($user_id);
		$client_name  = ucfirst(strtolower($user_info->first_name)) . ' ' . strtoupper($user_info->last_name);
		$client_email = $user_info->user_email;
        // -----------------------------
        // Save record in DB
        $tbl_removal_request = Equipeer()->tbl_equipeer_removal_request;
        $wpdb->insert( $tbl_removal_request, 
            array( 'uid' => $user_id, 'pid' => $post_id, 'reason' => $reason_to_remove ), 
            array( '%d', '%d', '%s' ) 
        );
        // -----------------------------
        // -----------------------------
        // Send Email to ADMIN
        // -----------------------------
        // -----------------------------
        add_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
        // -----------------------------
        // --- Get EMAIL template
        // -----------------------------
        ob_start();
        include(get_stylesheet_directory() . '/templates/emails/email-equipeer.php');
        $email_admin_body = ob_get_contents();
        ob_end_clean();
        // -----------------------------
        $admin_message = "Bonjour ADMIN,<br><br>Un client a demandé la suppression d'une de ses annonces :<br><br>Client: $client_name - $client_email<br>Référence : $ref<br>Annonce : $title<br>Raison de la suppression : ".stripslashes($reason_to_remove)."<br><br>Message provenant de la demande d'un client depuis son compte EQUIPEER";
        $email_admin_body = @preg_replace("/{EMAIL_CONTENT}/", $admin_message, $email_admin_body);
        // -----------------------------
        // --- Send email (Headers)
        // -----------------------------
        // (string|array) (Required) Array or comma-separated list of email addresses to send message
        $emails    = (get_option('equine_email_admin_removal_request') != '') ? get_option('equine_email_admin_removal_request') : get_option('admin_email');
        $comma     = strpos($emails, ","); // Search if several emails
        $to_admins = ($comma === false) ? $emails : explode(",", $emails);
        $subject   = "Demande de suppression d'annonce EQUIPEER.COM";
        $body      = $email_admin_body;
        // -----------------------------
        $admin_email_result = wp_mail( $to_admins, $subject, $body, $headers );
        // Reset content-type to avoid conflicts -- https://core.trac.wordpress.org/ticket/23578
        remove_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
        // -----------------------------
        echo '1';
        // -----------------------------
        wp_die();
    }
    
    /**
     * Put new ad in DB (moderation)
     *
     * @return bool
     */
    function equipeer_putad() {
        global $wpdb, $wp, $sitepress;
        // -------------------------------
        // DATAS Post in array
        // -------------------------------
        $data = [];
        foreach($_POST as $key => $value) {
            $data[$key] = $value;
        }
        // -------------------------------
        // Update user profile
        // -------------------------------
        $user_id = get_current_user_id();
        if (isset($data['user_phone']) && $data['user_phone'] != '') update_user_meta($user_id, 'equipeer_user_telephone', $data['user_phone']);
        if (isset($data['user_address']) && $data['user_address'] != '') update_user_meta($user_id, 'equipeer_user_address_1', $data['user_address']);
        if (isset($data['user_zip']) && $data['user_zip'] != '') update_user_meta($user_id, 'equipeer_user_zip', $data['user_zip']);
        if (isset($data['user_city']) && $data['user_city'] != '') update_user_meta($user_id, 'equipeer_user_city', $data['user_city']);
        if (isset($data['user_country']) && $data['user_country'] != '') update_user_meta($user_id, 'equipeer_user_country', $data['user_country']);
        // -------------------------------
        // Get Last Reference in DB
        // -------------------------------
        // --- Reference
		$last_id = $last_reference = "";
		$args    = array(
			 'post_type'              => Equipeer()->post_type
			,'post_status'            => array( 'moderate', 'publish', 'pending', 'draft', 'future', 'private', 'off' )
			//,'perm'                   => 'readable' // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
			,'cache_results'          => false // False pour eviter des incrementations aleatoires
			,'update_post_meta_cache' => false
			,'update_post_term_cache' => false
			,'orderby'                => 'meta_value_num' //'meta_value'
			,'order'                  => 'DESC'
			,'meta_key'               => 'reference'
			,'posts_per_page'         => 1
		);
		$query = new WP_Query( $args );
		if ( !$query->have_posts() ) return; // Check if have posts
		$last_reference = get_post_meta( $query->post->ID, 'reference', true ); // Get the meta value (by LAST ID)
		$horse_reference = (intval($last_reference)) + 1; // Return last reference + 1
        // -------------------------------
        // Insert AD in DB
        // -------------------------------
        $data_to_insert = [
             'post_title'  => $data['horse_name']
            ,'post_status' => 'moderate'
            ,'post_type'   => Equipeer()->post_type
            ,'meta_input'  => [
                 'reference'              => $horse_reference
                ,'sire'                   => $data['horse_sire']
                ,'type_annonce'           => $data['horse_type_ad']
                ,'type_canasson'          => $data['horse_type']
                ,'discipline'             => $data['horse_discipline']
                ,'birthday_real'          => $data['horse_date_of_birth']
                ,'birthday'               => $data['horse_birthday']
                ,'breed'                  => $data['horse_breed']
                ,'sex'                    => $data['horse_sex']
                ,'dress'                  => $data['horse_color']
                ,'size'                   => $data['horse_size']
                ,'size_cm'                => $data['horse_size_cm']
                // ---------------------------------------------------------
                ,'price_real'             => $data['horse_price_real']
                ,'price_equipeer'         => $data['horse_price_equipeer']
                ,'price_commission'       => $data['horse_commission']
                ,'price_tva_taux'         => $data['horse_taux_tva']
                ,'price_tva'              => $data['horse_is_tva']
                // ---------------------------------------------------------
                ,'impression'             => esc_html(strip_tags($data['horse_impression']))
                // ---------------------------------------------------------
                ,'proprietaire'           => $data['user_name'] . ' (' . $data['user_email'] . ') - ' . $data['user_address'] . ', ' . $data['user_city'] . ' (' . $data['user_zip'] . ') - ' . $data['user_country']
                ,'owner_email'            => $data['user_email']
                ,'phone'                  => $data['user_phone']
                ,'contact_by_phone'       => $data['user_contact_by_email']
                ,'contact_by_email'       => $data['usercontact_by_phone']
                ,'localisation_address'   => trim($data['horse_street_number'] . ' ' . $data['horse_address'])
                ,'localisation_zip'       => $data['horse_zip']
                ,'localisation_city'      => $data['horse_city']
                ,'localisation_country'   => $data['horse_country']
                ,'localisation_latitude'  => $data['horse_latitude']
                ,'localisation_longitude' => $data['horse_longitude']
                // ---------------------------------------------------------
                ,'veterinaire_date'       => $data['horse_date_veto']
                // ---------------------------------------------------------
                ,'sold'                   => 0
                // ---------------------------------------------------------
            ]
        ];
        // -------------------------------
        // WP INSERT DATAS
        // -------------------------------
        $insert_id = wp_insert_post( $data_to_insert );
        // -------------------------------
        // Insert medias in DB if exists
        // -------------------------------
        // --- Initialize
        $user_media_directory = ABSPATH . 'uploads/' . $user_id . '/' . $data['horse_user_time'] . '/';
        $user_media_url       = get_site_url() . '/uploads/' . $user_id . '/' . $data['horse_user_time'] . '/';
        $wp_upload_dir        = wp_upload_dir(); // path | url | subdir | basedir | baseurl | error
        $medias_authorized    = ['photo_1','photo_2','photo_3','photo_4','video_5','video_6','video_7','video_8','document_9'];
        $media_photo_1 = $media_photo_2 = $media_photo_3 = $media_photo_4 = $media_video_1 = $media_video_2 = $media_video_3 = $media_video_4 = $media_document_1 = $video_main = $video_main_id = $video_second = $video_second_id = $video_third = $video_third_id = $video_fourth = $video_fourth_id = false; 
        // -- List all files
        $user_files = array_diff(scandir($user_media_directory), array('.', '..'));        
        foreach($user_files as $file) {
            $filename = pathinfo($file, PATHINFO_FILENAME);
            $filext   = pathinfo($file, PATHINFO_EXTENSION);
            // --- Check
            if (in_array($filename, $medias_authorized)) {                
                // --- Instantiante Value
                $tmp_file     = $user_media_directory . $file;
                $new_filename = $data['horse_user_time'] . '_' . $file;
                switch($filename) {
                    case "photo_1":
                        $media_photo_1 = equipeer_insert_attachment($tmp_file, $new_filename, $insert_id);
                    break;
                    case "photo_2":
                        $media_photo_2 = equipeer_insert_attachment($tmp_file, $new_filename, $insert_id);
                    break;
                    case "photo_3":
                        $media_photo_3 = equipeer_insert_attachment($tmp_file, $new_filename, $insert_id);
                    break;
                    case "photo_4":
                        $media_photo_4 = equipeer_insert_attachment($tmp_file, $new_filename, $insert_id);
                    break;
                    case "video_5":
                        $media_video_1 = equipeer_insert_attachment($tmp_file, $new_filename, $insert_id);
                        if ($media_video_1) {
                            $video_main    = wp_get_attachment_url( $media_video_1 );
                            $video_main_id = $media_video_1;
                        }
                    break;
                    case "video_6":
                        $media_video_2 = equipeer_insert_attachment($tmp_file, $new_filename, $insert_id);
                        if ($media_video_2) {
                            $video_second    = wp_get_attachment_url( $media_video_2 );
                            $video_second_id = $media_video_2;
                        }
                    break;
                    case "video_7":
                        $media_video_3 = equipeer_insert_attachment($tmp_file, $new_filename, $insert_id);
                        if ($media_video_3) {
                            $video_third    = wp_get_attachment_url( $media_video_3 );
                            $video_third_id = $media_video_3;
                        }
                    break;
                    case "video_8":
                        $media_video_4 = equipeer_insert_attachment($tmp_file, $new_filename, $insert_id);
                        if ($media_video_4) {
                            $video_fourth    = wp_get_attachment_url( $media_video_4 );
                            $video_fourth_id = $media_video_4;
                        }
                    break;
                    case "document_9":
                        $media_document_1 = equipeer_insert_attachment($tmp_file, $new_filename, $insert_id);
                    break;
                }
            }
        }
        // -------------------------------
        // POST STATUS / PERMALINK
        // -------------------------------
        // --- New permalink
        $new_permalink = strtolower( equipeer_rewrite_string( strtolower( equipeer_head_text_horse( $insert_id, false, "-", "permalink" ) ) ) );
        // --- Check videos
        if (!$video_main && trim($data['horse_media_video_link_1']) != '') $video_main = equipeer_check_youtube_url(trim($data['horse_media_video_link_1']));
        if (!$video_second && trim($data['horse_media_video_link_2']) != '') $video_second = equipeer_check_youtube_url(trim($data['horse_media_video_link_2']));
        if (!$video_third && trim($data['horse_media_video_link_3']) != '') $video_third = equipeer_check_youtube_url(trim($data['horse_media_video_link_3']));
        if (!$video_fourth && trim($data['horse_media_video_link_4']) != '') $video_fourth = equipeer_check_youtube_url(trim($data['horse_media_video_link_4']));
        // --- Update Array
        $moderate_ad = [
             'ID'        => $insert_id
            ,'post_name' => $new_permalink
            ,'meta_input' => [
                 'veterinaire_document' => $media_document_1
                // ---------------------------------------------------------
                ,'photo_1' => $media_photo_1
                ,'photo_2' => $media_photo_2
                ,'photo_3' => $media_photo_3
                ,'photo_4' => $media_photo_4
                // ---------------------------------------------------------
                ,'video_main'      => $video_main
                ,'video_main_id'   => $video_main_id
                ,'video_second'    => $video_second
                ,'video_second_id' => $video_second_id
                ,'video_third'     => $video_third
                ,'video_third_id'  => $video_third_id
                ,'video_fourth'    => $video_fourth
                ,'video_fourth_id' => $video_fourth_id
            ]
        ];
        // -------------------------------
        wp_update_post( $moderate_ad );
        // -------------------------------
        // TRANSLATE TEXT
        // -------------------------------
        $gatt_target = (ICL_LANGUAGE_CODE == 'fr') ? "en" : "fr";
        $source      = ICL_LANGUAGE_CODE;
        // -------------------------------
        $translate_impression = equipeer_translate( $data['horse_impression'], $gatt_target, $source ); // Array: translated | source
        // -------------------------------
        // --- New permalink
        $new_permalink_en = strtolower( equipeer_rewrite_string( strtolower( equipeer_head_text_horse_url( $insert_id, false, "-", "permalink" ) ) ) );
        // -------------------------------
        // Creating translation of first post in another language. Right now for english        
        $en_args = array(
             'post_title'  => $data['horse_name']
            ,'post_name'   => $new_permalink_en
            ,'post_status' => 'moderate'
            ,'post_type'   => Equipeer()->post_type
            ,'meta_input' => [
                 'reference'              => $horse_reference
                ,'sire'                   => $data['horse_sire']
                ,'type_annonce'           => $data['horse_type_ad']
                ,'type_canasson'          => $data['horse_type']
                ,'discipline'             => $data['horse_discipline']
                ,'birthday_real'          => $data['horse_date_of_birth']
                ,'birthday'               => $data['horse_birthday']
                ,'breed'                  => $data['horse_breed']
                ,'sex'                    => $data['horse_sex']
                ,'dress'                  => $data['horse_color']
                ,'size'                   => $data['horse_size']
                ,'size_cm'                => $data['horse_size_cm']
                // ---------------------------------------------------------
                ,'price_real'             => $data['horse_price_real']
                ,'price_equipeer'         => $data['horse_price_equipeer']
                ,'price_commission'       => $data['horse_commission']
                ,'price_tva_taux'         => $data['horse_taux_tva']
                ,'price_tva'              => $data['horse_is_tva']
                // ---------------------------------------------------------
                ,'impression'             => esc_html(strip_tags($translate_impression['translated']))
                // ---------------------------------------------------------
                ,'proprietaire'           => $data['user_name'] . ' (' . $data['user_email'] . ') - ' . $data['user_address'] . ', ' . $data['user_city'] . ' (' . $data['user_zip'] . ') - ' . $data['user_country']
                ,'owner_email'            => $data['user_email']
                ,'phone'                  => $data['user_phone']
                ,'contact_by_phone'       => $data['user_contact_by_email']
                ,'contact_by_email'       => $data['usercontact_by_phone']
                ,'localisation_address'   => trim($data['horse_street_number'] . ' ' . $data['horse_address'])
                ,'localisation_zip'       => $data['horse_zip']
                ,'localisation_city'      => $data['horse_city']
                ,'localisation_country'   => $data['horse_country']
                ,'localisation_latitude'  => $data['horse_latitude']
                ,'localisation_longitude' => $data['horse_longitude']
                // ---------------------------------------------------------
                ,'veterinaire_date'       => $data['horse_date_veto']
                // ---------------------------------------------------------
                ,'veterinaire_document' => $media_document_1
                // ---------------------------------------------------------
                ,'photo_1' => $media_photo_1
                ,'photo_2' => $media_photo_2
                ,'photo_3' => $media_photo_3
                ,'photo_4' => $media_photo_4
                // ---------------------------------------------------------
                ,'video_main'      => $video_main
                ,'video_main_id'   => $video_main_id
                ,'video_second'    => $video_second
                ,'video_second_id' => $video_second_id
                ,'video_third'     => $video_third
                ,'video_third_id'  => $video_third_id
                ,'video_fourth'    => $video_fourth
                ,'video_fourth_id' => $video_fourth_id
                // ---------------------------------------------------------
            ]
        );
        // -------------------------------
        // CREATE EN POST
        // -------------------------------
        // --- Include WPML API
        include_once( WP_PLUGIN_DIR . '/sitepress-multilingual-cms/inc/wpml-api.php' );
        // --- Insert translated post
        $post_translated_id = wp_insert_post( $en_args );
        // --- Get trid of original post
        $trid = wpml_get_content_trid( 'post_' . Equipeer()->post_type, $insert_id );
        // --- Associate original post and translated post
        $wpdb->update( $wpdb->prefix.'icl_translations', array( 'trid' => $trid, 'element_type' => 'post_' . Equipeer()->post_type, 'language_code' => $gatt_target, 'source_language_code' => $source ), array( 'element_id' => $post_translated_id ) );
        // -----------------------------
        // Send EMAIL (Initialize)
        // -----------------------------
        $email_lang         = (ICL_LANGUAGE_CODE == 'fr') ? 'fr' : 'en';
        $_email_client_body = get_option('equine_email_client_putad_alert_'.$email_lang);
        $horse_reference    = get_post_meta($insert_id, 'reference', true);
        $horse_age_total    = (date('Y') - $data['horse_birthday']);
        $horse_age          = ($horse_age_total < 1) ? 'Foal' : ( ($horse_age_total > 1) ? $horse_age_total . ' ' . __('years', EQUIPEER_ID) : $horse_age_total . ' ' . __('year', EQUIPEER_ID) );
        $horse_discipline   = get_term_by( 'id', absint( $data['horse_discipline'] ), 'equipeer_discipline' );
        $email_photo_1      = wp_get_attachment_image_url( $media_photo_1, 'thumbnail');
        $email_photo_html   = '<div style="border: 1px solid #d1023e; float: left; margin: 0 5px 5px 0; width: 160px; height: 160px;"><img style="object-fit: cover; height: 160px; width: 100%;" src="' . esc_url($email_photo_1) . '" alt="" /></div><div style="clear: both;">&nbsp;</div>';
        // -----------------------------
        // -----------------------------
        // Send Email to CLIENT
        // -----------------------------
        // -----------------------------
        add_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
        // -----------------------------
        // --- Get EMAIL template
        // -----------------------------
        ob_start();
        include(get_stylesheet_directory() . '/templates/emails/email-equipeer.php');
        $email_client_body = $email_admin_body = ob_get_contents();
        ob_end_clean();
        // -----------------------------
        // --- Replace Variables in email body
        // -----------------------------
        $_email_client_body = @preg_replace("/{MODERATE_CLIENT}/", esc_html($data['user_name']), $_email_client_body);
        $_email_client_body = @preg_replace("/{MODERATE_HORSE_IMAGE}/", $email_photo_html, $_email_client_body);
        $_email_client_body = @preg_replace("/{MODERATE_HORSE_REF}/", esc_html($horse_reference), $_email_client_body);
        $_email_client_body = @preg_replace("/{MODERATE_HORSE_NAME}/", esc_html($data['horse_name']), $_email_client_body);
        $_email_client_body = @preg_replace("/{MODERATE_HORSE_AGE}/", esc_html($horse_age), $_email_client_body);
        $_email_client_body = @preg_replace("/{MODERATE_HORSE_PRICE}/", esc_html($data['horse_price_equipeer'] . ' euros'), $_email_client_body);
        $_email_client_body = @preg_replace("/{MODERATE_HORSE_DISCIPLINE}/", esc_html($horse_discipline->name), $_email_client_body);
        $email_client_body  = @preg_replace("/{EMAIL_CONTENT}/", stripslashes_deep(nl2br($_email_client_body)), $email_client_body);
        // --- Send email (Headers)
        $headers   = ["From: EQUIPEER <noreply@equipeer.com>", "Content-Type: text/html; charset=UTF-8"];
        $to_client = $data['user_email'];
        $subject   = __("You have just posted an ad on EQUIPEER.COM", EQUIPEER_ID);
        //$subject   = @preg_replace("/{MODERATE_HORSE_NAME}/", esc_html($data['horse_name']), $subject_2);
        $body      = $email_client_body;
        // -----------------------------
        $client_email_result = wp_mail( $to_client, $subject, $body, $headers );
        // -----------------------------
        // -----------------------------
        // Send Email to ADMIN
        // -----------------------------
        // -----------------------------
        $_email_admin_body  = get_option('equine_email_admin_putad_alert');
        // --- Replace Variables in email body
        $_email_admin_body = @preg_replace("/{MODERATE_CLIENT}/", esc_html($data['user_name'] . ' (' . $data['user_email'] . ' - ' . $data['user_phone'] . ') - ' . $data['user_address'] . ', ' . $data['user_city'] . ' (' . $data['user_zip'] . ') - ' . $data['user_country']), $_email_admin_body);
        $_email_admin_body = @preg_replace("/{MODERATE_HORSE_IMAGE}/", $email_photo_html, $_email_admin_body);
        $_email_admin_body = @preg_replace("/{MODERATE_HORSE_REF}/", esc_html($horse_reference), $_email_admin_body);
        $_email_admin_body = @preg_replace("/{MODERATE_HORSE_NAME}/", esc_html($data['horse_name']), $_email_admin_body);
        $_email_admin_body = @preg_replace("/{MODERATE_HORSE_AGE}/", esc_html($horse_age), $_email_admin_body);
        $_email_admin_body = @preg_replace("/{MODERATE_HORSE_PRICE}/", esc_html($data['horse_price_equipeer'] . ' euros'), $_email_admin_body);
        $_email_admin_body = @preg_replace("/{MODERATE_HORSE_DISCIPLINE}/", esc_html($horse_discipline->name), $_email_admin_body);
        $email_admin_body  = @preg_replace("/{EMAIL_CONTENT}/", stripslashes_deep(nl2br($_email_admin_body)), $email_admin_body);
        // --- Send email (Headers)
        // (string|array) (Required) Array or comma-separated list of email addresses to send message
        $emails    = (get_option('equine_email_admin_putad') != '') ? get_option('equine_email_admin_putad') : get_option('admin_email');
        $comma     = strpos($emails, ","); // Search if several emails
        $to_admins = ($comma === false) ? $emails : explode(",", $emails);
        $subject_2 = "Annonce déposée sur EQUIPEER.COM à modérer (Ref: ".esc_html($horse_reference).")";
        $body_2    = $email_admin_body;
        // -----------------------------
        $admin_email_result = wp_mail( $to_admins, $subject_2, $body_2, $headers );
        // Reset content-type to avoid conflicts -- https://core.trac.wordpress.org/ticket/23578
        remove_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
        // -----------------------------
        echo '1';
        // -----------------------------
        wp_die();
    }
    
    /**
     * Send my selection to admins
     *
     * @param 	$refs	All references from client
     *
     * @return bool
     */
	function equipeer_send_my_selection($refs = false, $uid = false, $ajax = true, $ids) {
		// -----------------------------
		// Initialization
		// -----------------------------
        // --- All refs
        //$refs = (!$refs) ? equipeer_get_my_selection() : $refs; // $all: not sold
        // --- User ID
        $uid = (!$uid) ? get_current_user_id() : $uid;
        // -----------------------------
		$user_info      = get_userdata($uid);
		$client_name    = ucfirst(strtolower($user_info->first_name)) . ' ' . strtoupper($user_info->last_name);
		$client_email   = $user_info->user_email;
		$client_phone   = (isset($user_info->equipeer_user_telephone) && $user_info->equipeer_user_telephone != '') ? $user_info->equipeer_user_telephone : '--';
		$client_address = (isset($user_info->equipeer_user_address_1)) ? $user_info->equipeer_user_address_1 . ', ' . $user_info->equipeer_user_city . ' (' . $user_info->equipeer_user_zip . ') - ' . $user_info->equipeer_user_country : '--';
        // -----------------------------
        // -----------------------------
        // Send Email to CLIENT
        // -----------------------------
        // -----------------------------
		add_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
        // -----------------------------
        // --- Get EMAIL template
        // -----------------------------
        ob_start();
        include(get_stylesheet_directory() . '/templates/emails/email-equipeer.php');
        $email_admin_body = $email_client_body = ob_get_contents();
        ob_end_clean();
        // -----------------------------
        // --- Replace Variables in email body
        // -----------------------------
        $selection_sport    = equipeer_get_my_selection_email($ids);
        $email_lang         = (ICL_LANGUAGE_CODE == 'fr') ? 'fr' : 'en';
        $_email_client_body = get_option("equine_email_client_send_selection_".$email_lang);
        $_email_client_body = @preg_replace("/{CLIENT_NAME}/", $client_name, $_email_client_body);
        $_email_client_body = @preg_replace("/{CLIENT_SELECTION}/", $selection_sport, $_email_client_body);
        $email_client_body  = @preg_replace("/{EMAIL_CONTENT}/", nl2br($_email_client_body), $email_client_body);
        // --- Send email (Headers)
        $to_client = $client_email;
        $subject   = "Votre sélection EQUIPEER SPORT (Ref: ".esc_html($refs).")";
        $body      = $email_client_body;
        // -----------------------------
        $admin_email_result = wp_mail( $to_client, $subject, $body, $headers );
        // -----------------------------
        // -----------------------------
        // Send Email to ADMIN
        // -----------------------------
        // -----------------------------
        // --- Replace Variables in email body
        // -----------------------------
        $admin_message = "Bonjour Admin,<br><br>Envoi d'une sélection par le client suivant :<br><br>Sélection : $refs<br>Client : $client_name<br>Adresse : $client_address<br>Email : $client_email<br>Téléphone : $client_phone<br><br>$selection_sport<br>Message automatique site EQUIPEER";
        $email_admin_body = @preg_replace("/{EMAIL_CONTENT}/", $admin_message, $email_admin_body);
        // --- Send email (Headers)
        // (string|array) (Required) Array or comma-separated list of email addresses to send message
        $emails    = (get_option('equine_email_admin_selection') != '') ? get_option('equine_email_admin_selection') : get_option('admin_email');
        $comma     = strpos($emails, ","); // Search if several emails
        $to_admins = ($comma === false) ? $emails : explode(",", $emails);
        $subject   = "Envoi d'une sélection par un client (Ref: ".esc_html($refs).")";
        $body      = $email_admin_body;
        // -----------------------------
        $admin_email_result = wp_mail( $to_admins, $subject, $body, $headers );
		// -----------------------------
        // Reset content-type to avoid conflicts -- https://core.trac.wordpress.org/ticket/23578
		// -----------------------------
        remove_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
        // -----------------------------
        // --- Check if Ajax Request
        if ($ajax) {
            // -----------------------------
            echo '1';
            // -----------------------------
            wp_die();
        }
	}
    
    /**
     * Admin send a message to a client
     *
     * @return bool
     */
    function equipeer_contact_remove() {
        global $wpdb;
        $debug = false;
        // -----------------------------
        // Send EMAIL (Initialize)
        // -----------------------------
        $client_email = trim($_POST['email']);
        $message      = wp_unslash(trim($_POST['body']));
        $subject      = wp_unslash(trim($_POST['subject']));
        $pid          = intval($_POST['product']);
        $email_photo  = wp_get_attachment_image_url( get_post_meta($pid, 'photo_1', true), 'thumbnail');
        // -----------------------------
        // -----------------------------
        // Send Email to CLIENT
        // -----------------------------
        // -----------------------------
        add_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
        // -----------------------------
        // --- Get EMAIL template
        // -----------------------------
        ob_start();
        include(get_stylesheet_directory() . '/templates/emails/email-equipeer.php');
        $email_client_body = ob_get_contents();
        ob_end_clean();
        // -----------------------------
        // --- Replace Variables in email body
        // -----------------------------
        $email_client_body = get_option('equine_email_client_message_admin');
        
        $email_client_body = @preg_replace("/{EMAIL_CONTENT}/", nl2br(esc_html($message)), $email_client_body);
		$email_client_body = @preg_replace("/{HORSE_IMAGE}/", "<img style='border: 1px solid #d1023e; padding: 3px;' src='".esc_url($email_photo)."' alt=''>", $email_client_body);
        // -----------------------------
        // --- Send email (Headers)
        // -----------------------------
        $headers   = ["From: EQUIPEER <noreply@equipeer.com>", "Content-Type: text/html; charset=UTF-8"];
        $to_client = $client_email;
        $body      = $email_client_body;
        // -----------------------------
        $client_email_result = wp_mail( $to_client, $subject, $body, $headers );
        // -----------------------------
        // Reset content-type to avoid conflicts -- https://core.trac.wordpress.org/ticket/23578
        // -----------------------------
        remove_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
        // -----------------------------
        // Log Activity
        // -----------------------------
        if (!$debug) equipeer_activity_log('Envoi message client', "Envoi d'un message de suppression d'annonce au client suivant : $client_email<br>Sujet : $subject<br>Message : $message");
        // -----------------------------
        // Change status
        // -----------------------------
        if (!$debug) $wpdb->query( "UPDATE {$wpdb->posts} SET post_status = 'trash' WHERE id = '$pid'" );
        // -----------------------------
        // Delete SELECTION(S)
        // -----------------------------
        $tbl_selection = Equipeer()->tbl_equipeer_selection_sport;
        if (!$debug) $wpdb->query( "DELETE FROM $tbl_selection WHERE pid = '$pid'" );
        // -----------------------------
        // Delete REMOVAL REQUEST
        // -----------------------------
        $tbl_removal_request = Equipeer()->tbl_equipeer_removal_request;
        if (!$debug) $wpdb->query( "DELETE FROM $tbl_removal_request WHERE pid = '$pid'" );
        // -----------------------------
        echo $client_email_result;
        // -----------------------------
        wp_die();
    }
    
    /**
     * Admin send a message to a client
     *
     * @return bool
     */
    function equipeer_contact() {
        // -----------------------------
        // Send EMAIL (Initialize)
        // -----------------------------
        $client_email = trim($_POST['email']);
        $message      = wp_unslash(trim($_POST['body']));
        $subject      = wp_unslash(trim($_POST['subject']));
        // -----------------------------
        // -----------------------------
        // Send Email to CLIENT
        // -----------------------------
        // -----------------------------
        add_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
        // -----------------------------
        // --- Get EMAIL template
        // -----------------------------
        ob_start();
        include(get_stylesheet_directory() . '/templates/emails/email-equipeer.php');
        $email_client_body = ob_get_contents();
        ob_end_clean();
        // -----------------------------
        // --- Replace Variables in email body
        // -----------------------------
        $_email_client_body = get_option('equine_email_client_message_admin');
        $_email_client_body = @preg_replace("/{CLIENT_MESSAGE}/", nl2br(esc_html($message)), $_email_client_body);
        $email_client_body  = @preg_replace("/{EMAIL_CONTENT}/", $_email_client_body, $email_client_body);
        // --- Send email (Headers)
        $headers   = ["From: EQUIPEER <noreply@equipeer.com>", "Content-Type: text/html; charset=UTF-8"];
        $to_client = $client_email;
        $body      = $email_client_body;
        // -----------------------------
        $client_email_result = wp_mail( $to_client, $subject, $body, $headers );
        // -----------------------------
        // Reset content-type to avoid conflicts -- https://core.trac.wordpress.org/ticket/23578
        // -----------------------------
        remove_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
        // -----------------------------
        echo $client_email_result;
        // -----------------------------
        // Log Activity
        // -----------------------------
        //equipeer_activity_log('Envoi message client', "Envoi d'un message au client suivant : $client_email<br>Sujet : $subject<br>Message : $message");
        // -----------------------------
        wp_die();
    }
	
	/**
	 * Return HTML VIDEO (youtube, vimeo, file)
	 *
	 * @return HTML
	 */
	function selected_video( $video_type = 'youtube', $video_url = false, $video_id = false ) {
		// Initialize
		$return = '';
		// POST
		$video_type = $_POST['video_type'];
		$video_url  = $_POST['video_url'];
		$video_id   = $_POST['video_id'];
		switch( strtolower($video_type) ) {
			case "youtube":
				if ( $video_url ) {
					// $video_url : https://www.youtube.com/embed/_pVCS8HbrmI
					// $video_id : _pVCS8HbrmI
					$return .= '<iframe width="225" height="169" src="' . $video_url . '" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
				} else {
					$return .= '<strong>' . __( "Can't load this video", EQUIPEER_ID ) . '</strong>';
				}
			break;
			case "vimeo":
				if ( $video_id ) {
					// $video_url: https://vimeo.com/265045525
					// $video_id : 265045525
					$return .= '<div style="padding:56.25% 0 0 0;position:relative;"><iframe src="https://player.vimeo.com/video/265045525?byline=0" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>';
				} else {
					$return .= '<strong>' . __( "Can't load this video", EQUIPEER_ID ) . '</strong>';
				}
			break;
			default:
				if ( $video_url ) {
					// $video_url: http://techslides.com/demos/sample-videos/small.mp4
					// $video_id : -
					$return .= '<video width="225" height="169" autoplay><source src="' . $video_url . '" type="video/mp4">' . __( 'Your browser does not support the video tag', EQUIPEER_ID ) . '</video> ';
				} else {
					$return .= '<strong>' . __( "Can't load this video", EQUIPEER_ID ) . '</strong>';
				}
			break;
		}
		return $return;
	}
	
	/**
	 * Used to determine what kind of url is being submitted here
	 *
	 * @param	string	$url	either a YouTube or Vimeo URL string
	 *
	 * @return array will return either "youtube","vimeo" or "file" and also the video id from the url
	 */
	function video_is($url) {	
		$yt_rx = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';
		$has_match_youtube = preg_match($yt_rx, $url, $yt_matches);

		$vm_rx = '/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([‌​0-9]{6,11})[?]?.*/';
		$has_match_vimeo = preg_match($vm_rx, $url, $vm_matches);
	
		// Then we want the video id which is:
		if ($has_match_youtube) {
			$video_id = $yt_matches[5]; 
			$type     = 'youtube';
		} elseif ($has_match_vimeo) {
			$video_id = $vm_matches[5];
			$type     = 'vimeo';
		} else {
			$video_id = 0;
			$type     = 'file';
		}

		$data['video_id']   = $video_id;
		$data['video_type'] = $type;
	
		return $data;
	}
    
    /**
     * Get counter search when updated (or not)
     *
     * @return counter
     */
    function equipeer_get_search_counter() {
        //global $wpdb;
        // ----------------------------------
        // Initialize args
        // ----------------------------------
        $_meta_query_arg   = array();
        //$_meta_query_arg[] = array( 'key' => 'sold', 'value' => '0', 'compare' => '=' );
        //$_meta_query_arg[] = array( 'key' => 'sold', 'value' => '1', 'compare' => '=' );
        // ----------------------------------
        $_args = array(
             'post_type'      => 'equine'
            ,'post_status'    => array( 'publish' )
            ,'perm'           => 'readable' // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
            ,'nopaging'       => true       // Display all posts by disabling pagination
            //,'cache_results'  => true
            //,'posts_per_page' => $_posts_per_page
            //,'paged'          => $paged
            ,'meta_query'     => array(
                $_meta_query_arg
            )
        );
        // ----------------------------------
        // --- REQUEST with ARGS
        // ----------------------------------
        $_query_ajax   = new WP_Query( $_args );
        $_count_total  = $_query_ajax->found_posts;
        $_last_query   = $_query_ajax->last_query;
        $_last_request = $_query_ajax->request;
        // ----------------------------------
        echo $_count_total;
        
        wp_die();
    }
    
    /**
     * Get counter search when updated (or not)
     *
     * @return counter
     */
    function equipeer_ajax_search() {
        //global $wpdb;
        // ----------------------------------
        // Initialize args
        // ----------------------------------
        // Check if Google Ads Option
        $google_ads_activated = get_option("equine_google_ads_active");
        $google_ads_code      = trim( get_option("equine_google_ads_code") );
        $google_ads_position  = (get_option("equine_google_ads_position") > 0) ? intval( get_option("equine_google_ads_position") ) : 5;
        // ----------------------------------
        // Initialisation
        // ----------------------------------
        $_post_type       = 'equine';
        $_post_status     = array( 'publish' ); // Statut issus de la recherche
        $_post_status_off = array( 'off' );     // Statut catalogue OFF
        // ----------------------------------
        // Price min max
        // ----------------------------------
        $_price_min = 5000;
        $_price_max = 100000;
        // ----------------------------------
        // Age min max
        // ----------------------------------
        $_age_min = 0;
        $_age_max = 20;
        // ----------------------------------
        // Distance min max
        // ----------------------------------
        $_distance_min = 50;
        $_distance_max = 1000;
        // ----------------------------------
        // Initialize args
        // ----------------------------------
        $meta_query_arg   = array();
        $meta_query_arg[] = array( 'key' => 'sold', 'value' => '0', 'compare' => '=' ); // Sauf les vendus
        // ----------------------------------
        // main_discipline
        // main_age_min / main_age_max
        // main_potential
        // main_price_min / main_price_max
        // main_localisation_latitude / main_localisation_longitude / main_localisation_distance
        // main_expertise
        // main_level
        // main_size
        // main_breed
        // main_gender
        // main_color
        // ----- RECHERCHE GLOBAL (navbar-search-content) -----
        $meta_query_arg_test = array();
        // --- Discipline
        $discipline = trim($_GET['main_discipline']);
        if (isset($discipline) && $discipline != '') {
            $arrdiscipline    = explode(",", $discipline);
            $meta_query_arg[] = array( 'key' => 'discipline', 'value' => $arrdiscipline, 'compare' => 'IN' );
        }
        // --- Age
        $age_min = intval( $_GET['main_age_min'] );
        $age_max = intval( $_GET['main_age_max'] );
        if ( ( (isset($age_min) && $age_min > $_age_min) ) || ( ( isset($age_max) && $age_max < $_age_max ) ) ) {
            if (( (isset($age_min) && $age_min != '') || $age_min == 0) && ( (isset($age_max) && $age_max != '') || $age_max == 0 ) ) {
                $date_min = (date('Y') - $age_min);
                $date_max = (date('Y') - $age_max);
                $meta_query_arg[] = array( 'key' => 'birthday', 'value' => $date_min, 'compare' => '<=', 'type' => 'NUMERIC' );
                $meta_query_arg[] = array( 'key' => 'birthday', 'value' => $date_max, 'compare' => '>=', 'type' => 'NUMERIC' );
            }
        }
        // --- Potentiel
        $potential = trim($_GET['main_potential']);
        if (isset($potential) && $potential > 0) {
            $arrpotential     = explode(",", $potential);
            $meta_query_arg[] = array( 'key' => 'potentiel', 'value' => $arrpotential, 'compare' => 'IN' );
        }
        // --- Prix					
        $price_min = intval($_GET['main_price_min']);
        $price_max = intval($_GET['main_price_max']);
        if ( ( (isset($price_min) && $price_min > $_price_min) ) || ( ( isset($price_max) && $price_max < $_price_max ) ) ) {
            if (isset($price_min) && isset($price_max)) {
                $meta_query_arg[] = array( 'key' => 'price_equipeer', 'value' => $price_min, 'compare' => '>=', 'type' => 'NUMERIC' );
                if ($price_max < $_price_max) $meta_query_arg[] = array( 'key' => 'price_equipeer', 'value' => $price_max, 'compare' => '<=', 'type' => 'NUMERIC' );
            }
        }
        // ANNONCES
        // --- Expertise
        // --- Libre	
        $to_expertise = intval($_GET['type_annonce_expert']);
        $to_free_ads  = intval($_GET['type_annonce_libre']);
        if ( (isset($to_expertise) && $to_expertise > 0) && (isset($to_free_ads) && $to_free_ads == 0) ) {
            $meta_query_arg[] = array( 'key' => 'type_annonce', 'value' => '2', 'compare' => '=', 'type' => 'NUMERIC' );
        }				
        if ( (isset($to_free_ads) && $to_free_ads > 0) && (isset($to_expertise) && $to_expertise == 0) ) {
            $meta_query_arg[] = array( 'key' => 'type_annonce', 'value' => '1', 'compare' => '=', 'type' => 'NUMERIC' );
        }
        // --- Niveau
        $level = trim($_GET['main_level']);
        if (isset($level) && $level != '') {
            $arrlevel = explode(",", $level);
            $meta_query_arg[] = array( 'key' => 'level', 'value' => $arrlevel, 'compare' => 'IN' );
        }
        // --- Taille
        $size = trim($_GET['main_size']);
        if (isset($size) && $size != '') {
            $arrsize = explode(",", $size);
            $meta_query_arg[] = array( 'key' => 'size', 'value' => $arrsize, 'compare' => 'IN' );
        }
        // --- Origine paternel
        $origin = stripslashes ( sanitize_text_field( trim($_GET['main_origin']) ) );
        $origin = htmlspecialchars( $origin, ENT_QUOTES );
        if (isset($origin) && $origin != '') {
            $meta_query_arg[] = array( 'key' => 'origin_sire', 'value' => $origin, 'compare' => 'LIKE' );
        }
        // --- Race
        $breed = trim($_GET['main_breed']);
        if (isset($breed) && $breed != '') {
            $arrbreed = explode(",", $breed);
            $meta_query_arg[] = array( 'key' => 'breed', 'value' => $arrbreed, 'compare' => 'IN' );
        }
        // --- Sexe
        $sex = trim($_GET['main_gender']);
        if (isset($sex) && $sex != '') {
            $arrsex = explode(",", $sex);
            $meta_query_arg[] = array( 'key' => 'sex', 'value' => $arrsex, 'compare' => 'IN' );
        }
        // --- Couleur
        $color = trim($_GET['main_color']);
        if (isset($color) && $color != '') {
            $arrcolor = explode(",", $color);
            $meta_query_arg[] = array( 'key' => 'dress', 'value' => $arrcolor, 'compare' => 'IN' );
        }
        // -----------------------------------------------------------
        $localisation_name = trim($_GET['autocomplete_global']);
        $latitudeFrom      = trim($_GET['main_localisation_latitude']);
        $longitudeFrom     = trim($_GET['main_localisation_longitude']);
        //$distance          = intval($_GET['main_around']);
        //$distance          = intval($_GET['main_localisation_distance']);
        $distance          = (isset($_GET['main_localisation_distance']) && intval($_GET['main_localisation_distance']) > 0) ? intval($_GET['main_localisation_distance']) : (($localisation_name != '') ? 50 : 0);
        // -----------------------------------------------------------
        $args = array(
             'post_type'      => $_post_type
            ,'post_status'    => $_post_status
            ,'perm'           => 'readable' // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
            ,'cache_results'  => true
            ,'posts_per_page' => -1
            ,'paged'          => 1
            ,'meta_query'     => array(
                $meta_query_arg
            )
        );
        // ----------------------------------
        // --- REQUEST with ARGS
        // ----------------------------------
        $query             = new WP_Query( $args );
        $query_count_total = $query->found_posts;
        // ----------------------------------
        // --- Boucle chevaux
        // ----------------------------------
		$count_horses = 0;
        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post(); // Don't remove this line (required for loop)
                if ( (isset($latitudeFrom) && $latitudeFrom != '') && (isset($longitudeFrom) && $longitudeFrom != '') ) {
                    // ----------------------------------
                    // Get information localization
                    // ----------------------------------
                    $the_id = $query->post->ID;
                    $localisation_latitude  = (get_post_meta( $the_id, 'localisation_latitude', true ) != '') ? get_post_meta( $the_id, 'localisation_latitude', true ) : false;
                    $localisation_longitude = (get_post_meta( $the_id, 'localisation_longitude', true ) != '') ? get_post_meta( $the_id, 'localisation_longitude', true ) : false;
                    // ----------------------------------
                    // Check distance between points from horse localization
                    // ----------------------------------
                    if ($localisation_latitude && $localisation_longitude) {
                        $get_distance = equipeer_get_distance_between_points($latitudeFrom, $longitudeFrom, $localisation_latitude, $localisation_longitude);
                        // Check distance
                        // @return different measures (object)
                        // $get_distance->miles
                        // $get_distance->feet
                        // $get_distance->yards
                        // $get_distance->kilometers
                        // $get_distance->meters
                        if (ceil($get_distance->kilometers) <= $distance) {
                            $count_horses++;
                            // --------------------------------------
                            // Check if search quest (8 max)
                            // --------------------------------------
                            if ($s == 'search_quest' && $count_horses == 8) {
                                break;
                            }
                        }
                    }
                } else {
                    // -------------------------------------------
                    // Pas de recherche de localisation
                    // -------------------------------------------
                    $count_horses++;
                }
            }
            wp_reset_postdata(); // On réinitialise les données
        }
        // ----------------------------------
        //echo $query_count_total . '/' . $count_horses;
        echo $count_horses;
        // ----------------------------------
        wp_die();
        // ----------------------------------
    }
	
}