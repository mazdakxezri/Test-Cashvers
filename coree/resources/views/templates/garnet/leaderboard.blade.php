@extends($activeTemplate . '.layouts.app')
@section('title', 'Leaderboard')

@section('content')
    <section class="cover leaderboard text-center px-3 px-xl-4 mb-3">
        <div class="classment mb-3 mt-5">
            <h2 class="text-capitalize">{{ $duration }} Leaderboard</h2>
            <p>{{ fmod($totalPrizePool, 1) === 0.0 ? (int) $totalPrizePool : number_format($totalPrizePool, 2) }}{{ siteSymbol() }}
                Leaderboard</p>
        </div>
        @if ($users->count() >= 3)
            <div class="row justify-content-center align-items-center mb-5">
                <!-- First Place -->
                <div class="col-auto mb-4 mb-md-0">
                    <div class="leaderboard-card first-place text-center">
                        <div class="position-tag">#1</div>
                        <div class="container-place">
                            <img src="{{ $users[0]->avatar ?? asset('assets/' . $activeTemplate . '/images/avatars/' . (Auth::user()->gender === 'male' ? '1.png' : (Auth::user()->gender === 'female' ? '2.png' : '1.png'))) }}"
                                alt="Profile Image" class="profile-img" />

                            <h5 class="username">{{ $users[0]->name }}</h5>
                            <img src="assets/images/icons/trophy.svg" class="img-fluid my-2" alt="" />
                            <p class="earned">Earned {{ number_format($users[0]->total_reward, 2) . " " . siteSymbol() }}</p>
                        </div>
                        <div class="prize">
                            <p class="mb-0">Prize {{ number_format($potentialPrizes[$users[0]->uid] ?? 0, 2) . " " . siteSymbol() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Second Place -->
                <div class="col-auto">
                    <div class="leaderboard-card second-place text-center">
                        <div class="position-tag">#2</div>
                        <div class="container-place">
                            <img src="{{ $users[1]->avatar ?? asset('assets/' . $activeTemplate . '/images/avatars/' . (Auth::user()->gender === 'male' ? '1.png' : (Auth::user()->gender === 'female' ? '2.png' : '1.png'))) }}"
                                alt="Profile Image" class="profile-img" />

                            <h5 class="username pb-3">{{ $users[1]->name }}</h5>
                            <p class="earned">Earned {{ number_format($users[1]->total_reward, 2) }}$</p>
                        </div>
                        <div class="prize">
                            <p class="mb-0">Prize {{ number_format($potentialPrizes[$users[1]->uid] ?? 0, 2) . " " . siteSymbol() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Third Place -->
                <div class="col-auto">
                    <div class="leaderboard-card third-place text-center">
                        <div class="position-tag">#3</div>
                        <div class="container-place">
                            <img src="{{ $users[2]->avatar ?? asset('assets/' . $activeTemplate . '/images/avatars/' . (Auth::user()->gender === 'male' ? '1.png' : (Auth::user()->gender === 'female' ? '2.png' : '1.png'))) }}"
                                alt="Profile Image" class="profile-img" />

                            <h5 class="username pb-2">{{ $users[2]->name }}</h5>
                            <p class="earned">Earned {{ number_format($users[2]->total_reward, 2) }}$</p>
                        </div>
                        <div class="prize">
                            <p class="mb-0">Prize {{ number_format($potentialPrizes[$users[2]->uid] ?? 0, 2) . " " . siteSymbol() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="leaderboard-container">
                <div class="leaderboard-table-header">
                    <div class="earn-info">
                        <h2 class="mb-0">You Earn <span>{{ $earnedToday . " " . siteSymbol() }}</span> Today</h2>
                    </div>
                    <div class="reset-info">
                        <span class="text-danger"><span id="countdown"></span></span>
                    </div>
                </div>
                <table class="leaderboard-table text-center">
                    <thead>
                        <tr>
                            <th>Rank</th>
                            <th>Name</th>
                            <th>Earned</th>
                            <th>Prize</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center">No data to show</td>
                            </tr>
                        @else
                            @foreach ($users as $index => $user)
                                <tr class="fs-14">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ number_format($user->total_reward, 2) . " " . siteSymbol() }}</td>
                                    <td>{{ number_format($potentialPrizes[$user->uid] ?? 0, 2) . " " . siteSymbol() }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>

                </table>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        const countdownElement = document.getElementById('countdown');
        const timeLeft = "{{ $timeLeft }}";

        let [days, hours, minutes, seconds] = timeLeft.split(':').map(Number);
        let totalSeconds = (days * 86400) + (hours * 3600) + (minutes * 60) + seconds;

        const updateCountdown = () => {
            const d = Math.floor(totalSeconds / 86400);
            const h = Math.floor((totalSeconds % 86400) / 3600);
            const m = Math.floor((totalSeconds % 3600) / 60);
            const s = totalSeconds % 60;

            countdownElement.textContent = `Resets in: ${d}d ${h}h ${m}m ${s}s`;

            if (totalSeconds-- <= 0) {
                clearInterval(countdownInterval);
                countdownElement.textContent = "Resets in: 0d 0h 0m 0s";
                location.reload();
            }
        };

        const countdownInterval = setInterval(updateCountdown, 1000);
        updateCountdown();
    </script>

@endsection
