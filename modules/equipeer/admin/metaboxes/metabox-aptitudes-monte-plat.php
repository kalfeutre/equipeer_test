<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Metabox Equine Aptitudes Plat
 *
 * @class Metabox
 */
class Equipeer_Metabox_Aptitudes_Plat extends Equipeer {
	
	private $mt_prefix = 'aptitudes-plat';
	
    /**
     * Constructor for the Equipeer_Metabox_Aptitudes_Plat class
     *
     * Sets up all the appropriate hooks and actions
     */
    function __construct() {
        // Add metaboxes
        add_action( 'add_meta_boxes', array( $this, 'aptitudes_plat_add_meta_box' ) );
		// Save infos from metaboxes
		add_action( 'save_post', array( $this, 'aptitudes_plat_save' ) );
		// Metabox class (call)
		$this->metaboxClass = new Equipeer_Metabox();
	}
	
    /**
     * Adds the meta box container.
     */
	function aptitudes_plat_add_meta_box() {
		add_meta_box(
			'equipeer-' . $this->mt_prefix,
			__( 'Sports skills', EQUIPEER_ID ) . ' : ' . __( 'Mounted on the flat', EQUIPEER_ID ),
			array( $this, 'aptitudes_plat_html' ),
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
	function aptitudes_plat_html( $post) {
		wp_nonce_field( '_aptitudes_plat_nonce', 'aptitudes_plat_nonce' ); ?>
	
		<table class="form-table">
			<tr class="row-1 even">
				<th scope="row" class="first" style="vertical-align: top;">
					<p id="block_plat_souplesse" class="equipeer_p_form">
						<label for="plat_souplesse"><?php _e( 'Flexibility - Step - Gathered', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'plat_souplesse' ); ?>
					</p>
					<p id="block_plat_sang" class="equipeer_p_form">
						<label for="plat_sang"><?php _e( 'Blood - Step - Elongate', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'plat_sang' ); ?>
					</p>
					<p id="block_plat_disponibilite" class="equipeer_p_form">
						<label for="plat_disponibilite"><?php _e( 'Disponibility - Trot - Work', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'plat_disponibilite' ); ?>
					</p>
					<p id="block_plat_bouche" class="equipeer_p_form">
						<label for="plat_bouche"><?php _e( 'Mouth - Trot - Elongate', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'plat_bouche' ); ?>
					</p>
					<p id="block_plat_confort" class="equipeer_p_form">
						<label for="plat_confort"><?php _e( 'Riding comfort - Gallop - Work', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'plat_confort' ); ?>
					</p>
					<p id="block_plat_caractere" class="equipeer_p_form">
						<label for="plat_caractere"><?php _e( 'Vocation - Gallop - Elongate', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'plat_caractere' ); ?>
					</p>
					<p id="block_plat_stabilite" class="equipeer_p_form">
						<label for="plat_stabilite"><?php _e( 'Stability', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'plat_stabilite' ); ?>
					</p>
				</th>
				<td class="second tf-note" style="vertical-align: top;">
					<label for="plat_impression" style="display: block; margin: 1em 0;"><?php _e( 'Overall Feeling', EQUIPEER_ID ); ?></label>
					<textarea rows="2" cols="70" name="plat_impression" id="plat_impression"><?php echo $this->metaboxClass->get_meta_value( 'plat_impression' ); ?></textarea>
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
	function aptitudes_plat_save( $post_id ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		// Check if our nonce is set AND if that the nonce is valid
		if ( ! isset( $_POST['aptitudes_plat_nonce'] ) || ! wp_verify_nonce( $_POST['aptitudes_plat_nonce'], '_aptitudes_plat_nonce' ) ) return;
		// Check the user's permissions
		if ( ! current_user_can( 'equipeer_edit_equine', $post_id ) ) return;
		// ---------------------------------------------
		// Update the meta field
		// ---------------------------------------------
		if ( isset( $_POST['plat_souplesse'] ) )
			update_post_meta( $post_id, 'plat_souplesse', esc_attr( $_POST['plat_souplesse'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['plat_sang'] ) )
			update_post_meta( $post_id, 'plat_sang', esc_attr( $_POST['plat_sang'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['plat_disponibilite'] ) )
			update_post_meta( $post_id, 'plat_disponibilite', esc_attr( $_POST['plat_disponibilite'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['plat_bouche'] ) )
			update_post_meta( $post_id, 'plat_bouche', esc_attr( $_POST['plat_bouche'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['plat_confort'] ) )
			update_post_meta( $post_id, 'plat_confort', esc_attr( $_POST['plat_confort'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['plat_caractere'] ) )
			update_post_meta( $post_id, 'plat_caractere', esc_attr( $_POST['plat_caractere'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['plat_stabilite'] ) )
			update_post_meta( $post_id, 'plat_stabilite', esc_attr( $_POST['plat_stabilite'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['plat_impression'] ) )
			update_post_meta( $post_id, 'plat_impression', esc_attr( $_POST['plat_impression'] ) );
		// ---------------------------------------------
	}
	
}