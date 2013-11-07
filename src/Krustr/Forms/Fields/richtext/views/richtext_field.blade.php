<div class="form-group">
	<label for="text" class="control-label">
		{{ $field->label }}
		<i class="glyphicon glyphicon-{{ $field->icon }}"></i>
	</label>

	<div class="control-field">
		<textarea name="text" id="text" cols="30" rows="10" class="richtext form-control">{{ $value }}</textarea>
	</div>
</div>
