<?php
/**
 * Blocking direct access to plugin
 */
defined('ABSPATH') or die('Are you crazy!');

/**
 * Equipeer class Metabox Equine Videos
 *
 * @class Metabox
 */
class Equipeer_Metabox_Videos extends Equipeer {
	
	private $mt_prefix = 'videos';
	
    /**
     * Constructor for the Equipeer_Metabox_Videos class
     *
     * Sets up all the appropriate hooks and actions
     */
    function __construct() {
        // Add metaboxes
        add_action( 'add_meta_boxes', array( $this, 'videos_add_meta_box' ) );
		// Save infos from metaboxes
		add_action( 'save_post', array( $this, 'videos_save' ) );
		// Metabox class (call)
		$this->metaboxClass = new Equipeer_Metabox();
		// Titan call
		$this->equipeer_options = TitanFramework::getInstance( EQUIPEER_ID );
	}
	
    /**
     * Adds the meta box container.
     */
	function videos_add_meta_box() {
		add_meta_box(
			'equipeer-' . $this->mt_prefix,
			__( 'Videos', EQUIPEER_ID ),
			array( $this, 'videos_html' ),
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
	function videos_html( $post) {
		wp_nonce_field( '_videos_nonce', 'videos_nonce' ); ?>
		
		<div id="equipeer-video-help" class="equipeer-msg equipeer-msg-warning">
			<span class="equipeer-msg-closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
			Cliquez sur <strong>UPLOAD VIDEO</strong> pour insérer / modifier une vidéo disponible sur votre serveur.<br>
			Vous pouvez mettre des liens <strong>YOUTUBE</strong>, <strong>VIMEO</strong> ou des <strong>vidéos</strong> distantes.<br>
			Ex (YOUTUBE) : https://www.youtube.com/embed/dIy1Jma43WI<br>
			Ex (VIMEO) : https://vimeo.com/265045525<br>
			Ex (FILE) : http://video.time-in.fr/contenu/469/85493/8.mp4
		</div>
		
		<p class="equipeer_p_form" style="text-align: center;">
			<?php $video_main_is = equipeer_video_is( $this->metaboxClass->get_meta_value('video_main') ); ?>
			<label for="video_main"><?php _e( 'Main video', EQUIPEER_ID ); ?> (<?php echo $video_main_is['video_type']; ?>)</label>
			<br>			
			<input type="text" data-videoid="<?php echo $video_main_is['video_id']; ?>" name="video_main" id="video_main" value="<?php echo $this->metaboxClass->get_meta_value( 'video_main' ); ?>">
			<input type="hidden" name="video_main_id" id="video_main_id" value="<?php echo @$this->metaboxClass->get_meta_value( 'video_main_id' ); ?>">
			<span class="equipeer-space"></span>
			<span id="video_main_preview">
				<?php echo equipeer_selected_video( $video_main_is['video_type'], $this->metaboxClass->get_meta_value('video_main'), $video_main_is['video_id']); ?>
			</span>
			<span class="equipeer-space"></span>
			<?php _e( 'Copy / Paste a link', EQUIPEER_ID ); ?><br>&mdash; <?php _e( 'OR', EQUIPEER_ID ); ?> &mdash;<br>
			<a href="#" id="video-upload-btn-main" class="button">Upload VIDEO</a>
		</p>
		
		<p class="equipeer_p_form" style="text-align: center;">
			<?php $video_second_is = equipeer_video_is( $this->metaboxClass->get_meta_value('video_second') ); ?>
			<label for="video_second"><?php _e( 'Second video', EQUIPEER_ID ); ?> (<?php echo $video_second_is['video_type']; ?>)</label>
			<br>			
			<input type="text" data-videoid="<?php echo $video_second_is['video_id']; ?>" name="video_second" id="video_second" value="<?php echo $this->metaboxClass->get_meta_value( 'video_second' ); ?>">
			<input type="hidden" name="video_second_id" id="video_second_id" value="<?php echo @$this->metaboxClass->get_meta_value( 'video_second_id' ); ?>">
			<span class="equipeer-space"></span>
			<span id="video_second_preview">
				<?php echo equipeer_selected_video( $video_second_is['video_type'], $this->metaboxClass->get_meta_value('video_second'), $video_second_is['video_id']); ?>
			</span>
			<span class="equipeer-space"></span>
			<?php _e( 'Copy / Paste a link', EQUIPEER_ID ); ?><br>&mdash; <?php _e( 'OR', EQUIPEER_ID ); ?> &mdash;<br>
			<a href="#" id="video-upload-btn-second" class="button">Upload VIDEO</a>
		</p>
		
		<p class="equipeer_p_form" style="text-align: center;">
			<?php $video_third_is = equipeer_video_is( $this->metaboxClass->get_meta_value('video_third') ); ?>
			<label for="video_third"><?php _e( 'Third video', EQUIPEER_ID ); ?> (<?php echo $video_third_is['video_type']; ?>)</label>
			<br>			
			<input type="text" data-videoid="<?php echo $video_third_is['video_id']; ?>" name="video_third" id="video_third" value="<?php echo $this->metaboxClass->get_meta_value( 'video_third' ); ?>">
			<input type="hidden" name="video_third_id" id="video_third_id" value="<?php echo @$this->metaboxClass->get_meta_value( 'video_third_id' ); ?>">
			<span class="equipeer-space"></span>
			<span id="video_third_preview">
				<?php echo equipeer_selected_video( $video_third_is['video_type'], $this->metaboxClass->get_meta_value('video_third'), $video_third_is['video_id']); ?>
			</span>
			<span class="equipeer-space"></span>
			<?php _e( 'Copy / Paste a link', EQUIPEER_ID ); ?><br>&mdash; <?php _e( 'OR', EQUIPEER_ID ); ?> &mdash;<br>
			<a href="#" id="video-upload-btn-third" class="button">Upload VIDEO</a>
		</p>
		
		<p class="equipeer_p_form" style="text-align: center;">
			<?php $video_fourth_is = equipeer_video_is( $this->metaboxClass->get_meta_value('video_fourth') ); ?>
			<label for="video_fourth"><?php _e( 'fourth video', EQUIPEER_ID ); ?> (<?php echo $video_fourth_is['video_type']; ?>)</label>
			<br>			
			<input type="text" data-videoid="<?php echo $video_fourth_is['video_id']; ?>" name="video_fourth" id="video_fourth" value="<?php echo $this->metaboxClass->get_meta_value( 'video_fourth' ); ?>">
			<input type="hidden" name="video_fourth_id" id="video_fourth_id" value="<?php echo @$this->metaboxClass->get_meta_value( 'video_fourth_id' ); ?>">
			<span class="equipeer-space"></span>
			<span id="video_fourth_preview">
				<?php echo equipeer_selected_video( $video_fourth_is['video_type'], $this->metaboxClass->get_meta_value('video_fourth'), $video_fourth_is['video_id']); ?>
			</span>
			<span class="equipeer-space"></span>
			<?php _e( 'Copy / Paste a link', EQUIPEER_ID ); ?><br>&mdash; <?php _e( 'OR', EQUIPEER_ID ); ?> &mdash;<br>
			<a href="#" id="video-upload-btn-fourth" class="button">Upload VIDEO</a>
		</p>
	
		<script>
			jQuery(function($) {
				/*
				 * Select/Upload image(s) event
				 */
				$('#video-upload-btn-main').click(function(e) {
					e.preventDefault();
					var video = wp.media({ 
						title: 'Upload new VIDEO',
						library : {
							type : 'video' // image, audio, video, application/pdf, ... etc
						},
						// mutiple: true if you want to upload multiple files at once
						multiple: false
					}).open()
					.on('select', function(){
						// This will return the selected image from the Media Uploader, the result is an object
						var uploaded_video = video.state().get('selection').first().toJSON();
						// We convert uploaded_image to a JSON object to make accessing it easier
						// Output to the console uploaded_image
						console.log(uploaded_video);
						var video_url = uploaded_video.url;
						var video_id  = uploaded_video.id;
						// Let's assign the url value to the input field
						$('#video_main').val( video_url );
						$('#video_main_id').val( video_id );
					});
				});
				$('#video-upload-btn-second').click(function(e) {
					e.preventDefault();
					var video = wp.media({ 
						title: 'Upload new VIDEO',
						library : {
							type : 'video' // image, audio, video, application/pdf, ... etc
						},
						// mutiple: true if you want to upload multiple files at once
						multiple: false
					}).open()
					.on('select', function(){
						// This will return the selected image from the Media Uploader, the result is an object
						var uploaded_video = video.state().get('selection').first().toJSON();
						// We convert uploaded_image to a JSON object to make accessing it easier
						// Output to the console uploaded_image
						console.log(uploaded_video);
						var video_url = uploaded_video.url;
						var video_id  = uploaded_video.id;
						// Let's assign the url value to the input field
						$('#video_second').val( video_url );
						$('#video_second_id').val( video_id );
					});
				});
				$('#video-upload-btn-third').click(function(e) {
					e.preventDefault();
					var video = wp.media({ 
						title: 'Upload new VIDEO',
						library : {
							type : 'video' // image, audio, video, application/pdf, ... etc
						},
						// mutiple: true if you want to upload multiple files at once
						multiple: false
					}).open()
					.on('select', function(){
						// This will return the selected image from the Media Uploader, the result is an object
						var uploaded_video = video.state().get('selection').first().toJSON();
						// We convert uploaded_image to a JSON object to make accessing it easier
						// Output to the console uploaded_image
						console.log(uploaded_video);
						var video_url = uploaded_video.url;
						var video_id  = uploaded_video.id;
						// Let's assign the url value to the input field
						$('#video_third').val( video_url );
						$('#video_third_id').val( video_id );
					});
				});
				$('#video-upload-btn-fourth').click(function(e) {
					e.preventDefault();
					var video = wp.media({ 
						title: 'Upload new VIDEO',
						library : {
							type : 'video' // image, audio, video, application/pdf, ... etc
						},
						// mutiple: true if you want to upload multiple files at once
						multiple: false
					}).open()
					.on('select', function(){
						// This will return the selected image from the Media Uploader, the result is an object
						var uploaded_video = video.state().get('selection').first().toJSON();
						// We convert uploaded_image to a JSON object to make accessing it easier
						// Output to the console uploaded_image
						console.log(uploaded_video);
						var video_url = uploaded_video.url;
						var video_id  = uploaded_video.id;
						// Let's assign the url value to the input field
						$('#video_fourth').val( video_url );
						$('#video_fourth_id').val( video_id );
					});
				});
			});
		</script>
		<div class="equipeer_clear"></div>
		<?php
	}
	
    /**
     * Save the meta when the post is saved.
     *
     * @param int $post_id The ID of the post being saved.
     */
	function videos_save( $post_id ) {
		// If this is an autosave, our form has not been submitted, so we don't want to do anything
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
		// Check if our nonce is set AND if that the nonce is valid
		if ( ! isset( $_POST['videos_nonce'] ) || ! wp_verify_nonce( $_POST['videos_nonce'], '_videos_nonce' ) ) return;
		// Check the user's permissions
		if ( ! current_user_can( 'equipeer_edit_equine', $post_id ) ) return;
		// ---------------------------------------------
		// Update the meta field
		// ---------------------------------------------
		if ( isset( $_POST['video_main'] ) )
			update_post_meta( $post_id, 'video_main', esc_attr($_POST['video_main']) );
		// ---------------------------------------------
		if ( isset( $_POST['video_main_id'] ) )
			update_post_meta( $post_id, 'video_main_id', esc_attr($_POST['video_main_id']) );
		// ---------------------------------------------
		if ( isset( $_POST['video_second'] ) )
			update_post_meta( $post_id, 'video_second', esc_attr($_POST['video_second']) );		
		// ---------------------------------------------
		if ( isset( $_POST['video_second_id'] ) )
			update_post_meta( $post_id, 'video_second_id', esc_attr( $_POST['video_second_id'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['video_third'] ) )
			update_post_meta( $post_id, 'video_third', esc_attr( $_POST['video_third'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['video_third_id'] ) )
			update_post_meta( $post_id, 'video_third_id', esc_attr( $_POST['video_third_id'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['video_fourth'] ) )
			update_post_meta( $post_id, 'video_fourth', esc_attr( $_POST['video_fourth'] ) );
		// ---------------------------------------------
		if ( isset( $_POST['video_fourth_id'] ) )
			update_post_meta( $post_id, 'video_fourth_id', esc_attr( $_POST['video_fourth_id'] ) );
		// ---------------------------------------------
	}
	
}