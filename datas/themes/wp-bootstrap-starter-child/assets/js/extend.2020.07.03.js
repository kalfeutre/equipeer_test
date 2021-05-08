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

/**
 *
 * Extend JS By Jquery
 *
 */
jQuery(function($) {	
	// ---------------------------------------
	// Sweet ALERT
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
		swal({
			title: swal_title,
			text: swal_text,
			icon: "warning",
			buttons: {
				connect: {
					text: swal_connect,
					value: "connect",
					className: "equipeer-alert-button-blue",
					closeModal: true,
				},
				cancel: swal_cancel,
				register: {
					text: swal_register,
					value: "register",
					className: "equipeer-alert-button-blue",
					closeModal: true,
				},
			},
			dangerMode: true,
		})
		.then((value) => {
			switch (value) {
				case "connect":
					// Redirect to Sign in
					document.location = swal_connect_url;
				break;
				case "register":
					// Redirect to Register (Sign up)
					document.location = swal_register_url;
				break;
			}
		});
	});

	// ---------------------------------------
	// Sweet ALERT
	// ---------------------------------------
	// --- User Not connected
	// ---------------------------------------
	$(".equipeer-save-my-search").on('click', function(e) {
    e.preventDefault();
    var swal_title          = $(this).attr('data-title');
    var swal_confirm_button = $(this).attr('data-button-confirm');
    swal({
      title: $(this).data('attr', 'data-title'),
      input: 'text',
      inputAttributes: {
        autocapitalize: 'off'
      },
      showCancelButton: true,
      confirmButtonText: $(this).data('attr', 'data-button-confirm'),
      showLoaderOnConfirm: true,
      preConfirm: (login) => {
        return fetch(`//api.github.com/users/${login}`)
          .then(response => {
            if (!response.ok) {
              throw new Error(response.statusText);
            }
            return response.json();
          })
          .catch(error => {
            Swal.showValidationMessage(
              `Request failed: ${error}`
            );
          });
      },
      allowOutsideClick: () => !Swal.isLoading()
    }).then((result) => {
      if (result.value) {
        Swal.fire({
          title: `${result.value.login}'s avatar`,
          imageUrl: result.value.avatar_url
        });
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
	getUserLocation(false);
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

	// ---------------------------------------
	// Equine LIST (click URL)
	// jQuery Click Event On Div, Except Child Div
	// ---------------------------------------
	$(".horse-list").click(function(e) {
		if ($(e.target).hasClass('equine-add-selection')) {
			// Don't change page when click on ADD TO SELECTION
			return false;
		}
		var url = $(this).attr('data-click-url');
		if (url !== '') document.location = url;
	});
	
});


//var placeSearch,autocomplete;
function initialize() {
	//autocomplete = new google.maps.places.Autocomplete(document.getElementById('autocomplete'), { types: [ 'geocode' ] });
	//google.maps.event.addListener(autocomplete, 'place_changed', function() {
	//	fillInAddress();
	//});
	//autocomplete2 = new google.maps.places.Autocomplete(document.getElementById('autocomplete2'), { types: [ 'geocode' ] });
	//google.maps.event.addListener(autocomplete2, 'place_changed', function() {
	//	fillInAddress2();
	//});
}
//function fillInAddress() {
//	// Get the place details from the autocomplete object.
//	var place = autocomplete.getPlace();                      
//	var lat   = place.geometry.location.lat(),
//			lng   = place.geometry.location.lng();				
//	// Add Longitude / Latitude
//	jQuery( "#quest_localisation_latitude" ).val( lat );
//	jQuery( "#quest_localisation_longitude" ).val( lng );
//}
//function fillInAddress_global() {
//	// Get the place details from the autocomplete object.
//	var place = autocomplete_global.getPlace();                      
//	var lat   = place.geometry.location.lat(),
//		lng   = place.geometry.location.lng();				
//	// Add Longitude / Latitude
//	jQuery( "#main_localisation_latitude" ).val( lat );
//	jQuery( "#main_localisation_longitude" ).val( lng );
//}