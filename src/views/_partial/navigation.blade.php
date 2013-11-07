@if (Auth::check())

	{{ app('krustr.navigation')->render('backend') }}

	{{ app('krustr.navigation')->render('backend.sub') }}
@endif
