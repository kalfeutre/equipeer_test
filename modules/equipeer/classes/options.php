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
class Equipeer_Options extends Equipeer {

    /**
     *  Equipeer front options __construct
     *  Initial loaded when class create an instance
     *
     *  @since 1.0.1
     */
    function __construct() {
		// Admin menu
		add_action('admin_menu', array( $this, 'options_create_menu' ) );
	}
	
    /**
     * Options menu
     *
     * @return void
     */
	function options_create_menu() {
		// Create submenu in OPTIONS (Réglages)
		//add_options_page('Annonces Options', 'Annonces Options', 'manage_options', __FILE__, array( $this, 'settings_page' ) );
		// Create submenu in ANNONCES
        add_submenu_page( 
            'edit.php?post_type=equine',
			__( 'Options', EQUIPEER_ID ),
			__( 'Options', EQUIPEER_ID ),
			'equipeer_manage_categories',
			'equine-options',
			array( &$this, 'settings_page' )
        );
		// Call register settings function
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}
	
	/**
	 * Register options
	 *
	 * @return void
	 */
	function register_settings() {
		// --- DB Infos
		register_setting( 'equine-db-group', 'equine_range_start' );
		register_setting( 'equine-db-group', 'equine_range_1_until' );
		register_setting( 'equine-db-group', 'equine_range_2_until' );
		register_setting( 'equine-db-group', 'equine_range_3_until' );
		register_setting( 'equine-db-group', 'equine_range_4_until' );
		// -----------------------------------------------------------
		register_setting( 'equine-db-group', 'equine_commission_annonce_libre' );
		register_setting( 'equine-db-group', 'equine_commission_annonce_expertise' );
		// -----------------------------------------------------------
		register_setting( 'equine-db-group', 'equine_google_place_api_key' );
		register_setting( 'equine-db-group', 'equine_google_translate_api_key' );
        register_setting( 'equine-db-group', 'equine_send_in_blue_api_key' );
        register_setting( 'equine-db-group', 'equine_send_in_blue_list_id' );
		// -----------------------------------------------------------
		register_setting( 'equine-db-group', 'equine_email_admin_search' );
        register_setting( 'equine-db-group', 'equine_email_admin_save_search' );
		register_setting( 'equine-db-group', 'equine_email_admin_putad' );
        register_setting( 'equine-db-group', 'equine_email_admin_putad_alert' );
        register_setting( 'equine-db-group', 'equine_email_admin_selection' );
        register_setting( 'equine-db-group', 'equine_email_admin_messaging' );
        register_setting( 'equine-db-group', 'equine_email_admin_removal_request' );
        register_setting( 'equine-db-group', 'equine_email_client_message_admin' );
        register_setting( 'equine-db-group', 'equine_email_client_putad_alert_fr' );
        register_setting( 'equine-db-group', 'equine_email_client_putad_alert_en' );
        register_setting( 'equine-db-group', 'equine_email_client_moderate_ok_fr' );
        register_setting( 'equine-db-group', 'equine_email_client_moderate_ok_en' );
        register_setting( 'equine-db-group', 'equine_email_client_moderate_ko_fr' );
        register_setting( 'equine-db-group', 'equine_email_client_moderate_ko_en' );
		// -----------------------------------------------------------
        register_setting( 'equine-db-group', 'equine_smartwizard_step1_title_fr' );
		register_setting( 'equine-db-group', 'equine_smartwizard_step1_text_fr' );
        register_setting( 'equine-db-group', 'equine_smartwizard_step1_title_en' );
		register_setting( 'equine-db-group', 'equine_smartwizard_step1_text_en' );
		// -----------------------------------------------------------
        register_setting( 'equine-db-group', 'equine_smartwizard_step2_title_fr' );
		register_setting( 'equine-db-group', 'equine_smartwizard_step2_text_fr' );
        register_setting( 'equine-db-group', 'equine_smartwizard_step2_title_en' );
		register_setting( 'equine-db-group', 'equine_smartwizard_step2_text_en' );
		register_setting( 'equine-db-group', 'equine_smartwizard_step2_text2_fr' );
		register_setting( 'equine-db-group', 'equine_smartwizard_step2_text2_en' );
		register_setting( 'equine-db-group', 'equine_smartwizard_step2_text3_fr' );
		register_setting( 'equine-db-group', 'equine_smartwizard_step2_text3_en' );
		// -----------------------------------------------------------
        register_setting( 'equine-db-group', 'equine_smartwizard_step3_title_fr' );
		register_setting( 'equine-db-group', 'equine_smartwizard_step3_text_fr' );
        register_setting( 'equine-db-group', 'equine_smartwizard_step3_title_en' );
		register_setting( 'equine-db-group', 'equine_smartwizard_step3_text_en' );
        register_setting( 'equine-db-group', 'equine_smartwizard_step3_text2_fr' );
		register_setting( 'equine-db-group', 'equine_smartwizard_step3_text3_fr' );
		register_setting( 'equine-db-group', 'equine_smartwizard_step3_text4_fr' );
        register_setting( 'equine-db-group', 'equine_smartwizard_step3_text2_en' );
		register_setting( 'equine-db-group', 'equine_smartwizard_step3_text3_en' );
		register_setting( 'equine-db-group', 'equine_smartwizard_step3_text4_en' );
		// -----------------------------------------------------------
        register_setting( 'equine-db-group', 'equine_smartwizard_step4_title_fr' );
		register_setting( 'equine-db-group', 'equine_smartwizard_step4_text_fr' );
        register_setting( 'equine-db-group', 'equine_smartwizard_step4_title_en' );
		register_setting( 'equine-db-group', 'equine_smartwizard_step4_text_en' );
		//register_setting( 'equine-db-group', 'equine_smartwizard_step4_text2_fr' );
		//register_setting( 'equine-db-group', 'equine_smartwizard_step4_text2_en' );
        // -----------------------------------------------------------
        register_setting( 'equine-db-group', 'equine_profil_redirect_if_datas_required' );
        register_setting( 'equine-db-group', 'equine_profil_my_selection_text_fr' );
        register_setting( 'equine-db-group', 'equine_profil_my_selection_text_en' );
        register_setting( 'equine-db-group', 'equine_profil_my_message_text_fr' );
        register_setting( 'equine-db-group', 'equine_profil_my_message_text_en' );
		// -----------------------------------------------------------
        register_setting( 'equine-db-group', 'equine_user_not_logged_in_active' );
        register_setting( 'equine-db-group', 'equine_user_not_logged_in_delay' );
        register_setting( 'equine-db-group', 'equine_user_not_logged_in_repeat' );
        register_setting( 'equine-db-group', 'equine_user_not_logged_in_title_fr' );
        register_setting( 'equine-db-group', 'equine_user_not_logged_in_title_en' );
        register_setting( 'equine-db-group', 'equine_user_not_logged_in_text_fr' );
        register_setting( 'equine-db-group', 'equine_user_not_logged_in_text_en' );
        // -----------------------------------------------------------
        register_setting( 'equine-db-group', 'equine_google_ads_active' );
        register_setting( 'equine-db-group', 'equine_google_ads_code' );
        register_setting( 'equine-db-group', 'equine_google_ads_position' );
        // -----------------------------------------------------------
        register_setting( 'equine-db-group', 'equine_email_client_message_messaging_fr' );
        register_setting( 'equine-db-group', 'equine_email_client_message_messaging_en' );
        // -----------------------------------------------------------
        register_setting( 'equine-db-group', 'equine_email_admin_send_message_suite' );
        register_setting( 'equine-db-group', 'equine_email_client_remove_ad_fr' );
        register_setting( 'equine-db-group', 'equine_email_client_remove_ad_en' );
        // -----------------------------------------------------------
        register_setting( 'equine-db-group', 'equine_email_admin_pdf' );
        register_setting( 'equine-db-group', 'equine_email_client_message_pdf_fr' );
        register_setting( 'equine-db-group', 'equine_email_client_message_pdf_en' );
        // -----------------------------------------------------------
        register_setting( 'equine-db-group', 'equine_email_client_send_selection_fr' );
        register_setting( 'equine-db-group', 'equine_email_client_send_selection_en' );
        register_setting( 'equine-db-group', 'equine_email_admin_send_selection' );
        // -----------------------------------------------------------
        register_setting( 'equine-db-group', 'equine_email_client_be_warned_fr' );
        register_setting( 'equine-db-group', 'equine_email_client_be_warned_en' );
        // -----------------------------------------------------------
        register_setting( 'equine-db-group', 'equine_bloginfo_slogan_en' );
	}
	
	/**
	 * Display Form Options (with Tabs)
	 *
	 * @return string HTML
	 */
	function settings_page() {
		$informatux_url     = '<a href="https://informatux.com/" target="_blank">INFORMATUX</a>';
		$informatux_support = '<a href="https://dev.informatux.com/support" target="_blank">DEV INFORMATUX</a>';
		$informatux_contact = '<a href="https://informatux.com/contact" target="_blank">Contactez INFORMATUX</a>';
		?>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script>
			jQuery( function($) {
				$( "#equine-tabs" ).tabs();
			} );
		</script>
		<div class="wrap">
			
			<h2>Options ANNONCES</h2>
		
			<form method="post" action="options.php">

				<?php settings_fields( 'equine-db-group' ); ?>
				<?php do_settings_sections( 'equine-db-group' ); ?>
				
				<div id="equine-tabs" style="margin-top: 1.5em;">
					
					 <ul>
						<li><a href="#tabs-price">Tranche de prix</a></li>
						<li><a href="#tabs-commissions">Commissions</a></li>
						<li><a href="#tabs-general">Général</a></li>
						<li><a href="#tabs-putad">Dépôt annonce</a></li>
						<li><a href="#tabs-rappels">Rappels</a></li>
						<li><a href="#tabs-emails">Emails</a></li>
						<li><a href="#tabs-profil">Profil</a></li>
						<li><a href="#tabs-googleads">Google Ads</a></li>
						<li><a href="#tabs-apis">Clés APIs</a></li>
						<li><a href="#tabs-credits">Crédits</a></li>
					</ul>
					 
					<div id="tabs-price">
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- ------------------------------ TRANCHE DE PRIX ---------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<table class="form-table">
							
							<tr valign="middle">
								<th scope="row">Prix de départ (€)</th>
								<td>
									<input style="width: 80px" class="regular-text" type="text" name="equine_range_start" value="<?php echo esc_attr( get_option('equine_range_start') ); ?>" />€
								</td>
							</tr>
					
							<tr valign="middle">
								<th scope="row">Tranche 1</th>
								<td>
									De <?php echo number_format( esc_attr( get_option('equine_range_start') ), 0, ",", "." ); ?>€ à
									<input style="width: 80px" class="regular-text" type="text" name="equine_range_1_until" value="<?php echo esc_attr( get_option('equine_range_1_until') ); ?>" />€
								</td>
							</tr>
					
							<tr valign="middle">
								<th scope="row">Tranche 2</th>
								<td>
									De <?php echo number_format( esc_attr( get_option('equine_range_1_until') ), 0, ",", "." ); ?>€ à
									<input style="width: 80px" class="regular-text" type="text" name="equine_range_2_until" value="<?php echo esc_attr( get_option('equine_range_2_until') ); ?>" />€
								</td>
							</tr>
					
							<tr valign="middle">
								<th scope="row">Tranche 3</th>
								<td>
									De <?php echo number_format( esc_attr( get_option('equine_range_2_until') ), 0, ",", "." ); ?>€ à
									<input style="width: 80px" class="regular-text" type="text" name="equine_range_3_until" value="<?php echo esc_attr( get_option('equine_range_3_until') ); ?>" />€
								</td>
							</tr>
					
							<tr valign="middle">
								<th scope="row">Tranche 4</th>
								<td>
									De <?php echo number_format( esc_attr( get_option('equine_range_3_until') ), 0, ",", "." ); ?>€ à
									<input style="width: 80px" class="regular-text" type="text" name="equine_range_4_until" value="<?php echo esc_attr( get_option('equine_range_4_until') ); ?>" />€
								</td>
							</tr>

							<tr valign="middle">
								<th scope="row">Tranche 5</th>
								<td>
									> <?php echo esc_attr( get_option('equine_range_4_until') ); ?>€
								</td>
							</tr>
							
						</table>
							
						<?php submit_button(); ?>
					</div>
					
					<div id="tabs-commissions">
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- -------------------------------- COMMISSIONS ------------------------------------ -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<table class="form-table">
							
							<tr valign="middle">
								<th scope="row">Annonce libre (%)</th>
								<td>
									<input style="width: 50px" class="regular-text" type="text" name="equine_commission_annonce_libre" value="<?php echo esc_attr( get_option('equine_commission_annonce_libre') ); ?>" />
								</td>
							</tr>
					
							<tr valign="middle">
								<th scope="row">Annonce expertisée (%)</th>
								<td>
									<input style="width: 50px" class="regular-text" type="text" name="equine_commission_annonce_expertise" value="<?php echo esc_attr( get_option('equine_commission_annonce_expertise') ); ?>" />
								</td>
							</tr>
							
						</table>
							
						<?php submit_button(); ?>
					</div>
                    
                    
					<div id="tabs-general">
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- ---------------------------------- GENERAL -------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<table class="form-table">
							
							<tr valign="middle">
								<th scope="row">Slogan (EN)</th>
								<td>
									<input class="regular-text" type="text" name="equine_bloginfo_slogan_en" value="<?php echo esc_attr( get_option('equine_bloginfo_slogan_en') ); ?>" />
                                    <br>
                                    <span style="color: gray;" class="description">Pour modifier la version FR, cliquez <a href="<?php echo get_admin_url(get_current_blog_id(), 'options-general.php'); ?>">ici</a> (Réglages généraux - Slogan)</span>
								</td>
							</tr>
							
						</table>
							
						<?php submit_button(); ?>
					</div>
                    
                    
					<div id="tabs-putad">
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- ------------------------------ DEPOT ANNONCES ----------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<table class="form-table">
                            
							<tr valign="middle">
								<th scope="row" colspan="2">STEP 1<hr></th>
							</tr>
                            
                            <!--- ================== -->
                            <!--- ===== STEP 1 ===== -->
                            <!--- ================== -->
							
							<tr valign="middle">
								<th scope="row">Step 1 - Titre (FR)</th>
								<td>
									<input style="" class="regular-text" type="text" name="equine_smartwizard_step1_title_fr" value="<?php echo esc_attr( get_option('equine_smartwizard_step1_title_fr') ); ?>" />
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 1 - Titre (EN)</th>
								<td>
									<input style="" class="regular-text" type="text" name="equine_smartwizard_step1_title_en" value="<?php echo esc_attr( get_option('equine_smartwizard_step1_title_en') ); ?>" />
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 1 - Texte (FR)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step1_text_fr'), 'equine_smartwizard_step1_text_fr' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 1 - Texte (EN)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step1_text_en'), 'equine_smartwizard_step1_text_en' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th colspan="2" scope="row"><?php submit_button(); ?></th>
							</tr>
                            
                            <!--- ================== -->
                            <!--- ===== STEP 2 ===== -->
                            <!--- ================== -->
                            
							<tr valign="middle">
								<th scope="row" colspan="2">STEP 2<hr></th>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 2 - Titre (FR)</th>
								<td>
									<input style="" class="regular-text" type="text" name="equine_smartwizard_step2_title_fr" value="<?php echo esc_attr( get_option('equine_smartwizard_step2_title_fr') ); ?>" />
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 2 - Titre (EN)</th>
								<td>
									<input style="" class="regular-text" type="text" name="equine_smartwizard_step2_title_en" value="<?php echo esc_attr( get_option('equine_smartwizard_step2_title_en') ); ?>" />
								</td>
							</tr>
					
							<tr valign="middle">
								<th scope="row">Step 2 - Texte (FR)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step2_text_fr'), 'equine_smartwizard_step2_text_fr' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 2 - Texte (EN)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step2_text_en'), 'equine_smartwizard_step2_text_en' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 2 - Texte Expertise (FR)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step2_text2_fr'), 'equine_smartwizard_step2_text2_fr' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 2 - Texte Expertise (EN)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step2_text2_en'), 'equine_smartwizard_step2_text2_en' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 2 - Texte Prix de vente (FR)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step2_text3_fr'), 'equine_smartwizard_step2_text3_fr' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 2 - Texte Prix de vente (EN)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step2_text3_en'), 'equine_smartwizard_step2_text3_en' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th colspan="2" scope="row"><?php submit_button(); ?></th>
							</tr>
                            
                            <!--- ================== -->
                            <!--- ===== STEP 3 ===== -->
                            <!--- ================== -->
                            
							<tr valign="middle">
								<th scope="row" colspan="2">STEP 3<hr></th>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 3 - Titre (FR)</th>
								<td>
									<input style="" class="regular-text" type="text" name="equine_smartwizard_step3_title_fr" value="<?php echo esc_attr( get_option('equine_smartwizard_step3_title_fr') ); ?>" />
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 3 - Titre (EN)</th>
								<td>
									<input style="" class="regular-text" type="text" name="equine_smartwizard_step3_title_en" value="<?php echo esc_attr( get_option('equine_smartwizard_step3_title_en') ); ?>" />
								</td>
							</tr>

							<tr valign="middle">
								<th scope="row">Step 3 - Texte (FR)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step3_text_fr'), 'equine_smartwizard_step3_text_fr' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 3 - Texte (EN)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step3_text_en'), 'equine_smartwizard_step3_text_en' ); ?>
								</td>
							</tr>

							<tr valign="middle">
								<th scope="row">Step 3 - Texte PHOTOS (FR)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step3_text2_fr'), 'equine_smartwizard_step3_text2_fr' ); ?>
								</td>
							</tr>

							<tr valign="middle">
								<th scope="row">Step 3 - Texte PHOTOS (EN)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step3_text2_en'), 'equine_smartwizard_step3_text2_en' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 3 - Texte VIDEO (FR)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step3_text3_fr'), 'equine_smartwizard_step3_text3_fr' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 3 - Texte VIDEOS (EN)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step3_text3_en'), 'equine_smartwizard_step3_text3_en' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 3 - Texte DOCUMENT (FR)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step3_text4_fr'), 'equine_smartwizard_step3_text4_fr' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 3 - Texte DOCUMENT (EN)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step3_text4_en'), 'equine_smartwizard_step3_text4_en' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th colspan="2" scope="row"><?php submit_button(); ?></th>
							</tr>
                            
                            <!--- ================== -->
                            <!--- ===== STEP 4 ===== -->
                            <!--- ================== -->

							<tr valign="middle">
								<th scope="row" colspan="2">STEP 4<hr></th>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 4 - Titre (FR)</th>
								<td>
									<input style="" class="regular-text" type="text" name="equine_smartwizard_step4_title_fr" value="<?php echo esc_attr( get_option('equine_smartwizard_step4_title_fr') ); ?>" />
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 4 - Titre (EN)</th>
								<td>
									<input style="" class="regular-text" type="text" name="equine_smartwizard_step4_title_en" value="<?php echo esc_attr( get_option('equine_smartwizard_step4_title_en') ); ?>" />
								</td>
							</tr>

							<tr valign="middle">
								<th scope="row">Step 4 - Texte (FR)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step4_text_fr'), 'equine_smartwizard_step4_text_fr' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Step 4 - Texte (EN)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step4_text_en'), 'equine_smartwizard_step4_text_en' ); ?>
								</td>
							</tr>
                            
							<!--<tr valign="middle">
								<th scope="row">Step 4 - Texte Bloc bouton Soumettre (FR)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step4_text2_fr'), 'equine_smartwizard_step4_text2_fr' ); ?>
								</td>
							</tr>-->
                            
							<!--<tr valign="middle">
								<th scope="row">Step 4 - Texte Bloc bouton Soumettre (EN)</th>
								<td>
                                    <?php wp_editor( get_option('equine_smartwizard_step4_text2_en'), 'equine_smartwizard_step4_text2_en' ); ?>
								</td>
							</tr>-->
							
						</table>
							
						<?php submit_button(); ?>
					</div>
                    
                    
					<div id="tabs-rappels">
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- ---------------------------------- RAPPELS -------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<table class="form-table">

							<tr valign="middle">
								<th scope="row">
                                    <em style="font-size: 0.9em; color: grey;"><strong>Le rappel aux utilisateurs non connectés ne s'affichera pas en même temps que le splashscreen</strong></em>
                                </th>
                                <td>
									<img src="<?php echo EQUIPEER_URL; ?>assets/images/annonces-user-no-logged-in.jpg" style="width: 400px;" alt="">
								</td>
							</tr>

							<tr valign="middle">
								<th scope="row">Activation du rappel utilisateur non connecté</th>
								<td>
									<input class="regular-text" type="checkbox" name="equine_user_not_logged_in_active" value="1" <?php if (get_option('equine_user_not_logged_in_active') == '1') echo 'checked="checked"'; ?> />&nbsp;Oui
								</td>
							</tr>
							
							<tr valign="middle">
								<th scope="row">Délai apparition</th>
								<td>
									<input style="width: 60px" class="regular-text" type="number" min="1" max="20" name="equine_user_not_logged_in_delay" value="<?php echo esc_attr( get_option('equine_user_not_logged_in_delay') ); ?>" />&nbsp;secondes
								</td>
							</tr>
					
							<tr valign="middle">
								<th scope="row">Nombre d'apparitions maximum</th>
								<td>
									<input style="width: 60px" class="regular-text" type="number" min="1" max="10" name="equine_user_not_logged_in_repeat" value="<?php echo esc_attr( get_option('equine_user_not_logged_in_repeat') ); ?>" />&nbsp;fois
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">TITRE de l'alerte d'info (FR)</th>
								<td>
									<input class="regular-text" type="text" name="equine_user_not_logged_in_title_fr" value="<?php echo esc_attr( get_option('equine_user_not_logged_in_title_fr') ); ?>" />
								</td>
							</tr>

							<tr valign="middle">
								<th scope="row">TITRE de l'alerte d'info (EN)</th>
								<td>
									<input class="regular-text" type="text" name="equine_user_not_logged_in_title_en" value="<?php echo esc_attr( get_option('equine_user_not_logged_in_title_en') ); ?>" />
								</td>
							</tr>
							
							<tr valign="middle">
								<th scope="row">TEXTE de l'alerte d'info (FR)</th>
								<td>
									<input class="regular-text" type="text" name="equine_user_not_logged_in_text_fr" value="<?php echo esc_attr( get_option('equine_user_not_logged_in_text_fr') ); ?>" />
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">TEXTE de l'alerte d'info (EN)</th>
								<td>
									<input class="regular-text" type="text" name="equine_user_not_logged_in_text_en" value="<?php echo esc_attr( get_option('equine_user_not_logged_in_text_en') ); ?>" />
								</td>
							</tr>
                            
						</table>
							
						<?php submit_button(); ?>
					</div>
                    

					<div id="tabs-emails">
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- ----------------------------------- EMAILS -------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<table class="form-table">
                            
							<tr valign="middle">
								<th scope="row" colspan="2">ENVOI DE MESSAGE <span style="color: red;">DEPUIS L'ADMINISTRATION</span> AU CLIENT<hr></th>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">CLIENT - Corps du message<br><u>Variables possibles dans l'email :</u><br>{CLIENT_MESSAGE} </th>
								<td>
                                    <?php wp_editor( get_option('equine_email_client_message_admin'), 'equine_email_client_message_admin' ); ?>
								</td>
							</tr>

							<tr valign="middle">
								<th scope="row" colspan="2">ENVOI DES MESSAGES <span style="color: red;">DE DEMANDES DE SUPPRESSION D'ANNONCES</span><hr></th>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Email(s) admin EQUIPEER</th>
								<td>
									<input class="regular-text" type="text" name="equine_email_admin_removal_request" value="<?php echo esc_attr( get_option('equine_email_admin_removal_request') ); ?>" />
                                    <br>
                                    <em style="font-size: 0.85em; color: grey;"><?php echo sprintf( "S'il n'est pas rempli, l'email d'administration par défaut de Wordpress sera utilisé à la place : %s", get_option('admin_email') ) . '<br>Vous pouvez ajouter plusieurs adresses emails en les séparant par des virgules.'; ?></em>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row" colspan="2">EMAIL LORS DE LA <span style="color: red;">SUPPRESSION D'UNE ANNONCE</span><hr></th>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">CLIENT - Corps du message (FR)<br><u>Variables possibles dans l'email :</u><br>{CLIENT_NAME}<br>{HORSE_IMAGE}<br>{HORSE_NAME}<br>{HORSE_REF} </th>
								<td>
									<?php wp_editor( get_option('equine_email_client_remove_ad_fr'), 'equine_email_client_remove_ad_fr' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">CLIENT - Corps du message (EN)<br><u>Variables possibles dans l'email :</u><br>{CLIENT_NAME}<br>{HORSE_IMAGE}<br>{HORSE_NAME}<br>{HORSE_REF} </th>
								<td>
									<?php wp_editor( get_option('equine_email_client_remove_ad_en'), 'equine_email_client_remove_ad_en' ); ?>
								</td>
							</tr>

							<tr valign="middle">
								<th scope="row" colspan="2">ENVOI DES <span style="color: red;">SÉLECTIONS CLIENTS</span><hr></th>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Email(s) admin EQUIPEER</th>
								<td>
									<input class="regular-text" type="text" name="equine_email_admin_selection" value="<?php echo esc_attr( get_option('equine_email_admin_selection') ); ?>" />
                                    <br>
                                    <em style="font-size: 0.85em; color: grey;"><?php echo sprintf( "S'il n'est pas rempli, l'email d'administration par défaut de Wordpress sera utilisé à la place : %s", get_option('admin_email') ) . '<br>Vous pouvez ajouter plusieurs adresses emails en les séparant par des virgules.'; ?></em>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">CLIENT - Email (FR)<br><u>Variables possibles dans l'email :</u><br>{CLIENT_INFOS}<br>{CLIENT_NAME}<br>{CLIENT_SELECTION} </th>
								<td>
                                    <?php wp_editor( get_option('equine_email_client_send_selection_fr'), 'equine_email_client_send_selection_fr' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">CLIENT - Email (EN)<br><u>Variables possibles dans l'email :</u><br>{CLIENT_INFOS}<br>{CLIENT_NAME}<br>{CLIENT_SELECTION} </th>
								<td>
                                    <?php wp_editor( get_option('equine_email_client_send_selection_en'), 'equine_email_client_send_selection_en' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">ADMIN - Email<br><u>Variables possibles dans l'email :</u><br>{CLIENT_INFOS}<br>{CLIENT_NAME}<br>{CLIENT_SELECTION} </th>
								<td>
                                    <?php wp_editor( get_option('equine_email_admin_send_selection'), 'equine_email_admin_send_selection' ); ?>
								</td>
							</tr>
							
							<tr valign="middle">
								<th scope="row" colspan="2">FORMULAIRES DE <span style="color: red;">RECHERCHE</span><hr></th>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Email(s) admin EQUIPEER<br>Résultat à 0</th>
								<td>
									<input class="regular-text" type="text" name="equine_email_admin_search" value="<?php echo esc_attr( get_option('equine_email_admin_search') ); ?>" />
                                    <br>
                                    <em style="font-size: 0.85em; color: grey;"><?php echo sprintf( "S'il n'est pas rempli, l'email d'administration par défaut de Wordpress sera utilisé à la place : %s", get_option('admin_email') ) . '<br>Vous pouvez ajouter plusieurs adresses emails en les séparant par des virgules.'; ?></em>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row" colspan="2">GENERATION DE <span style="color: red;">PDFs</span><hr></th>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Email(s) admin EQUIPEER</th>
								<td>
									<input class="regular-text" type="text" name="equine_email_admin_pdf" value="<?php echo esc_attr( get_option('equine_email_admin_pdf') ); ?>" />
                                    <br>
                                    <em style="font-size: 0.85em; color: grey;"><?php echo sprintf( "S'il n'est pas rempli, l'email d'administration par défaut de Wordpress sera utilisé à la place : %s", get_option('admin_email') ) . '<br>Vous pouvez ajouter plusieurs adresses emails en les séparant par des virgules.'; ?></em>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">CLIENT - Email (FR)<br><u>Variables possibles dans l'email :</u><br>{CLIENT_MESSAGE}<br>{CLIENT_NAME}<br>{CLIENT_LINK} </th>
								<td>
                                    <?php wp_editor( get_option('equine_email_client_message_pdf_fr'), 'equine_email_client_message_pdf_fr' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">CLIENT - Email (EN)<br><u>Variables possibles dans l'email :</u><br>{CLIENT_MESSAGE}<br>{CLIENT_NAME}<br>{CLIENT_LINK} </th>
								<td>
                                    <?php wp_editor( get_option('equine_email_client_message_pdf_en'), 'equine_email_client_message_pdf_en' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row" colspan="2">CLIENT SOUHAITANT ÊTRE AVERTI DES <span style="color: red;">RECHERCHES SAUVEGARDÉES</span><hr></th>
							</tr>
                            
							</tr>
                            
							<tr valign="middle">
								<th scope="row">CLIENT - Email (FR)<br><u>Variables possibles dans l'email :</u><br>{CLIENT_NAME}<br>{CLIENT_RECHERCHE} </th>
								<td>
                                    <?php wp_editor( get_option('equine_email_client_be_warned_fr'), 'equine_email_client_be_warned_fr' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">CLIENT - Email (EN)<br><u>Variables possibles dans l'email :</u><br>{CLIENT_NAME}<br>{CLIENT_RECHERCHE} </th>
								<td>
                                    <?php wp_editor( get_option('equine_email_client_be_warned_en'), 'equine_email_client_be_warned_en' ); ?>
								</td>
							</tr>

							<tr valign="middle">
								<th scope="row" colspan="2">CONVERSATION SUR EQUIPEER <span style="color: red;">PAR DES CLIENTS</span><hr></th>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Envoi d'un email aux administrateurs de chaque message lors de conversation entre client</th>
								<td>
									<input class="regular-text" type="checkbox" name="equine_email_admin_send_message_suite" value="1" <?php if (get_option('equine_email_admin_send_message_suite') == '1') echo 'checked="checked"'; ?> />&nbsp;Oui
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Email(s) admin EQUIPEER</th>
								<td>
									<input class="regular-text" type="text" name="equine_email_admin_messaging" value="<?php echo esc_attr( get_option('equine_email_admin_messaging') ); ?>" />
                                    <br>
                                    <em style="font-size: 0.85em; color: grey;"><?php echo sprintf( "S'il n'est pas rempli, l'email d'administration par défaut de Wordpress sera utilisé à la place : %s", get_option('admin_email') ) . '<br>Vous pouvez ajouter plusieurs adresses emails en les séparant par des virgules.'; ?></em>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">CLIENT - Email (FR)<br><u>Variables possibles dans l'email :</u><br>{CLIENT_MESSAGE}<br>{CLIENT_NAME}<br>{CLIENT_SENDER} </th>
								<td>
                                    <?php wp_editor( get_option('equine_email_client_message_messaging_fr'), 'equine_email_client_message_messaging_fr' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">CLIENT - Email (EN)<br><u>Variables possibles dans l'email :</u><br>{CLIENT_MESSAGE}<br>{CLIENT_NAME}<br>{CLIENT_SENDER} </th>
								<td>
                                    <?php wp_editor( get_option('equine_email_client_message_messaging_en'), 'equine_email_client_message_messaging_en' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row" colspan="2">SAUVEGARDE D'UNE <span style="color: red;">RECHERCHE (ETRE AVERTI)</span><hr></th>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Email(s) admin EQUIPEER</th>
								<td>
									<input class="regular-text" type="text" name="equine_email_admin_save_search" value="<?php echo esc_attr( get_option('equine_email_admin_save_search') ); ?>" />
                                    <br>
                                    <em style="font-size: 0.85em; color: grey;"><?php echo sprintf( "S'il n'est pas rempli, l'email d'administration par défaut de Wordpress sera utilisé à la place : %s", get_option('admin_email') ) . '<br>Vous pouvez ajouter plusieurs adresses emails en les séparant par des virgules.'; ?></em>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row" colspan="2">FORMULAIRE <span style="color: red;">DEPOSEZ VOTRE ANNONCE</span><hr></th>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Email(s) admin EQUIPEER</th>
								<td>
									<input class="regular-text" type="text" name="equine_email_admin_putad" value="<?php echo esc_attr( get_option('equine_email_admin_putad') ); ?>" />
                                    <br>
                                    <em style="font-size: 0.85em; color: grey;"><?php echo sprintf( "S'il n'est pas rempli, l'email d'administration par défaut de Wordpress sera utilisé à la place : %s", get_option('admin_email') ) . '<br>Vous pouvez ajouter plusieurs adresses emails en les séparant par des virgules.'; ?></em>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row" colspan="2">
                                    Emails <span style="color: red;">BODY</span> lors du dépôt d'une annonce
                                    <br><br><span style="font-weight: normal">
                                    <u>Variables possibles dans les emails :</u><br>
                                    {MODERATE_CLIENT} : Nom du client<br>
                                    {MODERATE_HORSE_IMAGE} : Vignette du cheval<br>
                                    {MODERATE_HORSE_REF} : Référence du cheval<br>
                                    {MODERATE_HORSE_NAME} : Nom du cheval<br>
                                    {MODERATE_HORSE_AGE} : Age du cheval<br>
                                    {MODERATE_HORSE_PRICE} : Prix du cheval<br>
                                    {MODERATE_HORSE_DISCIPLINE} : Discipline du cheval</span>
                                </th>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">ADMIN - Alerte dépôt d'une annonce </th>
								<td>
                                    <?php wp_editor( get_option('equine_email_admin_putad_alert'), 'equine_email_admin_putad_alert' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">CLIENT - Accusé de réception dépôt d'une annonce (FR) </th>
								<td>
                                    <?php wp_editor( get_option('equine_email_client_putad_alert_fr'), 'equine_email_client_putad_alert_fr' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">CLIENT - Accusé de réception dépôt d'une annonce (EN) </th>
								<td>
                                    <?php wp_editor( get_option('equine_email_client_putad_alert_en'), 'equine_email_client_putad_alert_en' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row" colspan="2">
                                    Emails <span style="color: red;">BODY</span> - Acceptation de l'annonce (modération)
                                    <br><br><span style="font-weight: normal">
                                    <u>Variables possibles dans l'email :</u><br>
                                    {MODERATE_CLIENT} : Nom du client<br>
                                    {MODERATE_HORSE_IMAGE} : Vignette du cheval<br>
                                    {MODERATE_HORSE_REF} : Référence du cheval<br>
                                    {MODERATE_HORSE_NAME} : Nom du cheval<br>
                                    {MODERATE_HORSE_AGE} : Age du cheval<br>
                                    {MODERATE_HORSE_PRICE} : Prix du cheval<br>
                                    {MODERATE_HORSE_DISCIPLINE} : Discipline du cheval<br>
                                    {MODERATE_HORSE_URL} : Url de la page du cheval
                                    </span>
                                </th>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">CLIENT - Annonce acceptée (FR) </th>
								<td>
                                    <?php wp_editor( get_option('equine_email_client_moderate_ok_fr'), 'equine_email_client_moderate_ok_fr' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">CLIENT - Annonce acceptée (EN) </th>
								<td>
                                    <?php wp_editor( get_option('equine_email_client_moderate_ok_en'), 'equine_email_client_moderate_ok_en' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row" colspan="2">
                                    Emails <span style="color: red;">BODY</span> - Rejet de l'annonce (modération)
                                    <br><br><span style="font-weight: normal">
                                    <u>Variables possibles dans l'email :</u><br>
                                    {MODERATE_CLIENT} : Nom du client<br>
                                    {MODERATE_HORSE_NAME} : Nom du cheval<br>
                                    {MODERATE_HORSE_IMAGE} : Vignette du cheval<br>
                                    {MODERATE_REJECT_CAUSE} : Cause du rejet (que vous indiquez lors d'une modération : motif du rejet)<br>
                                </th>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">CLIENT - Annonce rejetée (FR) </th>
								<td>
                                    <?php wp_editor( get_option('equine_email_client_moderate_ko_fr'), 'equine_email_client_moderate_ko_fr' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">CLIENT - Annonce rejetée (EN) </th>
								<td>
                                    <?php wp_editor( get_option('equine_email_client_moderate_ko_en'), 'equine_email_client_moderate_ko_en' ); ?>
								</td>
							</tr>
							
						</table>
							
						<?php submit_button(); ?>
					</div>
                    
					<div id="tabs-profil">
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- ---------------------------------- PROFIL --------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<table class="form-table">
                            
							<tr valign="middle">
								<th scope="row" colspan="2">COMPTE CLIENT - <span style="color: red;">Général</span><hr></th>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Activation de la redirection vers le compte si champs obligatoires non renseignés</th>
								<td>
									<input class="regular-text" type="checkbox" name="equine_profil_redirect_if_datas_required" value="1" <?php if (get_option('equine_profil_redirect_if_datas_required') == '1') echo 'checked="checked"'; ?> />&nbsp;Oui
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row" colspan="2">COMPTE CLIENT - <span style="color: red;">Ma sélection</span><hr></th>
							</tr>

							<tr valign="middle">
								<th scope="row">Texte AIDE (FR)</th>
								<td>
                                    <?php wp_editor( get_option('equine_profil_my_selection_text_fr'), 'equine_profil_my_selection_text_fr' ); ?>
								</td>
							</tr>

							<tr valign="middle">
								<th scope="row">Texte AIDE (EN)</th>
								<td>
                                    <?php wp_editor( get_option('equine_profil_my_selection_text_en'), 'equine_profil_my_selection_text_en' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row" colspan="2">COMPTE CLIENT - <span style="color: red;">Messagerie</span><hr></th>
							</tr>

							<tr valign="middle">
								<th scope="row">Texte AIDE (FR)</th>
								<td>
                                    <?php wp_editor( get_option('equine_profil_my_message_text_fr'), 'equine_profil_my_message_text_fr' ); ?>
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Texte AIDE (EN)</th>
								<td>
                                    <?php wp_editor( get_option('equine_profil_my_message_text_en'), 'equine_profil_my_message_text_en' ); ?>
								</td>
							</tr>

                        </table>
                        
						<?php submit_button(); ?>
                    </div>
                    
					<div id="tabs-googleads">
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- -------------------------------- GOOGLE ADS ------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<table class="form-table">
                            
							<tr valign="middle">
								<th scope="row" colspan="2">GOOGLE ADS ou code HTML personnalisé<hr></th>
							</tr>
							
							<tr valign="middle">
								<th scope="row">Activation</th>
								<td>
									<input class="regular-text" type="checkbox" name="equine_google_ads_active" value="1" <?php if (get_option('equine_google_ads_active') == '1') echo 'checked="checked"'; ?> />&nbsp;Oui
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Position</th>
								<td>
									En <input style="width: 60px" class="regular-text" type="number" min="1" max="11" name="equine_google_ads_position" value="<?php echo esc_attr( get_option('equine_google_ads_position') ); ?>" />e position
								</td>
							</tr>
					
							<tr valign="middle">
								<th scope="row">Code (HTML)</th>
								<td>
									<textarea style="height: 150px" class="regular-text" name="equine_google_ads_code"><?php echo esc_attr( get_option('equine_google_ads_code') ); ?></textarea>
								</td>
							</tr>
							
						</table>
							
						<?php submit_button(); ?>
					</div>
					
					<div id="tabs-apis">
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- ----------------------------------- APIs ---------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<table class="form-table">
							
							<tr valign="middle">
								<th scope="row">Google Place Autocomplete</th>
								<td>
									<input class="regular-text" type="text" name="equine_google_place_api_key" value="<?php echo esc_attr( get_option('equine_google_place_api_key') ); ?>" />
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Google Translate API</th>
								<td>
									<input class="regular-text" type="text" name="equine_google_translate_api_key" value="<?php echo esc_attr( get_option('equine_google_translate_api_key') ); ?>" />
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Send In Blue API V3 SDK</th>
								<td>
									<input class="regular-text" type="text" name="equine_send_in_blue_api_key" value="<?php echo esc_attr( get_option('equine_send_in_blue_api_key') ); ?>" />
								</td>
							</tr>
                            
							<tr valign="middle">
								<th scope="row">Send In Blue LIST ID (Newsletter)</th>
								<td>
									<input style="width: 80px;" class="regular-text" type="text" name="equine_send_in_blue_list_id" value="<?php echo esc_attr( get_option('equine_send_in_blue_list_id') ); ?>" />
								</td>
							</tr>
							
						</table>
							
						<?php submit_button(); ?>
					</div>
					
					<div id="tabs-credits">
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- ---------------------------------- CREDITS -------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<!-- --------------------------------------------------------------------------------- -->
						<table class="form-table">
							<tbody>
							  <tr valign="middle" style="border-bottom: 1px solid #eee;">
								<th scope="row"><h3>CREDITS<br><i style="font-size: 0.7em;">Plugin: <?php echo INFORMATUX_PLUGIN_NAME; ?></i></h3></th>
								<td>
									<img width="96" height="96" class="informatux-credits" src="<?php echo EQUIPEER_URL; ?>assets/images/informatux-avatar.png" alt=""><br><br>Développé et maintenu par <?php echo $informatux_url; ?>
								</td>
							  </tr>
							  <tr valign="middle" style="border-bottom: 1px solid #eee;">
								<th scope="row"><h3>SUPPORT<br><i style="font-size: 0.7em;">Plugin: <?php echo INFORMATUX_PLUGIN_NAME; ?></i></h3></th>
								<td>
									<img width="96" height="96" class="informatux-support" src="<?php echo EQUIPEER_URL; ?>assets/images/informatux-support.png" alt="EQUIPEER support">Support contact <?php echo $informatux_support; ?>
									<br>
									Besoin de plus de fonctionnalités sur ce plugin ? N'hésitez pas à nous contacter ici <?php echo $informatux_support; ?>
									<br>
									Besoin d'un plugin Wordpress ? N'hésitez pas à nous contacter ici <?php echo $informatux_support; ?>
									<br>
									Pour nous contacter, indiquez nous toutes les informations de votre installation Wordpress (Numéro de version WP, Numéro de version du plugin, Serveur)
									<br><br>
									<a class="informatux-support-other-plugins" target="_blank" href="<?php echo get_admin_url(get_current_blog_id(), 'plugin-install.php?s=informatux&tab=search&type=term'); ?>">&dzigrarr; Si vous souhaitez utiliser nos autres plugins, cliquez ici.</a>
								</td>
							  </tr>
							  <tr valign="middle">
								<th scope="row"><h3>SERVICES<br><i style="font-size: 0.7em;"><?php echo $informatux_url; ?><i></h3></th>
								<td>
									<div class="informatux_outerdiv">
										<div class="informatux_outer">
											<img src="https://informatux.com/data/uploads/giphy/informatux-securite-wp.gif" class="informatux_gs_image" alt="">
											<div class="informatux_centered">SECURITE</div>
											<div>
											  <p class="informatux_p_services">Fatigué de voir vos sites WORDPRESS attaqués ?<br>
											  Trop compliqué à remettre en ordre<br>
											  <?php echo $informatux_contact; ?>
											  </p>       
											</div>
										</div>
										
										<div class="informatux_outer">
											<img src="https://informatux.com/data/uploads/giphy/informatux-installation-wordpress.gif" class="informatux_gs_image" alt="">
											<div class="informatux_centered">INSTALLATION</div>
											<div>
											  <p class="informatux_p_services">Wordpress / WooCommerce<br>
											  Thèmes Wordpress<br>
											  Hébergement<br>
											  Gérer vos sites WP par applications ANDROID / APPLE<br>
											  <?php echo $informatux_contact; ?></p>
											</div>
										</div>
										
										<div class="informatux_outer informatux_last">
											<img src="https://informatux.com/data/uploads/giphy/informatux-maintenance.gif" class="informatux_gs_image" alt="">
											<div class="informatux_centered">MAINTENANCE</div>
											<div>
											  <p class="informatux_p_services">Pas le temps<br>
											  Pas l'envie<br>
											  Trop compliqué<br>
											  <?php echo $informatux_contact; ?>
											  </p>       
											</div>
										</div>
									</div>
								</td>
							  </tr>
							</tbody>
						</table>
					</div>
			
			</form>
			
		</div>
		<?php
	}
	
}