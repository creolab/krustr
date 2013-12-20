@extends('krustr::_layout.default')

@section('main')
	<div class="pg clearfix">
		<h2>
			{{ admin_icn('trash') }}
			Clear cache
		</h2>
	</div>

	<div id="entry-form" class="entry-form entry-form-edit boxed">
		<div class="alert alert-success">{{ admin_icn('check') }} The cache was cleared successfuly.</div>
	</div>
@stop
