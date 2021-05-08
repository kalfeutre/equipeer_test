<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Metabox Equine Proprietaire
 *
 * @class Metabox
 */
class Equipeer_Metabox_Proprietaire extends Equipeer {
	
	private $mt_prefix = 'proprietaire';
	
    /**
     * Constructor for the Equipeer_Metabox_Proprietaire class
     *
     * Sets up all the appropriate hooks and actions
     */
    function __construct() {
        // Add metaboxes
        add_action( 'add_meta_boxes', array( $this, 'proprietaire_add_meta_box' ) );
		// Save infos from metaboxes
		add_action( 'save_post', array( $this, 'proprietaire_save' ) );
		// Metabox class (call)
		$this->metaboxClass = new Equipeer_Metabox();
		// Titan call
		$this->equipeer_options = TitanFramework::getInstance( EQUIPEER_ID );
	}
	
    /**
     * Adds the meta box container.
     */
	function proprietaire_add_meta_box() {
		add_meta_box(
			'equipeer-' . $this->mt_prefix,
			__( 'Owner contact details', EQUIPEER_ID ),
			array( $this, 'proprietaire_html' ),
			$this->post_type,
			'normal', // normal | advanced | side
			'high' // default | high | core | low
		);
	}
	
    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
	function proprietaire_html( $post) {
		wp_nonce_field( '_proprietaire_nonce', 'proprietaire_nonce' ); ?>
	
		<link href="<?php echo EQUIPEER_URL; ?>assets/vendors/Select2/select2.min.css" rel="stylesheet">
		<script src="<?php echo EQUIPEER_URL; ?>assets/vendors/Select2/select2.min.js"></script>
		
		<div id="equipeer-proprietaire-help" class="equipeer-msg equipeer-msg-warning">
			<span class="equipeer-msg-closebtn" onclick="this.parentElement.style.display='none';">×</span>
			Renseigner une ville sinon affichage défectueux côté client (site web) !
		</div>
	
		<table class="form-table">
			<tr class="row-1 even" valign="top">
				<th scope="row" class="first">
					<label for="contact_by_phone"><?php _e( 'Contact by', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<?php $contact_by_phone_checked = ( $this->metaboxClass->get_meta_value('contact_by_phone') == 1 ) ? 'checked' : ''; ?>				
					<label class="switch switch-green">
					  <input type="checkbox" name="contact_by_phone" id="contact_by_phone" class="switch-input" <?php echo $contact_by_phone_checked; ?>>
					  <span class="switch-label" data-on="Oui" data-off="Non"></span>
					  <span class="switch-handle"></span>
					</label>
					<span class="switch-name"><?php _e( 'Phone', EQUIPEER_ID ); ?></span>
					<span class="switch-separator"></span>
					<?php $contact_by_email_checked = ( $this->metaboxClass->get_meta_value('contact_by_email') == 1 ) ? 'checked' : ''; ?>				
					<label class="switch switch-green">
					  <input type="checkbox" name="contact_by_email" id="contact_by_email" class="switch-input" <?php echo $contact_by_email_checked; ?>>
					  <span class="switch-label" data-on="Oui" data-off="Non"></span>
					  <span class="switch-handle"></span>
					</label>
					<span class="switch-name"><?php _e( 'Email', EQUIPEER_ID ); ?></span>
				</td>
			</tr>
			<tr class="row-1 odd" valign="top">
				<th scope="row" class="first">
					<label for="owner_email"><?php _e( 'Owner', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<?php
						$args = array(
							'blog_id'      => $GLOBALS['blog_id'],
							//'role'         => 'equipeer_client',
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
						$users = get_users( $args );
					?>
					<select name="owner_email" id="owner_email" class="equipeer-select-2">
						<option value="" selected="selected"><?php _e( 'No owner', EQUIPEER_ID ); ?></option>
						<?php
							foreach( $users as $user ) {
								echo '<option value="'.$user->user_email.'" ';
								echo selected( $this->metaboxClass->get_meta_value('owner_email'), $user->user_email );
								echo '>';
								echo $user->user_email . ' - ' . $user->user_nicename;
								echo '</option>';
							}
						
						?>
					</select>
				</td>
			</tr>
			<tr class="row-2 even" valign="top">
				<th scope="row" class="first">
					<label for="phone"><?php _e( 'Phone', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">			
					<input type="text" name="phone" id="phone" value="<?php echo $this->metaboxClass->get_meta_value( 'phone' ); ?>">
				</td>
			</tr>
			<tr class="row-3 odd" valign="top">
				<th scope="row" class="first">
					<label for="proprietaire">Infos - remarques</label>
				</th>
				<td class="second tf-note">	
					<textarea rows="6" cols="70" name="proprietaire" id="proprietaire"><?php echo $this->metaboxClass->get_meta_value( 'proprietaire' ); ?></textarea>
				</td>
			</tr>
			<tr class="row-3-1 even" valign="top">
				<th scope="row" class="first">
					<label for="autocomplete" style="color: #009587;">Lieu de station ou d'essai</label>
					<p class="description">
						Autocomplétion des champs adresse, code postal, ville, pays, longitude, latitude
					</p>
				</th>
				<td class="second tf-note">
					<img src="<?php echo EQUIPEER_URL; ?>assets/images/icon-google-place.png" style="float: left; width: 31px;">
					<input style="border: 1px solid #009587;" class="equipeer-input-long" id="autocomplete" placeholder="Entrer une adresse" onFocus="geolocate();" type="text">
				</td>
			</tr>
			<tr class="row-4 even" valign="top">
				<th scope="row" class="first">
					<label for="localisation_address"><?php _e( 'Address', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">			
					<input class="equipeer-input-long" type="text" name="localisation_address" id="route" value="<?php echo $this->metaboxClass->get_meta_value( 'localisation_address' ); ?>">
					<input type="hidden" id="street_number" value="">
				</td>
			</tr>
			<tr class="row-5 odd" valign="top">
				<th scope="row" class="first">
					<label for="localisation_zip"><?php _e( 'Zip', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">			
					<input class="equipeer-input-number" type="text" name="localisation_zip" id="postal_code" value="<?php echo $this->metaboxClass->get_meta_value( 'localisation_zip' ); ?>">
				</td>
			</tr>
			<tr class="row-6 even" valign="top">
				<th scope="row" class="first">
					<label for="localisation_city"><?php _e( 'City', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">			
					<input type="text" name="localisation_city" id="locality" value="<?php echo $this->metaboxClass->get_meta_value( 'localisation_city' ); ?>">
				</td>
			</tr>
			<tr class="row-7 odd" valign="top">
				<th scope="row" class="first">
					<label for="localisation_country"><?php _e( 'Country', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">			
					<input type="text" name="localisation_country" id="country" value="<?php echo $this->metaboxClass->get_meta_value( 'localisation_country' ); ?>">
				</td>
			</tr>
			<tr class="row-8 even" valign="top">
				<th scope="row" class="first">
					<label for="localisation_latitude"><?php _e( 'Latitude', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">			
					<input type="text" name="localisation_latitude" id="localisation_latitude" value="<?php echo $this->metaboxClass->get_meta_value( 'localisation_latitude' ); ?>">
				</td>
			</tr>
			<tr class="row-9 odd" valign="top">
				<th scope="row" class="first">
					<label for="localisation_longitude"><?php _e( 'Longitude', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">			
					<input type="text" name="localisation_longitude" id="localisation_longitude" value="<?php echo $this->metaboxClass->get_meta_value( 'localisation_longitude' ); ?>">
				</td>
			</tr>
			<tr class="row-1 odd" valign="top">
				<th scope="row" class="first">
					<label for="referring_expert"><?php _e( 'Reffering expert', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<?php
						$args = array(
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
						 ); 
						$experts = get_users( $args );
					?>
					<select name="referring_expert" id="referring_expert" class="equipeer-select-2">
						<option value="">Pas d'expert référent</option>
						<?php
							foreach( $experts as $expert ) {
								echo '<option value="'.$expert->ID.'" ';
								echo selected( $this->metaboxClass->get_meta_value('referring_expert'), $expert->ID );
								echo '>';
								echo $expert->user_email . ' - ' . $expert->user_nicename;
								echo '</option>';
							}
						
						?>
					</select>
				</td>
			</tr>
		</table>
		<div class="equipeer_clear"></div>
		<script>
			
			
			// This sample uses the Autocomplete widget to help the user select a
			// place, then it retrieves the address components associated with that
			// place, and then it populates the form fields with those details.
			// This sample requires the Places library. Include the libraries=places
			// parameter when you first load the API. For example:
			// <script
			// src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
			var placeSearch, autocomplete;
			// Put the same ID to your INPUTS
			var componentForm = {
				street_number: 'short_name',   // long_name | short_name
				route: 'long_name',            // long_name | short_name
				locality: 'long_name',         // long_name | short_name
				//administrative_area_level_1: 'short_name',
				//administrative_area_level_2: 'short_name',
				country: 'long_name',          // long_name | short_name
				postal_code: 'long_name'       // long_name | short_name
			};
			// Init Autocomplete
			function initAutocomplete() {
				// Create the autocomplete object, restricting the search predictions to
				// geographical location types.
				// types: (cities) | geocode | address | ...
				autocomplete = new google.maps.places.Autocomplete(
					document.getElementById('autocomplete'), {types: ['address']}
				);
				// Avoid paying for data that you don't need by restricting the set of
				// place fields that are returned to just the address components.
				autocomplete.setFields(['address_component', 'geometry']);
				// When the user selects an address from the drop-down, populate the
				// address fields in the form.
				autocomplete.addListener('place_changed', fillInAddress);
			}
			// Fill in Address Fields
			function fillInAddress() {
				// Get the place details from the autocomplete object.
				var place = autocomplete.getPlace();
			  
				var lat = place.geometry.location.lat(),
					lng = place.geometry.location.lng();				
				//console.log('latitude: '+lat);
				//console.log('longitude: '+lng);
			
				for (var component in componentForm) {
					document.getElementById(component).value = '';
					document.getElementById(component).disabled = false;
				}
				// Get each component of the address from the place details,
				// and then fill-in the corresponding field on the form.
				for (var i = 0; i < place.address_components.length; i++) {
					var addressType = place.address_components[i].types[0];
					if (componentForm[addressType]) {
						var val = place.address_components[i][componentForm[addressType]];
						document.getElementById(addressType).value = val;
					}
				}
				// Append street_number to route (Adresse complete)
				jQuery( "#route" ).val( jQuery( "#street_number" ).val() + ' ' + jQuery( "#route" ).val() );
				// Add Longitude / Latitude
				jQuery( "#localisation_latitude" ).val( lat );
				jQuery( "#localisation_longitude" ).val( lng );
			}
			
			// Bias the autocomplete object to the user's geographical location,
			// as supplied by the browser's 'navigator.geolocation' object.
			function geolocate() {
				if (navigator.geolocation) {
					navigator.geolocation.getCurrentPosition(function(position) {
						var geolocation = {
							lat: position.coords.latitude,
							lng: position.coords.longitude
						};
						var circle = new google.maps.Circle(
							{center: geolocation, radius: position.coords.accuracy});
						autocomplete.setBounds(circle.getBounds());
					});
				}
			}
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo get_option( 'equine_google_place_api_key' ); ?>&libraries=places&callback=initAutocomplete" async defer></script>

		<script>
			jQuery(function($) {
				// Select 2 for owner (DB User email + name)
				$('#owner_email').select2();
			});
		</script>
		<?php
	}
	
    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
	function proprietaire_save( $post_id ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		// Check if our nonce is set AND if that the nonce is valid
		if ( ! isset( $_POST['proprietaire_nonce'] ) || ! wp_verify_nonce( $_POST['proprietaire_nonce'], '_proprietaire_nonce' ) ) return;
		// Check the user's permissions
		if ( ! current_user_can( 'equipeer_edit_equine', $post_id ) ) return;
		// ---------------------------------------------
		// Update the meta field
		// ---------------------------------------------
		if ( isset( $_POST['contact_by_phone'] ) )
			update_post_meta( $post_id, 'contact_by_phone', '1' );
		else
			update_post_meta( $post_id, 'contact_by_phone', '0' );
		// ---------------------------------------------
		if ( isset( $_POST['contact_by_email'] ) )
			update_post_meta( $post_id, 'contact_by_email', '1' );
		else
			update_post_meta( $post_id, 'contact_by_email', '0' );
		// ---------------------------------------------
		if ( isset( $_POST['owner_email'] ) )
			update_post_meta( $post_id, 'owner_email', esc_attr( $_POST['owner_email'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['phone'] ) )
			update_post_meta( $post_id, 'phone', esc_attr( $_POST['phone'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['proprietaire'] ) )
			update_post_meta( $post_id, 'proprietaire', esc_attr( $_POST['proprietaire'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['localisation_address'] ) )
			update_post_meta( $post_id, 'localisation_address', esc_attr( $_POST['localisation_address'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['localisation_zip'] ) )
			update_post_meta( $post_id, 'localisation_zip', esc_attr( $_POST['localisation_zip'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['localisation_city'] ) )
			update_post_meta( $post_id, 'localisation_city', esc_attr( $_POST['localisation_city'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['localisation_country'] ) )
			update_post_meta( $post_id, 'localisation_country', esc_attr( $_POST['localisation_country'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['localisation_latitude'] ) )
			update_post_meta( $post_id, 'localisation_latitude', esc_attr( $_POST['localisation_latitude'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['localisation_longitude'] ) )
			update_post_meta( $post_id, 'localisation_longitude', esc_attr( $_POST['localisation_longitude'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['referring_expert'] ) )
			update_post_meta( $post_id, 'referring_expert', esc_attr( $_POST['referring_expert'] ) );
		// ---------------------------------------------
	}
	
}