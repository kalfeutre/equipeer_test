				<div class="navbar-brand">
                    <?php if ( get_theme_mod( 'wp_bootstrap_starter_logo' ) ): ?>
                        <a class="logo" href="<?php echo esc_url( home_url( '/' )); ?>">
                            <img src="<?php echo esc_url(get_theme_mod( 'wp_bootstrap_starter_logo' )); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                        </a>
		<?php
			if ( get_theme_mod( 'text_under_logo' ) ) {
				echo '<br>';
				// Check if is website home page
				$_lang = (ICL_LANGUAGE_CODE == 'en') ? '_en' : '';
				if ( is_front_page() )
					echo '<h1 class="text-under-logo">' . trim(get_theme_mod( "text_under_logo$_lang" )) . '</h1>';
				else
					echo '<span class="text-under-logo">' . trim(get_theme_mod( "text_under_logo$_lang" )) . '</span>';
			}
		?>
                    <?php else : ?>
                        <a class="site-title" href="<?php echo esc_url( home_url( '/' )); ?>"><?php esc_url(bloginfo('name')); ?></a>
                    <?php endif; ?>

                </div>