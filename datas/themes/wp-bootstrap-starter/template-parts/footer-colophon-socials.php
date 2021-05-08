<?php

if ( get_theme_mod( 'facebook_link' ) || get_theme_mod( 'twitter_link' ) || get_theme_mod( 'instagram_link' ) || get_theme_mod( 'linkedin_link' ) ) {?>
        <div id="footer-colophon-socials" class="row m-0 pt-2 pb-2">
            <div class="container">
                <div class="row">
					<div class="col-12">
						<!-- Social networks -->
						<?php if ( get_theme_mod( 'facebook_link' ) ) { ?><a class="social-network" target="_blank" title="<?php _e( 'Follow us on', 'wp-bootstrap-starter' ); ?> Facebook" href="<?php echo trim(get_theme_mod( 'facebook_link' )); ?>"><i class="fab fa-facebook-square"></i></a><?php } ?>
						<?php if ( get_theme_mod( 'twitter_link' ) ) { ?><a class="social-network" target="_blank" title="<?php _e( 'Follow us on', 'wp-bootstrap-starter' ); ?> Twitter" href="<?php echo trim(get_theme_mod( 'twitter_link' )); ?>"><i class="fab fa-twitter-square"></i></a><?php } ?>
						<?php if ( get_theme_mod( 'instagram_link' ) ) { ?><a class="social-network" target="_blank" title="<?php _e( 'Follow us on', 'wp-bootstrap-starter' ); ?> Instagram" href="<?php echo trim(get_theme_mod( 'instagram_link' )); ?>"><i class="fab fa-instagram"></i></a><?php } ?>
						<?php if ( get_theme_mod( 'linkedin_link' ) ) { ?><a class="social-network" target="_blank" title="<?php _e( 'Follow us on', 'wp-bootstrap-starter' ); ?> Linkedin" href="<?php echo trim(get_theme_mod( 'linkedin_link' )); ?>"><i class="fab fa-linkedin"></i></a><?php } ?>
					</div>
                </div>
            </div>
        </div>
<?php }