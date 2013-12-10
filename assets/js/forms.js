App.Forms = {
	params: {
		ckEditorPath:   App.get('assetsPath') + '/vendor/ckeditor',
		ckEditorURL:    App.get('assetsPath'),
		ckEditorConfig: App.get('assetsPath') + '/js/editor_config.js'
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
		this.initTags();
		this.initSave();
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
		} else if (ACTIVE_FIELD_GROUP) {
			App.Forms.selectGroup(ACTIVE_FIELD_GROUP);
		} else {
			App.Forms.selectGroup('default');
		}
	},

	/**
	 * Add clicks to field group navigation
	 */
	addGroupClicks: function() {
		$(".field-group-picker a").click(function(e) {
			App.Forms.selectGroup($(this).attr("href"));
			return true;
		});
	},

	selectGroup: function(id) {
		var groupId = id.replace(/\#/g, "");
		var elId    = 'field-group-' + groupId;
		var $group  = $("#" + elId);
		var $li     = $("#" + elId + "-trigger");

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
					customConfig: App.url(App.Forms.params.ckEditorConfig),
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
	 * Initialize the tag picker
	 * @return {void}
	 */
	initTags: function() {
		$(".tag-picker").each(function() {
			var $el = $(this);
			var except = $el.val();
			var url = $el.attr("data-source");

			var $sel = $el.selectize({
				delimiter: ',',
				persist: false,
				loadThrottle: 100,
				create: function(input) {
					// Add new tags to array
					/*var $create = $el.parent().find(".tag-picker-create");
					var tags = [];
					if ($create.val()) tags = $create.val().split(",");
					tags.push(input);

					// Unique tags only
					tags = _.uniq(tags);
					console.log(tags);

					// Join back and updae value
					tags = tags.join(",");
					$create.val(tags);*/

					return { value: input, text: input, existing: false };
				},
				load: function(query, callback) {
					var $existing = $el.parent().find(".tag-picker-existing");

					// New tag
					if ( ! query.length) return callback();

					$.ajax({
						url: url + '?q=' + encodeURIComponent(query),
						data: {
							q: encodeURIComponent(query),
							except: except
						},
						type: 'GET',
						error: function() { callback(); },
						success: function(res) {
							var terms = [];

							// Existing tag
							if (res) {
								$(res).each(function(index, val) {
									terms.push({ value: val.title, text: val.title, existing: true });
								});
							}

							callback(terms);
						}
					});
				}
			});
		});



		/*$(".tag-picker").each(function() {
			var url = $(this).attr("data-source");

			$(this).select2({
				tokenSeparators: [";", ","],
				placeholder: "Enter your tags",
				tags: true,
				multiple: true,
				ajax: {
					url: url,
					data: function (term, page) {
						return { q: term };
					},
					results: function (data, page) {
						var terms = [];

						$(data).each(function(index, el) {
							terms.push({ id: el.title, text: el.title });
						});

						return { results: terms };
					}
				},
				createSearchChoice: function(term, data) {
					if ($(data).filter(function() {
						return this.text.localeCompare(term) === 0;
					}).length === 0) {
						return { id:term, text:term };
					}
				},
				initSelection: function(element, callback) {
					var id = $(element).val();
					var ids = id.split(",");

					if (ids) {
						$.ajax(url + "/" + id).done(function(data) {
							var terms = [];

							$(data).each(function(index, val) {
								terms.push({ id: val.id, text: val.title });
							});

							callback(terms);
						});
					}
				},

			});
		});*/
	},

	/**
	 * Hook into save event
	 * @return {void}
	 */
	initSave: function() {
		$("#entry-form").submit(function() {
			App.showSpinner("Saving");
		});
	}
};
