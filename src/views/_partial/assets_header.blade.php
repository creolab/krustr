<script>
var APP_URL            = "{{ url('/') }}";
var UPLOAD_ACTION      = "{{ route('api.upload') }}";
var ACTIVE_FIELD_GROUP = "{{ Session::get('active_field_group') }}";
</script>

@assets('app.css')
