<fieldset id="field-group-_settings" class="field-group">
	<h3 class="field-group-title">Setting<</h3>

	<div class="row">
		<div class="col-lg-6">
			<div class="form-group has-value field-type-text" id="field-element-title">
				<label for="text" class="control-label">
					Meta data
					<i class="icn icon icon-cog"></i>
				</label>

				<div class="inline-form">
					<div class="control-field">
						<label for="meta_title">Meta title</label>
						{{ Form::text('meta_title', ((isset($entry)) ? $entry->meta_title : null), array('class' => 'form-control')) }}
					</div>

					<div class="control-field">
						<label for="meta_keywords">Meta keywords</label>
						{{ Form::text('meta_keywords',  ((isset($entry)) ? $entry->meta_keywords : null), array('class' => 'form-control')) }}
					</div>

					<div class="control-field">
						<label for="meta_keywords">Meta description</label>
						{{ Form::textarea('meta_description',  ((isset($entry)) ? $entry->meta_description : null), array('class' => 'form-control')) }}
					</div>
				</div>
			</div>
		</div>


		<!-- -->


		<div class="col-lg-6">
			<div class="form-group has-value field-type-text" id="field-element-title">
				<label for="text" class="control-label">
					Dates
					<i class="icn icon icon-calendar"></i>
				</label>

				<div class="inline-form">
					<div class="control-field">
						<label for="meta_title">Created at</label>
						{{ Form::text('created_at', ((isset($entry)) ? $entry->created_at : null), array('class' => 'form-control')) }}
					</div>

					<div class="control-field">
						<label for="meta_title">Updated at</label>
						{{ Form::text('updated_at', ((isset($entry)) ? $entry->created_at : null), array('class' => 'form-control')) }}
					</div>

					<div class="control-field">
						<label for="meta_title">Published at</label>
						{{ Form::text('published_at', ((isset($entry)) ? $entry->created_at : null), array('class' => 'form-control')) }}
					</div>
				</div>
			</div>
		</div>


		<!-- -->


		<div class="col-lg-6">
			<div class="form-group has-value field-type-text" id="field-element-title">
				<label for="text" class="control-label">
					People
					<i class="icn icon icon-user"></i>
				</label>

				<div class="inline-form">
					<div class="control-field">
						<label for="meta_title">Author</label>
						{{ Form::text('user', ((isset($entry)) ? $entry->author->full_name : null), array('class' => 'form-control')) }}
					</div>
				</div>
			</div>
		</div>
	</div>
</fieldset>
