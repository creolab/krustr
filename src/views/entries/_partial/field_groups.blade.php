<div class="field-group-picker widget">
	<h2>Fields</h2>
	<div class="wrap">
		<ul class="nav nav-pills nav-stacked">
			@foreach ($groups as $name => $group)
				<li id="field-group-{{ $name }}-trigger"><a href="#{{ $name }}" title="">{{ $group->name }}</a></li>
			@endforeach

			<hr>

			<li id="field-group-_taxonomies-trigger"><a href="#_taxonomies" title="">Taxonomies</a></li>
			<li id="field-group-_settings-trigger"><a href="#_settings" title="">Settings</a></li>
		</ul>
	</div>
</div>
