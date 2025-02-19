@if ($crud->hasAccess('update'))
    <a href="{{ url($crud->route.'/'.$entry->getKey().'/edit') }}" class="btn btn-sm btn-link">
        <i class="la la-edit"></i>
    </a>
@endif

@if ($crud->hasAccess('delete'))
    <a href="javascript:void(0)" onclick="deleteEntry(this)" data-route="{{ url($crud->route.'/'.$entry->getKey()) }}" class="btn btn-sm btn-link text-danger">
        <i class="la la-trash"></i>
    </a>
@endif


