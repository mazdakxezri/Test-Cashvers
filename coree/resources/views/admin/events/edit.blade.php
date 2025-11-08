@extends('admin.layouts.app')

@section('page-title', 'Edit Event')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 offset-md-1">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Edit Event: {{ $event->name }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.events.update', $event) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Event Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $event->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="2" required>{{ old('description', $event->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="event_type" class="form-label">Event Type *</label>
                                <select class="form-select @error('event_type') is-invalid @enderror" 
                                        id="event_type" name="event_type" required>
                                    <option value="bonus_multiplier" {{ old('event_type', $event->event_type) == 'bonus_multiplier' ? 'selected' : '' }}>Bonus Multiplier</option>
                                    <option value="special_offers" {{ old('event_type', $event->event_type) == 'special_offers' ? 'selected' : '' }}>Special Offers</option>
                                    <option value="contest" {{ old('event_type', $event->event_type) == 'contest' ? 'selected' : '' }}>Contest</option>
                                    <option value="announcement" {{ old('event_type', $event->event_type) == 'announcement' ? 'selected' : '' }}>Announcement</option>
                                </select>
                                @error('event_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="banner_color" class="form-label">Banner Color *</label>
                                <input type="color" class="form-control form-control-color @error('banner_color') is-invalid @enderror" 
                                       id="banner_color" name="banner_color" value="{{ old('banner_color', $event->banner_color) }}" required>
                                @error('banner_color')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="bonus_multiplier" class="form-label">Bonus Multiplier</label>
                                <input type="number" step="0.01" class="form-control @error('bonus_multiplier') is-invalid @enderror" 
                                       id="bonus_multiplier" name="bonus_multiplier" value="{{ old('bonus_multiplier', $event->bonus_multiplier) }}" min="1" max="10">
                                @error('bonus_multiplier')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Start Date & Time *</label>
                                <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">End Date & Time *</label>
                                <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" name="end_date" value="{{ old('end_date', $event->end_date->format('Y-m-d\TH:i')) }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="priority" class="form-label">Priority</label>
                                <input type="number" class="form-control @error('priority') is-invalid @enderror" 
                                       id="priority" name="priority" value="{{ old('priority', $event->priority) }}" min="0">
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" {{ $event->is_active ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="show_banner" name="show_banner" {{ $event->show_banner ? 'checked' : '' }}>
                                <label class="form-check-label" for="show_banner">Show Banner on Dashboard</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="send_notification" name="send_notification" {{ $event->send_notification ? 'checked' : '' }}>
                                <label class="form-check-label" for="send_notification">Send Push Notification</label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

