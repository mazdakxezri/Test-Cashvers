@extends('admin.layouts.master')
@section('title', 'Gateway')


@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">Gateway Setup</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-xl-4 col-md-5 col-sm-12">
                    <x-admin.alert />
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header bg-dark-lt pt-3 pb-2">
                                <h4 class="text-dark">Add Withdrawal Category</h4>
                            </div>
                            <div class="card-body pt-2 row">
                                <div class="mb-3">
                                    <label class="form-label">Gift category name</label>
                                    <input type="text" class="form-control" name="name" placeholder="Amazon Gift Card"
                                        value="{{ old('name') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Withdrawal Type</label>
                                    <select class="form-select" name="withdrawal_type">
                                        <option value="cash" {{ old('withdrawal_type') == 'cash' ? 'selected' : '' }}>
                                            Cash
                                        </option>
                                        <option value="gift_card"
                                            {{ old('withdrawal_type') == 'gift_card' ? 'selected' : '' }}>
                                            Gift Card
                                        </option>
                                        <option value="skins" {{ old('withdrawal_type') == 'skins' ? 'selected' : '' }}>
                                            Skins
                                        </option>
                                        <option value="crypto" {{ old('withdrawal_type') == 'crypto' ? 'selected' : '' }}>
                                            Crypto
                                        </option>
                                    </select>

                                    <small class="form-text text-muted">Please select the withdrawal type.</small>
                                </div>

                                <div class="mb-3">
                                    <div class="form-label">Item image</div>
                                    <input type="file" class="form-control" name="cover" accept="image/*">
                                </div>
                                
                                <div class="mb-3">
                                    <div class="form-label">Minimum {{siteSymbol()}}</div>
                                    <input
                                        type="number"
                                        class="form-control"
                                        id="minimum"
                                        name="minimum"
                                        step="0.01"
                                        min="0"
                                        required
                                        placeholder="Enter minimum {{ siteSymbol() }}"
                                    >
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Gift Background</label>
                                    <input type="text" class="form-control w-100" name="bg_color"
                                        placeholder="Enter your linear gradient CSS here">
                                    <small class="form-text text-muted">
                                        You can generate a linear gradient <a href="https://cssgradient.io/"
                                            target="_blank">here</a> and paste it.
                                    </small>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-dark">Add this item</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-8 col-md-7 col-sm-12">
                    <div class="row">
                        @foreach ($withdrawalsCategories as $categorie)
                            <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
                                <div class="card">
                                    <a href="{{ route('admin.gateways.items.add', $categorie->id) }}"
                                        class="d-block border-bottom" style="background: {{ $categorie->bg_color }}">
                                        <img src="{{ url($categorie->cover) }}" class="fixed-img-height w-100 card-img-top"
                                            style="max-height: 100%; height: 170px; object-fit: contain;">
                                    </a>
                                    <div class="card-body">
                                        <button class="btn btn-primary w-100 mb-2" data-bs-toggle="modal"
                                            data-bs-target="#modal-edit-{{ $categorie->id }}">
                                            Edit
                                        </button>
                                        <button class="btn btn-danger w-100" data-bs-toggle="modal"
                                            data-bs-target="#modal-delete-{{ $categorie->id }}">
                                            Delete
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal modal-blur fade" id="modal-edit-{{ $categorie->id }}" tabindex="-1"
                                role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit {{ $categorie->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <form method="post" action="{{ route('admin.gateways.update', $categorie->id) }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">

                                                <div class="mb-3">
                                                    <label class="form-label">Gift category name</label>
                                                    <input type="text" class="form-control" name="name"
                                                        placeholder="Amazon Gift Card"
                                                        value="{{ old('name', $categorie->name) }}">
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Withdrawal Type</label>
                                                    <select class="form-select" name="withdrawal_type">
                                                        <option value="cash"
                                                            {{ old('withdrawal_type', $categorie->withdrawal_type) == 'cash' ? 'selected' : '' }}>
                                                            Cash
                                                        </option>
                                                        <option value="gift_card"
                                                            {{ old('withdrawal_type', $categorie->withdrawal_type) == 'gift_card' ? 'selected' : '' }}>
                                                            Gift Card
                                                        </option>
                                                        <option value="skins"
                                                            {{ old('withdrawal_type', $categorie->withdrawal_type) == 'skins' ? 'selected' : '' }}>
                                                            Skins
                                                        </option>
                                                        <option value="crypto"
                                                            {{ old('withdrawal_type', $categorie->withdrawal_type) == 'crypto' ? 'selected' : '' }}>
                                                            Crypto
                                                        </option>
                                                    </select>

                                                </div>

                                                <div class="mb-3">
                                                    <div class="form-label">Item image</div>
                                                    <input type="file" class="form-control" name="cover"
                                                        accept="image/*">
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <div class="form-label">Minimum {{siteSymbol()}}</div>
                                                    <input
                                                        type="number"
                                                        class="form-control"
                                                        name="minimum"
                                                        step="0.01"
                                                        value="{{ old('minimum', $categorie->minimum) }}"
                                                        min="0"
                                                    >
                                                </div>
                                                <div class="mb-3">
                                                    <div class="form-label">Reward Image <span
                                                            class="text-red">(Optional)</span></div>
                                                    <input type="file" class="form-control" name="reward_img"
                                                        accept="image/*">
                                                    <small class="form-text text-muted">This image will be used for email
                                                        rewards.</small>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Gift Background</label>
                                                    <input type="text" class="form-control w-100" name="bg_color"
                                                        placeholder="Enter your linear gradient CSS here"
                                                        value="{{ $categorie->bg_color }}">
                                                    <small class="form-text text-muted">
                                                        You can generate a linear gradient <a
                                                            href="https://cssgradient.io/" target="_blank">here</a> and
                                                        paste it.
                                                    </small>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <a href="#" class="btn btn-link link-secondary"
                                                    data-bs-dismiss="modal">
                                                    Cancel
                                                </a>
                                                <button type="submit" class="btn btn-primary ms-auto">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                        height="24" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" fill="none" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M12 5v14" />
                                                        <path d="M5 12h14" />
                                                    </svg>
                                                    Update category
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal modal-blur fade" id="modal-delete-{{ $categorie->id }}" tabindex="-1"
                                role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        <div class="modal-status bg-danger"></div>
                                        <div class="modal-body text-center py-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                                                <path d="M12 9v4" />
                                                <path d="M12 17h.01" />
                                            </svg>
                                            <h3>Are you sure?</h3>
                                            <div class="text-secondary"> Do you really want to delete the
                                                {{ $categorie->name }} category and all related items?
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="w-100">
                                                <div class="row">
                                                    <div class="col">
                                                        <form method="post"
                                                            action="{{ route('admin.categories.destroy', $categorie->id) }}">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-danger w-100"
                                                                data-bs-dismiss="modal">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                    <div class="col"><a href="#" class="btn w-100"
                                                            data-bs-dismiss="modal">
                                                            Cancel
                                                        </a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
