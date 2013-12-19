App.Ajax = {

	params: {
		simDelete: true,
		simPut:    true,
	},

	/**
	 * Initialize ajax component
	 * @return {void}
	 */
	init: function() {
		this.initRemoteActions();
	},

	/**
	 * Initialize all liks with remote actions
	 * @return {void}
	 */
	initRemoteActions: function() {
		$("body").on("click", "a[data-remote]", function() {
			return App.Ajax.fireRemoteAction(this);
		});
	},

	/**
	 * Fires the remote action
	 * @param  {object} el
	 * @return {void}
	 */
	fireRemoteAction: function(el) {
		var $el          = $(el);
		var href         = $el.attr("href");
		var method       = $el.attr("data-remote") ? $el.attr("data-remote") : 'get';
		var id           = $el.attr("data-id");
		var before       = this.parseCallback($el.attr("data-before"));
		var after        = this.parseCallback($el.attr("data-after"));
		var callback     = this.parseCallback($el.attr("data-callback"));
		var confirmation = $el.attr("data-confirm");
		var sendData     = { id: id };

		// Before action
		if (before) before($el);

		// Confirmation
		if (confirmation) {
			if ( ! window.confirm(confirmation)) {
				return false;
			}
		}

		// Delete request setup
		if (method.toLowerCase() == "delete") {
			sendData["_method"] = "delete";
			method = 'post';
		}

		// Put request setup
		if (method.toLowerCase() == "put") {
			sendData["_method"] = "put";
			method = 'post';
		}

		// Now run the request
		if (href && method) {
			$.ajax({
				url:      href,
				data:     sendData,
				type:     method,
				dataType: 'json',
				success: function(response) {
					// Call the callback method if defined
					if (callback) callback(response, $el);
				},
				error: function() {
					alert("Error!");
				},
				complete: function(response) {
					if (after) after(response, $el);
				}
			});
		}

		return false;
	},

	/**
	 * Parse the callback string
	 * @param  {string} callback
	 * @return {Function}
	 */
	parseCallback: function(callback) {
		if (callback) {
			var method = window;
			var path   = callback.split(".");

			for (i = 0; i < path.length; i++) {
				method = method[path[i]];
			}

			return method;
		}
	}

};
