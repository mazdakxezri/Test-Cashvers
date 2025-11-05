@extends('admin.layouts.app')
@section('title', 'Fraud Detection')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-header mb-4">
                <h2>🛡️ Fraud Detection Dashboard</h2>
                <p class="text-muted">Monitor suspicious activity and prevent fraud</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stats-card bg-danger">
                <div class="stats-icon">⚠️</div>
                <div class="stats-content">
                    <h3>{{ count($suspiciousUsers) }}</h3>
                    <p>Suspicious Users</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card bg-warning">
                <div class="stats-icon">🔁</div>
                <div class="stats-content">
                    <h3>{{ count($duplicateAddresses) }}</h3>
                    <p>Duplicate Addresses</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card bg-info">
                <div class="stats-icon">📱</div>
                <div class="stats-content">
                    <h3>{{ count($multipleAccounts) }}</h3>
                    <p>Multi-Account Devices</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card bg-primary">
                <div class="stats-icon">🔒</div>
                <div class="stats-content">
                    <h3>{{ count($vpnUsers) }}</h3>
                    <p>VPN Users</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Suspicious Users Table -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>⚠️ Suspicious Users (Multiple Countries/IPs/Devices)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Countries</th>
                            <th>IPs</th>
                            <th>Devices</th>
                            <th>Balance</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($suspiciousUsers as $user)
                        <tr>
                            <td><strong>{{ $user->uid }}</strong></td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td><span class="badge bg-danger">{{ $user->country_changes }}</span></td>
                            <td><span class="badge bg-warning">{{ $user->ip_changes }}</span></td>
                            <td><span class="badge bg-info">{{ $user->device_changes }}</span></td>
                            <td>${{ number_format($user->balance, 2) }}</td>
                            <td>
                                <a href="{{ route('admin.fraud.user.details', $user->id) }}" class="btn btn-sm btn-primary">
                                    View Details
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                ✅ No suspicious users found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Duplicate Withdrawal Addresses -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>🔁 Duplicate Withdrawal Addresses</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Wallet Address</th>
                            <th>User Count</th>
                            <th>User IDs</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($duplicateAddresses as $address)
                        <tr>
                            <td><code>{{ Str::limit($address->wallet_address, 30) }}</code></td>
                            <td><span class="badge bg-danger">{{ $address->user_count }} users</span></td>
                            <td>{{ $address->user_ids }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="investigateAddress('{{ $address->wallet_address }}')">
                                    Investigate
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                ✅ No duplicate addresses found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Multiple Accounts from Same Device -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>📱 Multiple Accounts from Same Device</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Device Fingerprint</th>
                            <th>Account Count</th>
                            <th>User IDs</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($multipleAccounts as $device)
                        <tr>
                            <td><code>{{ Str::limit($device->device_fingerprint, 30) }}</code></td>
                            <td><span class="badge bg-warning">{{ $device->user_count }} accounts</span></td>
                            <td>{{ $device->user_ids }}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" onclick="investigateDevice('{{ $device->device_fingerprint }}')">
                                    Investigate
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-4">
                                ✅ No multi-account devices found
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.stats-card {
    border-radius: 12px;
    padding: 24px;
    color: white;
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 20px;
}

.stats-icon {
    font-size: 48px;
}

.stats-content h3 {
    font-size: 32px;
    font-weight: 700;
    margin: 0;
}

.stats-content p {
    margin: 0;
    opacity: 0.9;
    font-size: 14px;
}

.card {
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    border-radius: 12px;
}

.card-header {
    background: #f8f9fa;
    border-bottom: 2px solid #e9ecef;
    padding: 16px 24px;
}

.card-header h5 {
    margin: 0;
    font-weight: 600;
}

code {
    background: #f1f3f5;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
}
</style>

<script>
function investigateAddress(address) {
    alert('Investigating wallet address: ' + address);
    // TODO: Implement investigation modal
}

function investigateDevice(fingerprint) {
    alert('Investigating device: ' + fingerprint);
    // TODO: Implement investigation modal
}
</script>
@endsection

