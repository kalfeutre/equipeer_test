<?php
/**
 * The Template for displaying the ads form
 *
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

global $wpdb;

?>

<div class="wpum-template wpum-form">

	<h2><?php _e('My ads', EQUIPEER_ID); ?></h2>
	
	<?php if ( isset( $_GET['edit'] ) && $_GET['edit'] > 0 ) {
			include_once( get_stylesheet_directory() . '/wpum/forms/form-ads-edit.php' );
	} else { ?>

		<!-- SUCESS MESSAGE -->
		<?php if( isset( $_GET['updated'] ) && $_GET['updated'] == 'success' ) : ?>
			<?php
				WPUM()->templates
					->set_template_data( [ 'message' => esc_html__( 'Profile successfully updated.', 'wp-user-manager' ) ] )
					->get_template_part( 'messages/general', 'success' ); // success | error
			?>
		<?php endif; ?>
	
		<?php
		
			// Return array
			// result  => query
			// total   => count total
			// query   => last query
			// request => last request
			// author  => user_uid
			// email   => user_email
			$user_ads = equipeer_get_user_ads( get_current_user_id() );
			
			// Debug
			//echo '<strong>total</strong>: '.$user_ads['total'].'<br>';
			//echo '<strong>query</strong>: '.$user_ads['query'].'<br>';
			//echo '<strong>request</strong>: '.$user_ads['request'].'<br>';
			//echo '<strong>author</strong>: '.$user_ads['author']."<br><br>";
	
			if (!$user_ads || $user_ads['total'] == 0) {
				echo __('No ads found', EQUIPEER_ID);
			} else { ?>
			
				<div class="table-responsive-md mt-4">
					<table id="account-form-ads" class="table table-hover">
						<thead>
							<tr>
								<th><?php _e('Image', EQUIPEER_ID); ?></th>
								<th><?php _e('Submitted on', EQUIPEER_ID); ?></th>
								<th><?php _e('Horse name', EQUIPEER_ID); ?></th>
								<th><?php _e('Status', EQUIPEER_ID); ?></th>
								<th class="eq-center"><?php _e('Actions', EQUIPEER_ID); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							
								$query = $user_ads['result'];
							
								if ( $query->have_posts() ) :
							
									while ( $query->have_posts() ) :
				
										$query->the_post(); // Don't remove this line (required for loop)
										
										if ($query->post->post_status == 'publish' || $query->post->post_status == 'moderate') {
										
											$post_id   = $query->post->ID;
											$permalien = get_permalink( $post_id );
											// --- Photo
											$thumbnail_width     = '100'; // 350
											$thumbnail_height    = '70'; // 240
											$photo_id            = @get_post_meta( $post_id, 'photo_1', true );
											$thumbnail_src       = ($photo_id) ? wp_get_attachment_image_src( $photo_id, array("$thumbnail_width",  "$thumbnail_height") ) : false;
											$photo_path          = ($photo_id) ? get_attached_file( $photo_id ) : false; // Full path
											$photo_url           = ($thumbnail_src) ? wp_get_attachment_image_src( $photo_id, 'full' ) : false;
											$get_head_text_horse = equipeer_head_text_horse( $post_id, false );
											$default_photo_thumb = get_stylesheet_directory_uri() . '/assets/images/equipeer-no-photo-thumb.jpg';
											// --- Check if Removal Request is in progress
											$tbl_removal_request = Equipeer()->tbl_equipeer_removal_request;
											$get_current_user_id = get_current_user_id();
											$is_removal_request  = $wpdb->get_row("SELECT id FROM $tbl_removal_request WHERE uid = '$get_current_user_id' AND pid = '$post_id'");
											// --- Status
											$status = "";
											switch($query->post->post_status) {
												default: $status = '<span style="color: grey; font-style: italic;">' . __('Unknown', EQUIPEER_ID) . '</span>'; break;
												case "publish": $status = '<span style="color: green">' . __('Publish', EQUIPEER_ID) . '</span>'; break;
												case "moderate": $status = '<span style="color: orange">' . __('Pending', EQUIPEER_ID) . '</span>'; break;
											}
											
											?><tr>
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
														// --- Sold
														if ($horse_sold) echo $horse_sold;
														// --- Expertise
														if ($horse_expertise) echo $horse_expertise;
													?>
												</td>
												<td scope="row">
													<?php if (ICL_LANGUAGE_CODE == 'fr') echo equipeer_convert_date($query->post->post_date, 'FR2'); else echo $query->post->post_date; ?>
												</td>
												<td>
													<a title="" href="<?php echo $permalien; ?>"><?php echo esc_html($query->post->post_title); ?></a>
												</td>
												<td>
													<?php echo $status; ?>
												</td>
												<td class="eq-center">
													<?php if ($is_removal_request->id > 0) {
														?>
														<a class="eq-nocursor" title=""><i class="fas fa-edit eq-lgrey"></i></a>
														&nbsp;&nbsp;
														<a class="eq-nocursor" title=""><i class="far fa-trash-alt eq-lgrey"></i></a>
													<?php } else { ?>
														<?php if ($query->post->post_status == 'publish') { ?>
															<?php if ( get_current_user_id() == 3121 ) { ?>
																<a href="<?php echo equipeer_current_url() . "?edit=$post_id"; ?>" class="eq-cursor" title="<?php _e('Edit', EQUIPEER_ID); ?>"><i class="fas fa-edit eq-blue"></i></a>&nbsp;&nbsp;<a class="eq-cursor" title="<?php _e('Removal request', EQUIPEER_ID); ?>" onclick="removal_request('<?php echo $post_id; ?>', '<?php echo $query->post->post_author; ?>')"><i class="far fa-trash-alt eq-red"></i></a>
															<?php } else { ?>
																<!--<a class="eq-cursor" title="<?php _e('Edit', EQUIPEER_ID); ?>" onclick="alert('Modifier')"><i class="fas fa-edit eq-blue"></i></a>&nbsp;&nbsp;--><a class="eq-cursor" title="<?php _e('Removal request', EQUIPEER_ID); ?>" onclick="removal_request('<?php echo $post_id; ?>', '<?php echo $query->post->post_author; ?>')"><i class="far fa-trash-alt eq-red"></i></a>
															<?php } ?>
														<?php } else { ?>
															--
														<?php } ?>
													<?php } ?>
												</td>
											</tr><?php
											
											// Check if removal request is in progress
											if ($is_removal_request->id > 0) {
												echo '<tr><td class="text-center" colspan="5" style="border-top: 0"><strong class="eq-red">' . __('Demande de suppression en cours', EQUIPEER_ID) . ' : ' . esc_html($query->post->post_title) . '</strong></td></tr>';
											}
										}
	
									endwhile;
									
								endif;
									
							?>
						</tbody>
					</table>
				</div>
				
			<?php } ?>
		
			<script>
				function removal_request(post_id, post_author) {
					Swal.fire({
						title: "<?php _e('Removal request', EQUIPEER_ID); ?>",
						html: "<?php _e("You want to delete your ad for what reason?", EQUIPEER_ID); ?>",
						icon: 'question',
						input: 'select',
						inputOptions: {
							'sold_with_equipeer': "<?php _e("I sold my horse with EQUIPEER", EQUIPEER_ID); ?>",
							'sold_without_equipeer': "<?php _e("I sold my horse without going through EQUIPEER", EQUIPEER_ID); ?>",
							'sold_ko': "<?php _e("I did not find a buyer for my horse", EQUIPEER_ID); ?>",
							'remove': "<?php _e("I just want to delete my ad", EQUIPEER_ID); ?>"
						},
						confirmButtonText: "<?php _e('Validate', EQUIPEER_ID); ?>",
						showCancelButton: true,
						confirmButtonColor: '#0e2d4c',
						cancelButtonColor: '#d1023e',
						cancelButtonText: "<?php _e('Cancel', EQUIPEER_ID); ?>"
					}).then((result) => {
						if (result.value) {
							var reason = "";
							switch(result.value) {
								case 'sold_with_equipeer': reason = "<?php _e("I sold my horse with EQUIPEER", EQUIPEER_ID); ?>"; break;
								case 'sold_without_equipeer': reason = "<?php _e("I sold my horse without going through EQUIPEER", EQUIPEER_ID); ?>"; break;
								case 'sold_ko': reason = "<?php _e("I did not find a buyer for my horse", EQUIPEER_ID); ?>"; break;
								case 'remove': reason = "<?php _e("I just want to delete my ad", EQUIPEER_ID); ?>"; break;
							}
							
							jQuery.ajax({
								url: equipeer_ajax.ajaxurl,
								type: "POST",
								data: {
								  action : 'equipeer_removal_request', // wp_ajax_*, wp_ajax_nopriv_*
								  remove : reason,
								  pid    : post_id,
								  uid    : post_author
								},
								dataType: "html",
								success: function (datas) {
									// Check result
									if (datas == '1') {
										Swal.fire( {
											title: "<?php _e('Removal request', EQUIPEER_ID); ?>",
											html: "<?php _e('You have chosen to delete your ad for the following reason:', EQUIPEER_ID); ?><br><span style='color: grey; font-style: italic;'>"+reason+"</span><br><br><?php _e('The EQUIPEER administrators take note of your request and very soon confirm the deletion of your ad.', EQUIPEER_ID); ?>",
											icon: 'info',
											confirmButtonColor: '#0e2d4c'
										} );
									} else {
										// Error sending email
										Swal.fire( "Error sending!", "Please try agains", "error" );
									}
								},
								error: function (xhr, ajaxOptions, thrownError) {
									Swal.fire( "Error sending!", "Please try again " + thrownError, "error" );
								}
							});
						}
					});
					
					//if (fruit) {
					//  Swal.fire(`Vous avez choisi de supprimer votre annonce pour la raison suivante : ${fruit}<br>Les administrateurs prennent note de votre demande et vous confirment tr&egrave;s bient&ocirc;t la suppression de votre annonce.`)
					//}
				}
			</script>
	<?php } ?>

</div>
