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

if ( ! is_active_sidebar( 'equipeer-equine-archive-footer' ) ) {
	return;
}
?>

<div id="tertiary" class="content-area col-lg-12">
	<div id="content-tertiary">		
		<div class="container">
			
			<div class="row mt-5">
				<div class="col-lg-12">
					<?php dynamic_sidebar( 'equipeer-equine-archive-footer' ); ?>
				</div>
			</div>
			
		</div>
	</div>
</div>