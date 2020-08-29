class SwitchElement {

	constructor() {
		this.init();
	}

	init() {
		(function($) {
			$( document ).ready( function() {
				$( 'body' ).on( 'click', '.field-switch .button-secondary', function( e ) {
					$( this ).parent().find( '.button' ).toggleClass( 'button-primary button-secondary' );
	
					let checkBox = $( this ).parents( '.field-switch' ).find( 'input' );
					if ( checkBox.is( ':checked' ) ) {
						checkBox.removeAttr( 'checked' );
					} else {
						checkBox.attr( 'checked', 'checked' );
					}
	
					checkBox.trigger( 'change' );
				});
			});
		})(jQuery);
	}
}

const switchEl = new SwitchElement();

export default { switchEl };
