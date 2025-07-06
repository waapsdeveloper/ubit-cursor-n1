@extends(backpack_view('blank'))

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="la la-chart-bar"></i> Admin Dashboard & Statistics
            </h1>
            <p class="text-muted">Comprehensive overview of system performance and bidder applications</p>
        </div>
    </div>

    <!-- Key Metrics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Applications
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stats['total_applications']) }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="la la-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Pending Actions
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $pendingActions['applications_to_verify'] + $pendingActions['applications_to_invite'] + $pendingActions['applications_to_approve'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="la la-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Revenue
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                PKR {{ number_format($stats['total_revenue']) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="la la-money-bill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Conversion Rate
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $systemHealth['conversion_rate'] }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="la la-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Application Status Overview -->
    <div class="row mb-4">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Application Status Overview</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="la la-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="applicationStatusChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="la la-circle text-warning"></i> Pending ({{ $applicationStats['pending'] }})
                        </span>
                        <span class="mr-2">
                            <i class="la la-circle text-info"></i> Payment Verified ({{ $applicationStats['payment_verified'] }})
                        </span>
                        <span class="mr-2">
                            <i class="la la-circle text-primary"></i> Invitation Sent ({{ $applicationStats['invitation_sent'] }})
                        </span>
                        <span class="mr-2">
                            <i class="la la-circle text-success"></i> Approved ({{ $applicationStats['approved'] }})
                        </span>
                        <span class="mr-2">
                            <i class="la la-circle text-danger"></i> Rejected ({{ $applicationStats['rejected'] }})
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Actions -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pending Actions</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-sm font-weight-bold">Payment Verification</span>
                            <span class="badge badge-warning">{{ $pendingActions['applications_to_verify'] }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: {{ $stats['total_applications'] > 0 ? ($pendingActions['applications_to_verify'] / $stats['total_applications']) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-sm font-weight-bold">Send Invitations</span>
                            <span class="badge badge-info">{{ $pendingActions['applications_to_invite'] }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-info" style="width: {{ $stats['total_applications'] > 0 ? ($pendingActions['applications_to_invite'] / $stats['total_applications']) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-sm font-weight-bold">Approve Applications</span>
                            <span class="badge badge-primary">{{ $pendingActions['applications_to_approve'] }}</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" style="width: {{ $stats['total_applications'] > 0 ? ($pendingActions['applications_to_approve'] / $stats['total_applications']) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ backpack_url('bidder-application') }}" class="btn btn-primary btn-sm">
                            <i class="la la-arrow-right"></i> Manage Applications
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Monthly Trends -->
    <div class="row mb-4">
        <!-- Recent Activity -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Activity (Last 7 Days)</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <div class="h4 text-primary">{{ $recentActivity['new_applications'] }}</div>
                                <div class="text-sm text-muted">New Applications</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <div class="h4 text-success">{{ $recentActivity['verified_payments'] }}</div>
                                <div class="text-sm text-muted">Payments Verified</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <div class="h4 text-info">{{ $recentActivity['sent_invitations'] }}</div>
                                <div class="text-sm text-muted">Invitations Sent</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <div class="h4 text-warning">{{ $recentActivity['approved_applications'] }}</div>
                                <div class="text-sm text-muted">Applications Approved</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <div class="h4 text-secondary">{{ $recentActivity['new_bidders'] }}</div>
                                <div class="text-sm text-muted">New Bidders</div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-center">
                                <div class="h4 text-dark">{{ $recentActivity['new_bids'] }}</div>
                                <div class="text-sm text-muted">New Bids</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Health -->
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">System Health Metrics</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-sm font-weight-bold">Avg Processing Time</span>
                            <span class="text-sm text-muted">{{ $systemHealth['avg_application_processing_time'] }} days</span>
                        </div>
                        <div class="progress mt-1" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: {{ min(($systemHealth['avg_application_processing_time'] / 7) * 100, 100) }}%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-sm font-weight-bold">Conversion Rate</span>
                            <span class="text-sm text-muted">{{ $systemHealth['conversion_rate'] }}%</span>
                        </div>
                        <div class="progress mt-1" style="height: 6px;">
                            <div class="progress-bar bg-info" style="width: {{ $systemHealth['conversion_rate'] }}%"></div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-sm font-weight-bold">Revenue per Application</span>
                            <span class="text-sm text-muted">PKR {{ number_format($systemHealth['revenue_per_application']) }}</span>
                        </div>
                        <div class="progress mt-1" style="height: 6px;">
                            <div class="progress-bar bg-warning" style="width: {{ min(($systemHealth['revenue_per_application'] / 50000) * 100, 100) }}%"></div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <div class="row">
                            <div class="col-6">
                                <div class="h5 text-primary">{{ $stats['total_users'] }}</div>
                                <div class="text-sm text-muted">Total Users</div>
                            </div>
                            <div class="col-6">
                                <div class="h5 text-success">{{ $stats['total_bidders'] }}</div>
                                <div class="text-sm text-muted">Active Bidders</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Trends Chart -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Trends (Last 6 Months)</h6>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="monthlyTrendsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ backpack_url('bidder-application') }}" class="btn btn-outline-primary btn-block">
                                <i class="la la-users"></i> Manage Applications
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ backpack_url('auction') }}" class="btn btn-outline-success btn-block">
                                <i class="la la-gavel"></i> Manage Auctions
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ backpack_url('user') }}" class="btn btn-outline-info btn-block">
                                <i class="la la-user"></i> Manage Users
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ backpack_url('settings') }}" class="btn btn-outline-warning btn-block">
                                <i class="la la-cog"></i> System Settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Application Status Chart
const applicationStatusCtx = document.getElementById('applicationStatusChart').getContext('2d');
new Chart(applicationStatusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Payment Verified', 'Invitation Sent', 'Approved', 'Rejected'],
        datasets: [{
            data: [
                {{ $applicationStats['pending'] }},
                {{ $applicationStats['payment_verified'] }},
                {{ $applicationStats['invitation_sent'] }},
                {{ $applicationStats['approved'] }},
                {{ $applicationStats['rejected'] }}
            ],
            backgroundColor: ['#f6c23e', '#36b9cc', '#4e73df', '#1cc88a', '#e74a3b'],
            borderWidth: 2,
            borderColor: '#fff'
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        cutout: '70%'
    }
});

// Monthly Trends Chart
const monthlyTrendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
new Chart(monthlyTrendsCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($monthlyTrends, 'month')) !!},
        datasets: [{
            label: 'Applications',
            data: {!! json_encode(array_column($monthlyTrends, 'applications')) !!},
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78, 115, 223, 0.1)',
            tension: 0.3,
            fill: true
        }, {
            label: 'Approved',
            data: {!! json_encode(array_column($monthlyTrends, 'approved')) !!},
            borderColor: '#1cc88a',
            backgroundColor: 'rgba(28, 200, 138, 0.1)',
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        }
    }
});
</script>
@endsection 