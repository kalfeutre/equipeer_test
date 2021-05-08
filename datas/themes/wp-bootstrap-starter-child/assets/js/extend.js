/**
 * jQuery.browser.mobile (http://detectmobilebrowser.com/)
 *
 * jQuery.browser.mobile will be true if the browser is a mobile device
 *
 **/
(function(a){(jQuery.browser=jQuery.browser||{}).mobile=/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))})(navigator.userAgent||navigator.vendor||window.opera);

/**
 *
 * Assign IS by detect JQUERY BROWSER
 *
 */
var istablet = (/ipad|android|android 3.0|xoom|sch-i800|playbook|tablet|kindle/i.test(navigator.userAgent.toLowerCase()));
var isipad   = (/ipad/i.test(navigator.userAgent.toLowerCase()));
var isiphone = (/iphone/i.test(navigator.userAgent.toLowerCase()));

/**
 * Get Value by Key in URL
 *
 * @param	key		key name (Ex: https://domain.com/?q=123 - Key name = q)
 *
 * @return	string	value (Ex: https://domain.com/?q=123 - Value = 123)
 */ 
function getQuerystringDef(key, default_) {
  if (default_==null) default_=""; 
  key = key.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regex = new RegExp("[\\?&]"+key+"=([^&#]*)");
  var qs = regex.exec(window.location.href);
  if(qs == null)
	return default_;
  else
	return qs[1];
}

/**
 * Get Last part of URL
 *
 * @param		$url		Website URL
 *
 * @return string
 */ 
function getLastPartOfUrl($url) {
    var url = $url;
    var urlsplit = url.split("/");
    var lastpart = urlsplit[urlsplit.length-1];
    if(lastpart==='')
    {
        lastpart = urlsplit[urlsplit.length-2];
    }
    return lastpart;
}

/**
 * Locate the User's Position
 * HTML Geolocation API is used to locate a user's position
 *
 * @return string (User's position)
 */
function getUserLocation(maps) {
	if (maps === true) {
		// Position in GOOGLE MAPS
		map = new google.maps.Map(document.getElementById('map'), {
			center: {lat: -34.397, lng: 150.644},
			zoom: 6
		});
		infoWindow = new google.maps.InfoWindow;
	}

	// Try HTML5 geolocation.
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var pos = {
				lat: position.coords.latitude,
				lng: position.coords.longitude
			};

			if (maps === true) {
				infoWindow.setPosition(pos);
				infoWindow.setContent('Location found.');
				infoWindow.open(map);
				map.setCenter(pos);
			}
		}, function() {
			if (maps === true) handleLocationError(true, infoWindow, map.getCenter());
		});
	} else {
		// Browser doesn't support Geolocation
		if (maps === true) handleLocationError(false, infoWindow, map.getCenter());
	}
}
function handleLocationError(browserHasGeolocation, infoWindow, pos) {
	infoWindow.setPosition(pos);
	infoWindow.setContent(browserHasGeolocation ?
												'Error: The Geolocation service failed.' :
												'Error: Your browser doesn\'t support geolocation.');
	infoWindow.open(map);
}

function documentLocation(page) {
  document.location = "/" + page + "/?redirect_to=" +  encodeURI(window.location.href);
}

// Personal chat
function eqCloseModal() {
  // Close chat
  jQuery('#custom_html-3, #addthis_tool_by_class_name_widget-2').removeClass('z-index-1');
  jQuery('#footer-widget, #footer-colophon-socials').removeClass('z-index-relative');
}

/**
 *
 * Extend JS By Jquery
 *
 */
jQuery(function($) {
  // ---------------------------------------
  // Hover / Modal de merde...
  // ---------------------------------------
  $('#yobro-new-message').click(function() {
    // Ouverture modal
    var z_index_video_type = $('ul#equine-slider li.lslide img.video-type').css('zIndex');
    if (z_index_video_type == '1') {
      $('ul#equine-slider li.lslide img.video-type').css('zIndex', '0');
    } else {
      $('ul#equine-slider li.lslide img.video-type').css('zIndex', '1');
    }
  });
  
  // ---------------------------------------
  // Check if hover/touch equine dropdown selection
  // ---------------------------------------
  $("#menu-primary-icon li#equine-selection-li").hover(function () {
    //console.log('HOVER Dropdown selection');
		// Reload Masthead Menu
		$.ajax({
			type: "POST",                // use $_POST request to submit data
			url: equipeer_ajax.ajaxurl,  // URL to "wp-admin/admin-ajax.php"
			data: {
				action : 'equipeer_selection_menu', // wp_ajax_*, wp_ajax_nopriv_*
				//uid    : user_id,  // User ID
			},
			success:function(response) {
				// Populate Menu Mini
				$("#equine-dropdown-selection div#mini-selection").html(response);
				//console.log("mini-selection: " + response);
			}
		});
  });
  
  // ---------------------------------------
  // Check if single equine PAGE
  // ---------------------------------------
  if (document.body.classList.contains('single-equine')) {
    // Open chat
    $('.console-notification-message').on('click', function() {
      $('#custom_html-3, #addthis_tool_by_class_name_widget-2').addClass('z-index-1');
      $('#footer-widget, #footer-colophon-socials').addClass('z-index-relative');
    });
    // ---------------------------------------
    // Deplacement messagerie DESKTOP
    // ---------------------------------------
    //#yobro-new-message => #eqmessagerie
    if ( $(window).width() > 575) {
      // Si annonce libre
      $('#yobro-new-message').insertBefore('#eqmessagerie');
      // Si annonce expertisee
      $('#action-to-selection').insertBefore('#eqmessagerie');
      // Check if EN
      if (eqlang == 'en') {
        $('a.console-notification-message').html('Contact seller');
      }
    }
  }
  // ---------------------------------------
  // ACCOUNT
  // ---------------------------------------
  // --- H1 / Title
  $(".page-id-9 #content-header h1").html('Mon compte');
  if (document.body.classList.contains('page-id-9')) {
    if (eqlang == 'fr') { 
      document.title = 'Mon compte | Equipeer';
    }
  }
  // ---------------------------------------
  // REGISTER
  // ---------------------------------------
  // --- Title
  if (document.body.classList.contains('page-id-8')) {
    if (eqlang == 'fr') { 
      document.title = 'Créer un compte | Equipeer';
      $('label[for=user_password]').html('Mot de passe <span class="wpum-required">*</span>');
      $('fieldset.fieldset-wpum_field_16_ans_et_plus div.required-field small.description').html('Je déclare être âgé de 16 ans et plus <span class="wpum-required">*</span>');
    }
  }
  // ---------------------------------------
  // LOGIN
  // ---------------------------------------
  // --- Title
  if (document.body.classList.contains('page-id-6')) {
    if (eqlang == 'fr') {
      document.title = 'Se connecter | Equipeer';
    }
  }
  // ---------------------------------------
  // RESET PASSWORD
  // ---------------------------------------
  // --- Title
  if (document.body.classList.contains('page-id-7')) {
    if (eqlang == 'fr') {
      document.title = 'Mot de passe oublié | Equipeer';
    }
  }
  // --- Mes informations
  $("#wpum-submit-account-form input[type=text], #wpum-submit-account-form input[type=email], #wpum-submit-account-form input[type=url], #wpum-submit-account-form textarea, #wpum-submit-account-form select").addClass('form-control');
  if (eqlang == 'fr') {
    $("#wpum-submit-account-form fieldset.fieldset-user_firstname label").html('Pr&eacute;nom <span class="wpum-required">*</span>');
    $("#wpum-submit-account-form fieldset.fieldset-user_lastname label").html('Nom <span class="wpum-required">*</span>');
    $("#wpum-submit-account-form fieldset.fieldset-user_nickname label").html('Surnom');
    $("#wpum-submit-account-form fieldset.fieldset-user_displayname label").html('Nom public');
    $("#wpum-submit-account-form fieldset.fieldset-user_website label").html('Site web');
  }
  // --- Données personnelles
  $("#wpum-submit-personal-data-form input[type=password], #wpum-submit-data-erasure-form input[type=password]").addClass('form-control');
  $("#wpum-submit-personal-data-form input[type=submit], #wpum-submit-data-erasure-form input[type=submit]").addClass('eq-button eq-button-red');
  // --- Mot de passe
  $("#wpum-submit-password-form input[type=password]").addClass('form-control');
  $("#wpum-submit-password-form input[type=submit]").addClass('eq-button eq-button-red');
  
  // ---------------------------------------
  // Link clicked
  // ---------------------------------------
//  $(".equipeer-link-login").on('click', function() {
//    // Redirect to Sign in
//		document.location = "/login";
//  });
//  $(".equipeer-link-register").on('click', function() {
//    // Redirect to Sign in
//		document.location = "/register";
//  });
  
	// ---------------------------------------
	// Sweet ALERT 2
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

	// ---------------------------------------
	// Sweet ALERT 2
	// ---------------------------------------
	// --- Save my search result
	// ---------------------------------------
	$(".equipeer-save-my-search").on('click', function(e) {
    e.preventDefault();
    
    // Check if arguments in url
    var getfullurl = window.location.href;
    var isargument = getfullurl.indexOf("?");
    
    if (isargument < 0) {
      // Error insert datas in DB impossible
      // Arguments in url missing
      if (eqlang == 'fr') {
        Swal.fire(
          "Oops",
          "Vous devez effectuer une recherche avec des critères afin de pouvoir enregistrer votre recherche",
          "error"
        );
      } else {
        Swal.fire(
          "Oops",
          "You must perform a search with criteria in order to save your search",
          "error"
        );
      }
      return false;
    }
    
    var swal_title             = $(this).attr('data-title');
    var swal_confirm_title_txt = $(this).attr('data-txt-confirm');
    var swal_cancel_title_txt  = $(this).attr('data-txt-cancel');
    var swal_confirm_button    = $(this).attr('data-button-confirm');
    var swal_cancel_button     = $(this).attr('data-button-cancel');
    var swal_confirm_txt       = $(this).attr('data-text-confirm');
    var swal_cancel_txt        = $(this).attr('data-text-cancel');
    var swal_save_url          = $(this).attr('data-s-url');
    
    var new_string = "";
    if (typeof equipeer_search_text === "undefined") {
      //console.log('Search undefined text');
      new_string = "";
    } else {
      new_string = equipeer_search_text.replace(/<br>/g, ' - ');
      new_string = rtrim(new_string, ' - ');
    }
    
    if (eqlang == 'fr') {
      // FR
      search_txt_h6   = "Donner un nom &agrave; ma recherche";
      search_txt_span = "Etre averti d&egrave;s qu'une annonce correspond &agrave; ma recherche";
    } else {
      // EN
      search_txt_h6   = "Naming my search";
      search_txt_span = "Be notified as soon as an ad matches my search";
    }

    Swal.fire({
      title: swal_title,
      html: "<h6 style='margin-bottom: 0.5em;'>"+search_txt_h6+"</h6><input id='save_search_name' name='save_search_name' class='form-control' placeholder='' value='"+new_string+"'><br><input id='save_search_be_warned' name='save_search_be_warned' type='checkbox' class=''> <span style='font-size: 0.8em;'>"+search_txt_span+"</span>",
      icon: 'info',
      showCancelButton: true,
      confirmButtonText: swal_confirm_button,
      cancelButtonText: swal_cancel_button,
      reverseButtons: true,
      confirmButtonColor: '#0e2d4c',
      cancelButtonColor: '#d1023e'
    }).then((result) => {
      if (result.value) {
        
        $.ajax({
            url: equipeer_ajax.ajaxurl,
            type: "POST",
            data: {
              action : 'equipeer_save_search', // wp_ajax_*, wp_ajax_nopriv_*
              search_name: $('#save_search_name').val(),
              search_be_warned: $('#save_search_be_warned').prop('checked'),
              search_string: rtrim(new_string, ' - '),
              search_url: swal_save_url
            },
            dataType: "html",
            success: function (datas) {
              // Check result
              if (datas == '1') {
                Swal.fire( {
                  title: swal_confirm_title_txt,
                  html: swal_confirm_txt,
                  icon: 'success',
                  confirmButtonColor: '#0e2d4c'
                } );
              } else {
                // Error insert datas in DB
                Swal.fire(
                  "Error saving!",
                  "Please try agains",
                  "error"
                );
              }
            },
            error: function (xhr, ajaxOptions, thrownError) {
              Swal.fire(
                "Error saving!",
                "Please try again " + thrownError,
                "error"
              );
            }
        });
        
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        
        /* Read more about handling dismissals below */
        Swal.fire( {
          title: swal_cancel_title_txt,
          html: swal_cancel_txt, // Vous n'avez pas sauvegarde votre recherche
          icon: "error",
          confirmButtonColor: '#0e2d4c'
        } );
        
      }
    });
    
  });
  
	// ---------------------------------------
	// Tarteaucitron RGPD Button (click)
	// ---------------------------------------
	$(".tarteaucitronbutton").on('click', function() {
		tarteaucitron.userInterface.openPanel();
	});
	
	// ---------------------------------------
	// GEOLOCALISATION
	// false: Don't show Position in GOOGLE MAPS
	// true: Show Position in GOOGLE MAPS
	// ---------------------------------------
	//getUserLocation(false);
	// ---------------------------------------
	
	// ---------------------------------------
	// Si LOAD, RESIZE, SCROLL page
	// ---------------------------------------
	$(window).on("load resize scroll",function(e) {
		// Do what you want
		e.preventDefault();

		// ---------------------------------------		
		// Bootstrap Form
		// use this if you are using id/class to check
		// ---------------------------------------
		if( $('.form-signin').length ) {
				 // Add Class all inputs
				 // Exclude checkbox, submit
				 $('.form-signin input:not([type=checkbox])').addClass('form-control');
				 // Add Class all submit
				 $('.form-signin input[type=submit]').addClass('eq-button eq-button-blue');
		}
		
	});
	// ---------------------------------------
	
	// ---------------------------------------
	// Si MOBILE
	// ---------------------------------------
	if ( $.browser.mobile && /Mobi/i.test(navigator.userAgent) ) {
		
		if ( window.matchMedia("(orientation: portrait)").matches ) {  // Si mode PORTRAIT
			// Do what you want
		  
		} else if ( window.matchMedia("(orientation: landscape)").matches ) { // Si mode LANDSCAPE
			// Do what you want
		 
		}
	}
	// ---------------------------------------
	
	// ---------------------------------------
	// Si LARGEUR inferieure a 768px (MOBILE)
	// ---------------------------------------
	if ( $(window).width() < 768 ) {
		
	}
	
});

// ----------------------------------------
// ----------------------------------------
// API GOOGLE PLACES Multiples
// ----------------------------------------
// ----------------------------------------
var autocomplete = {};
var autocompletesWraps = ['searchMain', 'putadStep1', 'putadStep2'];
//var autocompletesWraps = ['putadStep1', 'putadStep2'];

var searchMain_form = { street_number: 'short_name', route: 'long_name', locality: 'long_name', administrative_area_level_1: 'short_name', country: 'long_name', postal_code: 'short_name' };
var putadStep1_form = { street_number: 'short_name', route: 'long_name', locality: 'long_name', administrative_area_level_1: 'short_name', country: 'long_name', postal_code: 'short_name' };
var putadStep2_form = { street_number: 'short_name', route: 'long_name', locality: 'long_name', administrative_area_level_1: 'short_name', country: 'long_name', postal_code: 'short_name' };

function eq_initialize() {

  jQuery.each(autocompletesWraps, function(index, name) {
  
    if (jQuery('#'+name).length == 0) {
      return;
    }

    // searchMain, putadStep1, putadStep2
    switch(name) {
      //default: autocomplete[name] = new google.maps.places.Autocomplete(jQuery('#'+name+' .autocomplete')[0], { types: ['address'] }); break;
      //default: autocomplete[name] = new google.maps.places.Autocomplete(jQuery('#'+name+' .autocomplete')[0], { types: ['geocode'] }); break;
      default: autocomplete[name] = new google.maps.places.Autocomplete(jQuery('#'+name+' .autocomplete')[0], { types: ['(cities)'] }); break;
      case "searchMain":
        autocomplete[name] = new google.maps.places.Autocomplete(jQuery('#'+name+' .autocomplete')[0], { types: ['(cities)'] });
      break;
      case "putadStep1":
        autocomplete[name] = new google.maps.places.Autocomplete(jQuery('#'+name+' .autocomplete')[0], { types: ["(cities)"] });
      break;
      case "putadStep2":
        autocomplete[name] = new google.maps.places.Autocomplete(jQuery('#'+name+' .autocomplete')[0], { types: ["(cities)"] });
      break;
    }
      
    google.maps.event.addListener(autocomplete[name], 'place_changed', function() {
      
      var place = autocomplete[name].getPlace();
      var form = eval(name+'_form');
      
      var lat = place.geometry.location.lat(),
          lng = place.geometry.location.lng();

      for (var component in form) {
        jQuery('#'+name+' .'+component).val('');
        jQuery('#'+name+' .'+component).attr('disabled', false);
      }
      
      for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (typeof form[addressType] !== 'undefined') {
          var val = place.address_components[i][form[addressType]];
          jQuery('#'+name+' .'+addressType).val(val);
        }
      }
      
      // ADD Longitude / Latitude
      switch(name) {
        case "searchMain":
          jQuery( "#main_localisation_latitude" ).val( lat );
          jQuery( "#main_localisation_longitude" ).val( lng );
        break;
        case "searchQuest": // Not effective
          jQuery( "#quest_localisation_latitude" ).val( lat );
          jQuery( "#quest_localisation_longitude" ).val( lng );
          jQuery( "#quest_localisation_name").val( jQuery( "#autocomplete" ).val() );
        break;
        case "putadStep1":
          // No lat / lng
          // New address with street number
          jQuery('#putadAddress').val( jQuery('#street_number').val() + ' ' + jQuery('#putadAddress').val() );
        break;
        case "putadStep2":
          jQuery( "#putadStep2Latitude" ).val( lat );
          jQuery( "#putadStep2Longitude" ).val( lng );
        break;
      }
      
    });
  });
}

// trim, rtrim, ltrim
function trim(str, chr) {
  if (!str) return;
  var rgxtrim = (!chr) ? new RegExp('^\\s+|\\s+$', 'g') : new RegExp('^'+chr+'+|'+chr+'+$', 'g');
  return str.replace(rgxtrim, '');
}
function rtrim(str, chr) {
  if (!str) return;
  var rgxtrim = (!chr) ? new RegExp('\\s+$') : new RegExp(chr+'+$');
  return str.replace(rgxtrim, '');
}
function ltrim(str, chr) {
  if (!str) return;
  var rgxtrim = (!chr) ? new RegExp('^\\s+') : new RegExp('^'+chr+'+');
  return str.replace(rgxtrim, '');
}
// Stripslashes
function stripSlashes() {
    return this.replace(/\\(.)/mg, "$1");
}
// Strip_tags
function strip_tags(str, allow) {
  if (!str) return;
  // making sure the allow arg is a string containing only tags in lowercase (<a><b><c>)
  allow = (((allow || '') + '').toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join('');
 
  var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi;
  var commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:php)?[\s\S]*?\?>/gi;
  return str.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) {
  return allow.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 :'';
  });
}

// Valid url (true or false)
function isValidURL(string) {
  var res = string.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
  return (res !== null)
};

// truncate
function truncate(str, length, ending) {
  if (length == null) {
    length = 100;
  }
  if (ending == null) {
    ending = '...';
  }
  if (str.length > length) {
    return str.substring(0, length - ending.length) + ending;
  } else {
    return str;
  }
}
// Number format
function formatThousands(n, dp) {
  var s = ''+(Math.floor(n)), d = n % 1, i = s.length, r = '';
  while ( (i -= 3) > 0 ) { r = ',' + s.substr(i, 3) + r; }
  return s.substr(0, i + 3) + r + (d ? '.' + Math.round(d * Math.pow(10,dp||2)) : '');
}
// Nl2br (like PHP)
function nl2br (str, is_xhtml) {
    if (typeof str === 'undefined' || str === null) {
        return '';
    }
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}