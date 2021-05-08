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
class Equipeer_Metabox_Images extends Equipeer {

	private $mt_prefix   = 'photos';
	private $image_width = '150px';
	
    /**
     * Constructor for the Equipeer_Metabox class
     *
     * Sets up all the appropriate hooks and actions
     */
    function __construct() {
        // Add metaboxes
        add_action( 'add_meta_boxes', array( $this, 'images_add_meta_box' ) );
		// Save infos from metaboxes
		add_action( 'save_post', array( $this, 'images_save' ) );
		// Metabox class (call)
		$this->metaboxClass = new Equipeer_Metabox();
		// Titan call
		$this->equipeer_options = TitanFramework::getInstance( EQUIPEER_ID );
	}
	
    /**
     * Adds the meta box container.
     */
	function images_add_meta_box() {
		add_meta_box(
			'equipeer-' . $this->mt_prefix,
			__( 'Photos', EQUIPEER_ID ),
			array( $this, 'images_html' ),
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
	function images_html( $post) {
		wp_nonce_field( '_images_nonce', 'images_nonce' );
		// ---------------------------------------------
		// Aller chercher des medias depuis l'import V3,
		// Si ils existent
		// ---------------------------------------------
		$get_children = get_children( 'post_type=attachment&post_mime_type=image&post_parent='.$post->ID, ARRAY_A );
		$get_images   = array_values( $get_children );
		//echo '<pre>';
		//var_dump($get_images);
		//echo '</pre>';
		?>
		<p class="description"><?php _e( 'Click one of the images to edit or update them', EQUIPEER_ID ); ?></p>
		<p class="equipeer_p_form">
			<label for="photo_1"><?php _e( 'First image', EQUIPEER_ID ); ?></label><br>
			<?php
				// -----------------------------------------------------------
				// Nouvel ID après import (si sauvegarde d'une nouvelle photo)
				// -----------------------------------------------------------
				$meta_photo_1 = @get_post_meta($post->ID, 'photo_1', true);
				// -------------------------------------------------------
				// Verifier s'il y a une nouvelle photo depuis l'import V3
				// -------------------------------------------------------
				if ( isset($meta_photo_1) && ( $meta_photo_1 == '0' || $meta_photo_1 > 0 ) ) {
					$photo_1_id = intval( $meta_photo_1 );
				} else {
					// Sinon, prendre celle de l'import
					$photo_1_id = $get_images[0]["ID"]; // First attached image
				}
				echo $this->image_uploader_field( 'photo_1', $photo_1_id );
			?>
		</p>
		<p class="equipeer_p_form">
			<label for="photo_2"><?php _e( 'Second image', EQUIPEER_ID ); ?></label><br>
			<?php
				// -----------------------------------------------------------
				// Nouvel ID après import (si sauvegarde d'une nouvelle photo)
				// -----------------------------------------------------------
				$meta_photo_2 = @get_post_meta($post->ID, 'photo_2', true);
				// -------------------------------------------------------
				// Verifier s'il y a une nouvelle photo depuis l'import V3
				// -------------------------------------------------------
				if ( isset($meta_photo_2) && ( $meta_photo_2 == '0' || $meta_photo_2 > 0 ) ) {
					$photo_2_id = intval( $meta_photo_2 );
				} else {
					// Sinon, prendre celle de l'import
					$photo_2_id = $get_images[1]["ID"]; // Second attached image
				}
				echo $this->image_uploader_field( 'photo_2', $photo_2_id );
			?>
		</p>
		<p class="equipeer_p_form">
			<label for="photo_3"><?php _e( 'Third image', EQUIPEER_ID ); ?></label><br>
			<?php
				// Pas de photo d'import puisqu'il n'y en avait que deux
				// La troisieme photo est une nouvelle entree dans le POST
				$meta_photo_3 = @get_post_meta($post->ID, 'photo_3', true);
				$photo_3_id = intval( $meta_photo_3 );
				echo $this->image_uploader_field( 'photo_3', $photo_3_id );
			?>
		</p>
		<p class="equipeer_p_form">
			<label for="photo_4">Quatrième photo</label><br>
			<?php
				// Pas de photo d'import puisqu'il n'y en avait que deux
				// La troisieme photo est une nouvelle entree dans le POST
				$meta_photo_4 = @get_post_meta($post->ID, 'photo_4', true);
				$photo_4_id = intval( $meta_photo_4 );
				echo $this->image_uploader_field( 'photo_4', $photo_4_id );
			?>
		</p>
		<script>
			jQuery(function($) {
				/*
				 * Select/Upload image(s) event
				 */
				$('body').on('click', '.equipeer_upload_image_button', function(e){
					e.preventDefault();			 
					var button = $(this),
						custom_uploader = wp.media({
							title: 'Insert image',
							library : {
								// uncomment the next line if you want to attach image to the current post
								<?php if ($this->equipeer_options->getOption('ads_enable_all_medias') == 1) { ?>uploadedTo : wp.media.view.settings.post.id,<?php } ?>
								type : 'image',
								orderby: 'date'
							},
							button: {
								text: 'Use this image' // button label text
							},
							multiple: false // for multiple image selection set to true
						}).on('select', function() { // it also has "open" and "close" events 
							var attachment = custom_uploader.state().get('selection').first().toJSON();
							$(button).removeClass('button').html('<img class="true_pre_image" src="' + attachment.url + '" style="max-width: <?php echo $this->image_width; ?>; display: block;" />').next().val(attachment.id).next().show();
							/* if you send multiple to true, here is some code for getting the image IDs
							var attachments = frame.state().get('selection'),
								attachment_ids = new Array(),
								i = 0;
							attachments.each(function(attachment) {
								attachment_ids[i] = attachment['id'];
								console.log( attachment );
								i++;
							});
							*/
						})
						.open();
				});
			 
				/*
				 * Remove image event
				 */
				$('body').on('click', '.equipeer_remove_image_button', function(){
					$(this).hide().prev().val('0').prev().addClass('button').html('Upload image');
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
	function images_save( $post_id ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		// Check if our nonce is set AND if that the nonce is valid
		if ( ! isset( $_POST['images_nonce'] ) || ! wp_verify_nonce( $_POST['images_nonce'], '_images_nonce' ) ) return;
		// Check the user's permissions
		if ( ! current_user_can( 'equipeer_edit_equine', $post_id ) ) return;
		// ---------------------------------------------
		// Update the meta field
		// ---------------------------------------------
		$photo_1_update = ( isset( $_POST['photo_1'] ) && $_POST['photo_1'] != '' ) ? esc_attr( $_POST['photo_1'] ) : '0';
		update_post_meta( $post_id, 'photo_1', $photo_1_update );
		// ---------------------------------------------
		$photo_2_update = ( isset( $_POST['photo_2'] ) && $_POST['photo_2'] != '' ) ? esc_attr( $_POST['photo_2'] ) : '0';
		update_post_meta( $post_id, 'photo_2', $photo_2_update );
		// ---------------------------------------------
		$photo_3_update = ( isset( $_POST['photo_3'] ) && $_POST['photo_3'] != '' ) ? esc_attr( $_POST['photo_3'] ) : '0';
		update_post_meta( $post_id, 'photo_3', $photo_3_update );
		// ---------------------------------------------
		$photo_4_update = ( isset( $_POST['photo_4'] ) && $_POST['photo_4'] != '' ) ? esc_attr( $_POST['photo_4'] ) : '0';
		update_post_meta( $post_id, 'photo_4', $photo_4_update );
		// ---------------------------------------------
	}
	
	/*
	 * @param string $name Name of option or name of post custom field.
	 * @param string $value Optional Attachment ID
	 * @return string HTML of the Upload Button
	 */
	function image_uploader_field( $name, $value = '') {
		$image      = ' button">Upload image';
		$image_size = 'full'; // it would be better to use thumbnail size here (150x150 or so)
		$display    = 'none'; // display state ot the "Remove image" button
	 
		if( $image_attributes = wp_get_attachment_image_src( $value, $image_size ) ) {
	 
			// $image_attributes[0] - image URL
			// $image_attributes[1] - image width
			// $image_attributes[2] - image height
	 
			$image = '"><img src="' . $image_attributes[0] . '" style="max-width: ' . $this->image_width . '; display: block;" />';
			$display = 'inline-block';
	 
		} 
	 
		return '
			<a href="#" class="equipeer_upload_image_button' . $image . '</a>
			<input type="hidden" name="' . $name . '" id="' . $name . '" value="' . esc_attr( $value ) . '" />
			<a href="#" class="equipeer_remove_image_button" style="display: inline-block; display:' . $display . '">Remove image</a>
			';
	}
	
}