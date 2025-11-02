@extends('admin.layouts.master')
@section('title', 'Add Gateway Items')
@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12 col-md-6">
                    <x-admin.alert />
                    <form method="POST" action="{{ route('admin.gateways.items.store', $withdrawalsCategory->id) }}">
                        @csrf
                        <div class="card">
                            <div class="card-header bg-dark-lt pt-2 pb-0">
                                <h4 class="text-dark">Add gift item</h4>
                            </div>
                            <div class="card-body pt-2 row">
                                <div class="col-12 col-md-6">
                                    <label class="form-label">Gift value</label>
                                    <input type="number" step="0.01" class="form-control" name="amount"
                                        placeholder="10" required>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label">Gift Description</label>
                                    <input type="text" class="form-control" name="description"
                                        placeholder="Describe the gift">
                                </div>

                                <div class="col-12 mt-3">
                                    <button type="submit" class="btn btn-primary w-100">Add this item</button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-header bg-dark-lt pt-2 pb-0">
                            <h4 class="text-dark">{{ $withdrawalsCategory->name }} items:</h4>
                        </div>
                        <div class="card-body border-bottom p-0">
                            <div class="table-responsive">
                                <table class="table card-table table-vcenter text-nowrap datatable">
                                    <thead>
                                        <tr>
                                            <th>Gift value</th>
                                            <th>Gift description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($withdrawalsSubCategories as $subcategory)
                                            <tr>
                                                <td>{{ $subcategory->amount }}</td>
                                                <td>{{ $subcategory->description }}</td>
                                                <td>
                                                    <form
                                                        action="{{ route('admin.gateways.items.delete', $subcategory->id) }}"
                                                        method="POST">
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
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
