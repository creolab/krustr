<div class="field-group-picker widget">
	<h2>Groups</h2>
	<div class="wrap">
		<ul class="nav nav-pills nav-stacked">
			@foreach ($settings as $group => $item)
				<li id="field-group-{{ $group }}-trigger">
					<a href="#{{ $group }}" title="{{ $group }}">
						{{ Str::title($group) }}
					</a>
				</li>
			@endforeach
		</ul>
	</div>
</div>
