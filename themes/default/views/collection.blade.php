@extends('theme::_layout.default')

@section('main')
	<h2>{{ $channel->title }}</h2>

	@foreach ($entries as $entry)
		<hr>

		<article>
			<h3><a href="{{ url($channel->resource.'/'.$entry->slug) }}">{{ $entry->title }}</a></h3>
			{{ $entry->body }}
		</article>
	@endforeach
@stop
