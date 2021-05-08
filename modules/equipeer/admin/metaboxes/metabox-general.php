<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Metabox Equine General
 *
 * @class Metabox
 */
class Equipeer_Metabox_General extends Equipeer {
	
	private $mt_prefix = 'type';
	
    /**
     * Constructor for the Equipeer_Metabox_General class
     *
     * Sets up all the appropriate hooks and actions
     */
    function __construct() {
        // Add metaboxes
        add_action( 'add_meta_boxes', array( $this, 'type_add_meta_box' ) );
		// Save infos from metaboxes
		add_action( 'save_post', array( $this, 'type_save' ) );
		// Metabox class (call)
		$this->metaboxClass = new Equipeer_Metabox();
		// Titan call
		$this->equipeer_options = TitanFramework::getInstance( EQUIPEER_ID );
	}
	
    /**
     * Adds the meta box container.
     */
	function type_add_meta_box() {
		add_meta_box(
			'equipeer-' . $this->mt_prefix,
			__( 'General INFOS', EQUIPEER_ID ),
			array( $this, 'type_html' ),
			$this->post_type,
			'normal', // normal | advanced | side
			'high' // default | high | core | low
		);
	}
	
	/**
	 * Get last REFERENCE
	 */
	function get_last_reference() {
		$last_id = $last_reference = "";
		$args = array(
			 'post_type'      => 'equine'
			,'post_status'    => array( 'moderate', 'publish', 'pending', 'draft', 'future', 'private', 'off' )
			//,'perm'           => 'readable' // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
			,'cache_results'  => false // False pour eviter des incrementations aleatoires
			,'update_post_meta_cache' => false
			,'update_post_term_cache' => false
			,'orderby'        => 'meta_value_num' //'meta_value'
			,'order'          => 'DESC'
			,'meta_key'       => 'reference'
			,'posts_per_page' => 1
		);
		$query = new WP_Query( $args );
		//echo '<pre>';
		//var_dump($query);
		//echo '</pre>';
		// Check if have posts
		if ( !$query->have_posts() ) return;
		// The LAST ID
		$last_id = $query->post->ID;
		// Get the meta value
		$last_reference = get_post_meta( $last_id, 'reference', true );
		// Return last reference + 1
		return (intval($last_reference)) + 1;
	}
	
    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
	function type_html( $post) {
		wp_nonce_field( '_type_nonce', 'type_nonce' ); ?>
		
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<link rel="stylesheet" href="/resources/demos/style.css">
		<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
		<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	
		<table class="form-table">
			<!-- ===== PERMALINK / RADIO BUTTONS ===== -->
			<tr class="row-00 odd" valign="top">
				<th scope="row" class="first">
					<label for="permalink">Permalien<br><span style="font-size: 0.9em; font-weight: normal;" class="description">Copier-coller</span></label>
				</th>
				<td class="second tf-note">
					<?php
					global $post;
					// ----------------------------------------
					$permalink_current_full = get_permalink();
					$permalink_wished_full  = get_site_url() . '/' . $this->slug . '/' . equipeer_rewrite_string( strtolower( equipeer_head_text_horse( intval($_GET['post']), false, "-", "permalink" ) ) ) . '/';
					// ----------------------------------------
					$permalink_current = $post->post_name;
					$permalink_wished  = (ICL_LANGUAGE_CODE == 'fr') ? equipeer_rewrite_string( strtolower( equipeer_head_text_horse( intval($_GET['post']), false, "-", "permalink" ) ) ) : equipeer_rewrite_string( strtolower( equipeer_head_text_horse_url( intval($_GET['post']), false, "-", "permalink" ) ) );
					// ----------------------------------------
					?>
					<input type="text" name="permalink" id="permalink" style="width: 450px;" value="<?php echo ( (ICL_LANGUAGE_CODE == 'fr') ? strtolower( equipeer_rewrite_string( strtolower( equipeer_head_text_horse( intval($_GET['post']), false, "-", "permalink" ) ) ) ) : strtolower( equipeer_rewrite_string( strtolower( equipeer_head_text_horse_url( intval($_GET['post']), false, "-", "permalink" ) ) ) ) ); ?>">
					<p class="description">Le permalien est composé de la race, du sexe, de la robe, de la taille, de la date de naissance ou l'année de naissance, de la discipline et de la r&eacute;f&eacute;rence.<br>Ex: selle-francais-hongre-gris-168cm-2010-02-25-cso-so0159
					<?php if ( $permalink_current != strtolower($permalink_wished) && $_GET['action'] == 'edit' ) { ?>
						<div class="equipeer-msg equipeer-msg-danger">
							<span class="equipeer-msg-closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
							<h4 style="margin: 0 0 0.5em 0; font-size: 1.3em;">Modification : copier/coller le permalien (<?php echo strtoupper(ICL_LANGUAGE_CODE); ?>)</h4>
							Permalien actuel&nbsp;: <?php echo $permalink_current; ?><br>
							Url : <?php echo $permalink_current_full; ?>
							<hr>
							Permalien voulu&nbsp;&nbsp;: <?php echo strtolower($permalink_wished); ?><br>
							Url : <?php echo strtolower($permalink_wished_full); ?>
						</div>
					<?php } ?>
					</p>
				</td>
			</tr>
			<tr class="row-0 even" valign="top">
				<th scope="row" class="first">
					
				</th>
				<td class="second tf-note">
					<?php $to_expertise_checked = ( $this->metaboxClass->get_meta_value('to_expertise') == 1 ) ? 'checked' : ''; ?>				
					<label class="switch switch-green">
					  <input type="checkbox" name="to_expertise" id="to_expertise" class="switch-input" <?php echo $to_expertise_checked; ?>>
					  <span class="switch-label" data-on="Oui" data-off="Non"></span>
					  <span class="switch-handle"></span>
					</label>
					<span class="switch-name"><?php _e( 'To expertise', EQUIPEER_ID ); ?></span>
					<span class="switch-separator"></span>
					<?php $sold_checked = ( $this->metaboxClass->get_meta_value('sold') == 1 ) ? 'checked' : ''; ?>				
					<label class="switch switch-green">
					  <input type="checkbox" name="sold" id="sold" class="switch-input" <?php echo $sold_checked; ?>>
					  <span class="switch-label" data-on="Oui" data-off="Non"></span>
					  <span class="switch-handle"></span>
					</label>
					<span class="switch-name"><?php _e( 'Sold', EQUIPEER_ID ); ?></span>
				</td>
			</tr>
			<!-- ===== SIRE ===== -->
			<tr class="row-5 odd" valign="top">
				<th scope="row" class="first">
					<label for="sire"><?php _e( 'Sire / Identification', EQUIPEER_ID ); ?><br><span style="font-size: 0.9em; font-weight: normal;">Ex: <span style="color: red;">03132710</span>E</span></label>
				</th>
				<td class="second tf-note">	
					<input type="text" name="sire" id="sire" value="<?php echo $this->metaboxClass->get_meta_value( 'sire' ); ?>">
					&nbsp;&nbsp;
					<span id="get-sire" class="button">SIRE</span>
					<p class="description">Le bouton SIRE permet de récupérer les informations sur l'équidé présent sur le territoire français.<br>Indiquez le numéro de SIRE sans la lettre finale.</p>
				</td>
			</tr>
			<!-- ===== REFERENCE ===== -->
			<tr class="row-4 even" valign="top">
				<th scope="row" class="first">
					<label for="reference"><?php _e( 'EQUIPEER Reference', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<?php
						// equipeer_discipline_horse_prefix_28
						$get_the_prefix   = get_term_meta( $this->metaboxClass->get_meta_value('discipline'), 'equipeer_prefix_taxonomy_parent_id', true );
						$reference_prefix  = ( isset($get_the_prefix) && $get_the_prefix != '' ) ? $get_the_prefix : '--';
						$get_the_reference = ( $this->metaboxClass->get_meta_value( 'reference' ) > 0 ) ? $this->metaboxClass->get_meta_value( 'reference' ) : '';
					?>
					<span class="equipeer-input-prefix"><?php echo $reference_prefix; ?></span>
					<input class="equipeer-input-number" type="text" name="reference_disabled" id="reference_disabled" value="<?php echo equipeer_get_format_reference( $get_the_reference ); ?>" style="background: rgba(255, 255, 255, 1);" disabled>
					<input class="equipeer-input-number" type="hidden" name="reference" id="reference" value="<?php echo $get_the_reference; ?>"> <span style="color: transparent;"><?php //echo $this->get_last_reference(); ?></span>
					<?php if ($get_the_reference == '') { ?>
						<input type="hidden" name="reference_start" id="reference_start" value="0">
						<p class="description"><span class="dashicons dashicons-info"></span> La référence sera disponible une fois la sauvegarde de la fiche équidé effectuée.</p>
					<?php } ?>
				</td>
			</tr>
			<!-- ===== TYPE D'ANNONCE ===== -->
			<tr class="row-6 even" valign="top">
				<th scope="row" class="first">
					<label for="type_annonce"><?php _e( 'Ad Type', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">			
					<select name="type_annonce" id="type_annonce" class="equipeer-select">
						<option value=""><?php _e( '&mdash; Select &mdash;', EQUIPEER_ID ); ?></option>
						<?php
							$all_ads_type = equipeer_get_all_type_ads();
							if ($all_ads_type) {
								foreach( $all_ads_type as $row ) {
									echo '<option value="' . $row['value'] . '" ';
									echo selected( $this->metaboxClass->get_meta_value('type_annonce'), $row['value'] );
									echo '>';
									echo $row['name'];
									echo '</option>';
								}
							}
						?>
					</select>
				</td>
			</tr>
			<!-- ===== TYPE D'EQUIDE ===== -->
			<tr class="row-1 odd" valign="top">
				<th scope="row" class="first">
					<label for="type_canasson"><?php _e( 'Equine type', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">			
					<select name="type_canasson" id="type_canasson" class="equipeer-select">
						<option value=""><?php _e( '&mdash; Select &mdash;', EQUIPEER_ID ); ?></option>
						<?php
							$all_type_canassons = equipeer_get_all_type_horses();
							if ($all_type_canassons) {
								foreach( $all_type_canassons as $row ) {
									echo '<option value="' . $row['value'] . '" ';
									echo selected( $this->metaboxClass->get_meta_value('type_canasson'), $row['value'] );
									echo '>';
									echo $row['name'];
									echo '</option>';
								}
							}
						?>
					</select>
				</td>
			</tr>
			<!-- ===== DISCPLINE ===== -->
			<tr class="row-2 even" valign="top">
				<th scope="row" class="first">
					<label for="discipline"><?php _e( 'Discipline', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">			
					<select name="discipline" id="discipline" class="equipeer-select">
						<option value=""><?php _e( '&mdash; Select &mdash;', EQUIPEER_ID ); ?></option>
						<?php
							//$all_types = equipeer_get_all_type_horses();
							//if ($all_types) {
							//	foreach( $all_types as $type ) {
							//		// ---------------------------------------------
							//		echo '<optgroup label="' . $type['name'] . '">';
							//		// ---------------------------------------------
							//		$taxonomies_discipline = equipeer_get_terms('equipeer_discipline', array( 'equipeer_select_taxonomy_parent_id' ), $type['value']);
							//		// ---------------------------------------------
							//		if ($taxonomies_discipline) {
							//			// ---------------------------------------------
							//			foreach( $taxonomies_discipline as $taxonomy ) {
							//				echo '<option value="' . $taxonomy['id'] . '" ';
							//				echo selected( $this->metaboxClass->get_meta_value('discipline'), $taxonomy['id'] );
							//				echo '>';
							//				echo $taxonomy['name'];
							//				echo '</option>';
							//			}
							//			// ---------------------------------------------
							//		}
							//		// ---------------------------------------------
							//		echo '</optgroup>';
							//		// ---------------------------------------------
							//	}
							//}
							// ---------------------------------------------
							$taxonomies_discipline = equipeer_get_terms('equipeer_discipline', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
							// ---------------------------------------------
							if ($taxonomies_discipline) {
								// ---------------------------------------------
								foreach( $taxonomies_discipline as $taxonomy ) {
									echo '<option value="' . $taxonomy['id'] . '" ';
									echo selected( $this->metaboxClass->get_meta_value('discipline'), $taxonomy['id'] );
									echo '>';
									echo $taxonomy['name'];
									echo '</option>';
								}
								// ---------------------------------------------
							}
						?>
					</select>
					<p class="description">Le choix de la discipline permet de modifier instantanément les labels des champs</p>
				</td>
			</tr>
			<!-- ===== ANNIVERSAIRE ===== -->
			<tr class="row-11 even" valign="top">
				<th scope="row" class="first">
					<label for="discipline"><?php _e( 'Date of birth', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">	
					<p class="equipeer_p_form">
						<label for="birthday_real" style="color: #50565B; font-size: 0.9em;	font-weight: normal;"><?php _e( 'Birthday real', EQUIPEER_ID ); ?></label><br>
						<input type="text" class="equipeer_datepicker equipeer-input-date wdisabled" name="birthday_real" id="birthday_real" value="<?php echo str_replace( " 00:00:00", "", $this->metaboxClass->get_meta_value( 'birthday_real' ) ); ?>">
						<br>
						<span style="clear: both; display: block;" class="description"><?php _e( 'Format YYYY-MM-DD', EQUIPEER_ID ); ?>.<br>Cliquez sur l'icône <strong>Calendrier</strong><br>pour saisir la date de naissance.</span>
					</p>
				
					<p class="equipeer_p_form">
						<label for="birthday" style="color: #50565B; font-size: 0.9em;	font-weight: normal;"><?php _e( 'Birthday Year', EQUIPEER_ID ); ?></label><br>
						<input class="equipeer-input-date" type="text" name="birthday" id="birthday" value="<?php echo $this->metaboxClass->get_meta_value( 'birthday' ); ?>">
						<br>
						<span class="description"><?php _e( 'Format YYYY', EQUIPEER_ID ); ?>. Ce champs se remplit automatiquement en sélectionnant une date de naissance OU avec le remplissage automatique de la recherche SIRE.</span>
					</p>
					
					<p class="equipeer_p_form">
						<label for="birthday" style="color: #50565B; font-size: 0.9em;	font-weight: normal;"><?php _e( 'Age', EQUIPEER_ID ); ?></label><br>
						<input class="equipeer-input-age" type="text" name="real_age" id="real_age" value="<?php echo equipeer_get_age_by_year( $this->metaboxClass->get_meta_value( 'birthday' ) ); ?>" disabled>
					</p>					
				</td>
			</tr>
			<!-- ===== RACE ===== -->
			<tr class="row-8 even" valign="top">
				<th scope="row" class="first">
					<label for="breed"><?php _e( 'Breed', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">			
					<select name="breed" id="breed" class="equipeer-select">
						<option value=""><?php _e( '&mdash; Select &mdash;', EQUIPEER_ID ); ?></option>
						<?php
							// ---------------------------------------------
							$taxonomies_breed = equipeer_get_terms('equipeer_breed', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
							// ---------------------------------------------
							if ($taxonomies_breed) {
								// ---------------------------------------------
								foreach( $taxonomies_breed as $taxonomy ) {
									echo '<option value="' . $taxonomy['id'] . '" ';
									echo selected( $this->metaboxClass->get_meta_value('breed'), $taxonomy['id'] );
									echo '>';
									echo $taxonomy['name'];
									echo '</option>';
								}
								// ---------------------------------------------
							}
						?>
					</select>
				</td>
			</tr>
			<!-- ===== SEXE ===== -->
			<tr class="row-3 odd" valign="top">
				<th scope="row" class="first">
					<label for="sex"><?php _e( 'Gender', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">			
					<select name="sex" id="sex" class="equipeer-select">
						<option value=""><?php _e( '&mdash; Select &mdash;', EQUIPEER_ID ); ?></option>
						<?php
							// ---------------------------------------------
							$taxonomies_gender = equipeer_get_terms('equipeer_gender', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
							// ---------------------------------------------
							if ($taxonomies_gender) {
								// ---------------------------------------------
								foreach( $taxonomies_gender as $taxonomy ) {
									echo '<option value="' . $taxonomy['id'] . '" ';
									echo selected( $this->metaboxClass->get_meta_value('sex'), $taxonomy['id'] );
									echo '>';
									echo $taxonomy['name'];
									echo '</option>';
								}
								// ---------------------------------------------
							}
						?>
					</select>
				</td>
			</tr>
			<!-- ===== ROBE ===== -->
			<tr class="row-9 odd" valign="top">
				<th scope="row" class="first">
					<label for="dress"><?php _e( 'Dress', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">			
					<select name="dress" id="dress" class="equipeer-select">
						<option value=""><?php _e( '&mdash; Select &mdash;', EQUIPEER_ID ); ?></option>
						<?php
							// ---------------------------------------------
							$taxonomies_dress = equipeer_get_terms('equipeer_color', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
							// ---------------------------------------------
							if ($taxonomies_dress) {
								// ---------------------------------------------
								foreach( $taxonomies_dress as $taxonomy ) {
									echo '<option value="' . $taxonomy['id'] . '" ';
									echo selected( $this->metaboxClass->get_meta_value('dress'), $taxonomy['id'] );
									echo '>';
									echo $taxonomy['name'];
									echo '</option>';
								}
								// ---------------------------------------------
							}
						?>
					</select>
				</td>
			</tr>
			<!-- ===== TAILLE ===== -->
			<tr class="row-7 odd" valign="top">
				<th scope="row" class="first">
					<label for="size_cm"><?php _e( 'Size (cm) / Size', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<div class="equipeer-td-input">
						<input style="text-align: right;" class="equipeer-input-number" type="text" name="size_cm" id="size_cm" value="<?php echo $this->metaboxClass->get_meta_value( 'size_cm' ); ?>">
						<span class="equipeer-input-suffix">cm</span>
					</div>
					<div class="equipeer-td-input">
						<select name="size" id="size" class="equipeer-select">
							<option value=""><?php _e( '&mdash; Select &mdash;', EQUIPEER_ID ); ?></option>
							<?php
								// ---------------------------------------------
								$taxonomies_size = equipeer_get_terms('equipeer_size', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
								// ---------------------------------------------
								if ($taxonomies_size) {
									// ---------------------------------------------
									foreach( $taxonomies_size as $taxonomy ) {
										echo '<option value="' . $taxonomy['id'] . '" ';
										echo selected( $this->metaboxClass->get_meta_value('size'), $taxonomy['id'] );
										echo '>';
										echo $taxonomy['name'];
										echo '</option>';
									}
									// ---------------------------------------------
								}
							?>
						</select>
					</div>
				</td>
			</tr>
		</table>
		<div class="equipeer_clear"></div>
		
		<script>
			function get_tranche_size(new_size) {
				var tranche_id = 0;
				// Get ID From SELECT (Tranche)
				if (new_size < 120) tranche_id = 124;
				if (new_size < 130 && new_size >= 120) tranche_id = 125;
				if (new_size < 140 && new_size >= 130) tranche_id = 126;
				if (new_size < 150 && new_size >= 140) tranche_id = 127;
				if (new_size < 160 && new_size >= 150) tranche_id = 128;
				if (new_size < 165 && new_size >= 160) tranche_id = 129;
				if (new_size < 170 && new_size >= 165) tranche_id = 130;
				if (new_size < 180 && new_size >= 170) tranche_id = 131;
				if (new_size >= 180) tranche_id = 132;
				// Change VALUE of the SELECT size
				jQuery( "#size" ).val(tranche_id).change();
				return false;
			}
			
			jQuery(function($) {
				
				$( "#size_cm" ).on( 'change keyup', function() {
					get_tranche_size( jQuery("#size_cm").val() );
				});
				
				$( ".equipeer_datepicker" ).datepicker({
					dateFormat: 'yy-mm-dd',
					closeText: 'Fermer',
					prevText: 'Précédent',
					nextText: 'Suivant',
					currentText: 'Aujourd\'hui',
					monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
					monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
					dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
					dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
					dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
					weekHeader: 'Sem.',
					changeMonth: true,
					changeYear: true,
					showOn: "button",
					buttonImage: "<?php echo EQUIPEER_URL; ?>assets/images/icon-calendar.png",
					buttonImageOnly: true,
					buttonText: "Select date",
					onSelect: function( d ) {
						// ----------------------------------
						// Get new date (Extract YEAR only)
						// ----------------------------------
						var new_year = d.substring(0, 4);
						$('#birthday').val( new_year );
						// ----------------------------------
						// Get Age
						// ----------------------------------
						var age = 0;
						// ----------------------------------
						var method = "year"; // date | year
						// ----------------------------------
						if (method == 'date') {
							// Calcul by DATE
							d = new Date(d);
							var today = new Date();
							age = Math.floor((today-d) / (365.25 * 24 * 60 * 60 * 1000));
						} else {
							// Calcul by YEAR
							var year = new Date().getFullYear();
							age = year - new_year;
						}
						// Return AGE
						$('#real_age').val( age + ' ans' );
					}
				});

				$('#get-sire').on('click', function() {
					var num_sire = $('#sire').val();
					if (!num_sire) {
						alert('Vous devez saisir un SIRE pour effectuer une recherche');
					} else {
						$.get( "<?php echo EQUIPEER_URL; ?>get-sire.php", { sire: num_sire, from: 'admin'} ).done(function( data ) {
							//alert('SIRE: '+num_sire);
							// ---------------------------------------------
							var equide = $.parseJSON(data);
							// ---------------------------------------------
							var date_explode = equide.date.split("-");
							var new_date = date_explode[2]+"/"+date_explode[1]+"/"+date_explode[0];
							// ---------------------------------------------
							//var new_nom = equide.nom.split(' ').join('-');
							var new_robe = equide.robe.split(' ').join('-');
							// ---------------------------------------------
							var equide_txt = "";
							equide_txt += "\n\n";
							equide_txt += "Sire : "+equide.sireN+equide.sireK+"\n\n";
							equide_txt += "Date : "+new_date+"\n";
							equide_txt += "Nom : "+equide.nom+"\n";
							equide_txt += "Race : "+equide.race+"\n";
							equide_txt += "Robe : "+equide.robe+"\n";
							equide_txt += "Taille : "+equide.taille+"\n";
							equide_txt += "Sexe : "+equide.sexe+"\n";
							// ---------------------------------------------
							var r_equide = confirm('Insérez les informations suivantes :'+equide_txt);
							// ---------------------------------------------
							if (r_equide === true) {
								// Insert DATAS
								// ---------------------------------------------
								$("input[id=sire]").val(equide.sireN);
								// ---------------------------------------------
								$("input[id=birthday_real]").val(equide.date);
								$("input[id=birthday]").val(date_explode[0]);
								var year = new Date().getFullYear();
								var age  = year - date_explode[0];
								$('#real_age').val( age + ' ans' );
								// ---------------------------------------------
								$("input[id=title]").val(equide.nom);
								$("#title-prompt-text").hide();
								// ---------------------------------------------
								$("input[id=size_cm]").val(equide.taille);
								get_tranche_size(equide.taille);
								// ---------------------------------------------
								// Race
								//alert('Race: '+equide.race.toLowerCase());
								switch(equide.race.toLowerCase()) {
									case "american-warmblood": case "american warmblood": race_id = 82; break;
									case "anglo-arabe": case "anglo-arabe de croisement": race_id = 83; break; // FAIT
									case "apaloosa": case "appaloosa": race_id = 84; break; // FAIT
									case "aqps": case "cheval autre que pur sang": race_id = 85; break; // FAIT
									case "autres": case "origine etrangere selle": race_id = 115; break; // FAIT
									case "bwp": case "belgian warmblood": race_id = 86; break; // FAIT
									case "caballo-de-deporte-espanol": race_id = 87; break; 
									case "connemara": race_id = 88; break; // FAIT
									case "dartmund": race_id = 89; break;
									case "deutsches-reitpony": case "deutsches reitpony": race_id = 90; break; // FAIT
									case "hanovrien": case "hannoveraner": race_id = 91; break; // FAIT
									case "holsteiner": case "holsteiner warmblut": race_id = 92; break; // FAIT
									case "irish-sport-horse": case "irish sport horse": race_id = 93; break; // FAIT
									case "kwpn": case "kon. warm paard nederland": race_id = 94; break; // FAIT
									case "lusitanien": case "pure race lusitanienne": race_id = 95; break; // FAIT
									case "new-forest": case "new forest": race_id = 96; break; // FAIT
									case "oc": case "origine constatee": race_id = 97; break; // FAIT
									case "oldenburger": race_id = 98; break; // FAIT
									case "paint-horse": case "paint horse": race_id = 99; break; // FAIT
									case "pfs": case "poney francais de selle": race_id = 100; break; // FAIT
									case "pottock": case "pottok": race_id = 101; break; // FAIT
									case "pur-race-espagnol": case "pura raza espanola": race_id = 102; break; // FAIT
									case "pur-sang": case "pur sang": race_id = 103; break; // FAIT
									case "pur-sang-arabe": case "arabe": race_id = 104; break; // FAIT
									case "quater-horse": case "quater horse": case "quarter horse appendix": race_id = 105; break; // FAIT
									case "rheinland": case "rheinisches warmblut": race_id = 106; break; // FAIT
									case "sbs": case "cheval de sport belge": race_id = 107; break; // FAIT									
									case "selle-italien": case "selle italien": case "sella italiano": race_id = 109; break; // FAIT
									case "selle-luxembourgeois": case "selle luxembourgeois": race_id = 110; break; // FAIT
									case "trakhener": case "trakehner": race_id = 111; break; // FAIT
									case "trotteur-francais": case "trotteur francais": race_id = 112; break; // FAIT
									case "welsh": case "welsh cob": race_id = 113; break; // FAIT
									case "zangersheide": race_id = 114; break; // FAIT
									default: case "selle-francais": case "selle francais": case "selle francais section a": race_id = 108; break;
								}
								$("#breed").val(race_id).change();
								// ---------------------------------------------
								// Robe
								switch(new_robe.toLowerCase()) {
									case "alezan": case "alezan crins laves": case "alezan-crins-laves": case "alezan melange": case "alezan brule": case "alezan-brule": robe_id = 116; break;
									case "bai": robe_id = 117; break;
									case "bai-brun": case "bai brun": case "bai-fonce": case "bai fonce": robe_id = 118; break;
									case "noir-pangare": case "noir": case "noir pangare": robe_id = 121; break;
									case "gris": robe_id = 120; break;
									case "pie": robe_id = 123; break;
									case "isabelle": robe_id = 484; break;
								}
								$("#dress").val(robe_id).change();
								// ---------------------------------------------
								// Sexe
								switch(equide.sexe.toLowerCase()) {
									case "hongre": sexe_id = 37; break;
									case "etalon": sexe_id = 36; break;
									case "jument": case "femelle": sexe_id = 38; break;
									case "male": sexe_id = 381; break;
								}
								$("#sex").val(sexe_id).change();
								// ---------------------------------------------
								alert('Données insérées');
								return false;
							}
							//console.log('DATAS : '+data);
						});
					}
					return false;
				});
			});
		</script>
		<div class="equipeer_clear"></div>
		<?php
	}
	
    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
	function type_save( $post_id ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		// Check if our nonce is set AND if that the nonce is valid
		if ( ! isset( $_POST['type_nonce'] ) || ! wp_verify_nonce( $_POST['type_nonce'], '_type_nonce' ) ) return;
		// Check the user's permissions
		if ( ! current_user_can( 'equipeer_edit_equine', $post_id ) ) return;
		// ---------------------------------------------
		// Update the meta field
		// ---------------------------------------------
		if ( isset( $_POST['to_expertise'] ) )
			update_post_meta( $post_id, 'to_expertise', '1' );
		else
			update_post_meta( $post_id, 'to_expertise', '0' );
		// ---------------------------------------------
		if ( isset( $_POST['sold'] ) )
			update_post_meta( $post_id, 'sold', '1' );
		else
			update_post_meta( $post_id, 'sold', '0' );
		// ---------------------------------------------
		if ( isset( $_POST['type_canasson'] ) )
			update_post_meta( $post_id, 'type_canasson', esc_attr($_POST['type_canasson']) );
		// ---------------------------------------------
		if ( isset( $_POST['discipline'] ) )
			update_post_meta( $post_id, 'discipline', esc_attr($_POST['discipline']) );
		// ---------------------------------------------
		if ( isset( $_POST['sex'] ) )
			update_post_meta( $post_id, 'sex', esc_attr($_POST['sex']) );		
		// ---------------------------------------------
		if ( isset($_POST['reference_start']) )
			update_post_meta( $post_id, 'reference', esc_attr( $this->get_last_reference() ) );
		else
			update_post_meta( $post_id, 'reference', esc_attr( $_POST['reference'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['sire'] ) )
			update_post_meta( $post_id, 'sire', esc_attr( $_POST['sire'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['type_annonce'] ) )
			update_post_meta( $post_id, 'type_annonce', esc_attr( $_POST['type_annonce'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['size_cm'] ) )
			update_post_meta( $post_id, 'size_cm', esc_attr( $_POST['size_cm'] ) );
		// ---------------------------------------------		
		if ( isset( $_POST['size'] ) )
			update_post_meta( $post_id, 'size', esc_attr( $_POST['size'] ) );
		// ---------------------------------------------		
		if ( isset( $_POST['breed'] ) )
			update_post_meta( $post_id, 'breed', esc_attr( $_POST['breed'] ) );
		// ---------------------------------------------	
		if ( isset( $_POST['dress'] ) )
			update_post_meta( $post_id, 'dress', esc_attr( $_POST['dress'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['birthday'] ) )
			update_post_meta( $post_id, 'birthday', esc_attr( $_POST['birthday'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['birthday_real'] ) )
			update_post_meta( $post_id, 'birthday_real', esc_attr( $_POST['birthday_real'] ) );
		// ---------------------------------------------
	}
	
}