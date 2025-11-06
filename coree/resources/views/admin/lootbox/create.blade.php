@extends('admin.layouts.master')
@section('title', 'Create Loot Box')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <x-admin.alert />
                </div>
                
                <div class="col-md-8">
                    <form action="{{ route('admin.lootbox.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Create New Loot Box</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label required">Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Bronze Box" required value="{{ old('name') }}">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="A basic loot box with common rewards">{{ old('description') }}</textarea>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label required">Price (USD)</label>
                                        <input type="number" name="price_usd" class="form-control" step="0.01" min="0" placeholder="1.00" required value="{{ old('price_usd') }}">
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Display Order</label>
                                        <input type="number" name="order" class="form-control" min="0" placeholder="0" value="{{ old('order', 0) }}">
                                        <small class="form-hint">Lower numbers appear first</small>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Box Image</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                    <small class="form-hint">Recommended: 500x500px, PNG or JPG</small>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Purchase Options</label>
                                    <div>
                                        <label class="form-check">
                                            <input type="checkbox" name="can_buy_with_earnings" class="form-check-input" {{ old('can_buy_with_earnings', true) ? 'checked' : '' }}>
                                            <span class="form-check-label">Can buy with earnings</span>
                                        </label>
                                        <label class="form-check">
                                            <input type="checkbox" name="can_buy_with_crypto" class="form-check-input" {{ old('can_buy_with_crypto', true) ? 'checked' : '' }}>
                                            <span class="form-check-label">Can buy with crypto</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-check">
                                        <input type="checkbox" name="is_active" class="form-check-input" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <span class="form-check-label">Active (visible to users)</span>
                                    </label>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <a href="{{ route('admin.lootbox.index') }}" class="btn btn-link">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create Loot Box</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

