@if ($crud->hasAccess('update'))
    @if($entry->status === 'pending')
        <a href="{{ url($crud->route.'/'.$entry->getKey().'/verify-payment') }}" class="btn btn-sm btn-info" title="Verify Payment">
            <i class="la la-check"></i> Verify Payment
        </a>
    @else
        <span class="btn btn-sm btn-secondary disabled" title="Payment already verified">
            <i class="la la-check"></i> Verified
        </span>
    @endif
@endif 