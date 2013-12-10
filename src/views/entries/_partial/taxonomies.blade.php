@foreach ($taxonomy_terms as $name => $taxonomy)
	<fieldset id="field-group-tax-{{ $name }}" class="field-group">
		<h3 class="field-group-title">{{ $taxonomy->title }}</h3>

		<div class="form-group has-value field-type-text" id="field-element-title">
			<label for="text" class="control-label">
				{{ $taxonomy->title }}
				{{ admin_icn($taxonomy->icon) }}
			</label>

			<div class="control-field">
				@if ($taxonomy->type == 'tags')
					@include('krustr::entries._partial.taxonomies_tags')
				@else
					@include('krustr::entries._partial.taxonomies_categories')
				@endif
			</div>
		</div>
	</fieldset>
@endforeach
