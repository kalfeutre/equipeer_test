<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Metabox Equine Profil Cavalier
 *
 * @class Metabox
 */
class Equipeer_Metabox_Profil_Cavalier extends Equipeer {
	
	private $mt_prefix = 'profil-cavalier';
	
    /**
     * Constructor for the Equipeer_Metabox_Profil_Cavalier class
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
			__( 'Rider Profile', EQUIPEER_ID ),
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
	
		<table class="form-table">
			<tr class="row-0 even" valign="top">
				<th scope="row" class="first">
					<label for="type_canasson"><?php _e( 'Rider Age', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<select name="cavalier_age" id="cavalier_age" class="equipeer-select">
						<option value=""><?php _e( '&mdash; Select &mdash;', EQUIPEER_ID ); ?></option>
						<?php
							// ---------------------------------------------
							$taxonomies_rider_age = equipeer_get_terms('equipeer_rider_age', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
							// ---------------------------------------------
							if ($taxonomies_rider_age) {
								// ---------------------------------------------
								foreach( $taxonomies_rider_age as $taxonomy ) {
									echo '<option value="' . $taxonomy['id'] . '" ';
									echo selected( $this->metaboxClass->get_meta_value('cavalier_age'), $taxonomy['id'] );
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
			<tr class="row-1 odd" valign="top">
				<th scope="row" class="first">
					<label for="type_canasson"><?php _e( 'Rider Gender', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">			
					<select name="cavalier_genre" id="cavalier_genre" class="equipeer-select">
						<option value=""><?php _e( '&mdash; Select &mdash;', EQUIPEER_ID ); ?></option>
						<?php
							// ---------------------------------------------
							$taxonomies_rider_gender = equipeer_get_terms('equipeer_rider_gender', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
							// ---------------------------------------------
							if ($taxonomies_rider_gender) {
								// ---------------------------------------------
								foreach( $taxonomies_rider_gender as $taxonomy ) {
									echo '<option value="' . $taxonomy['id'] . '" ';
									echo selected( $this->metaboxClass->get_meta_value('cavalier_genre'), $taxonomy['id'] );
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
			<tr class="row-2 even" valign="top">
				<th scope="row" class="first">
					<label for="discipline"><?php _e( 'Rider Level', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">			
					<select name="cavalier_niveau" id="cavalier_niveau" class="equipeer-select">
						<option value=""><?php _e( '&mdash; Select &mdash;', EQUIPEER_ID ); ?></option>
						<?php
							// ---------------------------------------------
							$taxonomies_rider_level = equipeer_get_terms('equipeer_rider_level', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
							// ---------------------------------------------
							if ($taxonomies_rider_level) {
								// ---------------------------------------------
								foreach( $taxonomies_rider_level as $taxonomy ) {
									echo '<option value="' . $taxonomy['id'] . '" ';
									echo selected( $this->metaboxClass->get_meta_value('cavalier_niveau'), $taxonomy['id'] );
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
			<tr class="row-3 odd" valign="top">
				<th scope="row" class="first">
					<label for="sex"><?php _e( 'Rider Behavior', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">			
					<select name="cavalier_comportement" id="cavalier_comportement" class="equipeer-select">
						<option value=""><?php _e( '&mdash; Select &mdash;', EQUIPEER_ID ); ?></option>
						<?php
							// ---------------------------------------------
							$taxonomies_rider_level = equipeer_get_terms('equipeer_rider_behavior', array( 'equipeer_select_taxonomy_parent_id' ), 'horse');
							// ---------------------------------------------
							if ($taxonomies_rider_level) {
								// ---------------------------------------------
								foreach( $taxonomies_rider_level as $taxonomy ) {
									echo '<option value="' . $taxonomy['id'] . '" ';
									echo selected( $this->metaboxClass->get_meta_value('cavalier_comportement'), $taxonomy['id'] );
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
			<tr class="row-4 even" valign="top">
				<th scope="row" class="first">
					<label for="cavalier_profil"><?php _e( 'Profile', EQUIPEER_ID ); ?></label>
				</th>
				<td class="second tf-note">
					<textarea rows="6" cols="70" name="cavalier_profil" id="cavalier_profil"><?php echo $this->metaboxClass->get_meta_value( 'cavalier_profil' ); ?></textarea>
				</td>
			</tr>
		</table>
		<script>
			jQuery(function($) {

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
		if ( isset( $_POST['cavalier_age'] ) )
			update_post_meta( $post_id, 'cavalier_age', esc_attr($_POST['cavalier_age']) );
		// ---------------------------------------------
		if ( isset( $_POST['cavalier_genre'] ) )
			update_post_meta( $post_id, 'cavalier_genre', esc_attr($_POST['cavalier_genre']) );
		// ---------------------------------------------
		if ( isset( $_POST['cavalier_niveau'] ) )
			update_post_meta( $post_id, 'cavalier_niveau', esc_attr($_POST['cavalier_niveau']) );		
		// ---------------------------------------------
		if ( isset( $_POST['cavalier_comportement'] ) )
			update_post_meta( $post_id, 'cavalier_comportement', esc_attr( $_POST['cavalier_comportement'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['cavalier_profil'] ) )
			update_post_meta( $post_id, 'cavalier_profil', esc_attr( $_POST['cavalier_profil'] ) );
		// ---------------------------------------------
	}
	
}