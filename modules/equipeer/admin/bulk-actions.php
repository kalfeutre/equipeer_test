<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Bulk Actions
 *
 * @class Bulk Actions
 */
class Equipeer_Admin_Bulk_Actions extends Equipeer {
	
	var $ids = array();
	
    /**
     * Constructor for the Equipeer_Admin_Bulk_Actions class
     *
     * Sets up all the appropriate hooks and actions
     */
	function __construct() {
		add_action('current_screen', array( $this, 'bulk_actions' ) );
	}
	
	function bulk_actions() {
		if ( current_user_can( 'administrator' ) || current_user_can( 'equipeer_expert' ) ) {
		  add_filter( 'bulk_actions-edit-equine',  array( $this, 'register_bulk_actions' ) );
		  add_filter( 'handle_bulk_actions-edit-equine', array( $this, 'bulk_actions_handler' ), 10, 3 );
		  add_action( 'admin_notices',  array( $this, 'bulk_actions_admin_notice' ) );
		}
	}   
	
	/**
	 * Register Bulk Actions
	 *
	 * @return array
	 */
	function register_bulk_actions($bulk_actions) {
		//$bulk_actions['delete'] = __( 'Delete', EQUIPEER_ID );
		$bulk_actions['trash']  = __( 'Trash', EQUIPEER_ID );
		$bulk_actions['print']  = __( 'Print', EQUIPEER_ID );
		return $bulk_actions;
	}
	
	/**
	 * Generate PDF
	 *
	 * @return PDF link
	 */
	function generate_pdf( $ids ) {
		// ---------------------------------------
		// --- MPDF
		// ---------------------------------------
		require_once EQUIPEER_DIR . 'lib/vendor/autoload.php';
		$mpdf = new \Mpdf\Mpdf();
		// ---------------------------------------
		// --- INITIALIZATION
		// ---------------------------------------
		// --- ICL_LANGUAGE_CODE
		$prod        = true;
		$created     = __('Created', EQUIPEER_ID) . " " . date('d-m-Y');
		$filename    = date('Ymd') . '-' . date('Hi') .'-%s.pdf';
		$type_equine = (ICL_LANGUAGE_CODE == 'fr') ? 'Cheval' : 'Poney';
		// ---------------------------------------
		defined('ADMIN_TPLS_PATH') or define('ADMIN_TPLS_PATH', EQUIPEER_DIR . 'assets/pdf/');
		defined('ADMIN_TPLS_URL') or define('ADMIN_TPLS_URL', EQUIPEER_URL . 'assets/pdf/');
		defined('ADMIN_TMP_PATH') or define('ADMIN_TMP_PATH', ABSPATH . '/uploads/pdf/');
		defined('ADMIN_TMP_URL') or define('ADMIN_TMP_URL', get_site_url() . '/uploads/pdf/');
		// ---------------------------------------
		$page_1_tpl    = ADMIN_TPLS_PATH . 'page_1.html';
		$page_2_tpl    = ADMIN_TPLS_PATH . 'page_2_client.html';
		$page_3_tpl    = ADMIN_TPLS_PATH . 'page_3_expert.html';
		$page_4_tpl    = ADMIN_TPLS_PATH . 'page_4_expert.html';
		$page_note_tpl = ADMIN_TPLS_PATH . 'page_note.html';
		// ---------------------------------------
		$default_photo = ADMIN_TMP_URL . "bg/no-photo.jpg";
		// ---------------------------------------
		// --- Initialize PDF Output
		// ---------------------------------------
		$mpdf->SetProtection(array('copy','print'));
		$mpdf->SetTitle( get_bloginfo('name') . ' - ' . get_bloginfo('description') );  // PDF Title
		$mpdf->SetAuthor( get_bloginfo('name') ); // PDF Author
		$mpdf->SetWatermarkText( get_bloginfo('name') ); // Watermark
		$mpdf->showWatermarkText = false; // Afficher un watermark
		$mpdf->watermark_font = 'DejaVuSansCondensed';
		$mpdf->watermarkTextAlpha = 0.1;
		$mpdf->SetDisplayMode('fullpage');
		// ------------------------------------------------------------------------------
		// ------------------------------------------------------------------------------
		// ----------------------------------- CLIENT -----------------------------------
		// ------------------------------------------------------------------------------
		// ------------------------------------------------------------------------------
		// --- Write HTML PDF Output
		// ---------------------------------------
		// -------------- 1ere PAGE --------------
		// --- Page de garde
		$page_1 = ""; 
		$page_1 = file_get_contents( $page_1_tpl );
		$page_1 = @preg_replace("/{PAGE_1_CREATED}/", $created, $page_1);
		$page_1 = @preg_replace("/{PAGE_1_SELECTION_TEXT}/", __('Selection of expert ads', EQUIPEER_ID), $page_1);
		// --- Write PAGE
		@$mpdf->AddPage('P', 'EVEN');
		@$mpdf->WriteHTML($page_1);
		// -------------- Page HORSE -------------
		if (!empty($ids)) {
			$_ids = explode(",", $ids);
			foreach($_ids as $id) {
				// ----------------------------------------
				// --- Initialize
				// ----------------------------------------
				$page_2 = "";
				$page_2 = file_get_contents( $page_2_tpl );
				// ----------------------------------------
				$the_prefix    = get_term_meta( @get_post_meta( $id, 'discipline', true ), 'equipeer_prefix_taxonomy_parent_id', true );
				$the_reference = @get_post_meta( $id, 'reference', true );
				$reference     = $the_prefix . '-' . equipeer_get_format_reference( $the_reference );
				$the_type      = @get_post_meta( $id, 'type_canasson', true );
				$discipline    = get_term_by( 'id', @get_post_meta( $id, 'discipline', true ), 'equipeer_discipline' )->name;
				$description1  = "";
				$description1 .= get_term_by( 'id', @get_post_meta( $id, 'breed', true ), 'equipeer_breed' )->name . ' - ';
				$description1 .= (@get_post_meta( $id, 'origin_sire', true )) ? strtolower(__("By", EQUIPEER_ID)) . " " . @get_post_meta( $id, 'origin_sire', true ) . ' - ' : "";
				$description1 .= get_term_by( 'id', @get_post_meta( $id, 'sex', true ), 'equipeer_gender' )->name . ' - ';
				$description1 .= get_term_by( 'id', @get_post_meta( $id, 'dress', true ), 'equipeer_color' )->name . ' - ';
				$description1 .= get_post_meta( $id, 'size_cm', true ) . ' cm' . ' - ';
				$description1 .= equipeer_get_age_by_year( get_post_meta( $id, 'birthday', true ) ) . ' - ';
				$description1  = rtrim($description1, ' - ');
				//$latitude      = @get_post_meta( $id, 'localisation_latitude', true );
				//$longitude     = @get_post_meta( $id, 'localisation_longitude', true );
				$localisation  = equipeer_get_localisation_detail($id, false);
				$actual_level  = get_term_by( 'id', @get_post_meta( $id, 'level', true ), 'equipeer_level' )->name;
				$potential     = get_term_by( 'id', @get_post_meta( $id, 'potentiel', true ), 'equipeer_potential' )->name;
				$impression    = @get_post_meta( $id, 'impression', true );
				$price_tva     = (@get_post_meta( $id, 'price_tva', true )) ? __('Tax included', EQUIPEER_ID) : __('without VAT', EQUIPEER_ID);
				$price         = __( 'Price', EQUIPEER_ID ) . ' ' . $price_tva . ' : ' . equipeer_get_price( @get_post_meta($id, 'price_equipeer', true), false );
				// ----------------------------------------
				// --- Photos
				// ----------------------------------------
				// --- 1
				$photo_1_id  = @get_post_meta( $id, 'photo_1', true );
				$photo_1_url = (wp_get_attachment_url( $photo_1_id )) ? wp_get_attachment_url( $photo_1_id ) : false;
				if (!$photo_1_url) $photo_1_url = $default_photo;
				// --- 2
				$photo_2_id  = @get_post_meta( $id, 'photo_2', true );
				$photo_2_url = (wp_get_attachment_url( $photo_2_id )) ? wp_get_attachment_url( $photo_2_id ) : false;
				if (!$photo_2_url) $photo_2_url = $default_photo;
				// --- 3
				$photo_3_id  = @get_post_meta( $id, 'photo_3', true );
				$photo_3_url = (wp_get_attachment_url( $photo_3_id )) ? wp_get_attachment_url( $photo_3_id ) : false;
				if (!$photo_3_url) $photo_3_url = $default_photo;
				// --- 4
				$photo_4_id  = @get_post_meta( $id, 'photo_4', true );
				$photo_4_url = (wp_get_attachment_url( $photo_4_id )) ? wp_get_attachment_url( $photo_4_id ) : false;
				if (!$photo_4_url) $photo_4_url = $default_photo;
				// ----------------------------------------
				// Debug only
				if ($photo_1_url && !$prod) $photo_1_url = str_replace("https", "http", $photo_1_url);
				if ($photo_2_url && !$prod) $photo_2_url = str_replace("https", "http", $photo_2_url);
				if ($photo_3_url && !$prod) $photo_3_url = str_replace("https", "http", $photo_3_url);
				if ($photo_4_url && !$prod) $photo_4_url = str_replace("https", "http", $photo_4_url);
				$page_2 = @preg_replace("/{HEADER_TXT}/", __("Ref.", EQUIPEER_ID) . " " . $reference . " - " . $type_equine . " - " . $discipline, $page_2);
				// ----------------------------------------
				$page_2 = @preg_replace("/{PAGE_2_IMG1}/", $photo_1_url, $page_2);
				// ----------------------------------------
				$page_2 = @preg_replace("/{PAGE_2_THB1}/", $photo_2_url, $page_2);
				$page_2 = @preg_replace("/{PAGE_2_THB2}/", $photo_3_url, $page_2);
				$page_2 = @preg_replace("/{PAGE_2_THB3}/", $photo_4_url, $page_2);
				// ----------------------------------------
				$page_2 = @preg_replace("/{DESCRIPTION1}/", $description1, $page_2);
				$page_2 = @preg_replace("/{DESCRIPTION2}/", strtoupper( __("Localisation", EQUIPEER_ID) ) . " : " . $localisation, $page_2);
				$page_2 = @preg_replace("/{DESCRIPTION_L1_TEXT}/", strtoupper( __('Actual level', EQUIPEER_ID) ), $page_2);
				$page_2 = @preg_replace("/{DESCRIPTION_L1}/", $actual_level, $page_2);
				$page_2 = @preg_replace("/{DESCRIPTION_R1_TEXT}/", strtoupper( __('Potential', EQUIPEER_ID) ), $page_2);
				$page_2 = @preg_replace("/{DESCRIPTION_R1}/", $potential, $page_2);
				$page_2 = @preg_replace("/{IMPRESSION}/", $impression, $page_2);
				$page_2 = @preg_replace("/{PRICE}/", $price, $page_2);
				// --- Write PAGE
				@$mpdf->AddPage('P', 'ODD');
				@$mpdf->WriteHTML($page_2);
			}
		}
		// -------------- PAGE NOTE --------------
		// --- Page de note
		$page_note_client = file_get_contents( $page_note_tpl );
		$page_note_client = @preg_replace("/{EQUIPEER_BG_PAGE_NOTE}/", ADMIN_TMP_URL . "bg/page-note.png", $page_note_client);
		// --- Write PAGE
		@$mpdf->AddPage('P', 'EVEN');
		@$mpdf->WriteHTML($page_note_client);
		// ---------------------------------------
		// Output a PDF file directly to the browser
		// ---------------------------------------
		//$mpdf->debug = true;
		$file_client = sprintf($filename, 'client');
		@$mpdf->Output( ADMIN_TMP_PATH . date('Y') . '/' . $file_client );
		// ------------------------------------------------------------------------------
		// ------------------------------------------------------------------------------
		// ----------------------------------- EXPERT -----------------------------------
		// ------------------------------------------------------------------------------
		// ------------------------------------------------------------------------------
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->SetProtection(array('copy','print'));
		$mpdf->SetTitle( get_bloginfo('name') . ' - ' . get_bloginfo('description') . ' - EXPERT' );  // PDF Title
		$mpdf->SetAuthor( get_bloginfo('name') ); // PDF Author
		$mpdf->SetWatermarkText( get_bloginfo('name') ); // Watermark
		$mpdf->showWatermarkText = false; // Afficher un watermark
		$mpdf->watermark_font = 'DejaVuSansCondensed';
		$mpdf->watermarkTextAlpha = 0.1;
		$mpdf->SetDisplayMode('fullpage');
		// ---------------------------------------
		// --- Write HTML PDF Output (EXPERT)
		// ---------------------------------------
		// -------------- 1ere PAGE --------------
		// --- Page de garde
		$page_1_expert = file_get_contents( $page_1_tpl );
		$page_1_expert = @preg_replace("/{PAGE_1_CREATED}/", $created, $page_1);
		$page_1_expert = @preg_replace("/{PAGE_1_SELECTION_TEXT}/", __('Selection of expert ads', EQUIPEER_ID), $page_1_expert);
		// --- Write PAGE
		@$mpdf->AddPage('P', 'EVEN');
		@$mpdf->WriteHTML($page_1_expert);
		// -------------- Page HORSE -------------
		if (!empty($ids)) {
			$_ids = explode(",", $ids);
			foreach($_ids as $id) {
				// ---------------------------------------
				// --------------- PAGE 2 ----------------
				// ---------------------------------------
				$page_2_expert = "";
				$page_2_expert = file_get_contents( $page_2_tpl );
				// ----------------------------------------
				$the_prefix    = get_term_meta( @get_post_meta( $id, 'discipline', true ), 'equipeer_prefix_taxonomy_parent_id', true );
				$the_reference = @get_post_meta( $id, 'reference', true );
				$reference     = $the_prefix . '-' . equipeer_get_format_reference( $the_reference );
				$the_type      = @get_post_meta( $id, 'type_canasson', true );
				$discipline    = get_term_by( 'id', get_post_meta( $id, 'discipline', true ), 'equipeer_discipline' )->name;
				$description1  = "";
				$description1 .= get_term_by( 'id', get_post_meta( $id, 'breed', true ), 'equipeer_breed' )->name . ' - ';
				$description1 .= (@get_post_meta( $id, 'origin_sire', true )) ? strtolower(__("By", EQUIPEER_ID)) . " " . @get_post_meta( $id, 'origin_sire', true ) . ' - ' : "";
				$description1 .= get_term_by( 'id', get_post_meta( $id, 'sex', true ), 'equipeer_gender' )->name . ' - ';
				$description1 .= get_term_by( 'id', get_post_meta( $id, 'dress', true ), 'equipeer_color' )->name . ' - ';
				$description1 .= get_post_meta( $id, 'size_cm', true ) . ' cm' . ' - ';
				$description1 .= equipeer_get_age_by_year( get_post_meta( $id, 'birthday', true ) ) . ' - ';
				$description1  = rtrim($description1, ' - ');
				//$latitude      = @get_post_meta( $id, 'localisation_latitude', true );
				//$longitude     = @get_post_meta( $id, 'localisation_longitude', true );
				$localisation  = equipeer_get_localisation_detail($id, false);
				$actual_level  = get_term_by( 'id', get_post_meta( $id, 'level', true ), 'equipeer_level' )->name;
				$potential     = get_term_by( 'id', get_post_meta( $id, 'potentiel', true ), 'equipeer_potential' )->name;
				$impression    = @get_post_meta( $id, 'impression', true );
				$price_tva     = (@get_post_meta( $id, 'price_tva', true )) ? __('Tax included', EQUIPEER_ID) : __('without VAT', EQUIPEER_ID);
				$price         = __( 'Price', EQUIPEER_ID ) . ' ' . $price_tva . ' : ' . equipeer_get_price( @get_post_meta($id, 'price_equipeer', true), false );
				$price_real    = __( 'Price', EQUIPEER_ID ) . ' ' . $price_tva . ' : ' . number_format(@get_post_meta($id, 'price_equipeer', true), 0, ',', ' ') . ' €';
				// ----------------------------------------
				// --- Photos
				// ----------------------------------------
				// --- 1
				$photo_1_id  = @get_post_meta( $id, 'photo_1', true );
				$photo_1_url = (wp_get_attachment_url( $photo_1_id )) ? wp_get_attachment_url( $photo_1_id ) : false;
				if (!$photo_1_url) $photo_1_url = $default_photo;
				// --- 2
				$photo_2_id  = @get_post_meta( $id, 'photo_2', true );
				$photo_2_url = (wp_get_attachment_url( $photo_2_id )) ? wp_get_attachment_url( $photo_2_id ) : false;
				if (!$photo_2_url) $photo_2_url = $default_photo;
				// --- 3
				$photo_3_id  = @get_post_meta( $id, 'photo_3', true );
				$photo_3_url = (wp_get_attachment_url( $photo_3_id )) ? wp_get_attachment_url( $photo_3_id ) : false;
				if (!$photo_3_url) $photo_3_url = $default_photo;
				// --- 4
				$photo_4_id  = @get_post_meta( $id, 'photo_4', true );
				$photo_4_url = (wp_get_attachment_url( $photo_4_id )) ? wp_get_attachment_url( $photo_4_id ) : false;
				if (!$photo_4_url) $photo_4_url = $default_photo;
				// ----------------------------------------
				// Debug only
				if ($photo_1_url && !$prod) $photo_1_url = str_replace("https", "http", $photo_1_url);
				if ($photo_2_url && !$prod) $photo_2_url = str_replace("https", "http", $photo_2_url);
				if ($photo_3_url && !$prod) $photo_3_url = str_replace("https", "http", $photo_3_url);
				if ($photo_4_url && !$prod) $photo_4_url = str_replace("https", "http", $photo_4_url);
				$page_2_expert = @preg_replace("/{HEADER_TXT}/", __("Ref.", EQUIPEER_ID) . " " . $reference . " - " . $type_equine . " - " . $discipline, $page_2_expert);
				// ----------------------------------------
				$page_2_expert = @preg_replace("/{PAGE_2_IMG1}/", $photo_1_url, $page_2_expert);
				// ----------------------------------------
				$page_2_expert = @preg_replace("/{PAGE_2_THB1}/", $photo_2_url, $page_2_expert);
				$page_2_expert = @preg_replace("/{PAGE_2_THB2}/", $photo_3_url, $page_2_expert);
				$page_2_expert = @preg_replace("/{PAGE_2_THB3}/", $photo_4_url, $page_2_expert);
				// ----------------------------------------
				$page_2_expert = @preg_replace("/{DESCRIPTION1}/", $description1, $page_2_expert);
				$page_2_expert = @preg_replace("/{DESCRIPTION2}/", strtoupper( __("Localisation", EQUIPEER_ID) ) . " : " . $localisation, $page_2_expert);
				$page_2_expert = @preg_replace("/{DESCRIPTION_L1_TEXT}/", strtoupper( __('Actual level', EQUIPEER_ID) ), $page_2_expert);
				$page_2_expert = @preg_replace("/{DESCRIPTION_L1}/", $actual_level, $page_2_expert);
				$page_2_expert = @preg_replace("/{DESCRIPTION_R1_TEXT}/", strtoupper( __('Potential', EQUIPEER_ID) ), $page_2_expert);
				$page_2_expert = @preg_replace("/{DESCRIPTION_R1}/", $potential, $page_2_expert);
				$page_2_expert = @preg_replace("/{IMPRESSION}/", $impression, $page_2_expert);
				$page_2_expert = @preg_replace("/{PRICE}/", $price, $page_2_expert);
				// --- Write PAGE
				@$mpdf->AddPage('P', 'ODD');
				@$mpdf->WriteHTML($page_2_expert);
				// ---------------------------------------
				// --------------- PAGE 3 ----------------
				// ---------------------------------------
				$page_3_expert     = "";
				$page_3_expert     = file_get_contents( $page_3_tpl );
				$header_expert_txt = __("Ref.", EQUIPEER_ID) . " " . $reference . " - " . $type_equine . " - " . $discipline . ' - ' . __('Detail', EQUIPEER_ID);
				// ---------------------------------------
				$content  = "";
				$content .= "NOM : " . get_the_title($id) . '<br>';
				$content .= "SIRE : ". @get_post_meta( $id, 'sire', true ) . '<br>';
				$content .= "DATE DE NAISSANCE : ". equipeer_convert_date( @get_post_meta( $id, 'birthday_real', true ), 'FR' ) . '<br>';
				$content .= "<br>PRIX NET VENDEUR : ". number_format( @get_post_meta( $id, 'price_real', true ), 0, ',', ' ') . ' €<br>';
				$content .= "PRIX EQUIPEER : ". number_format( @get_post_meta( $id, 'price_equipeer', true ), 0, ',', ' ') . ' €<br>';
				$content .= "COMMISSION : ". number_format( @get_post_meta( $id, 'price_commission', true ), 0, ',', ' ') . ' €<br>';
				$content .= "TVA : ". ( (@get_post_meta( $id, 'price_tva_taux', true )) ? @get_post_meta( $id, 'price_tva_taux', true ) . '%' . '<br>' : '--' . '<br>' );
				$content .= "<br>DATE DE LA DERNIERE VISITE VETERINAIRE : " .equipeer_convert_date( @get_post_meta( $id, 'veterinaire_date', true ), 'FR' ) . '<br>';
				$content .= "ANTECEDENTS ET BILANS : " . @get_post_meta( $id, 'misc_bilan', true ) . '<br>';
				$content .= "<br>PROPRIETAIRE<br>Email : " . @get_post_meta( $id, 'owner_email', true ) . '<br>';
				$content .= "T&eacute;l&eacute;phone : " . @get_post_meta( $id, 'phone', true ) . '<br>';
				$content .= "Adresse : " . @get_post_meta( $id, 'localisation_address', true ) . ' ' . @get_post_meta( $id, 'localisation_zip', true ) . ' ' . @get_post_meta( $id, 'localisation_city', true ) . ' ' . @get_post_meta( $id, 'localisation_country', true ) . '<br>';
				$content .= "Infos - Remarques : " . @get_post_meta( $id, 'proprietaire', true ) . '<br>';
				$content .= "<br>EXPERT REFERENT : " . @get_post_meta( $id, 'referring_expert', true ) . '<br>';
				$content .= "<br>PERE : " . @get_post_meta( $id, 'origin_sire', true ) . '<br>';
				$content .= "PERE DE PERE : " . @get_post_meta( $id, 'origin_sire_sire', true ) . '<br>';
				$content .= "MERE DE PERE : " . @get_post_meta( $id, 'origin_sire_dam', true ) . '<br>';
				$content .= "MERE : " . @get_post_meta( $id, 'origin_dam', true ) . '<br>';
				$content .= "PERE DE MERE : " . @get_post_meta( $id, 'origin_dam_sire', true ) . '<br>';
				$content .= "MERE DE MERE : " . @get_post_meta( $id, 'origin_dam_dam', true ) . '<br>';
				$content .= "<br>PROFIL CAVALIER :<br>Age : " . get_term_by( 'id', get_post_meta( $id, 'cavalier_age', true ), 'equipeer_rider_age' )->name . '<br>';
				$content .= "Genre : " . get_term_by( 'id', get_post_meta( $id, 'cavalier_genre', true ), 'equipeer_rider_gender' )->name . '<br>';
				$content .= "Niveau : " . get_term_by( 'id', get_post_meta( $id, 'cavalier_niveau', true ), 'equipeer_rider_level' )->name . '<br>';
				$content .= "Comportement : " . get_term_by( 'id', get_post_meta( $id, 'cavalier_comportement', true ), 'equipeer_rider_behavior' )->name . '<br>';
				$content .= "Profil : " . @get_post_meta( $id, 'cavalier_profil', true ) . '<br>';
				// ---------------------------------------
				$page_3_expert = @preg_replace("/{HEADER_TXT}/", $header_expert_txt, $page_3_expert);
				$page_3_expert = @preg_replace("/{PRICE}/", $price_real , $page_3_expert);
				$page_3_expert = @preg_replace("/{PAGE_3_CONTENT}/", $content, $page_3_expert);
				// ---------------------------------------
				@$mpdf->AddPage('P', 'EVEN');
				@$mpdf->WriteHTML($page_3_expert);
				// ---------------------------------------
				// --------------- PAGE 4 ----------------
				// ---------------------------------------
				$page_4_expert = "";
				$page_4_expert = file_get_contents( $page_4_tpl );
				// ---------------------------------------
				$content = "";
				// 28: CSO
				// 30: Dressage
				// 31: CCE
				// 35: Autres
				// 446: Elevage
				// 449: Hunter
				if (@get_post_meta( $id, 'discipline', true ) == 30) {
					// Discipline DRESSAGE
					// DESCRIPTIF DETAILLE
					//$content .= 'DESCRIPTIF DETAILLE<br>';
					$content .= 'Type de ferrure : ' . @get_post_meta( $id, 'descriptif_detail_1', true ) . '<br>';
					$content .= 'Type d\'embouchure : ' . @get_post_meta( $id, 'descriptif_detail_2', true ) . '<br>';
					$content .= 'Mod&egrave;le : avant­-main, dos, arri&egrave;re main : ' . @get_post_meta( $id, 'modele', true ) . '<br>';
					$content .= 'Aplombs : ant&eacute;rieurs, post&eacute;rieurs : ' . @get_post_meta( $id, 'aplomb', true ) . '<br>';
					$content .= 'Comportement : &agrave; l\'&eacute;curie, &agrave; pied, transport, longe, paddock, tonte, ext&eacute;rieur, travail : ' . @get_post_meta( $id, 'allure', true ) . '<br>';
					$content .= 'Caract&egrave;re g&eacute;n&eacute;ral : ' . @get_post_meta( $id, 'comportement', true ) . '<br>';
					// PLAT
					//$content .= '<br>PLAT<br>';
					$content .= '<br>';
					$content .= 'Aptitudes sportives : Qualit&eacute; des allures : ' . @get_post_meta( $id, 'equipeer_aptitudes_plat', true ) . '<br>';
					$content .= 'Pas - Rassembl&eacute; : ' . @get_post_meta( $id, 'plat_souplesse', true ) . '<br>';
					$content .= 'Pas - Allong&eacute; : ' . @get_post_meta( $id, 'plat_sang', true ) . '<br>';
					$content .= 'Trot - Travail : ' . @get_post_meta( $id, 'plat_disponibilite', true ) . '<br>';
					$content .= 'Trot - Allong&eacute; : ' . @get_post_meta( $id, 'plat_bouche', true ) . '<br>';
					$content .= 'Galop - Travail : ' . @get_post_meta( $id, 'plat_confort', true ) . '<br>';
					$content .= 'Galop - Allong&eacute; : ' . @get_post_meta( $id, 'plat_caractere', true ) . '<br>';
					// OBSTACLES
					//$content .= '<br>OBSTACLES<br>';
					$content .= '<br>';
					$content .= 'Aptitudes sportives : Qualit&eacute; au travail : ' . @get_post_meta( $id, 'equipeer_aptitudes_obstacle', true ) . '<br>';
					$content .= 'Souplesse : ' . @get_post_meta( $id, 'obstacle_caractere', true ) . '<br>';
					$content .= 'Sang : ' . @get_post_meta( $id, 'obstacle_disponibilite', true ) . '<br>';
					$content .= 'Bouche : ' . @get_post_meta( $id, 'obstacle_equilibre', true ) . '<br>';
					$content .= 'Confort cavalier : ' . @get_post_meta( $id, 'obstacle_style', true ) . '<br>';
					$content .= 'Stabilit&eacute; (mise en main) : ' . @get_post_meta( $id, 'obstacle_experience', true ) . '<br>';
					$content .= 'Soumission (facilit&eacute; d\'utilisation) : ' . @get_post_meta( $id, 'obstacle_stabilite', true ) . '<br>';
					$content .= 'Equilibre : ' . @get_post_meta( $id, 'obstacle_7', true ) . '<br>';
					$content .= 'Rebond et amplitude : ' . @get_post_meta( $id, 'obstacle_8', true ) . '<br>';
					// QUALITE SAUT
					//$content .= '<br>QUALITE SAUT<br>';
					$content .= '<br>';
					$content .= 'Aptitudes sportives : Mouvements acquis : ' . @get_post_meta( $id, 'equipeer_aptitudes_saut', true ) . '<br>';
					$content .= 'Arr&ecirc;t : ' . @get_post_meta( $id, 'saut_envergure', true ) . '<br>';
					$content .= 'Recul&eacute; : ' . @get_post_meta( $id, 'saut_moyen', true ) . '<br>';
					$content .= 'Epaule en dedans : ' . @get_post_meta( $id, 'saut_style', true ) . '<br>';
					$content .= 'Appuy&eacute; : ' . @get_post_meta( $id, 'saut_equilibre', true ) . '<br>';
					$content .= 'Changement de pied - Ferme &agrave; ferme : ' . @get_post_meta( $id, 'saut_intelligence', true ) . '<br>';
					$content .= 'Changement de pied - Isol&eacute; : ' . @get_post_meta( $id, 'saut_respect', true ) . '<br>';
					$content .= 'Changement de pied - Lignes : ' . @get_post_meta( $id, 'saut_7', true ) . '<br>';
					$content .= 'Galop &agrave; faux : ' . @get_post_meta( $id, 'saut_8', true ) . '<br>';
					$content .= 'Appuy&eacute;s au galop : ' . @get_post_meta( $id, 'saut_9', true ) . '<br>';
					$content .= 'Pirouettes : ' . @get_post_meta( $id, 'saut_10', true ) . '<br>';
					$content .= 'Passage : ' . @get_post_meta( $id, 'saut_11', true ) . '<br>';
					$content .= 'Piaff&eacute; : ' . @get_post_meta( $id, 'saut_12', true ) . '<br>';
					// RESULTATS EN COMPETITION
					//$content .= '<br>RESULTATS EN COMPETITION<br>';
					$content .= '<br>';
					$content .= 'Amateur 3 : ' . @get_post_meta( $id, 'competition_100', true ) . '<br>';
					$content .= 'Amateur 2 : ' . @get_post_meta( $id, 'competition_110', true ) . '<br>';
					$content .= 'Amateur 1 : ' . @get_post_meta( $id, 'competition_115', true ) . '<br>';
					$content .= 'Amateur Elite : ' . @get_post_meta( $id, 'competition_120', true ) . '<br>';
					$content .= 'Pro 3 : ' . @get_post_meta( $id, 'competition_130', true ) . '<br>';
					$content .= 'Pro 2 : ' . @get_post_meta( $id, 'competition_135', true ) . '<br>';
					$content .= 'Pro 1 : ' . @get_post_meta( $id, 'competition_140', true ) . '<br>';
					$content .= 'Pro Elite : ' . @get_post_meta( $id, 'competition_140_plus', true ) . '<br>';
					$content .= 'International : ' . @get_post_meta( $id, 'competition_9', true ) . '<br>';
				} else {
					// Autres disciplines (CSO, CCE, HUNTER, ...)
					// DESCRIPTIF DETAILLE
					//$content .= 'DESCRIPTIF DETAILLE<br>';
					$content .= 'Mod&egrave;le : avant­-main, dos, arri&egrave;re main : ' . @get_post_meta( $id, 'modele', true ) . '<br>';
					$content .= 'Aplombs : ant&eacute;rieurs, post&eacute;rieurs : ' . @get_post_meta( $id, 'aplomb', true ) . '<br>';
					$content .= 'Qualit&eacute; des allures : pas, trot, galop : ' . @get_post_meta( $id, 'allure', true ) . '<br>';
					$content .= 'Comportement : &agrave; l\'&eacute;curie, &agrave; pied, au transport, en longe, caract&egrave;re g&eacute;n&eacute;ral : ' . @get_post_meta( $id, 'comportement', true ) . '<br>';
					// PLAT
					//$content .= '<br>PLAT<br>';
					$content .= '<br>';
					$content .= 'Aptitudes sportives : Mont&eacute; sur le plat : ' . @get_post_meta( $id, 'equipeer_aptitudes_plat', true ) . '<br>';
					$content .= 'Souplesse : ' . @get_post_meta( $id, 'plat_souplesse', true ) . '<br>';
					$content .= 'Sang : ' . @get_post_meta( $id, 'plat_sang', true ) . '<br>';
					$content .= 'Disponibilit&eacute; : ' . @get_post_meta( $id, 'plat_disponibilite', true ) . '<br>';
					$content .= 'Bouche : ' . @get_post_meta( $id, 'plat_bouche', true ) . '<br>';
					$content .= 'Confort cavalier : ' . @get_post_meta( $id, 'plat_confort', true ) . '<br>';
					$content .= 'Caract&egrave;re : ' . @get_post_meta( $id, 'plat_caractere', true ) . '<br>';
					$content .= 'Stabilit&eacute; : ' . @get_post_meta( $id, 'plat_stabilite', true ) . '<br>';
					// OBSTACLES
					//$content .= '<br>OBSTACLES<br>';
					$content .= '<br>';
					$content .= 'Aptitudes sportives : Mont&eacute; &agrave; l\'obstacle : ' . @get_post_meta( $id, 'equipeer_aptitudes_obstacle', true ) . '<br>';
					$content .= 'Caract&egrave;re : ' . @get_post_meta( $id, 'obstacle_caractere', true ) . '<br>';
					$content .= 'Disponibilit&eacute; : ' . @get_post_meta( $id, 'obstacle_disponibilite', true ) . '<br>';
					$content .= 'Equilibre : ' . @get_post_meta( $id, 'obstacle_equilibre', true ) . '<br>';
					$content .= 'Style : ' . @get_post_meta( $id, 'obstacle_style', true ) . '<br>';
					$content .= 'Exp&eacute;rience : ' . @get_post_meta( $id, 'obstacle_experience', true ) . '<br>';
					$content .= 'Stabilit&eacute; : ' . @get_post_meta( $id, 'obstacle_stabilite', true ) . '<br>';
					// QUALITE SAUT
					//$content .= '<br>QUALITE SAUT<br>';
					$content .= '<br>';
					$content .= 'Aptitudes sportives : Qualit&eacute; de saut : ' . @get_post_meta( $id, 'equipeer_aptitudes_saut', true ) . '<br>';
					$content .= 'Envergure : ' . @get_post_meta( $id, 'saut_envergure', true ) . '<br>';
					$content .= 'Moyens : ' . @get_post_meta( $id, 'saut_moyen', true ) . '<br>';
					$content .= 'Style : ' . @get_post_meta( $id, 'saut_style', true ) . '<br>';
					$content .= 'Equilibre : ' . @get_post_meta( $id, 'saut_equilibre', true ) . '<br>';
					$content .= 'Intelligence : ' . @get_post_meta( $id, 'saut_intelligence', true ) . '<br>';
					$content .= 'Respect : ' . @get_post_meta( $id, 'saut_respect', true ) . '<br>';
					// RESULTATS EN COMPETITION
					//$content .= '<br>RESULTATS EN COMPETITION<br>';
					$content .= '<br>';
					$content .= 'Class&eacute; 100 : ' . @get_post_meta( $id, 'competition_100', true ) . '<br>';
					$content .= 'Class&eacute; 110 : ' . @get_post_meta( $id, 'competition_110', true ) . '<br>';
					$content .= 'Class&eacute; 115 : ' . @get_post_meta( $id, 'competition_115', true ) . '<br>';
					$content .= 'Class&eacute; 120 : ' . @get_post_meta( $id, 'competition_120', true ) . '<br>';
					$content .= 'Class&eacute; 130 : ' . @get_post_meta( $id, 'competition_130', true ) . '<br>';
					$content .= 'Class&eacute; 135 : ' . @get_post_meta( $id, 'competition_135', true ) . '<br>';
					$content .= 'Class&eacute; 140 : ' . @get_post_meta( $id, 'competition_140', true ) . '<br>';
					$content .= 'Class&eacute; 140 et + : ' . @get_post_meta( $id, 'competition_140_plus', true );
				}
				// ---------------------------------------
				$page_4_expert = @preg_replace("/{HEADER_TXT}/", $header_expert_txt, $page_4_expert);
				$page_4_expert = @preg_replace("/{PRICE}/", $price_real , $page_4_expert);
				$page_4_expert = @preg_replace("/{PAGE_4_CONTENT}/", $content, $page_4_expert);
				// ---------------------------------------
				@$mpdf->AddPage('P', 'EVEN');
				@$mpdf->WriteHTML($page_4_expert);
				// ---------------------------------------
			}
		}
		// -------------- PAGE NOTE --------------
		// --- Page de note
		$page_note_expert = file_get_contents( $page_note_tpl );
		$page_note_expert = @preg_replace("/{EQUIPEER_BG_PAGE_NOTE}/", ADMIN_TMP_URL . "bg/page-note.png", $page_note_expert);
		// --- Write PAGE
		@$mpdf->AddPage('P', 'EVEN');
		@$mpdf->WriteHTML($page_note_expert);
		// ---------------------------------------
		// Output a PDF file directly to the browser
		// ---------------------------------------
		//$mpdf->debug = true;
		$file_expert = sprintf($filename, 'expert');
		@$mpdf->Output( ADMIN_TMP_PATH . date('Y') . '/' . $file_expert );
		// ---------------------------------------
		// ---------------------------------------
		// ---------------------------------------
		$client_url_file = ADMIN_TMP_URL . date('Y') . '/' .$file_client;
		$expert_url_file = ADMIN_TMP_URL . date('Y') . '/' .$file_expert;
		// ---------------------------------------
		return (object) [
			 'client_name' => $file_client
			,'client_url'  => $client_url_file
			,'client_size' => equipeer_get_media_size( ADMIN_TMP_PATH . date('Y') . '/' .$file_client )
			,'expert_name' => $file_expert
			,'expert_url'  => $expert_url_file
			,'expert_size' => equipeer_get_media_size( ADMIN_TMP_PATH . date('Y') . '/' .$file_expert )
		];
	}
	
	/**
	 * Handle Bulk Actions
	 *
	 * @return void
	 */
	function bulk_actions_handler( $redirect_to, $doaction, $post_ids ) {
		global $wpdb;
		// Do ACTIONS
		switch($doaction) {
			case "print":
				$ids = isset($post_ids) ? $post_ids : array();
				if (is_array($ids)) {
					$ids = implode(',', $ids);
				}
	
				if (!empty($ids)) {
					$wpdb->query( "SELECT * FROM {$wpdb->posts} WHERE id IN($ids)" );
				}
	
				
				$generate = $this->generate_pdf( $ids );
				equipeer_activity_log('PDF', "Génération / Téléchargement fichier <a target='_blank' href='".$generate->client_url."'>PDF client</a><br>Génération / Téléchargement fichier <a target='_blank' href='".$generate->expert_url."'>PDF expert</a>");
	
				$redirect_to = add_query_arg( 'bulk_printed_equines', count( $post_ids ), $redirect_to . '&client_file=' . $generate->client_url . '&client_size=' . $generate->client_size . '&expert_file=' . $generate->expert_url . '&expert_size=' . $generate->expert_size );
			break;
			case "delete":
				$ids = isset($post_ids) ? $post_ids : array();
				if (is_array($ids)) $ids = implode(',', $ids);
	
				if (!empty($ids)) {
					// Delete ANNONCE(S)
					$wpdb->query( "DELETE FROM {$wpdb->posts} WHERE id IN($ids)" );
					// Delete SELECTION(S)
					$tbl_selection = Equipeer()->tbl_equipeer_selection_sport;
					$wpdb->query( "DELETE FROM $tbl_selection WHERE pid IN($ids)" );
					// Delete REMOVAL REQUEST
					$tbl_removal_request = Equipeer()->tbl_equipeer_removal_request;
					$wpdb->query( "DELETE FROM $tbl_removal_request WHERE pid IN($ids)" );
				}
	
				$redirect_to = add_query_arg( 'bulk_delete_equines', count( $post_ids ), $redirect_to );
			break;
			case "trash":
				$ids = isset($post_ids) ? $post_ids : array();
				if (is_array($ids)) $ids = implode(',', $ids);
	
				if (!empty($ids)) {
					// Change status
					$wpdb->query( "UPDATE {$wpdb->posts} SET post_status = 'draft' WHERE id IN($ids)" );
					// Delete SELECTION(S)
					$tbl_selection = Equipeer()->tbl_equipeer_selection_sport;
					$wpdb->query( "DELETE FROM $tbl_selection WHERE pid IN($ids)" );
					// Delete REMOVAL REQUEST
					$tbl_removal_request = Equipeer()->tbl_equipeer_removal_request;
					$wpdb->query( "DELETE FROM $tbl_removal_request WHERE pid IN($ids)" );
				}
	
				$redirect_to = add_query_arg( 'bulk_trash_equines', count( $post_ids ), $redirect_to );
			break;
			default:
				return $redirect_to;
			break;
		}
		
		return $redirect_to;		
	}
	
	/**
	 * Notices Bulk Actions
	 *
	 * @return string
	 */
	function bulk_actions_admin_notice() {
		//global $post_type, $pagenow;
	
		// Print ACTION
		if ( ! empty( $_REQUEST['bulk_printed_equines'] ) ) {
			$printed_count    = intval( $_REQUEST['bulk_printed_equines'] );
			$client_file_url  = trim($_GET['client_file']);
			$client_file_path = trim($_GET['client_file_path']);
			$client_file_size = trim($_GET['client_size']);
			$expert_file_url  = trim($_GET['expert_file']);
			$expert_file_path = trim($_GET['expert_file_path']);
			$expert_file_size = trim($_GET['expert_size']);
			$path_file_pdfs   = ABSPATH . '/uploads/pdf/' . date('Y');
			$message          = sprintf( _n( '%s annonce g&eacute;n&eacute;r&eacute;e', '%s annonces g&eacute;n&eacute;r&eacute;es', $printed_count ), $printed_count ) . '<br><a target="_blank" href="'.$client_file_url.'">T&eacute;l&eacute;chargez le fichier CLIENT - '.$client_file_size.'</a><br><a target="_blank" href="'.$expert_file_url.'">T&eacute;l&eacute;chargez le fichier EXPERT - '.$expert_file_size.'</a><br><a href="#" onclick="return equipeer_print(\'modal_pdf\')">Envoyer par email</a><br><a href="#" onclick="return equipeer_pdf_account_client(\'modal_account\')">Ajouter ce document dans un compte client</a>';
			echo "<div id='message-equine' class='updated notice is-dismissible'><p>{$message}</p></div>";
			// Get all experts
			$query_experts_ids = [
				'blog_id'      => $GLOBALS['blog_id'],
				'role'         => '',
				'role__in'     => array('equipeer_expert','administrator'),
				'role__not_in' => array(),
				'meta_key'     => '',
				'meta_value'   => '',
				'meta_compare' => '',
				'meta_query'   => array(),
				'date_query'   => array(),        
				'include'      => array(),
				'exclude'      => array(),
				'orderby'      => 'nicename', // ID | login | nicename | email | url | registered | display_name | post_count | include | meta_value
				'order'        => 'ASC',      // ASC | DESC
				'offset'       => '',
				'search'       => '',
				'number'       => '',
				'count_total'  => false,
				'fields'       => 'all',
				'who'          => '',
			];
			$experts         = get_users( $query_experts_ids );
			$select_experts  = "";
			$select_experts .= '<select name="expert_email" id="expert_email" class="equipeer-form-control">
									<option value="">&horbar; Envoyer à l\'expert &horbar;</option>';
			foreach( $experts as $expert ) {
				$select_experts .= '<option value="'.$expert->user_email.'">';
				$select_experts .= $expert->user_nicename;
				$select_experts .= '</option>';
			}
			$select_experts .= '</select>';
			
			$query_clients_ids = array(
				'blog_id'      => $GLOBALS['blog_id'],
				//'role'         => 'equipeer_client',
				'role'         => array(),
				'role__in'     => array(),
				'role__not_in' => array(),
				'meta_key'     => '',
				'meta_value'   => '',
				'meta_compare' => '',
				'meta_query'   => array(),
				'date_query'   => array(),        
				'include'      => array(),
				'exclude'      => array(),
				'orderby'      => 'nicename', // ID | login | nicename | email | url | registered | display_name | post_count | include | meta_value
				'order'        => 'ASC',      // ASC | DESC
				'offset'       => '',
				'search'       => '',
				'number'       => '',
				'count_total'  => false,
				'fields'       => 'all',
				'who'          => '',
			 ); 
			$clients         = get_users( $query_clients_ids );
			$select_clients  = "";
			$select_clients .= '<select name="contact_client" id="contact_client" class="equipeer-select-2">
									<option value="" selected="selected">&horbar; Envoyer à un client &horbar;</option>';
			foreach( $clients as $client ) {
				$select_clients .= '<option value="'.$client->user_email.'">';
				$select_clients .= $client->user_nicename . ' - ' . $client->user_email;
				$select_clients .= '</option>';
			}
			$select_clients .= '</select>';
			
			$select_clients_id  = "";
			$select_clients_id .= '<select name="pdf_account_client_id" id="pdf_account_client_id" class="equipeer-select-2">
									<option value="" selected="selected">&horbar; Choisissez un client &horbar;</option>';
			foreach( $clients as $client ) {
				$select_clients_id .= '<option value="'.$client->ID.'">';
				$select_clients_id .= $client->user_nicename . ' - ' . $client->user_email;
				$select_clients_id .= '</option>';
			}
			$select_clients_id .= '</select>';
			
			echo '<div id="modal_pdf" class="equipeer-modal" style="display: none;">
					<div class="equipeer-modal-content">
						<span id="modal_pdf_close" class="equipeer-modal-close">×</span>
						<div id="modal_pdf_1">
							<div id="moderate-reject-div" class="equipeer-nonee">
								<div style="text-align: center;">
									<h3>Envoi par email du document (Client / Expert / Admins)</h3>
								</div>
								<hr>
								<label class="equipeer-label" for="expert_email">Email de l\'expert <span style="color: red;">*</span></label><br>
								' . $select_experts . '<br>
								<label class="equipeer-label" for="contact_client">Email du client <span style="color: red;">*</span></label><br>
								' . $select_clients . '<br><br>
								<label class="equipeer-label" for="contact_subject">Sujet de l\'email <span style="color: red;">*</span></label><br>
								<input class="equipeer-form-control" type="text" id="contact_subject_pdf_1" value="Une sélection de chevaux equipeer.com" placeholder=""><br>
								<label class="equipeer-label" for="contact_body_pdf_1">Message de l\'email <span style="color: red;">*</span></label><br>
								<textarea rows="7" class="equipeer-form-control" id="contact_body_pdf_1" name="contact_body_pdf_1"></textarea>
								<span class="equipeer-description" style="font-style: italic;">Indiquer uniquement le corps du message - le réglage du body s\'effectue dans les options du plugin, onglet Emails, Rubrique GENERATION DE PDFs</span><br>
								<br>
								<span style="color: red;">*</span> requis
								<br>
								<input type="hidden" name="contact_link_client" id="contact_link_client" value="'.$client_file_url.'">
								<input type="hidden" name="contact_link_expert" id="contact_link_expert" value="'.$expert_file_url.'">
								<input type="hidden" name="contact_path_client" id="contact_path_client" value="'.$path_file_pdfs.basename($client_file_url).'">
								<input type="hidden" name="contact_path_expert" id="contact_path_expert" value="'.$path_file_pdfs.basename($expert_file_url).'">
								<div style="text-align: center;">
									<button class="equipeer-accept" id="contact_send" data-id="2555" onclick="return equipeer_contact_pdf_confirm();">ENVOYER LE MESSAGE</button>
								</div>
							</div>
						</div>
						<div id="modal_loading_pdf_1" style="width: 100%; text-align: center; padding: 0 0 3em;" class="equipeer-none">
							<h1 style="padding: 0.5em 0 1em;">ENVOI EN COURS... </h1>
							<img src="'.EQUIPEER_URL.'assets/images/loading.gif" style="border: 0px solid #eee; padding: 0;" alt="">
						</div>
					</div>
				</div>';
			echo '<div id="modal_account" class="equipeer-modal" style="display: none;">
					<div class="equipeer-modal-content">
						<span id="modal_account_close" class="equipeer-modal-close">×</span>
						<div id="modal_account_1">
							<div id="moderate-reject-div" class="equipeer-nonee">
								<div style="text-align: center;">
									<h3>Ajouter ce document dans un compte client</h3>
								</div>
								<hr>
								<label class="equipeer-label" for="pdf_account_client_id">Client <span style="color: red;">*</span></label><br>
								' . $select_clients_id . '<br><br>
								<input type="hidden" name="pdf_account_link" id="pdf_account_link" value="'.$client_file_url.'">
								<input type="hidden" name="pdf_account_size" id="pdf_account_size" value="'.$client_file_size.'">
								<br>
								<div style="text-align: center;">
									<button class="equipeer-accept" id="contact_send" data-id="2555" onclick="return equipeer_contact_pdf_account();">AJOUTER</button>
								</div>
							</div>
						</div>
						<div id="modal_loading_account_pdf" style="width: 100%; text-align: center; padding: 0 0 3em;" class="equipeer-none">
							<h1 style="padding: 0.5em 0 1em;">AJOUT EN COURS... </h1>
							<img src="'.EQUIPEER_URL.'assets/images/loading.gif" style="border: 0px solid #eee; padding: 0;" alt="">
						</div>
					</div>
				</div>';
		}
	
		// Trash ACTION
		if ( ! empty( $_REQUEST['bulk_trash_equines'] ) ) {
			$delete_count = intval( $_REQUEST['bulk_trash_equines'] );
			$message      = sprintf( _n( '%s annonce mise à la corbeille.', '%s annonces mises &agrave; la corbeille.', $_REQUEST['bulk_trash_equines'] ), $delete_count );
			echo "<div id='message-equine' class='updated notice is-dismissible'><p>{$message}</p></div>";
		}

		// Delete ACTION
		if ( ! empty( $_REQUEST['bulk_delete_equines'] ) ) {
			$delete_count = intval( $_REQUEST['bulk_delete_equines'] );
			$message      = sprintf( _n( 'Horse deleted.', '%s horses deleted.', $_REQUEST['bulk_delete_equines'] ), $delete_count );
			echo "<div id='message-equine' class='updated notice is-dismissible'><p>{$message}</p></div>";
		}
	}
	
}