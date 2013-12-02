@foreach ($taxonomy_terms as $name => $taxonomy)
	<fieldset id="field-group-tax-{{ $name }}" class="field-group">
		<h3 class="field-group-title">{{ $taxonomy->title }}</h3>

		<div class="form-group has-value field-type-text" id="field-element-title">
			<label for="text" class="control-label">
				{{ $taxonomy->title }}
				{{ admin_icn($taxonomy->icon) }}
			</label>

			<div class="control-field">
				@foreach ($taxonomy->terms as $term)
					<div class="checkbox">
						<label for="tax-term-{{ $term->id }}">
							<input type="checkbox" name="taxonomy-terms[{{ $taxonomy->name }}][]" value="{{ $term->id }}" id="tax-term-{{ $term->id }}" {{ $entry->hasTerm($term->id) ? ' checked="checked"' : '' }}>
							{{ $term->title }}
						</label>
					</div>
				@endforeach
			</div>
		</div>
	</fieldset>
@endforeach
