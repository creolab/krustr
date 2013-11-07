<!DOCTYPE html>
<html>
<head>
	@include('krustr::_partial.meta')

	@include('krustr::_partial.assets_header')
</head>
<body class="krustr @yield('body_class')">

@include('krustr::_partial.header')

<div class="container" id="layout">

	<div id="main">
		{{ all_alerts() }}

		@yield('main')
	</div>
</div>

@include('krustr::_partial.footer')

</body>
</html>

