<?php
/**
 * The sidebar containing the EQUINE Archive widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @Author BooBoo https://informatux.com
 *
 * @package WP_Bootstrap_Starter_child
 */

if ( ! is_active_sidebar( 'equipeer-equine-archive-header' ) ) {
	return;
}
?>

<div class="container mb-3">
	<div class="row">
		<div class="col-sm-4">
			<!-- DYNAMIC SIDEBAR -->
			<?php dynamic_sidebar( 'equipeer-equine-archive-header-image' ); ?>
			<!--<a href="<?php echo get_site_url(); ?>/les-experts-la-team-equipeer-sport/">
				<img class="w-100" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/equipeer-sport-team.jpg" alt="Découvrez l'équipe Equipeer SPORT">
			</a>-->
		</div>
		<div id="equine-archive-header" class="col-sm-8">
			<!-- DYNAMIC SIDEBAR -->
			<?php dynamic_sidebar( 'equipeer-equine-archive-header' ); ?>
		</div>
	</div>
</div>