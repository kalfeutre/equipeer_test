<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Cron
 *
 * @class Cron
 */
class Equipeer_Cron extends Equipeer {

    /**
     * Defined Recurrences Cron
     *
     * @var string
     */
    public static $recurrence_feed_fb          = 'daily';
    public static $recurrence_auto_validate_48 = 'hourly';
    public static $recurrence_alert_be_warned  = 'daily';
	
    /**
     * Constructor for the Equipeer_Metabox class
     *
     * Sets up all the appropriate hooks and actions
     */
	public function __construct() {
		// Titan call
		$this->equipeer_options = TitanFramework::getInstance( EQUIPEER_ID );
	}
	
	/**
	 * Create / Update XML FEED Facebook
	 *
	 * WP-CRON: equipeer_xml_feed_fb
	 *
	 * @return bool
	 */
	public function xml_feed_fb() {
		global $wpdb;
		
		/* ================================= */
		/* Launch options framework instance */
		/* ================================= */
		require_once(WP_PLUGIN_DIR . '/titan-framework/titan-framework-embedder.php');
        $equipeer_options = TitanFramework::getInstance( EQUIPEER_ID );

		/* ============== */
		/* Initialisation */
		/* ============== */
		// Facebook Business Manager (459400684473729)
		$business_id       = ( $equipeer_options->getOption('xml_feed_facebook_business_manager') ) ? $equipeer_options->getOption('xml_feed_facebook_business_manager') : "459400684473729";
		// DEFAULT equipeer_catalog_feed.xml
		$xml_feed_filename = ( $equipeer_options->getOption('xml_feed_filename') ) ? $equipeer_options->getOption('xml_feed_filename') : "equipeer_catalog_feed.xml";
		// DEFAULT 482367365547015
		$facebook_pixel_id = ( $equipeer_options->getOption('xml_feed_facebook_pixel_id') ) ? $equipeer_options->getOption('xml_feed_facebook_pixel_id') : "482367365547015";
		
		// Facebook catalog API Marketing : https://developers.facebook.com/docs/marketing-api/dynamic-product-ads/product-catalog/
		// Configuration de l'app : https://developers.facebook.com
		// Product feed debug : https://business.facebook.com/ads/product_feed/debug/
		// Product taxonomy : https://www.google.com/basepages/producttype/taxonomy-with-ids.en-US.txt
		
		// ID de l'APP : 2379453535408567
		$facebook_app_id   = ( $equipeer_options->getOption('xml_feed_facebook_app_id') ) ? $equipeer_options->getOption('xml_feed_facebook_app_id') : "2379453535408567";
		$facebook_secret   = ( $equipeer_options->getOption('xml_feed_facebook_secret') ) ? $equipeer_options->getOption('xml_feed_facebook_secret') : "9fcf61e2b009d90e2d3dbc2c1c4a0062";
		$facebook_token    = ( $equipeer_options->getOption('xml_feed_facebook_token') ) ? $equipeer_options->getOption('xml_feed_facebook_token') : "d5d82a099b241c65956b0245b1e74fc1";
		
		/* ======================== */
		/* ===== Request ARGS ===== */
		/* ======================== */
		$arg_orderby = ( $equipeer_options->getOption('xml_feed_sorted') ) ? $equipeer_options->getOption('xml_feed_sorted') : "date"; // DEFAULT date
		$args = array(
			'post_type'      => 'equine',
			'post_status'    => array( 'publish', 'off' ),
			'perm'           => 'readable', // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
			'cache_results'  => true,
			'orderby'        => 'date', // date | modified
			'order'          => 'ASC',
			'posts_per_page' => -1,
			'meta_query'     => array(
				array(
					'key'     => 'sold',
					'value'   => '0',
					'compare' => '=',
				),
			)
		);
		/* =================== */
		/* ===== Request ===== */
		/* =================== */
		$query = new WP_Query( $args );
		// Check if have posts
		if ( !$query->have_posts() ) return false;

		/* ==================================================== */
		/* ===== Create a dom document with encoding utf8 ===== */
		/* ==================================================== */
		$domtree = new DOMDocument('1.0', 'UTF-8');
	
		/* ==================================================== */
		/* ===== Create the root element of the xml tree ===== */
		/* ==================================================== */
		$xmlRoot = $domtree->createElement("rss");
		/* ================================== */
		/* ===== Attribute for RSS node ===== */
		/* ================================== */
		$rssAttribute_1 = $domtree->createAttribute('xmlns:g');
		$rssAttribute_2 = $domtree->createAttribute('version');
		/* =========================================== */
		/* ===== Value for the created attribute ===== */
		/* =========================================== */
		$rssAttribute_1->value = 'http://base.google.com/ns/1.0';
		$rssAttribute_2->value = '2.0';
		/* ========================= */
		/* ===== Append Childs ===== */
		/* ========================= */
		$xmlRoot->appendChild($rssAttribute_1);
		$xmlRoot->appendChild($rssAttribute_2);
		/* ============================================= */
		/* ===== Append it to the document created ===== */
		/* ============================================= */
		$domtree->appendChild($xmlRoot);
	
		/* ====================================================== */
		/* ===== Create the Channel element of the RSS tree ===== */
		/* ====================================================== */
		$currentChannel = $domtree->createElement("channel");
		$currentChannel = $xmlRoot->appendChild($currentChannel);

		/* ==================================== */		
		/* ===== Title, Link, Description ===== */
		/* ==================================== */
		$currentChannel->appendChild( $domtree->createElement( 'title', get_bloginfo() ) );
		$currentChannel->appendChild( $domtree->createElement( 'link', get_bloginfo( 'wpurl' ) ) );
		$currentChannel->appendChild($domtree->createElement('description', "Achat cheval de sport Expertisé – Equipeer, a sélectionné et expertisé pour vous les meilleurs chevaux dans de nombreuses disciplines. Grâce à nos experts, vous allez trouver le partenaire idéal pour vos meilleurs moments d'équitation sportive."));
		
		while ( $query->have_posts() ) {
			// ===== Initialize =====
			$query->the_post();
			// ===== Get metas =====
			$equine_value = equipeer_get_metas( $query->post->ID );
			// ===== Get infos =====
			$equine_sex        = get_term_by( 'id', absint( $equine_value["sex"][0] ), 'equipeer_gender' );
			$equine_discipline = get_term_by( 'id', absint( $equine_value["discipline"][0] ), 'equipeer_discipline' );

			$currentItem = $domtree->createElement("item");
			$currentItem = $currentChannel->appendChild($currentItem);
			/**
			 * <g:id>DR0024</g:id>
			 * <g:title>Etalon, Gris, 163cm, 12 ans, Dressage, potentiel Pro 1</g:title>
			 * <g:description>Etalon, Gris, 163cm, 12 ans, Dressage, potentiel Pro 1</g:description>
			 * <g:link>https://equipeer.com/equipeer-sport/annonce/product-140/0024/</g:link>
			 * <g:image_link>https://equipeer.com/upload/dr24.jpg</g:image_link>
			 * <g:brand>Etalon</g:brand>
			 * <g:mpn>DR0024</g:mpn>
			 * <g:condition>new</g:condition>
			 * <g:availability>in stock</g:availability>
			 * <g:price>0.0 EUR</g:price>
			 * <g:shipping>
			 * <g:country>FR</g:country>
			 * <g:service>Standard</g:service>
			 * <g:price>0.0 EUR</g:price>
			 * </g:shipping>
			 * <g:google_product_category>Sporting Goods &gt; Outdoor Recreation &gt; Equestrian</g:google_product_category>
			 * <g:custom_label_0>Très bel étalon lusitanien</g:custom_label_0>
			 */
			// Unique ID for item (String - Max size: 100)
			//$currentItem->appendChild($domtree->createElement('g:id', $row['reference_prefix'].getFormatHorseReference($row['reference'])));
			require_once EQUIPEER_INC_DIR . '/functions.php';
			$currentItem->appendChild( $domtree->createElement( 'g:id', equipeer_get_horse_prefix( $equine_value["discipline"][0] ) . equipeer_get_format_reference( $equine_value["reference"][0] ) ) );
			// If Item in stock, possible values:
			// in stock - Item ships immediately
			// out of stock - No plan to restock
			// preorder- Available in future
			// available for order - Ships in 1-2 weeks
			// discontinued - Discontinued
			$currentItem->appendChild($domtree->createElement('g:availability',"in stock"));
			// condition, possible values:
			// new | refurbished | used
			$currentItem->appendChild($domtree->createElement('g:condition','new'));
			// Short text describing product (String - Max size: 5000)
			$description_title = trim( str_replace(": ", "", equipeer_head_text_horse( $query->post->ID, false, " ", "feedfb" )) );
			$currentItem->appendChild( $domtree->createElement( 'g:description', $description_title ) );
			// Link to item image used in the ad. Provide proper image sizes.
			// For single-image, dynamic ads - The min image resolution requirement is 500px * 500px.
			// The min aspect ratio requirement is is 4:5 and the maximum aspect ratio requirement is 1:91:1.
			// If the image is outside this aspect ratio, Facebook crops it to be closest to either the minimum aspect ratio or the maximum aspect ratio depending on its original aspect ratio.
			// ---------------------------------------------
			// Aller chercher des medias depuis l'import V3,
			// Si ils existent
			// ---------------------------------------------
			$get_children = get_children( 'post_type=attachment&post_mime_type=image&post_parent=' . $query->post->ID, ARRAY_A );
			$get_images   = array_values( $get_children );
			// -----------------------------------------------------------
			// Nouvel ID après import (si sauvegarde d'une nouvelle photo)
			// -----------------------------------------------------------
			$meta_photo_1 = $equine_value["photo_1"][0];
			// -------------------------------------------------------
			// Verifier s'il y a une nouvelle photo depuis l'import V3
			// -------------------------------------------------------
			if ( isset($meta_photo_1) && ( $meta_photo_1 == '0' || $meta_photo_1 > 0 ) ) {
				$photo_1_id       = intval( $meta_photo_1 );
				$image_attributes = wp_get_attachment_image_src( $photo_1_id, "full" );
			} else {
				// Sinon, prendre celle de l'import
				$photo_1_id = $get_images[0]["ID"]; // First attached image
				if ( $photo_1_id > 0 ) {
					$image_attributes = wp_get_attachment_image_src( $photo_1_id, "full" );
				} else {
					$image_attributes[0] = EQUIPEER_URL . 'assets/images/no_image_available.jpg';
				}
			}
			// $image_attributes[0] - image URL
			// $image_attributes[1] - image width
			// $image_attributes[2] - image height
			$currentItem->appendChild( $domtree->createElement( 'g:image_link', $image_attributes[0] ) );
			// Link to merchant's site where someone can buy the item (String)
			$currentItem->appendChild( $domtree->createElement( 'g:link', get_permalink( $query->post->ID ) ) );
			// Title of item (String - Max size: 100)
			$currentItem->appendChild( $domtree->createElement( 'g:title', $description_title ) );
			// Cost of item and currency.
			// Currency should follow ISO 4217 currency codes.
			// Example: 9.99 USD
			$currentItem->appendChild( $domtree->createElement( 'g:price','0.0 EUR' ) );
			// gtin OR mpn OR brand (String)
			// gtin - Global Trade Item Number (GTIN) can include UPC, EAN, JAN, and ISBN. Max size: 70
			// mpn - Unique manufacturer ID for product.
			// brand - Name of the brand.
			$currentItem->appendChild( $domtree->createElement( 'g:brand', $equine_sex->name ) );
			$currentItem->appendChild( $domtree->createElement( 'g:mpn', equipeer_get_format_reference( $equine_value["reference"][0] ) ) );
			/* ------------------------------------------- */
			/* ------------- OPTIONAL FIELDS ------------- */
			/* ------------------------------------------- */
			// Predefined values (string or category ID) from Google's product taxonomy (String - Max size: 250)
			// https://www.google.com/basepages/producttype/taxonomy-with-ids.en-US.txt
			// Example: Apparel & Accessories &gt; Clothing &gt; Dresses or 2271
			$currentItem->appendChild( $domtree->createElement( 'g:google_product_category', 'Sporting Goods &gt; Outdoor Recreation &gt; Equestrian' ) );
			// Blob with different prices for each country and region. Different regions are comma-separated.
			// The format should be COUNTRY:STATE:SHIPPING_TYPE:PRICE.
			// Example:
			// US:CA:Ground:9.99 USD, US:NY:Air:15.99 USD
			$currentShipping = $domtree->createElement( "g:shipping" );
			$currentShipping = $currentItem->appendChild( $currentShipping );
			$currentShipping->appendChild( $domtree->createElement( 'g:country', 'FR' ) );
			$term_discipline = get_term( $query_metas->discipline );
			$currentShipping->appendChild( $domtree->createElement( 'g:service', $equine_discipline->name ) );
			$currentShipping->appendChild( $domtree->createElement( 'g:price', '0.0 EUR' ) );
			// You can add custom label (0, 1, 2, 3, 4)
			// Optional. Additional information about item (String - Max size: 100)
			$currentItem->appendChild( $domtree->createElement( 'g:custom_label_0', equipeer_truncate( $equine_value["impression"][0], 100 ) ) ); // impression
		}
		
		/* ========================== */
		/* ===== Human readable ===== */
		/* ========================== */
		$domtree->formatOutput = true;	
		/* =============================== */
		/* ===== get the xml printed ===== */
		/* =============================== */
		$domtree->save( ABSPATH . $xml_feed_filename );
		
		return true;		
	}
    
    
    /**
     * Auto validate AD after 48 hours
     *
     * WP-CRON: equipeer_ad_auto_validate_48
     *
     * @return void
     */
    public function auto_validate_ad_48() {
        global $wpdb;
        $cron_debug = false;
        // --------------------------------------
        // --- Get all pending moderate horses
        // --------------------------------------
		// --- Dates
        $today  = date('Y-m-d H:i:s');
        $_2days = date("Y-m-d H:i:s", strtotime("-2 days", strtotime($today)));
        // --- Table
        $table = $wpdb->prefix . 'posts';
        // --- Query
        $query = "SELECT ID, post_author, post_date, post_title FROM $table WHERE post_status = 'moderate' AND post_type = 'equine' AND post_date <= '$_2days'";
        // --- Result
        $result = $wpdb->get_results( $query );
		// --- Check if have posts
		if ( !$result ) return false;
        // --- Debug
        if ($cron_debug) equipeer_log_start();
        // --- Have posts
        if ( $result ) {
            $all_posts = array();
            foreach ( $result as $key => $post ) {
                // --------------------------------------
                // --------------------------------------
                // --- Check if POST STATUS exists in DRAFT
                // Wordpress cree 1 post pour moderate (post_status = moderate)
                // puis 1 post pour l'anglais (post_status = inherit)
                // --------------------------------------
                // ----------- BUG Wordpress ------------
                // --------------------------------------
                // Si le post est modifie (Modification rapide) en statut Brouillon, cela devrait modifier uniquement le statut actuel du l'ID en cours
                // Sauf que Wordpress cree 1 post supplementaire (post_status = draft) - mais pas toujours - ca semble aleatoire !!!
                // --------------------------------------
                // --- Donc, Verifier qu'il n'existe pas un draft avec le meme post_title
                // --------------------------------------
                $post_draft   = $post->post_title;
                $query_draft  = "SELECT ID, post_title, post_status FROM $table WHERE post_status = 'draft' AND post_type = 'equine' AND post_title = '$post_draft'";
                $result_draft = $wpdb->get_row( $query_draft );
                if ($result_draft) {
                    if ($cron_debug) equipeer_log("Post status DRAFT détecté ($post_draft - ID: {$result_draft->ID}) - Traitement interrompu !");
                    continue; // Si resultat, ne pas executer le traitement suivant
                }
                // --------------------------------------
                // --------------------------------------
                $all_posts[$key]['author']     = $post->post_author;
                $all_posts[$key]['post_id']    = $post->ID;
                $all_posts[$key]['post_title'] = $post->post_title;
                if ($cron_debug) equipeer_log("Date: $post->post_date ($_2days) - ID: $post->ID - title: $post->post_title");
                // Publish HORSE
                $update_db = $wpdb->update( $table,
                    array( 'post_status' => 'publish'), 
                    array( 'ID' => $post->ID ), 
                    array( '%s' ), 
                    array( '%d' ) 
                );
                if ($cron_debug) equipeer_log( ($update_db) ? 'Update db OK' : 'Update db Pas OK => KO');
            }
            // Clear datas
            wp_reset_postdata();
            // Debug
            if ($cron_debug) equipeer_log(equipeer_unique_multidim_array($all_posts, 'post_title'));
            // Loop on unique keys
            $loop_posts = equipeer_unique_multidim_array($all_posts, 'post_title');
            foreach($loop_posts as $row) {
                // --------------------------------------
                // Send email to client
                // --------------------------------------
                $subject           = __("Great, your ad is published on EQUIPEER.COM", EQUIPEER_ID);
                // --------------------------------------
                $post_id = $row['post_id'];
                // --------------------------------------
                $user              = get_userdata( $row['author'] );
                $client            = ucfirst(strtolower($user->first_name)) . ' ' . strtoupper($user->last_name);
                $url               = get_permalink($post_id);
                $price             = number_format( get_post_meta( $post_id, 'price_equipeer', true ), 0, ",", " ");
                $horse_name        = get_the_title($post_id);
				$the_prefix        = @get_term_meta( @get_post_meta( $post_id, 'discipline', true ), 'equipeer_prefix_taxonomy_parent_id', true );
				$the_reference     = equipeer_get_format_reference( @get_post_meta( $post_id, 'reference', true ) );                
                $horse_reference   = $the_prefix . '-' . $the_reference;
                $horse_age_total   = (date('Y') - get_post_meta($post_id, 'birthday', true));
                $horse_age         = ($horse_age_total < 1) ? 'Foal' : ( ($horse_age_total >= 1) ? $horse_age_total . ' ' . __('years', EQUIPEER_ID) : $horse_age_total . ' ' . __('year', EQUIPEER_ID) );
                $horse_discipline  = get_term_by( 'id', absint( get_post_meta($post_id, 'discipline', true) ), 'equipeer_discipline' );
				// Get horses Photo
				$photo_id          = @get_post_meta( $post_id, 'photo_1', true );
				$photo_url         = ($photo_id) ? wp_get_attachment_url( $photo_id ) : get_stylesheet_directory_uri() . '/assets/images/equipeer-no-photo-thumb.jpg';
                $photo             = '<div style="border: 1px solid #d1023e; float: left; margin: 0 5px 5px 0; width: 160px; height: 210px;"><a href="' . get_permalink( $selection->pid ) . '"><img style="object-fit: cover; height: 160px; width: 100%;" src="' . $photo_url . '" alt="' . $horse_reference . '" /></a><p style="text-align: center; color: #0e2d4c;">' . $horse_reference . '</p></div><div style="clear: both;">&nbsp;</div>';
                // --------------------------------------
                // Log activity
                // --------------------------------------
                equipeer_activity_log('Automatic Moderate', "Moderation automatique (CRON) : " . $row['post_title'] . " - REF: " . $horse_reference );
                // --------------------------------------
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
                $_email_client_body = get_option('equine_email_client_moderate_ok');
                $_email_client_body = @preg_replace("/{MODERATE_CLIENT}/", esc_html($client), $_email_client_body);
                $_email_client_body = @preg_replace("/{MODERATE_HORSE_REF}/", esc_html($horse_reference), $_email_client_body);
                $_email_client_body = @preg_replace("/{MODERATE_HORSE_NAME}/", esc_html($horse_name), $_email_client_body);
                $_email_client_body = @preg_replace("/{MODERATE_HORSE_AGE}/", esc_html($horse_age), $_email_client_body);
                $_email_client_body = @preg_replace("/{MODERATE_HORSE_PRICE}/", esc_html($price . ' euros'), $_email_client_body);
                $_email_client_body = @preg_replace("/{MODERATE_HORSE_DISCIPLINE}/", esc_html($horse_discipline->name), $_email_client_body);
                $_email_client_body = @preg_replace("/{MODERATE_HORSE_URL}/", '<a href="'.esc_html($url).'">'.esc_html($url).'</a>', $_email_client_body);
                $_email_client_body = @preg_replace("/{MODERATE_HORSE_IMAGE}/", $photo, $_email_client_body);
                $email_client_body  = @preg_replace("/{EMAIL_CONTENT}/", nl2br($_email_client_body), $email_client_body);
                // --- Send email (Headers)
                $headers   = ["From: EQUIPEER <noreply@equipeer.com>", "Content-Type: text/html; charset=UTF-8"];
                $to_client = $user->user_email;
                $body      = $email_client_body;
                // --------------------------------------
                $client_email_result = wp_mail( $to_client, $subject, $body, $headers );
                // Reset content-type to avoid conflicts -- https://core.trac.wordpress.org/ticket/23578
                remove_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
            }
        }
        return true;
    }


   /**
     * Check if new ads exist to notify the customer who has chosen to be notified 
     *
     * WP-CRON: equipeer_ad_search_be_warned
     *
     * @return void
     */
    public function get_new_ads_alert_be_warned() {
        global $wpdb;
        $cron_debug = true;
        // -----------------------------
        // Send EMAIL (Initialize)
        // -----------------------------
        $email_lang = (ICL_LANGUAGE_CODE == 'fr') ? 'fr' : 'en';
        // --------------------------------------
        // --- Get all pending moderate horses
        // --------------------------------------
		// --- Dates
        $today = date('Y-m-d');
        $_1day = date("Y-m-d", strtotime("-1 days", strtotime($today)));
        list($_1day_Y, $_1day_M, $_1day_D) = explode("-", $_1day);
        // --- Tables
        $table_search = Equipeer()->tbl_equipeer_user_save_search;
        $table_posts  = $wpdb->prefix . 'posts';
        // --- Debug
        if ($cron_debug) equipeer_log_start('bewarned');
        // --- Get all customers who want to be warned
        $query_bewarned = "SELECT uid AS search_uid, name AS search_name, args AS search_args FROM $table_search WHERE be_warned = '1' ORDER BY uid ASC";
        // --- Debug
        if ($cron_debug) {
            equipeer_log('Today: '.$today, 'bewarned');
            equipeer_log('Today - 1: '.$_1day, 'bewarned');
            equipeer_log('Explode (Y-M-D): '.$_1day_Y.'-'.$_1day_M.'-'.$_1day_D, 'bewarned');
            equipeer_log('SQL be warned: '.$query_bewarned, 'bewarned');
            equipeer_log('----------------------------------------------', 'bewarned');
        }
        // --- Result
        $result_bewarned = $wpdb->get_results( $query_bewarned, ARRAY_A );
        // --------------------------------------
		// --- Check if have customers to notify
        // --------------------------------------
		if ( !$result_bewarned ) return false;
        // --- Initialize
        $default_photo  = get_stylesheet_directory_uri() . '/assets/images/equipeer-no-photo-thumb.jpg';
        // -----------------------------
        // --- Initialize nb emails
        // -----------------------------
        $nb_email = 0;
        // --------------------------------------
        // --- Loop on be warned
        // --------------------------------------
        foreach($result_bewarned as $key => $bewarned) {
            // Initialize            
            $_email_content = "";
            $_horses_count  = 0;
            $_current_user  = $bewarned['search_uid'];
            /* --------------------------------------
            ** Prepare to get new horses for user search (OR NOT)
            ** -------------------------------------- discipline_28=28&main-age=+3+ans%3B+7+ans&potential_81=81&price=17000%3B30000&autocomplete_global=+27500+Pont-Audemer%2C++France&main_around=0&type_annonce_expert=1&type_annonce_libre=2&level_39=39&level_50=50&level_62=62&main_origin&breed_108=108&sex36=36&sex38=38&s=search_main&main_discipline=28&main_age_min=3&main_age_max=7&main_potential=81&main_price_min=17000&main_price_max=30000&main_localisation_latitude=49.3519377&main_localisation_longitude=0.5077573&main_localisation_distance=0&main_expertise=0&main_level=39%2C50%2C62&main_size&main_breed=108&main_gender=36%2C38&main_color
            ** -------------------------------------- */
            $_all_args = explode("&", urldecode($bewarned['search_args']));
            
            if ($cron_debug) equipeer_log('Search args ['.$key.']: '.urldecode($bewarned['search_args']), 'bewarned');
            
            foreach($_all_args as $_args) {
                list($_arg, $value) = explode("=", $_args);
                switch($_arg) {
                    case 'main_discipline': if (isset($value) && $value != '') $_GET['main_discipline'] = trim($value); break; // Discipline
                    case 'main_age_min': if (isset($value) && $value != '') $_GET['main_age_min'] = trim($value); break; // Age (Min)
                    case 'main_age_max': if (isset($value) && $value != '') $_GET['main_age_max'] = trim($value); break; // Age (Max)
                    case 'main_potential': if (isset($value) && $value != '') $_GET['main_potential'] = trim($value); break; // Potentiel
                    case 'main_price_min': if (isset($value) && $value != '') $_GET['main_price_min'] = trim($value); break; // Price (Min)
                    case 'main_price_max': if (isset($value) && $value != '') $_GET['main_price_max'] = trim($value); break; // Price (Max)
                    case 'type_annonce_expert': if (isset($value) && $value != '') $_GET['type_annonce_expert'] = trim($value); break; // ANNONCES Expertisees
                    case 'type_annonce_libre': if (isset($value) && $value != '') $_GET['type_annonce_libre'] = trim($value); break; // ANNONCES Libres
                    case 'main_level': if (isset($value) && $value != '') $_GET['main_level'] = trim($value); break; // Niveau
                    case 'main_size': if (isset($value) && $value != '') $_GET['main_size'] = trim($value); break; // --- Taille
                    case 'main_origin': if (isset($value) && $value != '') $_GET['main_origin'] = trim($value); break; // Origine paternel
                    case 'main_breed': if (isset($value) && $value != '') $_GET['main_breed'] = trim($value); break; // Race
                    case 'main_gender': if (isset($value) && $value != '') $_GET['main_gender'] = trim($value); break; // Sexe
                    case 'main_color': if (isset($value) && $value != '') $_GET['main_color'] = trim($value); break; // Couleur
                    case 'autocomplete_global': if (isset($value) && $value != '') $_GET['autocomplete_global'] = trim($value); break; // Localization
                    case 'main_localisation_latitude': if (isset($value) && $value != '') $_GET['main_localisation_latitude'] = trim($value); break; // Latitude
                    case 'main_localisation_longitude': if (isset($value) && $value != '') $_GET['main_localisation_longitude'] = trim($value); break; // Longitude
                    case 'main_localisation_distance': if (isset($value) && $value != '') $_GET['main_localisation_distance'] = trim($value); break; // Distance
                }
            }
            // -----------------------------------------
            // --- Check if have posts
            // -----------------------------------------
            // Initialize args			
            $meta_query_arg   = array();
            $meta_query_arg[] = array( 'key' => 'sold', 'value' => '0', 'compare' => '=' ); // Sauf les vendus
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
            $distance          = (isset($_GET['main_localisation_distance']) && intval($_GET['main_localisation_distance']) > 0) ? intval($_GET['main_localisation_distance']) : (($localisation_name != '') ? 50 : 0);
            // -----------------------------------------------------------
            $args = array(
                 'post_type'      => 'equine'
                ,'post_status'    => array( 'publish' )
                ,'perm'           => 'readable'
                ,'cache_results'  => true
                ,'orderby'        => 'date'
                ,'order'          => 'DESC'
                ,'posts_per_page' => -1
                ,'date_query' => array(
                    'column' => 'post_modified',
                    array(
                        'year'  => $_1day_Y,
                        'month' => $_1day_M,
                        'day'   => $_1day_D,
                    )
                )
                ,'meta_query'     => array(
                    $meta_query_arg
                )
            );
            // --- REQUEST with ARGS
            $query = new WP_Query( $args );
            $query_count_total = $query->found_posts;
            // -- Title
            $_email_content .= sprintf( __('New horses for your search <strong>%s</strong>', EQUIPEER_ID), $bewarned['search_name'] ) . ' :<br><br>';
            // User infos
            $user_info = @get_userdata( $_current_user );
            // --- Loop
            if ($query->have_posts()) {
                while ( $query->have_posts() ) {
                    // Don't remove this line (required for loop)
                    $query->the_post();
                    // PHOTO
                    $the_id         = $query->post->ID;
                    $photo_id       = @get_post_meta( $the_id, 'photo_1', true );
                    if ($photo_id) {
                        $thumbnail_src = wp_get_attachment_image_src( $photo_id );
                        $photo_url     = ($thumbnail_src) ? $thumbnail_src[0] : $default_photo;
                    } else {
                        $photo_url     = $default_photo;
                    }
                    $get_text_horse = equipeer_head_text_horse( $the_id, false );
                    // Check if localization required
                    if ( (isset($latitudeFrom) && $latitudeFrom != '') && (isset($longitudeFrom) && $longitudeFrom != '') ) {
                        // Get information localization
                        $localisation_latitude  = (get_post_meta( $the_id, 'localisation_latitude', true ) != '') ? get_post_meta( $the_id, 'localisation_latitude', true ) : false;
                        $localisation_longitude = (get_post_meta( $the_id, 'localisation_longitude', true ) != '') ? get_post_meta( $the_id, 'localisation_longitude', true ) : false;
                        // Check distance between points from horse localization
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
                                $_email_content .= '<div style="border: 1px solid #d1023e; float: left; margin: 0 5px 5px 0; width: 160px; height: 250px;"><a href="' . get_permalink( $the_id ) . '"><img style="object-fit: cover; height: 160px; width: 100%;" src="' . $photo_url . '" alt="' . $get_text_horse . '" /></a><p style="text-align: center; color: #0e2d4c; font-size: 12px;">' . $get_text_horse . '</p></div>';
                                $_horses_count++; // Increment horses counter
                                if ($cron_debug) equipeer_log( 'IMG (Distance): ' . $photo_url . ' - Horse:  ' . $get_text_horse , 'bewarned');
                            }
                        }
                    } else {
                        // -------------------------------------------
                        // Pas de recherche de localisation
                        // -------------------------------------------
                        $_email_content .= '<div style="border: 1px solid #d1023e; float: left; margin: 0 5px 5px 0; width: 160px; height: 250px;"><a href="' . get_permalink( $the_id ) . '"><img style="object-fit: cover; height: 160px; width: 100%;" src="' . $photo_url . '" alt="' . $get_text_horse . '" /></a><p style="text-align: center; color: #0e2d4c; font-size: 12px;">' . $get_text_horse . '</p></div>';
                        $_horses_count++; // Increment horses counter
                        if ($cron_debug) equipeer_log( 'IMG (General): ' . $photo_url . ' - Horse:  ' . $get_text_horse , 'bewarned');
                    }
                    
                }
                //wp_reset_query(); // On réinitialise les données
                wp_reset_postdata();
                // -----------------------------
                // Send email
                // -----------------------------
                // --- Check if send email to client (count horses)
                if ($_horses_count > 0) {
                    // -----------------------------
                    $_email_content .= '<div style="clear: both;">&nbsp;</div>';
                    // -----------------------------
                    // -----------------------------
                    // Send Email to CLIENT
                    // -----------------------------
                    // -----------------------------
                    add_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
                    // -----------------------------
                    // --- Replace Variables in email body
                    // -----------------------------
                    $_email_client_body = get_option('equine_email_client_be_warned_'.$email_lang);
                    $_email_client_body = @preg_replace("/{CLIENT_NAME}/", ucfirst(strtolower($user_info->first_name)) . ' ' . strtoupper($user_info->last_name), $_email_client_body);
                    $_email_client_body = @preg_replace("/{CLIENT_RECHERCHE}/", $_email_content, $_email_client_body);
                    // --- Send email (Headers)
                    $headers           = ["From: EQUIPEER <noreply@equipeer.com>", "Content-Type: text/html; charset=UTF-8"];
                    $to_client         = $user_info->user_email;
                    $subject           = __("New horses following your searches on EQUIPEER.COM ", EQUIPEER_ID);
                    $email_client_body = file_get_contents( get_stylesheet_directory() . '/templates/emails/email-equipeer.php' );
                    $client_body       = @preg_replace("/{EMAIL_CONTENT}/", stripslashes_deep(nl2br($_email_client_body)), $email_client_body);
                    // -----------------------------
                    $client_email_result = wp_mail( $to_client, $subject, $client_body, $headers );
                    // -----------------------------
                    // Reset content-type to avoid conflicts -- https://core.trac.wordpress.org/ticket/23578
                    remove_filter( 'wp_mail_content_type', 'equipeer_set_html_mail_content_type' );
                    if ($cron_debug) {
                        equipeer_log('--> Send email to user - Count: '.$_horses_count.' - ('.$user_info->user_email.'): '.$user_info->first_name . ' ' . $user_info->last_name, 'bewarned');
                        //equipeer_log($_email_content, 'bewarned');
                        equipeer_log('----------------------------------------------', 'bewarned');
                    }

                } else {
                    // No need to send email (count horses = 0)
                    if ($cron_debug) {
                        equipeer_log('--> No need to send email to user ('.$user_info->user_email.') - Count: ' . $_horses_count, 'bewarned');
                        equipeer_log('----------------------------------------------', 'bewarned');  
                    }

                }

            } else {
                if ($cron_debug) {
                    equipeer_log('--> No need to send email to user ('.$user_info->user_email.') - Count: ' . $_horses_count, 'bewarned');
                    equipeer_log('----------------------------------------------', 'bewarned');  
                }
            }

        }
        
        // --- END
        equipeer_log('Search cron END', 'bewarned');
    }
    

	/**
	 * Return content type (Email)
	 *
	 * @return string
	 */
	public function get_content_type( $content_type ) {
		return 'text/html';
	}
	
    public function static_value( $name = '' ) {
		if ( !$name )
			return;
		
		switch($name) {
			case "feedfb":
				return self::$recurrence_feed_fb;
			break;
            case "autovalidate":
                return self::$recurrence_auto_validate_48;
            break;
            case "bewarned":
                return self::$recurrence_alert_be_warned;
            break;
		}
		
        return;
    }
	
}