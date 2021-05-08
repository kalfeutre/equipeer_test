<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Metabox Equine Misc
 *
 * @class Metabox
 */
class Equipeer_Metabox_Misc extends Equipeer {
	
	private $mt_prefix = 'misc';
	
    /**
     * Constructor for the Equipeer_Metabox_Misc class
     *
     * Sets up all the appropriate hooks and actions
     */
    function __construct() {
        // Add metaboxes
        add_action( 'add_meta_boxes', array( $this, 'notes_add_meta_box' ) );
		// Save infos from metaboxes
		add_action( 'save_post', array( $this, 'notes_save' ) );
		// Metabox class (call)
		$this->metaboxClass = new Equipeer_Metabox();
	}
	
    /**
     * Adds the meta box container.
     */
	function notes_add_meta_box() {
		add_meta_box(
			'equipeer-' . $this->mt_prefix,
			__( 'Misc', EQUIPEER_ID ),
			array( $this, 'notes_html' ),
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
	function notes_html( $post) {
		wp_nonce_field( '_notes_nonce', 'notes_nonce' ); ?>
	
		<table class="form-table">
			<tr id="block_lieux_essais" class="row-1 even" valign="top">
				<th scope="row" class="first">
					<label for="lieux_essais"><?php _e( 'Test Places', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<textarea rows="6" cols="70" name="lieux_essais" id="lieux_essais"><?php echo $this->metaboxClass->get_meta_value( 'lieux_essais' ); ?></textarea>
				</td>
			</tr>
		</table>
		<div class="equipeer_clear"></div>
		<script>
			jQuery(function($) {
				
			});
		</script>
		<?php
	}
	
    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
	function notes_save( $post_id ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		// Check if our nonce is set AND if that the nonce is valid
		if ( ! isset( $_POST['notes_nonce'] ) || ! wp_verify_nonce( $_POST['notes_nonce'], '_notes_nonce' ) ) return;
		// Check the user's permissions
		if ( ! current_user_can( 'equipeer_edit_equine', $post_id ) ) return;
		// ---------------------------------------------
		// Update the meta field
		// ---------------------------------------------
		if ( isset( $_POST['lieux_essais'] ) )
			update_post_meta( $post_id, 'lieux_essais', esc_attr( $_POST['lieux_essais'] ) );
		// ---------------------------------------------
	}
	
}