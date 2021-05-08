<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Metabox Equine Notes
 *
 * @class Metabox
 */
class Equipeer_Metabox_Notes extends Equipeer {
	
	private $mt_prefix = 'notes';
	
    /**
     * Constructor for the Equipeer_Metabox_Notes class
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
			__( "Notepad", EQUIPEER_ID ),
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
			<tr id="block_misc_selectionneur_essai" class="row-1 even equipeer-none" valign="top">
				<th scope="row" class="first">
					<label for="misc_selectionneur_essai"><?php _e( 'Tests performed and date', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<textarea rows="6" cols="70" name="misc_selectionneur_essai" id="misc_selectionneur_essai"><?php echo $this->metaboxClass->get_meta_value( 'misc_selectionneur_essai' ); ?></textarea>
				</td>
			</tr>
			<tr id="block_misc_selectionneur_cavalier" class="row-2 odd equipeer-none" valign="top">
				<th scope="row" class="first">
					<label for="misc_selectionneur_cavalier"><?php _e( 'Previous riders', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<textarea rows="6" cols="70" name="misc_selectionneur_cavalier" id="misc_selectionneur_cavalier"><?php echo $this->metaboxClass->get_meta_value( 'misc_selectionneur_cavalier' ); ?></textarea>
				</td>
			</tr>
			<tr class="row-3 even" valign="top">
				<th scope="row" class="first">
					<label for="misc_notepad"><?php _e( 'Notes', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<textarea rows="6" cols="70" name="misc_notepad" id="misc_notepad"><?php echo $this->metaboxClass->get_meta_value( 'misc_notepad' ); ?></textarea>
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
		if ( isset( $_POST['misc_selectionneur_essai'] ) )
			update_post_meta( $post_id, 'misc_selectionneur_essai', esc_attr( $_POST['misc_selectionneur_essai'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['misc_selectionneur_cavalier'] ) )
			update_post_meta( $post_id, 'misc_selectionneur_cavalier', esc_attr( $_POST['misc_selectionneur_cavalier'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['misc_notepad'] ) )
			update_post_meta( $post_id, 'misc_notepad', esc_attr( $_POST['misc_notepad'] ) );
		// ---------------------------------------------
	}
	
}