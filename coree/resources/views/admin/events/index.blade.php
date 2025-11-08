@extends('admin.layouts.app')

@section('page-title', 'Events Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Events & Promotions</h3>
                    <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Create Event
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Bonus</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($events as $event)
                                    <tr>
                                        <td>
                                            <strong>{{ $event->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $event->description }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ str_replace('_', ' ', ucwords($event->event_type, '_')) }}</span>
                                        </td>
                                        <td>
                                            @if($event->event_type === 'bonus_multiplier')
                                                <span class="badge bg-warning">{{ $event->bonus_multiplier }}x</span>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $event->start_date->format('M d, Y H:i') }}</td>
                                        <td>{{ $event->end_date->format('M d, Y H:i') }}</td>
                                        <td>
                                            @if($event->isRunning())
                                                <span class="badge bg-success">🔴 Live</span>
                                            @elseif($event->start_date->isFuture())
                                                <span class="badge bg-info">⏳ Upcoming</span>
                                            @else
                                                <span class="badge bg-secondary">✅ Ended</span>
                                            @endif
                                            
                                            @if($event->show_banner)
                                                <span class="badge bg-primary">📢 Banner</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this event?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="text-muted mb-3">No events yet.</p>
                                            <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
                                                <i class="fas fa-plus"></i> Create Your First Event
                                            </a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($events->hasPages())
                        <div class="mt-3">
                            {{ $events->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

