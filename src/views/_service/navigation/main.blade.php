<div class="{{ $class }}">
	<ul class="nav navbar-nav">
		@foreach ($items as $item)
			@if (role($item->role))
				<li class="{{ $item->active() }} {{ $item->dropdown() }} {{ $item->li_class }}">
					<a href="{{ $item->href }}" class="{{ $item->class }} {{ $item->dropdown() ? 'dropdown-toggle' : null }}" {{ $item->dropdown() ? 'data-toggle="dropdown"' : null }} >
						{{ admin_icn($item->icon) }}

						{{ $item->label }}
						@if ($item->dropdown())
							<b class="caret"></b>
						@endif
					</a>

					@if ($item->dropdown())
						<ul class="dropdown-menu">
							@foreach ($item->children as $child)
								@if ($item->separated)
									<li role="presentation" class="divider"></li>
								@endif

								<li>
									<a href="{{ $child->href }}" title="{{ $child->label }}">
										{{ admin_icn($child->icon) }}
										{{ $child->label }}
									</a>
								</li>
							@endforeach
						</ul>
					@endif
				</li>
			@endif
		@endforeach
	</ul>

	@include('krustr::_partial.auth')
</div>
