@if ($crud->hasAccess('update'))
    @if($entry->status === 'invitation_sent')
        <a href="{{ url($crud->route.'/'.$entry->getKey().'/approve') }}" class="btn btn-sm btn-success" title="Approve Application">
            <i class="la la-thumbs-up"></i> Approve
        </a>
    @elseif($entry->status === 'approved')
        <span class="btn btn-sm btn-secondary disabled" title="Application already approved">
            <i class="la la-thumbs-up"></i> Approved
        </span>
    @else
        <span class="btn btn-sm btn-secondary disabled" title="Invitation must be sent first">
            <i class="la la-thumbs-up"></i> Send Invitation First
        </span>
    @endif
@endif 