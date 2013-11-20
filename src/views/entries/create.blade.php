@extends('krustr::_layout.default')

@section('main')
	<div class="pg clearfix">
		<h2 class="status-draft">
			{{ admin_icn($channel->icon) }}

			@if ($channel->headline)
				New {{ $channel->title_singular }} in <em>"{{ $channel->name }}"</em>
			@else
				New Entry in <em>"{{ $channel->name }}"</em>
			@endif
		</h2>

		<div class="tools">
			<a href="{{ admin_route('content.'.$channel->resource.'.index') }}" class="btn btn-info btn-small">{{ admin_icn('chevron-left') }} Back</a>
		</div>
	</div>

	<div id="entry-form" class="entry-form entry-form-create boxed">
		{{ $form->render() }}
	</div>
@stop
