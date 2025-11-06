@extends('admin.layouts.master')
@section('title', 'Manage Loot Box Items')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <x-admin.alert />
                </div>
                
                <div class="col-12 mb-3">
                    <a href="{{ route('admin.lootbox.index') }}" class="btn btn-link">
                        ← Back to Loot Boxes
                    </a>
                </div>
                
                <!-- Add New Item Form -->
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Add Item to {{ $lootBoxType->name }}</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.lootbox.items.store', $lootBoxType->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="mb-3">
                                    <label class="form-label required">Item Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="$5 Cash" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label required">Type</label>
                                    <input type="text" name="type" class="form-control" placeholder="cash, bonus, cosmetic" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Value (USD)</label>
                                    <input type="number" name="value" class="form-control" step="0.01" min="0" placeholder="5.00">
                                    <small class="form-hint">For cash rewards</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label required">Rarity</label>
                                    <select name="rarity" class="form-select" required>
                                        <option value="common">Common (Gray)</option>
                                        <option value="uncommon">Uncommon (Green)</option>
                                        <option value="rare">Rare (Blue)</option>
                                        <option value="epic">Epic (Purple)</option>
                                        <option value="legendary">Legendary (Gold)</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label required">Drop Rate (%)</label>
                                    <input type="number" name="drop_rate" class="form-control" step="0.01" min="0" max="100" placeholder="25.00" required>
                                    <small class="form-hint">Total should equal 100%</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Item Image</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="2" placeholder="Win instant cash!"></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-check">
                                        <input type="checkbox" name="is_active" class="form-check-input" checked>
                                        <span class="form-check-label">Active</span>
                                    </label>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100">Add Item</button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <!-- Items List -->
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Items in {{ $lootBoxType->name }}</h3>
                            <div class="card-subtitle">
                                Total Drop Rate: <strong id="totalDropRate">{{ $items->sum('drop_rate') }}%</strong>
                                @if($items->sum('drop_rate') != 100)
                                    <span class="text-danger">(Should be 100%)</span>
                                @endif
                            </div>
                        </div>
                        <div class="card-body">
                            @if($items->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-vcenter">
                                        <thead>
                                            <tr>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Type</th>
                                                <th>Value</th>
                                                <th>Rarity</th>
                                                <th>Drop %</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($items as $item)
                                                <tr>
                                                    <td>
                                                        @if($item->image)
                                                            <img src="{{ asset($item->image) }}" width="40" height="40" class="rounded">
                                                        @else
                                                            <div style="width: 40px; height: 40px; background: #ddd; border-radius: 4px;"></div>
                                                        @endif
                                                    </td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ ucfirst($item->type) }}</td>
                                                    <td>{{ $item->value ? '$' . number_format($item->value, 2) : '-' }}</td>
                                                    <td>
                                                        <span class="badge bg-{{ 
                                                            $item->rarity == 'common' ? 'secondary' : 
                                                            ($item->rarity == 'uncommon' ? 'success' : 
                                                            ($item->rarity == 'rare' ? 'info' : 
                                                            ($item->rarity == 'epic' ? 'purple' : 'warning')))
                                                        }}">
                                                            {{ ucfirst($item->rarity) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $item->drop_rate }}%</td>
                                                    <td>
                                                        @if($item->is_active)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-secondary">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('admin.lootbox.items.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this item?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="empty">
                                    <p class="empty-title">No items yet</p>
                                    <p class="empty-subtitle text-muted">
                                        Add items using the form on the left
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

