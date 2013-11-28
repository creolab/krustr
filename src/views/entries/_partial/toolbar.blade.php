<div class="form-actions form-actions-bar">
	<div class="wrap">

		@if ( ! isset($entry) or ! $entry)

			<button type="submit" name="publish" value="1" class="btn btn-info btn-publish">{{ admin_icn('cloud-upload') }} Save and Publish</button>
			<button type="submit" class="btn btn-success btn-save">{{ admin_icn('download-alt') }} Save draft</button>

		@elseif (isset($entry) and $entry)

			@if ($entry->status == 'draft')
				<button type="submit" name="publish" value="1" class="btn btn-info btn-publish">{{ admin_icn('cloud-upload') }} Publish</button>
				<button type="submit" class="btn btn-success btn-save">{{ admin_icn('download-alt') }} Save draft</button>
			@elseif ($entry->status == 'published')
				<button type="submit" name="publish" value="1" class="btn btn-info btn-save">{{ admin_icn('cloud-upload') }} Save</button>
				<button type="submit" name="publish" value="0" class="btn btn-default pull-right">{{ admin_icn('cloud') }} Unpublish</button>
			@else
				<button type="submit" class="btn btn-info btn-save">{{ admin_icn('cloud-upload') }} Save</button>
			@endif

		@endif
	</div>
</div>
