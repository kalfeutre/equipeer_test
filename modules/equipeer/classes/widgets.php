<?php

/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * CLASS Widgets EQUIPEER
 */
class Equipeer_Widgets extends WP_Widget {

    /**
     * Constructor for the Equipeer_Widgets class
     *
     * Sets up all the appropriate hooks and actions
     */	
	public function __construct() {
		parent::__construct(
			// Base ID of your widget (class)
			'Equipeer_Widgets', 
			// Widget name will appear in UI
			__( 'Posts Carousel (EQUIPEER)', EQUIPEER_ID ), 
			// Widget description
			array( 'description' => __( 'Posts Carousel Widget for EQUIPEER', EQUIPEER_ID ) ) 
		);
		// Titan call
		$this->equipeer_options = TitanFramework::getInstance( 'equipeer' );
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form($instance) {
		$carousel_adstype    = isset($instance['carousel_adstype']) ? $instance['carousel_adstype'] : 'last'; // Default LAST
		$carousel_number     = isset($instance['carousel_number']) ? $instance['carousel_number'] : 9;
		$carousel_indicators = isset($instance['carousel_indicators']) ? $instance['carousel_indicators'] : 'on';
		$carousel_interval   = isset($instance['carousel_interval']) ? $instance['carousel_interval'] : 7;
		// Widget admin form
		?>
			<p class="description">
				<em>
					<strong>Les annonces de votre choix</strong> : suivez le lien "Modifier" pour personnaliser vos annonces.<br>
					<strong>Les dernières annonces expertisées</strong> : les dernières annonces en statuts publié et off seront affichés.
				</em>
				
			</p>
			<p>
				<strong>Type d'annonces</strong><br>
				<input class="widefat" name="<?php echo $this->get_field_name( 'carousel_adstype' ); ?>" type="radio" value="custom" <?php if ($carousel_adstype == 'custom') echo 'checked=""'; ?>>&nbsp;Les annonces de votre choix <a href="<?php echo admin_url(); ?>edit.php?post_type=equine&page=equipeer_options&tab=equipeer_featured_ads" target="_blank">Modifier</a>
				<br>
				<input class="widefat" name="<?php echo $this->get_field_name( 'carousel_adstype' ); ?>" type="radio" value="last" <?php if ($carousel_adstype == 'last' || $carousel_adstype == '') echo 'checked=""'; ?>>&nbsp;Les dernières annonces expertisées
			</p>
			<p>
				<img style="border: 1px dotted lightgray;" src="<?php echo EQUIPEER_URL; ?>assets/images/carousel-indicators.jpg" title="indicateurs - pagination"><br>
				<strong><label for="<?php echo $this->get_field_name( 'carousel_indicators' ); ?>">Voir les indicateurs</label></strong><br>
				<input name="<?php echo $this->get_field_name( 'carousel_indicators' ); ?>" type="checkbox" <?php if ($carousel_indicators == 'on' || !$carousel_indicators ) echo 'checked=""'; ?>>&nbsp;Oui
			</p>
			<p>
				<strong><label for="<?php echo $this->get_field_name( 'carousel_number' ); ?>"></label>Nombre d'annonces</strong><br><em style="font-size: 10px !important; color: red;">Uniquement pour Les dernières annonces expertisées</em><br>
				<input class="widefat" name="<?php echo $this->get_field_name( 'carousel_number' ); ?>" type="radio" value="6" <?php if ($carousel_number == 6 ) echo 'checked=""'; ?>>&nbsp;6<br>
				<input class="widefat" name="<?php echo $this->get_field_name( 'carousel_number' ); ?>" type="radio" value="9" <?php if ($carousel_number == 9 || !$carousel_number ) echo 'checked=""'; ?>>&nbsp;9<br>
				<input class="widefat" name="<?php echo $this->get_field_name( 'carousel_number' ); ?>" type="radio" value="12" <?php if ($carousel_number == 12 ) echo 'checked=""'; ?>>&nbsp;12<br>
				<input class="widefat" name="<?php echo $this->get_field_name( 'carousel_number' ); ?>" type="radio" value="15" <?php if ($carousel_number == 15 ) echo 'checked=""'; ?>>&nbsp;15
			</p>
			<p>
				<strong><label for="<?php echo $this->get_field_name( 'carousel_interval' ); ?>"></label>Intervalle de défilement</strong><br>
				<input style="width: 60px;" class="widefat" name="<?php echo $this->get_field_name( 'carousel_interval' ); ?>" type="number" min="1" max="20" value="<?php echo $carousel_interval; ?>">
			</p>
		<?php 
	}
	
	/**
	 * Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget($args, $instance) {
		global $wp, $wpdb;		
		
		echo $args['before_widget'];
		if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
		// Carousel ID (CSS)
		$carousel_ID = 'carousel_' . rand();
		// Default ITEMS
		$default_items = ( isset($instance['carousel_number']) ) ? intval($instance['carousel_number']) : 9;
		// IF UPDATE
		$force_update = false;
		// Check if Carousel ADSTYPE is custom
		// Verify that the count of ads is a multiple of 3
		if ($instance['carousel_adstype'] == 'custom') {
			//$post__in     = array( 998, 1562, 1440, 1015, 1056, 1158 );
			$post__in     = get_option('eq_featured_ads');
			$count_custom = count( $post__in );
			// Multiple of 3, or not
			if ($count_custom %3 == 0 && $count_custom > 5)
				$instance['carousel_adstype'] = 'custom'; // YES
			else
				$instance['carousel_adstype'] = 'last';   // NO
		}
		// Request ARGS
		if ( $instance['carousel_adstype'] == 'custom' ) { // CUSTOM
			$args = array(
				'post_type' => 'equine',
				'post__in'  => $post__in
			);
		} else { // LAST
			$args = array(
				'post_type'      => 'equine',
				'post_status'    => array( 'publish', 'off' ),
				'perm'           => 'readable', // Beware of setting the 'post_status' to anything other than 'public', as it can easily lead to an information disclosure vulnerability
				'cache_results'  => true,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'posts_per_page' => $default_items,
				//'posts_per_page' => -1,
				'meta_query'     => array(
					array(
						'key'     => 'to_expertise',
						'value'   => '1',
						'compare' => '=',
					),
					array(
						'key'     => 'sold',
						'value'   => '0',
						'compare' => '=',
					),
				)
			);
		}
		// Request
		$query = new WP_Query( $args );
		// Check if have posts
		if ( !$query->have_posts() ) return;
		// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		// Update (A FAIRE UNE SEULE FOIS)
		// DECOMMENTER : 'posts_per_page' => -1,
		// COMMENTER : 'posts_per_page' => 6,
		// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
		if ( $force_update ) {
			while ( $query->have_posts() ) {				
				$query->the_post();
				// Update meta
				update_post_meta( $query->post->ID, 'to_expertise', '1' );
				update_post_meta( $query->post->ID, 'type_annonce', '2' );
			}
		}
		// -------------------------------------
		// GET ALL EQUINES (Columns Cards)
		// -------------------------------------
		$cpt_carousel     = 1;
		//$count_posts      = ( $instance['carousel_adstype'] == 'custom' ) ? $count_custom : $default_items; // $query->found_posts | $query->post_count
		$count_posts      = $query->post_count; // $query->found_posts | $query->post_count
		$multiple         = 3; // Items by view
		$multiples        = [3, 6, 9, 12, 15, 18, 21];
		$thumbnail_width  = 700;
		$thumbnail_height = 600;
		// -------------------------------------
		// -------------- Start ----------------
		// -------------------------------------
		?>
		<style>
			.cta-100 {
				padding-top: 0;
				padding-bottom: 5%;
				display: block;
			}
			.cta-575 {
				display: none;
				max-width: 400px;
			}
			.eq-carousel .carousel-indicators {
			  left: 0;
			  bottom: -40px;
			  height: 1px;
			}
			/* The colour of the indicators */
			.eq-carousel .carousel-indicators li {
				background: #aaa;
				border-radius: unset;
				width: 40px;
				height: 2px;
				border-top: 0;
				border-bottom: 0;
			}			
			.eq-carousel .carousel-indicators .active {
			  background: #ce023f;
			}
			.item-box-blog {
				border: 1px solid #ce023f;
				text-align: center;
				z-index: 4;
				padding: 0;
				margin-bottom: 0;
			}
			.item-box-blog-image {
				position: relative;
			}
			.item-box-blog-image figure img {
				width: 100%;
				height: 15em;
				object-fit: cover;
			}
			.item-box-blog-expert {
				position: absolute;
				z-index: 5;
				top: 1em;
				right: 1em;
			}
			.item-box-blog-expert img {
				width: 70px;
			}
			.item-box-blog-body {
				padding: 0.5em;
			}
			.item-box-blog-heading h3 {
				font-size: 1.2em;
				font-weight: 400;
			}
			.item-box-blog-text {
				max-height: 100px;
				overflow: hidden;
			}
			.carousel-item {
				background-color: white !important;
			}
			@media(max-width: 767px) {
				.item-box-blog {
					border: 1px solid #ce023f;
					text-align: center;
					z-index: 4;
					padding: 0;
					margin-bottom: 2em;
				}
			}
			@media (max-width: 575px) {
				.cta-575 {
					display: block;
				}
				.cta-100 {
					display: none;
				}
			}
		</style>
		<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('.slideshow').cycle({
				fx: 'fade' // fade, scrollUp, shuffle, ...
			});
		});
		</script>
		
		<div class="container cta-575">
			<div class="slideshow">
				<?php
					while ( $query->have_posts() ) {
						// -------------------------
						// Initialize
						// -------------------------
						$query->the_post();
						// -------------------------
						// Get metas
						// -------------------------
						$query_metas  = equipeer_get_metas( $query->post->ID );
						// -------------------------
						// Get The 1st Photo
						// -------------------------
						$get_children = get_children( 'post_type=attachment&post_mime_type=image&post_parent='.$query->post->ID, ARRAY_A ); // Return ARRAY
						$get_images   = array_values( $get_children );  // Put keys on ARRAY
						// -------------------------------------------------------
						// Verifier s'il y a une nouvelle photo depuis l'import V3
						// -------------------------------------------------------
						$meta_photo_1 = @get_post_meta( $query->post->ID, 'photo_1', true );
						//if ( isset($meta_photo_1) && ( $meta_photo_1 == '0' || $meta_photo_1 > 0 ) ) {
						if ( isset($meta_photo_1) && $meta_photo_1 > 0 ) {
							$value = wp_get_attachment_image( intval($meta_photo_1), array($thumbnail_width, $thumbnail_height), "", array( "class" => "img-responsive" ) );
						} else {
							// Sinon, prendre celle de l'import
							$photo_1_id = @$get_images[0]["ID"]; // First attached image
							if ( $photo_1_id > 0 ) {
								$value = wp_get_attachment_image( $photo_1_id, array( $thumbnail_width, $thumbnail_height ), "", array( "class" => "img-responsive import-attachment-image" ) );
							} else {
								$value = '<img class="" src="' . EQUIPEER_URL . 'assets/images/no_image_available.jpg" with="' . $thumbnail_width . 'px" height="' . $thumbnail_height . 'px">';
							}
						}
						// -------------------------
						// Item
						// -------------------------
						echo '<!-- ITEM START --> 
							<div class="" >
								<div class="item-box-blog" style="height: 270px !important;">
									<div class="item-box-blog-image">
										<!-- Expert -->
										<div class="item-box-blog-expert">
											<img src="' . EQUIPEER_URL . 'assets/images/tampon-expertise-equipeer.png" alt="Expert" title="">
										</div>
										<!-- Photo -->
										<figure>
											' . $value . '
										</figure>
									</div>
									<div class="item-box-blog-body">
										<!-- Text -->
										<div class="item-box-blog-heading">
											<h3>' . esc_html( equipeer_head_text_horse( $query->post->ID ) ) . '</h3>
										</div>
										<!-- Read More Button -->
										<div class="item-box-blog-text">
											<a href="' . get_permalink( $query->post->ID ) . '">' . __( 'Learn more about this horse', EQUIPEER_ID ) . '</a>
										</div>
									</div>
								</div>
							</div>
							<!-- ITEM END -->
						';
					}
				?>
			</div>
		</div>
		
		<div class="container cta-100">
			<div class="container">
				<div class="row eq-carousel">
					<div class="col-lg-12 col-md-12 col-sm-12">
						<!-- carousel-fade -->
						<div id="<?php echo $carousel_ID; ?>" class="carousel slide container-blog" data-ride="carousel">
							
							<?php if ( $instance['carousel_indicators'] == 'on' ) { ?>
							<ol class="carousel-indicators">
								<?php if ($count_posts %3 == 0) {
									// Le compteur de posts est un multiple de 3, OK, on continue
									for( $i = 0; $i < ($count_posts / 3); ++$i ) {
										$class    = ($i == 0) ? ' class="active"' : ''; // First slide active
										$interval = intval($instance['carousel_number'] * 1000);
										echo '<li data-target="#' . $carousel_ID . '" data-interval="' . $interval . '" data-slide-to="' . $i . '"' . $class . '></li>';
									}
									// -----------------------------------------------------
								} else { ?>
									<!--- Default 9 items -->
									<li data-target="#<?php echo $carousel_ID; ?>" data-slide-to="0" class="active"></li>
									<li data-target="#<?php echo $carousel_ID; ?>" data-slide-to="1"></li>
									<li data-target="#<?php echo $carousel_ID; ?>" data-slide-to="2"></li>
								<?php } ?>
							</ol>
							<?php } ?>
							
							<!-- Carousel items -->
							<div class="carousel-inner">
								
								<div class="carousel-item active">
									<div class="row">
								
										<?php
											while ( $query->have_posts() ) {
												// -------------------------
												// Initialize
												// -------------------------
												$query->the_post();
												// -------------------------
												// Get metas
												// -------------------------
												$query_metas  = equipeer_get_metas( $query->post->ID );
												// -------------------------
												// Get The 1st Photo
												// -------------------------
												$get_children = get_children( 'post_type=attachment&post_mime_type=image&post_parent='.$query->post->ID, ARRAY_A ); // Return ARRAY
												$get_images   = array_values( $get_children );  // Put keys on ARRAY
												// -------------------------------------------------------
												// Verifier s'il y a une nouvelle photo depuis l'import V3
												// -------------------------------------------------------
												$meta_photo_1 = @get_post_meta( $query->post->ID, 'photo_1', true );
												//if ( isset($meta_photo_1) && ( $meta_photo_1 == '0' || $meta_photo_1 > 0 ) ) {
												if ( isset($meta_photo_1) && $meta_photo_1 > 0 ) {
													$value = wp_get_attachment_image( intval($meta_photo_1), array($thumbnail_width, $thumbnail_height), "", array( "class" => "img-responsive eq-carousel-mob" ) );
												} else {
													// Sinon, prendre celle de l'import
													$photo_1_id = @$get_images[0]["ID"]; // First attached image
													if ( $photo_1_id > 0 ) {
														$value = wp_get_attachment_image( $photo_1_id, array( $thumbnail_width, $thumbnail_height ), "", array( "class" => "img-responsive import-attachment-image" ) );
													} else {
														$value = '<img class="eq-carousel-mob" src="' . EQUIPEER_URL . 'assets/images/no_image_available.jpg" with="' . $thumbnail_width . 'px" height="' . $thumbnail_height . 'px">';
													}
												}
												// -------------------------
												// Item
												// -------------------------
												echo '<!-- ITEM START --> 
													<div class="col count-'.$cpt_carousel.'" >
														<div class="item-box-blog">
															<div class="item-box-blog-image">
																<!-- Expert -->
																<div class="item-box-blog-expert">
																	<img src="' . EQUIPEER_URL . 'assets/images/tampon-expertise-equipeer.png" alt="Expert" title="">
																</div>
																<!-- Photo -->
																<figure>
																	' . $value . '
																</figure>
															</div>
															<div class="item-box-blog-body">
																<!-- Text -->
																<div class="item-box-blog-heading">
																	<h3>' . esc_html( equipeer_head_text_horse( $query->post->ID ) ) . '</h3>
																</div>
																<!-- Read More Button -->
																<div class="item-box-blog-text">
																	<a href="' . get_permalink( $query->post->ID ) . '">' . __( 'Learn more about this horse', EQUIPEER_ID ) . '</a>
																</div>
															</div>
														</div>
													</div>
													<!-- ITEM END -->
												';
												// -------------------------
												// Check if Multiple of 3
												// -------------------------
												if ( $cpt_carousel > 0 && in_array( $cpt_carousel, $multiples ) && $cpt_carousel < $count_posts ) {
													echo '</div>
															<!--.row-->
														</div>
														<!-- .carousel-item BY 3 Items -->
														
														<!-- Carousel BY 3 Items -->
														<div class="carousel-item">
															<div class="row">
													';
												}
												// Incrementation of Carousel counter
												$cpt_carousel++;
											}
										?>
										
									</div>
									<!--.row-->
								</div>
								<!--.carousel-item-->

							</div>
							<!--.carousel-inner-->
						
						</div>
						<!--.Carousel-->
					</div>
				</div>
			</div>
		</div>
		
		<script>
			jQuery( document ).ready(function() {
				jQuery("#<?php echo $carousel_ID; ?>").carousel({
						//interval: <?php echo intval($instance['carousel_number']); ?>* 1000
				});
			});	
		</script>
		<?php
		// ---------------------------------------
		// ----------------- End -----------------
		// ---------------------------------------
		if ( isset($args['after_widget']) ) echo $args['after_widget'];

		/* Restore original Post Data */
		wp_reset_postdata();
	}
	
}

?>