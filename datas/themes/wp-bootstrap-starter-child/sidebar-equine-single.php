<?php
/**
 * The sidebar containing the EQUINE Single widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @Author BooBoo https://informatux.com
 *
 * @package WP_Bootstrap_Starter_child
 */

if ( ! is_active_sidebar( 'equipeer-equine-single' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area col-sm-12 col-lg-4" role="complementary">

	<!-- DYNAMIC SIDEBAR -->
	<?php dynamic_sidebar( 'equipeer-equine-single' ); ?>
	
	<?php
		$user_email = get_post_meta( get_the_ID(), 'owner_email', true );
		$user_id    = get_user_by( "email", $user_email );
		//$buttons .= do_shortcode('[yobro_chat_new_message user_id='.$post->post_author.']');
		echo '<div style="display:none;" data-email="'.$user_email.'" data-uid="'.$user_id->ID.'">';
		do_shortcode('[yobro_chat_new_message user_id='.$user_id->ID.']');
		echo '/<div>';
	?>

</aside><!-- #secondary -->