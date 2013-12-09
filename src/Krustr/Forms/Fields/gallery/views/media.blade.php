@if ($field->value and ! $field->value->media->isEmpty())
	<div class="media-collection clearfix">
		<div class="gallery-manager clearfix">
			<ul class="clearfix">
				@foreach ($field->value->media as $media)
					<li id="gallery-list-item-{{ $media->id }}">
						<figure>
							<img src="@thumb($media->path, 150)" alt="" width="150">

							<div class="actions clearfix">
								<a href="{{ route('api.media.delete', $media->id) }}" class="btn btn-danger btn-xs pull-right delete" data-remote="delete" data-confirm="Are you sure?" data-id="{{ $media->id }}" data-after="App.Media.removeGalleryImage">{{ admin_icn('remove') }}</a>
								<a href="{{ asset($media->path) }}" class="btn btn-info btn-xs zoom lightbox" rel="lighbox-gallery-{{ $field->name }}">{{ admin_icn('zoom-in') }}</a>
							</div>
						</figure>
					</li>
				@endforeach
			</ul>
		</div>
	</div>
@endif
