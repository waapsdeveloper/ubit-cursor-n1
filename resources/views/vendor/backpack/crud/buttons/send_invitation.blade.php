@if ($crud->hasAccess('update'))
    @if($entry->status === 'payment_verified')
        <a href="{{ url($crud->route.'/'.$entry->getKey().'/send-invitation') }}" class="btn btn-sm btn-primary" title="Send Invitation">
            <i class="la la-envelope"></i> Send Invitation
        </a>
    @elseif($entry->status === 'invitation_sent' || $entry->status === 'approved')
        <span class="btn btn-sm btn-secondary disabled" title="Invitation already sent">
            <i class="la la-envelope"></i> Sent
        </span>
    @else
        <span class="btn btn-sm btn-secondary disabled" title="Payment must be verified first">
            <i class="la la-envelope"></i> Verify First
        </span>
    @endif
@endif 