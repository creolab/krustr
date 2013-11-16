@extends('theme::_layout.default')

@section('main')

	<h2>Article</h2>

	<hr>

	<h3>{{ $entry->title }}</h3>

	@if($entry->field('image'))
		<figure>
			<a href="{{ $entry->field('image') }}"><img src="@image($entry->field('image'), 300)" alt=""></a>
		</figure>
	@endif

	{{ $entry->body }}

@stop
