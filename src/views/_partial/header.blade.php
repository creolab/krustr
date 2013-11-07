@if (Auth::check())
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ admin_route('dashboard') }}">Krustr</a>
			</div>

			@include('krustr::_partial.navigation')
		</div>
	</nav>

	{{ app('krustr.navigation')->sub('backend') }}
@endif
