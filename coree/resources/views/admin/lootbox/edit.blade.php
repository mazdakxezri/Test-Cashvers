@extends('admin.layouts.master')
@section('title', 'Edit Loot Box')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <x-admin.alert />
                </div>
                
                <div class="col-md-8">
                    <form action="{{ route('admin.lootbox.update', $lootBoxType->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Edit Loot Box: {{ $lootBoxType->name }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label required">Name</label>
                                    <input type="text" name="name" class="form-control" required value="{{ old('name', $lootBoxType->name) }}">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="3">{{ old('description', $lootBoxType->description) }}</textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Price (USD)</label>
                                        <input type="number" name="price_usd" class="form-control" step="0.01" min="0" required value="{{ old('price_usd', $lootBoxType->price_usd) }}">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Display Order</label>
                                        <input type="number" name="order" class="form-control" min="0" value="{{ old('order', $lootBoxType->order) }}">
                                    </div>
                                </div>
                                
                                @if($lootBoxType->image)
                                    <div class="mb-3">
                                        <label class="form-label">Current Image</label>
                                        <div>
                                            <img src="{{ asset($lootBoxType->image) }}" alt="{{ $lootBoxType->name }}" style="max-width: 200px; border-radius: 8px;">
                                        </div>
                                    </div>
                                @endif
                                
                                <div class="mb-3">
                                    <label class="form-label">Replace Image</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Purchase Options</label>
                                    <div>
                                        <label class="form-check">
                                            <input type="checkbox" name="can_buy_with_earnings" class="form-check-input" {{ old('can_buy_with_earnings', $lootBoxType->can_buy_with_earnings) ? 'checked' : '' }}>
                                            <span class="form-check-label">Can buy with earnings</span>
                                        </label>
                                        <label class="form-check">
                                            <input type="checkbox" name="can_buy_with_crypto" class="form-check-input" {{ old('can_buy_with_crypto', $lootBoxType->can_buy_with_crypto) ? 'checked' : '' }}>
                                            <span class="form-check-label">Can buy with crypto</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-check">
                                        <input type="checkbox" name="is_active" class="form-check-input" {{ old('is_active', $lootBoxType->is_active) ? 'checked' : '' }}>
                                        <span class="form-check-label">Active</span>
                                    </label>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <a href="{{ route('admin.lootbox.index') }}" class="btn btn-link">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Loot Box</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

