@extends('krustr::_layout.default')

@section('main')
	<div class="pg clearfix">
		<h2>{{ admin_icn('exclamation-sign') }} Forbidden</h2>
	</div>

	<div class="boxed">
		<p>You don't have the appropriate permissions to access this part of the system.</p>
	</div>
@stop
