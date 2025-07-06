@extends(backpack_view('blank'))

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Auction System Settings</h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.settings.update') }}">
                    @csrf
                    
                    <div class="row">
                        <!-- Deposit Settings -->
                        <div class="col-md-6">
                            <h4 class="mb-3">Deposit & Payment Settings</h4>
                            
                            <div class="form-group">
                                <label for="deposit_amount">Required Deposit Amount (PKR)</label>
                                <input type="number" 
                                       class="form-control @error('deposit_amount') is-invalid @enderror" 
                                       id="deposit_amount" 
                                       name="deposit_amount" 
                                       value="{{ old('deposit_amount', $settings['deposit_amount']) }}"
                                       min="1000" 
                                       step="1000">
                                @error('deposit_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Amount required from users to become a bidder</small>
                            </div>

                            <div class="form-group">
                                <label for="bank_name">Bank Name</label>
                                <input type="text" 
                                       class="form-control @error('bank_name') is-invalid @enderror" 
                                       id="bank_name" 
                                       name="bank_name" 
                                       value="{{ old('bank_name', $settings['bank_name']) }}"
                                       maxlength="100">
                                @error('bank_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="account_title">Account Title</label>
                                <input type="text" 
                                       class="form-control @error('account_title') is-invalid @enderror" 
                                       id="account_title" 
                                       name="account_title" 
                                       value="{{ old('account_title', $settings['account_title']) }}"
                                       maxlength="100">
                                @error('account_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="account_number">Account Number</label>
                                <input type="text" 
                                       class="form-control @error('account_number') is-invalid @enderror" 
                                       id="account_number" 
                                       name="account_number" 
                                       value="{{ old('account_number', $settings['account_number']) }}"
                                       maxlength="50">
                                @error('account_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Auction Settings -->
                        <div class="col-md-6">
                            <h4 class="mb-3">Auction Settings</h4>
                            
                            <div class="form-group">
                                <label for="default_bid_increment">Default Bid Increment (PKR)</label>
                                <input type="number" 
                                       class="form-control @error('default_bid_increment') is-invalid @enderror" 
                                       id="default_bid_increment" 
                                       name="default_bid_increment" 
                                       value="{{ old('default_bid_increment', $settings['default_bid_increment']) }}"
                                       min="1000" 
                                       step="1000">
                                @error('default_bid_increment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Minimum amount by which bids must increase</small>
                            </div>

                            <div class="form-group">
                                <label for="max_bid_amount">Maximum Bid Amount (PKR)</label>
                                <input type="number" 
                                       class="form-control @error('max_bid_amount') is-invalid @enderror" 
                                       id="max_bid_amount" 
                                       name="max_bid_amount" 
                                       value="{{ old('max_bid_amount', $settings['max_bid_amount']) }}"
                                       min="100000" 
                                       step="10000">
                                @error('max_bid_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Maximum allowed bid amount</small>
                            </div>

                            <div class="form-group">
                                <label for="application_review_time">Application Review Time (Hours)</label>
                                <input type="number" 
                                       class="form-control @error('application_review_time') is-invalid @enderror" 
                                       id="application_review_time" 
                                       name="application_review_time" 
                                       value="{{ old('application_review_time', $settings['application_review_time']) }}"
                                       min="1" 
                                       max="168">
                                @error('application_review_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Expected time to review bidder applications (1-168 hours)</small>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="la la-save"></i> Save Settings
                            </button>
                            <a href="{{ route('admin.settings.statistics') }}" class="btn btn-info">
                                <i class="la la-chart-bar"></i> View Statistics
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 