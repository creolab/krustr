@extends('theme::_layout.default')

@section('main')

	<h2>Contact</h2>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

	<hr>

	{{ Form::open(array('')) }}

		<div class="form-group">
			{{ Form::label('Name') }}
			{{ Form::text('name', null, array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('E-mail') }}
			{{ Form::text('email', null, array('class' => 'form-control')) }}
		</div>

		<div class="form-group">
			{{ Form::label('Message') }}
			{{ Form::textarea('message', null, array('class' => 'form-control')) }}
		</div>

		{{ Form::submit('Send', array('class' => 'btn btn-primary')) }}

	{{ Form::close() }}

@stop
