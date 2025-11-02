@extends('admin.layouts.master')
@section('title', 'API Offerwalls')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards mb-3">
                <div class="col-12">
                    <x-admin.alert />
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header pt-2 pb-0">
                            <span class="h4 nav-link active fw-bold">API Offerwalls Management</span>
                        </div>
                        <div class="card-body row mt-2 pb-5">

                            <form method="post">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label required">OGads API Key</label>
                                            <input type="text" class="form-control" name="ogads_api_key"
                                                placeholder="Enter OGads API Key"
                                                value="{{ old('ogads_api_key', $settingsData['ogads_api_key'] ?? '') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label required">OGads Rate</label>
                                            <input type="text" class="form-control" name="ogads_rate"
                                                placeholder="Enter OGads Rate"
                                                value="{{ old('ogads_rate', $settingsData['ogads_rate'] ?? '') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label required">OGads Status</label>
                                            <select class="form-select" name="ogads_status_enabled" required>
                                                <option value="1"
                                                    {{ old('ogads_status_enabled', $settingsData['ogads_status_enabled'] ?? '') == '1' ? 'selected' : '' }}>
                                                    Enable
                                                </option>
                                                <option value="0"
                                                    {{ old('ogads_status_enabled', $settingsData['ogads_status_enabled'] ?? '') == '0' ? 'selected' : '' }}>
                                                    Disable
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label required">AdGate Media API Key</label>
                                                <input type="text" class="form-control" name="adgate_api_key"
                                                    placeholder="Enter AdGate Media API Key"
                                                    value="{{ old('adgate_api_key', $settingsData['adgate_api_key'] ?? '') }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label required">AdGate Media Wall Code</label>
                                                <input type="text" class="form-control" name="adgate_wall"
                                                    placeholder="Enter AdGate Media Wall Code"
                                                    value="{{ old('adgate_wall', $settingsData['adgate_wall'] ?? '') }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label required">AdGate Media Affiliate ID</label>
                                                <input type="text" class="form-control" name="adgate_affiliate_id"
                                                    placeholder="Enter AdGate Media Affiliate ID"
                                                    value="{{ old('adgate_affiliate_id', $settingsData['adgate_affiliate_id'] ?? '') }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label required">AdGate Media Rate</label>
                                                <input type="text" class="form-control" name="adgate_rate"
                                                    placeholder="Enter AdGate Media Rate"
                                                    value="{{ old('adgate_rate', $settingsData['adgate_rate'] ?? '') }}">
                                            </div>

                                            <div class="col-12 mb-3">
                                                <label class="form-label required">AdGate Media Status</label>
                                                <select class="form-select" name="adgate_status_enabled" required>
                                                    <option value="1"
                                                        {{ old('adgate_status_enabled', $settingsData['adgate_status_enabled'] ?? '') == '1' ? 'selected' : '' }}>
                                                        Enable
                                                    </option>
                                                    <option value="0"
                                                        {{ old('adgate_status_enabled', $settingsData['adgate_status_enabled'] ?? '') == '0' ? 'selected' : '' }}>
                                                        Disable
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label required">Torox App ID</label>
                                                <input type="text" class="form-control" name="torox_appid"
                                                    placeholder="Enter Torox App ID"
                                                    value="{{ old('torox_appid', $settingsData['torox_appid'] ?? '') }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label required">Torox Pub ID</label>
                                                <input type="text" class="form-control" name="torox_pubid"
                                                    placeholder="Enter Torox Pub ID"
                                                    value="{{ old('torox_pubid', $settingsData['torox_pubid'] ?? '') }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label required">Torox Secret Key</label>
                                                <input type="text" class="form-control" name="torox_key"
                                                    placeholder="Enter Secret Key"
                                                    value="{{ old('torox_key', $settingsData['torox_key'] ?? '') }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label required">Torox Rate</label>
                                                <input type="text" class="form-control" name="torox_rate"
                                                    placeholder="Enter Torox Rate"
                                                    value="{{ old('torox_rate', $settingsData['torox_rate'] ?? '') }}">
                                            </div>

                                            <div class="col-12 mb-3">
                                                <label class="form-label required">Torox Status</label>
                                                <select class="form-select" name="torox_status" required>
                                                    <option value="1"
                                                        {{ old('torox_status', $settingsData['torox_status'] ?? '') == '1' ? 'selected' : '' }}>
                                                        Enable
                                                    </option>
                                                    <option value="0"
                                                        {{ old('torox_status', $settingsData['torox_status'] ?? '') == '0' ? 'selected' : '' }}>
                                                        Disable
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label required">HangMyAds Network ID</label>
                                                <input type="text" class="form-control" name="hangmyads_network_id"
                                                    placeholder="Enter HangMyAds Network ID"
                                                    value="{{ old('hangmyads_network_id', $settingsData['hangmyads_network_id'] ?? '') }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label required">HangMyAds API Token</label>
                                                <input type="text" class="form-control" name="hangmyads_api"
                                                    placeholder="Enter HangMyAds API Token"
                                                    value="{{ old('hangmyads_api', $settingsData['hangmyads_api'] ?? '') }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label required">HangMyAds Rate</label>
                                                <input type="text" class="form-control" name="hangmyads_rate"
                                                    placeholder="Enter HangMyAds Rate"
                                                    value="{{ old('hangmyads_rate', $settingsData['hangmyads_rate'] ?? '') }}">
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label required">HangMyAds Status</label>
                                                <select class="form-select" name="hangmyads_status_enabled" required>
                                                    <option value="1"
                                                        {{ old('hangmyads_status_enabled', $settingsData['hangmyads_status_enabled'] ?? '') == '1' ? 'selected' : '' }}>
                                                        Enable
                                                    </option>
                                                    <option value="0"
                                                        {{ old('hangmyads_status_enabled', $settingsData['hangmyads_status_enabled'] ?? '') == '0' ? 'selected' : '' }}>
                                                        Disable
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row row-cards">
                <div class="col-6">
                    <!-- Ogads Postbacks Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h2 class="card-title">Ogads Postbacks</h2>
                        </div>
                        <div class="card-body">
                            <p>
                                {{ route('api.postback.callback', ['network_name' => 'ogads', 'secret_key' => 'qK8pR5vZ2yX9']) . '?payout={payout}&of_name={offer_name}&of_id={offer_id}&uid={aff_sub5}&ip={session_ip}' }}
                            </p>

                            <small class="text-red">Copy this link for your Ogads account postbacks.</small>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <!-- Adgate Media Postbacks Card -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h2 class="card-title">Adgate Media Postbacks</h2>
                        </div>
                        <div class="card-body">
                            <p>
                                {{ route('api.postback.callback', ['network_name' => 'adgatemedia', 'secret_key' => 'mN3&cW6zQ1lV8']) . '?payout={payout}&of_name={offer_name}&of_id={offer_id}&uid={s1}&ip={session_ip}&country={country}&status={state}&tx_id={conversion_id}' }}
                            </p>

                            <small class="text-red">Copy this link for your Adgate Media account postbacks.</small>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <!-- Torox Postbacks -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h2 class="card-title">Torox Postbacks</h2>
                        </div>
                        <div class="card-body">
                            <p>
                                {{ route('api.postback.callback', ['network_name' => 'torox', 'secret_key' => 'oIneMzO9v0hUmV']) . '?payout={payout}&of_name={o_name}&of_id={oid}&uid={user_id}&ip={ip_address}' }}
                            </p>

                            <small class="text-red">Copy this link for your Torox account postbacks.</small>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <!-- HangMyAds Postbacks -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h2 class="card-title">HangMyAds Postbacks</h2>
                        </div>
                        <div class="card-body">
                            <p>
                                {{ route('api.postback.callback', ['network_name' => 'hangmyads', 'secret_key' => 'hM7xR2kP9nY5']) . '?payout={pay}&of_name={offer_name}&of_id={offerid}&uid={sub_id}&ip={ip}&tx_id={convid}' }}
                            </p>

                            <small class="text-red">Copy this link for your HangMyAds account postbacks.</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection
