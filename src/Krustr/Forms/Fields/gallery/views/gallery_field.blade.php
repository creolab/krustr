<div class="form-group {{ ($field->value) ? 'has-value' : 'no-value' }}" id="field-element-{{ $field->name }}">
	<label for="text" class="control-label">
		{{ $field->label }}
		<i class="glyphicon glyphicon-{{ $field->icon }}"></i>
	</label>

	<?php echo '<pre>'; print_r(var_dump($media)); echo '</pre>'; ?>
	<?php //echo '<pre>'; print_r(var_dump($entry->field('gallery'))); echo '</pre>'; ?>

	@include("krustr_fields::_default.upload")

	@include("krustr_fields::image.views.preview")

</div>
