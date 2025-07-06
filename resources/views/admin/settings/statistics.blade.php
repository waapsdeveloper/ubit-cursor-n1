@extends(backpack_view('blank'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">System Statistics</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- User Statistics -->
                    <div class="col-md-6">
                        <h4 class="mb-3">User Statistics</h4>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="la la-users"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Users</span>
                                        <span class="info-box-number">{{ number_format($stats['total_users']) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="la la-user-check"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Verified Bidders</span>
                                        <span class="info-box-number">{{ number_format($stats['total_bidders']) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Application Statistics -->
                    <div class="col-md-6">
                        <h4 class="mb-3">Application Statistics</h4>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon"><i class="la la-file-alt"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Applications</span>
                                        <span class="info-box-number">{{ number_format($stats['total_applications']) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-box bg-danger">
                                    <span class="info-box-icon"><i class="la la-clock"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Pending Review</span>
                                        <span class="info-box-number">{{ number_format($stats['pending_applications']) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <!-- Auction Statistics -->
                    <div class="col-md-6">
                        <h4 class="mb-3">Auction Statistics</h4>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="info-box bg-primary">
                                    <span class="info-box-icon"><i class="la la-gavel"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Auctions</span>
                                        <span class="info-box-number">{{ number_format($stats['total_auctions']) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="la la-play"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Active Auctions</span>
                                        <span class="info-box-number">{{ number_format($stats['active_auctions']) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Financial Statistics -->
                    <div class="col-md-6">
                        <h4 class="mb-3">Financial Statistics</h4>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="la la-money-bill"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Bids</span>
                                        <span class="info-box-number">{{ number_format($stats['total_bids']) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="la la-bank"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Total Revenue</span>
                                        <span class="info-box-number">PKR {{ number_format($stats['total_revenue']) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <a href="{{ backpack_url('bidder-application') }}" class="btn btn-warning mr-2">
                                    <i class="la la-file-alt"></i> Review Applications
                                </a>
                                <a href="{{ backpack_url('auction') }}" class="btn btn-primary mr-2">
                                    <i class="la la-gavel"></i> Manage Auctions
                                </a>
                                <a href="{{ backpack_url('user') }}" class="btn btn-info mr-2">
                                    <i class="la la-users"></i> Manage Users
                                </a>
                                <a href="{{ route('admin.settings.index') }}" class="btn btn-secondary">
                                    <i class="la la-cog"></i> System Settings
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.info-box {
    display: block;
    min-height: 80px;
    background: #fff;
    width: 100%;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
    border-radius: 2px;
    margin-bottom: 15px;
}

.info-box-icon {
    border-top-left-radius: 2px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 2px;
    display: block;
    float: left;
    height: 80px;
    width: 80px;
    text-align: center;
    font-size: 40px;
    line-height: 80px;
    background: rgba(0,0,0,0.2);
}

.info-box-content {
    padding: 5px 10px;
    margin-left: 80px;
}

.info-box-text {
    display: block;
    font-size: 14px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.info-box-number {
    display: block;
    font-weight: bold;
    font-size: 18px;
}
</style>
@endsection 