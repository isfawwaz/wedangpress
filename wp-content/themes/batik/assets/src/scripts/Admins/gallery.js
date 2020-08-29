/* eslint-disable no-multi-str */
class GalleryElement {

	constructor() {
		let self = this;
		(function($) {
			$( document ).ready( function() {
				self.init();
			});
		})(jQuery)
	}

	init() {

		// Instantiates the variable that holds the media library frame.
		let metaImageFrame;

		( function($) {
			// Runs when the media button is clicked.
			$( 'body' ).on( 'click', '.btn-media-uploader', function( e ) {
				e.preventDefault();

				// Get the field target
				let field = $( this ).data( 'media-uploader-target' ),
					fieldId = $( this ).data( 'media-uploader-id' );

				// Sets up the media library frame
				metaImageFrame = wp.media.frames.metaImageFrame = wp.media({
					title: meta_image.title,
					button: { text: 'Use this file' }
				});

				// Runs when an image is selected.
				metaImageFrame.on( 'select', function() {

					// Grabs the attachment selection and creates a JSON representation of the model.
					let media_attachment = metaImageFrame.state().get( 'selection' ).first().toJSON();
					
					// Sends the attachment URL to our custom image input field.
					$( field ).val( media_attachment.url );
					$( fieldId ).val( media_attachment.id );
		
				});

				// Opens the media library frame.
				metaImageFrame.open();
			});

			// Runs when the media gallery is clicked
			$( '.btn-meta-gallery' ).click( function( e ) {
				e.preventDefault();

				// Get the field target
				let target = $( this ).data( 'media-gallery-target' ),
					nameAttr = $( this ).data( 'media-gallery-name' ),
					$target = $( target );

				//create a new Library, base on defaults
				//you can put your attributes in
				let insertImage = wp.media.controller.Library.extend({
					defaults: _.defaults({
						id: 'insert-image',
						title: 'Insert Image Url',
						allowLocalEdits: true,
						displaySettings: true,
						displayUserSettings: true,
						multiple: true,
						type: 'image'//audio, video, application/pdf, ... etc
					}, wp.media.controller.Library.prototype.defaults )
				});

				// Sets up the media library frame
				let metaGalleryFrame = wp.media.frames.metaGalleryFrame = wp.media({
					title: meta_image.title,
					button: { text: 'Use this file' },
					multiple: true,
					state: 'insert-image',
					states: [
						new insertImage()
					]
				});

				//on close, if there is no select files, remove all the files already selected in your main frame
				metaGalleryFrame.off( 'close' );
				metaGalleryFrame.on( 'close', function() {
					let selection = metaGalleryFrame.state( 'insert-image' ).get( 'selection' );
					if ( ! selection.length ) {
					}
				});

				// Runs when an image is selected.
				metaGalleryFrame.off( 'select' );
				metaGalleryFrame.on( 'select', function() {

					let state = metaGalleryFrame.state( 'insert-image' );
					let selection = state.get( 'selection' );
					let imageArray = [];

					if ( ! selection ) {
						return;
					}

					selection.each( function( attachment ) {
						let display = state.display( attachment ).toJSON();
						let obj_attachment = attachment.toJSON();
						let caption = obj_attachment.caption,
							options,
							html;

						// If captions are disabled, clear the caption.
						if ( ! wp.media.view.settings.captions ) {
							delete obj_attachment.caption;
						}

						display = wp.media.string.props( display, obj_attachment );

						options = {
							id: obj_attachment.id,
							post_content: obj_attachment.description,
							post_excerpt: caption
						};

						if ( display.linkUrl )
							options.url = display.linkUrl;

						if ( 'image' === obj_attachment.type ) {
							html = wp.media.string.image( display );
							_.each({
								align: 'align',
								size:  'image-size',
								alt:   'image_alt'
							}, function( option, prop ) {
								if ( display[ prop ]) {
									options[ option ] = display[ prop ];
								}
							});
						} else if ( 'video' === obj_attachment.type ) {
							html = wp.media.string.video( display, obj_attachment );
						} else if ( 'audio' === obj_attachment.type ) {
							html = wp.media.string.audio( display, obj_attachment );
						} else {
							html = wp.media.string.link( display );
							options.post_title = display.title;
						}

						//attach info to attachment.attributes object
						attachment.attributes.nonce = wp.media.view.settings.nonce.sendToEditor;
						attachment.attributes.attachment = options;
						attachment.attributes.html = html;
						attachment.attributes['post_id'] = wp.media.view.settings.post.id;

						//do what ever you like to use it
						// console.log( target );
						// console.log(attachment.attributes);
						// console.log(attachment.attributes['attachment']);
						// console.log(attachment.attributes['html']);

						// Add to element
						let el = '<div class="gallery-item">\
							<input type="hidden" name="' + nameAttr + '[]" value="' + attachment.attributes.id + '" />\
							<div class="gallery-item__image">\
								<img src="' + attachment.attributes.url + '" alt="' + attachment.attributes.filename + '" class="wp-image-' + attachment.attributes.id + ' alignnone size-medium">\
							</div>\
							<div class="gallery-item__content">\
								<span>' + attachment.attributes.filename + '</span>\
								<a href="javascript:;" class="btn-delete-gallery-item text-danger">\
									<i class="dashicons dashicons-trash"></i>\
								</a>\
							</div>\
						</div>';

						$target.append( el );
					});
				});

				//reset selection in popup, when open the popup
				metaGalleryFrame.off( 'open' );
				metaGalleryFrame.on( 'open', function() {
					var selection = metaGalleryFrame.state( 'insert-image' ).get( 'selection' );

					//remove all the selection first
					selection.each( function( image )  {
						var attachment = wp.media.attachment( image.attributes.id );
						attachment.fetch();
						selection.remove( attachment ? [ attachment ] : []);
					});

					//add back current selection, in here let us assume you attach all the [id] to <div id="my_file_group_field">...<input type="hidden" id="file_1" .../>...<input type="hidden" id="file_2" .../>
					$target.find( 'input[type="hidden"]' ).each( function() {
						let input_id = jq( this );
						if ( input_id.val() ) {
							attachment = wp.media.attachment( input_id.val() );
							attachment.fetch();
							selection.add( attachment ? [ attachment ] : []);
						}
					});
				});

				// Opens the media library frame.
				metaGalleryFrame.open();
			});

			$( 'body' ).on( 'click', '.btn-delete-gallery-item', function( e ) {
				e.preventDefault();

				let $this = $( this );

				$this.parent().parent().fadeOut( 'fast', function() {
					$( this ).remove();
				});
			});
		})(jQuery)
	}
}

const galleryElement = new GalleryElement();

export default { galleryElement };
