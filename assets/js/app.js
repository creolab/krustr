App = {
	/**
	 * Application params
	 * @type {Object}
	 */
	params: {
		url:        APP_URL,
		hash:       window.location.hash.replace(/\#/g, ""),
		assetsPath: '/packages/creolab/krustr/assets',
	},

	/**
	 * Loading spinner
	 */
	spinner: false,

	/**
	 * Initialize core app
	 * @return {void}
	 */
	init: function() {
		App.Ajax.init();
		App.Upload.init();
		App.Forms.init();
		App.Media.init();
		App.initLightbox();
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
	},

	/**
	 * Show nice loading spinner
	 * @param  {string} text
	 * @return {void}
	 */
	showSpinner: function(text) {
		$("#loading-text").html(text);

		var opts = {
			length: 25, // The length of each line
			width: 9, // The line thickness
			radius: 26, // The radius of the inner circle
			color: '#fff', // #rgb or #rrggbb or array of colors
		};
		var target = document.getElementById('loading-spinner');
		App.spinner = new Spinner(opts).spin(target);

		$("#loading-overlay").fadeIn(100);
	},

	/**
	 * Hide loading spinner
	 * @return {void}
	 */
	hideSpinner: function() {
		$("#loading-overlay").fadeOut(100, function() {
			App.spinner.stop();
		});
	}

};
