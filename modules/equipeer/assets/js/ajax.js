/* ========================================== */
/* ========================================== */
/* ========================================== */
/*                 ADMIN AJAX                 */
/* ========================================== */
/* ========================================== */
/* ========================================== */


jQuery(document).ready( function($) {
	// Debug mode initialisation
	var ajax_debug_selection     = false;
	var ajax_debug_questionnaire = false;
	// Debug mode
	if (ajax_debug_selection === true || ajax_debug_questionnaire === true) console.log('EQUIPEER AJAX Script loaded');
	
	// -----------------------------
	// Add / Dell selection (CLICK)
	// -----------------------------
	$('.action-to-selection').click(function (e) {
		e.preventDefault();
		// Initialize
		var the_button  = $(this);
		var the_counter = $("#equine-selection-counter");
		// Debug mode
		if (ajax_debug_selection === true) console.log('Click ADD/DEL TO SELECTION');
		// Ajax loader replaces text
		//the_button.html('<img class="equine-load-45" src="'+equipeer_ajax.ajaxloader_red+'" alt="loading">');
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
		// Debug mode
		if (ajax_debug_selection === true) console.log("PID: " + post_id + ' - UID: '+user_id);
		// Post Ajax Request
		$.ajax({
			type: "POST",                // use $_POST request to submit data
			url: equipeer_ajax.ajaxurl,  // URL to "wp-admin/admin-ajax.php"
			data: {
				action : 'equipeer_to_selection', // wp_ajax_*, wp_ajax_nopriv_*
				pid    : post_id,  // Post ID
				uid    : user_id,  // User ID
				op     : switch_op // ADD Operation
			},
			success:function(response) {
				//alert(response);
				var retour      = response.split("|");
				var resultat    = (retour[0] == 1) ? 'error' : 'success'; // 0: success | 1: error
				var title       = retour[1];
				var description = retour[2];
				var counter_tot = parseInt(retour[3]);
				if (ajax_debug_selection === true) console.log("Resultat: " + resultat + " - " + retour);
				// Add counter or NOT
				if (resultat == 'success') {
					if (ajax_debug_selection === true) console.log("Switch: " + switch_op);
					if (ajax_debug_selection === true) console.log('Counter TOTAL: '+counter_tot);
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
		// ------------------------------------------
		// Reload Masthead Menu
		// OBSOLETE : contournement par hover sur li
		// ------------------------------------------
		//$.ajax({
		//	type: "POST",                // use $_POST request to submit data
		//	url: equipeer_ajax.ajaxurl,  // URL to "wp-admin/admin-ajax.php"
		//	data: {
		//		action : 'equipeer_selection_menu', // wp_ajax_*, wp_ajax_nopriv_*
		//		uid    : user_id,  // User ID
		//	},
		//	success:function(response) {
		//		// Populate Menu Mini
		//		$("#equine-dropdown-selection div#mini-selection").html(response);
		//		if (ajax_debug_selection === true) console.log("mini-selection: " + response);
		//	}
		//});
		
		return false;
	});
	
	// -----------------------------
	// Questionnaire ACHAT (CLICK)
	// -----------------------------
	$('.questionnaire-achat-btn').click(function (e) {
		e.preventDefault();
		// -----------------------------
		// Initialize
		var the_button  = $(this);
		// -----------------------------
		// Debug mode
		if (ajax_debug_questionnaire === true) console.log('Click QUESTIONNAIRE Next');
		// -----------------------------
		// Get infos
		var the_step       = parseInt( $(this).attr('data-step') );       // Current STEP
		var the_step_next  = parseInt( $(this).attr('data-step-next') );  // Next STEP
		var the_step_total = parseInt( $(this).attr('data-step-total') ); // Next STEP
		// -----------------------------
		// Check if value is not empty
		switch(the_step) {
			case 1:
				// -----------------------------
				// Get quest_discipline value
				var quest_discipline = $('#quest_discipline').val();
				if (quest_discipline === '') {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Choisissez une catégorie !',
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
					//alert('Choisissez une catégorie !');
					return false;
				}
			break;
			case 2:
				// -----------------------------
				// Get quest_level
				var quest_level = $('#quest_level').val();
				var is_quest_discipline_elevage = $('#quest_discipline').val();
				if (quest_level === '' && is_quest_discipline_elevage != 446) {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Choisissez un niveau !',
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
					//alert('Choisissez un niveau !');
					return false;
				}
			break;
			case 3:
				// -----------------------------
				// Get quest_age
			break;
			case 4:
				// -----------------------------
				// Get quest_price
			break;
			case 5:
				// -----------------------------
				// Get quest_sex
				var quest_gender = $('#quest_gender').val();
				if (quest_gender === '') {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Choisissez un sexe !',
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
					//alert('Choisissez un sexe !');
					return false;
				}
			break;
			case 6:
				// -----------------------------
				// Get quest_localisation
				var quest_localisation_latitude  = $('#quest_localisation_latitude').val();
				var quest_localisation_longitude = $('#quest_localisation_longitude').val();
				if (quest_localisation_latitude === '' && quest_localisation_longitude === '') {
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Choisissez une localisation !',
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
					//alert('Choisissez une localisation !');
					return false;
				}
			break;
		}
		// -----------------------------
		// Check steps total
		if (the_step_next > the_step_total) return false;
		// -----------------------------
		// Ajax loader replaces text
		$('#questionnaire-content').fadeOut(1000);
		var button_in_progress_text = (eqlang == 'en') ? 'In progress' : 'En cours';
		the_button.html('<i class="spinner-grow spinner-grow-sm" role="status"></i>&nbsp;&nbsp;' + button_in_progress_text + '...');
		// -----------------------------
		// Debug mode
		if (ajax_debug_questionnaire === true) console.log("Current STEP: " + the_step + ' - Next STEP: '+the_step_next);
		// -----------------------------
		// Post Ajax Request
		$.ajax({
			type: "POST",                // use $_POST request to submit data
			url: equipeer_ajax.ajaxurl,  // URL to "wp-admin/admin-ajax.php"
			data: {
				action     : 'equipeer_questionnaire_achat', // wp_ajax_*, wp_ajax_nopriv_*
				step       : the_step,       // Current STEP
				step_next  : the_step_next,  // Next STEP
				step_total : the_step_total, // Total STEPs
				discipline : quest_discipline
			},
			success:function(response) {
				//alert(response);
				$('#questionnaire-content').html(response).fadeIn(1000);
				the_button.attr('data-step', the_step_next).attr('data-step-next', parseInt(the_step_next+1)).html( equipeer_ajax.txt_next + ' ' + the_step_next + '/' + the_step_total );
			},
			error: function(errorThrown) {
				swal( "Error", "Une erreur est survenue.<br>Réessayez ou contacter un administrateur", 'error' );
				//alert("Une erreur est survenue.\nRéessayez ou contacter un administrateur");
				console.log(errorThrown); // Error
			}
		});
	});
	
});