				
	<ul class="navbar-nav animate side-nav">
		
		<li class="nav-close">
			<span class="nav-title-close">
				<?php _e( 'Search', 'wp-bootstrap-starter' ); ?>
			</span>
			<span class="nav-button-close leftmenutrigger">
				<!--<i class="fas fa-times"></i>-->
				<img class="mb-1" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/close-nav.png'; ?>" alt=""> 
				<br>
				<?php _e( 'Close', 'wp-bootstrap-starter' ); ?> 
			</span>
		</li>
		
		<?php get_template_part( 'template-parts/navbar', 'search-content' ); ?>

	</ul>
