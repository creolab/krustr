<div class="form-group {{ ($field->value) ? 'has-value' : 'no-value' }} field-type-{{ $field->type }}" id="field-element-{{ $field->name }}">
	<label for="text" class="control-label">
		{{ $field->label }}
		<i class="glyphicon glyphicon-{{ $field->icon }}"></i>
	</label>

	<div class="control-field">
		<select name="{{ $field->name }}" class="form-control sel-advanced" data-placeholder="{{ $field->placeholder }}" {{ $field->multiple ? 'multiple' : null }}>
			<option></option>
			<option value="1">1</option>
			<option value="2">4</option>
			<option value="3">3</option>
		</select>
	</div>
</div>
