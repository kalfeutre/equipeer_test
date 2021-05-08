	<header id="masthead" class="stickybar site-header navbar-static-top <?php echo wp_bootstrap_starter_bg_class(); ?>" role="banner">
	
        <div class="container">
			
			<nav class="navbar navbar-icon-top navbar-expand-lg navbar-dark bg-dark">
			
                <?php //include( 'menu-masthead-navbar-brand.php' ); ?>
				<?php get_template_part( 'template-parts/menu-masthead', 'navbar-brand' ); ?>
				<?php //include( 'menu-masthead-navbar-collapse.php' ); ?>
				<?php get_template_part( 'template-parts/menu-masthead', 'navbar-collapse' ); ?>
				
			</nav>
			
        </div>
		
	</header><!-- #masthead sticky bar -->