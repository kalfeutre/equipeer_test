<?php
/* 
Template Name: Archives
*/
get_header();

// ------------------------------------
// --- PUBLICITES
// ------------------------------------
get_template_part( 'template-parts/publicity' );

// ---------------------------------------
// --- BREADCRUMB
// ---------------------------------------
get_template_part( 'template-parts/breadcrumb' );

get_sidebar('equine-archive-header'); ?>

<aside id="secondary" class="widget-area col-sm-12 col-lg-4 equipeer-ads" role="complementary">
	<!-- ===== Advanced Search ===== --> 
	<?php get_template_part( 'template-parts/navbar', 'searchads' ); ?>
	<?php get_sidebar('equine-archive'); ?>
</aside>
 
<div id="primary" class="content-area col-sm-12 col-lg-8">
	<div id="content" role="main">
			
		<?php // 1- Création d'une requête personnalisée
			$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
			
			// Check if Google Ads Option
			$google_ads_activated = get_option("equine_google_ads_active");
			$google_ads_code      = trim( get_option("equine_google_ads_code") );
			$google_ads_position  = (get_option("equine_google_ads_position") > 0) ? intval( get_option("equine_google_ads_position") ) : 5;
			
			// Got posts per page
			$posts_per_page = ($google_ads_activated && $google_ads_code != '') ? 11 : 12;
			
			$args = array(
				'post_type'      => 'equine',
				'post_status'    => array( 'publish' ),
				'perm'           => 'readable', // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
				'cache_results'  => true,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'posts_per_page' => $posts_per_page,
				'paged'          => $paged,
				'meta_query'     => array(
					//array(
					//	'key'     => 'to_expertise',
					//	'value'   => '1',
					//	'compare' => '=',
					//),
					//array(
					//	'key'     => 'sold',
					//	'value'   => '0',
					//	'compare' => '=',
					//)
				)
			);
			$query = new WP_Query( $args );
			//echo 'LQ1: '.$query->request;
			//echo '<pre>';
			//var_dump($args);
			//echo '</pre>';
			
			// Get all IDS for PREV / BACK TO LIST / NEXT
			$args_session = array(
				'post_type'      => 'equine',
				'post_status'    => array( 'publish' ),
				'perm'           => 'readable', // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
				'cache_results'  => true,
				//'orderby'        => 'date',
				//'order'          => 'DESC',
				'orderby'        => array(
					'date' => 'DESC',
					'type_annonce' => 'DESC',
				),
				'posts_per_page' => -1
			);
			equipeer_get_prev_list_next( $args_session );
		?>
		
		<script>
			jQuery(function($) {
				var $divs = $("div.archive-card");
				var typeOrderedDivs = $divs.sort(function (a, b) {
					return $(a).find("h5").text() < $(b).find("h5").text();
				});
				$("#the_container").html(typeOrderedDivs);
				<?php if (11 == $posts_per_page) { ?>
					// if pub
					var $pub = $("div.archive-card-pub");
					$('#the_container div.archive-card:nth-child(4)').after($pub);
				<?php } ?>
				// ---------------------------------------
				// Equine LIST (click URL)
				// jQuery Click Event On Div, Except Child Div
				// ---------------------------------------
				$(".horse-list").click(function(e) {
					if ($(e.target).hasClass('equine-add-selection')) {
						// Don't change page when click on ADD TO SELECTION
						return false;
					}
					var url = $(this).attr('data-click-url');
					if (url !== '') document.location = url;
				});
				// ---------------------------------------
				// --- User Not connected
				// ---------------------------------------
				$(".equipeer-not-connected").on('click', function(e) {
					e.preventDefault();
					var swal_title        = $(this).attr('data-title');
					var swal_text         = $(this).attr('data-text');
					var swal_cancel       = $(this).attr('data-cancel');
					var swal_connect      = $(this).attr('data-connect');
					var swal_connect_url  = $(this).attr('data-connect-url');
					var swal_register     = $(this).attr('data-register');
					var swal_register_url = $(this).attr('data-register-url');
					Swal.fire({
						title: swal_title,
				  //html: swal_text + '<br><div class="swal2-div"><button type="button" role="button" tabindex="0" class="swal2-styled swal2-link" onclick="documentLocation(\'login\')">' + swal_connect + '</button>' + '<button type="button" role="button" tabindex="0" class="swal2-confirm swal2-styled" onclick="Swal.close()">' + swal_cancel + '</button>' + '<button type="button" role="button" tabindex="0" class="swal2-styled swal2-link equipeer-link" onclick="documentLocation(\'register\')">' + swal_register + '</button></div>',
				  html: swal_text + '<br><div class="swal2-div"><button type="button" role="button" tabindex="0" class="swal2-styled swal2-link" onclick="documentLocation(\'login\')">' + swal_connect + '</button>' + '<button type="button" role="button" tabindex="0" class="swal2-styled swal2-link equipeer-link" onclick="documentLocation(\'register\')">' + swal_register + '</button></div>',
						icon: "warning",
				  showCloseButton: true,
				  showCancelButton: false,
				  showConfirmButton: false,
					});
				});
				// -----------------------------
				// Add / Del selection (CLICK)
				// -----------------------------
				$('.action-to-selection').click(function (e) {
					e.preventDefault();
					// Initialize
					var the_button  = $(this);
					var the_counter = $("#equine-selection-counter");
					// Ajax loader replaces text
					the_button.html('<div class="equine-load-45 spinner-equipeer-add-del"><i class="text-light spinner-grow spinner-grow-sm" role="status"></i></div>');
					// Get infos
					var post_id          = $(this).attr('data-pid');  // Post ID
					var user_id          = $(this).attr('data-uid');  // User ID
					var switch_op        = $(this).attr('data-op');   // OP to do
					var is_mini          = $(this).attr('data-mini'); // Is mini
					var pid_ref          = $(this).attr('data-ref');  // Horse REF
					var pid_sexe         = $(this).attr("data-sexe");
					var pid_robe         = $(this).attr("data-robe");
					var pid_taille       = $(this).attr("data-taille");
					var pid_age          = $(this).attr("data-age");
					var pid_discipline   = $(this).attr("data-discipline");
					var pid_potentiel    = $(this).attr("data-potentiel");
					var pid_photo        = $(this).attr("data-photo_licol");
					var pid_price        = $(this).attr("data-price");
					var pid_localisation = $(this).attr("data-localisation");
					var pid_url          = $(this).attr("data-url");
					// Post Ajax Request
					$.ajax({
						type: "POST",                // use $_POST request to submit data
						url: equipeer_ajax.ajaxurl,  // URL to "wp-admin/admin-ajax.php"
						data: {
							action : 'equipeer_to_selection', // wp_ajax_*, wp_ajax_nopriv_*
							pid    : post_id,  // Post ID
							uid    : user_id,  // User ID
							ref    : pid_ref,  // Horse reference
							op     : switch_op // ADD Operation
						},
						success:function(response) {
							//alert(response);
							var retour      = response.split("|");
							var resultat    = (retour[0] == 1) ? 'error' : 'success'; // 0: success | 1: error
							var title       = retour[1];
							var description = retour[2];
							var counter_tot = parseInt(retour[3]);
							//if (ajax_debug_selection === true) console.log("Resultat: " + resultat + " - " + retour);
							// Add counter or NOT
							if (resultat == 'success') {
								var _html_text = "";
								switch(switch_op) {
									case "add":
										// -----------------------------
										// ADD Operation
										// -----------------------------
										// Change text / class button
										_html_text = (!is_mini) ? '<i class="fas fa-star"></i>&nbsp;&nbsp;' + equipeer_ajax.txt_removefromselection : '<i class="fas fa-star"></i>';
										the_button.removeClass('equine-add-selection').addClass('equine-del-selection').attr('data-op', 'del').html( _html_text );
										// Change counter
										$('#navbarDropdownSelection i.fa-star').html('<span id="equine-selection-counter" class="badge badge-danger">'+counter_tot+'</span>');
										// Display Send Selection button
										$('#equipeer-send-my-selection').css('display', 'block');
										// -----------------------------
										// FACEBOOK PIXEL TRACKING : ADDTOCART
										// -----------------------------
										fbq('track', 'AddToCart', {
											contents: [
												{
													id: pid_ref,
													quantity: 1
												}
											],
											content_ids: pid_ref,
											content_name: 'ADD TO SELECTION',
											content_type: 'product'
										});
										// -----------------------------
										// SEND IN BLUE : ADD_TO_SELECTION
										// -----------------------------
										sendinblue.track(
											'add_to_selection', {
												"id": pid_ref,
												"sexe": pid_sexe,
												"robe": pid_robe,
												"taille": pid_taille,
												"age": pid_age,
												"discipline": pid_discipline,
												"potentiel": pid_potentiel,
												"photo_licol": pid_photo,
												"price": pid_price,
												"localisation_code_postal": pid_localisation,
												"impression": '',
												"url": pid_url
											}
										);
									break;
									case "del":
										// -----------------------------
										// DEL Operation
										// -----------------------------
										// Change text / class button
										_html_text = (!is_mini) ? '<i class="fas fa-star"></i>&nbsp;&nbsp;' + equipeer_ajax.txt_addtoselection : '<i class="fas fa-star"></i>';
										the_button.removeClass('equine-del-selection').addClass('equine-add-selection').attr('data-op', 'add').html( _html_text );
										// Check if Counter is equal to 0
										// navbarDropdownSelection i.fa-star
										// REMOVE <span id="equine-selection-counter" class="badge badge-danger">0</span>
										if (counter_tot == 0) {
											$('#navbarDropdownSelection i.fa-star').html('');
											// Hide Send Selection button
											$('#equipeer-send-my-selection').css('display', 'none');
										} else {
											// Change counter menu
											$('#navbarDropdownSelection i.fa-star').html('<span id="equine-selection-counter" class="badge badge-danger">'+counter_tot+'</span>');
											// Display Send Selection button
											$('#equipeer-send-my-selection').css('display', 'block');
										}
										// -----------------------------
										// FACEBOOK PIXEL TRACKING : ADDTOCART
										// -----------------------------
										fbq('track', 'AddToCart', {
											contents: [
												{
													id: pid_ref,
													quantity: 1
												}
											],
											content_ids: pid_ref,
											content_name: 'DEL SELECTION',
											content_type: 'product'
										});
									break;
								}
							}
							// Display RESULT in Sweet Alert 2
							Swal.fire({
									icon: resultat,
									title: title,
									text: description,
									customClass: {
										closeButton: 'swal-eq-close-button-class',
										confirmButton: 'swal-eq-confirm-button-class',
										cancelButton: 'swal-eq-cancel-button-class',
										//container: 'container-class',
										//popup: 'popup-class',
										//header: 'header-class',
										//title: 'title-class',
										//icon: 'icon-class',
										//image: 'image-class',
										//content: 'content-class',
										//input: 'input-class',
										//actions: 'actions-class',
										//footer: 'footer-class'
									}
								});
			
						},
						error: function(errorThrown) {
							alert("Une erreur est survenue.\nRéessayez ou contacter un administrateur");
							console.log(errorThrown); // Error
						}
					});
					
					return false;
				});
			});
		</script>

		<div class="container" rel="<?php echo $posts_per_page; ?>">

			<div id="the_container" class="row">
			<?php // 2- Boucle chevaux
			$google_ads_cpt = 1;
			if ( $query->have_posts() ) :

				while ( $query->have_posts() ) :
					$query->the_post(); // Don't remove this line (required for loop)
					
					// Check if Google Ads Activated
					// Afficher apres X annonces
					if ($posts_per_page == 11  && $google_ads_cpt == $google_ads_position) {
						?>
							<div class="col-lg-4 col-md-6 col-sm-12 p-3-eq archive-card archive-card-pub">
							   <div class="h-100 text-center eq-color horse-list">
									<?php echo $google_ads_code; ?>
							   </div>
							</div>
						<?php
					}

					get_template_part( 'templates/equine/archive', 'card' );
					$google_ads_cpt++;
					
				endwhile;
				
				$custom_pagination = true;
			?>
			</div>

			<div class="row justify-content-md-center mt-3">
				
				<div class="col text-center">
					<!-- Sauvegarder ma recherche -->
					<?php echo do_shortcode('[equine-save-my-search]'); ?>
				</div>

			</div>

			<div class="row justify-content-md-center">
				<div class="col">
					<?php
						
						if ($custom_pagination) {
							
							equipeer_pagination( $query->max_num_pages );
							
						} else {
						
							// 3- Appel de la fonction paginate_links
							$big = 999999999;
			
							echo paginate_links( array( // Plus d'info sur les arguments possibles : https://codex.wordpress.org/Function_Reference/paginate_links
								'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format'  => '?paged=%#%',
								'current' => max( 1, get_query_var('paged') ),
								'total'   => $query->max_num_pages
							) ); 
							//Fin de la fonction paginate_links
							
						}
					
					?>
				</div>
						
			<?php else : ?>
				<p><?php _e( "No horses available", 'wp-bootstrap-starter'); ?></p>
			<?php endif; ?>
			
			</div>
			
		</div>
	 
	</div><!-- #content -->
</div><!-- #primary -->

<?php //get_template_part( 'template-parts/footer', 'page' ); ?>
<?php get_sidebar('equine-archive-footer'); ?>
 
<?php get_footer(); ?>