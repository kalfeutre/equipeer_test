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
$table     = Equipeer()->tbl_equipeer_selections_sent;
$language  = (ICL_LANGUAGE_CODE == 'fr') ? ICL_LANGUAGE_CODE : 'en';
$user_id   = get_current_user_id();

$post_ref  = array();

?>

<div class="wpum-template wpum-form">

	<h2><?php _e('Selections sent', EQUIPEER_ID); ?></h2>
	
	<?php
	
	$all_selections = equipeer_selections_sent();
	
	$nb_selections  = 0;
	
	if (!$all_selections) {
		echo __('No selection found', EQUIPEER_ID);
	} else { ?>

		<div id="account-form-selection" class="table-responsive-md mt-4">
			<table class="table table-hover">
				<thead>
					<tr>
						<th><?php _e('Date', EQUIPEER_ID); ?></th>
						<th><?php _e('Reference', EQUIPEER_ID); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($all_selections as $selection) { ?>
						<tr>
							<td><?php echo ($language == 'fr') ? equipeer_convert_date($selection->date, 'FR2') : equipeer_convert_date($selection->date); ?></td>
							<th scope="row">
								<?php
									$_post_ids = $selection->post_ids;
									$post_ids  = explode("|", $_post_ids);
									foreach($post_ids as $post_id) {
										$the_prefix    = @get_term_meta( get_post_meta( $post_id, 'discipline', true ), 'equipeer_prefix_taxonomy_parent_id', true );
										$the_reference = equipeer_get_format_reference( @get_post_meta( $post_id, 'reference', true ) );
										$horse_sold    = (get_post_meta( $post_id, 'sold', true ) == 1) ? __('Sold', EQUIPEER_ID) : false;
										$the_permalink = get_permalink( $post_id );
										echo $the_prefix . '-' . $the_reference;
										if ($horse_sold) echo ' - ' . $horse_sold;
										echo ' - <span style="font-weight: normal;"><a href="' . $the_permalink . '">' . equipeer_head_text_horse( $post_id, false ) . '</a></span>';
										echo '<br>';
									}
								?>
							</th>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		
	<?php } ?>

</div>