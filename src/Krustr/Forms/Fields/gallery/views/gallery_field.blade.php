<div class="form-group {{ ($field->value) ? 'has-value' : 'no-value' }} field-type-{{ $field->type }} field-type-image" id="field-element-{{ $field->name }}">
	<label for="text" class="control-label">
		{{ $field->label }}
		<i class="glyphicon glyphicon-{{ $field->icon }}"></i>
	</label>

	<?php echo '<pre>'; print_r(var_dump($media)); echo '</pre>'; ?>
	<?php //echo '<pre>'; print_r(var_dump($entry->field('gallery'))); echo '</pre>'; ?>

	@include("krustr_fields::gallery.views.preview")

	@include("krustr_fields::_default.upload")

	@include("krustr_fields::gallery.views.media")

</div>
