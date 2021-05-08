<?php
/**
 * The Template for displaying the saved searches form
 *
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

global $wpdb;

$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$table     = $wpdb->prefix . 'eqsearch_save';
$user_id   = get_current_user_id();

?>

<div class="wpum-template wpum-form">

	<h2><?php _e('Saved searches', EQUIPEER_ID); ?></h2>

	<!-- SUCCESS / ERROR MESSAGE -->
	<?php
		// Remove search
		if( isset( $_GET['r'] ) && $_GET['r'] > 0 ) {
			$remove_id = intval($_GET['r']);
			$remove    = $wpdb->delete( $table, array( 'id' => $remove_id, 'uid' => $user_id ), array( '%d', '%d' ) );
			
			if ($remove) { 
			
				WPUM()->templates
					->set_template_data( [ 'message' => sprintf( __( '%s successfully deleted', EQUIPEER_ID )."e", __('Saved search', EQUIPEER_ID) ) ] )
					->get_template_part( 'messages/general', 'success' ); // success | error
					
			} else {
				
				WPUM()->templates
					->set_template_data( [ 'message' => sprintf( __( 'An error occured while deleting your %s', EQUIPEER_ID ), strtolower(__('Saved search', EQUIPEER_ID)) ) ] )
					->get_template_part( 'messages/general', 'error' ); // success | error
				
			}
		}
		// Change status
		if( isset( $_GET['i'] ) && $_GET['i'] > 0 ) {
			$get_id     = intval($_GET['i']);
			$new_status = intval($_GET['s']);
			$change = $wpdb->update( $table,
				array( 
					'be_warned' => "$new_status"
				), 
				array( 'id' => $get_id, 'uid' => $user_id ), 
				array( '%d' ), 
				array( '%d', '%d' ) 
			);
			
			if ($change) { 
			
				WPUM()->templates
					->set_template_data( [ 'message' => sprintf( __( '%s successfully updated', EQUIPEER_ID ), __('Search notification', EQUIPEER_ID) ) ] )
					->get_template_part( 'messages/general', 'success' ); // success | error
					
			} else {
				
				WPUM()->templates
					->set_template_data( [ 'message' => sprintf( __( 'An error occured while deleting your %s', EQUIPEER_ID ), strtolower(__('Search notification', EQUIPEER_ID)) ) ] )
					->get_template_part( 'messages/general', 'error' ); // success | error
				
			}
		}
	?>

	<?php
	
	$all_searches = equipeer_searches();
	
	if (!$all_searches) {
		echo __('No saved search found', EQUIPEER_ID);
	} else { ?>

		<div class="table-responsive-md mt-4">
			<table class="table table-hover">
				<thead>
					<tr>
						<th><?php _e('Date', EQUIPEER_ID); ?></th>
						<th><?php _e('Search name', EQUIPEER_ID); ?></th>
						<th class="eq-center"><?php _e('Be notified as soon as an ad matches my search', EQUIPEER_ID); ?></th>
						<th class="eq-center"><?php _e('Remove', EQUIPEER_ID); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($all_searches as $search) { ?>
						<tr>
							<th scope="row">
								<?php if (ICL_LANGUAGE_CODE == 'fr') echo equipeer_convert_date($search->date, 'FR2'); else echo $search->date; ?>
							</th>
							<td>
								<a title="<?php _e('See saved search', EQUIPEER_ID); ?>" href="<?php echo $search->url; ?>">
									<?php echo esc_html($search->name); ?>
								</a>
							</td>
							<td class="eq-center">
								<?php if ($search->be_warned == 1) { ?>
									<span class="eq-cursor" style="color: green; line-height: 0.51em;" onclick='equipeer_change_status_saved_search("<?php echo $search->id; ?>", "0", "<?php _e("Do you no longer wish to be notified for this search?", EQUIPEER_ID); ?>")'><?php _e('Yes', EQUIPEER_ID); ?></span>
								<?php } else { ?>
									<span class="eq-cursor" style="color: red; line-height: 0.51em;" onclick='equipeer_change_status_saved_search("<?php echo $search->id; ?>", "1", "<?php _e("Do you wish to be notified for this search?", EQUIPEER_ID); ?>")'><?php _e('No', EQUIPEER_ID); ?></span>
								<?php } ?>
							</td>
							<td class="eq-center">
								<a class="eq-cursor" title="<?php _e('Remove', EQUIPEER_ID); ?>" onclick="equipeer_remove_saved_search('<?php echo $search->id; ?>')">
									<i class="far fa-trash-alt eq-red"></i>
								</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		
	<?php } ?>

</div>

<script>
	function equipeer_remove_saved_search(id) {
		Swal.fire({
			title: '<?php _e('Are you sure?', EQUIPEER_ID); ?>',
			text: "<?php _e('Remove this saved search?', EQUIPEER_ID); ?>",
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
	function equipeer_change_status_saved_search(id, status, text_status) {
		Swal.fire({
			title: '<?php _e('Are you sure?', EQUIPEER_ID); ?>',
			text: text_status,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#0e2d4c',
			cancelButtonColor: '#d1023e',
			confirmButtonText: "<?php _e('Yes', EQUIPEER_ID); ?>",
			cancelButtonText: "<?php _e('Cancel', EQUIPEER_ID); ?>"
		}).then((result) => {
			if (result.isConfirmed) {
				window.location.href = "<?php echo 'https://' . $_SERVER['HTTP_HOST'] . $uri_parts[0] . '?i='; ?>"+id+'&s='+status;
			}
		});
	}
</script>
