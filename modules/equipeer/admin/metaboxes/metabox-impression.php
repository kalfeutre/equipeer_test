<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Metabox Equine Impression
 *
 * @class Metabox
 */
class Equipeer_Metabox_Impression extends Equipeer {
	
	private $mt_prefix = 'impression';
	
    /**
     * Constructor for the Equipeer_Metabox_Impression class
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
			__( 'Overall Feeling', EQUIPEER_ID ),
			array( $this, 'impression_html' ),
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
	function impression_html( $post) {
		wp_nonce_field( '_impression_nonce', 'impression_nonce' ); ?>
		
		<table class="form-table">
			<tr class="row-0 even" valign="top">
				<th scope="row" class="first">
					<label for="impression"><?php _e( 'Overall Feeling', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">	
					<textarea rows="6" cols="70" name="impression" id="impression"><?php echo $this->metaboxClass->get_meta_value( 'impression' ); ?></textarea>
				</td>
			</tr>
		</table>

		<div class="equipeer_clear"></div>
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
		if ( ! isset( $_POST['impression_nonce'] ) || ! wp_verify_nonce( $_POST['impression_nonce'], '_impression_nonce' ) ) return;
		// Check the user's permissions
		if ( ! current_user_can( 'equipeer_edit_equine', $post_id ) ) return;
		
		// Update the meta field
		// ---------------------------------------------
		if ( isset( $_POST['impression'] ) )
			update_post_meta( $post_id, 'impression', esc_attr( $_POST['impression'] ) );
		// ---------------------------------------------
	}
	
}