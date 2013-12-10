<div class="form-group {{ ($field->value) ? 'has-value' : 'no-value' }} field-type-{{ $field->type }}" id="field-element-{{ $field->name }}">
	<label for="text" class="control-label">
		{{ $field->label }}
		<i class="glyphicon glyphicon-{{ $field->icon }}"></i>
	</label>

	<div class="control-field">
		<input type="text" name="{{ $field->name }}" value="{{ $value }}" placeholder="{{ $field->placeholder }}" class="form-control datepicker {{ $field->css_class }}">
	</div>
</div>
