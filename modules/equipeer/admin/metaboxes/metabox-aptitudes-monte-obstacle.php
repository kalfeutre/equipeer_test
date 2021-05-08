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
class Equipeer_Metabox_Aptitudes_Obstacle extends Equipeer {
	
	private $mt_prefix = 'aptitudes-obstacle';
	
    /**
     * Constructor for the Equipeer_Metabox_Aptitudes_Obstacle class
     *
     * Sets up all the appropriate hooks and actions
     */
    function __construct() {
        // Add metaboxes
        add_action( 'add_meta_boxes', array( $this, 'aptitudes_obstacle_add_meta_box' ) );
		// Save infos from metaboxes
		add_action( 'save_post', array( $this, 'aptitudes_obstacle_save' ) );
		// Metabox class (call)
		$this->metaboxClass = new Equipeer_Metabox();
	}
	
    /**
     * Adds the meta box container.
     */
	function aptitudes_obstacle_add_meta_box() {
		add_meta_box(
			'equipeer-' . $this->mt_prefix,
			__( 'Sports skills', EQUIPEER_ID ) . ' : ' . __( 'Mounted at the obstacle', EQUIPEER_ID ),
			array( $this, 'aptitudes_obstacle_html' ),
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
	function aptitudes_obstacle_html( $post) {
		wp_nonce_field( '_aptitudes_obstacle_nonce', 'aptitudes_obstacle_nonce' ); ?>
	
		<table class="form-table">
			<tr class="row-1 even" valign="top">
				<th scope="row" class="first" style="vertical-align: top;">
					<p id="block_obstacle_caractere" class="equipeer_p_form">
						<label for="obstacle_caractere"><?php _e( 'Vocation', EQUIPEER_ID ); ?></span></label><br>
						<?php echo equipeer_get_score_select( 'obstacle_caractere' ); ?>
					</p>
					<p id="block_obstacle_disponibilite" class="equipeer_p_form">
						<label for="obstacle_disponibilite"><?php _e( 'Disponibility', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'obstacle_disponibilite' ); ?>
					</p>
					<p id="block_obstacle_equilibre" class="equipeer_p_form">
						<label for="obstacle_equilibre"><?php _e( 'Balanced', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'obstacle_equilibre' ); ?>
					</p>
					<p id="block_obstacle_style" class="equipeer_p_form">
						<label for="obstacle_style"><?php _e( 'Style', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'obstacle_style' ); ?>
					</p>
					<p id="block_obstacle_experience" class="equipeer_p_form">
						<label for="obstacle_experience"><?php _e( 'Experience', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'obstacle_experience' ); ?>
					</p>
					<p id="block_obstacle_stabilite" class="equipeer_p_form">
						<label for="obstacle_stabilite"><?php _e( 'Stability', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'obstacle_stabilite' ); ?>
					</p>
					<p id="block_obstacle_7" class="equipeer_p_form">
						<label for="obstacle_7"><?php _e( 'Obstacle 7', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'obstacle_7' ); ?>
					</p>
					<p id="block_obstacle_8" class="equipeer_p_form">
						<label for="obstacle_8"><?php _e( 'Obstacle 8', EQUIPEER_ID ); ?></label><br>
						<?php echo equipeer_get_score_select( 'obstacle_8' ); ?>
					</p>
				</th>
				<td class="second tf-note" style="vertical-align: top;">
					<label for="obstacle_impression" style="display: block; margin: 1em 0;"><?php _e( 'Overall Feeling', EQUIPEER_ID ); ?></label>
					<textarea rows="2" cols="70" name="obstacle_impression" id="obstacle_impression"><?php echo $this->metaboxClass->get_meta_value( 'obstacle_impression' ); ?></textarea>
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
	function aptitudes_obstacle_save( $post_id ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		// Check if our nonce is set AND if that the nonce is valid
		if ( ! isset( $_POST['aptitudes_obstacle_nonce'] ) || ! wp_verify_nonce( $_POST['aptitudes_obstacle_nonce'], '_aptitudes_obstacle_nonce' ) ) return;
		// Check the user's permissions
		if ( ! current_user_can( 'equipeer_edit_equine', $post_id ) ) return;
		// ---------------------------------------------
		// Update the meta field
		// ---------------------------------------------
		if ( isset( $_POST['obstacle_caractere'] ) )
			update_post_meta( $post_id, 'obstacle_caractere', esc_attr( $_POST['obstacle_caractere'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['obstacle_disponibilite'] ) )
			update_post_meta( $post_id, 'obstacle_disponibilite', esc_attr( $_POST['obstacle_disponibilite'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['obstacle_equilibre'] ) )
			update_post_meta( $post_id, 'obstacle_equilibre', esc_attr( $_POST['obstacle_equilibre'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['obstacle_style'] ) )
			update_post_meta( $post_id, 'obstacle_style', esc_attr( $_POST['obstacle_style'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['obstacle_experience'] ) )
			update_post_meta( $post_id, 'obstacle_experience', esc_attr( $_POST['obstacle_experience'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['obstacle_stabilite'] ) )
			update_post_meta( $post_id, 'obstacle_stabilite', esc_attr( $_POST['obstacle_stabilite'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['obstacle_7'] ) )
			update_post_meta( $post_id, 'obstacle_7', esc_attr( $_POST['obstacle_7'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['obstacle_8'] ) )
			update_post_meta( $post_id, 'obstacle_8', esc_attr( $_POST['obstacle_8'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['obstacle_impression'] ) )
			update_post_meta( $post_id, 'obstacle_impression', esc_attr( $_POST['obstacle_impression'] ) );
		// ---------------------------------------------
	}
	
}