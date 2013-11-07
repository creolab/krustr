<div class="form-actions form-actions-bar">
	<div class="wrap">

		@if ( ! isset($entry) or ! $entry)

			<button type="submit" class="btn btn-success btn-save">{{ admin_icn('download-alt') }} Save draft</button>
			<button type="submit" class="btn btn-info btn-publish pull-right">{{ admin_icn('cloud-upload') }} Publish</button>

		@elseif (isset($entry) and $entry)

			@if ($entry->status == 'draft')
				<button type="submit" class="btn btn-info btn-publish">{{ admin_icn('cloud-upload') }} Publish</button>
			@elseif ($entry->status == 'published')
				<button type="submit" class="btn btn-info btn-save">{{ admin_icn('cloud-upload') }} Save and publish</button>
				<button type="button" class="btn btn-default pull-right">{{ admin_icn('cloud') }} Unpublish</button>
			@else
				<button type="submit" class="btn btn-info btn-save">{{ admin_icn('cloud-upload') }} Save</button>
			@endif

		@endif
	</div>
</div>
