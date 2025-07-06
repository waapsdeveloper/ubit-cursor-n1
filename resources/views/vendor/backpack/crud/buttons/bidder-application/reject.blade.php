@if ($crud->hasAccess('update'))
    @if(in_array($entry->status, ['pending', 'payment_verified']))
        <a href="{{ url($crud->route.'/'.$entry->getKey().'/reject') }}" class="btn btn-sm btn-danger" title="Reject Application" onclick="return confirm('Are you sure you want to reject this application?')">
            <i class="la la-times"></i> Reject
        </a>
    @elseif($entry->status === 'rejected')
        <span class="btn btn-sm btn-secondary disabled" title="Application already rejected">
            <i class="la la-times"></i> Rejected
        </span>
    @else
        <span class="btn btn-sm btn-secondary disabled" title="Cannot reject application in current status">
            <i class="la la-times"></i> Cannot Reject
        </span>
    @endif
@endif 