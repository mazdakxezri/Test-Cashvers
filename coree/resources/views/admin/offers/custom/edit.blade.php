@extends('admin.layouts.master')
@section('title', 'Edit Custom Offer')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <x-admin.alert />
            </div>
            <div class="row row-cards">
                <div class="card px-0">
                    <div class="col-12">
                        <form method="POST" action="{{ route('admin.offers.custom.update', $offer->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-header bg-dark-lt h3 text-dark bold pt-2 pb-2">
                                Edit a Custom Offer
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info bg-azure-lt text-black" role="alert">
                                    <span class="fw-bold me-2 text-black">Allowed Macros:</span>
                                    <span class="text-nowrap me-2 text-black">For User ID, use: <span
                                            class="text-danger">[uid]</span>
                                        please add it in the
                                        offer URL</span>
                                </div>

                                <div class="row">
                                    <!-- Network Name (Input Text) -->
                                    <div class="col col-lg-6 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Network Name:</label>
                                        <input type="text" class="form-control" name="network_name"
                                            placeholder="Enter network name"
                                            value="{{ old('network_name', $offer->partner) }}" required />
                                        @error('network_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Custom Offer Name -->
                                    <div class="col col-lg-6 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Custom Offer Name:</label>
                                        <input type="text" class="form-control" name="custom_offer_name"
                                            placeholder="Enter custom offer name"
                                            value="{{ old('custom_offer_name', $offer->name) }}" required />
                                        @error('custom_offer_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Offer Country -->
                                    <div class="col col-lg-6 col-md-4 col-sm-6 col-12 mb-3">
                                        <div class="form-label">Select Country</div>
                                        <select name="country[]" class="form-select" id="select-countries" multiple
                                            required>
                                            @foreach ($countries as $code => $name)
                                                <option value="{{ $code }}"
                                                    {{ in_array($code, old('country', $selectedCountries)) ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('country')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>



                                    <!-- Custom Offer Image -->
                                    <div class="col col-lg-6 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Custom Offer Image:</label>
                                        <input type="file" class="form-control" name="custom_offer_image"
                                            accept="image/*" />
                                        <small>Leave blank if you don't want to change the image.</small>
                                        @error('custom_offer_image')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Custom Offer Payout -->
                                    <div class="col col-lg-6 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Custom Offer Payout:</label>
                                        <input type="number" class="form-control" name="custom_offer_payout"
                                            placeholder="Enter custom offer payout" step="0.01"
                                            value="{{ old('custom_offer_payout', $offer->payout) }}" required />
                                        @error('custom_offer_payout')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Offer ID -->
                                    <div class="col col-lg-6 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Offer ID:</label>
                                        <input type="text" class="form-control" name="offer_id"
                                            placeholder="Enter offer ID" value="{{ old('offer_id', $offer->offer_id) }}"
                                            required />
                                        @error('offer_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Offer Requirement -->
                                    <div class="col col-lg-6 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Offer Requirement:</label>
                                        <textarea class="form-control" name="offer_requirement" data-bs-toggle="autosize"
                                            placeholder="Outline requirements for the offer"
                                            style="overflow: hidden; overflow-wrap: break-word; resize: none; text-align: start; height: 100px;">{{ old('offer_requirement', $offer->requirements) }}</textarea>
                                        @error('offer_requirement')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Custom Offer Description -->
                                    <div class="col col-lg-6 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Custom Offer Description:</label>
                                        <textarea class="form-control" name="custom_offer_description" data-bs-toggle="autosize"
                                            placeholder="Enter custom offer description"
                                            style="overflow: hidden; overflow-wrap: break-word; resize: none; text-align: start; height: 100px;">{{ old('custom_offer_description', $offer->description) }}</textarea>
                                        @error('custom_offer_description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Offer Device -->
                                    <div class="col col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Offer Device:</label>
                                        <select class="form-select" name="offer_device" required>
                                            <option value="all"
                                                {{ old('offer_device', $offer->device) == 'all' ? 'selected' : '' }}>
                                                All
                                            </option>
                                            <option value="android"
                                                {{ old('offer_device', $offer->device) == 'android' ? 'selected' : '' }}>
                                                Android
                                            </option>
                                            <option value="ios"
                                                {{ old('offer_device', $offer->device) == 'ios' ? 'selected' : '' }}>
                                                iOS
                                            </option>
                                            <option value="desktop"
                                                {{ old('offer_device', $offer->device) == 'desktop' ? 'selected' : '' }}>
                                                Desktop
                                            </option>
                                        </select>
                                        @error('offer_device')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>


                                    <div class="col col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Offer Link:</label>
                                        <input type="url" class="form-control" name="custom_offer_link"
                                            placeholder="Enter offer Link"
                                            value="{{ old('custom_offer_link', $offer->link) }}" required />
                                        @error('custom_offer_link')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Status (Enabled/Disabled) -->
                                    <div class="col col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Status:</label>
                                        <div class="form-selectgroup">
                                            <label class="form-selectgroup-item">
                                                <input type="radio" name="status" value="1"
                                                    class="form-selectgroup-input"
                                                    {{ old('status', $offer->status) == '1' ? 'checked' : '' }} />
                                                <span class="form-selectgroup-label">Enabled</span>
                                            </label>
                                            <label class="form-selectgroup-item">
                                                <input type="radio" name="status" value="0"
                                                    class="form-selectgroup-input"
                                                    {{ old('status', $offer->status) == '0' ? 'checked' : '' }} />
                                                <span class="form-selectgroup-label">Disabled</span>
                                            </label>
                                        </div>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer text-end">
                                    <button type="submit" class="btn btn-primary">Update Custom Offer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/panel/dist/libs/tom-select/dist/js/tom-select.base.min.js') }}" defer></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var el;
            window.TomSelect && (new TomSelect(el = document.getElementById('select-countries'), {
                copyClassesToDropdown: false,
                dropdownParent: 'body',
                controlInput: '<input>',
                render: {
                    item: function(data, escape) {
                        if (data.customProperties) {
                            return '<div><span class="dropdown-item-indicator">' + data
                                .customProperties + '</span>' + escape(data.text) + '</div>';
                        }
                        return '<div>' + escape(data.text) + '</div>';
                    }
                }
            }));
        });
    </script>
@endsection
