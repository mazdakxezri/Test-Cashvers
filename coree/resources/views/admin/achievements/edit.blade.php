@extends('admin.layouts.app')

@section('page-title', 'Edit Achievement')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Edit Achievement: {{ $achievement->name }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.achievements.update', $achievement) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Achievement Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $achievement->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="2" required>{{ old('description', $achievement->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="icon" class="form-label">Icon (Emoji) *</label>
                                <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                       id="icon" name="icon" value="{{ old('icon', $achievement->icon) }}" maxlength="10" required>
                                <small class="text-muted">Use emoji like: 🎯 💰 🏆 ⭐ 🔥</small>
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category *</label>
                                <select class="form-select @error('category') is-invalid @enderror" 
                                        id="category" name="category" required>
                                    <option value="earning" {{ old('category', $achievement->category) == 'earning' ? 'selected' : '' }}>Earning</option>
                                    <option value="milestone" {{ old('category', $achievement->category) == 'milestone' ? 'selected' : '' }}>Milestone</option>
                                    <option value="social" {{ old('category', $achievement->category) == 'social' ? 'selected' : '' }}>Social</option>
                                    <option value="special" {{ old('category', $achievement->category) == 'special' ? 'selected' : '' }}>Special</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="tier" class="form-label">Tier *</label>
                                <select class="form-select @error('tier') is-invalid @enderror" 
                                        id="tier" name="tier" required>
                                    <option value="bronze" {{ old('tier', $achievement->tier) == 'bronze' ? 'selected' : '' }}>Bronze</option>
                                    <option value="silver" {{ old('tier', $achievement->tier) == 'silver' ? 'selected' : '' }}>Silver</option>
                                    <option value="gold" {{ old('tier', $achievement->tier) == 'gold' ? 'selected' : '' }}>Gold</option>
                                    <option value="platinum" {{ old('tier', $achievement->tier) == 'platinum' ? 'selected' : '' }}>Platinum</option>
                                    <option value="diamond" {{ old('tier', $achievement->tier) == 'diamond' ? 'selected' : '' }}>Diamond</option>
                                </select>
                                @error('tier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="points" class="form-label">Points *</label>
                                <input type="number" class="form-control @error('points') is-invalid @enderror" 
                                       id="points" name="points" value="{{ old('points', $achievement->points) }}" min="0" required>
                                @error('points')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="reward_amount" class="form-label">Reward Amount ($) *</label>
                                <input type="number" step="0.01" class="form-control @error('reward_amount') is-invalid @enderror" 
                                       id="reward_amount" name="reward_amount" value="{{ old('reward_amount', $achievement->reward_amount) }}" min="0" required>
                                @error('reward_amount')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="requirement_type" class="form-label">Requirement Type *</label>
                                <select class="form-select @error('requirement_type') is-invalid @enderror" 
                                        id="requirement_type" name="requirement_type" required>
                                    <option value="offers_completed" {{ old('requirement_type', $achievement->requirements['type'] ?? '') == 'offers_completed' ? 'selected' : '' }}>Offers Completed</option>
                                    <option value="total_earned" {{ old('requirement_type', $achievement->requirements['type'] ?? '') == 'total_earned' ? 'selected' : '' }}>Total Earned</option>
                                    <option value="daily_streak" {{ old('requirement_type', $achievement->requirements['type'] ?? '') == 'daily_streak' ? 'selected' : '' }}>Daily Streak</option>
                                    <option value="level_reached" {{ old('requirement_type', $achievement->requirements['type'] ?? '') == 'level_reached' ? 'selected' : '' }}>Level Reached</option>
                                    <option value="withdrawals_completed" {{ old('requirement_type', $achievement->requirements['type'] ?? '') == 'withdrawals_completed' ? 'selected' : '' }}>Withdrawals Completed</option>
                                    <option value="referrals" {{ old('requirement_type', $achievement->requirements['type'] ?? '') == 'referrals' ? 'selected' : '' }}>Referrals</option>
                                </select>
                                @error('requirement_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="requirement_count" class="form-label">Requirement Count *</label>
                                <input type="number" class="form-control @error('requirement_count') is-invalid @enderror" 
                                       id="requirement_count" name="requirement_count" value="{{ old('requirement_count', $achievement->requirements['count'] ?? 1) }}" min="1" required>
                                @error('requirement_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="order" class="form-label">Display Order</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                       id="order" name="order" value="{{ old('order', $achievement->order) }}" min="0">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ $achievement->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_hidden" name="is_hidden" {{ $achievement->is_hidden ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_hidden">Hidden (until unlocked)</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.achievements.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Achievement
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

