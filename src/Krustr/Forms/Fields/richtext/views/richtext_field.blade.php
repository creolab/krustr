<div class="form-group {{ ($field->value) ? 'has-value' : 'no-value' }}" id="field-element-{{ $field->name }}">
	<label for="text" class="control-label">
		{{ $field->label }}
		<i class="glyphicon glyphicon-{{ $field->icon }}"></i>
	</label>

	<div class="control-field">
		<textarea name="{{ $field->name }}" id="rich-{{ $field->name }}" cols="30" rows="10" class="richtext form-control">{{ $value }}</textarea>
	</div>
</div>
