{{ Form::text('taxonomy-terms['.$taxonomy->name.']', $entry->termsString($taxonomy->name_singular), array('data-data' => '', 'class' => 'form-control input-lg tag-picker', 'data-source' => url('api/taxonomies/'.$taxonomy->name.'/terms'))) }}

{{ Form::hidden('taxonomy-terms-create['.$taxonomy->name.']',  null, array('class' => 'form-control tag-picker-create')) }}

