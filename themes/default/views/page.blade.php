@extends('theme::_layout.default')

@section('main')

	<h2>Page</h2>

	<hr>

	<h3>{{ $entry->title }}</h3>
	{{ $entry->body }}

@stop
