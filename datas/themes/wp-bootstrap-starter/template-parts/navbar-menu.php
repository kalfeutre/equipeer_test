	<ul class="navbar-nav animate side-nav-menu">
		<li class="nav-close">
			<form action="" method="post">
				<div class="input-wrapper">
					<input class="search leftmenu-except" type="text" id="search" name="search" placeholder="<?php _e( 'Search', 'wp-bootstrap-starter' ); ?>">
					<label for="search" class="fa fa-search input-icon"></label>
				</div>
			</form>
			<span class="nav-button-close rightmenutrigger">
				<!--<i class="fas fa-times"></i>-->
				<img class="mb-1" src="<?php echo get_stylesheet_directory_uri() . '/assets/images/close-nav.png'; ?>" alt=""> 
				<br>
				<?php _e( 'Close', 'wp-bootstrap-starter' ); ?> 
			</span>
		</li>
		
		<?php
		// Main menu (PRIMARY)
		wp_nav_menu( array(
			'theme_location'  => 'primary',
			'container'       => false,
			'container_id'    => '',
			'container_class' => 'collapse navbar-collapse',
			'menu_id'         => false,
			'menu_class'      => '',
			'depth'           => 1,
			'fallback_cb'     => 'wp_bootstrap_navwalker::fallback',
			'walker'          => new wp_bootstrap_navwalker()
		) );
		?>

	</ul>