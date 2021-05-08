jQuery(function($) {
	/**
	 * Change RANGE price when changes
	 *
	 * Page Settings OPTIONS (Titan Options)
	 */
	// ----- RANGE start -----
	// --- Initialize VALUES
	var init_range_start = $("#equipeer_range_start").val();
	if (init_range_start) {
		$('.range_start').text( init_range_start.replace(/(.)(?=(\d{3})+$)/g,'$1.') );
		// --- VALUES On change
		$("#equipeer_range_start").on("load change", function() {
			// Get new value
			var range_start = $(this).val();
			// Affect the SPAN text (format number 98.000)
			$('.range_start').text( range_start.replace(/(.)(?=(\d{3})+$)/g,'$1.') );
		});
	}
	// ----- RANGE 1 -----
	// --- Initialize VALUES
	var init_range_1_until = $("#equipeer_range_1_until").val();
	if (init_range_1_until) {
		$('.range_1_until').text( init_range_1_until.replace(/(.)(?=(\d{3})+$)/g,'$1.') );
		// --- VALUES On change
		$("#equipeer_range_1_until").on("change", function() {
			// Get new value
			var range_1_until = $(this).val();
			// Affect the SPAN text (format number 98.000)
			$('.range_1_until').text( range_1_until.replace(/(.)(?=(\d{3})+$)/g,'$1.') );
		});
	}
	// ----- RANGE 2 -----
	// --- Initialize VALUES
	var init_range_2_until = $("#equipeer_range_2_until").val();
	if (init_range_2_until) {
		$('.range_2_until').text( init_range_2_until.replace(/(.)(?=(\d{3})+$)/g,'$1.') );
		// --- VALUES On change
		$("#equipeer_range_2_until").on("change", function() {
			// Get new value
			var range_2_until = $(this).val();
			// Affect the SPAN text (format number 98.000)
			$('.range_2_until').text( range_2_until.replace(/(.)(?=(\d{3})+$)/g,'$1.') );
		});
	}
	// ----- RANGE 3 -----
	// --- Initialize VALUES
	var init_range_3_until = $("#equipeer_range_3_until").val();
	if (init_range_3_until) {
		$('.range_3_until').text( init_range_3_until.replace(/(.)(?=(\d{3})+$)/g,'$1.') );
		// --- VALUES On change
		$("#equipeer_range_3_until").on("change", function() {
			// Get new value
			var range_3_until = $(this).val();
			// Affect the SPAN text (format number 98.000)
			$('.range_3_until').text( range_3_until.replace(/(.)(?=(\d{3})+$)/g,'$1.') );
		});
	}
	// ----- RANGE 4 -----
	// --- Initialize VALUES
	var init_range_4_until = $("#equipeer_range_4_until").val();
	if (init_range_4_until) {
		$('.range_4_until').text( init_range_4_until.replace(/(.)(?=(\d{3})+$)/g,'$1.') );
		// --- VALUES On change
		$("#equipeer_range_4_until").on("change", function() {
			// Get new value
			var range_4_until = $(this).val();
			// Affect the SPAN text (format number 98.000)
			$('.range_4_until').text( range_4_until.replace(/(.)(?=(\d{3})+$)/g,'$1.') );
		});
	}
	
	// ----- Add Target Blank to EQUICODEX Link (Submenu) -----
	$('a[href$="//codex.equipeer.com/"]:first').attr('target','_blank');
	
	// ----- Division Moderate Counter -----
	var moderate_counter = $('ul.subsubsub li.moderate span.count').text();
	moderate_counter = moderate_counter.substring(1); // Remove first character
	moderate_counter = moderate_counter.substring(0, moderate_counter.length-1); // Remove last character
	var new_moderate_counter = parseInt(moderate_counter)/2;
	new_moderate_counter = (new_moderate_counter < 1) ? 0 : new_moderate_counter;
	$('ul.subsubsub li.moderate span.count').text('('+Math.floor(new_moderate_counter)+')');
	console.log('New counter: '+new_moderate_counter);

});

function equipeer_moderate(modal_id) {
	// Show modal box
	equipeer_modal(modal_id);
	return false;
}

function equipeer_contact(modal_id) {
	// Show modal box
	equipeer_modal(modal_id);
	return false;
}

function equipeer_print(modal_id) {
	// Show modal box
	equipeer_modal(modal_id);
	return false;
}

function equipeer_trashemail(modal_id) {
	// Show modal box
	equipeer_modal(modal_id);
	return false;
}

function equipeer_pdf_account_client(modal_id) {
	// Show modal box
	equipeer_modal(modal_id);
	return false;
}

function equipeer_modal(modal_id) {
	// Get the modal
	var modal = document.getElementById( modal_id );
	modal.style.display = "block";
	// Get the <span> element that closes the modal
	var span = document.getElementById( modal_id + "_close");
	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	  modal.style.display = "none";
	};
	// When the user clicks anywhere outside of the modal, close it
	//window.onclick = function(event) {
	//  if (event.target == modal) {
	//	modal.style.display = "none";
	//  }
	//};
}

function equipeer_close_modal(modal_id) {
	// close the modal
	var modal = document.getElementById( modal_id );
	modal.style.display = "none";
}

function equipeer_moderate_confirm(switch_action, pid, user_email) {
	switch(switch_action) {
		case "accept":
			var a = confirm("Vous confirmez accepter cette annonce ?");
			if (a == true) {
				// Confirmation de l'acceptation (Animation loader)
				jQuery('#modal_'+pid).addClass('equipeer-none'); // Hide complete form + buttons
				jQuery('#modal_loading_'+pid).removeClass('equipeer-none'); // Show GIF loader
				// Confirmation de l'acceptation (Post Ajax Request)
				jQuery.ajax({
					type: "POST",                // use $_POST request to submit data
					url: equipeer_ajax.ajaxurl,  // URL to "wp-admin/admin-ajax.php"
					data: {
						action : 'equipeer_moderate', // wp_ajax_*, wp_ajax_nopriv_*
						pid    : pid,          // Post ID
						email  : user_email,   // User Email
						op     : switch_action // Operation: accept | reject
					},
					success:function(response) {
						console.log(response);
						window.location.href = equipeer_admin_ajax.adminurl + "edit.php?s&post_status=moderate&post_type=equine";
					},
					error: function(errorThrown) {
						alert("Une erreur est survenue.\nRéessayez ou contacter un administrateur");
						console.log(errorThrown); // Error
					}
				});
			} else {
				// Annulation de la demande
			}
			//alert(txt);
		break;
		case "reject":
			var r = confirm("Vous rejetez cette annonce ?");
			if (r == true) {
				// Confirmation du refus (Animation loader)
				jQuery('#modal_'+pid).addClass('equipeer-none'); // Hide complete form + buttons
				jQuery('#modal_loading_'+pid).removeClass('equipeer-none'); // Show GIF loader
				// Confirmation du rejet
				var reject_subject = jQuery('#reject_subject_'+pid).val();
				var reject_cause   = jQuery('#reject_cause_'+pid).val();
				if (reject_subject != '' && reject_cause != '') {
					// Process rejet (Post Ajax Request)
					jQuery.ajax({
						type: "POST",                // use $_POST request to submit data
						url: equipeer_ajax.ajaxurl,  // URL to "wp-admin/admin-ajax.php"
						data: {
							action        : 'equipeer_moderate', // wp_ajax_*, wp_ajax_nopriv_*
							pid           : pid,          // Post ID
							email         : user_email,   // User Email
							cause_subject : reject_subject,
							cause         : reject_cause, // User message REJECT
							op            : switch_action // Operation: accept | reject
						},
						success:function(response) {
							console.log(response);
							window.location.href = equipeer_admin_ajax.adminurl + "edit.php?s&post_status=moderate&post_type=equine";
						},
						error: function(errorThrown) {
							alert("Une erreur est survenue.\nRéessayez ou contacter un administrateur");
							console.log(errorThrown); // Error
						}
					});
				} else {
					alert('Les champs Sujet et Motif sont obligatoires !');
				}
			} else {
				// Annulation de la demande
			}
		break;
	}
	// Break dance
	return false;
}

function equipeer_contact_confirm(pid, user_email) {
	var s = confirm("Vous souhaitez envoyer ce message ?");
	if (s == true) {
		// Confirmation du rejet
		var contact_subject = jQuery('#contact_subject_'+pid).val();
		var contact_body    = jQuery('#contact_body_'+pid).val();
		if (contact_subject != '' && contact_body != '') {
			// Confirmation de l'envoi (Animation loader)
			jQuery('#modal_'+pid).addClass('equipeer-none'); // Hide complete form + buttons
			jQuery('#modal_loading_'+pid).removeClass('equipeer-none'); // Show GIF loader
			// Process rejet (Post Ajax Request)
			jQuery.ajax({
				type: "POST",                // use $_POST request to submit data
				url: equipeer_ajax.ajaxurl,  // URL to "wp-admin/admin-ajax.php"
				data: {
					action  : 'equipeer_contact', // wp_ajax_*, wp_ajax_nopriv_*
					email   : user_email,   // User Email
					subject : contact_subject,
					body    : contact_body // User message BODY
				},
				success:function(response) {
					console.log(response);
					// Close modal (Animation GIF)
					jQuery('#modal_'+pid).removeClass('equipeer-none'); // Hide complete form + buttons
					jQuery('#modal_loading_'+pid).addClass('equipeer-none'); // Show GIF loader
					// Close modal (contact form)
					equipeer_close_modal('moderate_'+pid);
					// Success
					alert('Message envoyé au client !');
				},
				error: function(errorThrown) {
					// Close modal (Animation GIF)
					jQuery('#modal_'+pid).removeClass('equipeer-none'); // Hide complete form + buttons
					jQuery('#modal_loading_'+pid).addClass('equipeer-none'); // Show GIF loader
					// Close modal (contact form)
					equipeer_close_modal('moderate_'+pid);
					// --------------------------
					alert("Une erreur est survenue.\nRéessayez ou contacter un administrateur");
					console.log(errorThrown); // Error
				}
			});
		} else {
			alert('Les champs Sujet et Message sont obligatoires !');
		}
	} else {
		// Annulation de la demande
	}

	return false;
}

function equipeer_remove_confirm(pid, user_email) {
	var s = confirm("Vous souhaitez envoyer ce message avant de mettre à la corbeille cette annonce ?");
	if (s == true) {
		// Confirmation du rejet
		var contact_subject = jQuery('#contact_remove_subject_'+pid).val();
		var contact_body    = jQuery('#contact_remove_body_'+pid).val();
		if (contact_subject != '' && contact_body != '') {
			// Confirmation de l'envoi (Animation loader)
			jQuery('#modal_trashemail_'+pid).addClass('equipeer-none'); // Hide complete form + buttons
			jQuery('#modal_trashemail_loading_'+pid).removeClass('equipeer-none'); // Show GIF loader
			// Process rejet (Post Ajax Request)
			jQuery.ajax({
				type: "POST",                // use $_POST request to submit data
				url: equipeer_ajax.ajaxurl,  // URL to "wp-admin/admin-ajax.php"
				data: {
					action  : 'equipeer_contact_remove', // wp_ajax_*, wp_ajax_nopriv_*
					email   : user_email,   // User Email
					subject : contact_subject,
					body    : contact_body, // User message BODY
					product : pid  // Product ID
				},
				success:function(response) {
					console.log(response);
					// Close modal (Animation GIF)
					jQuery('#modal_trashemail_'+pid).removeClass('equipeer-none'); // Hide complete form + buttons
					jQuery('#modal_trashemail_loading_'+pid).addClass('equipeer-none'); // Show GIF loader
					// Close modal (contact form)
					equipeer_close_modal('trashemail_'+pid);
					// Success
					alert("Message envoyé au client\net annonce mise à la corbeille !");
					// Redirect
					window.location.href = equipeer_admin_ajax.adminurl + "edit.php?post_type=equine";
				},
				error: function(errorThrown) {
					// Close modal (Animation GIF)
					jQuery('#modal_trashemail_'+pid).removeClass('equipeer-none'); // Hide complete form + buttons
					jQuery('#modal_trashemail_loading_'+pid).addClass('equipeer-none'); // Show GIF loader
					// Close modal (contact form)
					equipeer_close_modal('trashemail_'+pid);
					// --------------------------
					alert("Une erreur est survenue.\nRéessayez ou contacter un administrateur\n"+errorThrown);
					console.log(errorThrown); // Error
				}
			});
		} else {
			alert('Les champs Sujet et Message sont obligatoires !');
		}
	} else {
		// Annulation de la demande
	}

	return false;
}

function equipeer_contact_pdf_confirm() {
	var s = confirm("Vous souhaitez envoyer les documents PDFs ?");
	if (s == true) {
		// Confirmation du rejet
		var expert_email        = jQuery('#expert_email').val();
		var contact_client      = jQuery('#contact_client').val();
		var contact_subject     = jQuery('#contact_subject_pdf_1').val();
		var contact_body        = jQuery('#contact_body_pdf_1').val();
		var contact_link_client = jQuery('#contact_link_client').val();
		var contact_link_expert = jQuery('#contact_link_expert').val();
		var contact_path_client = jQuery('#contact_path_client').val();
		var contact_path_expert = jQuery('#contact_path_expert').val();
		if (expert_email != '' && contact_client != '' && contact_subject != '' && contact_body != '') {
			// Confirmation de l'envoi (Animation loader)
			jQuery('#modal_pdf_1').addClass('equipeer-none'); // Hide complete form + buttons
			jQuery('#modal_loading_pdf_1').removeClass('equipeer-none'); // Show GIF loader
			// Process (Post Ajax Request)
			jQuery.ajax({
				type: "POST",                // use $_POST request to submit data
				url: equipeer_ajax.ajaxurl,  // URL to "wp-admin/admin-ajax.php"
				data: {
					action        : 'equipeer_pdf_send_files', // wp_ajax_*, wp_ajax_nopriv_*
					email_expert  : expert_email, // Email expert
					email_client  : contact_client,   // Email client
					email_subject : contact_subject, // Email subject
					email_body    : contact_body,     // Email body
					link_client   : contact_link_client, //
					link_expert   : contact_link_expert,
					path_client   : contact_path_client,
					path_expert   : contact_path_expert
				},
				success:function(response) {
					console.log(response);
					// Close modal (Animation GIF)
					jQuery('#modal_pdf_1').removeClass('equipeer-none'); // Hide complete form + buttons
					jQuery('#modal_loading_pdf_1').addClass('equipeer-none'); // Show GIF loader
					// Close modal (contact form)
					equipeer_close_modal('modal_pdf');
					// Check
					alert("Emails envoyés au client, à l'expert et aux administrateurs !");
				},
				error: function(errorThrown) {
					// Close modal (Animation GIF)
					jQuery('#modal_pdf_1').removeClass('equipeer-none'); // Hide complete form + buttons
					jQuery('#modal_loading_pdf_1').addClass('equipeer-none'); // Show GIF loader
					// Close modal (contact form)
					equipeer_close_modal('modal_pdf');
					// --------------------------
					alert("Une erreur est survenue.\nRéessayez ou contacter un administrateur\n"+errorThrown);
					console.log(errorThrown); // Error
				}
			});
		} else {
			alert('Tous les champs sont obligatoires !');
		}
	} else {
		// Annulation de la demande
	}

	return false;
}

function equipeer_contact_pdf_account() {
	var s = confirm("Vous souhaitez ajouter ce document à ce compte client ?");
	if (s == true) {
		// Confirmation du rejet
		var client_id        = jQuery('#pdf_account_client_id').val();
		var client_file_link = jQuery('#pdf_account_link').val();
		var client_file_size = jQuery('#pdf_account_size').val();
		console.log('client_id: '+client_id);
		console.log('client_file_link: '+client_file_link);
		console.log('client_file_size: '+client_file_size);
		if (client_id > 0) {
			// Confirmation de l'envoi (Animation loader)
			jQuery('#modal_account_1').addClass('equipeer-none'); // Hide complete form + buttons
			jQuery('#modal_loading_account_pdf').removeClass('equipeer-none'); // Show GIF loader
			// Process (Post Ajax Request)
			jQuery.ajax({
				type: "POST",                // use $_POST request to submit data
				url: equipeer_ajax.ajaxurl,  // URL to "wp-admin/admin-ajax.php"
				data: {
					action    : 'equipeer_pdf_add_file', // wp_ajax_*, wp_ajax_nopriv_*
					uid       : client_id,        // User ID
					file_link : client_file_link, // File link (http)
					file_size : client_file_size  // File size (Human readable)
				},
				success:function(response) {
					console.log(response);
					// Close modal (Animation GIF)
					jQuery('#modal_account_1').removeClass('equipeer-none'); // Hide complete form + buttons
					jQuery('#modal_loading_account_pdf').addClass('equipeer-none'); // Show GIF loader
					// Close modal (contact form)
					equipeer_close_modal('modal_account');
					// Check
					alert("Ajout du document effectué sur le compte du client !");
				},
				error: function(errorThrown) {
					// Close modal (Animation GIF)
					jQuery('#modal_account_1').removeClass('equipeer-none'); // Hide complete form + buttons
					jQuery('#modal_loading_account_pdf').addClass('equipeer-none'); // Show GIF loader
					// Close modal (contact form)
					equipeer_close_modal('modal_account');
					// --------------------------
					alert("Une erreur est survenue.\nRéessayez ou contacter un administrateur\n"+errorThrown);
					console.log(errorThrown); // Error
				}
			});
		} else {
			alert('Vous devez sélectionner un client !');
		}
	} else {
		// Annulation de la demande
	}

	return false;
}