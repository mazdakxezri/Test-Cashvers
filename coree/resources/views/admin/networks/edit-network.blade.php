@extends('admin.layouts.master')
@section('title', 'Edit Network')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">
                <div class="col-12">
                    <x-admin.alert />
                </div>
                <div class="card px-0">
                    <div class="col-12">

                        <div class="card-header bg-dark-lt h3 text-dark bold pt-2 pb-2">
                            <img src="{{ url($networkInfo->network_image) }}" class="rounded mx-2" width="40"
                                height="40" alt="{{ $networkInfo->network_name }}" />
                            Update {{ $networkInfo->network_name }}

                            <form action="{{ route('admin.network.delete', $networkInfo->id) }}" method="POST"
                                class="ms-auto">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete Network</button>
                            </form>

                        </div>

                        <div class="card-body">

                            <div class="alert alert-info bg-azure-lt text-black" role="alert">
                                <span class="fw-bold me-2 text-black">Allowed Macros:</span>
                                <span class="text-nowrap me-2 text-black">For User ID, use: <span
                                        class="text-danger">[uid]</span>
                                    please add it in the
                                    offerwall URL</span>
                            </div>
                            <form method="POST" action="{{ route('admin.network.update', $networkInfo->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Network name:</label>
                                        <input type="text" class="form-control" name="network_name"
                                            placeholder="Enter network name"
                                            value="{{ old('network_name', $networkInfo->network_name) }}" />

                                    </div>
                                    <div class="col col-lg-6 col-md-5 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Web offerwall URL:</label>
                                        <input type="text" class="form-control" name="offerwall_url"
                                            placeholder="Enter web offerwall URL"
                                            value="{{ old('offerwall_url', $networkInfo->offerwall_url) }}" />
                                    </div>

                                    <div class="col col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Offerwall description: <small class="text-info"> If
                                                Present</small></label>
                                        <input type="text" class="form-control" name="network_description"
                                            placeholder="Enter offerwall description" maxlength="10"
                                            value="{{ old('network_description', $networkInfo->network_description) }}" />
                                    </div>
                                    <div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-3">
                                        <div class="form-label">Network logo:</div>
                                        <input type="file" class="form-control" name="network_image" />
                                    </div>
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                        <label for="network-rating" class="form-label">Network Rating</label>
                                        <select id="network-rating" class="form-select" name="network_rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}"
                                                    {{ $i == $networkInfo->network_rating ? 'selected' : '' }}>
                                                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-3">
                                        <label for="network-level" class="form-label">Network Level</label>
                                        <select id="network-level" class="form-select" name="level_id">
                                            <option value="" {{ is_null($networkInfo->level_id) ? 'selected' : '' }}>
                                                No Level Required</option>
                                            @foreach ($levels as $level)
                                                <option value="{{ $level->id }}"
                                                    {{ $networkInfo->level_id == $level->id ? 'selected' : '' }}>
                                                    Level {{ $level->level }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-lg-2 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Select Offer Type</label>
                                        <div class="form-selectgroup">
                                            <label class="form-selectgroup-item text-no-wrap">
                                                <input type="radio" name="network_type" value="offer"
                                                    class="form-selectgroup-input"
                                                    {{ old('network_type', $networkInfo->network_type ?? 'offer') == 'offer' ? 'checked' : '' }} />
                                                <span class="form-selectgroup-label">Offers</span>
                                            </label>

                                            <label class="form-selectgroup-item">
                                                <input type="radio" name="network_type" value="survey"
                                                    class="form-selectgroup-input"
                                                    {{ old('network_type', $networkInfo->network_type ?? 'offer') == 'survey' ? 'checked' : '' }} />
                                                <span class="form-selectgroup-label">Surveys</span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Offerwall availability</label>
                                        <div class="form-selectgroup">
                                            <label class="form-selectgroup-item text-no-wrap">
                                                <input type="radio" name="network_status" value="1"
                                                    class="form-selectgroup-input"
                                                    {{ old('network_status', $networkInfo->network_status ?? '1') == '1' ? 'checked' : '' }} />
                                                <span class="form-selectgroup-label">Enable</span>
                                            </label>
                                            <label class="form-selectgroup-item">
                                                <input type="radio" name="network_status" value="0"
                                                    class="form-selectgroup-input"
                                                    {{ old('network_status', $networkInfo->network_status ?? '1') == '0' ? 'checked' : '' }} />
                                                <span class="form-selectgroup-label">Disable</span>
                                            </label>
                                        </div>
                                    </div>

                                </div>
                                <div class="hr-text mt-4 mb-3 text-blue hr-text-left bold">
                                    Postback Setup
                                </div>
                                <div class="row">
                                    <div class="col col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Postback method:</label>
                                        <div class="form-selectgroup">
                                            <label class="form-selectgroup-item text-no-wrap">
                                                <input type="radio" name="postback_method" value="GET"
                                                    class="form-selectgroup-input"
                                                    {{ old('postback_method', $networkInfo->postback_method ?? 'GET') == 'GET' ? 'checked' : '' }} />
                                                <span class="form-selectgroup-label">GET</span>
                                            </label>
                                            <label class="form-selectgroup-item">
                                                <input type="radio" name="postback_method" value="POST"
                                                    class="form-selectgroup-input"
                                                    {{ old('postback_method', $networkInfo->postback_method ?? 'GET') == 'POST' ? 'checked' : '' }} />
                                                <span class="form-selectgroup-label">POST</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Parameters visible in URL?</label>
                                        <div class="form-selectgroup">
                                            <label class="form-selectgroup-item text-no-wrap">
                                                <input type="radio" name="param_url_visibility" value="1"
                                                    class="form-selectgroup-input"
                                                    {{ old('param_url_visibility', $networkInfo->param_url_visibility ?? '1') == '1' ? 'checked' : '' }} />
                                                <span class="form-selectgroup-label">Visible</span>
                                            </label>
                                            <label class="form-selectgroup-item">
                                                <input type="radio" name="param_url_visibility" value="0"
                                                    class="form-selectgroup-input"
                                                    {{ old('param_url_visibility', $networkInfo->param_url_visibility ?? '1') == '0' ? 'checked' : '' }} />
                                                <span class="form-selectgroup-label">Hidden</span>
                                            </label>
                                        </div>
                                    </div>


                                    <div class="col col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Who will manage exchange rate?</label>
                                        <div class="form-selectgroup">
                                            <label class="form-selectgroup-item text-no-wrap">
                                                <input type="radio" name="postback_exchange" value="backend"
                                                    class="form-selectgroup-input" onclick="toggleExchangeRateInput(true)"
                                                    {{ !empty($networkInfo->param_custom_rate) ? 'checked' : '' }} />
                                                <span class="form-selectgroup-label">Backend</span>
                                            </label>
                                            <label class="form-selectgroup-item">
                                                <input type="radio" name="postback_exchange" value="adnetwork"
                                                    class="form-selectgroup-input"
                                                    onclick="toggleExchangeRateInput(false)"
                                                    {{ empty($networkInfo->param_custom_rate) ? 'checked' : '' }} />
                                                <span class="form-selectgroup-label">Ad Network</span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="col col-lg-3 col-md-4 col-sm-6 col-12 mb-3" id="exchangeRateInput"
                                        style="{{ old('postback_exchange') == 'backend' ? '' : 'display: none' }}">
                                        <label class="form-label">Custom Exchange Rate:</label>
                                        <input type="text" class="form-control" name="param_custom_rate"
                                            placeholder="0.5"
                                            value="{{ old('param_custom_rate', $networkInfo->param_custom_rate) }}" />
                                    </div>


                                    <div class="col col-lg-3 col-md-4 col-sm-6 col-12 mb-3" id="amountRate">
                                        <label class="form-label text-truncate">Parameter for <span
                                                class="text-dark bold">Reward Amount:</span></label>
                                        <input type="text" class="form-control" name="param_amount"
                                            placeholder="{amount}"
                                            value="{{ old('param_amount', $networkInfo->param_amount) }}" />
                                    </div>
                                    <div class="col col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label text-truncate">Parameter for <span
                                                class="text-dark bold">Payout Amount:</span><small class="text-info"> If
                                                Present</small></label>
                                        <input type="text" class="form-control" name="param_payout"
                                            placeholder="{payout}"
                                            value="{{ old('param_payout', $networkInfo->param_payout) }}" />
                                    </div>
                                    <div class="col col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Parameter for <span class="text-dark bold">User
                                                ID:</span></label>
                                        <input type="text" class="form-control" name="param_user_id"
                                            placeholder="{user_id}"
                                            value="{{ old('param_user_id', $networkInfo->param_user_id) }}" />
                                    </div>
                                    <div class="col col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Parameter for <span class="text-dark bold">Offer
                                                ID:</span><small class="text-info"> If
                                                Present</small></label>
                                        <input type="text" class="form-control" name="param_offer_id"
                                            placeholder="{of_id}"
                                            value="{{ old('param_offer_id', $networkInfo->param_offer_id) }}" />
                                    </div>

                                    <div class="col col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Parameter for <span class="text-dark bold">Offer
                                                Name:</span></label>
                                        <input type="text" class="form-control" name="param_offer_name"
                                            placeholder="{of_name}"
                                            value="{{ old('param_offer_name', $networkInfo->param_offer_name) }}" />
                                    </div>

                                    <div class="col col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Parameter for <span class="text-dark bold">Transaction
                                                ID:</span><small class="text-info"> If Present</small></label>
                                        <input type="text" class="form-control" name="param_tx_id"
                                            placeholder="{transaction}"
                                            value="{{ old('param_tx_id', $networkInfo->param_tx_id) }}" />
                                    </div>

                                    <div class="col col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Parameter for <span class="text-dark bold">IP
                                                address:</span><small class="text-danger"> Optional</small></label>
                                        <input type="text" class="form-control" name="param_ip" placeholder="{ip}"
                                            value="{{ old('param_ip', $networkInfo->param_ip) }}" />
                                    </div>

                                    <div class="col col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Parameter for <span class="text-dark bold">Country
                                                :</span><small class="text-danger"> Optional</small></label>
                                        <input type="text" class="form-control" name="param_country"
                                            placeholder="{country}"
                                            value="{{ old('param_country', $networkInfo->param_country) }}" />
                                    </div>

                                    <div class="col col-lg-3 col-md-4 col-sm-6 col-12 mb-3">
                                        <label class="form-label">Parameter for <span class="text-dark bold">Status
                                                :</span><small class="text-danger"> Optional</small></label>
                                        <input type="text" class="form-control" name="param_status"
                                            placeholder="{status}"
                                            value="{{ old('param_status', $networkInfo->param_status) }}" />
                                    </div>
                                </div>
                                <div class="d-flex flex-row-reverse mt-4">
                                    <button type="submit" class="btn btn-dark">Update Ad Network</button>
                                    <a href="{{ route('admin.networks.index') }}" class="btn btn-white me-4">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function toggleExchangeRateInput(show) {
            const exchangeRateInput = document.getElementById("exchangeRateInput");
            const amountRateInput = document.getElementById("amountRate");

            if (show) {
                exchangeRateInput.style.display = "block";
                amountRateInput.style.display = "none";
            } else {
                exchangeRateInput.style.display = "none";
                amountRateInput.style.display = "block";
            }
        }

        const adNetworkRadio = document.querySelector('input[name="postback_exchange"][value="adnetwork"]');
        toggleExchangeRateInput(!adNetworkRadio.checked);
    </script>
@endsection
