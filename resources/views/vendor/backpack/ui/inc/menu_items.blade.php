{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-chart-bar nav-icon"></i> Admin Dashboard & Statistics</a></li>
<x-backpack::menu-item title="Users" icon="la la-users" :link="backpack_url('user')" />
<x-backpack::menu-item title="Auctions" icon="la la-gavel" :link="backpack_url('auction')" />
<x-backpack::menu-item title="Bids" icon="la la-money-bill" :link="backpack_url('bid')" />
<x-backpack::menu-item title="Wallets" icon="la la-wallet" :link="backpack_url('wallet')" />
<x-backpack::menu-item title="Invites" icon="la la-envelope" :link="backpack_url('invite')" />
<x-backpack::menu-item title="Auction Timer Settings" icon="la la-clock" :link="backpack_url('auctiontimersetting')" />
<x-backpack::menu-item title="Invitations" icon="la la-paper-plane" :link="backpack_url('invitation')" />
<x-backpack::menu-item title="Bidder Applications" icon="la la-user-plus" :link="backpack_url('bidder-application')" />
<x-backpack::menu-item title="Settings" icon="la la-cog" :link="backpack_url('settings')" />