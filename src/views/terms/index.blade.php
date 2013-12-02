@extends('krustr::_layout.default')

@section('main')
	<div class="pg clearfix">
		<h2>
			{{ admin_icn($taxonomy->icon) }}

			Terms in <em>"{{ $taxonomy->title }}"</em>
		</h2>

		<div class="tools">
			<a href="{{ admin_route('taxonomies.'.$taxonomy->name.'.create') }}" class="btn btn-success btn-small">{{ admin_icn('plus') }} Add new</a>
		</div>
	</div>

	<div class="boxed">
		@if ( ! $terms->isEmpty())
			<table class="table">
				<thead>
					<tr>
						<th class="slim"></th>
						<th class="slim">#</th>
						<th>Title</th>
						<th>When</th>
						<th class="slim"></th>
					</tr>
				</thead>
				<tbody>
					@foreach ($terms as $term)
						<tr class="">
							<td class="slim status">{{ admin_icn('globe') }}</td>
							<td class="slim r">{{ $term->id }}</td>
							<td class="title"><a href="{{ admin_route('taxonomies.'.$taxonomy->name.'.edit', $term->id) }}">{{ $term->title }}</a></td>
							<td class="slim">{{ $term->created_at }}</td>
							<td class="actions slim c">
								<div class="wrapper">
									<a href="#" class="edit">{{ admin_icn('pencil')}}</a>
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
