@foreach ($taxonomy->terms as $term)
	<div class="checkbox">
		<label for="tax-term-{{ $term->id }}">
			<input type="checkbox" name="taxonomy-terms[{{ $taxonomy->name }}][]" value="{{ $term->id }}" id="tax-term-{{ $term->id }}" {{ ($entry and $entry->hasTerm($term->id)) ? ' checked="checked"' : '' }}>
			{{ $term->title }}
		</label>
	</div>
@endforeach
