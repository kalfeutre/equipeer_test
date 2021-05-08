<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WP_Bootstrap_Starter
 */

// ----------------------------------------
$single_page_id = get_queried_object_id();
$current_url    = get_permalink( $single_page_id );
// ----------------------------------------
$the_id = get_the_ID();
// ----------------------------------------
$lang   = (ICL_LANGUAGE_CODE == 'fr') ? ICL_LANGUAGE_CODE : 'en';
$source = $lang;
$target = (ICL_LANGUAGE_CODE == 'fr') ? "en" : "fr";
// ----------------------------------------
$default_photo_full       = "equipeer-no-photo-full.jpg";
$default_photo_thumb      = "equipeer-no-photo-thumb.jpg";
$default_video_blur_thumb = get_stylesheet_directory_uri() . '/assets/images/default-thumbnail-video-blur.jpg';
$default_image_blur_thumb = get_stylesheet_directory_uri() . '/assets/images/default-thumbnail-image-blur.jpg';
$default_video_icon       = get_stylesheet_directory_uri() . '/assets/images/video-icon-play.png';
$default_photo_full_url   = get_stylesheet_directory_uri() . '/assets/images/' . $default_photo_full;
$default_class_img_100    = "img-fluid mx-auto d-block img-width-100";
// ----------------------------------------
$photo_width      = '730';
$photo_height     = '500';
$thumbnail_width  = '133';
$thumbnail_height = '100';
$video_width      = '100%';
$video_height     = '500';
// ----------------------------------------
$get_site_url             = get_site_url();
$get_bloginfo_name        = trim( get_bloginfo( 'name' ) );
$get_bloginfo_description = (ICL_LANGUAGE_CODE == 'fr') ? trim( get_bloginfo( 'description' ) ) : trim( get_option( 'equine_bloginfo_slogan_en' ) );
$get_equipeer_slug        = Equipeer()->slug;
$get_head_text_horse      = equipeer_head_text_horse( $the_id, false );
// ----------------------------------------
// --------- IMAGES / THUMBNAILS ----------
// ----------------------------------------
$photo_1_id       = @get_post_meta( $the_id, 'photo_1', true );
$photo_1_path     = ($photo_1_id) ? get_attached_file( $photo_1_id ) : false; // Full path
$thumbnail_1_src  = ($photo_1_id) ? wp_get_attachment_image_src( $photo_1_id, array("$thumbnail_width",  "$thumbnail_height") ) : false;
$photo_1_url      = ($thumbnail_1_src) ? wp_get_attachment_image_src( $photo_1_id, 'full' ) : false;
// ----------------------------------------
$photo_2_id       = get_post_meta( $the_id, 'photo_2', true );
$photo_2_path     = ($photo_2_id) ? get_attached_file( $photo_2_id ) : false; // Full path
$thumbnail_2_src  = ($photo_2_id) ? wp_get_attachment_image_src( $photo_2_id, array("$thumbnail_width",  "$thumbnail_height") ) : false;
$photo_2_url      = ($thumbnail_2_src) ? wp_get_attachment_image_src( $photo_2_id, 'full' ) : false;
// ----------------------------------------
$photo_3_id       = get_post_meta( $the_id, 'photo_3', true );
$photo_3_path     = ($photo_3_id) ? get_attached_file( $photo_3_id ) : false; // Full path
$thumbnail_3_src  = ($photo_3_id) ? wp_get_attachment_image_src( $photo_3_id, array("$thumbnail_width",  "$thumbnail_height") ) : false;
$photo_3_url      = ($thumbnail_3_src) ? wp_get_attachment_image_src( $photo_3_id, 'full' ) : false;
// ----------------------------------------
$photo_4_id       = get_post_meta( $the_id, 'photo_4', true );
$photo_4_path     = ($photo_4_id) ? get_attached_file( $photo_4_id ) : false; // Full path
$thumbnail_4_src  = ($photo_4_id) ? wp_get_attachment_image_src( $photo_4_id, array("$thumbnail_width",  "$thumbnail_height") ) : false;
$photo_4_url      = ($thumbnail_4_src) ? wp_get_attachment_image_src( $photo_4_id, 'full' ) : false;
// ----------------------------------------
// --------- VIDEOS / THUMBNAILS ----------
// ----------------------------------------
$video_main_url         = get_post_meta( $the_id, 'video_main', true );
$video_main_is          = ($video_main_url) ? equipeer_video_is( $video_main_url ) : false;
$video_main_thumbnail   = ($video_main_url && $video_main_is) ? equipeer_video_thumbnail( $video_main_is['video_type'], $video_main_is['video_id'] ) : false;
// ----------------------------------------
$video_second_url       = get_post_meta( $the_id, 'video_second', true );
$video_second_is        = ($video_second_url) ? equipeer_video_is( $video_second_url ) : false;
$video_second_thumbnail = ($video_second_url && $video_second_is) ? equipeer_video_thumbnail( $video_second_is['video_type'], $video_second_is['video_id'] ) : false;
// ----------------------------------------
$video_third_url        = get_post_meta( $the_id, 'video_third', true );
$video_third_is         = ($video_third_url) ? equipeer_video_is( $video_third_url ) : false;
$video_third_thumbnail  = ($video_third_url && $video_third_is) ? equipeer_video_thumbnail( $video_third_is['video_type'], $video_third_is['video_id'] ) : false;
// ---------------------------------------
$video_fourth_url        = get_post_meta( $the_id, 'video_fourth', true );
$video_fourth_is         = ($video_fourth_url) ? equipeer_video_is( $video_fourth_url ) : false;
$video_fourth_thumbnail  = ($video_fourth_url && $video_fourth_is) ? equipeer_video_thumbnail( $video_fourth_is['video_type'], $video_fourth_is['video_id'] ) : false;
// ---------------------------------------
// --- Sample NOT CONNECTED button
// ---------------------------------------
// <button class="eq-button eq-button-blue equipeer-not-connected"
//         data-title="Vous n'êtes pas connecté.e ?"
//         data-text="Cette fonctionnalité est réservée aux utilisateurs connectés"
//         data-cancel="fermer"
//         data-connect="Se connecter"
//         data-connect-url="https://localhost/clients/equipeer/"
//         data-register="S'enregistrer"
//         data-register-url="https://localhost/clients/equipeer/">
//         Fonctionnalités non accessible
// </button>
// -----------------------------------------
// -----------------------------------------
// -----------------------------------------
// --- MOBILE PREV/LIST/NEXT/SELECTION/CHAT
// -----------------------------------------
// -----------------------------------------
// -----------------------------------------
//echo do_shortcode('[equine-prev-list-next-mob]');

// -----------------------------------------
// -----------------------------------------
// -----------------------------------------
// --- BREADCRUMB
// -----------------------------------------
// -----------------------------------------
// -----------------------------------------
?>
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="<?php echo $get_site_url; ?>"><?php echo $get_bloginfo_name; ?></a></li>
		<li class="breadcrumb-item"><a href="<?php echo $get_site_url . '/' . $get_equipeer_slug; ?>"><?php echo $get_bloginfo_description; ?></a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php echo $get_head_text_horse; ?></li>
	</ol>
</nav>
<!-- ===== BREADCRUMB (JSON) ===== -->
<script type="application/ld+json">
	{
		"@context": "http://schema.org",
		"@type": "BreadcrumbList",
		"itemListElement":
			[{
				"@type": "ListItem",
				"position": 1,
				"item": {
					"@id": "<?php echo $get_site_url; ?>",
					"name": "<?php echo $get_bloginfo_name; ?>"
				}
			},
			{
				"@type": "ListItem",
				"position": 2,
				"item": {
					"@id": "<?php echo $get_site_url . '/' . $get_equipeer_slug; ?>",
					"name": "<?php echo $get_bloginfo_description; ?>"
				}
			},
			{
				"@type": "ListItem",
				"position": 3,
				"item": {
					"@id": "",
					"name": "<?php echo $get_head_text_horse; ?>"
				}
			}
		]
	}
</script>
<?php
// ---------------------------------------
// ---------------------------------------
// ---------------------------------------
// --- CAROUSEL
// ---------------------------------------
// ---------------------------------------
// ---------------------------------------
?>
<link type="text/css" rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/lightslider/css/lightslider.min.css'">
<script src="<?php echo get_stylesheet_directory_uri(); ?>/assets/js/lightslider/js/lightslider.min.js"></script>
	
<div class="equipeer-carousel equine-single-<?php echo $the_id; ?>">

	<div class="equipeer-single-media-1">
		<?php
			// ----------------------------------
			//              PHOTOS
			// ----------------------------------
			// Check if is photos
			// ----------------------------------
			// PHOTO 1 Full OR NO PHOTO (User not connected)
			$photo_1_tag_id = "image-1";
			$photo_1_image = ($photo_1_id > 0) ?
			                 equipeer_image_url( equipeer_image_orientation($photo_1_path), $photo_1_tag_id, $photo_1_id, $photo_width, $photo_height, $get_head_text_horse )
							 :
							 '<img id="'.$photo_1_tag_id.'" class="'.$default_class_img_100.'" src="'.$default_photo_full_url.'" alt="'.$get_head_text_horse.'">';
			echo $photo_1_image;
			// Vendu OU pas
			if (get_post_meta( $the_id, 'sold', true ) == 1) {
				echo '<img class="cursor horse-sold-detail" src="' . get_stylesheet_directory_uri() . '/assets/images/filigrane-vendu-' . $lang . '.png">';
			}
			// Expertise OU pas
			$type_annonce = get_post_meta( $the_id, 'type_annonce', true ); // 1: Libre - 2: Expertise
			if (get_post_meta( $the_id, 'to_expertise', true ) == 1 && $type_annonce == 2) {
				echo '<img class="cursor horse-expertise-detail" src="' . get_stylesheet_directory_uri() . '/assets/images/tampon-expertise-equipeer.png">';
			}
			// --- PHOTO 2 Full if exists (User connected)
			if ($photo_2_id > 0 && is_user_logged_in()) {
				$photo_2_tag_id = "image-2";
				echo equipeer_image_url( equipeer_image_orientation($photo_2_path), $photo_2_tag_id, $photo_2_id, $photo_width, $photo_height, $get_head_text_horse, true );
			}
			// --- PHOTO 3 Full if exists (User connected)
			if ($photo_3_id > 0 && is_user_logged_in()) {
				$photo_3_tag_id = "image-3";
				echo equipeer_image_url( equipeer_image_orientation($photo_3_path), $photo_3_tag_id, $photo_3_id, $photo_width, $photo_height, $get_head_text_horse, true );
			}
			// --- PHOTO 4 Full if exists (User connected)
			if ($photo_4_id > 0 && is_user_logged_in()) {
				$photo_4_tag_id = "image-4";
				echo equipeer_image_url( equipeer_image_orientation($photo_4_path), $photo_4_tag_id, $photo_4_id, $photo_width, $photo_height, $get_head_text_horse, true );
			}
			// --- VIDEO 1 Main (User connected)
			if ($video_main_is && is_user_logged_in()) {
				echo '<div id="video-1" class="d-none video-type">';
					echo equipeer_selected_video( $video_main_is['video_type'], $video_main_url, $video_main_is['video_id'], $video_width, $video_height );
				echo '</div>';
			}
			// --- VIDEO 2 Second (User connected)
			if ($video_second_is && is_user_logged_in()) {
				echo '<div id="video-2" class="d-none video-type">';
					echo equipeer_selected_video( $video_second_is['video_type'], $video_second_url, $video_second_is['video_id'], $video_width, $video_height );
				echo '</div>';
			}
			// --- VIDEO 3 Third (User connected)
			if ($video_third_is && is_user_logged_in()) {
				echo '<div id="video-3" class="d-none video-type">';
					echo equipeer_selected_video( $video_third_is['video_type'], $video_third_url, $video_third_is['video_id'], $video_width, $video_height );
				echo '</div>';
			}
			// --- VIDEO 4 Fourth (User connected)
			if ($video_fourth_is && is_user_logged_in()) {
				echo '<div id="video-4" class="d-none video-type">';
					echo equipeer_selected_video( $video_fourth_is['video_type'], $video_fourth_url, $video_fourth_is['video_id'], $video_width, $video_height );
				echo '</div>';
			}
			
		?>
	</div> <!-- End .equipeer-single-media-1 -->
	
	<div id="equine-single-carousel" class="container text-center my-3">

		<div class="item">  
			<ul id="equine-slider" class="content-slider">
				<?php
				// ----------------------------------
				$thumbnails = 0;
				// ----------------------------------
				// --- Thumbnail 1 (User not connected)
				// ----------------------------------
				if ($thumbnail_1_src) { ?>
					<li>
						<?php echo '<img class="carousel-event image-type" src="' . $thumbnail_1_src[0] . '" data-id="image-1" alt="">'; ?>
					</li>
					<?php
					$thumbnails++;
				}
				// ----------------------------------
				// --- Thumbnail 2 (User connected)
				// ----------------------------------
				if ($thumbnail_2_src) { ?>
					<li>
						<?php
							if (is_user_logged_in()) {
								echo '<img class="carousel-event image-type" src="' . $thumbnail_2_src[0] . '" data-id="image-2" alt="">';
							} else {
								// $default_image_blur_thumb
								echo '<img class="image-type equipeer-not-connected content-media-no"
										   data-title="' . __( "You're not logged in?", EQUIPEER_ID ) . '"
										   data-text="' . __( 'This functionality is reserved for connected users', EQUIPEER_ID ) . '"
										   data-cancel="' . __( 'Close', EQUIPEER_ID ) . '"
										   data-connect="' . __( 'Sign in', EQUIPEER_ID ) . '"
										   data-connect-url="' . get_site_url() . '/login/"
										   data-register="' . __( 'Sign up', EQUIPEER_ID ) . '"
										   data-register-url="' . get_site_url() . '/register/"
										   src="' . $thumbnail_2_src[0] . '"
										   alt="">';
							}
						?>
					</li>
					<?php
					$thumbnails++;
				}
				// ----------------------------------
				// --- Thumbnail 3 (User connected)
				// ----------------------------------
				if ($thumbnail_3_src) { ?>
					<li>
						<?php
							if (is_user_logged_in()) {
								echo '<img class="carousel-event image-type" src="' . $thumbnail_3_src[0] . '" data-id="image-3" alt="">';
							} else {
								// $default_image_blur_thumb
								echo '<img class="image-type equipeer-not-connected content-media-no"
										   data-title="' . __( "You're not logged in?", EQUIPEER_ID ) . '"
										   data-text="' . __( 'This functionality is reserved for connected users', EQUIPEER_ID ) . '"
										   data-cancel="' . __( 'Close', EQUIPEER_ID ) . '"
										   data-connect="' . __( 'Sign in', EQUIPEER_ID ) . '"
										   data-connect-url="' . get_site_url() . '/login/"
										   data-register="' . __( 'Sign up', EQUIPEER_ID ) . '"
										   data-register-url="' . get_site_url() . '/register/"
										   src="' . $thumbnail_3_src[0] . '"
										   alt="">';
							}
						?>
					</li>
					<?php
					$thumbnails++;
				}
				// ----------------------------------
				// --- Thumbnail 4 (User connected)
				// ----------------------------------
				if ($thumbnail_4_src) { ?>
					<li>
						<?php
							if (is_user_logged_in()) {
								echo '<img class="carousel-event image-type" src="' . $thumbnail_4_src[0] . '" data-id="image-4" alt="">';
							} else {
								// $default_image_blur_thumb
								echo '<img class="image-type equipeer-not-connected content-media-no"
										   data-title="' . __( "You're not logged in?", EQUIPEER_ID ) . '"
										   data-text="' . __( 'This functionality is reserved for connected users', EQUIPEER_ID ) . '"
										   data-cancel="' . __( 'Close', EQUIPEER_ID ) . '"
										   data-connect="' . __( 'Sign in', EQUIPEER_ID ) . '"
										   data-connect-url="' . get_site_url() . '/login/"
										   data-register="' . __( 'Sign up', EQUIPEER_ID ) . '"
										   data-register-url="' . get_site_url() . '/register/"
										   src="' . $thumbnail_4_src[0] . '"
										   alt="">';
							}
						?>
					</li>
					<?php
					$thumbnails++;
				}
				// ----------------------------------
				// --- Video 1 (Main) (User connected)
				// ----------------------------------
				if ($video_main_url && $video_main_is) { ?>
					<li style="position: relative;">
						<?php
							if (is_user_logged_in()) {
								if ($video_main_is['video_type'] != 'file') echo '<img class="video-type" data-id="video-1" src="' . $default_video_icon . '">';
								echo '<img class="carousel-event ' . $video_main_is['video_type'] . '" data-id="video-1" src="' . $video_main_thumbnail . '" alt="">';
							} else {
								// $default_video_blur_thumb
								echo '<img class="' . $video_main_is['video_type'] . ' equipeer-not-connected content-media-no"
										   data-title="' . __( "You're not logged in?", EQUIPEER_ID ) . '"
										   data-text="' . __( 'This functionality is reserved for connected users', EQUIPEER_ID ) . '"
										   data-cancel="' . __( 'Close', EQUIPEER_ID ) . '"
										   data-connect="' . __( 'Sign in', EQUIPEER_ID ) . '"
										   data-connect-url="' . get_site_url() . '/login/"
										   data-register="' . __( 'Sign up', EQUIPEER_ID ) . '"
										   data-register-url="' . get_site_url() . '/register/"
										   src="' . $video_main_thumbnail . '"
										   alt="">';
							}
						?>
					</li>
					<?php
					$thumbnails++;
				}
				// ----------------------------------
				// --- Video 2 (Second) (User connected)
				// ----------------------------------
				if ($video_second_url && $video_second_is) { ?>
					<li style="position: relative;">
						<?php
							if (is_user_logged_in()) {
								if ($video_second_is['video_type'] != 'file') echo '<img class="video-type" data-id="video-2" src="' . $default_video_icon . '">';
								echo '<img class="carousel-event ' . $video_second_is['video_type'] . '" data-id="video-2" src="' . $video_second_thumbnail . '" alt="">';
							} else {
								// $default_video_blur_thumb
								echo '<img class="' . $video_second_is['video_type'] . ' equipeer-not-connected content-media-no"
										   data-title="' . __( "You're not logged in?", EQUIPEER_ID ) . '"
										   data-text="' . __( 'This functionality is reserved for connected users', EQUIPEER_ID ) . '"
										   data-cancel="' . __( 'Close', EQUIPEER_ID ) . '"
										   data-connect="' . __( 'Sign in', EQUIPEER_ID ) . '"
										   data-connect-url="' . get_site_url() . '/login/"
										   data-register="' . __( 'Sign up', EQUIPEER_ID ) . '"
										   data-register-url="' . get_site_url() . '/register/"
										   src="' . $video_second_thumbnail . '"
										   alt="">';
							}
						?>
					</li>
					<?php
					$thumbnails++;
				}
				// ----------------------------------
				// --- Video 3 (Third) (User connected)
				// ----------------------------------
				if ($video_third_url && $video_third_is) { ?>
					<li style="position: relative;">
						<?php
							if (is_user_logged_in()) {
								if ($video_third_is['video_type'] != 'file') echo '<img class="video-type" data-id="video-3" src="' . $default_video_icon . '">';
								echo '<img class="carousel-event ' . $video_third_is['video_type'] . '" data-id="video-3" src="' . $video_third_thumbnail . '" alt="">';
							} else {
								// $default_video_blur_thumb
								echo '<img class="' . $video_third_is['video_type'] . ' equipeer-not-connected content-media-no"
										   data-title="' . __( "You're not logged in?", EQUIPEER_ID ) . '"
										   data-text="' . __( 'This functionality is reserved for connected users', EQUIPEER_ID ) . '"
										   data-cancel="' . __( 'Close', EQUIPEER_ID ) . '"
										   data-connect="' . __( 'Sign in', EQUIPEER_ID ) . '"
										   data-connect-url="' . get_site_url() . '/login/"
										   data-register="' . __( 'Sign up', EQUIPEER_ID ) . '"
										   data-register-url="' . get_site_url() . '/register/"
										   src="' . $video_third_thumbnail . '"
										   alt="">';
							}
						?>
					</li>
					<?php
					$thumbnails++;
				}
				// ----------------------------------
				// --- Video 4 (Third) (User connected)
				// ----------------------------------
				if ($video_fourth_url && $video_fourth_is) { ?>
					<li style="position: relative;">
						<?php
							if (is_user_logged_in()) {
								if ($video_fourth_is['video_type'] != 'file') echo '<img class="video-type" data-id="video-4" src="' . $default_video_icon . '">';
								echo '<img class="carousel-event ' . $video_fourth_is['video_type'] . '" data-id="video-4" src="' . $video_fourth_thumbnail . '" alt="">';
							} else {
								// $default_video_blur_thumb
								echo '<img class="' . $video_fourth_is['video_type'] . ' equipeer-not-connected content-media-no"
										   data-title="' . __( "You're not logged in?", EQUIPEER_ID ) . '"
										   data-text="' . __( 'This functionality is reserved for connected users', EQUIPEER_ID ) . '"
										   data-cancel="' . __( 'Close', EQUIPEER_ID ) . '"
										   data-connect="' . __( 'Sign in', EQUIPEER_ID ) . '"
										   data-connect-url="' . get_site_url() . '/login/"
										   data-register="' . __( 'Sign up', EQUIPEER_ID ) . '"
										   data-register-url="' . get_site_url() . '/register/"
										   src="' . $video_fourth_thumbnail . '"
										   alt="">';
							}
						?>
					</li>
					<?php
					$thumbnails++;
				} ?>
			</ul>
		</div>
	</div>
	
	<style>
		a.lSPrev:not([href]):not([tabindex]), a.lSNext:not([href]):not([tabindex]) {			
			width: 32px;
			display: block;
			top: 50%;
			height: 32px;
			background-image: url('/datas/themes/wp-bootstrap-starter-child/assets/js/lightslider/img/controls.png');
			cursor: pointer;
			position: absolute;
			z-index: 0; /* 99 */
			margin-top: -16px;
			opacity: .8;
			-webkit-transition: opacity .35s linear 0s;
			transition: opacity .35s linear 0s;
		}
		@media screen and (max-width: 425px) {
			#content {
				overflow: hidden;
			}
			a.lSPrev:not([href]):not([tabindex]), a.lSNext:not([href]):not([tabindex]) {
				display: none;
			}
		}
	</style>
					
	<script>
		jQuery(function($) {
			console.log('Width: '+window.innerWidth);
			// ---------------------------------------
			// Equine SINGLE Carousel
			// ---------------------------------------
			$("#equine-slider").lightSlider({
                loop: false,
                keyPress: true,
				//controls: true,
				item: 6,
				pager: false,
				responsive : [
					{
						breakpoint: 500,
						settings: {
							item: 3
						  }
					}
				]
				//autoWidth: true
            });
			// ---------------------------------------
			// --- EVENT On Click
			// ---------------------------------------
			$(".carousel-event, .video-type").on('click touchend', function(event) {
				event.preventDefault();
				var data_id = $(this).attr('data-id'); // Ex: image-1 OR video-2
				// Check if click on the video
				if (!data_id) return;
				for (i = 1; i < 5; i++) {
					// Images (display none)
					$(".equipeer-single-media-1 img#image-"+i).addClass('d-none').removeClass('d-block');
					// Videos (display none)
					$(".equipeer-single-media-1 div#video-"+i).addClass('d-none').removeClass('d-block');
				}
				// Get type
				var type = data_id.split("-");
				// Show the right IMAGE or VIDEO
				switch(type[0]) {
					case "video":
						//$('.youtube-video').contentWindow.postMessage('{"event":"command","func":"' + 'stopVideo' + '","args":""}', '*');
						$(".equipeer-single-media-1 div#video-"+type[1]).addClass('d-block');
						if (window.innerWidth < 425) {
							$('.equipeer-single-media-1 iframe, .equipeer-single-media-1 video').css('height', '280px');
						}
					break;
					case "image":
						$(".equipeer-single-media-1 img#image-"+type[1]).addClass('d-block');
					break;
				}
				// Stop YOUTUBE video
				$('.youtube-video').each(function() {
					this.contentWindow.postMessage('{"event":"command","func":"stopVideo","args":""}', '*');
				});
				// Stop HTML5 video
				//$('.html5-video').each(function() {
					//document.getElementsByClassName('html5-video').rewind();
				//});
				var video = document.querySelector( 'video' );
				if ( video ) {
					video.pause();
				}
			});
		});
	</script>
	
</div>

<?php
// ---------------------------------------
// ---------------------------------------
// ---------------------------------------
// --- REFERENCE (User not connected)
// --- PRIX (User connected)
// ---------------------------------------
// ---------------------------------------
// ---------------------------------------
$the_prefix    = get_term_meta( get_post_meta( $the_id, 'discipline', true ), 'equipeer_prefix_taxonomy_parent_id', true );
$the_reference = @get_post_meta( $the_id, 'reference', true );
// ---------------------------------------
?>

<script>
	// ---------------------------------------
	// FACEBOOK PIXEL TRACKING : VIEWCONTENT
	// ---------------------------------------
	fbq('track', 'ViewContent', {
		content_ids: '<?php echo $the_prefix . '-' . equipeer_get_format_reference( $the_reference ); ?>',
		content_type: 'product'
	});
</script>

<div class="alert alert-dark rounded-0">
  <div class="row">
    <div id="get-ref" data-ref="<?php echo $the_prefix . '-' . equipeer_get_format_reference( $the_reference ); ?>" class="col-4 col-sm-4 eq-color text-left">
      <strong>REF</strong>: <?php echo $the_prefix . '-' . equipeer_get_format_reference( $the_reference ); ?>
    </div>
	<?php
		$equipeer_OPT = TitanFramework::getInstance( 'equipeer' );
		$price        = get_option( 'equipeer_options_range_start' );
		$price_tva    = (get_post_meta($the_id, 'price_tva', true)) ? __('Tax included', EQUIPEER_ID) : __('without VAT', EQUIPEER_ID);
	?>
	<?php if (is_user_logged_in()) { ?>
    <div class="col-8 col-sm-8 eq-color text-right">
      <strong><?php _e( 'Price', EQUIPEER_ID ); ?> <?php echo $price_tva; ?></strong> : <?php echo equipeer_get_price( get_post_meta($the_id, 'price_equipeer', true), false ); ?>
    </div>
	<?php } ?>
  </div>
</div>
<?php
// ---------------------------------------
// ---------------------------------------
// ---------------------------------------
// --- POINTS FORTS (User not connected) - (Annonce libre)
// --- L'AVIS DE L'EXPERT (User not connected) - (Annonce expertise)
// type_annonce
// 1: Annonce libre
// 2: Annonce expertise
// ---------------------------------------
// ---------------------------------------
// ---------------------------------------
$type_annonce = (get_post_meta( $the_id, 'type_annonce', true ) == 1) ? 'libre' : 'expertise';
?>
<h2><?php if ($type_annonce == 'expertise') _e( "The expert's opinion", 'wp-bootstrap-starter' ); else _e( "Strong points", 'wp-bootstrap-starter' ); ?></h2>
<?php
	if (get_post_meta( $the_id, 'impression', true ) != '') {
        // -------------------------------
        // TRANSLATE TEXT
        // -------------------------------
        $translate_impression = equipeer_translate( get_post_meta( $the_id, 'impression', true ), $source, $target ); // Array: translated | source
		// -------------------------------
		echo nl2br( $translate_impression['translated'] );
		// -------------------------------
	} else {
		echo '<h3>' . __( "No expert's opinion", 'wp-bootstrap-starter' ) . '</h3>';
	}
// ---------------------------------------
// ---------------------------------------
// ---------------------------------------
// --- INFORMATIONS GENERALES (User not connected)
// ---------------------------------------
// ---------------------------------------
// ---------------------------------------
$general_informations = [
	 __( 'Discipline', EQUIPEER_ID ) => get_term_by( 'id', get_post_meta( $the_id, 'discipline', true ), 'equipeer_discipline' )->name
	,__( 'Breed', EQUIPEER_ID )      => get_term_by( 'id', get_post_meta( $the_id, 'breed', true ), 'equipeer_breed' )->name
	,__( 'Gender', EQUIPEER_ID )     => get_term_by( 'id', get_post_meta( $the_id, 'sex', true ), 'equipeer_gender' )->name
	,__( 'Color', EQUIPEER_ID )      => get_term_by( 'id', get_post_meta( $the_id, 'dress', true ), 'equipeer_color' )->name
	,__( 'Size', EQUIPEER_ID )       => get_post_meta( $the_id, 'size_cm', true ) . ' cm'
	//,__( 'Age', EQUIPEER_ID )        => equipeer_get_age( get_post_meta( $the_id, 'birthday_real', true ) )
	,__( 'Age', EQUIPEER_ID )        => equipeer_get_age_by_year( get_post_meta( $the_id, 'birthday', true ) )
]
?>
<h2><?php _e( "General informations", 'wp-bootstrap-starter' ); ?></h2>
<div class="table-responsive-sm">
	<table class="table table-striped table-sm table-borderless">
		<tbody>
			<?php
				foreach($general_informations as $key => $value) {
					echo '<tr>';
						echo '<th scope="row">&nbsp;' . $key . '</th>';
						echo '<td>' . $value . '</td>';
					echo '</tr>';
				}
			?>
		</tbody>
	</table>
</div>
<?php
// ---------------------------------------
// ---------------------------------------
// ---------------------------------------
// --- USER NOT CONNECTED
// ---------------------------------------
// ---------------------------------------
// ---------------------------------------
if ( !is_user_logged_in() ) {
	?>
	<hr class="hr-color">
	<p class="text-center eq-color">
		<strong class="eq-color-red"><?php _e("The rest is reserved for connected users.", 'wp-bootstrap-starter'); ?></strong>
		<?php _e("Already a Equipeer SPORT account?", 'wp-bootstrap-starter'); ?>
		<a href="<?php echo get_site_url(); ?>/login/"><?php _e("Sign in", 'wp-bootstrap-starter'); ?></a>
	</p>
	
	<div class="container">
		<div class="row">
			<div class="col">
				<div class="media">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-search.png" class="align-self-start mr-3" width="20" alt="">
					<div class="media-body">
						<p class="eq-color">
							<?php _e("Access the <strong>full description of the horse</strong>: price, origin, skills & qualities, location, etc.", 'wp-bootstrap-starter'); ?>
						</p>
					</div>
				</div>
			</div>
			<div class="col">
				<div class="media">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/icon-search.png" class="align-self-start mr-3" width="20" alt="">
					<div class="media-body">
						<p class="eq-color">
							<?php _e("Take advantage of <strong>all the features of our site</strong>: saving and sending a selection, search alerts, etc.", 'wp-bootstrap-starter'); ?>
						</p>
					</div>
				</div>
			</div>
	  </div>
	
	<p class="text-center">
		<a class="btn eq-button-blue" href="<?php echo get_site_url(); ?>/register"><?php _e("Create a free account", 'wp-bootstrap-starter'); ?></a>
	</p>
	
	<hr class="hr-color">
	<?php
} else {
	// ---------------------------------------
	// ---------------------------------------
	// ---------------------------------------
	// --- DESCRIPTION DETAILLEE (User connected)
	// ---------------------------------------
	// ---------------------------------------
	// ---------------------------------------
	$skills_qualities_1 = @get_post_meta( $the_id, 'plat_impression', true );
	$skills_qualities_2 = ($skills_qualities_1 != '' ? "<br>" : '') . @get_post_meta( $the_id, 'obstacle_impression', true );
	$skills_qualities_3 = ($skills_qualities_2 != '' ? "\n" : '') . @get_post_meta( $the_id, 'saut_impression', true );
	// ---------------------------------------
	// -------------------------------
	// TRANSLATE TEXT
	// -------------------------------
	$skills_and_qualities           = $skills_qualities_1 . $skills_qualities_2 . $skills_qualities_3;
	$translate_skills_and_qualities = equipeer_translate( $skills_and_qualities, $source, $target ); // Array: translated | source
	// -------------------------------
	// -------------------------------
	// TRANSLATE TEXT
	// -------------------------------
	$rider_profile           = @get_post_meta( $the_id, 'cavalier_profil', true );
	$translate_rider_profile = equipeer_translate( $rider_profile, $source, $target ); // Array: translated | source
	// ---------------------------------------
	$detailed_description = [
		 __( 'Origin', 'wp-bootstrap-starter' )             => (@get_post_meta( $the_id, 'origin_sire', true )) ? get_post_meta( $the_id, 'origin_sire', true ) : '--'
		,__( 'Skills & qualities', 'wp-bootstrap-starter' ) => nl2br( $translate_skills_and_qualities['translated'] )
		,__( 'Actual level', 'wp-bootstrap-starter' )       => @get_term_by( 'id', get_post_meta( $the_id, 'level', true ), 'equipeer_level' )->name
		,__( 'Potential', 'wp-bootstrap-starter' )          => @get_term_by( 'id', get_post_meta( $the_id, 'potentiel', true ), 'equipeer_potential' )->name
		,__( 'Rider profile', 'wp-bootstrap-starter' )      => $translate_rider_profile['translated']
		,__( 'Radio report', EQUIPEER_ID)                   => (@get_post_meta( $the_id, 'veterinaire_date', true )) ? __('Yes') : __('No')
	]
	?>
	<?php if ($type_annonce == 'expertise') { ?>
	<h2><?php _e( "Detailed description", 'wp-bootstrap-starter' ); ?></h2>
	<div class="table-responsive-sm">
		<table class="table table-striped table-sm table-borderless">
			<tbody>
				<?php
					foreach($detailed_description as $key => $value) {
						echo '<tr>';
							echo '<th scope="row">&nbsp;' . $key . '</th>';
							echo '<td>' . $value . '</td>';
						echo '</tr>';
					}
				?>
			</tbody>
		</table>
	</div>
	<?php } ?>
	<?php
	// ---------------------------------------
	// ---------------------------------------
	// ---------------------------------------
	// --- LOCALISATION
	// ---------------------------------------
	// ---------------------------------------
	// ---------------------------------------
	?>
	<h2>
		<?php
			$latitude  = get_post_meta( $the_id, 'localisation_latitude', true );
			$longitude = get_post_meta( $the_id, 'localisation_longitude', true );
			// Title
			_e( "Localisation", 'wp-bootstrap-starter' );
			// Check if coordinates
			if ($latitude && $longitude) {
				echo ' - ' . equipeer_get_localisation_detail($the_id, false);
			}
		?>
	</h2>
	<?php
		if ($latitude && $longitude) { ?>
            <!--MAJ MODIF JH-->
			 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
                integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
                crossorigin=""/>
			<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
                integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
                crossorigin=""></script>
            
			<script>
				jQuery(function($) {
					var mymap = L.map('mapid').setView([<?php echo $latitude; ?>, <?php echo $longitude; ?>], 7);
				
					L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
						maxZoom: 8,
						attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
							'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
							'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',id: 'mapbox/streets-v11',
                        tileSize: 512,
                        zoomOffset: -1
					}).addTo(mymap);
					
					var circle = L.circle([<?php echo $latitude; ?>, <?php echo $longitude; ?>], {
						color: 'red',
						fillColor: '#f03',
						fillOpacity: 0.5,
						radius: 85000
					}).addTo(mymap);
				});
			</script>
			<div id="mapid" style="width: 100%; height: 350px; z-index: 0;"></div>
		
		<?php } else {
			echo '<h3>' . __( "No information about localisation", 'wp-bootstrap-starter' ) . '</h3>';
		}

}