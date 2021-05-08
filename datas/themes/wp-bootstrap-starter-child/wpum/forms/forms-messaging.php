<?php
/**
 * The Template for displaying the messaging form
 *
 * @version 1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<div class="wpum-template wpum-form">

	<h2><?php _e('My messages', EQUIPEER_ID); ?></h2>

	<!-- SUCESS MESSAGE -->
	<?php if( isset( $_GET['updated'] ) && $_GET['updated'] == 'success' ) : ?>
		<?php
			WPUM()->templates
				->set_template_data( [ 'message' => esc_html__( 'Profile successfully updated.', 'wp-user-manager' ) ] )
				->get_template_part( 'messages/general', 'success' ); // success | error
		?>
	<?php endif; ?>



</div>
