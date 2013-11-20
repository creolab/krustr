App.Forms = {
	params: {
		ckEditorPath: App.get('assetsPath') + '/vendor/ckeditor',
		ckEditorURL:  App.get('assetsPath')
	},

	/**
	 * Initialize resource forms
	 * @return {void}
	 */
	init: function() {
		this.initGroups();
		this.initEditors();
		this.initSelectboxes();
		this.initDateTimePickers();
		// this.Fields.init();
	},

	/**
	 * Initialize field group switching
	 * @return {void}
	 */
	initGroups: function() {
		// Add click events
		App.Forms.addGroupClicks();

		// Initial group
		if (App.get('hash')) {
			App.Forms.selectGroup(App.get('hash'));
		} else if (App.input('g')) {
			App.Forms.selectGroup(App.input('g'));
		} else {
			App.Forms.selectGroup('field-group-default');
		}
	},

	/**
	 * Add clicks to field group navigation
	 */
	addGroupClicks: function() {
		$(".field-group-picker a").click(function(e) {
			App.Forms.selectGroup($(this).attr("href"));
			e.preventDefault();
		});
	},

	selectGroup: function(id) {
		var groupId = id.replace(/\#/g, "");
		var $group = $("#" + groupId);
		var $li    = $("#" + groupId + "-trigger");
		console.log($li);
		console.log(groupId);

		// Mark navigation
		$(".field-group-picker li").removeClass("active");
		$li.addClass("active");

		// Toggle groups
		$(".field-group").not($group).hide();
		$group.show();

		// Rememeber active group
		$("input[name=active_field_group]").val(groupId);
	},

	/**
	 * Initialize rich text editor
	 * @return {void}
	 */
	initEditors: function() {
		if (CKEDITOR !== undefined) {
			CKEDITOR.basePath = App.url(App.Forms.params.ckEditorPath) + '/';

			$(".richtext").each(function() {
				CKEDITOR.replace(this, {
					customConfig: App.url(App.Forms.params.ckEditorPath + '/config.js'),
					baseHref:     App.url(),
					contentsCss:  App.url(App.Forms.params.ckEditorPath + '/contents.css')
				});
			});
		}
	},

	/**
	 * Initialize selectboxes with filtering
	 * @return {void}
	 */
	initSelectboxes: function() {
		$(".sel-advanced").select2({
			allowClear: true,
			placeholder: "Choose..."
		});
	},

	/**
	 * Initialize datepicker scripts
	 * @return {void}
	 */
	initDateTimePickers: function() {
		var $dateElements = $(".datepicker, .field-type-date input[type=text], .field-type-datetime-date input[type=text]");
		var $timeElements = $(".timepicker, .field-type-time input[type=text], .field-type-datetime-time input[type=text]");

		// Initialize date elements
		$dateElements.datepicker({
			format: 'yyyy/mm/dd',
			autoclose: true
		});

		// Initiliaze time elements
		$timeElements.timepicker({
			minuteStep: 15,
			showMeridian: false
		});
	},

	/**
	 * Just remove a gallery item after being deleted from DB
	 * @return {void}
	 */
	removeGalleryImage: function(response, el) {
		var id = $(el).attr('data-id');
		$('#' + id).fadeOut(300, function() { $(this).remove(); });
	}
};
