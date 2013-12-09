App.Media = {
	params: {
	},

	/**
	 * Initiliaze media managers
	 * @return {void}
	 */
	init: function() {

	},

	/**
	 * Remove an image item after being deleted from DB
	 * @return {void}
	 */
	removeImage: function(response, el) {
		var id = $(el).attr('data-id');
		var $preview = $('#image-preview-item-' + id);

		$preview.fadeOut(300, function() {
			$img = $('<img src="" class="preview-image-img" alt="" width="150">');
			$img.insertAfter($preview);
			$(this).closest(".form-group").removeClass("has-value").addClass("no-value");
			$(this).remove();
		});
	},

	/**
	 * Remove a gallery item after being deleted from DB
	 * @return {void}
	 */
	removeGalleryImage: function(response, el) {
		var id = $(el).attr('data-id');
		$('#gallery-list-item-' + id).fadeOut(300, function() { $(this).remove(); });
	}

};
