@extends($activeTemplate . '.layouts.app')
@section('title', 'Profile')

@section('content')
    <div class="cosmic-bg">
        <div class="stars"></div>
        <div class="glow-orb glow-orb-blue" style="top: 20%; right: 10%;"></div>
        <div class="glow-orb glow-orb-purple" style="bottom: 40%; left: 15%;"></div>
    </div>

    <section class="section-space" style="padding-top: var(--space-3xl);">
        <div class="container-space">
            <!-- Profile Header Card -->
            <div class="profile-header-space">
                <div class="profile-avatar-space">
                    <img src="{{ asset('assets/' . $activeTemplate . '/images/avatars/' . (Auth::user()->gender === 'male' ? '1.png' : (Auth::user()->gender === 'female' ? '2.png' : '1.png'))) }}" 
                         alt="Avatar">
                </div>
                <div class="profile-info-space">
                    <h2>{{ Auth::user()->name }}</h2>
                    <div class="profile-meta">
                        <img src="{{ asset('assets/images/flags/' . strtolower(Auth::user()->country_code) . '.svg') }}" 
                             alt="Country" style="width: 20px; height: 20px; border-radius: 50%;">
                        <span>{{ getFullCountryName(Auth::user()->country_code) }}</span>
                    </div>
                </div>
                <form id="logout-form" action="{{ route('auth.logout') }}" method="POST" class="ms-auto">
                    @csrf
                    <button type="submit" class="btn-space-secondary btn-sm-space">Logout</button>
                </form>
            </div>

            <!-- Stats Grid -->
            <div class="grid-4" style="margin-top: var(--space-xl);">
                <div class="stat-card-space">
                    <div class="stat-value-space">{{ $offers_completed }}</div>
                    <div class="stat-label-space">Offers Completed</div>
                </div>
                <div class="stat-card-space">
                    <div class="stat-value-space">{{ siteSymbol() }}{{ number_format($total_earned, 2) }}</div>
                    <div class="stat-label-space">Total Earned</div>
                </div>
                <div class="stat-card-space">
                    <div class="stat-value-space">{{ $referred_count }}</div>
                    <div class="stat-label-space">Referrals</div>
                </div>
                <div class="stat-card-space">
                    <div class="stat-value-space">Lv.{{ Auth::user()->level }}</div>
                    <div class="stat-label-space">Current Level</div>
                </div>
            </div>

            <!-- Account Settings -->
            <div class="grid-2" style="margin-top: var(--space-xl);">
                <div class="card-float">
                    <h3 style="margin-bottom: var(--space-lg);">Account Settings</h3>
                    <form method="POST" action="{{ url('/profile') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group-space">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" class="input-space" required>
                        </div>
                        
                        <div class="form-group-space">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}" class="input-space" required>
                        </div>
                        
                        <div class="form-group-space">
                            <label class="form-label">Gender</label>
                            <select name="gender" class="input-space">
                                <option value="male" {{ Auth::user()->gender === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ Auth::user()->gender === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ Auth::user()->gender === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group-space">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ Auth::user()->date_of_birth }}" class="input-space">
                        </div>
                        
                        <button type="submit" class="btn-space-primary" style="width: 100%; margin-top: var(--space-md);">
                            Save Changes
                        </button>
                    </form>
                </div>

                <!-- Recent Activity -->
                <div class="card-float">
                    <h3 style="margin-bottom: var(--space-lg);">Recent Withdrawals</h3>
                    <div class="activity-list-space">
                        @forelse($withdrawals as $withdrawal)
                            <div class="activity-item-space">
                                <div>
                                    <div class="activity-title">{{ $withdrawal->category->name }}</div>
                                    <div class="activity-date">{{ $withdrawal->created_at->diffForHumans() }}</div>
                                </div>
                                <div class="activity-amount">{{ siteSymbol() }}{{ number_format($withdrawal->amount, 2) }}</div>
                                <span class="badge-space {{ 
                                    $withdrawal->status === 'completed' ? 'badge-success' : 
                                    ($withdrawal->status === 'pending' ? 'badge-warning' : 'badge-primary')
                                }}">
                                    {{ ucfirst($withdrawal->status) }}
                                </span>
                            </div>
                        @empty
                            <p class="text-body" style="text-align: center; color: var(--text-dim);">No withdrawals yet</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<style>
.profile-header-space {
    background: rgba(18, 18, 26, 0.5);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.06);
    border-radius: var(--radius-xl);
    padding: var(--space-xl);
    display: flex;
    align-items: center;
    gap: var(--space-lg);
}

.profile-avatar-space {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid var(--primary-glow);
    box-shadow: 0 0 30px rgba(0, 184, 212, 0.3);
}

.profile-avatar-space img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profile-info-space h2 {
    font-size: 28px;
    margin-bottom: var(--space-sm);
}

.profile-meta {
    display: flex;
    align-items: center;
    gap: var(--space-sm);
    color: var(--text-gray);
    font-size: 15px;
}

.form-group-space {
    margin-bottom: var(--space-lg);
}

.activity-list-space {
    display: flex;
    flex-direction: column;
    gap: var(--space-md);
}

.activity-item-space {
    display: flex;
    align-items: center;
    gap: var(--space-md);
    padding: var(--space-md);
    background: rgba(0, 0, 0, 0.2);
    border-radius: var(--radius-md);
    border: 1px solid rgba(255, 255, 255, 0.05);
}

.activity-title {
    font-size: 15px;
    font-weight: 600;
    color: var(--text-white);
    margin-bottom: 4px;
}

.activity-date {
    font-size: 12px;
    color: var(--text-dim);
}

.activity-amount {
    font-size: 18px;
    font-weight: 700;
    color: var(--primary-bright);
    margin-left: auto;
}

@media (max-width: 768px) {
    .profile-header-space {
        flex-direction: column;
        text-align: center;
    }
    
    .activity-item-space {
        flex-wrap: wrap;
    }
}
</style>

