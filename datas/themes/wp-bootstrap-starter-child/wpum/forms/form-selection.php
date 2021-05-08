<?php
/**
 * The Template for displaying the selection form
 *
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

global $wpdb;

$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$table     = $wpdb->prefix . 'equipeer_selection_sport';
$language  = (ICL_LANGUAGE_CODE == 'fr') ? ICL_LANGUAGE_CODE : 'en';
$help_text = get_option("equine_profil_my_selection_text_$language");
$user_id   = get_current_user_id();
$user_info = get_userdata( $user_id );
$post_ref  = array();

?>

<div class="wpum-template wpum-form">

	<h2><?php _e('My selection', EQUIPEER_ID); ?></h2>

	<!-- SUCCESS / ERROR MESSAGE -->
	<?php
		// Send Selection
		if ( isset( $_POST['all_refs'] ) && $_POST['all_refs'] != '' ) {
			// --- Send email to admins
			Equipeer_Ajax::equipeer_send_my_selection( $_POST['all_refs'], $user_id, false, $_POST['all_ids'] );
			// --- Get all selections from this user
			//$_all_selections = equipeer_my_selection();
			$_all_selections = explode(",", $_POST['all_ids']);
			// --- Loop all IDS
			$_post_ids = "";
			foreach($_all_selections as $_selection) {
				// Check if horse is solded
				if (@get_post_meta( $_selection, 'sold', true ) == 1) continue;
				$_post_ids .= $_selection . "|";
			}
			$_post_ids = rtrim($_post_ids, "|");
			// --- Record selection in DB
			$_insert = $wpdb->insert( Equipeer()->tbl_equipeer_selections_sent, 
				array( 'uid' => $user_id, 'post_ids' => $_post_ids ), 
				array( '%d', '%s' ) 
			);
			if ($_insert) {
				// Remove selections
				$ids = $_POST['all_ids'];
				//$wpdb->delete( $table, array( 'uid' => $user_id ) );
				$wpdb->query( "DELETE FROM $table WHERE pid IN($ids) AND uid = '$user_id'" );
				// --- Success message
				WPUM()->templates
					->set_template_data( [ 'message' => __( 'Your selection has been sent to EQUIPEER, we will get back to you quickly', EQUIPEER_ID ) ] )
					->get_template_part( 'messages/general', 'success' ); // success | error
			} else {
				// --- Error message
				WPUM()->templates
					->set_template_data( [ 'message' => __( 'An error has occurred since sending your selection to EQUIPEER, please resend', EQUIPEER_ID ) ] )
					->get_template_part( 'messages/general', 'error' ); // success | error
			}
		}
		
		// Remove a selection from list
		if ( isset( $_GET['r'] ) && $_GET['r'] > 0 ) {
			$remove_id = intval($_GET['r']);
			$remove    = $wpdb->delete( $table, array( 'ID' => $remove_id, 'uid' => $user_id ), array( '%d', '%d' ) );
			
			if ($remove) {
				
				// Get new count
				$selection_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table WHERE uid = '$user_id'" );
				
				if ($selection_count == 0) { ?>
					<script>
						jQuery(document).ready( function($) {
							// Hide Send Selection button
							$("div#equine-dropdown-selection.dropdown-menu.dropdown-visible-756 a#equipeer-send-my-selection.eq-button.eq-button-blue").css("display", "none");
							$('#navbarDropdownSelection i.fa-star').html('');
						});
					</script>
				<?php } else { ?>
					<script>
						jQuery(document).ready( function($) {
							$('#navbarDropdownSelection i.fa-star').html('<span id="equine-selection-counter" class="badge badge-danger"><?php echo $selection_count; ?></span>');
						});
					</script>
				<?php }
			
				WPUM()->templates
					->set_template_data( [ 'message' => __( 'Selection successfully deleted', EQUIPEER_ID ) ] )
					->get_template_part( 'messages/general', 'success' ); // success | error
					
			} else {
				
				WPUM()->templates
					->set_template_data( [ 'message' => sprintf( __( 'An error occured while deleting your %s', EQUIPEER_ID ), strtolower(__('Selection', EQUIPEER_ID)) ) ] )
					->get_template_part( 'messages/general', 'error' ); // success | error
				
			}
		};
		// Get phone number
		$phone = $user_info->equipeer_user_telephone;
		if ($phone == '') {
			$fields .= '<a href="' . get_permalink( wpum_get_core_page_id( 'account' ) ) . 'address' . '">' . __('Phone', EQUIPEER_ID) . '</a>';
			WPUM()->templates
				->set_template_data( [ 'message' => esc_html__( 'Before sending us your selection, give us your phone number so that we can contact you more quickly', EQUIPEER_ID ) . " - " . __("Fill in your phone number here", EQUIPEER_ID) . ' : <strong>' . $fields . '</strong>' ] )
				->get_template_part( 'messages/general', 'error' );
		}
	?>

	<?php
	
	$all_selections = equipeer_my_selection();
	
	$nb_selections  = 0;
	
	if (!$all_selections) {
		echo __('No selection found', EQUIPEER_ID);
	} else { ?>

		<div id="account-form-selection" class="table-responsive-md mt-4">
			<table class="table table-hover">
				<thead>
					<tr>
						<th><?php _e('Selection', EQUIPEER_ID); ?></th>
						<th><?php _e('Photo', EQUIPEER_ID); ?></th>
						<th><?php _e('Reference', EQUIPEER_ID); ?></th>
						<th><?php _e('Horse', EQUIPEER_ID); ?></th>
						<th class="eq-center"><?php _e('Remove', EQUIPEER_ID); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($all_selections as $selection) {
						// --- Check if canasson is sold
						if (get_post_meta( $selection->pid, 'sold', true ) == 1) continue;
						// --- Get infos
						$post_id       = $selection->pid;
						$the_prefix    = @get_term_meta( get_post_meta( $selection->pid, 'discipline', true ), 'equipeer_prefix_taxonomy_parent_id', true );
						$the_reference = equipeer_get_format_reference( @get_post_meta( $selection->pid, 'reference', true ) );
						$post_ref[]    = $the_prefix . '-' . $the_reference;
						$post_ids[]    = $post_id;
						$horse_sold    = (get_post_meta( $post_id, 'sold', true ) == 1) ? __('Sold', EQUIPEER_ID) : false;
						$nb_selections++;
						// --- Photo
						$thumbnail_width     = '100'; // 350
						$thumbnail_height    = '70'; // 240
						$photo_id            = @get_post_meta( $post_id, 'photo_1', true );
						$thumbnail_src       = ($photo_id) ? wp_get_attachment_image_src( $photo_id, array("$thumbnail_width",  "$thumbnail_height") ) : false;
						$photo_path          = ($photo_id) ? get_attached_file( $photo_id ) : false; // Full path
						$photo_url           = ($thumbnail_src) ? wp_get_attachment_image_src( $photo_id, 'full' ) : false;
						$get_head_text_horse = equipeer_head_text_horse( $post_id, false );
						$default_photo_thumb = get_stylesheet_directory_uri() . '/assets/images/equipeer-no-photo-thumb.jpg';
					?>
						<tr>
							<td style="vertical-align: middle; text-align: center;">
								<input type="checkbox" value="<?php echo $the_prefix . '-' . $the_reference; ?>" data-id="<?php echo $post_id; ?>" class="refs" name="refs" checked>
							</td>
							<td>
								<?php
									// -------------------------------
									// --- THUMBNAIL
									// -------------------------------
									$photo_tag_id = "horse-thumb-".rand(0,9999);
									$photo_image  = ($photo_id > 0) ?
														equipeer_thumbnail_url( equipeer_image_orientation($photo_path), $photo_tag_id, $photo_id, $thumbnail_width, $thumbnail_height, $get_head_text_horse )
														:
														'<img id="'.$photo_tag_id.'" class="card-img-top img-fluid" src="'.$default_photo_thumb.'" alt="'.$get_head_text_horse.'">';
									// --- Thumbnail
									   echo $photo_image;
								?>
							</td>
							<th scope="row">
								<?php
									echo $the_prefix . '-' . $the_reference;
									if ($horse_sold) {
										echo '<br><strong class="eq-red">' . $horse_sold . '</strong>';
									}
								?>
							</th>
							<td>
								<a title="<?php _e('See horse', EQUIPEER_ID); ?>" href="<?php echo get_permalink( $selection->pid ); ?>"><?php echo equipeer_head_text_horse( $selection->pid, false ); ?></a>
							</td>
							<td class="eq-center">
								<a class="eq-cursor" title="<?php _e('Remove', EQUIPEER_ID); ?>" onclick="equipeer_remove_selection('<?php echo $selection->id; ?>')">
									<i class="far fa-trash-alt eq-red"></i>
								</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		
		<div class="mt-4">
			<?php echo nl2br($help_text); ?>
		</div>
		<div class="mt-4 eq-w100 eq-center">
			<?php
				// All refs
				$all_refs = "";
				if ($post_ref) {
					foreach($post_ref as $ref) {
						$all_refs .= $ref . ",";
					}
					$all_refs = rtrim($all_refs, ",");
				}
				// All IDS
				$all_ids  = "";
				if ($post_ids) {
					foreach($post_ids as $id) {
						$all_ids .= $id . ",";
					}
					$all_ids = rtrim($all_ids, ",");
				}
			?>
			<?php if ($nb_selections > 0) { ?>
				<form action="<?php echo get_site_url(). '/account/selection'; ?>" name="send_my_selection" id="send_my_selection" method="post">
					<input type="hidden" name="all_refs" id="all_refs" value="<?php echo $all_refs;  ?>">
					<input type="hidden" name="all_ids" id="all_ids" value="<?php echo $all_ids;  ?>">
					<input type="submit" class="eq-button eq-button-blue" value="<?php _e("Send my selection to EQUIPEER", EQUIPEER_ID); ?>">
				</form>
			<?php } ?>
		</div>
		
	<?php } ?>

</div>

<script>
	function equipeer_remove_selection(id) {
		Swal.fire({
			title: '<?php _e('Are you sure?', EQUIPEER_ID); ?>',
			text: "<?php _e('Remove this horse from your selection?', EQUIPEER_ID); ?>",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#0e2d4c',
			cancelButtonColor: '#d1023e',
			confirmButtonText: "<?php _e('Yes, delete it!', EQUIPEER_ID); ?>",
			cancelButtonText: "<?php _e('Cancel', EQUIPEER_ID); ?>"
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = "<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $uri_parts[0] . '?r='; ?>"+id;
			}
		});
	}
	jQuery(document).ready( function($) {
		// Populate send selection (all refs)
		$('.refs').click(function() {
			var checkedVals = $('.refs:checkbox:checked').map(function() {
				return this.value;
			}).get();
			var checkedIDs = $('.refs:checkbox:checked').map(function() {
				return $(this).attr("data-id");
			}).get();
			$('#all_refs').val( checkedVals.join(",") );
			$('#all_ids').val( checkedIDs.join(",") );
		});
		// Check when submit
		$('#send_my_selection').click(function() {
			var check_all_refs = $('#all_refs').val();
			if (!check_all_refs) {
				Swal.fire({
					icon: "error",
					title: "<?php _e('Oops', EQUIPEER_ID); ?>",
					text: "<?php _e("Choose the references you want to send us.", EQUIPEER_ID); ?>",
					customClass: {
						closeButton: 'swal-eq-close-button-class',
						confirmButton: 'swal-eq-confirm-button-class',
						cancelButton: 'swal-eq-cancel-button-class',
						//container: 'container-class',
						//popup: 'popup-class',
						//header: 'header-class',
						//title: 'title-class',
						//icon: 'icon-class',
						//image: 'image-class',
						//content: 'content-class',
						//input: 'input-class',
						//actions: 'actions-class',
						//footer: 'footer-class'
					}
				});
				return false;
			}
		});
	});
</script>