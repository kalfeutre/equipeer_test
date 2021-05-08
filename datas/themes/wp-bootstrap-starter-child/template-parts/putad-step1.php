<?php
// Informations vendeur
global $smartwizard_required_field;
// Check if user is connected
if (is_user_logged_in()) {
	$user_info      = get_userdata( get_current_user_id() );
	$putadFirstname = $user_info->first_name;
	$putadLastname  = $user_info->last_name;
	$putadEmail     = $user_info->user_email;
	$putadPhone     = $user_info->equipeer_user_telephone;
	$putadAddress   = $user_info->equipeer_user_address_1;
	$putadZip       = $user_info->equipeer_user_zip;
	$putadCity      = $user_info->equipeer_user_city;
	$putadCountry   = $user_info->equipeer_user_country;
} else {
	//$putadFirstname = trim($_POST['putadFirstname']);
	//$putadLastname  = trim($_POST['putadLastname']);
	//$putadEmail     = trim($_POST['putadEmail']);
	//$putadPhone     = trim($_POST['putadPhone']);
	//$putadAddress   = trim($_POST['putadAddress']);
	//$putadZip       = trim($_POST['putadZip']);
	//$putadCity      = trim($_POST['putadCity']);
	//$putadCountry   = trim($_POST['putadCountry']);
}
//$putadContactByPhone = intval($_POST['putadContactByPhone']);
//$putadContactByEmail = intval($_POST['putadContactByEmail']);
// Autocomplete API Google Places (extend.js)
//$putadLatitude       = trim($_POST['putadLatitude']);
//$putadLongitude      = trim($_POST['putadLongitude']);
?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/vendor/intltelinput/css/prism.css">
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/vendor/intltelinput/css/intlTelInput.css">
<style>
	#putadPhone-error-msg {
	  color: red;
	}
	#putadPhone-valid-msg {
	  color: #00C900;
	}
	input.error {
	  border: 1px solid #FF7C7C;
	}
	.hide {
	  display: none;
	}
</style>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/vendor/intltelinput/js/prism.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/vendor/intltelinput/js/intlTelInput.js"></script>
<script>
	jQuery(document).ready(function() {
		var input = document.querySelector("#putadPhone"),
		  errorMsg = document.querySelector("#putadPhone-error-msg"),
		  validMsg = document.querySelector("#putadPhone-valid-msg");
		// here, the index maps to the error code returned from getValidationError - see readme
		var errorMap = ["<?php _e("Invalid number", EQUIPEER_ID); ?>", "<?php _e("Invalid country code", EQUIPEER_ID); ?>", "<?php _e("Too short", EQUIPEER_ID); ?>", "<?php _e("Too long", EQUIPEER_ID); ?>", "<?php _e("Invalid number", EQUIPEER_ID); ?>"];
		
		// initialise plugin
		var iti = window.intlTelInput(input, {
			// allowDropdown: false,
			// autoHideDialCode: false,
			// autoPlaceholder: "off",
			// dropdownContainer: document.body,
			// excludeCountries: ["us"],
			// formatOnDisplay: false,
			// geoIpLookup: function(callback) {
			//   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
			//     var countryCode = (resp && resp.country) ? resp.country : "";
			//     callback(countryCode);
			//   });
			// },
			// hiddenInput: "full_number",
			initialCountry: 'fr', // Country in 2 characters | auto
			// localizedCountries: { 'de': 'Deutschland' },
			 nationalMode: false,
			// onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
			placeholderNumberType: 'MOBILE', // MOBILE | FIXED_LINE
			// preferredCountries: ['cn', 'jp'],
			 separateDialCode: true,
			utilsScript: "<?php echo get_stylesheet_directory_uri(); ?>/vendor/intltelinput/js/utils.js"
		});
		
		var reset = function() {
			input.classList.remove("error");
			errorMsg.innerHTML = "";
			errorMsg.classList.add("hide");
			validMsg.classList.add("hide");
		};
		
		// on blur: validate
		input.addEventListener('blur', function() {
			reset();
			if (input.value.trim()) {
				if (iti.isValidNumber()) {
					validMsg.classList.remove("hide");
				} else {
					input.classList.add("error");
					var errorCode = iti.getValidationError();
					errorMsg.innerHTML = errorMap[errorCode];
					errorMsg.classList.remove("hide");
				}
			}
		});
		
		// on keyup / change flag: reset
		input.addEventListener('change', reset);
		input.addEventListener('keyup', reset);

	});
</script>

<h2 class="mt-0"><?php _e('Seller Information', EQUIPEER_ID); ?></h2>
<div class="row">
	<div class="col col-mob-100">
		<div class="form-group">
			<label for="putadFirstname"><?php echo __('Firstname', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<input type="text" class="form-control" id="putadFirstname" name="putadFirstname" value="<?php echo $putadFirstname; ?>" aria-describedby="putadFirstnameHelp" required<?php if ($putadFirstname != '') echo ' disabled'; ?>>
			<input type="hidden" id="putadFirstnameH" name="putadFirstnameH" value="<?php echo $putadFirstname; ?>">
			<!--<small id="putadFirstnameHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>
		<div class="form-group">
			<label for="putadLastname"><?php echo __('Lastname', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<input type="text" class="form-control" id="putadLastname" name="putadLastname" value="<?php echo $putadLastname; ?>" aria-describedby="putadLastnameHelp" required<?php if ($putadLastname != '') echo ' disabled'; ?>>
			<input type="hidden" id="putadLastnameH" name="putadLastnameH" value="<?php echo $putadLastname; ?>">
			<!--<small id="putadLastnameHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>
		<div class="form-group">
			<label for="putadPhone"><?php echo __('Phone', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<br>
			<input type="tel" class="form-control" id="putadPhone" name="putadPhone" value="<?php echo $putadPhone; ?>" aria-describedby="putadPhoneHelp" required>
			<span id="putadPhone-valid-msg" class="hide">✓ <?php _e('Valid', EQUIPEER_ID); ?></span>
			<span id="putadPhone-error-msg" class="hide"></span>
			<!--<small id="putadPhoneHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>
		<div class="form-group">
			<label for="putadEmail"><?php echo __('Email', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<input type="email" class="form-control" id="putadEmail" name="putadEmail" value="<?php echo $putadEmail; ?>" aria-describedby="putadEmailHelp" disabled>
			<input type="hidden" id="putadEmailH" name="putadEmailH" value="<?php echo $putadEmail; ?>">
			<!--<small id="putadEmailHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>
		<label for="contacted">&nbsp;&nbsp;</label>
		<div class="form-group form-check">
			<?php _e('I prefer to be contacted by', EQUIPEER_ID); ?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="putadContactByEmail" name="putadContactByEmail" <?php checked( $putadContactByEmail, 1 ); ?> checked="">
			<label class="form-check-label" for="putadContactByEmail"><?php _e('Email', EQUIPEER_ID); ?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="putadContactByPhone" name="putadContactByPhone" <?php checked( $putadContactByPhone, 1 ); ?>>
			<label class="form-check-label" for="putadContactByPhone"><?php _e('Phone', EQUIPEER_ID); ?></label>
			&nbsp;
			<?php echo $smartwizard_required_field; ?>
		</div>
		<div style="margin-top: .5rem !important;">
			<small class="description d-block" style="color: #444 !important;"><?php echo sprintf( __('%s required fields', EQUIPEER_ID), '<span style="color: red;">*</span>' ); ?></small>
		</div>
		<div style="height: 50px;">&nbsp;</div>
	</div>
	<div class="col col-mob-100" id="putadStep1">
		<label for="autocomplete"><?php _e('Fill in city', EQUIPEER_ID); ?></label>
		<div class="input-group mb-3">
			<div class="input-group-prepend">
			  <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
			</div>
			<input type="text" class="form-control autocomplete" id="autocomplete" placeholder="<?php _e('Indicate a city', EQUIPEER_ID); ?>" name="autocomplete" value="" aria-describedby="putadAutocompleteHelp" required>
			<!--<small id="putadZipHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>
		<!--<div class="form-group">-->
			<!--<label for="putadAddress"><?php echo __('Address', EQUIPEER_ID); ?></label>-->
			<!--<input type="text" class="form-control route" id="putadAddress" name="putadAddress" value="<?php echo $putadAddress; ?>" aria-describedby="putadAddressHelp">-->
			<!--<small id="putadAddressHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
			<!--<input type="hidden" class="street_number" id="street_number" value="">-->
			<!--<input type="hidden" id="putadLatitude" value="<?php echo $putadLatitude; ?>">-->
			<!--<input type="hidden" id="putadLongitude" value="<?php echo $putadLongitude; ?>">-->
		<!--</div>-->
		<div class="form-group">
			<label for="putadZip"><?php echo __('Zip', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<input type="text" class="form-control postal_code" id="putadZip" name="putadZip" value="<?php echo $putadZip; ?>" aria-describedby="putadZipHelp" required>
			<!--<small id="putadZipHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>
		<div class="form-group">
			<label for="putadCity"><?php echo __('City', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<input type="text" class="form-control locality" id="putadCity" name="putadCity" value="<?php echo $putadCity; ?>" aria-describedby="putadCityHelp" required>
			<!--<small id="putadCityHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>
		<div class="form-group">
			<label for="putadCountry"><?php echo __('Country', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<input type="text" class="form-control country" id="putadCountry" name="putadCountry" value="<?php echo $putadCountry; ?>" aria-describedby="putadCountryHelp" required>
			<!--<small id="putadCountryHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>
	</div>
</div>
<!--<div class="row">
	<div class="col">
		<div class="form-group form-check">
			<?php _e('I prefer to be contacted by', EQUIPEER_ID); ?>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="putadContactByEmail" name="putadContactByEmail" <?php checked( $putadContactByEmail, 1 ); ?>>
			<label class="form-check-label" for="putadContactByEmail"><?php _e('Email', EQUIPEER_ID); ?></label>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="checkbox" class="form-check-input" id="putadContactByPhone" name="putadContactByPhone" <?php checked( $putadContactByPhone, 1 ); ?>>
			<label class="form-check-label" for="putadContactByPhone"><?php _e('Phone', EQUIPEER_ID); ?></label>
		</div>
	</div>
</div>-->