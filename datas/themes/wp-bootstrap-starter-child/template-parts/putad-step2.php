<?php
// Informations vendeur
global $smartwizard_required_field, $smartwizard_step2_text2, $smartwizard_step2_text3;
// Post infos
$putadSire = trim($_POST['putadSire']);
$putadBirthdayReal = trim($_POST['putadBirthdayReal']);
$putadBirthday  = trim($_POST['putadBirthday']);
$putadBreed     = trim($_POST['putadBreed']);
$putadColor   = trim($_POST['putadColor']);
$putadZip       = trim($_POST['putadZip']);
$putadCity      = trim($_POST['putadCity']);
$putadCountry   = trim($_POST['putadCountry']);
// Autocomplete API Google Places (extend.js)
$putadStep2Latitude  = trim($_POST['putadStep2Latitude']);
$putadStep2Longitude = trim($_POST['putadStep2Longitude']);
// Get label options RANGE
$range_start       = number_format( get_option( 'equine_range_start' ), 0, "", "." );
$range_start_raw   = intval( get_option( 'equine_range_start' ) );
// ------------------------
$range_1_until     = number_format( get_option( 'equine_range_1_until' ), 0, "", "." );
$range_1_until_raw = intval( get_option( 'equine_range_1_until' ) );
// ------------------------
$range_2_until     = number_format( get_option( 'equine_range_2_until' ), 0, "", "." );
$range_2_until_raw = intval( get_option( 'equine_range_2_until' ) );
// ------------------------
$range_3_until     = number_format( get_option( 'equine_range_3_until' ), 0, "", "." );
$range_3_until_raw = intval( get_option( 'equine_range_3_until' ) );
// ------------------------
$range_4_until     = number_format( get_option( 'equine_range_4_until' ), 0, "", "." );
$range_4_until_raw = intval( get_option( 'equine_range_4_until' ) );
// ------------------------
?>

<style>
	#labelFREE, #labelEXPERTISE {
		display: none;
	}
	.putad_datepicker, .putad_datepicker_step3 {
		width: 200px;
		margin-left: 3em;
	}
	.ui-datepicker-trigger {
		padding: 0.2em 0.5em 0 0.3em;
		float: left;
		cursor: pointer;
		margin-top: -2.3em;
	}
	.basic-offer {
		border: 1px solid #0e2d4c;
		text-align: center;
	}
	.basic-offer-bg {
		background-color: #0e2d4c;
		color: white;
	}
	.premium-offer {
		border: 1px solid #d1023e;
		text-align: center;
	}
	.premium-offer-bg {
		background-color: #d1023e;
		color: white;
	}
</style>

<h2 class="mt-0"><?php _e('Horse General Information', EQUIPEER_ID); ?></h2>
<div class="row">
	<div class="col col-mob-100">
		<div class="form-group">
			<label for="putadSire"><?php _e('Identification number', EQUIPEER_ID); ?></label>
			<small id="putadSireHelp" class="form-text text-muted"><?php _e('Only for equines registered in France, once the SIRE number (without the letter) entered > validate with the "OK" button and some of the fields are automatically filled with the corresponding information', EQUIPEER_ID); ?></small>
		</div>
		<div class="form-row">
			<div class="form-group col-md-10">
				<input type="text" class="form-control" id="putadSire" name="putadSire" value="<?php echo $putadSire; ?>" aria-describedby="putadSireHelp">
			</div>
			<div class="form-group col-md-2">
				<button type="button" id="get-sire" class="eq-button eq-button-blue eq-cursor mb-2">OK</button>
			</div>
		</div>
		<div class="form-group">
			<label for="putadPostTitle"><?php echo __('Horse name', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<input type="text" class="form-control" id="putadPostTitle" name="putadPostTitle" value="<?php echo $putadPostTitle; ?>" aria-describedby="putadPostTitleHelp" required>
			<!--<small id="putadPostTitleHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>
		<div class="form-group">
			<label for="putadBirthdayReal"><?php echo __('Date of Birth', EQUIPEER_ID) . ' (Format ' . __('YYYY-MM-DD', EQUIPEER_ID) . ')' . $smartwizard_required_field; ?></label>
			<input type="text" class="form-control putad_datepicker simple-tooltip" id="putadBirthdayReal" name="putadBirthdayReal" value="<?php echo $putadBirthdayReal; ?>" aria-describedby="putadLastnameHelp" style="pointer-events: none !important; cursor: default;" placeholder="<?php _e('click on the icon', EQUIPEER_ID); ?>" required>
			<!--<small id="putadBirthdayRealHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
			<input type="hidden" id="putadBirthday" name="putadBirthday" value="">
		</div>
		<div class="form-group">
			<label for="putadBreed"><?php echo __('Breed', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<select class="form-control" id="putadBreed" name="putadBreed" aria-describedby="putadEmailHelp" required>
				<option value=""><?php _e('Choose breed', EQUIPEER_ID); ?></option>
				<?php
					// ---------------------------------------------
					$taxonomies_breed = equipeer_get_terms('equipeer_breed', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
					// ---------------------------------------------
					if ($taxonomies_breed) {
						foreach( $taxonomies_breed as $taxonomy ) {
							echo '<option value="' . $taxonomy['id'] . '">' . $taxonomy['name'] . '</option>';
						}
					}
				?>
			</select>
			<!--<small id="putadBreedHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>
		<div class="form-group">
			<label for="putadColor"><?php echo __('Color', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<select class="form-control" id="putadColor" name="putadColor" aria-describedby="putadColorHelp" required>
				<option value=""><?php _e('Choose color', EQUIPEER_ID); ?></option>
				<?php
					// ---------------------------------------------
					$taxonomies_dress = equipeer_get_terms('equipeer_color', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
					// ---------------------------------------------
					if ($taxonomies_dress) {
						foreach( $taxonomies_dress as $taxonomy ) {
							echo '<option value="' . $taxonomy['id'] . '">' . $taxonomy['name'] . '</option>';
						}
					}
				?>
			</select>
			<!--<small id="putadColorHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>
		<div class="form-group">
			<label for="putadSize"><?php echo __('Size', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<select class="form-control disabled-events" id="putadSize" name="putadSize" aria-describedby="putadSizeHelp" required>
				<option value=""><?php _e('Choose size', EQUIPEER_ID); ?></option>
				<?php
					// ---------------------------------------------
					$taxonomies_size = equipeer_get_terms('equipeer_size', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
					// ---------------------------------------------
					if ($taxonomies_size) {
						foreach( $taxonomies_size as $taxonomy ) {
							echo '<option value="' . $taxonomy['id'] . '">' . $taxonomy['name'] . '</option>';
						}
					}
				?>
			</select>
			<!--<input type="hidden" id="putadSizeCm" name="putadSizeCm" value="">-->
			<!--<small id="putadSizeHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>
		<div class="form-group">
			<label for="putadSizeCm"><?php echo __('Size', EQUIPEER_ID) . " (cm)" . $smartwizard_required_field; ?></label>
			<input type="number" class="form-control" id="putadSizeCm" name="putadSizeCm" value="<?php echo $putadSizeCm; ?>" aria-describedby="putadSizeCmHelp" required>
			<!--<small id="putadSizeCmHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>

	</div>
	<div class="col col-mob-100" id="putadStep2">
		<div class="form-group">
			<label for="putadSex"><?php echo __('Sex', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<select class="form-control" id="putadSex" name="putadSex" aria-describedby="putadSexHelp" required>
				<option value=""><?php _e('Choose sex', EQUIPEER_ID); ?></option>
				<?php
				// ---------------------------------------------
					$taxonomies_gender = get_terms( array(
						'taxonomy' => 'equipeer_gender',
						'hide_empty' => false
					) );
					// ---------------------------------------------
					if ($taxonomies_gender) {
						foreach( $taxonomies_gender as $taxonomy ) {
							echo '<option value="' . $taxonomy->term_id . '">' . $taxonomy->name . '</option>';
						}
					}
				?>
			</select>
			<!--<small id="putadSexHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>
		<div class="form-group">
			<label for="putadDiscipline"><?php echo __('Discipline', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<select class="form-control" id="putadDiscipline" name="putadDiscipline" aria-describedby="putadDisciplineHelp" required>
				<option value=""><?php _e('Choose category', EQUIPEER_ID); ?></option>
				<?php
					// ---------------------------------------------
					$taxonomies_discipline = equipeer_get_terms('equipeer_discipline', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
					// ---------------------------------------------
					if ($taxonomies_discipline) {
						foreach( $taxonomies_discipline as $taxonomy ) {
							echo '<option value="' . $taxonomy['id'] . '">' . $taxonomy['name'] . '</option>';
						}
					}
				?>
			</select>
			<!--<small id="putadDisciplineHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>
		<!--<div class="form-group">
			<label for="putadTypeCanasson"><?php echo __('Type', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<select class="form-control" id="putadTypeCanasson" name="putadTypeCanasson" aria-describedby="putadTypeCanassonHelp" required>
				<option value=""><?php _e('Choose an equine type', EQUIPEER_ID); ?></option>
				<?php
					$all_type_canassons = equipeer_get_all_type_horses();
					if ($all_type_canassons) {
						foreach( $all_type_canassons as $row ) {
							echo '<option value="' . $row['value'] . '">';
							echo $row['name'];
							echo '</option>';
						}
					}
				?>
			</select>
			<small id="putadTypeCanassonHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>
		</div>-->
		
		<label for="autocomplete"><?php echo __('Fill in city', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
			</div>
			<input type="text" class="form-control autocomplete" id="autocomplete" name="autocomplete" placeholder="<?php _e('Indicate a city', EQUIPEER_ID); ?>" value="" aria-describedby="putadAutocompleteHelp" required>
			<!--<small id="putadZipHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
			<input type="hidden" class="street_number" id="putadStep2StreetNumber" value="">
			<input type="hidden" class="route" id="putadStep2Address" value="">
			<input type="hidden" id="putadStep2Latitude" value="">
			<input type="hidden" id="putadStep2Longitude" value="">
			<input type="hidden" id="putadTypeCanasson" name="putadTypeCanasson" value="horse">
		</div>
		<div class="form-group">
			<label for="putadHorseZip"><?php echo __('Localization - Postal code', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<input type="text" class="form-control postal_code" id="putadHorseZip" name="putadHorseZip" value="<?php echo $putadHorseZip; ?>" aria-describedby="putadHorseZipHelp">
			<!--<small id="putadHorseZipHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>
		<div class="form-group">
			<label for="putadHorseCity"><?php echo __('Localization - City', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<input type="text" class="form-control locality" id="putadHorseCity" name="putadHorseCity" value="<?php echo $putadHorseCity; ?>" aria-describedby="putadHorseCityHelp">
			<!--<small id="putadHorseCityHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>
		<div class="form-group">
			<label for="putadHorseCountry"><?php echo __('Localization - Country', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<input type="text" class="form-control country" id="putadHorseCountry" name="putadHorseCountry" value="<?php echo $putadHorseCountry; ?>" aria-describedby="putadHorseCountryHelp">
			<!--<small id="putadHorseCountryHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>
	</div>
</div>
<div class="row">
	<div class="col col-mob-100">
		<div class="form-group">
			<!-- Decrivez votre cheval en 140 caracteres maximum -->
			<label for="putadImpression"><?php echo __('Strong points', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<textarea type="text" class="form-control" id="putadImpression" name="putadImpression" aria-describedby="putadImpressionHelp" placeholder="<?php _e('Describe your horse in 280 characters maximum', EQUIPEER_ID); ?>" onkeyup="countChar(280)" required><?php echo $putadImpression; ?></textarea>
			<div id="charNum" style="color: grey; margin-bottom: 0.5em; margin-top: 0em; display: block; height: 15px; font-size: 0.7em;">280</div>
			<!--<small id="putadImpressionHelp" class="form-text text-muted">Décrivez votre cheval en 140 caractères maximum</small>-->
		</div>
	</div>
</div>

<h2 class="mt-4"><?php _e('Expertise EQUIPEER with my horse', EQUIPEER_ID); ?></h2>
<div class="row">
	<div class="col col-mob-100">
		<?php echo nl2br($smartwizard_step2_text2); ?>
	</div>
</div>
<div class="row mt-4">
	<div class="col col-mob-100">
		<div class="card basic-offer">
			<div class="card-header basic-offer-bg">
				<h4><?php _e('BASIC Offer', EQUIPEER_ID); ?></h4>
				<?php _e("Free ad management", EQUIPEER_ID); ?>
			</div>
			<div class="card-body">
				<!--<label for="FREE"><?php _e("Free ad management", EQUIPEER_ID); ?></label>-->
				<input type="radio" id="FREE" name="putadTypeAnnonce" value="1">
			</div>
		</div>
	</div>
	<div class="col col-mob-100">
		<div class="card premium-offer">
			<div class="card-header premium-offer-bg">
				<h4><?php _e('PREMIUM Offer', EQUIPEER_ID); ?></h4>
				<?php _e("Management of the ad by EQUIPEER", EQUIPEER_ID); ?>
			</div>
			<div class="card-body">
				<!--<label for="EXPERTISE"><?php _e("Management of the ad by EQUIPEER", EQUIPEER_ID); ?></label>-->
				<input type="radio" id="EXPERTISE" name="putadTypeAnnonce" value="2">
			</div>
		</div>
	</div>
</div>

<fieldset id="prixdevente" disabled>
	<div class="row">
		<div class="col col-mob-100">
			<h2 class="mt-4"><?php _e('Horse selling price', EQUIPEER_ID); ?></h2>
		</div>
	</div>
	<div class="row">
		<div class="col col-mob-100">
			<div class="form-group">
				<input type="radio" id="TVA" name="putadPriceTvaTauxChoice" value="1">
				<label for="TVA"><?php _e("The horse is subject to VAT", EQUIPEER_ID); ?></label>
				<br>
				<input type="radio" id="NOTVA" name="putadPriceTvaTauxChoice" value="0">
				<label for="NOTVA"><?php _e("The horse is not subject to VAT", EQUIPEER_ID); ?></label><br>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col col-mob-100">
			<div class="form-row">
				<div class="form-group col-md-5">
					<label for="putadPriceReal"><?php echo __('NET seller selling price in Euro', EQUIPEER_ID) . ' (' . __('excluding VAT', EQUIPEER_ID) . ') ' . $smartwizard_required_field; ?></label>
					<div class="input-group">
						<div class="input-group-prepend">
						  <span class="input-group-text">&euro;</span>
						</div>
						<input type="number" class="form-control" id="putadPriceReal" name="putadPriceReal" value="" aria-describedby="putadPriceRealHelp" placeholder="<?php _e('Minimum 5 000&euro;', EQUIPEER_ID); ?>" required>
						<input type="hidden" id="putadPriceCommission" name="putadPriceCommission" value="">
						<input type="hidden" id="putadPriceWithTva" name="putadPriceWithTva" value="">
						<!--<small id="putadPriceRealHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="putadPriceTvaTaux"><?php echo __('VAT', EQUIPEER_ID); ?></label>
					<div class="input-group">
						<div class="input-group-prepend">
						  <span class="input-group-text">%</span>
						</div>
						<input type="number" class="form-control" id="putadPriceTvaTaux" name="putadPriceTvaTaux" min="0" value="20" aria-describedby="putadPriceTvaTauxHelp" disabled>
						<!--<small id="putadPriceTvaTauxHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
					</div>
				</div>
				<div class="form-group col-md-5">
					<label for="putadPriceEquipeer"><span id="labelFE">&nbsp;</span><span id="labelFREE"><?php echo __('Free deposit sale price', EQUIPEER_ID); ?></span><span id="labelEXPERTISE"><?php echo __('Selling price in appraised deposit', EQUIPEER_ID); ?></span></label>
					<div class="input-group">
						<div class="input-group-prepend">
						  <span class="input-group-text">&euro;</span>
						</div>
						<input type="number" class="form-control" id="putadPriceEquipeer" name="putadPriceEquipeer" value="<?php echo $putadPriceEquipeer; ?>" aria-describedby="putadPriceEquipeerHelp" style="pointer-events: none !important; cursor: default; background-color: #eee;">
					</div>
					<small id="putadPriceEquipeerHelp" class="form-text text-muted font-italic"><?php _e('Price including VAT, Equipeer SPORT fees included', EQUIPEER_ID); ?></small>
				</div>
			</div>
		</div>
	</div>
	<?php if (trim($smartwizard_step2_text3) != '') { ?>
	<div class="row mt-3">
		<div class="col col-mob-100">
			<?php echo nl2br($smartwizard_step2_text3); ?>
		</div>
	</div>
	<?php } ?>
	<div class="row mt-4">
		<div class="col col-mob-100">
			<h4 class="eq-red" style="font-size: 1rem;"><?php _e("Your horse will be displayed in the price range:", EQUIPEER_ID); ?> <span id="price-range">0 &euro;</span></h4>
		</div>
	</div>
	<div class="row">
		<div class="col col-mob-100">
			<small class="description d-block" style="color: #444 !important;"><?php echo sprintf( __('%s required fields', EQUIPEER_ID), '<span style="color: red;">*</span>' ); ?></small>
		</div>
	</div>
</fieldset>
	
<!-- Datepicker -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
	// --------------------------------------
	// Calculate Sell price
	// Ex: 10.000 + 10% TVA (1.000) = 11.000 + Commission 15% (1.650) = 12.650
	// putadPriceReal : 10.000
	// putadPriceTvaTaux : 10 (1.000)
	// putadPriceEquipeer : 11.000
	// Commission : 1.650 
	// --------------------------------------
	function prixdevente() {
		var prix_de_vente = parseInt( jQuery('#putadPriceReal').val() );
		var is_tva        = jQuery('input[name="putadPriceTvaTauxChoice"]:checked').val();
		var taux_tva      = parseFloat( jQuery('#putadPriceTvaTaux').val() );
		// Calculate
		var price_equipeer = (!is_tva) ? prix_de_vente : parseInt( prix_de_vente + ((prix_de_vente / 100) * parseInt(taux_tva)) );
		// Commission
		var is_free_ad = jQuery('input[name="putadTypeAnnonce"]:checked').val();
		var commission = (is_free_ad == '1') ? parseInt(<?php echo get_option('equine_commission_annonce_libre'); ?>) : parseInt(<?php echo get_option('equine_commission_annonce_expertise'); ?>);
		// Total price
		var total_price = parseInt( price_equipeer + ((price_equipeer / 100) * commission) );
		// Price range
		price_range(total_price);
		
		if (isNaN(total_price) == true) {
			jQuery("#putadPriceEquipeer").val(0);
		} else {
			jQuery("#putadPriceEquipeer").val(total_price);
			jQuery("#putadPriceWithTva").val(price_equipeer);
		}
	}
	
	// --------------------------------------
	// Count characters
	// --------------------------------------
	function countChar(count) {
		var val = document.getElementById('putadImpression');
		var len = val.value.length;
		if (len >= count) {
			val.value = val.value.substring(0, count);
		} else {
			jQuery('#charNum').text(count - len);
		}
	}
	
	// --------------------------------------
	// Get size range
	// --------------------------------------
	function get_tranche_size(new_size) {
		if (new_size === null) return false;
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
		jQuery( "#putadSize" ).val(tranche_id).change();
		//return false;
	}
	
	// --------------------------------------
	// Changement de tranche si taille cm change
	// --------------------------------------
	jQuery( "#putadSizeCm" ).on( 'change keyup', function() {
		get_tranche_size( jQuery("#putadSizeCm").val() );
	});
	
	// --------------------------------------
	// Gestion de l'annonce (FREE - EXPERTISE)
	// --------------------------------------
	jQuery("#FREE").on('click', function() {
		jQuery('#prixdevente').removeAttr('disabled');
		jQuery("#labelEXPERTISE, #labelFE").css('display', 'none');
		jQuery("#labelFREE").css('display', 'block');
		prixdevente();
	});
	jQuery("#EXPERTISE").on('click', function() {
		jQuery('#prixdevente').removeAttr('disabled');
		jQuery("#labelFREE, #labelFE").css('display', 'none');
		jQuery("#labelEXPERTISE").css('display', 'block');
		prixdevente();
	});
	
	// --------------------------------------
	// Keyup
	// --------------------------------------
	jQuery('#putadPriceReal, #putadPriceTvaTaux').on('keyup change', function() {
		prixdevente();
	});
	
	// --------------------------------------
	// TVA or NOT
	// --------------------------------------
	jQuery("#TVA").on('click', function() {
		jQuery('#putadPriceTvaTaux').removeAttr('disabled');
		prixdevente();
	});
	jQuery("#NOTVA").on('click', function() {
		jQuery('#putadPriceTvaTaux').attr('disabled', 'disabled');
		jQuery('#putadPriceTvaTaux').val(0);
		prixdevente();
	});
	
	// --------------------------------------	
	// Price Range
	// --------------------------------------
	// Initialize text price range
	var price_range_1 = "<?php echo $range_start; ?>&euro; <?php _e('to', EQUIPEER_ID); ?> <?php echo $range_1_until; ?>&euro;"; 
	var price_range_2 = "<?php echo $range_1_until; ?>&euro; <?php _e('to', EQUIPEER_ID); ?> <?php echo $range_2_until; ?>&euro;"; 
	var price_range_3 = "<?php echo $range_2_until; ?>&euro; <?php _e('to', EQUIPEER_ID); ?> <?php echo $range_3_until; ?>&euro;"; 
	var price_range_4 = "<?php echo $range_3_until; ?>&euro; <?php _e('to', EQUIPEER_ID); ?> <?php echo $range_4_until; ?>&euro;"; 
	var price_range_5 = "> <?php echo $range_4_until; ?>&euro;";
	// Function
	function price_range(new_price) {
		// Check if new_price is a number
		if (isNaN(new_price) == true) return;

		var new_range_price = 0;
		if ( new_price <= <?php echo $range_1_until_raw; ?> ) {
			new_range_price = 1;
			show_range = price_range_1;
		} else if ( new_price <= <?php echo $range_2_until_raw; ?> ) {
			new_range_price = 2;
			show_range = price_range_2;
		} else if ( new_price <= <?php echo $range_3_until_raw; ?> ) {
			new_range_price = 3;
			show_range = price_range_3;
		} else if ( new_price <= <?php echo $range_4_until_raw; ?> ) {
			new_range_price = 4;
			show_range = price_range_4;
		} else {
			new_range_price = 5;
			show_range = price_range_5;
		}
		jQuery('#price-range').html( show_range ); // Text
	}
	
	// --------------------------------------
	// Datepicker (Date of birth)
	// --------------------------------------
	jQuery( ".putad_datepicker" ).datepicker({
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
			jQuery('#putadBirthdayReal').val( d ); // Complete date
			// ----------------------------------
			// Return ONLY year
			var only_year = d.substring(0, 4);
			jQuery('#putadBirthday').val( only_year );
			// ----------------------------------
		}
	});
	
	// --------------------------------------
	// Get SIRE Infos
	// --------------------------------------
	jQuery('#get-sire').on('click', function() {
		var num_sire = jQuery('#putadSire').val();
		if (!num_sire) {
			Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e("You must enter a SIRE to perform a search", EQUIPEER_ID); ?>", "error" );
		} else {
			// --------------------------------------
			// Get DATAS (JSON)
			// --------------------------------------
			var ajax_get_sire = jQuery.get( "<?php echo get_site_url(); ?>/wp-getsire.php", { sire: num_sire, from: 'front'} ).done(function( data ) {
				// ---------------------------------------------
				// Si erreur, renvoie ce message :
				// "Incorrect SIRE number ! There is two formats allowed : 1) 2 letters + 4 numbers - 2) 8 numbers"
				// ---------------------------------------------
				var search_errors = data.search(/incorrect sire number/i);
				// ---------------------------------------------
				// --- Check if ERROR
				if (search_errors == 0) {
					//console.log('ERREUR SIRE 1');
					Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e("The SIRE number must be 8 digits", EQUIPEER_ID); ?>", "error" );
					return false;
				}
				// ---------------------------------------------
				var equide = jQuery.parseJSON(data);
				//console.log('DATAS : '+data);
				// ---------------------------------------------
				// Deuxieme erreur de merde (!!!!!!)
				// Si SIRE 8 chiffres mais en renvoie que des null
				// ---------------------------------------------
				if (equide.date == null && equide.nom == null && equide.race == null && equide.robe == null && equide.taille == null && equide.sexe == null && equide.sireN == null && equide.sireK == null) {
					//console.log('ERREUR SIRE 2');
					Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e("No information concerning this SIRE number", EQUIPEER_ID); ?>", "error" );
					return false;
				}
				// ---------------------------------------------
				var date_explode  = equide.date.split("-");
				//var date_expl_new = date_expl_new.replace(/-/g, '/');
				var new_date      = date_explode[2]+"/"+date_explode[1]+"/"+date_explode[0];
				// ---------------------------------------------
				//var new_nom = equide.nom.split(' ').join('-');
				var new_robe = equide.robe.split(' ').join('-');
				// ---------------------------------------------
				var equide_txt = "";
				equide_txt += "<br>";
				equide_txt += "Sire : "+equide.sireN+equide.sireK+"<br><br>";
				equide_txt += "<?php _e('Date of Birth', EQUIPEER_ID); ?> : "+new_date+"<br>";
				equide_txt += "<?php _e('Name', EQUIPEER_ID); ?> : "+equide.nom+"<br>";
				equide_txt += "<?php _e('Breed', EQUIPEER_ID); ?> : "+equide.race+"<br>";
				equide_txt += "<?php _e('Color', EQUIPEER_ID); ?> : "+equide.robe+"<br>";
				equide_txt += "<?php _e('Size', EQUIPEER_ID); ?> : "+equide.taille+" cm<br>";
				equide_txt += "<?php _e('Gender', EQUIPEER_ID); ?> : "+equide.sexe+"<br>";
				// ---------------------------------------------
				//var r_equide = confirm('Insérez les informations suivantes :'+equide_txt);
				
				
				Swal.fire({
					title: '<?php _e('SIRE Result', EQUIPEER_ID); ?>',
					html: "Insérez les informations suivantes :<br>"+equide_txt,
					icon: 'info',
					showCancelButton: true,
					confirmButtonColor: '#5cb85c',
					cancelButtonColor: '#d33',
					confirmButtonText: '<?php _e('Yes'); ?>',
					cancelButtonText: '<?php _e('No'); ?>'
				}).then((result) => {
					if (result.value) {
						// Insert DATAS
						// ---------------------------------------------
						jQuery("input[id=putadSire]").val(equide.sireN);
						// ---------------------------------------------
						jQuery("input[id=putadBirthdayReal]").val(equide.date);
						jQuery("input[id=putadBirthday]").val(date_explode[0]);
						var year = new Date().getFullYear();
						var age  = year - date_explode[0];
						jQuery('#real_age').val( age + ' ans' );
						// ---------------------------------------------
						jQuery("input[id=putadPostTitle]").val(equide.nom);
						//jQuery("#title-prompt-text").hide();
						// ---------------------------------------------
						jQuery("input[id=putadSizeCm]").val(equide.taille);
						get_tranche_size(equide.taille);
						// ---------------------------------------------
						// Race
						// ---------------------------------------------
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
							case "selle-francais": case "selle francais": case "selle francais section a": race_id = 108; break;
							default: race_id = 0; break;
						}
						if (race_id > 0) jQuery("#putadBreed").val(race_id).change();
						// ---------------------------------------------
						// Robe
						// ---------------------------------------------
						switch(new_robe.toLowerCase()) {
							case "alezan": case "alezan crins laves": case "alezan-crins-laves": case "alezan melange": case "alezan brule": case "alezan-brule": robe_id = 116; break;
							case "bai": robe_id = 117; break;
							case "bai-brun": case "bai brun": case "bai-fonce": case "bai fonce": robe_id = 118; break;
							case "noir-pangare": case "noir": case "noir pangare": robe_id = 121; break;
							case "gris": robe_id = 120; break;
							case "pie": robe_id = 123; break;
							case "isabelle": robe_id = 484; break;
							default: robe_id = 0; break;
						}
						if (robe_id > 0) jQuery("#putadColor").val(robe_id).change();
						// ---------------------------------------------
						// Sexe
						// ---------------------------------------------
						switch(equide.sexe.toLowerCase()) {
							case "hongre": sexe_id = 37; break;
							case "etalon": sexe_id = 36; break;
							case "jument": case "femelle": sexe_id = 38; break;
							case "male": sexe_id = 381; break;
							default: sexe_id = 0; break;
						}
						if (sexe_id > 0) jQuery("#putadSex").val(sexe_id).change();
						// ---------------------------------------------
						Swal.fire( "<?php _e("Well done", EQUIPEER_ID); ?>", "<?php _e("Inserted data", EQUIPEER_ID); ?>", "success" );
						// ---------------------------------------------
						return false;
					}
				});
			});
		}
		return false;
	});
</script>