<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class ADMIN USERS
 *
 * @class ADMIN USERS
 */
class Equipeer_Admin_User_Profile extends Equipeer {
	
    public function __construct() {
        add_action( 'show_user_profile', array( $this, 'add_meta_fields' ), 20 );
        add_action( 'edit_user_profile', array( $this, 'add_meta_fields' ), 20 );

        add_action( 'personal_options_update', array( $this, 'save_meta_fields' ) );
        add_action( 'edit_user_profile_update', array( $this, 'save_meta_fields' ) );
		
		add_filter( 'manage_users_columns', array( $this, 'modify_user_table' ) );
		add_filter( 'manage_users_custom_column', array( $this, 'modify_user_table_row' ), 10, 3 );
		add_filter( 'manage_users_sortable_columns', array( $this, 'column_sortable' ) );
		
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    /**
     * Enqueue Script in admin profile
     *
     * @param  string $page
     *
     * @return void
     */
    function enqueue_scripts( $page ) {
        if ( in_array( $page, array( 'profile.php', 'user-edit.php' ) ) ) {
            wp_enqueue_media();

            $admin_admin_script = array(
                'ajaxurl'     => admin_url( 'admin-ajax.php' ),
                'nonce'       => wp_create_nonce( 'equipeer_reviews' ),
                'ajax_loader' => EQUIPEER_URL . '/assets/images/ajax-loader.gif',
                'client'      => array(
                    'available'    => __( 'Available', EQUIPEER_ID ),
                    'notAvailable' => __( 'Not Available', EQUIPEER_ID ),
                ),
            );

            wp_enqueue_script( 'equipeer-url' );
            wp_localize_script( 'jquery', EQUIPEER_ID . '_user_profile', $admin_admin_script );
        }

    }

    /**
     * Add fields to user profile
     *
     * @param WP_User $user
     *
     * @return void|false
     */
    function add_meta_fields( $user ) {
        if ( ! current_user_can( 'manage_equipeer' ) ) {
            //return;
        }

        $group         = esc_attr( get_user_meta( $user->ID, 'equipeer_user_group', true ) );
        $club          = esc_attr( get_user_meta( $user->ID, 'equipeer_user_club', true ) );
		$activity      = esc_attr( get_user_meta( $user->ID, 'equipeer_user_activity', true ) );
		$activity_desc = esc_attr( get_user_meta( $user->ID, 'equipeer_user_activity_desc', true ) );

		$social_network = esc_attr( get_user_meta( $user->ID, 'equipeer_user_social_network', true ) );
		$social_id      = esc_attr( get_user_meta( $user->ID, 'equipeer_user_social_id', true ) );
		
		$equestrian_level        = esc_attr( get_user_meta( $user->ID, 'equipeer_user_equestrian_level', true ) );
		$equestrian_discipline_1 = esc_attr( get_user_meta( $user->ID, 'equipeer_user_equestrian_discipline', true ) );
		$equestrian_discipline_2 = esc_attr( get_user_meta( $user->ID, 'equipeer_user_equestrian_discipline_2', true ) );
		$equestrian_discipline_3 = esc_attr( get_user_meta( $user->ID, 'equipeer_user_equestrian_discipline_3', true ) );
		
		$business_name = esc_attr( get_user_meta( $user->ID, 'equipeer_user_businessname', true ) );
		$siret         = esc_attr( get_user_meta( $user->ID, 'equipeer_user_siret', true ) );
		
		$civility        = esc_attr( get_user_meta( $user->ID, 'equipeer_user_civility', true ) );		
        $address_street1 = esc_attr( get_user_meta( $user->ID, 'equipeer_user_address_1', true ) );
        $address_street2 = esc_attr( get_user_meta( $user->ID, 'equipeer_user_address_2', true ) );
        $address_zip     = esc_attr( get_user_meta( $user->ID, 'equipeer_user_zip', true ) );
        $address_city    = esc_attr( get_user_meta( $user->ID, 'equipeer_user_city', true ) );
        $address_country = esc_attr( get_user_meta( $user->ID, 'equipeer_user_country', true ) );
		
		$sex        = esc_attr( get_user_meta( $user->ID, 'equipeer_user_sex', true ) );
		$phone      = esc_attr( get_user_meta( $user->ID, 'equipeer_user_telephone', true ) );
		$birthday   = esc_attr( get_user_meta( $user->ID, 'equipeer_user_birthday', true ) );
		$newsletter = esc_attr( get_user_meta( $user->ID, 'equipeer_user_newsletter', true ) );
        ?>
		
		<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
		<link rel="stylesheet" href="/resources/demos/style.css">
		<!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>-->
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

		<h2>SOCIAL NETWORK CLIENTS (EQUIPEER - OLD)</h2>
	
		<table class="form-table">
			<tr>
				<th><label for="address">Social name</label></th>
				<td>
					<input type="text" name="equipeer_user_social_network" id="equipeer_user_social_network" value="<?php echo $social_network; ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th><label for="address">Social ID</label></th>
				<td>
					<input type="text" name="equipeer_user_social_id" id="equipeer_user_social_id" value="<?php echo $social_id; ?>" class="regular-text" />
				</td>
			</tr>
		</table>
	
		<h2>INFORMATIONS CLIENTS (EQUIPEER)</h2>
	
		<table class="form-table">
			<tr>
				<th><label for="address">Newsletter</label></th>
				<td>
					<input type="checkbox" name="equipeer_user_newsletter" id="equipeer_user_newsletter" value="1" class="regular-text" <?php checked( $newsletter, 1 ); ?> />
				</td>
			</tr>
			<tr>
				<th><label for="address">Sexe</label></th>
				<td>
					<select name="equipeer_user_sex" id="equipeer_user_sex">
						<option value="">Choisissez</option>
						<option value="m" <?php if ($sex == 'm' || $sex == 'h') echo 'selected="selected"'; ?>>Homme</option>
						<option value="f" <?php selected( $sex, 'f' ); ?>>Femme</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="address">Civilité</label></th>
				<td>
					<select name="equipeer_user_civility" id="equipeer_user_civility">
						<option value="">Choisissez</option>
						<option value="1" <?php selected( $civility, 'mr' ); ?>>Monsieur</option>
						<option value="2" <?php selected( $civility, 'mrs' ); ?>>Madame</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="address">Groupe</label></th>
				<td>
					<select name="equipeer_user_group" id="equipeer_user_group">
						<option value="">Choisissez un groupe</option>
						<option value="1" <?php selected( $group, 1 ); ?>>Professionnel</option>
						<option value="2" <?php selected( $group, 2 ); ?>>Particulier</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="address">Société (Nom)</label></th>
				<td>
					<input type="text" name="equipeer_user_businessname" id="equipeer_user_businessname" value="<?php echo $business_name; ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th><label for="address">Siret</label></th>
				<td>
					<input type="text" name="equipeer_user_siret" id="equipeer_user_siret" value="<?php echo $siret; ?>" class="regular-text" />
				</td>
			</tr>
		</table>

		<h2>ADRESSES CLIENTS (EQUIPEER)</h2>
	
		<table class="form-table">
			<tr>
				<th><label for="address">Adresse 1</label></th>
				<td>
					<input type="text" name="equipeer_user_address_1" id="equipeer_user_address_1" value="<?php echo $address_street1; ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th><label for="address">Adresse 2</label></th>
				<td>
					<input type="text" name="equipeer_user_address_2" id="equipeer_user_address_2" value="<?php echo $address_street2; ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th><label for="address">Code postal</label></th>
				<td>
					<input type="text" name="equipeer_user_zip" id="equipeer_user_zip" value="<?php echo $address_zip; ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th><label for="address">Ville</label></th>
				<td>
					<input type="text" name="equipeer_user_city" id="equipeer_user_city" value="<?php echo $address_city; ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th><label for="address">Pays</label></th>
				<td>
					<input type="text" name="equipeer_user_country" id="equipeer_user_country" value="<?php echo $address_country; ?>" class="regular-text" />
				</td>
			</tr>
		</table>

		<h2>INFORMATIONS EQUESTRES (EQUIPEER)</h2>
	
		<table class="form-table">
			<tr>
				<th><label for="address">Club</label></th>
				<td>
					<input type="text" name="equipeer_user_club" id="equipeer_user_club" value="<?php echo $club; ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th><label for="address">Niveau équestre</label></th>
				<td>
					<?php $terms_equestrian_level = get_terms('equipeer_equestrian_level', 'orderby=none&hide_empty'); ?>
					<select name="equipeer_user_equestrian_level" id="equipeer_user_equestrian_level">
						<option value="">Choisissez un niveau</option>
						<?php
							foreach($terms_equestrian_level as $row) {
								// SLUG : $row->slug
								echo '<option value="' . $row->term_id . '" ' . selected( $equestrian_level, $row->term_id ) . '>';
								echo $row->name;
								echo '</option>';
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="address">Discipline équestre (1)</label></th>
				<td>
					<?php $terms_equestrian_discipline = get_terms('equipeer_equestrian_discipline', 'orderby=name&hide_empty'); ?>
					<select name="equipeer_user_equestrian_discipline" id="equipeer_user_equestrian_discipline">
						<option value="">Choisissez une discipline</option>
						<?php
							foreach($terms_equestrian_discipline as $row) {
								// SLUG : $row->slug
								echo '<option value="' . $row->term_id . '" ' . selected( $equestrian_discipline_1, $row->term_id ) . '>';
								echo $row->name;
								echo '</option>';
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="address">Discipline équestre (2)</label></th>
				<td>
					<select name="equipeer_user_equestrian_discipline_2" id="equipeer_user_equestrian_discipline_2">
						<option value="">Choisissez une discipline</option>
						<?php
							foreach($terms_equestrian_discipline as $row) {
								// SLUG : $row->slug
								echo '<option value="' . $row->term_id . '" ' . selected( $equestrian_discipline_2, $row->term_id ) . '>';
								echo $row->name;
								echo '</option>';
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="address">Discipline équestre (3)</label></th>
				<td>
					<select name="equipeer_user_equestrian_discipline_3" id="equipeer_user_equestrian_discipline_3">
						<option value="">Choisissez une discipline</option>
						<?php
							foreach($terms_equestrian_discipline as $row) {
								// SLUG : $row->slug
								echo '<option value="' . $row->term_id . '" ' . selected( $equestrian_discipline_3, $row->term_id ) . '>';
								echo $row->name;
								echo '</option>';
							}
						?>
					</select>
				</td>
			</tr>
		</table>
	
		<h2>AUTRES (EQUIPEER)</h2>
	
		<table class="form-table">
			<tr>
				<th><label for="address">Téléphone</label></th>
				<td>
					<input type="text" name="equipeer_user_telephone" id="equipeer_user_telephone" value="<?php echo $phone; ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th><label for="address">Date d'anniversaire<br>(JJ/MM/AAAA)</label></th>
				<td>
					<input type="text" name="equipeer_user_birthday" id="equipeer_user_birthday" value="<?php echo $birthday; ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th><label for="address">Activité</label></th>
				<td>
					<input type="text" name="equipeer_user_activity" id="equipeer_user_activity" value="<?php echo $activity; ?>" class="regular-text" />
				</td>
			</tr>
			<tr>
				<th><label for="address">Activité (Description)</label></th>
				<td>
					<textarea name="equipeer_user_activity_desc" id="equipeer_user_activity_desc" class="regular-text"><?php echo $activity_desc; ?></textarea>
				</td>
			</tr>
		</table>

        <script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('#equipeer_user_birthday').datepicker({
					dateFormat: 'dd/mm/yy',
					defaultDate: '01/01/1980',
					changeMonth: true,
					changeYear: true,
					firstDay: 1,
					closeText: 'Fermer',
					prevText: 'Précédent',
					nextText: 'Suivant',
					currentText: 'Aujourd\'hui',
					monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
					monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
					dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
					dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
					dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
					weekHeader: 'Sem.'
				}); 
			});
        </script>
        <?php
    }

    /**
     * Save user data
     *
     * @param int $user_id
     *
     * @return void
     */
    function save_meta_fields( $user_id ) {
        if ( ! current_user_can( 'manage_equipeer' ) ) {
            return;
        }

        $post_data = wp_unslash( $_POST );

		update_user_meta( $user_id, 'equipeer_user_group', $post_data['equipeer_user_group'] );
		update_user_meta( $user_id, 'equipeer_user_club', $post_data['equipeer_user_club'] );
		update_user_meta( $user_id, 'equipeer_user_activity', $post_data['equipeer_user_activity'] );
		update_user_meta( $user_id, 'equipeer_user_activity_desc', $post_data['equipeer_user_activity_desc'] );
		
		update_user_meta( $user_id, 'equipeer_user_social_network', $post_data['equipeer_user_social_network'] );
		update_user_meta( $user_id, 'equipeer_user_social_id', $post_data['equipeer_user_social_id'] );

		update_user_meta( $user_id, 'equipeer_user_equestrian_level', $post_data['equipeer_user_equestrian_level'] );
		update_user_meta( $user_id, 'equipeer_user_equestrian_discipline', $post_data['equipeer_user_equestrian_discipline'] );
		update_user_meta( $user_id, 'equipeer_user_equestrian_discipline_2', $post_data['equipeer_user_equestrian_discipline_2'] );
		update_user_meta( $user_id, 'equipeer_user_equestrian_discipline_3', $post_data['equipeer_user_equestrian_discipline_3'] );

		update_user_meta( $user_id, 'equipeer_user_businessname', $post_data['equipeer_user_businessname'] );
		update_user_meta( $user_id, 'equipeer_user_siret', $post_data['equipeer_user_siret'] );

		update_user_meta( $user_id, 'equipeer_user_civility', $post_data['equipeer_user_civility'] );
		update_user_meta( $user_id, 'equipeer_user_address_1', $post_data['equipeer_user_address_1'] );
		update_user_meta( $user_id, 'equipeer_user_address_2', $post_data['equipeer_user_address_2'] );
		update_user_meta( $user_id, 'equipeer_user_zip', $post_data['equipeer_user_zip'] );
		update_user_meta( $user_id, 'equipeer_user_city', $post_data['equipeer_user_city'] );
		update_user_meta( $user_id, 'equipeer_user_country', $post_data['equipeer_user_country'] );
		
		update_user_meta( $user_id, 'equipeer_user_sex', $post_data['equipeer_user_sex'] );
		update_user_meta( $user_id, 'equipeer_user_telephone', $post_data['equipeer_user_telephone'] );
		update_user_meta( $user_id, 'equipeer_user_birthday', $post_data['equipeer_user_birthday'] );
		update_user_meta( $user_id, 'equipeer_user_newsletter', $post_data['equipeer_user_newsletter'] );
    }
	
    /**
     * Add custom columns
     *
     * @param string $column
     *
     * @return array
     */
	function modify_user_table( $column ) {
		$column['social'] = 'Social';
		//$column['xyz'] = 'XYZ';
		return $column;
	}
	
    /**
     * Add custom columns
     *
     * @param string $val
     * @param string $column_name
     * @param int $user_id
     *
     * @return string
     */
	function modify_user_table_row( $val, $column_name, $user_id ) {
		switch ($column_name) {
			case 'social' :
				$equipeer_social_network = get_the_author_meta( 'equipeer_user_social_network', $user_id );
				return ($equipeer_social_network) ? $equipeer_social_network : '--';
			break;
			//case 'xyz' :
				//return '';
			//break;
			default:
				return '';
			break;
		}
		return $val;
	}
	
	/*
	 * Make column sortable
	 *
	 * @param array $columns Array of all user sortable columns {column ID} => {orderby GET-param}
	 *
	 * return void
	 */
	function column_sortable( $columns ) {
		return wp_parse_args( array( 'social' => 'equipeer_user_social_network' ), $columns );
	}
	
}