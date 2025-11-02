@extends('admin.layouts.master')

@section('title', 'Leaderboard Settings')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">

                <div class="col-12">
                    <x-admin.alert />
                </div>

                <div class="col-12">
                    <form action="{{ route('admin.leaderboard.store') }}" method="POST" class="card">
                        @csrf
                        <div class="card-header">
                            <h4 class="card-title">Leaderboard Settings</h4>
                        </div>

                        <div class="card-body">
                            <div class="row g-5">
                                <!-- Total Prize -->
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label">Total Prize (in $):</label>
                                        <input type="number" class="form-control" name="total_prize"
                                            value="{{ old('total_prize', $leaderboardSettings['total_prize'] ?? '') }}"
                                            required>
                                        @error('total_prize')
                                            <small class="text-red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Number of Users -->
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label">Number of Users in Leaderboard:</label>
                                        <input type="number" class="form-control" name="number_of_users"
                                            value="{{ old('number_of_users', $leaderboardSettings['number_of_users'] ?? '') }}"
                                            max="100" required>
                                        @error('number_of_users')
                                            <small class="text-red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Distribution Method -->
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label">Distribution Method:</label>
                                        <select class="form-select" name="distribution_method" required>
                                            <option value="linear"
                                                {{ old('distribution_method', $leaderboardSettings['distribution_method'] ?? '') == 'linear' ? 'selected' : '' }}>
                                                Linear</option>
                                            <option value="exponential"
                                                {{ old('distribution_method', $leaderboardSettings['distribution_method'] ?? '') == 'exponential' ? 'selected' : '' }}>
                                                Top Heavy</option>
                                        </select>
                                        @error('distribution_method')
                                            <small class="text-red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Leaderboard Status -->
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label">Leaderboard Status:</label>
                                        <select class="form-select" name="status" required>
                                            <option value="1"
                                                {{ old('status', $leaderboardSettings['status'] ?? '1') == '1' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="0"
                                                {{ old('status', $leaderboardSettings['status'] ?? '0') == '0' ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                        @error('status')
                                            <small class="text-red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Leaderboard Frequency -->
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label">Leaderboard Frequency:</label>
                                        <select class="form-select" name="duration" required>
                                            <option value="daily"
                                                {{ old('duration', $leaderboardSettings['duration'] ?? 'daily') == 'daily' ? 'selected' : '' }}>
                                                Daily</option>
                                            <option value="weekly"
                                                {{ old('duration', $leaderboardSettings['duration'] ?? 'daily') == 'weekly' ? 'selected' : '' }}>
                                                Weekly</option>
                                            <option value="monthly"
                                                {{ old('duration', $leaderboardSettings['duration'] ?? 'daily') == 'monthly' ? 'selected' : '' }}>
                                                Monthly</option>
                                        </select>
                                        @error('duration')
                                            <small class="text-red">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Top Ranks Prizes (Comma-Separated) -->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label">Top Ranks Prizes (Comma-Separated):</label>
                                        <input type="text" class="form-control" name="top_ranks_prizes"
                                            value="{{ old('top_ranks_prizes', isset($leaderboardSettings['top_ranks_prizes']) ? implode(', ', json_decode($leaderboardSettings['top_ranks_prizes'], true)) : '') }}">
                                        @error('top_ranks_prizes')
                                            <small class="text-red">{{ $message }}</small>
                                        @enderror
                                        <small class="text-muted">Enter the prize distribution for top ranks in a
                                            comma-separated format (e.g., 1,2,3)</small>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-dark">Save Leaderboard Settings</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
