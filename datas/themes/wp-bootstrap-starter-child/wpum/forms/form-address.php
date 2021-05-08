<?php
/**
 * The Template for displaying the address form
 *
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

global $wpdb;

$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$table     = $wpdb->prefix . 'eqsearch_save';
$user_id   = get_current_user_id();

?>

<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/vendor/intltelinput/css/prism.css">
<link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/vendor/intltelinput/css/intlTelInput.css">

<style>
	#equipeer_user_telephone-error-msg {
	  color: red;
	}
	#equipeer_user_telephone-valid-msg {
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
	function phone_prefix() {
		var phone_prefix = jQuery('.iti__selected-dial-code').html();
		jQuery('#phone_prefix').val('');
		jQuery('#phone_prefix').val(phone_prefix + jQuery('#equipeer_user_telephone').val());
	}

	jQuery(document).ready(function() {
		var input = document.querySelector("#equipeer_user_telephone"),
		  errorMsg = document.querySelector("#equipeer_user_telephone-error-msg"),
		  validMsg = document.querySelector("#equipeer_user_telephone-valid-msg");
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
		
		// Onsubmit form
		jQuery("#wpum-submit-address-form").on("submit", function() {
			// Check TEL
			if (iti.isValidNumber()) {
				//console.log('valid number');
				phone_prefix();
			} else {
				// console.log('error number');
                Swal.fire( {
                  title: "<?php _e('Oops', EQUIPEER_ID); ?>",
                  html: "<?php _e('Phone error', EQUIPEER_ID); ?>",
                  icon: 'error',
                  confirmButtonColor: '#0e2d4c'
                } );
				return false;
			}
		});
		
		var reset = function() {
			input.classList.remove("error");
			errorMsg.innerHTML = "";
			errorMsg.classList.add("hide");
			validMsg.classList.add("hide");
			phone_prefix();
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

<div class="wpum-template wpum-form">

	<h2><?php echo __('Address / Phone', EQUIPEER_ID) . ' / Newsletter'; ?></h2>
	
	<?php
		#################################################
		# Include the Sendinblue library
		#################################################
		require_once( EQUIPEER_DIR . "lib/sendinblue-api-v3-sdk/autoload.php" );
		#################################################
		# Get API V3 SDK
		#################################################
		$api_key = trim( get_option('equine_send_in_blue_api_key') );
		#################################################
		# Configure API key authorization: api-key
		#################################################
		$config = SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey("api-key", "$api_key");
		#################################################
		# Account API
		#################################################
		$apiInstance = new SendinBlue\Client\Api\ContactsApi(
			// If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
			// This is optional, `GuzzleHttp\Client` will be used as default.
			new GuzzleHttp\Client(),
			$config
		);
		$current_user_infos = wp_get_current_user();
		$SID_identifier     = $current_user_infos->user_email; // string | Email (urlencoded) OR ID of the contact OR its SMS attribute value
		$SID_listId         = trim( get_option('equine_send_in_blue_list_id') ); // int | Id of the list
		$SID_debug          = false;
	?>

	<!-- SUCCESS / ERROR MESSAGE -->
	<?php
		if( $_POST ) {
			update_usermeta( get_current_user_id(), 'equipeer_user_address_1', $_POST['equipeer_user_address_1'] );
			update_usermeta( get_current_user_id(), 'equipeer_user_address_2', $_POST['equipeer_user_address_2'] );
			update_usermeta( get_current_user_id(), 'equipeer_user_zip', $_POST['equipeer_user_zip'] );
			update_usermeta( get_current_user_id(), 'equipeer_user_city', $_POST['equipeer_user_city'] );
			update_usermeta( get_current_user_id(), 'equipeer_user_country', $_POST['equipeer_user_country'] );
			update_usermeta( get_current_user_id(), 'equipeer_user_telephone', $_POST['phone_prefix'] );
			
			// ---------------------------
			// --- SEND IN BLUE
			// ---------------------------
			$post_newsletter = trim( $_POST['equipeer_user_newsletter'] );
			if ( isset($post_newsletter) && $post_newsletter == $SID_listId) {
				# ------------------------------------
				# Create contact if not exists in CONTACTS
				# ------------------------------------
				try {
					$createContactArgs = [
						'email' => $SID_identifier
					];
					$createContact = new \SendinBlue\Client\Model\CreateContact($createContactArgs); // \SendinBlue\Client\Model\CreateContact | Values to create a contact
					$result = $apiInstance->createContact($createContact);
					if ($SID_debug) print_r($result);
				} catch (Exception $e) {
					if ($SID_debug) echo 'Exception when calling AccountApi->addContactToList: ', $e->getMessage(), PHP_EOL;
				}
				# ------------------------------------
				# Add Contact to List
				# ------------------------------------
				try {
					$addContactArgs = [
						'emails' => [$SID_identifier]
					];
					$addContactEmails = new \SendinBlue\Client\Model\AddContactToList($addContactArgs); // \SendinBlue\Client\Model\AddContactToList | Emails addresses OR IDs of the contacts
					$result = $apiInstance->addContactToList($SID_listId, $addContactEmails);
					if ($SID_debug) print_r($result);
				} catch (Exception $e) {
					if ($SID_debug) echo 'Exception when calling AccountApi->addContactToList: ', $e->getMessage(), PHP_EOL;
				}
			} else {
				# ------------------------------------
				# Remove Contact from List
				# ------------------------------------
				try {
					$removeContactArgs = [
						'emails' => [$SID_identifier]
					];
					$removeContactEmails = new \SendinBlue\Client\Model\RemoveContactFromList($removeContactArgs); // \SendinBlue\Client\Model\RemoveContactFromList | Emails addresses OR IDs of the contacts
					$result = $apiInstance->removeContactFromList($SID_listId, $removeContactEmails);
					if ($SID_debug) print_r($result);
				} catch (Exception $e) {
					if ($SID_debug) echo 'Exception ('.$SID_identifier.') when calling AccountApi->removeContactFromList: ', $e->getMessage(), PHP_EOL;
				}
			}
						
			WPUM()->templates
				->set_template_data( [ 'message' => sprintf( esc_html__( '%s successfully updated', EQUIPEER_ID ), __('Address / Phone', EQUIPEER_ID) . ' / Newsletter' ) ] )
				->get_template_part( 'messages/general', 'success' ); // success | error
				
		}
	?>
	
	<?php
		// Get required datas
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
			$fields = "";
			if ($firstname == '') $fields .= '<a href="' . get_permalink( wpum_get_core_page_id( 'account' ) ) . 'settings' . '">' . __('Firstname', EQUIPEER_ID) . '</a> - ';
			if ($lastname == '')  $fields .= '<a href="' . get_permalink( wpum_get_core_page_id( 'account' ) ) . 'settings' . '">' . __('Lastname', EQUIPEER_ID) . '</a> - ';
			if ($phone == '')     $fields .= '<a href="' . get_permalink( wpum_get_core_page_id( 'account' ) ) . 'address' . '">' . __('Phone', EQUIPEER_ID) . '</a> - ';
			if ($address == '')   $fields .= '<a href="' . get_permalink( wpum_get_core_page_id( 'account' ) ) . 'address' . '">' . __('Address', EQUIPEER_ID) . '</a> - ';
			if ($zip == '')       $fields .= '<a href="' . get_permalink( wpum_get_core_page_id( 'account' ) ) . 'address' . '">' . __('Postal code', EQUIPEER_ID) . '</a> - ';
			if ($city == '')      $fields .= '<a href="' . get_permalink( wpum_get_core_page_id( 'account' ) ) . 'address' . '">' . __('City', EQUIPEER_ID) . '</a> - ';
			if ($country == '')   $fields .= '<a href="' . get_permalink( wpum_get_core_page_id( 'account' ) ) . 'address' . '">' . __('Country', EQUIPEER_ID) . '</a> - ';
			$fields = rtrim($fields, " - ");
			
			WPUM()->templates
				->set_template_data( [ 'message' => esc_html__( 'Fill in the following fields in order to use the site', EQUIPEER_ID ) . " EQUIPEER :<br><strong>$fields</strong>" ] )
				->get_template_part( 'messages/general', 'error' );
		}
	?>
	
	<form action="" method="post" id="wpum-submit-address-form">

		<?php
			// Get infos after update or not
		
			$user_info_after         = get_userdata( get_current_user_id() );
			$equipeer_user_phone     = $user_info_after->equipeer_user_telephone;
			$equipeer_user_address_1 = $user_info_after->equipeer_user_address_1;
			$equipeer_user_address_2 = $user_info_after->equipeer_user_address_2;
			$equipeer_user_zip       = $user_info_after->equipeer_user_zip;
			$equipeer_user_city      = $user_info_after->equipeer_user_city;
			$equipeer_user_country   = $user_info_after->equipeer_user_country;
		?>
		
		<div class="form-group field">
			<label for="equipeer_user_telephone"><?php echo __('Phone', EQUIPEER_ID); ?> <span style="color: red;">*</span></label>
			<br>
			<input type="tel" class="form-control" id="equipeer_user_telephone" name="equipeer_user_telephone" value="<?php echo $equipeer_user_phone; ?>" aria-describedby="putadPhoneHelp" required>
			<input type="hidden" id="phone_prefix" name="phone_prefix" value="<?php echo $phone_prefix; ?>">
			<span id="equipeer_user_telephone-valid-msg" class="hide">✓ <?php _e('Valid', EQUIPEER_ID); ?></span>
			<span id="equipeer_user_telephone-error-msg" class="hide"></span>
			<!--<small id="putadPhoneHelp" class="form-text text-muted">We'll never share your -- with anyone else.</small>-->
		</div>
		
		<div class="form-group field">
			<label for="equipeer_user_address_1"><?php _e('Address', EQUIPEER_ID); ?> 1 <span style="color: red;">*</span></label>
			<input type="text" class="form-control" id="equipeer_user_address_1" name="equipeer_user_address_1" value="<?php echo $equipeer_user_address_1; ?>" required="">
		</div>
		
		<div class="form-group field">
			<label for="equipeer_user_address_2"><?php _e('Address', EQUIPEER_ID); ?> 2</label>
			<input type="text" class="form-control" id="equipeer_user_address_2" name="equipeer_user_address_2" value="<?php echo $equipeer_user_address_2; ?>">
		</div>
		
		<div class="form-group field">
			<label for="equipeer_user_zip"><?php _e('Postal code', EQUIPEER_ID); ?> <span style="color: red;">*</span></label>
			<input type="text" class="form-control" id="equipeer_user_zip" name="equipeer_user_zip" value="<?php echo $equipeer_user_zip; ?>" required="">
		</div>
		
		<div class="form-group field">
			<label for="equipeer_user_city"><?php _e('City', EQUIPEER_ID); ?> <span style="color: red;">*</span></label>
			<input type="text" class="form-control" id="equipeer_user_city" name="equipeer_user_city" value="<?php echo $equipeer_user_city; ?>" required="">
		</div>
		
		<div class="form-group field">
			<label for="equipeer_user_country"><?php _e('Country', EQUIPEER_ID); ?> <span style="color: red;">*</span></label>
			<input type="text" class="form-control" id="equipeer_user_country" name="equipeer_user_country" value="<?php echo $equipeer_user_country; ?>" required="">
		</div>
		
		<?php
			// -------------------------
			// SEND IN BLUE
			// -------------------------
			$modifiedSince = date('Y-m-d\TH:m:i+01:00'); // UTC date-time (YYYY-MM-DDTHH:mm:ss.SSSZ)
			$limit = 50; // int | Number of documents per page
			$offset = 0; // int | Index of the first document of the page
			$sort = "desc"; // string | Sort the results in the ascending/descending order of record creation. Default order is **descending** if `sort` is not passed

			try {
				$SID_result        = $apiInstance->getContactsFromList($SID_listId, $modifiedSince, $limit, $offset, $sort);
				$SID_identifiers = $SID_result['contacts'];
				//echo '<br>SID ID: '.$SID_result['id'];
				if ($SID_debug) print_r($SID_identifiers);
			} catch (Exception $e) {
				$SID_identifiers = false;
				if ($SID_debug) echo 'Exception when calling AccountApi->getContactsFromList: ', $e->getMessage(), PHP_EOL;
			}
			// Search for email in list
			$equipeer_user_newsletter = false;
			foreach($SID_identifiers as $search) {
				if ($search['email'] == $SID_identifier) $equipeer_user_newsletter = true;
			}
			if ($SID_debug) echo '<br>equipeer_user_newsletter: '.$equipeer_user_newsletter;
		?>
		
		<div class="form-group field">
			<input type="checkbox" class="" id="equipeer_user_newsletter" name="equipeer_user_newsletter" value="<?php echo $SID_listId; ?>" <?php if ($equipeer_user_newsletter === true) echo 'checked=""'; else echo ''; ?>>&nbsp;&nbsp;<?php if (ICL_LANGUAGE_CODE == 'fr') echo 'inscrit à la newsletter EQUIPEER SPORT'; else echo 'Subscribed to the EQUIPEER SPORT newsletter'; ?>
		</div>

		<div class="form-group field">
			<input type="submit" name="submit_account" class="eq-button eq-button-red" value="<?php esc_html_e( 'Update profile', 'wp-user-manager' ); ?>">
		</div>
		
	</form>