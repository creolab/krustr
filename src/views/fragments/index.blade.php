@extends('krustr::_layout.default')

@section('main')
	<div class="pg clearfix">
		<h2>
			{{ admin_icn('pencil') }}
			Fragments
		</h2>

		<div class="tools">
			<a href="{{ admin_route('content.fragments.create') }}" class="btn btn-success btn-small">{{ admin_icn('plus') }} Add new</a>
		</div>
	</div>

	<div class="boxed">
		@if ($fragments->count())
			<table class="table">
				<thead>
					<tr>
						<th>Name</th>
						<th>Template trigger</th>
						<th>Preview</th>
						<th>When</th>
						<th class="slim"></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($fragments as $fragment)
						<tr>
							<td class="title"><a href="{{ admin_route('content.fragments.edit', $fragment->id) }}">{{ $fragment->title }}</a></td>
							<td>@frag('{{ $fragment->slug }}')</td>
							<td>{{ Str::limit(strip_tags($fragment->body), 80) }}</td>
							<td class="slim">{{ $fragment->updated_at }}</td>
							<td class="actions slim c">
								<div class="wrapper">
									<a href="{{ admin_route('content.fragments.edit', $fragment->id) }}" class="edit">{{ admin_icn('pencil')}}</a>
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
