{{-- You can load files directly from CDNs, they will get cached and loaded from local --}}
@basset('https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css')

{{-- You can also load files from any place in your application directories --}}
@basset(resource_path('custom-view/css/sb-admin-2.css'))

{{-- You can also write inline CSS blocks --}}
{{-- @bassetBlock('my-cool-theme/custom-styling')
<style>
.something {
    border: 1px solid red;
} --}}
</style>
{{-- @endBassetBlock --}}


