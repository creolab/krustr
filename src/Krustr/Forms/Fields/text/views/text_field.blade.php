<div class="form-group {{ ($field->value) ? 'has-value' : 'no-value' }}" id="field-element-{{ $field->name }}">
	<label for="text" class="control-label">
		{{ $field->label }}
		{{ admin_icn($field->icon) }}
	</label>

	<div class="control-field">
		<input type="text" name="{{ $field->name }}" value="{{ $value }}" placeholder="{{ $field->placeholder }}" class="form-control {{ $field->css_class }}">
	</div>
</div>
