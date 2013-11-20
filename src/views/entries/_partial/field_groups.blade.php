<div class="field-group-picker widget">
	<h2>Fields</h2>
	<div class="wrap">
		<ul class="nav nav-pills nav-stacked">
			@foreach ($groups as $name => $group)
				<li id="field-group-{{ $name }}-trigger"><a href="#field-group-{{ $name }}" title="">{{ $group->name }}</a></li>
			@endforeach

			<li  id="field-group-settings-trigger" class="separated"><a href="#field-group-settings" title="">Settings</a></li>
		</ul>
	</div>
</div>
