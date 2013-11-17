<div id="file-upload-<?php echo $field->name; ?>" class="file-upload-widget" data-id="<?php echo $field->name; ?>">
	<div class="toggle"><a href="#" class="btn btn-default">{{ admin_icn('cloud-upload') }} Upload file</a></div>

	<input id="uploaded-files-{{ $field->name }}" name="uploaded-files-{{ $field->name }}" value="" type="hidden">
	<input id="uploaded-urls-{{ $field->name }}" name="uploaded-urls-{{ $field->name }}" value="" type="hidden">

	<div class="uploader">
		<h3>Upload a new file</h3>

		<div class="clearfix">
			<div id="file-drop-<?php echo $field->name; ?>" class="file-drop">
				<a id="pick-files-<?php echo $field->name; ?>" href="#">{{ admin_icn('cloud-upload') }} <u>Select or drop files here</u></a>
			</div>

			<div id="filelist-<?php echo $field->name; ?>" class="file-upload-list">
				<div style="color: #999;">Please select some files...</div>
			</div>
		</div>

		<!-- <div class="clearfix">
			<a id="upload-files-<?php echo $field->name; ?>" href="#" class="btn btn-success btn-upload">{{ admin_icn('cloud-upload') }} Start uploading</a>
			<a href="#" class="btn btn-cancel-upload pull-right">{{ admin_icn('ban-circle') }} Cancel upload</a>
		</div> -->
	</div>
</div>
