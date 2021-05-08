// =================================
// =========== CUSTOM JS ===========
// =================================

// ===============================
// =========== TOPBAR ============
// ===============================
jQuery(function($) {
	$('.top-line').after('<div class="mobile-menu d-xl-none">');
	$('.top-menu').clone().appendTo('.mobile-menu');
	$('.mobile-menu-btn').click(function(){
		$('.mobile-menu').stop().slideToggle();
	});
	
	// ===== RANGE SLIDER PRICE =====	
    $(".js-range-slider").ionRangeSlider({
		skin: "modern"
	});
	
	// ===== HEADER BAR (Search) =====
	$('.leftmenutrigger, .leftmenu, .eq-overlay').on('click', function(e) {
		//eq_initialize();
		// Search bar (open / close)
		$('.side-nav').toggleClass("open");
		$('.eq-overlay').toggleClass("eq-no-overlay");
		e.preventDefault();
    });

	// ===== HEADER BAR (Menu) =====
	$('.rightmenutrigger, .rightmenu, .eq-overlay-menu').on('click', function(e) {
		// Search bar (open / close)
		$('.side-nav-menu').toggleClass("open");
		$('.eq-overlay-menu').toggleClass("eq-no-overlay");
		e.preventDefault();
    });

	// ===== HEADER BAR (Search) =====
	// ===== Exception merdique  =====
	$('.leftmenu-except').on('click', function(e) {
		// Search bar (open / close)
		$('.side-nav-menu').toggleClass("open"); // Close main menu
		$('.eq-overlay-menu').toggleClass("eq-no-overlay");
		$('.side-nav').toggleClass("open");      // Open main search
		$('.eq-overlay').toggleClass("eq-no-overlay");
		e.preventDefault();
    });
	
	// ===== EPREUVES (selection) =====
	$('.epreuve').on('click', function(e) {
		if ( $( this ).is( ".selected" ) ) {
			$( this ).toggleClass( "selected" );
			$( '.epreuve').not( this ).addClass( 'selected' );
			$( '#epreuve' ) .val( $( '.epreuve').not( this ).attr( 'data-epreuve' ) );
		} else {
			$( this ).toggleClass( "selected" );
			$( '.epreuve' ).not( this ).removeClass( 'selected' );
			$( '#epreuve' ) .val( $( this ).attr( 'data-epreuve' ) );
		}
		e.preventDefault();
	});
});

// ======================================
// ===== Behavior Scroll Sticky BAR =====
// ======================================
var lastScrollTop = 0;
jQuery(window).scroll(function() {

	    if (jQuery(window).scrollTop() === 0) {
			//console.log( 'Scroll en haut de page' );
	    }
		
	    if (jQuery(window).scrollTop() > 150) {
			//console.log( 'Scroll à 150px de hauteur de la page' );
			var st = jQuery(this).scrollTop();
			if (st > lastScrollTop) {
				// Direction is DOWN
			   jQuery( '.stickybar' ).css( 'top', '0' );
			} else if( st == lastScrollTop ) {
				// Do nothing 
				// In IE this is an important condition because there seems to be some instances where the last scrollTop is equal to the new one
			} else {
				// Direction is UP
			   jQuery( '.stickybar' ).css( 'top', '-97px' );
			}
			lastScrollTop = st;
	    } else {
			// Under 150, remove class stickybar
			jQuery( '.stickybar' ).css( 'top', '-97px' );
		}
		
		if (jQuery(window).height() + jQuery(window).scrollTop() == jQuery(document).height()) {
			//console.log( 'Scroll en bas de page' );
	    }
});