<div class="form-group {{ ($field->value and ! $field->value->media->isEmpty()) ? 'has-value' : 'no-value' }} field-type-{{ $field->type }} field-type-image" id="field-element-{{ $field->name }}" data-field-type="{{ $field->type }}">
	<label for="text" class="control-label">
		{{ $field->label }}
		<i class="glyphicon glyphicon-{{ $field->icon }}"></i>
	</label>

	@include("krustr_fields::gallery.views.preview")

	@include("krustr_fields::gallery.views.media")

	@include("krustr_fields::_default.upload")

</div>
