<?php
/**
 * The Template for displaying the document form
 *
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

global $wpdb;

$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$table     = Equipeer()->tbl_equipeer_pdf_client;
$language  = (ICL_LANGUAGE_CODE == 'fr') ? ICL_LANGUAGE_CODE : 'en';
$user_id   = get_current_user_id();

$post_ref  = array();

?>

<div class="wpum-template wpum-form">

	<h2><?php _e('My documents', EQUIPEER_ID); ?></h2>
	
	<?php
	
	$all_documents = equipeer_client_documents();
	
	$nb_documents  = 0;
	
	if (!$all_documents) {
		echo __('No document found', EQUIPEER_ID);
	} else { ?>

		<div id="account-form-document" class="table-responsive-md mt-4">
			<table class="table table-hover">
				<thead>
					<tr>
						<th><?php _e('Date', EQUIPEER_ID); ?></th>
						<th><?php _e('File to download', EQUIPEER_ID); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($all_documents as $document) { ?>
						<tr>
							<td>
								<?php echo ($language == 'fr') ? equipeer_convert_date($document->date, 'FR2') : equipeer_convert_date($document->date); ?>
							</td>
							<td>
								<a target="_blank" href="<?php echo $document->file_link; ?>"><i class="fas fa-download"></i>&nbsp;&nbsp;<?php _e('Selections', EQUIPEER_ID); ?> (<?php echo $document->file_size; ?>)</a>
							</th>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		
	<?php } ?>

</div>