<div class="field-group-picker widget">
	<h2>Fields</h2>
	<div class="wrap">
		<ul class="nav nav-pills nav-stacked">
			@foreach ($groups as $name => $group)
				<li id="field-group-{{ $name }}-trigger"><a href="#{{ $name }}" title="">{{ $group->name }}</a></li>
			@endforeach

			<hr>

			@if ($taxonomies)
				@foreach ($taxonomies as $name => $taxonomy)
					<li id="field-group-tax-{{ $name }}-trigger"><a href="#tax-{{ $name }}" title="">{{ admin_icn($taxonomy->icon) }} {{ $taxonomy->title }}</a></li>
				@endforeach

				<hr>
			@endif

			<li id="field-group-_settings-trigger"><a href="#_settings" title="">{{ admin_icn('cog') }} Settings</a></li>
		</ul>
	</div>
</div>
