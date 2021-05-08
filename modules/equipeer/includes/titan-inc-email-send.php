<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

//$equipeer_users   = equipeer_admin_get_users();

// Get user email
$user_email = ( isset($_GET['email']) ) ? trim($_GET['email']) : '';

$equipeer_clients  = '';
$equipeer_clients .= '<select name="owner_email_to_send" id="owner_email_to_send" class="equipeer-select-2">';
	$equipeer_clients .= '<option value="">&mdash; Selectionnez un client &mdash;</option>';
	foreach( equipeer_admin_get_users() as $user ) {
		$equipeer_clients .= '<option value="'.$user->user_email.'" ';
		if ($user_email) $equipeer_clients .= selected( $user_email, $user->user_email, false );
		$equipeer_clients .= '>';
		$equipeer_clients .= $user->user_email . ' - ' . $user->user_nicename;
		$equipeer_clients .= '</option>';
	}
$equipeer_clients .= '</select>';

$email_send->createOption( array(
	'name' => 'Email du client<span class="equipeer-space-titan"></span>Sujet de l\'email<span class="equipeer-space-titan"></span>Template<span class="equipeer-space-titan"></span>Votre message<span class="equipeer-space-titan"></span>Email administrateur<br><a href="' . admin_url() . 'edit.php?post_type=equine&page=equipeer_options&tab=equipeer_options" target="_blank" class="equipeer-admin-color description">' . $equipeer_options->getOption('email_admin') . '</a>',
	'type' => 'note',
	'desc' => '<link href="' . EQUIPEER_URL . 'assets/vendors/Select2/select2.min.css" rel="stylesheet">
		<script src="' . EQUIPEER_URL . 'assets/vendors/Select2/select2.min.js"></script>
		' . $equipeer_clients . '
		<span class="equipeer-space"></span>
		<input class="equipeer-input-long" type="text" name="owner_email_subject" value="">
		<!--<p class="description">Le choix de la discipline permet de modifier instantanément les labels des champs</p>-->
		<span class="equipeer-space"></span>
		<select name="owner_email_template" id="owner_email_template">
			<option value="">&mdash; Selectionnez un template &mdash;</option>
			<option value="contact_client">Contact Client</option>
		</select>
		<span class="equipeer-space"></span>
		<textarea name="owner_email_body" id="owner_email_body" rows=10 cols=50></textarea>
		
		<script>
			jQuery(function($) {
				$("#owner_email_to_send").select2();
			});
		</script>
	'
));

?>