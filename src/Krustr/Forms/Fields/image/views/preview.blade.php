<div class="preview">
	<div class="preview-image clearfix">
		<div class="img">
			<?php if ($field->value) : ?>
				<a href="<?php echo $field->value ?>" target="_blank" class="lightbox"><img src="@thumb($field->value, 150)" class="preview-image-img" alt="" width="150"></a>
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
