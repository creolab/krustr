@extends('krustr::_layout.default')

@section('main')
	<div class="pg clearfix">
		<h2>
			{{ admin_icn($channel->icon) }}

			@if ($channel->headline)
				{{ $channel->title }} in <em>"{{ $channel->headline }}"</em>
			@else
				Entries in <em>"{{ $channel->title }}"</em>
			@endif
		</h2>

		<div class="tools">
			<a href="{{ admin_route('content.'.$channel->resource.'.create') }}" class="btn btn-success btn-small">{{ admin_icn('plus') }} Add new</a>
		</div>
	</div>

	<div class="boxed">
		@if ( ! $entries->isEmpty())
			<table class="table">
				<thead>
					<tr>
						<th class="slim"></th>
						<th class="slim">#</th>
						<th>Title</th>
						<th>Author</th>
						<th>Status</th>
						<th>When</th>
						<th class="slim"></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($entries as $entry)
						<tr class="status-{{ $entry->status }}">
							<td class="slim status">{{ admin_icn('globe') }}</td>
							<td class="slim r">{{ $entry->id }}</td>
							<td class="title"><a href="{{ admin_route('content.'.$entry->channel.'.edit', $entry->id) }}">{{ $entry->title }}</a></td>
							<td>{{ $entry->author->full_name }}</td>
							<td>{{ ucfirst($entry->status) }}</td>
							<td class="slim">{{ $entry->date }}</td>
							<td class="actions slim c">
								<div class="wrapper">
									<a href="{{ admin_route('content.'.$entry->channel.'.edit', $entry->id) }}" class="edit">{{ admin_icn('pencil')}}</a>
									<span class="sep">&bull;</span>
									<a href="#" class="delete btn-link">{{ admin_icn('remove-sign')}}</a>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@else
			<div class="alert alert-warning not-found">{{ admin_icn('warning-sign') }} Nothing found.</div>
		@endif
	</div>
@stop
