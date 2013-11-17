<div class="form-group {{ ($field->value) ? 'has-value' : 'no-value' }} field-type-{{ $field->type }}" id="field-element-{{ $field->name }}">
	<label for="text" class="control-label">
		{{ $field->label }}
		<i class="glyphicon glyphicon-{{ $field->icon }}"></i>
	</label>

	<div class="control-field">
		<textarea name="{{ $field->name }}" id="txt-{{ $field->name }}" cols="30" rows="10" class="form-control" placeholder="{{ $field->placeholder }}">{{ $value }}</textarea>
	</div>
</div>
