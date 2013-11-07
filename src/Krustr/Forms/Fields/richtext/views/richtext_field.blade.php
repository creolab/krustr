<div class="form-group">
	<label for="text" class="control-label">
		{{ $field->label }}
		<i class="glyphicon glyphicon-{{ $field->icon }}"></i>
	</label>

	<div class="control-field">
		<textarea name="{{ $field->name }}" id="rich-{{ $field->name }}" cols="30" rows="10" class="richtext form-control">{{ $value }}</textarea>
	</div>
</div>
