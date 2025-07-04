You're an expert Laravel architect. Help me build a custom real estate auction platform called "UBit for Sahil e Firdaus".

🎯 High-Level Objective:
Build a modern Laravel-based auction platform where invited users can bid on real estate listings after paying a deposit. Admins can manage listings, verify users, and approve/refuse auctions.

🔑 Key Modules:
1. **User Roles & Auth**: Guest, Bidder, Admin
2. **Invitation System**: Admin invites users by email → registration allowed only via invite
3. **Wallet System**: Each user has a wallet for deposits and refunds
4. **Auction Listings**:
   - Properties listed by admin
   - Each auction has title, image, location, starting bid, deposit requirement, bid increment, start/end time
5. **Bidding Engine**:
   - Users place bids only if deposit is paid
   - Auto-bid support (optional for later)
   - Real-time updates optional (later via Pusher or Laravel Echo)
6. **Admin Panel**:
   - Dashboard
   - Create/edit/delete listings
   - Invite users
   - View bids & winner
   - Release refunds

💻 Tech Stack:
- Laravel 11
- Laravel Breeze or Fortify for auth
- Laravel Backpack or Filament for admin
- MySQL
- Blade (you can keep views minimal)
- Optional: Laravel Echo + Pusher (for real-time bidding in future phase)

🚀 Step 1 Task:
Set up:
- Laravel 11 project with Breeze
- User roles: Bidder, Admin
- Invitation-based registration
- Wallet table with basic deposit tracking
- Migration + Model scaffolding for: Users, Auctions, Bids, Wallets, Invites

Return:
- Project structure
- Key models with relationships
- Seeders/factories for demo data
- Mention next recommended step
