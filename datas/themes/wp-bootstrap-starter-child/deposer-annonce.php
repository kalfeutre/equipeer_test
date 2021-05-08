<?php
/**
* Template Name: Déposer une annonce
*/

get_header();

// ---------------------------------------
// --- BREADCRUMB
// ---------------------------------------
get_template_part( 'template-parts/breadcrumb' );

?>

<section id="primary" class="content-area col-sm-12">
	<main id="main" class="site-main" role="main">

		<div class="container mt-2">
			<div class="row">
				<div class="col col-pad-0">
					<?php if (!is_user_logged_in()) { ?>
							<h2><?php _e('Hello !', EQUIPEER_ID); ?></h2>
							<div class="mb-3">
								<?php _e('To place an ad, sign in or create your account', EQUIPEER_ID); ?>
							</div>
							<a class="eq-button eq-button-red" href="<?php echo get_site_url(); ?>/login/?redirect_to=<?php echo urlencode(get_site_url() . '/deposez-votre-annonce/'); ?>"><?php _e( 'Sign in', EQUIPEER_ID ); ?></a>
							&nbsp;&nbsp;&nbsp;&nbsp;
							<a class="eq-button eq-button-blue" href="<?php echo get_site_url(); ?>/register/"><?php _e( 'Sign up', EQUIPEER_ID ); ?></a>
					<?php } else { ?>
					
					<?php
							// -------------------------------
							// Initialization
							// -------------------------------
							$lang = (ICL_LANGUAGE_CODE == 'fr') ? ICL_LANGUAGE_CODE : 'en';
							// --- Title
							$smartwizard_step1_title = get_option('equine_smartwizard_step1_title_'.$lang);
							$smartwizard_step2_title = get_option('equine_smartwizard_step2_title_'.$lang);
							$smartwizard_step3_title = get_option('equine_smartwizard_step3_title_'.$lang);
							$smartwizard_step4_title = get_option('equine_smartwizard_step4_title_'.$lang);
							// --- Texte
							$smartwizard_step1_text = get_option('equine_smartwizard_step1_text_'.$lang);
							$smartwizard_step2_text = get_option('equine_smartwizard_step2_text_'.$lang);
							$smartwizard_step3_text = get_option('equine_smartwizard_step3_text_'.$lang);
							$smartwizard_step4_text = get_option('equine_smartwizard_step4_text_'.$lang);
							// --- Texte STEP2 ---
							// --- Texte Expertise
							$smartwizard_step2_text2 = get_option('equine_smartwizard_step2_text2_'.$lang);
							// --- Texte Prix de vente
							$smartwizard_step2_text3 = get_option('equine_smartwizard_step2_text3_'.$lang);
							// --- Textes STEP3 ---
							$smartwizard_step3_text2 = get_option('equine_smartwizard_step3_text2_'.$lang);
							$smartwizard_step3_text3 = get_option('equine_smartwizard_step3_text3_'.$lang);
							$smartwizard_step3_text4 = get_option('equine_smartwizard_step3_text4_'.$lang);
							// --- Textes STEP4 ---
							$smartwizard_step4_text2 = get_option('equine_smartwizard_step4_text2_'.$lang);
							// --- Required field
							$smartwizard_required_field = ' <span style="color: red;">*</span>';
							// --- Define TMP Directory to upload MEDIAS
							$user_time_putad = date('YmdHis');
						?>
						<!-- CSS -->
						<link href="<?php echo get_stylesheet_directory_uri(); ?>/vendor/smartwizard/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />
						<style>
							/* --- Next - Prev --- */
							.sw-btn-prev, .sw-btn-next {
								background-color: #d1023e !important;
								border: 1px solid #d1023e !important;
								-o-transition:.5s;
								-ms-transition:.5s;
								-moz-transition:.5s;
								-webkit-transition:.5s;
								/* For the proper property */
								transition:.5s;
							}
							.sw-btn-prev:hover, .sw-btn-next:hover {
								background-color: white !important;
								border: 1px solid #d1023e !important;
								color: #d1023e !important;
							}
							/* --- Active step --- */
							.sw-theme-arrows > .nav .nav-link.active::after {
								border-left-color: #d1023e;
							}
							.sw-theme-arrows > .nav .nav-link.active {
								border-color: #d1023e;
								background: #d1023e;
								cursor: default;
							}
							/* --- Inactive step --- */
							.sw-theme-arrows > .nav .nav-link.done::after {
								border-left-color: #0e2d4c;
							}
							.sw-theme-arrows > .nav .nav-link.done {
								border-color: #0e2d4c;
								background: #0e2d4c;
								cursor: default;
							}
						</style>
						<!-- JavaScript -->
						<script src="<?php echo get_stylesheet_directory_uri(); ?>/vendor/smartwizard/js/jquery.smartWizard.min.js" type="text/javascript"></script>
						<!-- Custom style -->
						<style>
							.sw-theme-arrows {
								border: 0;
							}
							.sw-theme-arrows > .nav {
								border-bottom: 0;
							}
							.col-pad-0 {
								padding-left: 0;
								padding-right: 0;
							}
							.step-nod {
								display: none;
							}
						</style>
						<!-- Step Text -->
						<!--<div id="smartwizard-step-text" class="mb-4">
							<div id="step1-text" class="step-nod"><?php echo $smartwizard_step1_text; ?></div>
							<div id="step2-text" class="step-nod"><?php echo $smartwizard_step2_text; ?></div>
							<div id="step3-text" class="step-nod"><?php echo $smartwizard_step3_text; ?></div>
							<div id="step4-text" class="step-nod"><?php echo $smartwizard_step4_text; ?></div>
						</div>-->
						<!-- Wizard -->
						<div id="smartwizard">
							<ul class="nav">
							   <li>
								   <a class="nav-link" href="#step-1">
									  <?php echo $smartwizard_step1_title; ?>
								   </a>
							   </li>
							   <li>
								   <a class="nav-link" href="#step-2">
									  <?php echo $smartwizard_step2_title; ?>
								   </a>
							   </li>
							   <li>
								   <a class="nav-link" href="#step-3">
									  <?php echo $smartwizard_step3_title; ?>
								   </a>
							   </li>
							   <li>
								   <a class="nav-link" href="#step-4">
									  <?php echo $smartwizard_step4_title; ?>
								   </a>
							   </li>
							</ul>
						 
							<div class="tab-content">
								<div id="step-1" class="tab-pane" role="tabpanel">
									<div id="step1-text-md" class="mt-2 mb-4"><?php echo $smartwizard_step1_text; ?></div>
									<?php get_template_part( 'template-parts/putad-step1' ); ?>
								</div>
								<div id="step-2" class="tab-pane" role="tabpanel">
									<div id="step2-text-md" class="mt-2 mb-4"><?php echo $smartwizard_step2_text; ?></div>
									<?php get_template_part( 'template-parts/putad-step2' ); ?>
								</div>
								<div id="step-3" class="tab-pane" role="tabpanel">
									<div id="step3-text-md" class="mt-2 mb-4"><?php echo $smartwizard_step3_text; ?></div>
									<?php get_template_part( 'template-parts/putad-step3' ); ?>
								</div>
								<div id="step-4" class="tab-pane" role="tabpanel">
									<div id="step4-text-md" class="mt-2 mb-4"><?php echo $smartwizard_step4_text; ?></div>
									<?php get_template_part( 'template-parts/putad-step4' ); ?>
								</div>
							</div>
						</div>
						<script>
							jQuery(document).ready(function() {
								// Breadcrumb
								jQuery('.breadcrumb').append('<li class="breadcrumb-item"><?php echo the_title(); ?></li>');
								// SmartWizard initialize
								jQuery('#smartwizard').smartWizard({
									theme: 'arrows',  // default | arrows | dots | progress
									selected: 0, // Initial selected step, 0 = first step
									justified: true, // Nav menu justification. true/false
									darkMode: false, // Enable/disable Dark Mode if the theme supports. true/false
									autoAdjustHeight: true, // Automatically adjust content height
									cycleSteps: true, // Allows to cycle the navigation of steps
									backButtonSupport: true, // Enable the back button support
									enableURLhash: false, // Enable selection of the step based on url hash
									transition: {
										animation: 'fade', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
										speed: '400', // Transion animation speed
										easing: '' // Transition animation easing. Not supported without a jQuery easing plugin
									},
									toolbarSettings: {
										toolbarPosition: 'both', // none, top, bottom, both
										toolbarButtonPosition: 'right', // left, right, center
										showNextButton: true, // show/hide a Next button
										showPreviousButton: true, // show/hide a Previous button
										toolbarExtraButtons: [
											jQuery('<button></button>').text('<?php _e("Put your ad", EQUIPEER_ID); ?>')
											.addClass('btn sw-btn-next putad-finish')
											.on('click', function() {
												// Add OVERLAY
												jQuery('.eq-overlay-ajax').removeClass("d-none");
												// AJAX Request
												jQuery.ajax({
													url: equipeer_ajax.ajaxurl,
													type: "POST",
													data: {
														action : 'equipeer_putad', // wp_ajax_*, wp_ajax_nopriv_*
														// -----------------
														user_name: jQuery('#putadFirstnameH').val() + ' ' + jQuery('#putadLastnameH').val(),
														user_email: jQuery('#putadEmailH').val(),
														user_phone: jQuery('.iti__selected-dial-code').html() + jQuery('#putadPhone').val(),
														user_address : jQuery('#putadAddress').val(),
														user_zip: jQuery('#putadZip').val(),
														user_city: jQuery('#putadCity').val(),
														user_country: jQuery('#putadCountry').val(),
														user_contact_by_email: (jQuery('#putadContactByEmail').prop('checked')) ? '1' : '0',
														usercontact_by_phone: (jQuery('#putadContactByPhone').prop('checked')) ? '1' : '0',
														// -----------------
														horse_sire: jQuery('#putadSire').val(),
														horse_name: jQuery('#putadPostTitle').val(),
														horse_date_of_birth: jQuery('#putadBirthdayReal').val(),
														horse_birthday: jQuery('#putadBirthday').val(),
														horse_breed: jQuery('#putadBreed').val(),
														horse_color: jQuery('#putadColor').val(),
														horse_size: jQuery('#putadSize').val(),
														horse_size_cm: jQuery('#putadSizeCm').val(),
														horse_sex: jQuery('#putadSex').val(),
														horse_discipline: jQuery('#putadDiscipline').val(),
														horse_type: 'horse',
														horse_street_number: jQuery('#putadStep2StreetNumber').val(),
														horse_address: jQuery('#putadStep2Address').val(),
														horse_city: jQuery('#putadHorseCity').val(),
														horse_zip: jQuery('#putadHorseZip').val(),
														horse_country: jQuery('#putadHorseCountry').val(),
														horse_latitude: jQuery('#putadStep2Latitude').val(),
														horse_longitude: jQuery('#putadStep2Longitude').val(),
														horse_impression: jQuery('#putadImpression').val(),
														horse_type_ad: jQuery('input[name="putadTypeAnnonce"]:checked').val(),
														horse_price_real: jQuery('#putadPriceReal').val(),
														horse_taux_tva: (jQuery('#putadPriceTvaTaux').val() > 0) ? jQuery('#putadPriceTvaTaux').val() : '',
														horse_is_tva: jQuery('input[name="putadPriceTvaTauxChoice"]:checked').val(),
														horse_price_equipeer: jQuery('#putadPriceEquipeer').val(),
														horse_commission: parseInt(jQuery('#putadPriceEquipeer').val()) - parseInt(jQuery('#putadPriceWithTva').val()),
														// -----------------
														horse_user_time: <?php echo $user_time_putad; ?>,
														// -----------------
														horse_media_video_link_1: jQuery('#upl_video_link_5').val(),
														horse_media_video_link_2: jQuery('#upl_video_link_6').val(),
														horse_media_video_link_3: jQuery('#upl_video_link_7').val(),
														horse_media_video_link_4: jQuery('#upl_video_link_8').val(),
														// -----------------
														horse_date_veto: jQuery('#putadVeterinaireDate').val(),
													},
													dataType: "html",
													success: function (datas) {
														// Remove Overlay
														jQuery('.eq-overlay-ajax').addClass("d-none");
														// Request result
														var result = trim(datas);
														// Check result
														if (result == '1') {
															// Hide form buttons (prev - finish)
															jQuery('.sw-btn-prev, .putad-finish').addClass('d-none');
															// Alert Fire
															Swal.fire({
																allowOutsideClick: false,
																icon: 'success',
																title: "<?php _e("Well done", EQUIPEER_ID); ?>",
																text: "<?php _e("Your ad has been submitted. You will be notified when your ad is publishing very soon.", EQUIPEER_ID); ?>",
																confirmButtonColor: '#0e2d4c'
															});
															setTimeout(function() {
																window.location.href = '<?php echo get_site_url() . '/account/ads/' ; ?>';
															}, 2500);
														} else {
															// Error insert datas in DB
															Swal.fire( "Error saving!", "Please try again ("+result+")", "error" );
														}
													},
													error: function (xhr, ajaxOptions, thrownError) {
														// Remove Overlay
														jQuery('.eq-overlay-ajax').addClass("d-none");
														Swal.fire( "Error saving!", "Please try again " + thrownError, "error" );
													}
												});
											}),
										] // Extra buttons to show on toolbar, array of jQuery input/buttons elements
									},
									anchorSettings: {
										anchorClickable: false, // Enable/Disable anchor navigation
										enableAllAnchors: false, // Activates all anchors clickable all times
										markDoneStep: true, // Add done state on navigation
										markAllPreviousStepsAsDone: true, // When a step selected by url hash, all previous steps are marked done
										removeDoneStepOnNavigateBack: false, // While navigate back done step after active step will be cleared
										enableAnchorOnDoneStep: true // Enable/Disable the done steps navigation
									},
									keyboardSettings: {
										keyNavigation: false, // Enable/Disable keyboard navigation(left and right keys are used if enabled)
										keyLeft: [37], // Left key code
										keyRight: [39] // Right key code
									},
									lang: { // Language variables for button
										next: "<?php _e('Next', EQUIPEER_ID); ?>",
										previous: "<?php _e('Previous', EQUIPEER_ID); ?>"
									},
									disabledSteps: [], // Array Steps disabled
									errorSteps: [], // Highlight step with errors
									hiddenSteps: [] // Hidden steps
								});
							});
							// Initialize H1
							var step_h1 = jQuery('h1').text();
							// -------------------------------------
							// Initialize the stepContent event
							// -------------------------------------
							jQuery("#smartwizard").on("stepContent", function(e, anchorObject, stepIndex, stepDirection) {
								// Hide all Step text
								jQuery('#step1-text,#step2-text,#step3-text,#step4-text').addClass("step-nod");
								switch(stepIndex) {
									case 0: // Step 1
										// Change TITLE / TEXT
										jQuery('h1').text( step_h1 + " > <?php echo $smartwizard_step1_title; ?>");
										jQuery('#step1-text').removeClass("step-nod"); // Show step text
									break;
									case 1: // Step 2
										// Change TITLE / TEXT
										jQuery('h1').text( step_h1 + " > <?php echo $smartwizard_step2_title; ?>");
										jQuery('#step2-text').removeClass("step-nod"); // Show step text
									break;
									case 2: // Step 3
										// Change TITLE / TEXT
										jQuery('h1').text( step_h1 + " > <?php echo $smartwizard_step3_title; ?>");
										jQuery('#step3-text').removeClass("step-nod"); // Show step text
									break;
									case 3: // Step 4
										// Change TITLE / TEXT
										jQuery('h1').text( step_h1 + " > <?php echo $smartwizard_step4_title; ?>");
										jQuery('#step4-text').removeClass("step-nod"); // Show step text
									break;
								}
							   console.log("Content for step " + stepIndex);
							});
							// -------------------------------------
							// Event on show step
							// -------------------------------------
							jQuery("#smartwizard").on("showStep", function(e, anchorObject, stepIndex, stepDirection) {
								var debug_showstep = true;
								jQuery('.toolbar button.sw-btn-next').removeClass('d-none'); // Next button
								jQuery('.putad-finish').addClass('d-none');
								console.log('stepIndex: '+stepIndex);
								switch(stepIndex) {
									case 0:
										// --- Hide Prev button
										jQuery('.toolbar button.sw-btn-prev').addClass('d-none');
									break;
									case 1:
										// Scroll to Top (Bug Chrome uniquement)
										jQuery(window).scrollTop(300);
										// --- Show Prev button
										jQuery('.toolbar button.sw-btn-prev').removeClass('d-none');
									break;
									case 2:
										// Scroll to Top (Bug Chrome uniquement)
										jQuery(window).scrollTop(300);
									break;
									case 3: // Step 4
										// Scroll to Top (Bug Chrome uniquement)
										jQuery(window).scrollTop(300);
										// --- Hide Next button
										jQuery('.toolbar button.sw-btn-next').addClass('d-none');
										// --- Show Finish button
										jQuery('.putad-finish').removeClass('d-none');
										// ---------------------------
										// STEP 1
										// ---------------------------
										// Phone
										if (debug_showstep) console.log('phone result: '+jQuery('#putadPhone').val());
										jQuery('#result_putadPhone').html( jQuery('.iti__selected-dial-code').html() + jQuery('#putadPhone').val() );
										// Firstname
										if (debug_showstep) console.log('firstname result: '+jQuery('#putadFirstname').val());
										jQuery('#result_putadFirstname').html( jQuery('#putadFirstname').val() );
										// Lastname
										if (debug_showstep) console.log('lastname result: '+jQuery('#putadLastname').val());
										jQuery('#result_putadLastname').html( jQuery('#putadLastname').val() );
										// Email
										if (debug_showstep) console.log('email result: '+jQuery('#putadEmail').val());
										jQuery('#result_putadEmail').html( jQuery('#putadEmail').val() );
										// Address
										if (debug_showstep) console.log('address result: '+jQuery('#putadAddress').val() + ' ' + jQuery('#putadZip').val() + ' ' + jQuery('#putadCity').val() + ' - ' + jQuery('#putadCountry').val());
										//jQuery('#result_putadAddress').html( jQuery('#putadAddress').val() + ', ' + jQuery('#putadCity').val() + ' (' + jQuery('#putadZip').val() + ') - ' + jQuery('#putadCountry').val() );
										jQuery('#result_putadAddress').html( jQuery('#putadCity').val() + ' (' + jQuery('#putadZip').val() + ') - ' + jQuery('#putadCountry').val() );
										// Contact by
										var contact_by_email = (jQuery('#putadContactByEmail').prop('checked')) ? '<?php _e('Email', EQUIPEER_ID); ?> / ' : '';
										var contact_by_phone = (jQuery('#putadContactByPhone').prop('checked')) ? '<?php _e('Phone', EQUIPEER_ID); ?>' : '';
										var contact_by       = rtrim( contact_by_email + contact_by_phone, ' / ');
										if (debug_showstep) console.log('contact by result: '+contact_by);
										jQuery('#result_putadContactBy').html( contact_by );										
										// ---------------------------
										// STEP 2
										// ---------------------------
										// Identification
										if (debug_showstep) console.log('identification result: '+jQuery('#putadSire').val());
										jQuery('#result_putadSire').html( jQuery('#putadSire').val() );
										// Horse name
										if (debug_showstep) console.log('horse name result: '+jQuery('#putadPostTitle').val());
										jQuery('#result_putadPostTitle').html( jQuery('#putadPostTitle').val() );
										// Date of birth
										if (debug_showstep) console.log('date of birth result: '+jQuery('#putadBirthdayReal').val());
										jQuery('#result_putadBirthdayReal').html( jQuery('#putadBirthdayReal').val() );
										// Breed
										if (debug_showstep) console.log('breed result: '+jQuery('#putadBreed option:selected').text());
										jQuery('#result_putadBreed').html( jQuery('#putadBreed option:selected').text() );
										// Color
										if (debug_showstep) console.log('color result: '+jQuery('#putadColor option:selected').text());
										jQuery('#result_putadColor').html( jQuery('#putadColor option:selected').text() );
										// Size
										if (debug_showstep) console.log('size result: '+jQuery('#putadSize option:selected').text());
										jQuery('#result_putadSize').html( jQuery('#putadSize option:selected').text() );
										// Sex
										if (debug_showstep) console.log('sex result: '+jQuery('#putadSex option:selected').text());
										jQuery('#result_putadSex').html( jQuery('#putadSex option:selected').text() );
										// Discipline
										if (debug_showstep) console.log('discipline result: '+jQuery('#putadDiscipline option:selected').text());
										jQuery('#result_putadDiscipline').html( jQuery('#putadDiscipline option:selected').text() );
										// Equine type
										//if (debug_showstep) console.log('equine type result: '+jQuery('#putadTypeCanasson option:selected').text());
										//jQuery('#result_putadTypeCanasson').html( jQuery('#putadTypeCanasson option:selected').text() );
										//// Localization
										if (debug_showstep) console.log('identification result: ' + jQuery('#putadHorseCity').val() + ' (' + jQuery('#putadHorseZip').val() + ') - ' + jQuery('#putadHorseCountry').val());
										jQuery('#result_putadLocalization').html( jQuery('#putadHorseCity').val() + ' (' + jQuery('#putadHorseZip').val() + ') - ' + jQuery('#putadHorseCountry').val() );
										// Strong points
										if (debug_showstep) console.log('impression result: '+jQuery('#putadImpression').val());
										//jQuery('#result_putadImpression').html( nl2br(jQuery('#putadImpression').val()) );
										jQuery('#result_putadImpression').html( jQuery('#putadImpression').val() );
										// Ad type
										var free_ad      = jQuery('input[name="putadTypeAnnonce"]:checked').val();
										var free_ad_text = (free_ad == '1') ? "<?php _e('Basic', EQUIPEER_ID); ?>" : "<?php _e('Premium', EQUIPEER_ID); ?>";
										if (debug_showstep) console.log('ad type result: '+free_ad_text);
										jQuery('#result_putadTypeAnnonce').html( free_ad_text );
										// Net seller
										var format_price_net = formatThousands(jQuery('#putadPriceReal').val());
										format_price_net = format_price_net.replace(",", ".");
										if (debug_showstep) console.log('net seller result: '+format_price_net);
										jQuery('#result_putadPriceReal').html( format_price_net + '&euro;' );
										// VAT
										var the_tva      = jQuery('#putadPriceTvaTaux').val();
										var the_tva_text = (the_tva > 0) ? the_tva + "%" : "<?php _e('No VAT', EQUIPEER_ID); ?>"; 
										if (debug_showstep) console.log('vat result: '+the_tva_text);
										jQuery('#result_putadPriceTvaTaux').html( the_tva_text );
										// Equipeer price
										var format_price_equipeer = formatThousands(jQuery('#putadPriceEquipeer').val());
										format_price_equipeer = format_price_equipeer.replace(",", ".");
										if (debug_showstep) console.log('equipeer price result: '+format_price_equipeer);
										jQuery('#result_putadPriceEquipeer').html( format_price_equipeer + '&euro;' );
										// Price range
										if (debug_showstep) console.log('price range result: '+jQuery('#price-range').html());
										jQuery('#result_putadPriceRange').html( jQuery('#price-range').html() );
										// ---------------------------
										// STEP 3
										// ---------------------------
										// Photos
										var photos_number = 0;
										var photo_upload_1 = jQuery('#upl_media_infos_1').text();
										var photo_upload_2 = jQuery('#upl_media_infos_2').text();
										var photo_upload_3 = jQuery('#upl_media_infos_3').text();
										var photo_upload_4 = jQuery('#upl_media_infos_4').text();
										if (photo_upload_1) photos_number++;
										if (photo_upload_2) photos_number++;
										if (photo_upload_3) photos_number++;
										if (photo_upload_4) photos_number++;
										if (debug_showstep) console.log('photo uploaded number result: '+photos_number);
										jQuery('#result_putadUploadPhotos').html( photos_number );
										// Videos (Upload)
										var videos_number = 0;
										var video_upload_1 = jQuery('#upl_media_infos_5').text();
										var video_upload_2 = jQuery('#upl_media_infos_6').text();
										var video_upload_3 = jQuery('#upl_media_infos_7').text();
										var video_upload_4 = jQuery('#upl_media_infos_8').text();
										if (video_upload_1) videos_number++;
										if (video_upload_2) videos_number++;
										if (video_upload_3) videos_number++;
										if (video_upload_4) videos_number++;
										if (debug_showstep) console.log('video uploaded number result: '+videos_number);
										jQuery('#result_putadUploadVideos').html( videos_number );
										// Videos (Link)
										var videos_link_number = 0;
										var video_link_1 = jQuery('#upl_video_link_5').val();
										var video_link_2 = jQuery('#upl_video_link_6').val();
										var video_link_3 = jQuery('#upl_video_link_7').val();
										var video_link_4 = jQuery('#upl_video_link_8').val();
										if (video_link_1) videos_link_number++;
										if (video_link_2) videos_link_number++;
										if (video_link_3) videos_link_number++;
										if (video_link_4) videos_link_number++;
										if (debug_showstep) console.log('video links number result: '+videos_link_number);
										jQuery('#result_putadLinkVideos').html( videos_link_number );
										// Photos
										var document_number = 0;
										var document_upload_1 = jQuery('#upl_media_infos_9').text();
										if (document_upload_1) document_number++;
										jQuery('#result_putadUploadDocument').html( document_number );
										// Date veto
										jQuery('#result_putadVeterinaireDate').html( jQuery('#putadVeterinaireDate').val() );
									break;
								}
							});
							// -------------------------------------
							// Event before leaving Step
							// -------------------------------------
							jQuery("#smartwizard").on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
								switch(currentStepIndex) {
									case 0: // Step 1
										// -------------------------------------
										// --- Check if phone number is valid
										// -------------------------------------
										var phone_valid = jQuery('#putadPhone-error-msg').attr('class');
										if (phone_valid == '') {
											Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('Your phone number is not valid', EQUIPEER_ID); ?>", "error" );
											return false;
										}
										// -------------------------------------
										// --- Check if fields required are not empty
										// -------------------------------------
										var firstname = trim( jQuery("#putadFirstname").val() );
										var lastname  = trim( jQuery("#putadLastname").val() );
										var email     = trim( jQuery("#putadEmail").val() );
										var phone     = trim( jQuery("#putadPhone").val() );
										var address   = trim( jQuery("#putadAddress").val() );
										var zip       = trim( jQuery("#putadZip").val() );
										var city      = trim( jQuery("#putadCity").val() );
										var country   = trim( jQuery("#putadCountry").val() );
										console.log('zip: '+zip);
										//if (firstname == '' || lastname == '' || email == '' || phone == '' || address == '' || zip == '' || city == '' || country == '') {
										//if (firstname == '' || lastname == '' || email == '' || phone == '') {
										if (!firstname || !lastname || !email || !phone || !zip || !city || !country) {
											//var error_title = '<br><?php _e('Missing fields:', EQUIPEER_ID); ?><br>';
											var error_title = "<br>";
											var errors = "";
											if (!firstname) errors += "<?php _e('Firstname', EQUIPEER_ID); ?>";
											if (!lastname) errors += ", <?php _e('Lastname', EQUIPEER_ID); ?>";
											if (!email) errors += ", <?php _e('Email', EQUIPEER_ID); ?>";
											if (!phone) errors += ", <?php _e('Phone', EQUIPEER_ID); ?>";
											//if (address == '') errors += ", <?php _e('Address', EQUIPEER_ID); ?>";
											if (!zip) errors += ", <?php _e('Postal code', EQUIPEER_ID); ?>";
											if (!city) errors += ", <?php _e('City', EQUIPEER_ID); ?>";
											if (!country) errors += ", <?php _e('Country', EQUIPEER_ID); ?>";
											Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('Required fields are missing', EQUIPEER_ID); ?><br>" + error_title + ltrim(errors, ', '), "error" );
											return false;
										}
										// -------------------------------------
										var contactByEmail = (jQuery("#putadContactByEmail").is(':checked')) ? 1 : 0;
										var contactByPhone = (jQuery("#putadContactByPhone").is(':checked')) ? 1 : 0;
										if (contactByPhone == 0 && contactByEmail == 0) {
											Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('You must choose how to be contacted', EQUIPEER_ID); ?>", "error" );
											return false;
										}
										// -------------------------------------
									break;
									case 1: // Step 2
										// Check if click on Back button
										if (nextStepIndex > currentStepIndex) {
											// -------------------------------------
											// --- Check if fields required are not empty
											// -------------------------------------
											//var sire          = trim( jQuery("#putadSire").val() );
											var horse_name    = trim( jQuery("#putadPostTitle").val() );
											var date_of_birth = trim( jQuery("#putadBirthdayReal").val() );
											var breed         = trim( jQuery("#putadBreed").val() );
											var color         = trim( jQuery("#putadColor").val() );
											var size          = trim( jQuery("#putadSize").val() );
											var size_cm       = trim( jQuery("#putadSizeCm").val() );
											var sex           = trim( jQuery("#putadSex").val() );
											var discipline    = trim( jQuery("#putadDiscipline").val() );
											var type          = trim( jQuery("#putadTypeCanasson").val() );
											var horse_zip     = trim( jQuery("#putadHorseZip").val() );
											var horse_city    = trim( jQuery("#putadHorseCity").val() );
											var horse_country = trim( jQuery("#putadHorseCountry").val() );
											var horse_impress = trim( jQuery("#putadImpression").val() );
											//if (sire == '' || horse_name == '' || date_of_birth == '' || breed == '' || color == '' || size == '' || sex == '' || discipline == '' || type == '' || horse_zip == '' || horse_city == '' || horse_country == '' || horse_impress == '') {
											if (!horse_name || !date_of_birth || !breed || !color || !size || !size_cm || !sex || !discipline || !type || !horse_zip || !horse_city || !horse_country || !horse_impress) {
												//var error_horse_title = '<br><?php _e('Missing fields:', EQUIPEER_ID); ?><br>';
												var error_horse_title = "<br>";
												var errors_horse = "";
												//if (sire == '') errors_horse += "<?php _e('Identification number', EQUIPEER_ID); ?>";
												if (!horse_name) errors_horse += ", <?php _e('Horse name', EQUIPEER_ID); ?>";
												if (!date_of_birth) errors_horse += ", <?php _e('Date of birth', EQUIPEER_ID); ?>";
												if (!breed) errors_horse += ", <?php _e('Breed', EQUIPEER_ID); ?>";
												if (!color) errors_horse += ", <?php _e('Color', EQUIPEER_ID); ?>";
												if (!size) errors_horse += ", <?php _e('Size', EQUIPEER_ID); ?>";
												if (!size_cm) errors_horse += ", <?php _e('Size', EQUIPEER_ID) . ' (cm)'; ?>";
												if (!sex) errors_horse += ", <?php _e('Sex', EQUIPEER_ID); ?>";
												if (!discipline) errors_horse += ", <?php _e('Category', EQUIPEER_ID); ?>";
												if (!type) errors_horse += ", <?php _e('Ad type', EQUIPEER_ID); ?>";
												if (!horse_zip) errors_horse += ", <?php _e('Localization - Postal code', EQUIPEER_ID); ?>";
												if (!horse_city) errors_horse += ", <?php _e('Localization - City', EQUIPEER_ID); ?>";
												if (!horse_country) errors_horse += ", <?php _e('Localization - Country', EQUIPEER_ID); ?>";
												if (!horse_impress) errors_horse += ", <?php _e('Strong points', EQUIPEER_ID); ?>";
												Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('Required fields are missing', EQUIPEER_ID); ?><br>" + error_horse_title + ltrim(errors_horse, ', '), "error" );
												return false;
											}
											// -------------------------------------
											var latitude  = jQuery("#putadStep2Latitude").val();
											var longitude = jQuery("#putadStep2Longitude").val();
											if (!latitude || !longitude) {
												//var error_lat_lng_title = '<br><?php _e('Missing fields:', EQUIPEER_ID); ?><br>';
												var error_lat_lng_title = "<br>";
												var errors_lat_lng = "";
												if (!latitude) errors_lat_lng += ', Latitude';
												if (!longitude) errors_lat_lng += ', Longitude';
												Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('You must indicate your address in the field<br>Fill in address', EQUIPEER_ID); ?><br>" + error_lat_lng_title + ltrim(errors_lat_lng, ', '), "error" );
												return false;
											}
											// -------------------------------------
											var type_annonce = jQuery('input[name="putadTypeAnnonce"]:checked').val();
											if (!type_annonce) {
												Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('You must choose how your ad will be manage', EQUIPEER_ID); ?>", "error" );
												return false;
											}
											// -------------------------------------
											var prix_net = jQuery("#putadPriceReal").val();
											if (parseInt(prix_net) < 5000) {
												Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('The minimum price is 5,000 Euros', EQUIPEER_ID); ?>", "error" );
												return false;
											}
											// -------------------------------------
											var is_tva = jQuery('input[name="putadPriceTvaTauxChoice"]:checked').val();
											if (!prix_net || !is_tva) {
												//var error_price_title = '<br><?php _e('Missing fields:', EQUIPEER_ID); ?><br>';
												var error_price_title = "<br>";
												var errors_price = "";
												if (prix_net == '') errors_price += ", <?php _e('NET seller selling price in Euro', EQUIPEER_ID); ?>";
												if (!is_tva) errors_price += ", <?php _e('subject to VAT', EQUIPEER_ID); ?>";
												Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('Required fields are missing', EQUIPEER_ID); ?><br>" + error_price_title + ltrim(errors_price, ', '), "error" );
												return false;
											}
											// -------------------------------------
											var taux_tva = jQuery('#putadPriceTvaTaux').val();
											if (is_tva == '1' && !taux_tva) {
												Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('You must indicate VAT rate', EQUIPEER_ID); ?>", "error" );
												return false;
											}
											// -------------------------------------
										}
									break;
									case 2: // Step 3
										// Check if click on Back button
										if (nextStepIndex > currentStepIndex) {
											// Check if Media 1 (Photo) is uploaded
											var media_photo_1      = trim(jQuery('#upl_media_infos_1').text());
											var media_progress_1   = rtrim( jQuery('#file-progress-bar-1').text(), "%" );
											var media_video_1      = trim(jQuery('#upl_media_infos_5').text());
											var media_video_link_1 = trim(jQuery('#upl_video_link_5').val());
											var media_progress_5   = rtrim( jQuery('#file-progress-bar-5').text(), "%" );
											// Check if Media 1 (Photo) is uploaded
											if ( !media_photo_1 || parseInt(media_progress_1) < 100 ) {
												Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('You must upload the first photo or wait for it to finish uploading', EQUIPEER_ID); ?>", "error" );
												return false;
											}
											// Check if video link is filled in
											if ( !media_video_1 && !media_video_link_1 ) {
												Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('You must upload the first video or wait for it to finish uploading', EQUIPEER_ID); ?>", "error" );
												return false;
											}
											if ( media_video_1 && parseInt(media_progress_5) < 100 ) {
												Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('You must upload the first video or wait for it to finish uploading', EQUIPEER_ID); ?>", "error" );
												return false;
											}
											// Check Required fields
											var date_veto = jQuery("#putadVeterinaireDate").val();
											if (!date_veto) {
												Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('Required fields are missing', EQUIPEER_ID); ?>", "error" );
												return false;
											}
											// Check if right url string
											if ( media_video_link_1 && !isValidURL(media_video_link_1) ) {
													Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('Your video link 1 is not correct', EQUIPEER_ID); ?>", "error" );
													return false;
											}
											var media_video_link_2 = jQuery('#upl_video_link_6').val();
											if ( media_video_link_2 && !isValidURL(media_video_link_2) ) {
													Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('Your video link 2 is not correct', EQUIPEER_ID); ?>", "error" );
													return false;
											}
											var media_video_link_3 = jQuery('#upl_video_link_7').val();
											if ( media_video_link_3 && !isValidURL(media_video_link_3) ) {
													Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('Your video link 3 is not correct', EQUIPEER_ID); ?>", "error" );
													return false;
											}
											var media_video_link_4 = jQuery('#upl_video_link_8').val();
											if ( media_video_link_4 && !isValidURL(media_video_link_4) ) {
													Swal.fire( "<?php _e("Oops", EQUIPEER_ID); ?>", "<?php _e('Your video link 4 is not correct', EQUIPEER_ID); ?>", "error" );
													return false;
											}											
										}
									break;
								}
							});
						</script>
					<?php } ?>
				</div>
			</div>
			<div class="row mt-5">
				<div class="col col-pad-0">
					<!-- Additional Content -->
					<?php the_content(); ?>
				</div>
			</div>
		</div>

	</main><!-- #main -->
</section><!-- #primary -->

<!--<aside id="secondary" class="widget-area col-sm-12 equipeer-putad mt-5" role="complementary">-->
	<!-- DYNAMIC SIDEBAR -->
	<?php //dynamic_sidebar( 'equipeer-equine-putad' ); ?>
<!--</aside>-->

<?php
get_footer();