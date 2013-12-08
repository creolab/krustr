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
	 * Just remove a gallery item after being deleted from DB
	 * @return {void}
	 */
	removeGalleryImage: function(response, el) {
		console.log(response);
		console.log(el);
		var id = $(el).attr('data-id');
		$('#gallery-list-item-' + id).fadeOut(300, function() { $(this).remove(); });
	}

};
