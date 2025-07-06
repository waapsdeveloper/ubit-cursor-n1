{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Users" icon="la la-question" :link="backpack_url('user')" />
<x-backpack::menu-item title="Auctions" icon="la la-question" :link="backpack_url('auction')" />
<x-backpack::menu-item title="Bids" icon="la la-question" :link="backpack_url('bid')" />
<x-backpack::menu-item title="Wallets" icon="la la-question" :link="backpack_url('wallet')" />
<x-backpack::menu-item title="Invites" icon="la la-question" :link="backpack_url('invite')" />
<x-backpack::menu-item title="Auctiontimersettings" icon="la la-question" :link="backpack_url('auctiontimersetting')" />
<x-backpack::menu-item title="Invitation crud controllers" icon="la la-question" :link="backpack_url('invitation-crud-controller')" />
<x-backpack::menu-item title="Invitations" icon="la la-question" :link="backpack_url('invitation')" />
<x-backpack::menu-item title="Bidder Applications" icon="la la-user-plus" :link="backpack_url('bidder-application')" />