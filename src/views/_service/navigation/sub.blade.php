@if ($items)
	<div class="subnav">
		<ul class="nav nav-pills">
			@foreach ($items as $item)
				<li class="{{ $item->active() }} {{ $item->li_class }}">
					<a href="{{ $item->href }}" title="{{ $item->label }}">
						{{ admin_icn($item->icon) }}
						{{ $item->label }}
					</a>
				</li>
			@endforeach
		</ul>
	</div>
@endif
