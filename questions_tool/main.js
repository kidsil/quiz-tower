$( document ).ready( function() {
	var form = $( 'form.question_db' );
	form.on( 'click', '.add_question', function() {
		var lastTr = $( this ).parent().find( 'tr:last' );
		var newTr = lastTr.clone();
		newTr.find( 'input' ).each( function( i ) {
			var oldName = $( this ).attr( 'name' );
			var newName = oldName.replace( /(.+?questions\]\[)(\d+)(\].+)/, function( $0, $1, $2, $3 ) {
				return $1 + String( parseInt( $2 ) + 1 ) + $3;
			});
			$( this ).attr( 'name', newName );
			if ( $( this ).attr( 'type' ) == 'text' ) {
				$( this ).val( '' );
			} else if ( $( this ).attr( 'type' ) == 'radio' ) {
				$( this ).prop( 'checked', false );
			}
		});
		lastTr.after( newTr );
	});

	form.on( 'click', '.add_category', function() {
		var lastCat = form.find( '.category_wrapper:last' );
		var newCat = lastCat.clone();
		newCat.find( 'tr:gt(1)' ).remove();

		newCat.find( 'input[name]' ).each( function( i ) {
			var oldName = $( this ).attr( 'name' );
			var newName = oldName.replace( /(.*?category\[)(\d+)(\].*)/, function( $0, $1, $2, $3 ) {
				return $1 + String( parseInt( $2 ) + 1 ) + $3;
			});
			$( this ).attr( 'name', newName );
			if ( $( this ).attr( 'type' ) == 'text' ) {
				$( this ).val( '' );
			} else if ( $( this ).attr( 'type' ) == 'radio' ) {
				$( this ).prop( 'checked', false );
			}
		});
		lastCat.after( newCat );
	});
})