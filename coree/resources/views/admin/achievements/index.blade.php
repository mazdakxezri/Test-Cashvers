@extends('admin.layouts.app')

@section('page-title', 'Achievements Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0">Achievements</h3>
                    <div>
                        <form action="{{ route('admin.achievements.seed') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-info btn-sm" onclick="return confirm('This will seed 20 default achievements. Continue?')">
                                <i class="fas fa-seedling"></i> Seed Default Achievements
                            </button>
                        </form>
                        <a href="{{ route('admin.achievements.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Create Achievement
                        </a>
                    </div>
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
                                    <th>Icon</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Tier</th>
                                    <th>Points</th>
                                    <th>Reward</th>
                                    <th>Requirements</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($achievements as $achievement)
                                    <tr>
                                        <td style="font-size: 24px;">{{ $achievement->icon }}</td>
                                        <td>
                                            <strong>{{ $achievement->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $achievement->description }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ ucfirst($achievement->category) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge" style="background-color: {{ $achievement->tier_color }};">
                                                {{ $achievement->tier_icon }} {{ ucfirst($achievement->tier) }}
                                            </span>
                                        </td>
                                        <td>{{ $achievement->points }} pts</td>
                                        <td>${{ number_format($achievement->reward_amount, 2) }}</td>
                                        <td>
                                            <small>
                                                {{ $achievement->requirements['type'] ?? 'N/A' }}: 
                                                {{ $achievement->requirements['count'] ?? 'N/A' }}
                                            </small>
                                        </td>
                                        <td>
                                            @if($achievement->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">Inactive</span>
                                            @endif
                                            @if($achievement->is_hidden)
                                                <span class="badge bg-warning">Hidden</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.achievements.edit', $achievement) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.achievements.destroy', $achievement) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this achievement?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <p class="text-muted mb-3">No achievements yet.</p>
                                            <form action="{{ route('admin.achievements.seed') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-info">
                                                    <i class="fas fa-seedling"></i> Seed Default Achievements
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($achievements->hasPages())
                        <div class="mt-3">
                            {{ $achievements->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

