<?php
// Informations vendeur
global $user_time_putad, $smartwizard_required_field, $smartwizard_step3_text2, $smartwizard_step3_text3, $smartwizard_step3_text4;
// -----------------------------------
$photo_allowed_max    = 20000*1024;  // 20 Mo
$video_allowed_max    = 100000*1024; // 100 Mo
$document_allowed_max = 10000*1024;  // 10 Mo
// -----------------------------------
?>

<style>
	.imageupload .btn-file {
	  overflow: hidden;
	  position: relative;
	}
	.imageupload .btn-file input[type="file"] {
	  cursor: inherit;
	  display: block;
	  font-size: 100px;
	  min-height: 100%;
	  min-width: 100%;
	  opacity: 0;
	  position: absolute;
	  right: 0;
	  text-align: right;
	  top: 0;
	}
	.medias-preview-blk {
		background-color: #eeeeee;
	}
	.media-preview {
		object-fit: cover;
		width: 100%;
		height: 200px;
	}
	.equipeer_media_infos {
		color: grey;
		font-size: 0.77em;
		font-style: italic;
	}
	.equipeer-media-card {
		width: 252px;
		/*margin: 0 auto;*/
	}
	.equipeer-media-card-required {
		border: 1px solid red;
	}
	.equipeer-media-card-photo {
		min-height: 25em;
	}
	.equipeer-media-card-video {
		min-height: 29em;
	}
	.equipeer-media-card-document {
		min-height: 25em;
	}
</style>

<h2 class="mt-0"><?php _e('Photos, videos and document of the horse', EQUIPEER_ID); ?></h2>
<div class="row">
	<div class="col col-mob-100">
		<div class="form-group" style="font-weight: normal;">
			<?php echo nl2br($smartwizard_step3_text2); ?>
		</div>
	</div>
</div>
<!-- =========================== -->
<!-- ====== PHOTOS UPLOAD ====== -->
<!-- =========================== -->
<div class="row">
	<?php for($photo_id = 1; $photo_id < 5; ++$photo_id) { ?>
		<div class="col-lg-3 col-md-6 mb-3 col-mob-100">
			<div class="card equipeer-media-card equipeer-media-card-photo<?php if ($photo_id == 1) echo ' equipeer-media-card-required'; ?>">
				<div id="preview-<?php echo $photo_id; ?>" class="medias-preview-blk">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/photo-thumbnail-default.jpg" class="card-img-top media-preview" id="photo-preview-<?php echo $photo_id; ?>" alt="">
				</div>
			  
				<div class="card-body">
					<form id="upload-medias-<?php echo $photo_id; ?>" class="upload-form" method="post">
						<div class="row">
							<div class="form-group col-md-6 text-left">
							  
								<div class="file-tab panel-body">
									<label id="upl_add_<?php echo $photo_id; ?>" class="btn btn-primary btn-file d-block">
										<?php _e('Add', EQUIPEER_ID); ?>
										<!-- The file is stored here. -->
										<input accept="image/png,image/jpeg" type="file" id="upl_photo_<?php echo $photo_id; ?>" name="upl_photo_<?php echo $photo_id; ?>" data-media="<?php echo $photo_id; ?>" data-type="photo" onchange="document.getElementById('photo-preview-<?php echo $photo_id; ?>').src = window.URL.createObjectURL(this.files[0]);" class="d-none">
									</label>
								</div>
								<span id="chk-error"></span>
							</div>
							<div class="form-group col-md-6 text-right">
								<!--<button type="submit" class="btn btn-primary float-left" id="upload-file-<?php echo $photo_id; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>-->
								<!--&nbsp;&nbsp;-->
								<button id="upl_delete_<?php echo $photo_id; ?>" type="button" class="btn btn-danger d-none" onclick="equipeer_upload_delete('<?php echo $photo_id; ?>', 'photo', '<?php echo get_current_user_id(); ?>', '<?php echo $user_time_putad; ?>');"><?php _e('Remove', EQUIPEER_ID); ?></button>
							</div>
						</div>
						<div class="row text-center">
							<div class="col mt-0 mb-0 equipeer_media_infos" id="upl_media_infos_<?php echo $photo_id; ?>"></div>
						</div>
						<input type="hidden" name="mediaAction" value="upload">
						<input type="hidden" name="mediaType" value="photo">
						<input type="hidden" name="mediaNum" value="<?php echo $photo_id; ?>">
						<input type="hidden" name="mediaPath" value="<?php echo get_current_user_id(); ?>">
						<input type="hidden" name="mediaTime" value="<?php echo $user_time_putad; ?>">
						<input type="hidden" name="siteUrl" value="<?php echo get_site_url(); ?>">
					</form>
					<div class="row align-items-center">
					  <div class="col">
						<div class="progress">
						  <div id="file-progress-bar-<?php echo $photo_id; ?>" class="progress-bar"></div>
					   </div>
					 </div>
					</div>
					<div class="row">  
						<div class="col">
						  <div id="uploaded-file-<?php echo $photo_id; ?>" class="text-center" style="font-size: 0.9em;"></div>
						</div>
					</div>
				</div>
			</div>
			<script>
				jQuery('#upl_photo_<?php echo $photo_id; ?>').on('change', function() {
					equipeer_media_change( this );
				});
			</script>
		</div>
	<?php } ?>
</div>

<div class="row mt-5">
	<div class="col col-mob-100">
		<div class="form-group" style="font-weight: normal;">
			<?php echo nl2br($smartwizard_step3_text3); ?>
		</div>
	</div>
</div>
<!-- =========================== -->
<!-- ====== VIDEOS UPLOAD ====== -->
<!-- =========================== -->
<div class="row">
	<?php for($video_id = 5; $video_id < 9; ++$video_id) { ?>
		<div class="col-lg-3 col-md-6 mb-3">
			<div class="card equipeer-media-card equipeer-media-card-video<?php if ($video_id == 5) echo ' equipeer-media-card-required'; ?>">
				<div id="preview-<?php echo $video_id; ?>" class="medias-preview-blk">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/video-thumbnail-default.jpg" class="card-img-top media-preview" id="photo-preview-<?php echo $video_id; ?>" alt="">
				</div>
			  
				<div class="card-body">
					<form id="upload-medias-<?php echo $video_id; ?>" class="upload-form" method="post">
						<div class="row">
							<div class="form-group col-md-6 text-left">
							  
								<div class="file-tab panel-body">
									<label id="upl_add_<?php echo $video_id; ?>" class="btn btn-primary btn-file d-block">
										<?php _e('Add', EQUIPEER_ID); ?>
										<!-- The file is stored here. -->
										<input accept="video/*" type="file" id="upl_video_<?php echo $video_id; ?>" name="upl_video_<?php echo $video_id; ?>" data-media="<?php echo $video_id; ?>" data-type="video" class="d-none">
									</label>
								</div>
								<span id="chk-error"></span>
							</div>
							<div class="form-group col-md-6 text-right">
								<!--<button type="submit" class="btn btn-primary float-left" id="upload-file-<?php echo $video_id; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>-->
								<!--&nbsp;&nbsp;-->
								<button id="upl_delete_<?php echo $video_id; ?>" type="button" class="btn btn-danger d-none" onclick="equipeer_upload_delete('<?php echo $video_id; ?>', 'video', '<?php echo get_current_user_id(); ?>', '<?php echo $user_time_putad; ?>');"><?php _e('Remove', EQUIPEER_ID); ?></button>
							</div>
						</div>
						<div class="row">
							<div class="col text-center">
								— <?php _e('OR', EQUIPEER_ID); ?> —
							</div>
						</div>
						<div class="row">
							<div class="col">
								<input class="form-control" type="text" id="upl_video_link_<?php echo $video_id; ?>" name="upl_video_link_<?php echo $video_id; ?>" value="" placeholder="<?php _e('Youtube or Vimeo link', EQUIPEER_ID); ?>">
							</div>
						</div>
						<div class="row text-center">
							<div class="col mt-0 mb-0 equipeer_media_infos" id="upl_media_infos_<?php echo $video_id; ?>"></div>
						</div>
						<input type="hidden" name="mediaAction" value="upload">
						<input type="hidden" name="mediaType" value="video">
						<input type="hidden" name="mediaNum" value="<?php echo $video_id; ?>">
						<input type="hidden" name="mediaPath" value="<?php echo get_current_user_id(); ?>">
						<input type="hidden" name="mediaTime" value="<?php echo $user_time_putad; ?>">
						<input type="hidden" name="siteUrl" value="<?php echo get_site_url(); ?>">
					</form>
					<div class="row align-items-center">
					  <div class="col">
						<div class="progress">
						  <div id="file-progress-bar-<?php echo $video_id; ?>" class="progress-bar"></div>
					   </div>
					 </div>
					</div>
					<div class="row">  
						<div class="col">
						  <div id="uploaded-file-<?php echo $video_id; ?>" class="text-center" style="font-size: 0.9em;"></div>
						</div>
					</div>
				</div>
			</div>
			<script>
				jQuery('#upl_video_<?php echo $video_id; ?>').on('change', function() {
					equipeer_media_change( this );
				});
			</script>
		</div>
	<?php } ?>
</div>

<div class="row mt-5">
	<div class="col col-mob-100">
		<div class="form-group" style="font-weight: normal;">
			<?php echo nl2br($smartwizard_step3_text4); ?>
		</div>
	</div>
</div>
<!-- ============================== -->
<!-- ====== DOCUMENTS UPLOAD ====== -->
<!-- ============================== -->
<div class="row">
	<?php for($document_id = 9; $document_id < 10; ++$document_id) { ?>
		<div class="col-lg-3 col-md-6 mb-3">
			<div class="card equipeer-media-card equipeer-media-card-document">
				<div id="preview-<?php echo $document_id; ?>" class="medias-preview-blk">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/document-thumbnail-default.jpg" class="card-img-top media-preview" id="photo-preview-<?php echo $document_id; ?>" alt="">
				</div>
			  
				<div class="card-body">
					<form id="upload-medias-<?php echo $document_id; ?>" class="upload-form" method="post">
						<div class="row">
							<div class="form-group col-md-6 text-left">
							  
								<div class="file-tab panel-body">
									<label id="upl_add_<?php echo $document_id; ?>" class="btn btn-primary btn-file d-block">
										<?php _e('Add', EQUIPEER_ID); ?>
										<!-- The file is stored here. -->
										<input accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.oasis.opendocument.text" type="file" id="upl_document_<?php echo $document_id; ?>" name="upl_document_<?php echo $document_id; ?>" data-media="<?php echo $document_id; ?>" data-type="document" class="d-none">
									</label>
								</div>
								<span id="chk-error"></span>
							</div>
							<div class="form-group col-md-6 text-right">
								<!--<button type="submit" class="btn btn-primary float-left" id="upload-file-<?php echo $document_id; ?>"><i class="fa fa-upload" aria-hidden="true"></i> Upload</button>-->
								<!--&nbsp;&nbsp;-->
								<button id="upl_delete_<?php echo $document_id; ?>" type="button" class="btn btn-danger d-none" onclick="equipeer_upload_delete('<?php echo $document_id; ?>', 'document', '<?php echo get_current_user_id(); ?>', '<?php echo $user_time_putad; ?>');"><?php _e('Remove', EQUIPEER_ID); ?></button>
							</div>
						</div>
						<div class="row text-center">
							<div class="col mt-0 mb-0 equipeer_media_infos" id="upl_media_infos_<?php echo $document_id; ?>"></div>
						</div>
						<input type="hidden" name="mediaAction" value="upload">
						<input type="hidden" name="mediaType" value="document">
						<input type="hidden" name="mediaNum" value="<?php echo $document_id; ?>">
						<input type="hidden" name="mediaPath" value="<?php echo get_current_user_id(); ?>">
						<input type="hidden" name="mediaTime" value="<?php echo $user_time_putad; ?>">
						<input type="hidden" name="siteUrl" value="<?php echo get_site_url(); ?>">
					</form>
					<div class="row align-items-center">
					  <div class="col">
						<div class="progress">
						  <div id="file-progress-bar-<?php echo $document_id; ?>" class="progress-bar"></div>
					   </div>
					 </div>
					</div>
					<div class="row">  
						<div class="col">
						  <div id="uploaded-file-<?php echo $document_id; ?>" class="text-center" style="font-size: 0.9em;"></div>
						</div>
					</div>
				</div>
			</div>
			<script>
				jQuery('#upl_document_<?php echo $document_id; ?>').on('change', function() {
					equipeer_media_change( this );
				});
			</script>
		</div>
	<?php } ?>
	<div class="col col-mob-100">
		<div class="form-group">
			<label for="putadVeterinaireDate"><?php echo __('Date of last veterinary visit', EQUIPEER_ID) . $smartwizard_required_field; ?></label>
			<input type="text" class="form-control putad_datepicker_step3 simple-tooltip" id="putadVeterinaireDate" name="putadVeterinaireDate" value="<?php echo $putadVeterinaireDate; ?>" aria-describedby="putadVeterinaireDateHelp" style="pointer-events: none !important; cursor: default;" placeholder="<?php _e('click on the icon', EQUIPEER_ID); ?>" required>
			<small id="putadVeterinaireDateHelp" class="form-text text-muted"><?php echo 'Format (' . __('YYYY-MM-DD', EQUIPEER_ID) . ')'; ?></small>
		</div>
	</div>
</div>
<div class="row">
	<div class="col col-mob-100">
		<small class="description d-block" style="color: #444 !important;"><?php echo sprintf( __('%s required fields', EQUIPEER_ID), '<span style="color: red;">*</span>' ); ?></small>
	</div>
</div>
<div style="height: 50px;">&nbsp;</div>

<script>
	// --------------------------------------
	// Datepicker (Date of birth)
	// --------------------------------------
	jQuery( ".putad_datepicker_step3" ).datepicker({
		dateFormat: 'yy-mm-dd',
		closeText: 'Fermer',
		prevText: 'Précédent',
		nextText: 'Suivant',
		currentText: 'Aujourd\'hui',
		monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
		monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
		dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
		dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
		dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
		weekHeader: 'Sem.',
		changeMonth: true,
		changeYear: true,
		showOn: "button",
		buttonImage: "<?php echo EQUIPEER_URL; ?>assets/images/icon-calendar.png",
		buttonImageOnly: true,
		buttonText: "Select date",
		onSelect: function( dat ) {
			// ----------------------------------
			// Get new date (Extract YEAR only)
			// ----------------------------------
			jQuery('#putadVeterinaireDate').val( dat ); // Complete date
			// ----------------------------------
		}
	});
	// ------------------------------------------
	// ------- Check File type validation -------
	// ------------------------------------------
	function equipeer_media_change( uplmed ) {
		// ------------------------------------------
		// Datas
		// ------------------------------------------
		var dataMedia = uplmed.getAttribute("data-media"); // 1 | 2 | 3 | 4
		var dataType  = uplmed.getAttribute("data-type");  // photo | video | document
		// ------------------------------------------
		// Allowed Types
		// ------------------------------------------
		var allowedTypes     = [];
		var allowedTypesText = [];
		switch(dataType) {
			default: case "photo":
				allowedTypes     = ['image/jpeg', 'image/png', 'image/jpg'];
				allowedTypesText = 'JPEG/JPG/PNG/GIF';
			break;
			case "video":
				// ----------- AVI -----------
				// application/x-troff-msvideo
				// video/avi
				// video/msvideo
				// video/x-msvideo
				// ----------- MP4 -----------
				// video/mp4
				// application/mp4
				// ----------- MOV -----------
				// video/quicktime
				// video/x-quicktime
				// image/mov
				// audio/aiff
				// audio/x-midi
				// audio/x-wav
				// video/avi
				// ----------- OGG -----------
				// audio/ogg
				// video/ogg
				// ----------- WMV -----------
				// video/x-ms-wmv
				// video/x-ms-asf
				// ----------- WEBM ----------
				// video/webm
				// audio/webm
				//allowedTypes     = ['video/x-msvideo', 'video/mpeg', 'video/ogg', 'video/webm', 'video/3gpp', 'video/3gpp2', 'video/mp4', 'application/x-mpegURL', 'video/MP2T', 'video/quicktime', 'video/x-ms-wmv'];
				//allowedTypesText = 'AVI/MPEG/OGG/WEBM/MOV/WMV';
				allowedTypes     = ['video/mp4', 'application/mp4', 'video/quicktime'];
				allowedTypesText = 'MP4';
			break;
			case "document":
				allowedTypes     = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.oasis.opendocument.text'];
				allowedTypesText = 'PDF/DOC/DOCX/ODT';
			break;
		}
		// ------------------------------------------
		// Initialize
		// ------------------------------------------
		var file = uplmed.files[0];
		// ------------------------------------------
		// Check Types
		// ------------------------------------------
		if ( !allowedTypes.includes(file.type) ) {
			Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('Please choose a valid file', EQUIPEER_ID); ?> "+allowedTypesText+"<br><?php _e('Type of your video: ', EQUIPEER_ID); ?>"+file.type, "error" );
			jQuery( "#upl_" + dataType + "_" + dataMedia ).val('');
			return false;
		}
		// ------------------------------------------ 
		// Image initialization
		// ------------------------------------------
		var img = new Image();
		// ------------------------------------------
		// Image onload
		// ------------------------------------------
		img.onload = function() {
			var sizes = {
				width:  this.width,
				height: this.height
			};
			URL.revokeObjectURL(this.src);
			//$('#upl_media_infos_1').text('Type: ' + file.type + ' - Name: ' + file.name + ' - ' + file.size + 'Ko - ' + sizes.width + ' x ' + sizes.height);
		};
		var objectURL = URL.createObjectURL(file);		
		img.src = objectURL;
		// ------------------------------------------
		// Get infos
		// ------------------------------------------
		jQuery( "#upl_media_infos_" + dataMedia ).html( truncate(file.type, 25, '..') + ' (' + humanFileSize(file.size, true) + ')');
		// ------------------------------------------
		// Upload media
		// ------------------------------------------
		var allowedSize = 0;
		switch(dataType) {
			case "photo": allowedSize = <?php echo $photo_allowed_max; ?>; break;
			case "video": allowedSize = <?php echo $video_allowed_max; ?>; break;
			case "document": allowedSize = <?php echo $document_allowed_max; ?>; break;
		}
		if (file.size > allowedSize) {
			// Error Size
			if (dataType == 'photo') {
				jQuery('#photo-preview-'+dataMedia).attr('src', '<?php echo get_stylesheet_directory_uri(); ?>/assets/images/photo-thumbnail-default.jpg');
				jQuery( "#upl_media_infos_" + dataMedia ).empty();
			}
			Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e("File is too large", EQUIPEER_ID); ?>", "error" );
			return false;
		} else {
			equipeer_upload_medias( dataMedia );
		}
		// ------------------------------------------
	}
	
	// ------------------------------------------
	// ---------- Delete button event -----------
	// ------------------------------------------
	function equipeer_upload_delete( num, type, dpath, dtime ) {
		if (!num) return;
		// Delete file
		request = jQuery.ajax({
			method: 'POST',
			url: '<?php echo EQUIPEER_URL; ?>includes/upload.php',
			data: {
				'mediaAction': 'delete',
				'mediaType': type,
				'mediaNum': num,
				'mediaPath': dpath,
				'mediaTime': dtime
			},
			dataType: 'json'
		});
		request.done(function( json ) {
			switch(json) {
				default:
					//Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('Error Unknown', EQUIPEER_ID); ?>", "error" );
					Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", json, "error" );
				break;
				case "success":
					// Initialize
					jQuery('#photo-preview-'+num).attr('src', '<?php echo get_stylesheet_directory_uri(); ?>/assets/images/'+type+'-thumbnail-default.jpg');
					// Clear progress bar
					jQuery( "#file-progress-bar-"+num ).width( '0%' );
					jQuery( "#file-progress-bar-"+num ).html( '' );
					// Clear message upload + infos upload
					jQuery( '#uploaded-file-'+num ).html('');
					jQuery( '#upl_media_infos_'+num ).html('');
					// Hide button Delete Photo + Display Add Photo
					jQuery('#upl_delete_'+num).removeClass('d-block').addClass('d-none');
					jQuery('#upl_add_'+num).removeClass('d-none').addClass('d-block');
				break;
				case "failed":
					jQuery( '#uploaded-file-'+num ).html('<p style="color:#EA4335;">Error TMP Directory (write).</p>'); // Error writing in TMP Directory
					//Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('Error TMP Directory', EQUIPEER_ID); ?>", "error" );
				break;
			}
		});
		 
		request.fail(function( jqXHR, textStatus, thrownError ) {
		   console.log(thrownError + "\r\n" + textStatus);
		});
	}
	
	// ------------------------------------------
	// --------- Upload MEDIAS function ---------
	// ------------------------------------------
	function equipeer_upload_medias( num ) {
		if (!num) return;
		// Initialize
		var uploadForm = document.getElementById( 'upload-medias-'+num );
		formData = new FormData(uploadForm);
		// Disable Add button
		jQuery('#upl_add_'+num).removeClass('d-block').addClass('d-none');
		// Ajax request
		jQuery.ajax({
			xhr: function() {
				var xhr = new window.XMLHttpRequest();         
				xhr.upload.addEventListener( "progress", function(element) {
					if (element.lengthComputable) {
						var percentComplete = ((element.loaded / element.total) * 100);
						jQuery( "#file-progress-bar-"+num ).width( parseInt( percentComplete ) + '%' );
						jQuery( "#file-progress-bar-"+num ).html( parseInt( percentComplete ) + '%' );
					}
				}, false);
				return xhr;
			},
			type: 'POST',
			url: '<?php echo EQUIPEER_URL; ?>includes/upload.php',
			data: formData,
			contentType: false,
			cache: false,
			processData: false,
			dataType: 'json',

			beforeSend: function(){
				jQuery( "#file-progress-bar-"+num ).width( '0%' );
			},

			success: function(json) {
				if (json == 'success') {
					// --- Success
					jQuery( '#upload-medias-'+num )[0].reset();
					jQuery( '#uploaded-file-'+num ).html('<p style="color:#28A74B;"><?php _e('File has uploaded successfully!', EQUIPEER_ID); ?></p>');
					// -- Display button Delete Photo + hide Add Photo
					jQuery('#upl_delete_'+num).removeClass('d-none').addClass('d-block');
					jQuery('#upl_add_'+num).removeClass('d-block').addClass('d-none');
				} else if (json == 'failed') {
					// --- Failed
					jQuery( '#uploaded-file-'+num ).html('<p style="color:#EA4335;"><?php _e('Error TMP Directory', EQUIPEER_ID); ?></p>');
				} else if (json == 'notallowed') {
					// --- Extension not allowed
					Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('File extension not allowed', EQUIPEER_ID); ?>", "error" );
				} else if (json == 'emptyfile') {
					// --- Empty file
					Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('Empty file', EQUIPEER_ID); ?>", "error" );
				} else if (json == 'filetoolarge') {
					// --- File too large
					Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('File is too large', EQUIPEER_ID); ?>", "error" );
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
			  console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});
	}
	
	function humanFileSize(bytes, si=false, dp=1) {
		const thresh = si ? 1000 : 1024;
	  
		if (Math.abs(bytes) < thresh) {
			return bytes + ' B';
		}
	  
		const units = si 
		  ? ['kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'] 
		  : ['KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
		let u = -1;
		const r = 10**dp;
	  
		do {
			bytes /= thresh;
			++u;
		} while (Math.round(Math.abs(bytes) * r) / r >= thresh && u < units.length - 1);
	  
	  
		return bytes.toFixed(dp) + ' ' + units[u];
	}
</script> 