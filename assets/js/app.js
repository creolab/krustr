App = {
	params: {
		url:        APP_URL,
		hash:       window.location.hash.replace(/\#/g, ""),
		assetsPath: '/packages/creolab/krustr/assets',
	},

	/**
	 * Initialize core app
	 * @return {void}
	 */
	init: function() {
		App.Ajax.init();
		App.Upload.init();
		App.Forms.init();
	},

	/**
	 * Simply build an app URL
	 * @param  {string} path
	 * @return {string}
	 */
	url: function(path) {
		return App.params.url + path;
	},

	/**
	 * Initiliaze lightbox plugin
	 * @return {void}
	 */
	initLightbox: function() {
		$("a.lightbox").fancybox();
	},

	/**
	 * Displays an alert box on the page
	 * @param  {string} message
	 * @param  {string} type
	 * @return {void}
	 */
	notify: function(message, type) {
		if ( ! type) type = 'success';

		alertify.log(message, type);
	},

	/**
	 * Get app param
	 * @param  {string} key
	 * @return {mixed}
	 */
	get: function(key) {
		return App.params[key];
	},

	/**
	 * Set an app param
	 * @param {string} key
	 * @param {mixed}  val
	 */
	set: function(key, val) {
		App.params[key] = val;
	},

	/**
	 * Get query string params
	 * @param  {string} key
	 * @return {string}
	 */
	input: function(key) {
		var name = key.replace(/[[]/, "\\[").replace(/[]]/, "\\]");
		var regexS = "[\\?&]" + name + "=([^&#]*)";
		var regex = new RegExp(regexS);
		var results = regex.exec(window.location.search);
		if (results === null) {
			return "";
		} else {
			return decodeURIComponent(results[1].replace(/\+/g, " "));
		}
	}

};
