<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Metabox Equine Origines
 *
 * @class Metabox
 */
class Equipeer_Metabox_Origines extends Equipeer {
	
	private $mt_prefix = 'origines';
	
    /**
     * Constructor for the Equipeer_Metabox_Origines class
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
			__( 'Origins', EQUIPEER_ID ),
			array( $this, 'type_html' ),
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
	function type_html( $post) {
		wp_nonce_field( '_type_nonce', 'type_nonce' ); ?>
	
		<table style="margin: 0 auto; width: 100%">
			<tbody>
				<tr>
					<td></td>
					<td></td>
					<td>
						<input style="width: 350px;" type="text" name="origin_sire_sire" id="origin_sire_sire" value="<?php echo $this->metaboxClass->get_meta_value( 'origin_sire_sire' ); ?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php _e( 'Father', EQUIPEER_ID ); ?>
					</td>
					<td>
						<input style="width: 350px;" type="text" name="origin_sire" id="origin_sire" value="<?php echo $this->metaboxClass->get_meta_value( 'origin_sire' ); ?>">
					</td>
					<td><hr></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>
						<input style="width: 350px;" type="text" name="origin_sire_dam" id="origin_sire_dam" value="<?php echo $this->metaboxClass->get_meta_value( 'origin_sire_dam' ); ?>">
					</td>
				</tr>
				<tr>
					<td colspan="3"><hr style="border: 1px solid lightgrey;"></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>
						<input style="width: 350px;" type="text" name="origin_dam_sire" id="origin_dam_sire" value="<?php echo $this->metaboxClass->get_meta_value( 'origin_dam_sire' ); ?>">
					</td>
				</tr>
				<tr>
					<td>
						<?php _e( 'Mother', EQUIPEER_ID ); ?>
					</td>
					<td>
						<input style="width: 350px;" type="text" name="origin_dam" id="origin_dam" value="<?php echo $this->metaboxClass->get_meta_value( 'origin_dam' ); ?>">
					</td>
					<td><hr></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>
						<input style="width: 350px;" type="text" name="origin_dam_dam" id="origin_dam_dam" value="<?php echo $this->metaboxClass->get_meta_value( 'origin_dam_dam' ); ?>">
					</td>
				</tr>
			</tbody>
		</table>

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
		if ( isset( $_POST['origin_sire'] ) )
			update_post_meta( $post_id, 'origin_sire', esc_attr($_POST['origin_sire']) );
		// ---------------------------------------------
		if ( isset( $_POST['origin_sire_sire'] ) )
			update_post_meta( $post_id, 'origin_sire_sire', esc_attr($_POST['origin_sire_sire']) );
		// ---------------------------------------------
		if ( isset( $_POST['origin_sire_dam'] ) )
			update_post_meta( $post_id, 'origin_sire_dam', esc_attr($_POST['origin_sire_dam']) );		
		// ---------------------------------------------
		if ( isset( $_POST['origin_dam'] ) )
			update_post_meta( $post_id, 'origin_dam', esc_attr( $_POST['origin_dam'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['origin_dam_sire'] ) )
			update_post_meta( $post_id, 'origin_dam_sire', esc_attr( $_POST['origin_dam_sire'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['origin_dam_dam'] ) )
			update_post_meta( $post_id, 'origin_dam_dam', esc_attr( $_POST['origin_dam_dam'] ) );
		// ---------------------------------------------
	}
	
}