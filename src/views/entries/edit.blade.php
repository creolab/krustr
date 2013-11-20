@extends('krustr::_layout.default')

@section('main')
	<div class="pg clearfix">
		<h2 class="status-{{ $entry->status }}">
			{{ admin_icn($channel->icon) }}
			Edit Entry
			<em>"{{ $entry->title }}"</em>
		</h2>

		<div class="tools">
			<a href="{{ admin_route('content.'.$channel->resource.'.index') }}" class="btn btn-info btn-small">{{ admin_icn('chevron-left') }} Back</a>
			<a href="{{ admin_route('content.'.$channel->resource.'.create') }}" class="btn btn-success btn-small">{{ admin_icn('plus') }} Add new</a>
		</div>
	</div>

	<div id="entry-form" class="entry-form entry-form-edit boxed">
		{{ $form->render() }}
	</div>
@stop
