@extends('admin.layouts.app')
@section('title', 'User Fraud Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-header mb-4">
                <a href="{{ route('admin.fraud.index') }}" class="btn btn-secondary">← Back to Fraud Dashboard</a>
                <h2>User Fraud Analysis: {{ $user->name }}</h2>
            </div>
        </div>
    </div>

    <!-- Risk Score Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card risk-score-card @if($riskScore >= 70) bg-danger @elseif($riskScore >= 40) bg-warning @else bg-success @endif">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h3 class="mb-2">Risk Score</h3>
                            <p class="mb-0">Based on activity patterns and fraud indicators</p>
                        </div>
                        <div class="risk-score-display">
                            <div class="score-value">{{ $riskScore }}</div>
                            <div class="score-label">/100</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        @if($riskScore >= 70)
                            <strong>🚨 HIGH RISK</strong> - Immediate action recommended
                        @elseif($riskScore >= 40)
                            <strong>⚠️ MEDIUM RISK</strong> - Monitor closely
                        @else
                            <strong>✅ LOW RISK</strong> - Normal activity
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Info -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>👤 User Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>User ID:</th>
                            <td>{{ $user->uid }}</td>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Balance:</th>
                            <td><strong>${{ number_format($user->balance, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <th>Status:</th>
                            <td>
                                @if($user->status === 'active')
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Banned</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Registered:</th>
                            <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>📊 Activity Summary</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th>Unique Countries:</th>
                            <td><span class="badge bg-{{ $sessions->pluck('country_code')->unique()->count() > 2 ? 'danger' : 'success' }}">
                                {{ $sessions->pluck('country_code')->unique()->count() }}
                            </span></td>
                        </tr>
                        <tr>
                            <th>Unique IPs:</th>
                            <td><span class="badge bg-{{ $sessions->pluck('ip_address')->unique()->count() > 5 ? 'warning' : 'success' }}">
                                {{ $sessions->pluck('ip_address')->unique()->count() }}
                            </span></td>
                        </tr>
                        <tr>
                            <th>Unique Devices:</th>
                            <td><span class="badge bg-{{ $sessions->pluck('device_fingerprint')->unique()->count() > 2 ? 'danger' : 'success' }}">
                                {{ $sessions->pluck('device_fingerprint')->unique()->count() }}
                            </span></td>
                        </tr>
                        <tr>
                            <th>Total Sessions:</th>
                            <td>{{ $sessions->count() }}</td>
                        </tr>
                        <tr>
                            <th>Total Withdrawals:</th>
                            <td>{{ $withdrawals->count() }}</td>
                        </tr>
                        <tr>
                            <th>VPN Detected:</th>
                            <td>
                                @if($user->vpn_detected)
                                    <span class="badge bg-danger">Yes</span>
                                @else
                                    <span class="badge bg-success">No</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Session History -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>🌐 Login Session History</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date/Time</th>
                            <th>IP Address</th>
                            <th>Country</th>
                            <th>Timezone</th>
                            <th>Device</th>
                            <th>OS</th>
                            <th>Browser</th>
                            <th>Screen</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sessions as $session)
                        <tr>
                            <td>{{ $session->last_activity_at->format('M d, Y H:i') }}</td>
                            <td><code>{{ $session->ip_address }}</code></td>
                            <td>{{ $session->country_code }}</td>
                            <td>{{ $session->timezone }}</td>
                            <td>{{ $session->device_type }}</td>
                            <td>{{ $session->os }}</td>
                            <td>{{ $session->browser }}</td>
                            <td>{{ $session->screen_resolution }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Withdrawal History -->
    <div class="card">
        <div class="card-header">
            <h5>💰 Withdrawal History</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Method</th>
                            <th>Wallet Address</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($withdrawals as $withdrawal)
                        <tr>
                            <td>{{ $withdrawal->created_at->format('M d, Y H:i') }}</td>
                            <td>{{ $withdrawal->gateway->name ?? 'N/A' }}</td>
                            <td><code>{{ Str::limit($withdrawal->wallet_address ?? 'N/A', 40) }}</code></td>
                            <td>${{ number_format($withdrawal->withdraw_amount, 2) }}</td>
                            <td>
                                @if($withdrawal->status === 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($withdrawal->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-danger">{{ $withdrawal->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                No withdrawals yet
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
.risk-score-display {
    display: flex;
    align-items: baseline;
    gap: 4px;
}

.score-value {
    font-size: 72px;
    font-weight: 900;
    line-height: 1;
}

.score-label {
    font-size: 24px;
    opacity: 0.8;
}

.stats-card {
    border-radius: 12px;
    padding: 24px;
    color: white;
}

code {
    background: #f1f3f5;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    color: #495057;
}
</style>
@endsection

