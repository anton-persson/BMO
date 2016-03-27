/**
 * Handles toggling the main navigation menu for small screens.
 */
jQuery( document ).ready( function( $ ) {
	var $navbar = $( '.navbar' ),
	    timeout = false;

	$.fn.smallMenu = function() {
		$navbar.find( '.navigation' ).removeClass( 'navigation' ).addClass( 'small-navigation' ).toggle();
		$navbar.find( '.menu-toggle' ).removeClass( 'hidden' );

		$( '.menu-toggle' ).unbind( 'click' ).click( function() {
			$navbar.find( '.small-navigation' ).toggle();
			$( this ).toggleClass( 'toggled-on' );
		} );
	};

	// Check viewport width on first load.
	if ( $( window ).width() < 540 )
		$.fn.smallMenu();

	// Check viewport width when user resizes the browser window.
	$( window ).resize( function() {
		var browserWidth = $( window ).width();

		if ( false !== timeout )
			clearTimeout( timeout );

		timeout = setTimeout( function() {
			if ( browserWidth < 540 ) {
				$.fn.smallMenu();
			} else {
				$navbar.find( '.small-navigation' ).removeClass( 'small-navigation' ).addClass( 'navigation' ).toggle();;
				$navbar.find( '.menu-toggle' ).addClass( 'hidden' );
			}
		}, 200 );
	} );
} );
