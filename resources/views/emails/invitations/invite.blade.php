@component('mail::message')
# You're Invited to Join Sahil e Firdaus Auctions!

Hello @if(!empty($invitation->name)) {{ $invitation->name }} @else {{ $invitation->email }} @endif,

You have been exclusively invited to join the premium real estate auctions at **Sahil e Firdaus**.

@component('mail::panel')
**Your Invitation Code:**
# {{ $invitation->invitation_code }}
@endcomponent

Click the button below to register and activate your bidder account:

@component('mail::button', ['url' => $invitation->getInvitationUrl()])
Register Now
@endcomponent

**How it works:**
- Use your invitation code during registration
- Complete your profile and deposit to start bidding
- Only invited users can place bids

If you did not request this invitation, you can safely ignore this email.

Thanks,<br>
The Sahil e Firdaus Team

@slot('subcopy')
If you're having trouble clicking the "Register Now" button, copy and paste the URL below into your web browser:
[{{ $invitation->getInvitationUrl() }}]({{ $invitation->getInvitationUrl() }})
@endslot
@endcomponent
