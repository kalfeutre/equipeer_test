<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Metabox Equine Aptitudes Saut
 *
 * @class Metabox
 */
class Equipeer_Metabox_Aptitudes_Saut extends Equipeer {
	
	private $mt_prefix = 'aptitudes-saut';
	
    /**
     * Constructor for the Equipeer_Metabox_Aptitudes_Saut class
     *
     * Sets up all the appropriate hooks and actions
     */
    function __construct() {
        // Add metaboxes
        add_action( 'add_meta_boxes', array( $this, 'aptitudes_saut_add_meta_box' ) );
		// Save infos from metaboxes
		add_action( 'save_post', array( $this, 'aptitudes_saut_save' ) );
		// Metabox class (call)
		$this->metaboxClass = new Equipeer_Metabox();
	}
	
    /**
     * Adds the meta box container.
     */
	function aptitudes_saut_add_meta_box() {
		add_meta_box(
			'equipeer-' . $this->mt_prefix,
			__( 'Sports skills', EQUIPEER_ID ) . ' : ' . __( 'Jump quality', EQUIPEER_ID ),
			array( $this, 'aptitudes_saut_html' ),
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
	function aptitudes_saut_html( $post) {
		wp_nonce_field( '_aptitudes_saut_nonce', 'aptitudes_saut_nonce' ); ?>
	
		<table class="form-table">
			<tr class="row-1 even" valign="top">
				<th scope="row" class="first" style="vertical-align: top;">
					<p id="block_saut_envergure" class="equipeer_p_form">
						<label for="saut_envergure"><?php _e( 'Stretch', EQUIPEER_ID ); ?></span></label><br>
						<?php echo equipeer_get_score_select( 'saut_envergure' ); ?>
					</p>
					<p id="block_saut_moyen" class="equipeer_p_form">
						<label for="saut_moyen"><?php _e( 'Average jump', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'saut_moyen' ); ?>
					</p>
					<p id="block_saut_style" class="equipeer_p_form">
						<label for="saut_style"><?php _e( 'Style', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'saut_style' ); ?>
					</p>
					<p id="block_saut_equilibre" class="equipeer_p_form">
						<label for="saut_equilibre"><?php _e( 'Balanced', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'saut_equilibre' ); ?>
					</p>
					<p id="block_saut_intelligence" class="equipeer_p_form">
						<label for="saut_intelligence"><?php _e( 'Intelligence', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'saut_intelligence' ); ?>
					</p>
					<p id="block_saut_respect" class="equipeer_p_form">
						<label for="saut_respect"><?php _e( 'Respect', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'saut_respect' ); ?>
					</p>
			
					<p id="block_saut_7" class="equipeer_p_form">
						<label for="saut_7"><?php _e( 'Foot change - Lines', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'saut_7' ); ?>
					</p>
					<p id="block_saut_8" class="equipeer_p_form">
						<label for="saut_8"><?php _e( 'False gallop', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'saut_8' ); ?>
					</p>
					<p id="block_saut_9" class="equipeer_p_form">
						<label for="saut_9"><?php _e( 'Backed up', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'saut_9' ); ?>
					</p>
					<p id="block_saut_10" class="equipeer_p_form">
						<label for="saut_10"><?php _e( 'Spins', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'saut_10' ); ?>
					</p>
					<p id="block_saut_11" class="equipeer_p_form">
						<label for="saut_11"><?php _e( 'Crossing', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'saut_11' ); ?>
					</p>
					<p id="block_saut_12" class="equipeer_p_form">
						<label for="saut_12"><?php _e( 'Piaff&eacute;', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'saut_12' ); ?>
					</p>
				</th>
				<td class="second tf-note" style="vertical-align: top;">
					<label for="saut_impression" style="display: block; margin: 1em 0;"><?php _e( 'Overall Feeling', EQUIPEER_ID ); ?></label>
					<textarea rows="2" cols="70" name="saut_impression" id="saut_impression"><?php echo $this->metaboxClass->get_meta_value( 'saut_impression' ); ?></textarea>
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
	function aptitudes_saut_save( $post_id ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		// Check if our nonce is set AND if that the nonce is valid
		if ( ! isset( $_POST['aptitudes_saut_nonce'] ) || ! wp_verify_nonce( $_POST['aptitudes_saut_nonce'], '_aptitudes_saut_nonce' ) ) return;
		// Check the user's permissions
		if ( ! current_user_can( 'equipeer_edit_equine', $post_id ) ) return;
		// ---------------------------------------------
		// Update the meta field
		// ---------------------------------------------
		if ( isset( $_POST['saut_envergure'] ) )
			update_post_meta( $post_id, 'saut_envergure', esc_attr( $_POST['saut_envergure'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['saut_moyen'] ) )
			update_post_meta( $post_id, 'saut_moyen', esc_attr( $_POST['saut_moyen'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['saut_style'] ) )
			update_post_meta( $post_id, 'saut_style', esc_attr( $_POST['saut_style'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['saut_equilibre'] ) )
			update_post_meta( $post_id, 'saut_equilibre', esc_attr( $_POST['saut_equilibre'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['saut_intelligence'] ) )
			update_post_meta( $post_id, 'saut_intelligence', esc_attr( $_POST['saut_intelligence'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['saut_respect'] ) )
			update_post_meta( $post_id, 'saut_respect', esc_attr( $_POST['saut_respect'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['saut_7'] ) )
			update_post_meta( $post_id, 'saut_7', esc_attr( $_POST['saut_7'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['saut_8'] ) )
			update_post_meta( $post_id, 'saut_8', esc_attr( $_POST['saut_8'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['saut_9'] ) )
			update_post_meta( $post_id, 'saut_9', esc_attr( $_POST['saut_9'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['saut_10'] ) )
			update_post_meta( $post_id, 'saut_10', esc_attr( $_POST['saut_10'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['saut_11'] ) )
			update_post_meta( $post_id, 'saut_11', esc_attr( $_POST['saut_11'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['saut_12'] ) )
			update_post_meta( $post_id, 'saut_12', esc_attr( $_POST['saut_12'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['saut_impression'] ) )
			update_post_meta( $post_id, 'saut_impression', esc_attr( $_POST['saut_impression'] ) );
		// ---------------------------------------------
	}
	
}