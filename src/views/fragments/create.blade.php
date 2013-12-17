@extends('krustr::_layout.default')

@section('main')
	<div class="pg clearfix">
		<h2>
			{{ admin_icn('pencil') }}
			New fragment
		</h2>

		<div class="tools">
			<a href="{{ admin_route('content.fragments.index') }}" class="btn btn-info btn-small">{{ admin_icn('chevron-left') }} Back</a>
		</div>
	</div>

	<div id="entry-form" class="entry-form entry-form-edit boxed">
		{{ $form->render() }}
	</div>
@stop
