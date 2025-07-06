# Sahil e Firdaus Auctions

A modern, secure online auction platform built with Laravel for property auctions in Pakistan.

## 🏗️ System Overview

Sahil e Firdaus Auctions is a comprehensive online auction platform that enables users to participate in property auctions. The system supports multiple user roles, real-time bidding, secure payment processing, and administrative management tools.

## ✨ Key Features

### 🏠 Property Auctions
- **Property Listings**: Browse available properties with detailed information
- **Real-time Bidding**: Live auction experience with instant bid updates
- **Timer System**: Countdown timers for auction end times
- **Bid History**: Complete history of all bids on each auction
- **Minimum Bid Increments**: Configurable bid increments to prevent micro-bidding

### 👥 User Management
- **Multi-role System**: Admin, Bidder, and Regular User roles
- **Open Registration**: Users can register without invitation codes
- **Bidder Applications**: Upgrade path from regular user to bidder
- **Profile Management**: User profile and account settings

### 💰 Financial System
- **Wallet Management**: User wallets for deposit management
- **Payment Verification**: Secure payment proof upload and verification
- **Deposit System**: Required deposits for bidder accounts
- **Transaction Tracking**: Complete audit trail of all financial transactions

### 🔐 Security & Compliance
- **Authentication**: Secure user authentication and authorization
- **Role-based Access**: Granular permissions based on user roles
- **Payment Security**: Secure payment processing and verification
- **Data Protection**: User data privacy and protection measures

### 📧 Communication
- **Email Notifications**: Automated email notifications for important events
- **Invitation System**: Admin-controlled invitation system for special access
- **Status Updates**: Real-time status updates for applications and bids

## 🚀 Quick Start

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL 8.0 or higher
- Node.js and NPM (for frontend assets)
- Laragon (recommended for Windows) or similar local development environment

### Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd ubit-cursor-n1
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   Edit `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sahil_auctions
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

7. **Build frontend assets**
   ```bash
   npm run build
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

### Default Admin Account
After running the seeders, you'll have access to the default admin account:
- **Email**: admin@sahilefirdaus.com
- **Password**: password

## 👥 User Roles & Permissions

### 🔧 Admin
- **Full system access** and management
- **Create and manage auctions**
- **Manage user accounts and roles**
- **Process bidder applications**
- **Send invitations**
- **View all financial transactions**
- **System configuration**

### 🎯 Bidder
- **Place bids on auctions**
- **View auction details and history**
- **Manage wallet and deposits**
- **Receive bid notifications**
- **View personal bid history**

### 👤 Regular User
- **Browse auctions** (view-only)
- **Register for bidder status**
- **View auction details**
- **Submit bidder applications**

## 🔄 User Workflows

### New User Registration
1. **Register**: User creates account (gets 'user' role)
2. **Browse**: Can view auctions but cannot bid
3. **Apply**: Submits bidder application with payment proof
4. **Verify**: Admin verifies payment and sends invitation
5. **Activate**: User activates bidder account
6. **Bid**: Can now participate in auctions

### Auction Process
1. **Admin creates auction** with property details and settings
2. **Users browse** available auctions
3. **Bidders place bids** during active period
4. **Real-time updates** show current highest bid
5. **Timer counts down** to auction end
6. **Winner is determined** based on highest bid
7. **Payment processing** and property transfer

### Bidder Application Process
1. **User applies** for bidder status
2. **Makes deposit** to designated bank account
3. **Uploads payment proof** with application
4. **Admin verifies** payment and documents
5. **Invitation sent** to user's email
6. **User activates** bidder account
7. **Can now bid** on auctions

## 🏗️ System Architecture

### Frontend
- **Laravel Blade Templates** with Tailwind CSS
- **Alpine.js** for interactive components
- **Real-time updates** via JavaScript
- **Responsive design** for mobile and desktop

### Backend
- **Laravel 11** PHP framework
- **MySQL** database
- **Spatie Permission** for role management
- **Backpack CRUD** for admin interface
- **Laravel Mail** for email notifications

### Key Models
- **User**: Authentication and role management
- **Auction**: Property auction details and settings
- **Bid**: Individual bids on auctions
- **Wallet**: User financial management
- **BidderApplication**: Application tracking
- **Invitation**: Admin-controlled invitations

## 📁 Project Structure

```
ubit-cursor-n1/
├── app/
│   ├── Http/Controllers/     # Application controllers
│   ├── Models/              # Eloquent models
│   ├── Mail/                # Email notifications
│   └── Providers/           # Service providers
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/            # Database seeders
│   └── factories/          # Model factories
├── resources/
│   ├── views/              # Blade templates
│   ├── css/                # Stylesheets
│   └── js/                 # JavaScript files
├── routes/                 # Application routes
├── config/                 # Configuration files
└── public/                 # Public assets
```

## 🔧 Configuration

### Auction Settings
Configure auction parameters in `config/auction.php`:
- Default deposit amounts
- Bid increments
- Timer settings
- Bank account details

### Email Configuration
Set up email settings in `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@sahilefirdaus.com
MAIL_FROM_NAME="Sahil e Firdaus Auctions"
```

## 🚀 Deployment

### Production Setup
1. **Set environment to production**
   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

2. **Optimize for production**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   composer install --optimize-autoloader --no-dev
   ```

3. **Set up web server** (Apache/Nginx) to point to `public/` directory

4. **Configure SSL certificate** for secure HTTPS access

5. **Set up database backups** and monitoring

## 🧪 Testing

Run the test suite:
```bash
php artisan test
```

## 📝 API Documentation

The system provides RESTful APIs for:
- User authentication
- Auction management
- Bidding operations
- User profile management

API documentation is available at `/api/documentation` when running in development mode.

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Submit a pull request

## 📄 License

This project is proprietary software for Sahil e Firdaus Auctions.

## 🆘 Support

For technical support or questions:
- **Email**: admin@sahilefirdaus.com
- **Documentation**: Check the `/docs` folder for detailed guides
- **Issues**: Report bugs through the issue tracker

## 🔄 Version History

### v1.0.0 (Current)
- Initial release
- Multi-role user system
- Real-time auction platform
- Payment verification system
- Admin management interface

---

**Built with ❤️ for Sahil e Firdaus Auctions**
