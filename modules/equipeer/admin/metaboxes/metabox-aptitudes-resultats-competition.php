<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Metabox Equine Resultats Competition
 *
 * @class Metabox
 */
class Equipeer_Metabox_Resultats_Competition extends Equipeer {
	
	private $mt_prefix = 'resultats-competition';
	
    /**
     * Constructor for the Equipeer_Metabox_Resultats_Competition class
     *
     * Sets up all the appropriate hooks and actions
     */
    function __construct() {
        // Add metaboxes
        add_action( 'add_meta_boxes', array( $this, 'resultats_competition_add_meta_box' ) );
		// Save infos from metaboxes
		add_action( 'save_post', array( $this, 'resultats_competition_save' ) );
		// Metabox class (call)
		$this->metaboxClass = new Equipeer_Metabox();
	}
	
    /**
     * Adds the meta box container.
     */
	function resultats_competition_add_meta_box() {
		add_meta_box(
			'equipeer-' . $this->mt_prefix,
			__( 'Sports skills', EQUIPEER_ID ) . ' : ' . __( 'Results in competition', EQUIPEER_ID ),
			array( $this, 'resultats_competition_html' ),
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
	function resultats_competition_html( $post) {
		wp_nonce_field( '_resultats_competition_nonce', 'resultats_competition_nonce' ); ?>
	
		<div class="equipeer-none">
		<p id="block_competition_100" class="equipeer_p_form">
			<label for="competition_100"><?php _e( 'Classified 100', EQUIPEER_ID ); ?></label><br>
			<input type="text" name="competition_100" id="competition_100" value="<?php echo $this->metaboxClass->get_meta_value( 'competition_100' ); ?>">
		</p>
		<p id="block_competition_110" class="equipeer_p_form">
			<label for="competition_110"><?php _e( 'Classified 110', EQUIPEER_ID ); ?></label><br>
			<input type="text" name="competition_110" id="competition_110" value="<?php echo $this->metaboxClass->get_meta_value( 'competition_110' ); ?>">
		</p>
		<p id="block_competition_115" class="equipeer_p_form">
			<label for="competition_115"><?php _e( 'Classified 115', EQUIPEER_ID ); ?></label><br>
			<input type="text" name="competition_115" id="competition_115" value="<?php echo $this->metaboxClass->get_meta_value( 'competition_115' ); ?>">
		</p>
		<p id="block_competition_120" class="equipeer_p_form">
			<label for="competition_120"><?php _e( 'Classified 120', EQUIPEER_ID ); ?></label><br>
			<input type="text" name="competition_120" id="competition_120" value="<?php echo $this->metaboxClass->get_meta_value( 'competition_120' ); ?>">
		</p>
		<p id="block_competition_130" class="equipeer_p_form">
			<label for="competition_130"><?php _e( 'Classified 130', EQUIPEER_ID ); ?></label><br>
			<input type="text" name="competition_130" id="competition_130" value="<?php echo $this->metaboxClass->get_meta_value( 'competition_130' ); ?>">
		</p>
		<p id="block_competition_135" class="equipeer_p_form">
			<label for="competition_135"><?php _e( 'Classified 135', EQUIPEER_ID ); ?></label><br>
			<input type="text" name="competition_135" id="competition_135" value="<?php echo $this->metaboxClass->get_meta_value( 'competition_135' ); ?>">
		</p>
		<p id="block_competition_140" class="equipeer_p_form">
			<label for="competition_140"><?php _e( 'Classified 140', EQUIPEER_ID ); ?></label><br>
			<input type="text" name="competition_140" id="competition_140" value="<?php echo $this->metaboxClass->get_meta_value( 'competition_140' ); ?>">
		</p>
		<p id="block_competition_140_plus" class="equipeer_p_form">
			<label for="competition_140_plus"><?php _e( 'Classified 140 and +', EQUIPEER_ID ); ?></label><br>
			<input type="text" name="competition_140_plus" id="competition_140_plus" value="<?php echo $this->metaboxClass->get_meta_value( 'competition_140_plus' ); ?>">
		</p>
		<p id="block_competition_9" class="equipeer_p_form">
			<label for="competition_9"><?php _e( 'International', EQUIPEER_ID ); ?></label><br>
			<input type="text" name="competition_9" id="competition_9" value="<?php echo $this->metaboxClass->get_meta_value( 'competition_9' ); ?>">
		</p>
		</div>
	
		<table class="form-table">
			<tr id="block_level" class="row-1 odd" valign="top">
				<th scope="row" class="first">
					<label for="level"><?php _e( 'Actual level', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<select name="level" id="level" class="equipeer-select">
						<option value=""><?php _e( '&mdash; Select &mdash;', EQUIPEER_ID ); ?></option>
						<?php
							// ---------------------------------------------
							$taxonomies_size = equipeer_get_terms('equipeer_level', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
							// ---------------------------------------------
							if ($taxonomies_size) {
								// ---------------------------------------------
								foreach( $taxonomies_size as $taxonomy ) {
									echo '<option value="' . $taxonomy['id'] . '" ';
									echo selected( $this->metaboxClass->get_meta_value('level'), $taxonomy['id'] );
									echo '>';
									echo $taxonomy['name'];
									echo '</option>';
								}
								// ---------------------------------------------
							}
						?>
					</select>
				</td>
			</tr>
			<tr id="block_level_description" class="row-11 even" valign="top">
				<th scope="row" class="first">
					<label for="level_description"><?php _e( 'Level', EQUIPEER_ID ); ?><br>Texte suppl&eacute;mentaire</label>
				</th>
				<td class="second tf-note">
					<textarea rows="2" cols="70" name="level_description" id="level_description"><?php echo $this->metaboxClass->get_meta_value( 'level_description' ); ?></textarea>
				</td>
			</tr>
			<tr id="block_potentiel" class="row-1 odd" valign="top">
				<th scope="row" class="first">
					<label for="potentiel"><?php _e( 'Potential', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<select name="potentiel" id="potentiel" class="equipeer-select">
						<option value=""><?php _e( '&mdash; Select &mdash;', EQUIPEER_ID ); ?></option>
						<?php
							// ---------------------------------------------
							$taxonomies_size = equipeer_get_terms('equipeer_potential', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
							// ---------------------------------------------
							if ($taxonomies_size) {
								// ---------------------------------------------
								foreach( $taxonomies_size as $taxonomy ) {
									echo '<option value="' . $taxonomy['id'] . '" ';
									echo selected( $this->metaboxClass->get_meta_value('potentiel'), $taxonomy['id'] );
									echo '>';
									echo $taxonomy['name'];
									echo '</option>';
								}
								// ---------------------------------------------
							}
						?>
					</select>
				</td>
			</tr>
			<tr id="block_potentiel_description" class="row-11 even" valign="top">
				<th scope="row" class="first">
					<label for="potentiel_description"><?php _e( 'Potential', EQUIPEER_ID ); ?><br>Texte suppl&eacute;mentaire</label>
				</th>
				<td class="second tf-note">
					<textarea rows="2" cols="70" name="potentiel_description" id="potentiel_description"><?php echo $this->metaboxClass->get_meta_value( 'potentiel_description' ); ?></textarea>
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
	function resultats_competition_save( $post_id ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		// Check if our nonce is set AND if that the nonce is valid
		if ( ! isset( $_POST['resultats_competition_nonce'] ) || ! wp_verify_nonce( $_POST['resultats_competition_nonce'], '_resultats_competition_nonce' ) ) return;
		// Check the user's permissions
		if ( ! current_user_can( 'equipeer_edit_equine', $post_id ) ) return;
		// ---------------------------------------------
		// Update the meta field
		// ---------------------------------------------
		if ( isset( $_POST['competition_100'] ) )
			update_post_meta( $post_id, 'competition_100', esc_attr( $_POST['competition_100'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['competition_110'] ) )
			update_post_meta( $post_id, 'competition_110', esc_attr( $_POST['competition_110'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['competition_115'] ) )
			update_post_meta( $post_id, 'competition_115', esc_attr( $_POST['competition_115'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['competition_120'] ) )
			update_post_meta( $post_id, 'competition_120', esc_attr( $_POST['competition_120'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['competition_130'] ) )
			update_post_meta( $post_id, 'competition_130', esc_attr( $_POST['competition_130'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['competition_135'] ) )
			update_post_meta( $post_id, 'competition_135', esc_attr( $_POST['competition_135'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['competition_140'] ) )
			update_post_meta( $post_id, 'competition_140', esc_attr( $_POST['competition_140'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['competition_140_plus'] ) )
			update_post_meta( $post_id, 'competition_140_plus', esc_attr( $_POST['competition_140_plus'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['competition_9'] ) )
			update_post_meta( $post_id, 'competition_9', esc_attr( $_POST['competition_9'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['level'] ) )
			update_post_meta( $post_id, 'level', esc_attr( $_POST['level'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['level_description'] ) )
			update_post_meta( $post_id, 'level_description', esc_attr( $_POST['level_description'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['potentiel'] ) )
			update_post_meta( $post_id, 'potentiel', esc_attr( $_POST['potentiel'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['potentiel_description'] ) )
			update_post_meta( $post_id, 'potentiel_description', esc_attr( $_POST['potentiel_description'] ) );
		// ---------------------------------------------
	}
	
}