	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		
		<!-- ===== Advanced Search ===== --> 
		<?php if ( !is_archive() ) { ?>
			<?php get_template_part( 'template-parts/navbar', 'search' ); ?>
		<?php } ?>

		<!-- ===== Main Menu ===== -->
		<?php get_template_part( 'template-parts/navbar', 'menu' ); ?>
		
		<ul class="navbar-nav mr-auto">
			<!-- ===== Other menu if necessary ===== -->
			<?php
				/*
				<li class="nav-item active">
					<a class="nav-link" href="#">
						<i class="fa fab fa-home"></i>
						Home
						<span class="sr-only">(current)</span>
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="#">
						<i class="fa fab fa-bell">
							<span class="badge badge-danger">1</span>
						</i>
						Link
					</a>
				</li>
				<li class="nav-item">
					<a class="nav-link disabled" href="#">
						<i class="fa fab fa-bell">
							<span class="badge badge-warning">10</span>
						</i>
						Disabled
					</a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fab fa-bell">
							<span class="badge badge-primary">23</span>
						</i>
						Dropdown
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="#">Action</a>
						<a class="dropdown-item" href="#">Another action</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#">Something else here</a>
					</div>
				</li>
				*/
			?>
		</ul>
		
		<?php $get_site_url_lang = (ICL_LANGUAGE_CODE == 'fr') ?  get_site_url() :  get_site_url() . '/en'; ?>
		<ul id="menu-primary-icon" class="navbar-nav ">

			<!-- ========== Button SUBMIT YOUR AD ========== -->
			<li class="nav-item primary-icon-hide">
				<a class="nav-link eq-button-header" href="<?php echo $get_site_url_lang; ?>/deposez-votre-annonce/" title="<?php _e( 'Submit your ad', EQUIPEER_ID ); ?>">
					<i class="far fa-plus-square"></i>&nbsp;&nbsp;<?php _e( 'Submit your ad', EQUIPEER_ID ); ?>
				</a>
			</li>
			<li class="nav-item primary-icon-992">
				<a class="nav-link" href="<?php echo $get_site_url_lang; ?>/deposez-votre-annonce/" title="<?php _e( 'Submit your ad', EQUIPEER_ID ); ?>">
					<i class="fas fa-plus-square"></i>
				</a>
			</li>
			
			<!-- ========== SEARCH ========== -->
			<?php if ( !is_archive() ) { ?>
			<li class="nav-item">
				<a class="nav-link leftmenutrigger" href="#" title="<?php _e( 'Search a horse', EQUIPEER_ID ); ?>">
					<!--<i class="fa fas fa-search"></i>-->
					<img class="fa navbar-search" src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-search.png" alt="<?php _e( 'Search a horse', EQUIPEER_ID ); ?>" title="<?php _e( 'Search a horse', EQUIPEER_ID ); ?>">
				</a>
			</li>
			<?php } ?>
			
			<!-- ========== MY ACCOUNT ========== -->
			<li class="nav-item dropdown primary-icon-hide">
				<a class="nav-link dropdown-toggle" href="<?php echo $get_site_url_lang; ?>/account" id="navbarDropdownAccount2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php _e( 'My Account', 'wp-bootstrap-starter' ); ?>">
					<i class="fa far fa-portrait"></i>
				</a>
				<div class="dropdown-menu dropdown-visible-756" aria-labelledby="navbarDropdownAccount2">
					
					<?php if ( is_user_logged_in() && !is_admin() ) { ?>
					
						<a href="<?php echo wp_logout_url(equipeer_current_url()); ?>" class="eq-button eq-button-red"><?php _e( 'Logout', EQUIPEER_ID ); ?></a>
					
						<!--<a class="dropdown-item" href="<?php echo get_site_url(); ?>/account"><?php _e( 'Dashboard', 'wp-bootstrap-starter' ); ?></a>-->
						<a class="dropdown-item" href="<?php echo $get_site_url_lang; ?>/account/settings"><?php _e( 'My profile', 'wp-bootstrap-starter' ); ?></a>
						<a class="dropdown-item" href="<?php echo $get_site_url_lang; ?>/account/searches"><?php _e( 'My searches', EQUIPEER_ID ); ?></a>
						<a class="dropdown-item" href="<?php echo $get_site_url_lang; ?>/account/selection"><?php _e( 'My selection', 'wp-bootstrap-starter' ); ?></a>
						<a class="dropdown-item" href="<?php echo $get_site_url_lang; ?>/account/messaging"><?php _e( 'Messaging', 'wp-bootstrap-starter' ); ?></a>
						<?php //echo do_shortcode('[yobro_chat_notification]'); ?>
						<a class="dropdown-item" href="<?php echo $get_site_url_lang; ?>/account/ads"><?php _e( 'My ads', 'wp-bootstrap-starter' ); ?></a>
						<a class="dropdown-item" href="<?php echo $get_site_url_lang; ?>/account/password"><?php _e( 'Manage my password', EQUIPEER_ID ); ?></a>
					
					<?php } else { ?>
					
						<a class="eq-button eq-button-red" href="<?php echo get_site_url(); ?>/login/?redirect_to=<?php echo urlencode(equipeer_current_url()); ?>"><?php _e( 'Log in', 'wp-bootstrap-starter' ); ?></a>
						<small class="text-muted"><a id="equipeer-except" class="dropdown-item" href="<?php echo get_site_url(); ?>/register/"><?php echo __( 'New client?', 'wp-bootstrap-starter' ) . ' ' . __( 'Create an account', 'wp-bootstrap-starter' ); ?></a></small>
							<div class="dropdown-divider"></div>
						<!--<a class="dropdown-item" href="<?php echo $get_site_url_lang; ?>/account"><?php _e( 'Dashboard', 'wp-bootstrap-starter' ); ?></a>-->
						<a class="dropdown-item" href="<?php echo $get_site_url_lang; ?>/account/settings"><?php _e( 'My profile', 'wp-bootstrap-starter' ); ?></a>
						<a class="dropdown-item" href="<?php echo $get_site_url_lang; ?>/account/searches"><?php _e( 'My searches', EQUIPEER_ID ); ?></a>
						<a class="dropdown-item" href="<?php echo $get_site_url_lang; ?>/account/selection"><?php _e( 'My selection', 'wp-bootstrap-starter' ); ?></a>
						<a class="dropdown-item" href="<?php echo $get_site_url_lang; ?>/account/messaging"><?php _e( 'Messaging', 'wp-bootstrap-starter' ); ?></a>
						<a class="dropdown-item" href="<?php echo $get_site_url_lang; ?>/account/ads"><?php _e( 'My ads', 'wp-bootstrap-starter' ); ?></a>
						<a class="dropdown-item" href="<?php echo $get_site_url_lang; ?>/account/password"><?php _e( 'Manage my password', EQUIPEER_ID ); ?></a>
					
					<?php } ?>
					
				</div>
			</li>
			
			<!-- ========== MY SELECTIONS ========== -->
			<li id="equine-selection-li" class="nav-item dropdown primary-icon-hide">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownSelection" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="<?php _e( 'My Selections', 'wp-bootstrap-starter' ); ?>">
					<i class="fa far fa-star">
						<?php if (equipeer_count_selection(get_current_user_id()) > 0) { ?>
						<span id="equine-selection-counter" class="badge badge-danger"><?php echo equipeer_count_selection(get_current_user_id()); ?></span>
						<?php } ?>
					</i>
				</a>
				<div id="equine-dropdown-selection" class="dropdown-menu dropdown-visible-756" aria-labelledby="navbarDropdownSelection">
					
					<?php //if ( is_user_logged_in() && !is_admin() ) { ?>
					<?php if ( is_user_logged_in() ) { ?>
					
						<div id="mini-selection" class="mb-1">
							<?php echo equipeer_get_selection('', get_current_user_id(), $limit = 3, $selection = true, $menu = true); ?>
						</div>										
						<div class="dropdown-divider"></div>
						<a class="eq-button eq-button-red" href="<?php echo $get_site_url_lang; ?>/account/selection"><?php _e( 'See my selection', 'wp-bootstrap-starter' ); ?></a>
						<a role="" id="equipeer-send-my-selection" href="#" class="eq-button eq-button-blue" onclick="return equipeer_send_my_selection();" style="display: <?php if (equipeer_count_selection(get_current_user_id()) > 0) echo 'block'; else echo 'none'; ?>;"><?php _e( 'Send my selection', 'wp-bootstrap-starter' ); ?></a>
						
					<?php } else { ?>
						
						<small class="muted-text"><?php _e( "You don't have selection", EQUIPEER_ID ); ?></small>
						<div class="dropdown-divider"></div>
						<a class="eq-button eq-button-red" href="<?php echo get_site_url(); ?>/login/?redirect_to=<?php echo urlencode(equipeer_current_url()); ?>"><?php _e( 'Log in', 'wp-bootstrap-starter' ); ?></a>
						<small class="text-muted">
							<a id="equipeer-except-2" class="dropdown-item" href="<?php echo get_site_url(); ?>/register/"><?php echo __( 'New client?', 'wp-bootstrap-starter' ) . ' ' . __( 'Create an account', 'wp-bootstrap-starter' ); ?></a>
						</small>
						<div class="dropdown-divider"></div>
						<?php echo do_shortcode('[equine-see-my-selection]'); ?>
						<div class="dropdown-divider-invisible"></div>
						<?php echo do_shortcode('[equine-send-my-selection]'); ?>
					
					<?php } ?>
				</div>
			</li>
			
			<!-- ========== LATERAL MENU ========== -->
			<li class="nav-item">
				<a class="nav-link rightmenutrigger" href="#" title="<?php _e( 'Main Menu', 'wp-bootstrap-starter' ); ?>">
					<i class="fa fas fa-bars"></i>
				</a>
			</li>
			
			<!-- ========== FLAG ========== -->
			<li id="primary-icon-flag" class="nav-item primary-icon-hide">
				<a class="nav-link" href="#" title="<?php _e( 'Language', 'wp-bootstrap-starter' ); ?>">
					&nbsp;
					<!--<img class="fa navbar-flag" src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-en-us.png" alt="<?php _e( 'Language', 'wp-bootstrap-starter' ); ?>" title="<?php _e( 'Language', 'wp-bootstrap-starter' ); ?>">-->
				</a>
			</li>
			
		</ul>
		
	</div>
	
	<script>
		function equipeer_send_my_selection() {
			// ---------------------------------------
			// --- Send my selection
			// ---------------------------------------
			Swal.fire({
				title: "<?php _e('Send your selection', EQUIPEER_ID); ?>",
				html: "<?php _e("Send my selection to a EQUIPEER coach", EQUIPEER_ID); ?>",
				icon: 'info',
				showCancelButton: true,
				confirmButtonText: "<?php _e('Yes send it!', EQUIPEER_ID); ?>",
				cancelButtonText: "<?php _e('Cancel', EQUIPEER_ID); ?>",
				confirmButtonColor: '#0e2d4c',
				cancelButtonColor: '#d1023e'
			}).then((result) => {
				
				if (result.value) {
				  
					jQuery.ajax({
						url: equipeer_ajax.ajaxurl,
						type: "POST",
						data: {
							action : 'equipeer_send_my_selection' // wp_ajax_*, wp_ajax_nopriv_*
						},
						dataType: "html",
						success: function () {
							Swal.fire(
								"<?php _e("Well done", EQUIPEER_ID); ?>",
								"<?php _e("An EQUIPEER coach will contact you very soon", EQUIPEER_ID); ?>",
								'success'
							);
						},
						error: function (xhr, ajaxOptions, thrownError) {
							Swal.fire(
								"<?php _e("Error Sending", EQUIPEER_ID); ?>",
								"<?php _e("Please try again", EQUIPEER_ID); ?> " + thrownError,
								"error"
							);
						}
					});
				
				} else if (result.dismiss === Swal.DismissReason.cancel) {
				  
					/* Read more about handling dismissals below */
					Swal.fire(
						"<?php _e('Cancelled', EQUIPEER_ID); ?>",
						"<?php _e("You decide to don't send your selection to an EQUIPEER coach for the moment", EQUIPEER_ID); ?>", // Vous n'avez pas envoye votre selection
						"error"
					);
				  
				}
			});
		}
	</script>