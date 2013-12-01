<fieldset id="field-group-_taxonomies" class="field-group">
	<h3 class="field-group-title">Tax</h3>

	<div class="form-group has-value field-type-text" id="field-element-title">
		<label for="text" class="control-label">
			Taxonomies
			<i class="icn icon icon-pencil"></i>
		</label>

		<div class="control-field">
			<ul class="nav nav-tabs">
				@foreach ($taxonomy_terms as $key => $taxonomy)
					@if ( ! $taxonomy->terms->isEmpty())
						<li class="active"><a href="#tax-{{ $taxonomy->name }}" data-toggle="tab">{{ $taxonomy->title }}</a></li>
					@endif
				@endforeach
			</ul>

			<!-- Tab panes -->
			<div class="tab-content">
				@foreach ($taxonomy_terms as $key => $taxonomy)
					@if ( ! $taxonomy->terms->isEmpty())
						<div class="tab-pane active" id="tax-{{ $taxonomy->name }}">
							@foreach ($taxonomy->terms as $term)
									<div class="checkbox">
										<label for="tax-term-{{ $term->id }}">
											<input type="checkbox" value="{{ $term->id }}" id="tax-term-{{ $term->id }}">
											{{ $term->title }}
										</label>
									</div>
							@endforeach
						</div>
					@endif
				@endforeach
			</div>
		</div>
	</div>
</fieldset>
