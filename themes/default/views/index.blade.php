@extends('theme::_layout.default')

@section('main')
	@if (isset($entry))
		<div class="jumbotron">
			<h1>{{ $entry->title }}</h1>
			{{ $entry->body }}
			<p><a class="btn btn-lg btn-success" href="#">Get started today</a></p>
		</div>
	@endif
@stop
