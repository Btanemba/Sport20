{{-- You can load files directly from CDNs, they will get cached and loaded from local --}}
@basset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js')

{{-- You can also load files from any place in your application directories --}}
@basset(resource_path('custom-view/js/sb-admin-2.js'))

{{-- You can also write inline JS blocks --}}
{{-- @bassetBlock('my-cool-theme/custom-scripting') --}}
{{-- <script>
 alert('got here');
</script>
@endBassetBlock --}}
