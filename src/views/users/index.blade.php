@extends('krustr::_layout.default')

@section('main')
	<div class="pg clearfix">
		<h2>
			{{ admin_icn('user') }}
			Users
		</h2>

		<div class="tools">
			<a href="{{ admin_route('system.users.create') }}" class="btn btn-success btn-small">{{ admin_icn('plus') }} Add new</a>
		</div>
	</div>

	<div class="boxed">
		<table class="table">
			<thead>
				<tr>
					<th class="slim"></th>
					<th class="slim">#</th>
					<th>Email</th>
					<th>Name</th>
					<th>Status</th>
					<th>When</th>
					<th class="slim"></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($users as $user)
					<tr class="status-{{ $user->status }}">
						<td class="slim status">{{ admin_icn('globe') }}</td>
						<td class="slim r">{{ $user->id }}</td>
						<td class="title"><a href="{{ admin_route('system.users.edit', $user->id) }}">{{ $user->email }}</a></td>
						<td>{{ $user->full_name }}</td>
						<td>{{ ucfirst($user->status) }}</td>
						<td class="slim">{{ $user->created_at }}</td>
						<td class="actions slim c">
							<div class="wrapper">
								<a href="{{ admin_route('system.users.edit', $user->id) }}" class="edit">{{ admin_icn('pencil')}}</a>
								<span class="sep">&bull;</span>
								<a href="#" class="delete btn-link">{{ admin_icn('remove-sign')}}</a>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
@stop
