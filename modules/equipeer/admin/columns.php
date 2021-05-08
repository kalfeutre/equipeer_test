<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Columns
 *
 * @class Options
 */
class Equipeer_Admin_Columns extends Equipeer {
	
	private $thumbnail_width  = 120;
	private $thumbnail_height = 120;
	
    /**
     * Constructor for the Equipeer_Admin_Columns class
     *
     * Sets up all the appropriate hooks and actions
     */
	function __construct() {
		// Get custom columns
		add_filter( 'manage_equine_posts_columns' , array( $this, 'get_columns_equine' ) );
		// Output Table Cell Contents
		add_action( 'manage_equine_posts_custom_column', array( $this, 'get_value_columns' ) );
		// Columns Sortable
		add_filter( 'manage_edit-equine_sortable_columns', array( $this, 'get_sortable_columns_equine' ) );
		// Custom sort columns
		add_filter( "request", array( $this, "sort_column_by_modified" ) );
		// Extend search custom posts
		add_action( 'pre_get_posts', array( $this, 'extend_cpt_admin_search' ) );
		// Extend search in title AND meta
		add_action( 'pre_get_posts', array( $this, 'meta_or_title_search' ) );
		// Sort columns by modified date (Default sort)
		add_action( 'pre_get_posts', array( $this, 'admin_posts_sort_by_date_modified' ) );
		// ------------------------------------------------
		//                    QUICK EDIT
		// ------------------------------------------------
		// Add to our admin_init function
		add_action( 'quick_edit_custom_box', array( $this, 'quick_edit_add' ), 10, 2 );
		// Add to our admin_init function
		add_action( 'save_post', array( $this, 'quick_edit_save_data' ) );
		// Load script in the footer
		add_action( 'admin_enqueue_scripts', array( $this, 'quick_edit_admin_enqueue_scripts' ) );
		// Add Links to Quick Edit
		add_filter( 'post_row_actions', array( $this, 'quick_edit_add_links' ), 10, 2 );
		add_filter( 'page_row_actions', array( $this, 'quick_edit_add_links' ), 10, 2 );
		// ------------------------------------------------
		//                      FILTERS		
		// ------------------------------------------------
		add_action( 'restrict_manage_posts', array( $this, 'filter_type_discipline' ), 10, 2 );     // Filter by Discipline
		add_action( 'restrict_manage_posts', array( $this, 'filter_type_breed' ), 10, 2 );          // Filter by Breed          (Race)
		add_action( 'restrict_manage_posts', array( $this, 'filter_type_color' ), 10, 2 );          // Filter by Color          (Robe)
		add_action( 'restrict_manage_posts', array( $this, 'filter_type_sex' ), 10, 2 );            // Filter by Sex            (Sexe)
		add_action( 'restrict_manage_posts', array( $this, 'filter_type_size' ), 10, 2 );           // Filter by Size           (Taille)
		add_action( 'restrict_manage_posts', array( $this, 'filter_type_level' ), 10, 2 );          // Filter by Level          (Niveau)
		add_action( 'restrict_manage_posts', array( $this, 'filter_type_potential' ), 10, 2 );      // Filter by Potential      (Potentiel)
		add_action( 'restrict_manage_posts', array( $this, 'filter_type_user_experts' ), 10, 2 );   // Filter by Experts        (EQUIPEER Experts)
		add_action( 'restrict_manage_posts', array( $this, 'filter_type_annonce' ), 10, 2 );        // Filter by Ads Type       (Type d'annonces)
		add_action( 'restrict_manage_posts', array( $this, 'filter_type_age' ), 10, 2 );            // Filter by Age            (Age)
		add_action( 'restrict_manage_posts', array( $this, 'filter_price' ), 10, 2 );               // Filter by Price Range    (Prix)
		add_action( 'restrict_manage_posts', array( $this, 'filter_sold' ), 10, 2 );                // Filter by Sold           (Vendu)
		add_action( 'restrict_manage_posts', array( $this, 'filter_type_rider_age' ), 10, 2 );      // Filter by Rider Age      (Ages de cavalier)
		add_action( 'restrict_manage_posts', array( $this, 'filter_type_rider_behavior' ), 10, 2 ); // Filter by Rider Behavior (Comportements de cavalier)
		add_action( 'restrict_manage_posts', array( $this, 'filter_type_rider_gender' ), 10, 2 );   // Filter by Rider Gender   (Genres de cavalier)
		add_action( 'restrict_manage_posts', array( $this, 'filter_type_rider_level' ), 10, 2 );    // Filter by Rider Level    (Niveaux de cavalier)
		// --- QUERY Filters
		add_filter( 'parse_query', array( $this, 'filters_query' ), 10 );
		// ------------------------------------------------
		// Metabox class (call)
		$this->metaboxClass = new Equipeer_Metabox();
		// Titan call
		$this->equipeer_options = TitanFramework::getInstance( EQUIPEER_ID );
		// ------------------------------------------------
	}
	
	/**
	 * Get Admin columns Table List
	 *
	 * @return array
	 */
	function get_columns_equine( $columns ) {
		// ----------------------------------------
		// unset($columns['date']);
		// unset($columns['author']);
		// unset($columns['comments']);
		// ----------------------------------------
		$columns = array(
			  'cb'           => $columns['cb'],
			  'photo'        => __( "Thumbnail", EQUIPEER_ID ),
			  'title'        => __( 'Title', EQUIPEER_ID ),
			  'type'         => __( 'Type', EQUIPEER_ID ),
			  'birthday'     => __( "Age", EQUIPEER_ID ),
			  'reference'    => __( "Reference", EQUIPEER_ID ),
			  'price'        => __( "Price", EQUIPEER_ID ),
			  'discipline'   => __( "Discipline", EQUIPEER_ID ),
			  'dress'        => __( "Dress", EQUIPEER_ID ), // Robe
			  'origin_sire'  => __( "Origin (Sire)", EQUIPEER_ID ), // Pere
			  'sold'         => __( "Sold", EQUIPEER_ID ),
			  'type_annonce' => __( "Ad", EQUIPEER_ID ),
			  //'city'         => __( "City", EQUIPEER_ID ),
			  'date'         => __( 'Date de publication' ),
			  'modified'     => __( 'Date de modification' ),
		);
		return $columns;
	}

	/**
	 * Get Admin columns Table List to be sorted
	 *
	 * @return array
	 */
	function get_sortable_columns_equine( $columns ) {
		$columns = array(
			'title'        => 'title',
			'type'         => 'type_canasson',
			'birthday'     => 'birthday',
			'reference'    => 'reference',
			'price'        => 'price_equipeer',
			'discipline'   => 'discipline',
			'dress'        => 'dress',
			'origin_sire'  => 'origin_sire',
			'sold'         => 'sold',
		    'type_annonce' => 'type_annonce',
			'city'         => 'localisation_city',
			'date'         => 'date',
			'modified'     => 'modified'
		);
		return $columns;
	}
	
	/**
	 * Get Admin columns Table List value
	 *
	 * @return string
	 */
	function get_value_columns( $column ) {
		global $post;
		$post_id = $post->ID;
		switch( $column ) {
			case "birthday":
				$age    = date('Y') - intval( get_post_meta( $post_id, 'birthday', true ) );
				$suffix = ($age > 1) ? ' ans' : ' an'; 
				$value  = $age . $suffix . '<br><span style="font-style: italic; color: lightgrey;">' . get_post_meta( $post_id, 'birthday', true ) . '</span>';
			break;
			case "reference":
				$value = get_post_meta( $post_id, 'reference', true );
			break;
			case "photo":
				$get_children = get_children( 'post_type=attachment&post_mime_type=image&post_parent='.$post_id, ARRAY_A ); // Return ARRAY
				$get_images   = array_values( $get_children );  // Put keys on ARRAY
				// -------------------------------------------------------
				// Verifier s'il y a une nouvelle photo depuis l'import V3
				// -------------------------------------------------------
				$meta_photo_1 = @get_post_meta( $post_id, 'photo_1', true );
				if ( isset($meta_photo_1) && ( $meta_photo_1 == '0' || $meta_photo_1 > 0 ) ) {
					$value = wp_get_attachment_image( intval($meta_photo_1), array($this->thumbnail_width, $this->thumbnail_height), "", array( "class" => "img-responsive" ) );
				} else {
					// Sinon, prendre celle de l'import
					$photo_1_id = (isset($get_images[0]["ID"])) ? $get_images[0]["ID"] : 0; // First attached image
					if ( $photo_1_id > 0 ) {
						$value = wp_get_attachment_image( $photo_1_id, array( $this->thumbnail_width, $this->thumbnail_height ), "", array( "class" => "img-responsive import-attachment-image" ) );
					} else {
						$value = '<img src="' . EQUIPEER_URL . 'assets/images/no_image_available.jpg" with="' . $this->thumbnail_width . 'px" height="' . $this->thumbnail_height . 'px">';
					}
				}
				// Check if value
				if (!$value) {
					$value = '<img src="' . EQUIPEER_URL . 'assets/images/no_image_available.jpg" with="' . $this->thumbnail_width . 'px" height="' . $this->thumbnail_height . 'px">';
				}
				// -------------------------------------------------------
				// Add Watermark "VENDU" if equine is sold
				// -------------------------------------------------------
				if ( get_post_meta( $post_id, 'sold', true ) == 1 )
					$value .= '<img class="equipeer-sold-watermark" src="' . EQUIPEER_URL . 'assets/images/icon-sold.png">';
			break;
			case "discipline":
				$term_id  = get_post_meta( $post_id, 'discipline', true );
				$the_term = get_term( $term_id );
				$value    = $the_term->name;
			break;
			case "dress":
				$term_id  = get_post_meta( $post_id, 'dress', true );
				$the_term = get_term( $term_id );
				$value    = ($the_term) ? $the_term->name : "";
			break;
			case "origin_sire":
				$value = get_post_meta( $post_id, 'origin_sire', true );
			break;
			case "city":
				$value = get_post_meta( $post_id, 'localisation_city', true );
			break;
			case "price":
				$value  = (get_post_meta( $post_id, 'price_equipeer', true )) ? number_format( get_post_meta( $post_id, 'price_equipeer', true ), 0, ",", "." ) : 0;
				$value .= ' &euro;';
			break;
			case "type":
				$value = equipeer_type_horse( get_post_meta( $post_id, 'type_canasson', true ) );
			break;
			case "type_annonce":
				$type  = get_post_meta( $post_id, 'type_annonce', true );
				$value = ($type == 2) ? 'Expertisé' : 'Libre';
			break;
			case "sold":
				$value = ( get_post_meta( $post_id, 'sold', true ) == 0 ) ? '' : '<strong style="color: green">Vendu</strong>';
			break;
			case 'modified':
				$m_orig		= get_post_field( 'post_modified', $post_id, 'raw' );
				$m_stamp	= strtotime( $m_orig );
				$modified	= date('d/m/Y à H:i', $m_stamp );
		
				$modr_id	= get_post_meta( $post_id, '_edit_last', true );
				$auth_id	= get_post_field( 'post_author', $post_id, 'raw' );
				$user_id	= !empty( $modr_id ) ? $modr_id : $auth_id;
				$user_info	= get_userdata( $user_id );
		
				echo '<p class="mod-date">';
				echo '<em>'.$modified.'</em><br />';
				echo 'par <strong>'.$user_info->display_name.'<strong>';
				echo '</p>';
			break;
		}
		// Return VALUE
		if ( isset($value) ) echo $value;
	}
	
	/**
	 * Sort columns by default by Modified date
	 *
	 * @param  $query 	query
	 *
	 * @return void
	 */
	function admin_posts_sort_by_date_modified( $query ) {
		global $pagenow;
		if( is_admin()
			&& 'edit.php' == $pagenow
			&& !isset( $_GET['orderby'] )
			&& @$_GET['post_type'] == 'equine' ) {
				$query->set( 'orderby', 'date' );
				$query->set( 'order', 'DESC' );
		}
	}
	
	/**
	 * Sort columns authorized by meta value
	 *
	 * @param	$vars	orderby
	 *
	 * @return void
	 */
	function sort_column_by_modified( $vars ){
		// Authorized columns
		$authorized_columns = [
			 'birthday'
			,'type_canasson'
			,'reference'
			,'price_equipeer'
			,'discipline'
			,'dress'
			,'origin_sire'
			,'sold'
			,'type_annonce'
			,'localisation_city'
		];
		// If sort "orderby" requested
		if ( isset( $vars["orderby"] ) && $_GET['post_type'] == $this->post_type) {
			// Get orderby if authorized
			if ( in_array( $vars["orderby"], $authorized_columns ) ) {
				$vars = array_merge( $vars, array(
					'meta_key' => $vars["orderby"],
					'orderby' => 'meta_value_num'
				) );
			}
		}
		return $vars;
	}

	/**
	 * Extend custom post type search to also search meta fields
	 * @param  WP_Query $query
	 */
	function extend_cpt_admin_search( $query ) {
		// Make sure we're in the admin area and that this is our custom post type
		if ( !is_admin() || $query->query['post_type'] != $this->post_type ){
			return;
		}
	
		// Put all the meta fields you want to search for here
		$custom_fields = array(
			'birthday'
		   ,'birthday_real'
		   ,'cavalier_profil'
		   ,'comportement'
		   ,'discipline'
		   ,'dress'
		   ,'impression'
		   ,'lieux_essais'
		   ,'localisation_address'
		   ,'localisation_city'
		   ,'localisation_zip'
		   ,'origin_sire'
		   ,'origin_dam'
		   ,'price_equipeer'
		   ,'proprietaire'
		   ,'reference'
		   ,'sire'
		   ,'size_cm'
		   ,'type_canasson'
		);
		// The string submitted via the search form
		$searchterm = $query->query_vars['s'];
	  
		// Set to empty, otherwise no results will be returned.
		// The one downside is that the displayed search text is empty at the top of the page.
		$query->query_vars['s'] = '';
	  
		if ($searchterm != "") {
			// Add additional meta_query parameter to the WP_Query object.
			// Reference: https://codex.wordpress.org/Class_Reference/WP_Query#Custom_Field_Parameters
			$meta_query = array();
			// -----------------------------------------
			// If searching a REFERENCE
			// -----------------------------------------
			if (strtolower(substr($searchterm, 0, 4)) == 'ref:' ) {
				list($type_s, $search_reference) = explode(":", $searchterm, 2);
				$custom_fields = array();
				$custom_fields = array(
					'reference'
				);
				$searchterm = $search_reference;
			}
			foreach($custom_fields as $cf) {
				$_value   = stripslashes( sanitize_text_field( $searchterm ) );
				$_compare = ($key == 'reference') ? 'LIKE' : '=';
				array_push($meta_query, array(
					'key'     => $cf,
					'value'   => htmlspecialchars( $_value, ENT_QUOTES ),
					'compare' => $_compare
				));
			}
			// Use an 'OR' comparison for each additional custom meta field.
			if (count($meta_query) > 1) {
				$meta_query['relation'] = 'OR';
			}
			// Set the meta_query parameter
			$query->set('meta_query', $meta_query);
		
			// To allow the search to also return "OR" results on the post_title
			$query->set('_meta_or_title', $searchterm);
			
			//echo '<pre>';
			//var_dump($query);
			//echo '</pre>';
			//die();
		}
	}	
	
	/**
	 * WP_Query parameter _meta_or_title to allow searching post_title when also
	 * checking searching custom meta values
	 * https://wordpress.stackexchange.com/questions/78649/using-meta-query-meta-query-with-a-search-query-s
	 * https://wordpress.stackexchange.com/a/178492
	 * This looks a little scary, but basically it's modifying the WHERE clause in the 
	 * SQL to say "[like the post_title] OR [the existing WHERE clause]"
	 * @param  WP_Query $q
	 */
	function meta_or_title_search( $q ) {
		if( $title = $q->get( '_meta_or_title' ) ){
			add_filter( 'get_meta_sql', function( $sql ) use ( $title ){
				global $wpdb;
		  
				// Only run once:
				static $nr = 0;
				if( 0 != $nr++ ) return $sql;
		  
				// Modified WHERE
				$sql['where'] = sprintf(
					 " AND ( (%s) OR (%s) ) "
					,$wpdb->prepare( "{$wpdb->posts}.post_title LIKE '%%%s%%'", $title)
					,mb_substr( $sql['where'], 5, mb_strlen( $sql['where'] ) )
				);
		  
				return $sql;
			});
		}
	}
	
	/**
	 * Print checkbox in Quick Edit for each custom column
	 *
	 * @return HTML
	 */
	function quick_edit_add( $column_name, $post_type ) {
		switch ( $column_name ) {
			case 'sold' :
				printf(
					'<fieldset class="inline-edit-col-right">
					  <div class="inline-edit-col column-'.$column_name.'">
						<label class="inline-edit-group">
							<span class="title">%s</span>
							<input type="checkbox" name="sold" class="sold">
						</label>
					  </div>
					</fieldset>',
					__( 'Sold', EQUIPEER_ID )
				);
			break;
		}
	}
	
	/**
	 * Quick Edit save data from form
	 *
	 * @param 	$post_id	POST ID
	 *
	 * @return void
	 */
	function quick_edit_save_data( $post_id ) {
		if ( empty( $_POST ) ) {
			return $post_id;
		}
	
		// Verify quick edit nonce
		if ( isset( $_POST[ '_inline_edit' ] ) && ! wp_verify_nonce( $_POST[ '_inline_edit' ], 'inlineeditnonce' ) ) {
			return $post_id;
		}
	
		// Don't save for autosave
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		
		// Check post_type
		if ( $this->post_type !== $_POST['post_type'] ) {
			return;
		}
		
		// User is authorized to use OR not
		if ( !current_user_can( 'equipeer_edit_equines', $post_id ) ) {
			return;
		}
	
		// Don't save for revisions
		if ( isset( $post->post_type ) && 'revision' === $post->post_type ) {
			return $post_id;
		}
		// the value is checked the value is yes , if unchecked it will be no… these two values are stored in DB also
		if ( isset( $_POST[ '_inline_edit' ] ) && wp_verify_nonce( $_POST[ '_inline_edit' ], 'inlineeditnonce' ) ) {
			if ( isset( $_POST['sold'] ) ) {
				update_post_meta( $post_id, 'sold', '1' );
			} else {
				update_post_meta( $post_id, 'sold' ,'0');
			}
		}		
	}
	
	/**
	 * Quick Edit add admin JS script
	 *
	 * @return void
	 */
	function quick_edit_admin_enqueue_scripts( $hook ) {
	
		if ( 'edit.php' === $hook && isset( $_GET['post_type'] ) && $this->post_type === $_GET['post_type'] ) {
			// Quick Edit Populate fields
			wp_enqueue_script( 'quick_edit_equipeer_script', EQUIPEER_URL . 'assets/js/admin-quick-edit.js', false, null, true );
		}
	
	}
	
	/**
	 * Remove all the quick edit links in the backend when scrolling the list of published posts
	 *
	 * @return array
	 */
	function quick_edit_remove_links( $actions ) {
		// Check current screen
		$screen = get_current_screen();
		if ( $this->post_type !== $screen->post_type ) {
			return $actions;
		}
		
		unset($actions['inline hide-if-no-js']);
		return $actions;
	}

	/**
	 *	Add links in Quick Edit Actions
	 *
	 *	@return array
	 */
	function quick_edit_add_links($actions, $post) {
		// Check post type
		if ( $post->post_type == $this->post_type ) {
			// Get Owner Email
			$owner_email = get_post_meta( $post->ID, 'owner_email', true );
			if ( isset($owner_email) && $owner_email != '' ) {
				// Get user infos by Email
				$user_infos = @get_user_by('email', $owner_email);
				// ---------------------------------------
				// --- Moderate
				// ---------------------------------------
				if ($_GET['post_status'] == 'moderate') {
					$actions['contact']  = '
						<div id="moderate_'.$post->ID.'" class="equipeer-modal">
							<div class="equipeer-modal-content">
								<span id="moderate_'.$post->ID.'_close" class="equipeer-modal-close">&times;</span>
								<div id="modal_'.$post->ID.'">
									<div style="text-align: center;">
										<button class="equipeer-accept" id="moderate_accept" onclick="return equipeer_moderate_confirm(\'accept\', \''.$post->ID.'\', \''.$owner_email.'\');">ACCEPTER</button>
									</div>
									<h1 class="equipeer-title-before-after">&nbsp;&nbsp;OU&nbsp;&nbsp;</h1>
									<div id="moderate-reject-div" class="equipeer-nonee">
										<hr>
										<div style="text-align: center;">
											Email : '.$owner_email.'<br>
											Nom du client : '.ucfirst(strtolower($user_infos->first_name)).' ' . strtoupper($user_infos->last_name) .  '<br>
											<a href="'.get_admin_url().'user-edit.php?user_id='.$user_infos->ID.'" target="_blank">Voir le profil client</a>
										</div>
										<hr>
										<label class="equipeer-label" for="reject_subject">Sujet de l\'email</label>
										<input class="equipeer-form-control" type="text" id="reject_subject_'.$post->ID.'" value="EQUIPEER : Rejet de votre annonce pour '.$post->post_title.'"><br>
										<label class="equipeer-label" for="reject_subject">Motif du rejet de l\'annonce</label><br>
										<textarea rows="7" class="equipeer-form-control" id="reject_cause_'.$post->ID.'"></textarea><br>
										<br>
										<div style="text-align: center;">
											<button class="equipeer-reject" id="moderate_reject" data-id="'.$post->ID.'" onclick="return equipeer_moderate_confirm(\'reject\', \''.$post->ID.'\', \''.$owner_email.'\');">REFUSER</button>
										</div>
									</div>
								</div>
								<div id="modal_loading_'.$post->ID.'" style="width: 100%; text-align: center; padding: 0 0 3em;" class="equipeer-none">
									<h1 style="padding: 0.5em 0 1em;">MODERATION EN COURS... </h1>
									<img src="'.EQUIPEER_URL.'assets/images/loading.gif" style="border: 0px solid #eee; padding: 0;" alt="">
								</div>
							</div>
						</div>';
					$actions['contact'] .= '<a data-email="'.$user_infos->user_email.'" href="" data-id="' . $owner_email . '" title="" rel="permalink" onclick="return equipeer_moderate(\'moderate_'.$post->ID.'\');">Modérer</a>';					
				} else {
					// ---------------------------------------
					// --- Email dialog
					// ---------------------------------------
					$actions['contact'] = '
						<div id="moderate_'.$post->ID.'" class="equipeer-modal">
							<div class="equipeer-modal-content">
								<span id="moderate_'.$post->ID.'_close" class="equipeer-modal-close">&times;</span>
								<div id="modal_'.$post->ID.'">
									<div id="moderate-reject-div" class="equipeer-nonee">
										<div style="text-align: center;">
											Email : '.$owner_email.'<br>
											Nom du client : '.ucfirst(strtolower($user_infos->first_name)).' ' . strtoupper($user_infos->last_name) .  '<br>
											<a href="'.get_admin_url().'user-edit.php?user_id='.$user_infos->ID.'" target="_blank">Voir le profil client</a>
										</div>
										<hr>
										<label class="equipeer-label" for="contact_subject">Sujet de l\'email</label>
										<input class="equipeer-form-control" type="text" id="contact_subject_'.$post->ID.'" value="À propos de votre annonce sur equipeer.com" placeholder=""><br>
										<label class="equipeer-label" for="contact_body">Message de l\'email</label><br>
										<textarea rows="7" class="equipeer-form-control" id="contact_body_'.$post->ID.'"></textarea><br>
										<br>
										<div style="text-align: center;">
											<button class="equipeer-accept" id="contact_send" data-id="'.$post->ID.'" onclick="return equipeer_contact_confirm(\''.$post->ID.'\', \''.$owner_email.'\');">ENVOYER LE MESSAGE</button>
										</div>
									</div>
								</div>
								<div id="modal_loading_'.$post->ID.'" style="width: 100%; text-align: center; padding: 0 0 3em;" class="equipeer-none">
									<h1 style="padding: 0.5em 0 1em;">ENVOI EN COURS... </h1>
									<img src="'.EQUIPEER_URL.'assets/images/loading.gif" style="border: 0px solid #eee; padding: 0;" alt="">
								</div>
							</div>
						</div>
					';
					$actions['contact'] .= '<a data-email="'.$user_infos->user_email.'" href="" data-id="' . $owner_email . '" title="" rel="permalink" onclick="return equipeer_contact(\'moderate_'.$post->ID.'\');">' . __( 'Contact client', EQUIPEER_ID ) . '</a>';
					//$actions['contact'] .= '<a data-email="'.$user_infos->user_email.'" href="' . admin_url() . 'edit.php?post_type=equine&page=equipeer_options&tab=equipeer_email_send&email=' . $owner_email . '" data-id="' . $owner_email . '" title="" rel="permalink">' . __( 'Contact client', EQUIPEER_ID ) . '</a>';
				}
			} else {
				$actions['contact'] = '<a onclick="alert(\'' . addslashes( __( 'This equine does not have a owner email!', EQUIPEER_ID ) ) . '\')" href="#" title="" rel="permalink">' . __( 'Contact client', EQUIPEER_ID ) . '</a>';
			}
			// Trash with email
			$lang = (ICL_LANGUAGE_CODE == 'fr') ? ICL_LANGUAGE_CODE : 'en';
			$email_client_body = get_option('equine_email_client_remove_ad_'.$lang);
			$horse_reference   = get_post_meta($post->ID, 'reference', true);
			$horse_name        = get_the_title($post->ID);
			//$email_photo_1     = wp_get_attachment_image_url( get_post_meta($pid, 'photo_1', true), 'thumbnail');
			$email_client_body = @preg_replace("/{CLIENT_NAME}/", esc_html(ucfirst($user_infos->first_name) . ' ' . strtoupper($user_infos->last_name)), $email_client_body);
			//$email_client_body = @preg_replace("/{HORSE_IMAGE}/", "<img style='border: 1px solid #d1023e; padding: 3px;' src='".esc_url($email_photo_1)."' alt=''>", $email_client_body);
			$email_client_body = @preg_replace("/{HORSE_REF}/", esc_html($horse_reference), $email_client_body);
			$email_client_body = @preg_replace("/{HORSE_NAME}/", esc_html($horse_name), $email_client_body);
			$actions['trashemail'] = '
				<div id="trashemail_'.$post->ID.'" class="equipeer-modal">
					<div class="equipeer-modal-content">
						<span id="trashemail_'.$post->ID.'_close" class="equipeer-modal-close">&times;</span>
						<div id="modal_trashemail_'.$post->ID.'">
							<div id="trashemail-div-'.$post->ID.'" class="equipeer-nonee">
								<div style="text-align: center;">
									Email : '.$owner_email.'<br>
									Nom du client : '.ucfirst(strtolower($user_infos->first_name)).' ' . strtoupper($user_infos->last_name) .  '<br>
									<a href="'.get_admin_url().'user-edit.php?user_id='.$user_infos->ID.'" target="_blank">Voir le profil client</a>
								</div>
								<hr>
								<label class="equipeer-label" for="contact_remove_subject_'.$post->ID.'">Sujet de l\'email</label>
								<input class="equipeer-form-control" type="text" id="contact_remove_subject_'.$post->ID.'" value="Suppression de votre annonce sur equipeer.com" placeholder=""><br>
								<label class="equipeer-label" for="contact_remove_body_'.$post->ID.'">Message de l\'email</label><br>
								<textarea rows="7" class="equipeer-form-control" id="contact_remove_body_'.$post->ID.'">' . $email_client_body . '</textarea>
								<span style="font-style: italic; color: grey;">Si vous souhaitez mettre la photo du cheval supprimé, laissez la variable {HORSE_IMAGE}, elle sera remplacée à l\'envoi par la photo du cheval du client sinon supprimez la variable du contenu</span>
								<br>
								<br>
								<div style="text-align: center;">
									<button class="equipeer-reject" id="contact_send" data-id="'.$post->ID.'" onclick="return equipeer_remove_confirm(\''.$post->ID.'\', \''.$owner_email.'\');">ENVOYER LE MESSAGE<br>ET METTRE A LA CORBEILLE</button>
								</div>
							</div>
						</div>
						<div id="modal_trashemail_loading_'.$post->ID.'" style="width: 100%; text-align: center; padding: 0 0 3em;" class="equipeer-none">
							<h1 style="padding: 0.5em 0 1em;">ENVOI EN COURS... </h1>
							<img src="'.EQUIPEER_URL.'assets/images/loading.gif" style="border: 0px solid #eee; padding: 0;" alt="">
						</div>
					</div>
				</div>
			';
			//$actions['trashemail'] = '<a style="color: #dc3232; border: none;" onclick="return confirm(\'Vous souhaitez mettre a la corbeille cette annonce\net prevenir par email le client de sa suppression ?\')" href="/wp-admin/post.php?post=' . $post->ID . '&action=trashemail&post_type=equine&_wpnonce=5c1702feca" title="" rel="permalink">Corbeille avec email</a>';
			$actions['trashemail'] .= '<a style="color: #dc3232; border: none;" data-email="'.$user_infos->user_email.'" href="" data-id="' . $owner_email . '" title="" rel="permalink" onclick="return equipeer_trashemail(\'trashemail_'.$post->ID.'\');">Corbeille avec email</a>';
		}
		return $actions;
	}
	
	
	/**
	 *	Add Admin Filter Discipline
	 *
	 *	@return void
	 */
	function filter_type_discipline( $post_type, $which ) {
		global $typenow, $wp_query;
		
		if ( $this->post_type !== $post_type ) {
			return; //check to make sure this is your cpt
		}
	 
		$request_attr  = 'filter_discipline'; //this will show up in the url
		$taxonomy_slug = 'equipeer_discipline';
		$taxonomy      = get_taxonomy($taxonomy_slug);
		$selected      = isset( $_GET[ $request_attr ] ) ? $_GET[ $request_attr ] : '';
		 
		wp_dropdown_categories(array(
			'show_option_all' =>  __("{$taxonomy->label}"),
			'taxonomy'        =>  $taxonomy_slug,
			'name'            =>  $request_attr,
			'orderby'         =>  'name',
			'selected'        =>  $selected,
			'hierarchical'    =>  true,
			'depth'           =>  3,
			'show_count'      =>  false, // Show number of post in parent term
			'hide_empty'      =>  false, // Don't show posts w/o terms
		) );
	}
	
	/**
	 *	Add Admin Filter Breed (Race)
	 *
	 *	@return void
	 */
	function filter_type_breed( $post_type, $which ) {
		global $typenow, $wp_query;
		
		if ( $this->post_type !== $post_type ) {
			return; //check to make sure this is your cpt
		}
	 
		$request_attr  = 'filter_breed'; //this will show up in the url
		$taxonomy_slug = 'equipeer_breed';
		$taxonomy      = get_taxonomy($taxonomy_slug);
		$selected      = isset( $_GET[ $request_attr ] ) ? $_GET[ $request_attr ] : '';
		 
		wp_dropdown_categories(array(
			'show_option_all' =>  __("{$taxonomy->label}"),
			'taxonomy'        =>  $taxonomy_slug,
			'name'            =>  $request_attr,
			'orderby'         =>  'name',
			'selected'        =>  $selected,
			'hierarchical'    =>  true,
			'depth'           =>  3,
			'show_count'      =>  false, // Show number of post in parent term
			'hide_empty'      =>  false, // Don't show posts w/o terms
		) );
	}
	
	/**
	 *	Add Admin Filter Color (Robe)
	 *
	 *	@return void
	 */
	function filter_type_color( $post_type, $which ) {
		global $typenow, $wp_query;
		
		if ( $this->post_type !== $post_type ) {
			return; //check to make sure this is your cpt
		}
	 
		$request_attr  = 'filter_color'; //this will show up in the url
		$taxonomy_slug = 'equipeer_color';
		$taxonomy      = get_taxonomy($taxonomy_slug);
		$selected      = isset( $_GET[ $request_attr ] ) ? $_GET[ $request_attr ] : '';
		 
		wp_dropdown_categories(array(
			'show_option_all' =>  __("{$taxonomy->label}"),
			'taxonomy'        =>  $taxonomy_slug,
			'name'            =>  $request_attr,
			'orderby'         =>  'name',
			'selected'        =>  $selected,
			'hierarchical'    =>  true,
			'depth'           =>  3,
			'show_count'      =>  false, // Show number of post in parent term
			'hide_empty'      =>  false, // Don't show posts w/o terms
		) );
	}
	
	/**
	 *	Add Admin Filter Sex
	 *
	 *	@return void
	 */
	function filter_type_sex( $post_type, $which ) {
		global $typenow, $wp_query;
		
		if ( $this->post_type !== $post_type ) {
			return; //check to make sure this is your cpt
		}
	 
		$request_attr  = 'filter_sex'; //this will show up in the url
		$taxonomy_slug = 'equipeer_gender';
		$taxonomy      = get_taxonomy($taxonomy_slug);
		$selected      = isset( $_GET[ $request_attr ] ) ? $_GET[ $request_attr ] : '';
		 
		wp_dropdown_categories(array(
			'show_option_all' =>  __("{$taxonomy->label}"),
			'taxonomy'        =>  $taxonomy_slug,
			'name'            =>  $request_attr,
			'orderby'         =>  'name',
			'selected'        =>  $selected,
			'hierarchical'    =>  true,
			'depth'           =>  3,
			'show_count'      =>  false, // Show number of post in parent term
			'hide_empty'      =>  false, // Don't show posts w/o terms
		) );
	}
	
	/**
	 *	Add Admin Filter Size
	 *
	 *	@return void
	 */
	function filter_type_size( $post_type, $which ) {
		global $typenow, $wp_query;
		
		if ( $this->post_type !== $post_type ) {
			return; //check to make sure this is your cpt
		}
	 
		$request_attr  = 'filter_size'; //this will show up in the url
		$taxonomy_slug = 'equipeer_size';
		$taxonomy      = get_taxonomy($taxonomy_slug);
		$selected      = isset( $_GET[ $request_attr ] ) ? $_GET[ $request_attr ] : '';
		 
		wp_dropdown_categories(array(
			'show_option_all' =>  __("{$taxonomy->label}"),
			'taxonomy'        =>  $taxonomy_slug,
			'name'            =>  $request_attr,
			'orderby'         =>  'name',
			'selected'        =>  $selected,
			'hierarchical'    =>  true,
			'depth'           =>  3,
			'show_count'      =>  false, // Show number of post in parent term
			'hide_empty'      =>  false, // Don't show posts w/o terms
		) );
	}
	
	/**
	 *	Add Admin Filter Level (Niveau)
	 *
	 *	@return void
	 */
	function filter_type_level( $post_type, $which ) {
		global $typenow, $wp_query;
		
		if ( $this->post_type !== $post_type ) {
			return; //check to make sure this is your cpt
		}
	 
		$request_attr  = 'filter_level'; //this will show up in the url
		$taxonomy_slug = 'equipeer_level';
		$taxonomy      = get_taxonomy($taxonomy_slug);
		$selected      = isset( $_GET[ $request_attr ] ) ? $_GET[ $request_attr ] : '';
		 
		wp_dropdown_categories(array(
			'show_option_all' =>  __("{$taxonomy->label}"),
			'taxonomy'        =>  $taxonomy_slug,
			'name'            =>  $request_attr,
			'orderby'         =>  'name',
			'selected'        =>  $selected,
			'hierarchical'    =>  true,
			'depth'           =>  3,
			'show_count'      =>  false, // Show number of post in parent term
			'hide_empty'      =>  false, // Don't show posts w/o terms
		) );
	}
	
	/**
	 *	Add Admin Filter Potential (Potentiel)
	 *
	 *	@return void
	 */
	function filter_type_potential( $post_type, $which ) {
		global $typenow, $wp_query;
		
		if ( $this->post_type !== $post_type ) {
			return; //check to make sure this is your cpt
		}
	 
		$request_attr  = 'filter_potential'; //this will show up in the url
		$taxonomy_slug = 'equipeer_potential';
		$taxonomy      = get_taxonomy($taxonomy_slug);
		$selected      = isset( $_GET[ $request_attr ] ) ? $_GET[ $request_attr ] : '';
		 
		wp_dropdown_categories(array(
			'show_option_all' =>  __("{$taxonomy->label}"),
			'taxonomy'        =>  $taxonomy_slug,
			'name'            =>  $request_attr,
			'orderby'         =>  'name',
			'selected'        =>  $selected,
			'hierarchical'    =>  true,
			'depth'           =>  3,
			'show_count'      =>  false, // Show number of post in parent term
			'hide_empty'      =>  false, // Don't show posts w/o terms
		) );
	}
	
	/**
	 *	Add Admin Filter Potential (Potentiel)
	 *
	 *	@return void
	 */
	function filter_type_user_experts( $post_type, $which ) {
		global $typenow, $wp_query;
		
		if ( $this->post_type !== $post_type ) {
			return; //check to make sure this is your cpt
		}
	 
		$request_attr = 'filter_expert';
		$role         = array('equipeer_expert','administrator');
		$selected     = isset( $_GET[ $request_attr ] ) ? $_GET[ $request_attr ] : '';
		
		$query_users_ids_by_role = [
			'blog_id'      => $GLOBALS['blog_id'],
			'role'         => '',
			'role__in'     => $role,
			'role__not_in' => array(),
			'meta_key'     => '',
			'meta_value'   => '',
			'meta_compare' => '',
			'meta_query'   => array(),
			'date_query'   => array(),        
			'include'      => array(),
			'exclude'      => array(),
			'orderby'      => 'nicename', // ID | login | nicename | email | url | registered | display_name | post_count | include | meta_value
			'order'        => 'ASC',      // ASC | DESC
			'offset'       => '',
			'search'       => '',
			'number'       => '',
			'count_total'  => false,
			'fields'       => 'all',
			'who'          => '',
		];
		 
		$experts = get_users( $query_users_ids_by_role );
		?>
		<select id="filter_expert" class="postform" name="filter_expert">
			<option value="">Experts</option>
			<?php
				foreach( $experts as $expert ) {
					echo '<option value="'.$expert->ID.'" ';
					echo selected( $selected, $expert->ID );
					echo '>';
					echo $expert->user_nicename;
					echo '</option>';
				}
			
			?>
		</select>
		<?php
	}
	
	/**
	 *	Add Admin Filter Ads Type
	 *
	 *	@return void
	 */
	function filter_type_annonce( $post_type, $which ) {
		global $typenow, $wp_query;
		
		if ( $this->post_type !== $post_type ) {
			return; //check to make sure this is your cpt
		}
	 
		$request_attr = 'filter_type_annonce';
		$selected     = isset( $_GET[ $request_attr ] ) ? $_GET[ $request_attr ] : '';
	 
		$types = equipeer_get_all_type_ads();
		?>
		<select id="filter_type_annonce" class="postform" name="filter_type_annonce">
			<option value="">Type d'annonces</option>
			<?php
				for($i = 0; $i < count($types); ++$i ) {
					echo '<option value="'.$types[$i]['value'].'" ';
					echo selected( $selected, $types[$i]['value'] );
					echo '>';
					echo $types[$i]['name'];
					echo '</option>';
				}
			
			?>
		</select>
		<?php
	}
	
	/**
	 *	Add Admin Filter Status
	 *
	 *	@return void
	 */
	function filter_type_status( $post_type, $which ) {
		global $typenow, $wp_query;
		
		if ( $this->post_type !== $post_type ) {
			return; //check to make sure this is your cpt
		}
	 
		$request_attr = 'filter_type_status';
		$selected     = isset( $_GET[ $request_attr ] ) ? $_GET[ $request_attr ] : '';
	 
		?>
		<select id="filter_type_status" class="postform" name="filter_type_status">
			<option value="">Statut</option>
			<option value="publish" <?php echo selected( $selected, 'publish' ); ?>>Publié</option>
			<option value="draft" <?php echo selected( $selected, 'draft' ); ?>>Brouillon</option>
			<option value="off" <?php echo selected( $selected, 'off' ); ?>>Off</option>
			<option value="moderate" <?php echo selected( $selected, 'moderate' ); ?>>A Modérer</option>
		</select>
		<?php
	}
	
	/**
	 *	Add Admin Filter Age
	 *
	 *	@return void
	 */
	function filter_type_age( $post_type, $which ) {
		global $typenow, $wp_query;
		
		if ( $this->post_type !== $post_type ) {
			return; //check to make sure this is your cpt
		}
	 
		$request_attr = 'filter_type_age';
		$selected     = isset( $_GET[ $request_attr ] ) ? $_GET[ $request_attr ] : '';
	 
		$max  = 17;
		$year = date('Y');
		?>
		<select id="filter_type_age" class="postform" name="filter_type_age">
			<option value="">Age</option>
			<?php
				for($i = 0; $i < $max; ++$i ) {
					// Value YEAR
					$val_year = $year - $i;
					// Name YEAR
					$name_year = $i . ( ($i > 1) ? ' ans' : ' an' );
					echo '<option value="'.$val_year.'" ';
					echo selected( $selected, $val_year );
					echo '>';
					if ($i == 0) {
						echo 'Foal';
					} elseif ($i == 16) {
						echo $name_year . ' et +';
					} else {
						echo $name_year;
					}
					echo '</option>';
				}
			?>
		</select>
		<input type="button" onclick="window.location.href = '<?php echo get_admin_url()."edit.php?post_type=equine"; ?>';" class="button" value="Réinitialiser">
		<?php
	}
	
	/**
	 *	Add Admin Filter Rider Age (Age de cavalier)
	 *
	 *	@return void
	 */
	function filter_type_rider_age( $post_type, $which ) {
		global $typenow, $wp_query;
		
		if ( $this->post_type !== $post_type ) {
			return; //check to make sure this is your cpt
		}
	 
		$request_attr  = 'filter_rider_age'; //this will show up in the url
		$taxonomy_slug = 'equipeer_rider_age';
		$taxonomy      = get_taxonomy($taxonomy_slug);
		$selected      = isset( $_GET[ $request_attr ] ) ? $_GET[ $request_attr ] : '';
		 
		wp_dropdown_categories(array(
			'show_option_all' =>  __("{$taxonomy->label}"),
			'taxonomy'        =>  $taxonomy_slug,
			'name'            =>  $request_attr,
			'orderby'         =>  'name',
			'selected'        =>  $selected,
			'hierarchical'    =>  true,
			'depth'           =>  3,
			'show_count'      =>  false, // Show number of post in parent term
			'hide_empty'      =>  false, // Don't show posts w/o terms
		) );
	}
	
	/**
	 *	Add Admin Filter Rider Behavior (Comportements de cavalier)
	 *
	 *	@return void
	 */
	function filter_type_rider_behavior( $post_type, $which ) {
		global $typenow, $wp_query;
		
		if ( $this->post_type !== $post_type ) {
			return; //check to make sure this is your cpt
		}
	 
		$request_attr  = 'filter_rider_behavior'; //this will show up in the url
		$taxonomy_slug = 'equipeer_rider_behavior';
		$taxonomy      = get_taxonomy($taxonomy_slug);
		$selected      = isset( $_GET[ $request_attr ] ) ? $_GET[ $request_attr ] : '';
		 
		wp_dropdown_categories(array(
			'show_option_all' =>  __("{$taxonomy->label}"),
			'taxonomy'        =>  $taxonomy_slug,
			'name'            =>  $request_attr,
			'orderby'         =>  'name',
			'selected'        =>  $selected,
			'hierarchical'    =>  true,
			'depth'           =>  3,
			'show_count'      =>  false, // Show number of post in parent term
			'hide_empty'      =>  false, // Don't show posts w/o terms
		) );
	}
	
	/**
	 *	Add Admin Filter Rider Gender (Genres de cavalier)
	 *
	 *	@return void
	 */
	function filter_type_rider_gender( $post_type, $which ) {
		global $typenow, $wp_query;
		
		if ( $this->post_type !== $post_type ) {
			return; //check to make sure this is your cpt
		}
	 
		$request_attr  = 'filter_rider_gender'; //this will show up in the url
		$taxonomy_slug = 'equipeer_rider_gender';
		$taxonomy      = get_taxonomy($taxonomy_slug);
		$selected      = isset( $_GET[ $request_attr ] ) ? $_GET[ $request_attr ] : '';
		 
		wp_dropdown_categories(array(
			'show_option_all' =>  __("{$taxonomy->label}"),
			'taxonomy'        =>  $taxonomy_slug,
			'name'            =>  $request_attr,
			'orderby'         =>  'name',
			'selected'        =>  $selected,
			'hierarchical'    =>  true,
			'depth'           =>  3,
			'show_count'      =>  false, // Show number of post in parent term
			'hide_empty'      =>  false, // Don't show posts w/o terms
		) );
	}
	
	/**
	 *	Add Admin Filter Rider Level (Niveaux de cavalier)
	 *
	 *	@return void
	 */
	function filter_type_rider_level( $post_type, $which ) {
		global $typenow, $wp_query;
		
		if ( $this->post_type !== $post_type ) {
			return; //check to make sure this is your cpt
		}
	 
		$request_attr  = 'filter_rider_level'; //this will show up in the url
		$taxonomy_slug = 'equipeer_rider_level';
		$taxonomy      = get_taxonomy($taxonomy_slug);
		$selected      = isset( $_GET[ $request_attr ] ) ? $_GET[ $request_attr ] : '';
		 
		wp_dropdown_categories(array(
			'show_option_all' =>  __("{$taxonomy->label}"),
			'taxonomy'        =>  $taxonomy_slug,
			'name'            =>  $request_attr,
			'orderby'         =>  'name',
			'selected'        =>  $selected,
			'hierarchical'    =>  true,
			'depth'           =>  3,
			'show_count'      =>  false, // Show number of post in parent term
			'hide_empty'      =>  false, // Don't show posts w/o terms
		) );
	}
	
	/**
	 *	Add Admin Filter Price
	 *
	 *	@return void
	 */
	function filter_price( $post_type, $which ) {
		global $typenow, $wp_query;
		
		if ( $this->post_type !== $post_type ) {
			return; //check to make sure this is your cpt
		}
		// -----------------------------------
		$request_attr = 'filter_price';
		$selected     = isset( $_GET[ $request_attr ] ) ? $_GET[ $request_attr ] : '';
		// -----------------------------------
		$range_1 = esc_attr( get_option('equine_range_start') ) . '-' . esc_attr( get_option('equine_range_1_until') );
		$range_2 = esc_attr( get_option('equine_range_1_until') ) . '-' . esc_attr( get_option('equine_range_2_until') );
		$range_3 = esc_attr( get_option('equine_range_2_until') ) . '-' . esc_attr( get_option('equine_range_3_until') );
		$range_4 = esc_attr( get_option('equine_range_3_until') ) . '-' . esc_attr( get_option('equine_range_4_until') );
		$range_5 = esc_attr( get_option('equine_range_4_until') );
		// -----------------------------------
		$range_price_1 = 'De ' . esc_attr( get_option('equine_range_start') ) . '€ à ' . esc_attr( get_option('equine_range_1_until') ) . '€';
		$range_price_2 = 'De ' . esc_attr( get_option('equine_range_1_until') ) . '€ à ' . esc_attr( get_option('equine_range_2_until') ) . '€';
		$range_price_3 = 'De ' . esc_attr( get_option('equine_range_2_until') ) . '€ à ' . esc_attr( get_option('equine_range_3_until') ) . '€';
		$range_price_4 = 'De ' . esc_attr( get_option('equine_range_3_until') ) . '€ à ' . esc_attr( get_option('equine_range_4_until') ) . '€';
		$range_price_5 = '> ' . esc_attr( get_option('equine_range_4_until') ) . '€';
	 
		?>
		<select id="filter_price" class="postform" name="filter_price">
			<option value="">Prix</option>
			<option value="<?php echo $range_1; ?>" <?php echo selected( $selected, $range_1 ); ?>><?php echo $range_price_1; ?></option>
			<option value="<?php echo $range_2; ?>" <?php echo selected( $selected, $range_2 ); ?>><?php echo $range_price_2; ?></option>
			<option value="<?php echo $range_3; ?>" <?php echo selected( $selected, $range_3 ); ?>><?php echo $range_price_3; ?></option>
			<option value="<?php echo $range_4; ?>" <?php echo selected( $selected, $range_4 ); ?>><?php echo $range_price_4; ?></option>
			<option value="<?php echo $range_5; ?>" <?php echo selected( $selected, $range_5 ); ?>><?php echo $range_price_5; ?></option>
		</select>
		<?php
	}
	
	/**
	 *	Add Admin Filter Sold
	 *
	 *	@return void
	 */
	function filter_sold( $post_type, $which ) {
		global $typenow, $wp_query;
		
		if ( $this->post_type !== $post_type ) {
			return; //check to make sure this is your cpt
		}
	 
		$request_attr = 'filter_sold';
		$selected     = isset( $_GET[ $request_attr ] ) ? $_GET[ $request_attr ] : '';
	 
		?>
		<select id="filter_sold" class="postform" name="filter_sold">
			<option value="">Etat vente</option>
			<option value="2" <?php echo selected( $selected, "2" ); ?>>Pas vendu</option>
			<option value="1" <?php echo selected( $selected, "1" ); ?>>Vendu</option>
		</select>
		<?php
	}
	
	/**
	 * Parse query filter added
	 *
	 * https://developer.wordpress.org/reference/classes/wp_query/parse_query/
	 *
	 * @return void
	 */
	function filters_query( $query ) {
		global $pagenow;

		if ( !( is_admin() AND $query->is_main_query() ) ) { 
		  return $query;
		}
		
		if ( $this->post_type !== $query->query['post_type'] ){
		  return $query;
		}
		
		$args_discipline = array (
			'key'     => 'discipline',
			'value'   => $_GET['filter_discipline'],
			'compare' => 'IN',
			'type'    => 'CHAR'
		);
		$args_breed = array (
			'key'     => 'breed',
			'value'   => $_GET['filter_breed'],
			'compare' => 'IN',
			'type'    => 'CHAR'
		);
		$args_color = array (
			'key'     => 'dress',
			'value'   => $_GET['filter_color'],
			'compare' => 'IN',
			'type'    => 'CHAR'
		);
		$args_sex = array (
			'key'     => 'sex',
			'value'   => $_GET['filter_sex'],
			'compare' => 'IN',
			'type'    => 'CHAR'
		);
		$args_size = array (
			'key'     => 'size',
			'value'   => $_GET['filter_size'],
			'compare' => 'IN',
			'type'    => 'CHAR'
		);
		$args_level = array (
			'key'     => 'level',
			'value'   => $_GET['filter_level'],
			'compare' => 'IN',
			'type'    => 'CHAR'
		);
		$args_potential = array (
			'key'     => 'potentiel',
			'value'   => $_GET['filter_potential'],
			'compare' => 'IN',
			'type'    => 'CHAR'
		);
		$args_experts = array (
			'key'     => 'referring_expert',
			'value'   => $_GET['filter_expert'],
			'compare' => 'IN',
			'type'    => 'CHAR'
		);
		$args_types = array (
			'key'     => 'type_annonce',
			'value'   => $_GET['filter_type_annonce'],
			'compare' => 'IN',
			'type'    => 'CHAR'
		);
		$args_rider_ages = array (
			'key'     => 'cavalier_age',
			'value'   => $_GET['filter_rider_age'],
			'compare' => 'IN',
			'type'    => 'CHAR'
		);
		$args_rider_behaviors = array (
			'key'     => 'cavalier_comportement',
			'value'   => $_GET['filter_rider_behavior'],
			'compare' => 'IN',
			'type'    => 'CHAR'
		);
		$args_rider_genders = array (
			'key'     => 'cavalier_genre',
			'value'   => $_GET['filter_rider_gender'],
			'compare' => 'IN',
			'type'    => 'CHAR'
		);
		$args_rider_levels = array (
			'key'     => 'cavalier_niveau',
			'value'   => $_GET['filter_rider_level'],
			'compare' => 'IN',
			'type'    => 'CHAR'
		);
		// ------------------------------------		
		// Search if sold
		// ------------------------------------
		$sold_value = ( trim($_GET['filter_sold']) == 2 ) ? 0 : 1; 
		$args_solds = array (
			'key'     => 'sold',
			'value'   => $sold_value,
			'compare' => '=',
			'type'    => 'CHAR'
		);
		// ------------------------------------		
		// Search if price range
		// ------------------------------------
		$search_prices = trim($_GET['filter_price']);
		if (strpos($search_prices, "-") === false) {
			// > 80.000
			$price_value   = $search_prices;
			$price_compare = '>';
			$args_prices = array (
				'key'     => 'price_equipeer',
				'value'   => $search_prices,
				'compare' => '>',
				'type'    => 'NUMERIC'
			);
		} else {
			// Range price
			// array( 
			//	'key' => 'price', 
			//	'value' => array(20,30) 
			//	'compare' => 'BETWEEN'
			// )
			list($price_1, $price_2) = explode("-", $search_prices);
			$args_prices = array (
				'key'     => 'price_equipeer',
				'value'   => array("$price_1", "$price_2"),
				'compare' => 'BETWEEN',
				'type'    => 'NUMERIC'
			);
		}
		//echo '<pre>';
		//var_dump($args_prices);
		//echo '</pre>';
		//die();
		// ------------------------------------
		// Search if age is equal to 16+
		// ------------------------------------
		$year    = date('Y');
		$_16plus = $year - intval($_GET['filter_type_age']);
		$compare = ($_16plus == 16) ? '<=' : 'IN';
		$args_ages = array (
			'key'     => 'birthday',
			'value'   => $_GET['filter_type_age'],
			'compare' => $compare,
			'type'    => 'CHAR'
		);
		
		if ( is_admin() && $pagenow == 'edit.php') {
			// Check if filters are required
			if ( ( isset($_GET['filter_discipline']) && $_GET['filter_discipline'] > 0 )
			  || ( isset($_GET['filter_breed']) && $_GET['filter_breed'] > 0 )
			  || ( isset($_GET['filter_color']) && $_GET['filter_color'] > 0 )
			  || ( isset($_GET['filter_sex']) && $_GET['filter_sex'] > 0 )
			  || ( isset($_GET['filter_size']) && $_GET['filter_size'] > 0 )
			  || ( isset($_GET['filter_level']) && $_GET['filter_level'] > 0 )
			  || ( isset($_GET['filter_potential']) && $_GET['filter_potential'] > 0 )
			  || ( isset($_GET['filter_expert']) && $_GET['filter_expert'] > 0 )
			  || ( isset($_GET['filter_type_annonce']) && $_GET['filter_type_annonce'] > 0 )
			  || ( isset($_GET['filter_type_age']) && $_GET['filter_type_age'] > 0 )
			  || ( isset($_GET['filter_rider_age']) && $_GET['filter_rider_age'] > 0 )
			  || ( isset($_GET['filter_rider_behavior']) && $_GET['filter_rider_behavior'] > 0 )
			  || ( isset($_GET['filter_rider_gender']) && $_GET['filter_rider_gender'] > 0 )
			  || ( isset($_GET['filter_rider_level']) && $_GET['filter_rider_level'] > 0 )
			  || ( isset($_GET['filter_price']) && $_GET['filter_price'] > 0 )
			  || ( isset($_GET['filter_sold']) && $_GET['filter_sold'] > 0 )
			) {
				
				// Empty array (args)
				if ( isset($_GET['filter_discipline']) && $_GET['filter_discipline'] == 0 ) $args_discipline = array();
				if ( isset($_GET['filter_breed']) && $_GET['filter_breed'] == 0 ) $args_breed = array();
				if ( isset($_GET['filter_color']) && $_GET['filter_color'] == 0 ) $args_color = array();
				if ( isset($_GET['filter_sex']) && $_GET['filter_sex'] == 0 ) $args_sex = array();
				if ( isset($_GET['filter_size']) && $_GET['filter_size'] == 0 ) $args_size = array();
				if ( isset($_GET['filter_level']) && $_GET['filter_level'] == 0 ) $args_level = array();
				if ( isset($_GET['filter_potential']) && $_GET['filter_potential'] == 0 ) $args_potential = array();
				if ( isset($_GET['filter_expert']) && $_GET['filter_expert'] == 0 ) $args_experts = array();
				if ( isset($_GET['filter_type_annonce']) && $_GET['filter_type_annonce'] == 0 ) $args_types = array();
				if ( isset($_GET['filter_type_age']) && $_GET['filter_type_age'] == 0 ) $args_ages = array();
				if ( isset($_GET['filter_rider_age']) && $_GET['filter_rider_age'] == 0 ) $args_rider_ages = array();
				if ( isset($_GET['filter_rider_behavior']) && $_GET['filter_rider_behavior'] == 0 ) $args_rider_behaviors = array();
				if ( isset($_GET['filter_rider_gender']) && $_GET['filter_rider_gender'] == 0 ) $args_rider_genders = array();
				if ( isset($_GET['filter_rider_level']) && $_GET['filter_rider_level'] == 0 ) $args_rider_levels = array();
				if ( isset($_GET['filter_price']) && $_GET['filter_price'] == 0 ) $args_prices = array();
				if ( isset($_GET['filter_sold']) && $_GET['filter_sold'] == 0 ) $args_solds = array();
				
				$query->query_vars['meta_query'] = array (
					 $args_discipline
					,$args_breed
					,$args_color
					,$args_sex
					,$args_size
					,$args_level
					,$args_potential
					,$args_experts
					,$args_types
					,$args_ages
					,$args_rider_ages
					,$args_rider_behaviors
					,$args_rider_genders
					,$args_rider_levels
					,$args_prices
					,$args_solds
				);
			
			}
		}
		
	}
	
}