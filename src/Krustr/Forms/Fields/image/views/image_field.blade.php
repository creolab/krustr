<div class="form-group {{ ($field->value) ? 'has-value' : 'no-value' }}" id="field-element-{{ $field->name }}">
	<label for="text" class="control-label">
		{{ $field->label }}
		<i class="glyphicon glyphicon-{{ $field->icon }}"></i>
	</label>

	@include("krustr_fields::image.views.preview")

	@include("krustr_fields::_default.upload")
</div>
