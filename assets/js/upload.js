App.Upload = {
	params: {
		maxFiles:     1,
		uploadAction: UPLOAD_ACTION
	},
	instances: [],

	/**
	 * Initiliaze upload widgets
	 * @return {void}
	 */
	init: function() {
		$(".file-upload-widget").each(function() {
			App.Upload.add(this);
		});
	},

	/**
	 * Create new uploader widget
	 * @param {object} el
	 */
	add: function(el) {
		var $el = $(el);
		var id  = $el.attr('data-id');

		if (id) {
			var $uploadButton   = $('#upload-files-' + id);
			var $fileList       = $('#filelist-' + id);
			var $fileUploadData = $("#file-upload-data-" + id);
			var $uploadedFiles  = $("#uploaded-files-" + id);
			var $uploadedUrls   = $("#uploaded-urls-" + id);
			var $toggle         = $el.find(".toggle");
			var $toggleCancel   = $el.find(".btn-cancel-upload");
			var $maxFiles       = $el.attr("data-max-files");
			if ( ! $maxFiles) $maxFiles = App.Upload.params.maxFiles;

			// Create new instance
			var instanceData = {
				runtimes        : 'html5',
				browse_button   : 'pick-files-'  + id,
				container       : 'file-upload-' + id,
				drop_element    : 'file-drop-'   + id,
				max_file_size   : '10mb',
				url             : App.Upload.params.uploadAction,
				max_files       : $maxFiles,
				file_types      : $el.attr('data-file-types'),
				uploaded_files  : []
			};

			// ! -- Toggle uploader
			$toggle.click(function() {
				$(this).hide();
				$(this).closest(".file-upload-widget").find(".uploader").show();
				return false;
			});
			$toggleCancel.click(function() {
				$toggle.show();
				$(this).closest(".uploader").hide();
				return false;
			});

			// ! -- Multi upload
			if (instanceData.max_files > 1) instanceData.multi_selection = true;
			else                            instanceData.multi_selection = false;

			// ! -- Filters
			instanceData.filters = [
				{ title : "Image files", extensions : "jpeg,jpg,gif,png" },
				{ title : "Image or zip files", extensions : "jpeg,jpg,gif,png,zip" },
				{ title : "ZIP files", extensions : "zip" },
				{ title : "Documents", extensions : "doc,docx,pdf,xls,ppt" }
			];

			// ! -- Add instance to list
			var instance = new plupload.Uploader(instanceData);
			App.Upload.instances.push(instance);
			instance.uploaded_files = [];

			// ! -- Start uploading on click
			instance.init();
			$uploadButton.click(function() {
				instance.start();
				return false;
			});

			// ! -- Upload progress
			instance.bind('UploadProgress', function(up, file) {
				$('#' + file.id + " b").html(file.percent + "%");
			});

			// ! -- Errors
			instance.bind('Error', function(up, err) {
				$fileList.append('<div class="alert-error upload-error">Error: ' + err.code +
					", Message: " + err.message +
					(err.file ? ", File: " + err.file.name : "") +
					"</div>"
				);
				up.refresh();
			});

			// ! -- Update filelist
			instance.bind('FilesAdded', function(up, files) {
				if (instance.files.length > $maxFiles) {
					instance.removeFile(instance.files[0]);
				}

				$.each(files, function(i, file) {
					$fileList.append(
						'<div id="' + file.id + '" class="file"><i class="icon-file"></i> ' +
							file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
						'</div>');
				});

				up.refresh();

				// Automatic upload if only file is allowed
				if ($maxFiles == 1) this.start();
			});

			// ! -- Upload success
			instance.bind('FileUploaded', function(up, file, response) {
				var $el = $('#' + file.id);
				var $b  = $el.find("b");
				$b.html("100%");
				$el.addClass("finished");
				var $data   = $fileUploadData;
				var current = $data.val();

				// Parse the response
				response = App.Upload.parsePluploadResponse(up, file, response);

				// Add to list
				instance.uploaded_files.push(response);

				if (response && ! response.error) {
					var uploadedFiles = $.trim(response.path + ";" + $uploadedFiles.val());
					$uploadedFiles.val(uploadedFiles);
					var uploadedUrls = $.trim(response.url + ";" + $uploadedUrls.val());
					$uploadedUrls.val(uploadedUrls);

					// Show message
					console.log(App);
					App.notify("The file was uploaded.", "success");

					// Reload the preview
					App.Upload.reloadPreview(id, response, $el.attr("id"));
				}
			});
		}
	},

	/**
	 * Reload the preview for the uploaded file
	 * @param  {object} $preview
	 * @return {void}
	 */
	reloadPreview: function(id, response, listId) {
		var $upload          = $("#file-upload-" + id);
		var $listItem        = $("#" + listId);
		var $el              = $("#" + id);
		var $previewImage    = $("#field-element-" + id).find(".preview-image");
		var $previewImageSrc = $("#field-element-" + id).find(".preview-image-img");
		var $noImage         = $("#field-element-" + id).find(".no-image");

		console.log("#field-element-" + id);
		console.log($previewImage.length);

		// Change SRC for preview image
		$previewImageSrc.attr("src", response.url);

		// Hide "no-image" container, and show preview
		$noImage.hide();
		$previewImage.show();

		// $previewImage.closest("a").attr("href", response.base_filepath).show();
		//$("#file-path-act-<?php echo $field->slug; ?> .current-path a").attr("href", response.base_filepath).html(response.base_filepath);
		// $previewImage.closest(".preview").find(".no-image").hide();
		//$("#file-path-act-<?php echo $field->slug; ?>").show();

		// Remove from list after upload
		var file_upload_success_timeout = setTimeout(function() {
			$listItem.fadeOut();

		}, 1000, $listItem);


	},

	/**
	 * This one should parse the response from the upload server script
	 * @param  {string} up
	 * @param  {string} file
	 * @param  {string} response
	 * @return {pmixed}
	 */
	parsePluploadResponse: function(up, file, response) {
		var rpc_response;

		try {
			rpc_response = JSON.parse(response.response);
		} catch(err) { console.error(err); }

		return rpc_response;
	}

};
