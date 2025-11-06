@extends('admin.layouts.master')
@section('title', 'Loot Box Management')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <x-admin.alert />
                </div>
                
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Loot Box Types</h3>
                            <div class="card-actions">
                                <a href="{{ route('admin.lootbox.create') }}" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="12" y1="5" x2="12" y2="19"></line>
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                    </svg>
                                    Create New Loot Box
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($lootBoxTypes->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Price</th>
                                                <th>Items</th>
                                                <th>Purchase Options</th>
                                                <th>Status</th>
                                                <th>Order</th>
                                                <th class="w-1">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($lootBoxTypes as $box)
                                                <tr>
                                                    <td>
                                                        @if($box->image)
                                                            <img src="{{ asset($box->image) }}" alt="{{ $box->name }}" width="50" height="50" class="rounded">
                                                        @else
                                                            <div style="width: 50px; height: 50px; background: #ddd; border-radius: 4px;"></div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <strong>{{ $box->name }}</strong>
                                                        <br><small class="text-muted">{{ $box->slug }}</small>
                                                    </td>
                                                    <td>${{ number_format($box->price_usd, 2) }}</td>
                                                    <td>
                                                        <a href="{{ route('admin.lootbox.items', $box->id) }}" class="badge bg-blue">
                                                            {{ $box->items->count() }} items
                                                        </a>
                                                    </td>
                                                    <td>
                                                        @if($box->can_buy_with_earnings)
                                                            <span class="badge bg-green">Earnings</span>
                                                        @endif
                                                        @if($box->can_buy_with_crypto)
                                                            <span class="badge bg-purple">Crypto</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($box->is_active)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $box->order }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('admin.lootbox.items', $box->id) }}" class="btn btn-sm btn-info" title="Manage Items">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                    <rect x="3" y="8" width="18" height="12" rx="2" ry="2"></rect>
                                                                    <path d="M12 8V3M8 3h8"></path>
                                                                </svg>
                                                            </a>
                                                            <a href="{{ route('admin.lootbox.edit', $box->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                                </svg>
                                                            </a>
                                                            <form action="{{ route('admin.lootbox.destroy', $box->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this loot box?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="empty">
                                    <div class="empty-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="8" width="18" height="12" rx="2" ry="2"></rect>
                                            <path d="M12 8V3M8 3h8"></path>
                                        </svg>
                                    </div>
                                    <p class="empty-title">No loot boxes yet</p>
                                    <p class="empty-subtitle text-muted">
                                        Create your first loot box to get started
                                    </p>
                                    <div class="empty-action">
                                        <a href="{{ route('admin.lootbox.create') }}" class="btn btn-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                            </svg>
                                            Create Loot Box
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

