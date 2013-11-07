@extends('theme::_layout.default')

@section('main')
	<h2>Application error [{{ $code }}]!!!</h2>
	<hr>
	<h3>Exception: "{{ $error->getMessage() }}"</h3>
	<hr>
	<h4>Stack trace</h4>
	<p><pre>{{ $error->getTraceAsString() }}</pre></p>
@stop
