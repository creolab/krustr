@extends('krustr::_layout.default')

@section('main')
	<div class="pg clearfix">
		<h2>
			{{ admin_icn('user') }}
			Create new user
		</h2>
	</div>

	<div id="user-form" class="user-form-edit boxed">
		{{ $form->render() }}
	</div>
@stop
