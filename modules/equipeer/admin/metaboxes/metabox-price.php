<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Metabox Equine Price
 *
 * @class Metabox
 */
class Equipeer_Metabox_Price extends Equipeer {
	
	private $mt_prefix = 'price';
	
    /**
     * Constructor for the Equipeer_Metabox_Price class
     *
     * Sets up all the appropriate hooks and actions
     */
    function __construct() {
        // Add metaboxes
        add_action( 'add_meta_boxes', array( $this, 'date_add_meta_box' ) );
		// Save infos from metaboxes
		add_action( 'save_post', array( $this, 'date_save' ) );
		// Metabox class (call)
		$this->metaboxClass = new Equipeer_Metabox();
		// Titan call
		$this->equipeer_options = TitanFramework::getInstance( EQUIPEER_ID );
	}
	
    /**
     * Adds the meta box container.
     */
	function date_add_meta_box() {
		add_meta_box(
			'equipeer-' . $this->mt_prefix,
			__( 'Price', EQUIPEER_ID ),
			array( $this, 'date_html' ),
			$this->post_type,
			'normal', // normal | advanced | side
			'high' // default | high | core | low
		);
	}
	
    /**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
	function date_html( $post) {
		wp_nonce_field( '_date_nonce', 'date_nonce' );
		
		// Get label options RANGE
		$range_start       = number_format( get_option( 'equine_range_start' ), 0, "", "." );
		$range_start_raw   = intval( get_option( 'equine_range_start' ) );
		// ------------------------
		$range_1_until     = number_format( get_option( 'equine_range_1_until' ), 0, "", "." );
		$range_1_until_raw = intval( get_option( 'equine_range_1_until' ) );
		// ------------------------
		$range_2_until     = number_format( get_option( 'equine_range_2_until' ), 0, "", "." );
		$range_2_until_raw = intval( get_option( 'equine_range_2_until' ) );
		// ------------------------
		$range_3_until     = number_format( get_option( 'equine_range_3_until' ), 0, "", "." );
		$range_3_until_raw = intval( get_option( 'equine_range_3_until' ) );
		// ------------------------
		$range_4_until     = number_format( get_option( 'equine_range_4_until' ), 0, "", "." );
		$range_4_until_raw = intval( get_option( 'equine_range_4_until' ) );
		// ------------------------
		?>
		
		<!-- ===== MESSAGE NON VISIBLE ===== -->
		<div id="equipeer-video-help" class="equipeer-msg equipeer-msg-info equipeer-none">
			<span class="equipeer-msg-closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
			<h4 style="margin: 0 0 0.3em 0;">TRANCHE DE PRIX (<a href="<?php echo admin_url(); ?>edit.php?post_type=equine&page=equine-options">Modifier</a>)</h4>
			<strong class="equipeer-red">€</strong>€€€€ &nbsp;&nbsp;:&nbsp;&nbsp; <?php echo $range_start; ?> à <?php echo $range_1_until; ?>€<br>
			<strong class="equipeer-red">€€</strong>€€€ &nbsp;&nbsp;:&nbsp;&nbsp; <?php echo $range_1_until; ?> à <?php echo $range_2_until; ?>€<br>
			<strong class="equipeer-red">€€€</strong>€€ &nbsp;&nbsp;:&nbsp;&nbsp; <?php echo $range_2_until; ?> à <?php echo $range_3_until; ?>€<br>
			<strong class="equipeer-red">€€€€</strong>€ &nbsp;&nbsp;:&nbsp;&nbsp; <?php echo $range_3_until; ?> à <?php echo $range_4_until; ?>€<br>
			<strong class="equipeer-red">€€€€€</strong> &nbsp;&nbsp;:&nbsp;&nbsp; &gt; <?php echo $range_4_until; ?>€<br>
		</div>
		<div id="equipeer-video-help" class="equipeer-msg equipeer-msg-warning">
			<span class="equipeer-msg-closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
			Modification des tranches de prix :&nbsp;<a target="_blank" href="<?php echo admin_url(); ?>edit.php?post_type=equine&page=equine-options">Modifier</a>
			<br>
			Le prix EQUIPEER est dans la tranche <span id="price-range">0</span>
		</div>

		<!-- ===== PRIX NON VISIBLE ===== -->
		<p class="equipeer_p_form_s equipeer-none">
			<label for="price"><?php _e( 'Price (&euro;&euro;&euro;&euro;&euro;)', EQUIPEER_ID ); ?></label><br>
			<select name="price" id="price" class="equipeer-select-number">
				<option value=""><?php _e( '&mdash; Select &mdash;', EQUIPEER_ID ); ?></option>
				<?php
					for($i = 1; $i < 6; ++$i) {
						echo '<option value="' . $i . '" ';
						echo selected( $this->metaboxClass->get_meta_value('price'), $i );
						echo '>';
						echo $i;
						echo '</option>';
					}
				?>
			</select>
			<span style="clear: both; display: block;" class="description">Change en fonction du prix EQUIPEER</span>
		</p>
		<p class="equipeer_p_form_s">
			<label for="price_real"><?php _e( 'Net seller price', EQUIPEER_ID ); ?></label><br>
			<input class="equipeer-input-number" type="text" name="price_real" id="price_real" value="<?php echo $this->metaboxClass->get_meta_value( 'price_real' ); ?>">
			<span class="equipeer-input-suffix">&euro;</span>
			<br>
			<span style="clear: both; display: block;" class="description"><?php _e( 'Vendor price', EQUIPEER_ID ); ?></span>
		</p>
		<p class="equipeer_p_form_s">
			<label for="price_equipeer"><?php _e( 'EQUIPEER Price', EQUIPEER_ID ); ?></label><br>
			<input class="equipeer-input-number" type="text" name="price_equipeer" id="price_equipeer" value="<?php echo $this->metaboxClass->get_meta_value( 'price_equipeer' ); ?>">
			<span class="equipeer-input-suffix">&euro;</span>
			<br>
			<span style="clear: both; display: block;" class="description"><?php _e( 'Equipeer price (with commission)', EQUIPEER_ID ); ?></span>
		</p>
		<p class="equipeer_p_form_s">
			<label for="price_commission"><?php _e( 'EQUIPEER Commission TTC', EQUIPEER_ID ); ?></label><br>
			<input class="equipeer-input-number" type="text" name="price_commission" id="price_commission" value="<?php echo $this->metaboxClass->get_meta_value( 'price_commission' ); ?>">
			<span class="equipeer-input-suffix">&euro;</span>
			<br>
			<span style="clear: both; display: block;" class="description"><?php _e( 'Equipeer commission (commission amount only)', EQUIPEER_ID ); ?></span>
		</p>
		<p class="equipeer_p_form_s">
			<label for="price_tva_label"><?php _e( 'Price with VAT', EQUIPEER_ID ); ?></label><br>
			<?php $price_tva_checked = ( $this->metaboxClass->get_meta_value('price_tva') == 1 ) ? 'checked' : ''; ?>				
			<label class="switch switch-green">
			  <input type="checkbox" name="price_tva" id="price_tva" class="switch-input" <?php echo $price_tva_checked; ?>>
			  <span class="switch-label" data-on="Oui" data-off="Non"></span>
			  <span class="switch-handle"></span>
			</label>
		</p>
		<p class="equipeer_p_form_s">
			<label for="price_tva_taux"><?php _e( 'VAT rate', EQUIPEER_ID ); ?></label><br>
			<input class="equipeer-input-number" type="text" name="price_tva_taux" id="price_tva_taux" value="<?php echo $this->metaboxClass->get_meta_value( 'price_tva_taux' ); ?>">
			<span class="equipeer-input-suffix">&percnt;</span>
		</p>
		<div class="equipeer_clear"></div>
		<script>
			// Initialize text price range
			var price_range_1 = "<?php echo $range_start; ?>&euro; &agrave; <?php echo $range_1_until; ?>&euro;"; 
			var price_range_2 = "<?php echo $range_1_until; ?>&euro; &agrave; <?php echo $range_2_until; ?>&euro;"; 
			var price_range_3 = "<?php echo $range_2_until; ?>&euro; &agrave; <?php echo $range_3_until; ?>&euro;"; 
			var price_range_4 = "<?php echo $range_3_until; ?>&euro; &agrave; <?php echo $range_4_until; ?>&euro;"; 
			var price_range_5 = "> <?php echo $range_4_until; ?>&euro;"; 

			(function() { // Onload
				var new_price = jQuery("#price_equipeer").val();
				equipeer_show_price_range(new_price);
			})();
			
			function equipeer_show_price_range(new_price) {
					var new_range_price = 0;
					if ( new_price <= <?php echo $range_1_until_raw; ?> ) {
						new_range_price = 1;
						show_range = price_range_1;
					} else if ( new_price <= <?php echo $range_2_until_raw; ?> ) {
						new_range_price = 2;
						show_range = price_range_2;
					} else if ( new_price <= <?php echo $range_3_until_raw; ?> ) {
						new_range_price = 3;
						show_range = price_range_3;
					} else if ( new_price <= <?php echo $range_4_until_raw; ?> ) {
						new_range_price = 4;
						show_range = price_range_4;
					} else {
						new_range_price = 5;
						show_range = price_range_5;
					}
				jQuery('#price-range').html( new_range_price + ' : ' + show_range ); // Text
			}
		
			jQuery(function($) {
				// Change price (SELECT) on price_equipeer Changed
				$("#price_equipeer").on("change keyup", function() {
					// Get new value
					var new_price = $(this).val();
					// Affect the SPAN text (format number 98.000)
					var new_range_price = 0;
					if ( new_price <= <?php echo $range_1_until_raw; ?> ) {
						new_range_price = 1;
						show_range = price_range_1;
					} else if ( new_price <= <?php echo $range_2_until_raw; ?> ) {
						new_range_price = 2;
						show_range = price_range_2;
					} else if ( new_price <= <?php echo $range_3_until_raw; ?> ) {
						new_range_price = 3;
						show_range = price_range_3;
					} else if ( new_price <= <?php echo $range_4_until_raw; ?> ) {
						new_range_price = 4;
						show_range = price_range_4;
					} else {
						new_range_price = 5;
						show_range = price_range_5;
					}
					$('#price').val( new_range_price ).change(); // Select
					jQuery('#price-range').html( new_range_price + ' : ' + show_range ); // Text
					console.log('price: '+new_range_price);
				});
			} );
		</script>
		<?php
	}
	
    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
	function date_save( $post_id ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		// Check if our nonce is set AND if that the nonce is valid
		if ( ! isset( $_POST['date_nonce'] ) || ! wp_verify_nonce( $_POST['date_nonce'], '_date_nonce' ) ) return;
		// Check the user's permissions
		if ( ! current_user_can( 'equipeer_edit_equine', $post_id ) ) return;
		// ---------------------------------------------
		// Update the meta field
		// ---------------------------------------------
		if ( isset( $_POST['price'] ) )
			update_post_meta( $post_id, 'price', esc_attr( $_POST['price'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['price_real'] ) )
			update_post_meta( $post_id, 'price_real', esc_attr( $_POST['price_real'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['price_equipeer'] ) )
			update_post_meta( $post_id, 'price_equipeer', esc_attr( $_POST['price_equipeer'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['price_commission'] ) )
			update_post_meta( $post_id, 'price_commission', esc_attr( $_POST['price_commission'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['price_tva'] ) )
			update_post_meta( $post_id, 'price_tva', '1' );
		else
			update_post_meta( $post_id, 'price_tva', '0' );
		// ---------------------------------------------
		if ( isset( $_POST['price_tva_taux'] ) )
			update_post_meta( $post_id, 'price_tva_taux', esc_attr( $_POST['price_tva_taux'] ) );
		// ---------------------------------------------
	}
	
}