<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Metabox Equine Descriptif Detail
 *
 * @class Metabox
 */
class Equipeer_Metabox_Descriptif_Detail extends Equipeer {
	
	private $mt_prefix = 'descriptif-detail';
	
    /**
     * Constructor for the Equipeer_Metabox_Descriptif_Detail class
     *
     * Sets up all the appropriate hooks and actions
     */
    function __construct() {
        // Add metaboxes
        add_action( 'add_meta_boxes', array( $this, 'descriptif_detail_add_meta_box' ) );
		// Save infos from metaboxes
		add_action( 'save_post', array( $this, 'descriptif_detail_save' ) );
		// Metabox class (call)
		$this->metaboxClass = new Equipeer_Metabox();
	}
	
    /**
     * Adds the meta box container.
     */
	function descriptif_detail_add_meta_box() {
		add_meta_box(
			'equipeer-' . $this->mt_prefix,
			__( 'Detailed description', EQUIPEER_ID ),
			array( $this, 'descriptif_detail_html' ),
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
	function descriptif_detail_html( $post) {
		wp_nonce_field( '_descriptif_detail_nonce', 'descriptif_detail_nonce' ); ?>
	
		<table class="form-table">
			<tr id="block_descriptif_detail_1" class="row-1 even" valign="top">
				<th scope="row" class="first">
					<label for="descriptif_detail_1"><?php _e( 'Type of hinge', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<textarea rows="2" cols="70" name="descriptif_detail_1" id="descriptif_detail_1"><?php echo $this->metaboxClass->get_meta_value( 'descriptif_detail_1' ); ?></textarea>
				</td>
			</tr>
			<tr id="block_descriptif_detail_2" class="row-2 odd" valign="top">
				<th scope="row" class="first">
					<label for="descriptif_detail_2"><?php _e( 'Type of mouth piece', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<textarea rows="2" cols="70" name="descriptif_detail_2" id="descriptif_detail_2"><?php echo $this->metaboxClass->get_meta_value( 'descriptif_detail_2' ); ?></textarea>
				</td>
			</tr>
			<tr id="block_modele" class="row-3 even" valign="top">
				<th scope="row" class="first">
					<label for="modele"><?php _e( 'Model: forehand, back, back hand', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<textarea rows="2" cols="70" name="modele" id="modele"><?php echo $this->metaboxClass->get_meta_value( 'modele' ); ?></textarea>
				</td>
			</tr>
			<tr id="block_aplomb" class="row-4 odd" valign="top">
				<th scope="row" class="first">
					<label for="aplomb"><?php _e( 'Balances: anterior, posterior', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<textarea rows="2" cols="70" name="aplomb" id="aplomb"><?php echo $this->metaboxClass->get_meta_value( 'aplomb' ); ?></textarea>
				</td>
			</tr>
			<tr id="block_allure" class="row-5 even" valign="top">
				<th scope="row" class="first">
					<label for="allure"><?php _e( 'Quality of pace: step, trot, gallop', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<textarea rows="2" cols="70" name="allure" id="allure"><?php echo $this->metaboxClass->get_meta_value( 'allure' ); ?></textarea>
				</td>
			</tr>
			<tr id="block_comportement" class="row-6 odd" valign="top">
				<th scope="row" class="first">
					<label for="comportement"><?php _e( 'Behavior / General Character: in the stable, on foot, in transport, in the tether, paddock, mowing, outdoors, work', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<textarea rows="2" cols="70" name="comportement" id="comportement"><?php echo $this->metaboxClass->get_meta_value( 'comportement' ); ?></textarea>
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
	function descriptif_detail_save( $post_id ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		// Check if our nonce is set AND if that the nonce is valid
		if ( ! isset( $_POST['descriptif_detail_nonce'] ) || ! wp_verify_nonce( $_POST['descriptif_detail_nonce'], '_descriptif_detail_nonce' ) ) return;
		// Check the user's permissions
		if ( ! current_user_can( 'equipeer_edit_equine', $post_id ) ) return;
		// ---------------------------------------------
		// Update the meta field
		// ---------------------------------------------
		if ( isset( $_POST['modele'] ) )
			update_post_meta( $post_id, 'modele', esc_attr( $_POST['modele'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['aplomb'] ) )
			update_post_meta( $post_id, 'aplomb', esc_attr( $_POST['aplomb'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['allure'] ) )
			update_post_meta( $post_id, 'allure', esc_attr( $_POST['allure'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['comportement'] ) )
			update_post_meta( $post_id, 'comportement', esc_attr( $_POST['comportement'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['descriptif_detail_1'] ) )
			update_post_meta( $post_id, 'descriptif_detail_1', esc_attr( $_POST['descriptif_detail_1'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['descriptif_detail_2'] ) )
			update_post_meta( $post_id, 'descriptif_detail_2', esc_attr( $_POST['descriptif_detail_2'] ) );
		// ---------------------------------------------
	}
	
}