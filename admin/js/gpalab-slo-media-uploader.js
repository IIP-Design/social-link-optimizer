( function( $ ) {
	'use strict';

  let fileFrame;
  let imageData;

	$( function() {
		const selectLogoBtn = $( '#gpalab-slo-identity-logo-btn' );
		const removeLogoBtn = $( '#gpalab-slo-identity-remove-logo-btn' );
		const logo = $( '#gpalab-slo-identity-logo' );
		const inputField = $( '#gpalab-slo-identity-input' );

		selectLogoBtn.click( function( e ) {
			e.preventDefault();

			if ( undefined !== fileFrame ) {
				fileFrame.open();
				return;
			}

			fileFrame = wp.media.frames.file_frame = wp.media( {
				title: "Insert Image",
				button: {
					text: "Upload Image",
				},
				library: { 
					type: 'image',
				},
				multiple: false,
			} );

			fileFrame.on( 'select', function() {
				imageData = fileFrame.state().get( 'selection' ).first().toJSON();

				if ( imageData ) {
					logo
						.attr( 'style', 'display: block; height: auto; max-width: 100%; margin: auto;' )
						.attr( 'src', imageData.url );

					inputField.val( imageData.url );
				}
			} );

			fileFrame.open();
		} );

		removeLogoBtn.on( 'click', function() {
			logo
				.attr( 'src', '' )
				.attr( 'style', 'display: none' );

			inputField.val( '' );
		} );
	} );
} )( jQuery );
