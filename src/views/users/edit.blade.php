@extends('krustr::_layout.default')

@section('main')
	<div class="pg clearfix">
		<h2>
			{{ admin_icn('user') }}
			Editing user <em>"{{ $user->full_name }}"</em>
		</h2>

		<div class="tools">
			<a href="{{ admin_route('system.users.create') }}" class="btn btn-success btn-small">{{ admin_icn('plus') }} Add new</a>
		</div>
	</div>

	<div id="user-form" class="user-form-edit boxed">
		{{ $form->render() }}
	</div>
@stop
