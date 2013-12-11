<div class="preview">
	<div class="preview-image clearfix">
		<div class="img">
			<?php if ($field->value) : ?>
				<figure id="image-preview-item-{{ $field->id }}">
					<img src="@thumb($field->value, 150)" class="preview-image-img" alt="" width="150">

					<div class="actions clearfix">
						<a href="{{ route('api.media.field.delete', array($entry->id, $field->name)) }}" class="btn btn-danger btn-xs pull-right delete" data-remote="delete" data-confirm="Are you sure?" data-id="{{ $field->id }}" data-after="App.Media.removeImage">{{ admin_icn('remove') }}</a>
						<a href="{{ asset($field->value) }}" class="btn btn-success btn-xs pull-left zoom lightbox" rel="lighbox-gallery-{{ $field->name }}">{{ admin_icn('zoom-in') }}</a>
						<a href="{{ route('backend.field.image.edit', $field->id) }}" class="btn btn-info btn-xs editbox">{{ admin_icn('pencil') }}</a>
					</div>
				</figure>
			<?php else : ?>
				<img src="" class="preview-image-img" alt="" width="150">
			<?php endif; ?>
		</div>

		<!-- <div class="info">
			<label for="">Title</label>
			<input type="text" name="<?php echo $field->name ?>[title]"><br><br>
			<label for="">Alt</label>
			<input type="text" name="<?php echo $field->name ?>[title]">
		</div> -->
	</div>

	<div class="no-image" style="display: <?php echo ( ! $value) ? 'none' : 'none'; ?>">
		<div class="no-image-icon">{{ admin_icn('ban-circle') }}</div>
		<div class="no-image-text">
			There's no image currently uploaded<br>
			Please upload an image by clicking on the button below
		</div>
	</div>
</div>
