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

if ( ! is_active_sidebar( 'equipeer-equine-archive' ) ) {
	return;
}
?>

<!--<aside id="secondary" class="widget-area col-sm-12 col-lg-4" role="complementary">-->

	<!-- DYNAMIC SIDEBAR -->
	<?php dynamic_sidebar( 'equipeer-equine-archive' ); ?>

<!--</aside>--><!-- #secondary -->