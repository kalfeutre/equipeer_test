<?php
// -------------------------------
global $query;
// -------------------------------
$lang = (ICL_LANGUAGE_CODE == 'fr') ? ICL_LANGUAGE_CODE : 'en';
// -------------------------------
$thumbnail_width       = '230'; // 350
$thumbnail_height      = '160'; // 240
$default_photo_thumb   = get_stylesheet_directory_uri() . '/assets/images/equipeer-no-photo-thumb.jpg';
$default_class_img_100 = "img-fluid mx-auto d-block img-width-100";
// -------------------------------
$post_id  = $query->post->ID;
$photo_id = @get_post_meta( $post_id, 'photo_1', true );
// -------------------------------
$thumbnail_src = ($photo_id) ? wp_get_attachment_image_src( $photo_id, array("$thumbnail_width",  "$thumbnail_height") ) : false;
$photo_path    = ($photo_id) ? get_attached_file( $photo_id ) : false; // Full path
$photo_url     = ($thumbnail_src) ? wp_get_attachment_image_src( $photo_id, 'full' ) : false;
// -------------------------------
// Vendu OU pas
$horse_sold = (get_post_meta( $post_id, 'sold', true ) == 1) ? '<img class="cursor horse-sold-small" src="' . get_stylesheet_directory_uri() . '/assets/images/filigrane-vendu-' . $lang . '.png">' : false;
// Expertise OU pas
$type_annonce    = get_post_meta( $post_id, 'type_annonce', true ); // 1: Libre - 2: Expertise
$horse_expertise = (get_post_meta( $post_id, 'to_expertise', true ) == 1 && $type_annonce == 2) ? '<img class="cursor horse-expertise-small" src="' . get_stylesheet_directory_uri() . '/assets/images/tampon-expertise-equipeer.png">' : false;
// -------------------------------
$get_head_text_horse = equipeer_head_text_horse( $post_id, false );
// -------------------------------
$the_prefix    = get_term_meta( get_post_meta( $post_id, 'discipline', true ), 'equipeer_prefix_taxonomy_parent_id', true );
$the_reference = @get_post_meta( $post_id, 'reference', true );
// -------------------------------
// Selection (ADD or DEL)
$op = equipeer_get_selection($post_id, get_current_user_id());
// -------------------------------
?>

<div class="col-lg-4 col-md-6 col-sm-12 p-3-eq archive-card">
   <h5 style="display: none;"><?php echo $type_annonce; ?></h5>
   <div class="card h-100 text-center eq-color horse-list" data-click-url="<?php echo get_permalink( $post_id ); ?>">
      <?php
         // -------------------------------
         // -------------------------------
         // --- THUMBNAIL
         // -------------------------------
         // -------------------------------
         $photo_tag_id = "horse-thumb-".rand(0,9999);
			$photo_image  = ($photo_id > 0) ?
			                 equipeer_thumbnail_url( equipeer_image_orientation($photo_path), $photo_tag_id, $photo_id, $thumbnail_width, $thumbnail_height, $get_head_text_horse )
							 :
							 '<img id="'.$photo_tag_id.'" class="card-img-top img-fluid" src="'.$default_photo_thumb.'" alt="'.$get_head_text_horse.'">';
         // Thumbnail
			echo $photo_image;
         // Sold
         if ($horse_sold) echo $horse_sold;
         // Expertise
         if ($horse_expertise) echo $horse_expertise;
      ?>
      <!-- Head TEXT -->
      <div class="horse-thumb-title w-100 eq-color">
         <h3><?php echo $get_head_text_horse; ?></h3>
      </div>

      <!--  -->
      <div class="horse-localisation eq-color">
         <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/pointeur-small.png" class="" alt="">
         <?php echo equipeer_get_localisation_detail($post_id); ?>
      </div>
      
      <div class="card-body horse-body">
         <p class="card-text eq-color">
            &laquo; <?php
            echo equipeer_truncate( wp_kses_decode_entities( equipeer_get_post_meta($post_id, 'impression', '--') ), 91, "..." );
            //echo equipeer_truncate( equipeer_get_post_meta($post_id, 'impression', '--'), 91, "..." );
            ?> &raquo;
         </p>
      </div>
      
      <div class="card-footer text-center bg-white horse-footer">
         <div class="row mb-2">
            <div class="col text-left eq-color ml-0 mr-0">
               <strong>Ref</strong>: <?php echo $the_prefix . '-' . equipeer_get_format_reference( $the_reference ); ?>
            </div>
            <?php if (is_user_logged_in()) { ?>
            <div class="col text-right eq-color mr-0 equine-range-price">
               <?php _e("Price", EQUIPEER_ID); ?>: <?php echo equipeer_get_price( get_post_meta($post_id, 'price_equipeer', true) ); ?>
            </div>
            <?php } ?>
         </div>
			<?php
            if ($horse_expertise && !$horse_sold) {
               echo do_shortcode('[equine-add-to-selection-mini pid="'.$post_id.'" uid="' . get_current_user_id() . '" op="' . $op . '"]');
            } else {
               echo '<a class="btn">&nbsp;</a>';
            }
         ?>
      </div>
   </div>
</div>