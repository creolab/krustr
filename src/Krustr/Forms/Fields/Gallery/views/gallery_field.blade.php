<div class="{{ $field->css_box_class }}">
	<div class="form-group {{ ($field->hasMedia()) ? 'has-value' : 'no-value' }} field-type-{{ $field->type }} field-type-image" id="field-element-{{ $field->name }}" data-field-type="{{ $field->type }}">
		<label for="text" class="control-label">
			{{ $field->label }}
			<i class="glyphicon glyphicon-{{ $field->icon }}"></i>
		</label>

		@include("krustr_fields::Gallery.views.preview")

		@include("krustr_fields::Gallery.views.media")

		@include("krustr_fields::_default.upload")
	</div>
</div>
