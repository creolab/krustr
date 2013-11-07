<!doctype html>
<html>
<head>
	<title>Krustr</title>

	<?php Assets::clearCache() ?>

	<link href='http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic' rel='stylesheet' type='text/css'>

	@theme_assets('theme.css')
</head>
<body class="site {{ template_class() }}">
<div class="container">
	<header class="masthead">
		<h2 class="text-muted"><a href="{{ route('site.home') }}">Krustr</a></h2>

		@include('theme::_partial.navigation')
	</header>
