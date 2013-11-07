@extends('theme::_layout.default')

@section('main')

	<h2>Article</h2>

	<hr>

	<h3>{{ $entry->title }}</h3>
	{{ $entry->body }}

@stop
