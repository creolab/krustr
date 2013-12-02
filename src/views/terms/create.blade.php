@extends('krustr::_layout.default')

@section('main')
	<div class="pg clearfix">
		<h2 class="status-draft">
			{{ admin_icn($taxonomy->icon) }}

			New {{ $taxonomy->title_singular }}</em>
		</h2>

		<div class="tools">
			<a href="{{ admin_route('taxonomies.'.$taxonomy->name.'.index') }}" class="btn btn-info btn-small">{{ admin_icn('chevron-left') }} Back</a>
		</div>
	</div>

	<div id="entry-form" class="entry-form entry-form-create boxed">
		<?php /*{{ $form->render() }}*/ ?>
	</div>
@stop
