<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Metabox Equine Veterinaire
 *
 * @class Metabox
 */
class Equipeer_Metabox_Veto extends Equipeer {
	
	private $mt_prefix   = 'veto';
	private $image_width = '50px';
	
    /**
     * Constructor for the Equipeer_Metabox_Veto class
     *
     * Sets up all the appropriate hooks and actions
     */
    function __construct() {
        // Add metaboxes
        add_action( 'add_meta_boxes', array( $this, 'date_add_meta_box' ) );
		// Save infos from metaboxes
		add_action( 'save_post', array( $this, 'date_save' ) );
		// Metabox class (call)
		$this->metaboxClass = new Equipeer_Metabox();
	}
	
    /**
     * Adds the meta box container.
     */
	function date_add_meta_box() {
		add_meta_box(
			'equipeer-' . $this->mt_prefix,
			__( 'Veterinary visit', EQUIPEER_ID ),
			array( $this, 'date_html' ),
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
	function date_html( $post) {
		wp_nonce_field( '_date_nonce', 'date_nonce' ); ?>
		
		<p class="equipeer_p_form">
			<?php $veterinaire_date = ( $this->metaboxClass->get_meta_value( 'veterinaire_date' ) == '0000-00-00 00:00:00' ) ? false : str_replace( " 00:00:00", "", $this->metaboxClass->get_meta_value( 'veterinaire_date' ) ); ?>
			<label for="veterinaire_date"><?php _e( 'Date of the last veterinary visit', EQUIPEER_ID ); ?></label><br>
			<input style="float: left;" type="text" class="equipeer_datepicker_veto equipeer-input-date" name="veterinaire_date" id="veterinaire_date" value="<?php echo $veterinaire_date; ?>">
			<br>
			<span style="clear: both; display: block;" class="description"><?php _e( 'Format YYYY-MM-DD', EQUIPEER_ID ); ?></span>
		</p>
		<p class="equipeer_p_form">
			<label for="veterinaire_document"><?php _e( 'Veterinary report', EQUIPEER_ID ); ?></label><br>
			<?php
				$veterinaire_document_id  = ( @get_post_meta($post->ID, 'veterinaire_document', true) ) ? @get_post_meta($post->ID, 'veterinaire_document', true) : '';
				$veterinaire_document_url = ( isset($veterinaire_document_id) && $veterinaire_document_id > 0 ) ? @wp_get_attachment_url( $veterinaire_document_id ) : '';
				$veto_display_document    = ( isset($veterinaire_document_id) && $veterinaire_document_id > 0 ) ? 'block' : 'none';
				$veto_display_button      = ( isset($veterinaire_document_id) && $veterinaire_document_id > 0 ) ? 'none' : 'block';
			?>
			<span style="display: <?php echo $veto_display_button; ?>;" id="veterinaire_document_none">Aucun document</span>
			<img style="display: <?php echo $veto_display_document; ?>;" id="veterinaire_document_url" src="<?php echo EQUIPEER_URL; ?>assets/images/icon_document.png" data-url="<?php echo $veterinaire_document_url; ?>" width="<?php echo $this->image_width; ?>px" title="Cliquez sur l'ic&ocirc;ne pour visualiser le document">
			<a href="#" id="veterinaire_remove_button" style="display: <?php echo $veto_display_document; ?>;">Remove document</a>
			<input style="display: <?php echo $veto_display_button; ?>;" type="button" name="veto-upload-btn" id="veto-upload-btn" class="button-secondary" value="Upload Document">
			<input type="hidden" name="veterinaire_document" id="veterinaire_document" value="<?php echo $veterinaire_document_id; ?>">
			<span style="clear: both; display: block;" class="description">Format : PDF, PNG, DOC, DOCX</span>
		</p>
		
		<table class="form-table">
			<tr class="row-1 even" valign="top">
				<th scope="row" class="first">
					<label for="misc_bilan"><?php _e( 'Medical background and results', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<textarea rows="6" cols="70" name="misc_bilan" id="misc_bilan"><?php echo $this->metaboxClass->get_meta_value( 'misc_bilan' ); ?></textarea>
				</td>
			</tr>
		</table>
		
		<div class="equipeer_clear"></div>
		<script>
			jQuery(function($) {
				// Date Picker
				$( ".equipeer_datepicker_veto" ).datepicker({
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
					buttonText: "Select date"
				});
				/*
				 * Select/Upload image(s) event
				 */
				$('#veto-upload-btn').click(function(e) {
					e.preventDefault();
					var image = wp.media({ 
						title: 'Upload document',
						// mutiple: true if you want to upload multiple files at once
						multiple: false
					}).open()
					.on('select', function(){
						// This will return the selected image from the Media Uploader, the result is an object
						var uploaded_document = image.state().get('selection').first().toJSON();
						// We convert uploaded_image to a JSON object to make accessing it easier
						// Output to the console uploaded_image
						console.log(uploaded_document);
						var document_url = uploaded_document.url;
						var document_id  = uploaded_document.id;
						// Let's assign the url value to the input field
						$('#veterinaire_document_url').attr( 'data-url', document_url ).css( 'display', 'block' );
						$('#veterinaire_document_none, #veto-upload-btn').css( 'display', 'none' );
						$('#veterinaire_remove_button').css( 'display', 'block' );
						$('#veterinaire_document').val( document_id );
					});
				});
				/*
				 * Remove image event
				 */
				$('#veterinaire_remove_button').click(function() {
					// Valeur 0
					$('#veterinaire_document').val('');
					$('#veterinaire_document_url').attr( 'data-url', '' ).css( 'display', 'none' );
					// Display
					$('#veterinaire_document_none, #veto-upload-btn').css( 'display', 'block' );
					$('#veterinaire_remove_button').css( 'display', 'none' );
					return false;
				});
				/*
				 * On click DOCUMENT
				 */
				$('#veterinaire_document_url').click(function() {
					//var veto_url = this.attr('data-url');
					window.open( $( this ).attr('data-url') );
				});
			} );
		</script>
		<?php
	}
	
    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
	function date_save( $post_id ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		// Check if our nonce is set AND if that the nonce is valid
		if ( ! isset( $_POST['date_nonce'] ) || ! wp_verify_nonce( $_POST['date_nonce'], '_date_nonce' ) ) return;
		// Check the user's permissions
		if ( ! current_user_can( 'equipeer_edit_equine', $post_id ) ) return;
		
		// Update the meta field
		// ---------------------------------------------
		if ( isset( $_POST['veterinaire_date'] ) )
			update_post_meta( $post_id, 'veterinaire_date', esc_attr( $_POST['veterinaire_date'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['veterinaire_document'] ) )
			update_post_meta( $post_id, 'veterinaire_document', esc_attr( $_POST['veterinaire_document'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['misc_bilan'] ) )
			update_post_meta( $post_id, 'misc_bilan', esc_attr( $_POST['misc_bilan'] ) );
		// ---------------------------------------------
	}
	
	/*
	 * @param string $name Name of option or name of post custom field.
	 * @param string $value Optional Attachment ID
	 * @return string HTML of the Upload Button
	 */
	function image_uploader_field( $name, $value = '') {
		$image      = ' button">Upload document';
		$image_size = 'full'; // it would be better to use thumbnail size here (150x150 or so)
		$display    = 'none'; // display state ot the "Remove image" button
	 
		if( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {
	 
			// $image_attributes[0] - image URL
			// $image_attributes[1] - image width
			// $image_attributes[2] - image height
	 
			$image = '"><img src="' . EQUIPEER_URL . 'assets/images/document_veto_available.jpg" style="max-width: ' . $this->image_width . '; display: block;" />';
			$display = 'inline-block';
	 
		} 
	 
		return '
			<a href="#" class="equipeer_remove_image_button_veto' . $image . '</a>
			<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . esc_attr( $value ) . '" />
			<a href="#" class="equipeer_remove_image_button_veto" style="display: inline-block; display:' . $display . '">Remove image</a>
			';
	}
	
}