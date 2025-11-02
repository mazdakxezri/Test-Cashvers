@extends('admin.layouts.master')

@section('title', 'Fraud Protection')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    <x-admin.alert />
                </div>
                <div class="col-12">

                    <form class="card" method="POST" action="{{ route('admin.frauds.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="card-header bg-blue-lt pt-3 pb-2">
                            <h4 class="text-dark">Fraud Protection</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mt-2">
                                <!-- Email Verification -->
                                <div class="col-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Email Verification?</label>
                                        <div class="form-selectgroup">
                                            <label class="form-selectgroup-item text-no-wrap">
                                                <input type="radio" name="email_verification_enabled" value="1"
                                                    class="form-selectgroup-input"
                                                    {{ isset($settingsFraud['email_verification_enabled']) && $settingsFraud['email_verification_enabled'] == '1' ? 'checked' : '' }}>
                                                <span class="form-selectgroup-label">Yes</span>
                                            </label>
                                            <label class="form-selectgroup-item">
                                                <input type="radio" name="email_verification_enabled" value="0"
                                                    class="form-selectgroup-input"
                                                    {{ isset($settingsFraud['email_verification_enabled']) && $settingsFraud['email_verification_enabled'] == '0' ? 'checked' : '' }}>
                                                <span class="form-selectgroup-label">No</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Registration -->
                                <div class="col-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Allow Registration?</label>
                                        <div class="form-selectgroup">
                                            <label class="form-selectgroup-item text-no-wrap">
                                                <input type="radio" name="registration_enabled" value="1"
                                                    class="form-selectgroup-input"
                                                    {{ isset($settingsFraud['registration_enabled']) && $settingsFraud['registration_enabled'] == '1' ? 'checked' : '' }}>
                                                <span class="form-selectgroup-label">Yes</span>
                                            </label>
                                            <label class="form-selectgroup-item">
                                                <input type="radio" name="registration_enabled" value="0"
                                                    class="form-selectgroup-input"
                                                    {{ isset($settingsFraud['registration_enabled']) && $settingsFraud['registration_enabled'] == '0' ? 'checked' : '' }}>
                                                <span class="form-selectgroup-label">No</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Ban VPN -->
                                <div class="col-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Auto Ban VPN?</label>
                                        <div class="form-selectgroup">
                                            <label class="form-selectgroup-item text-no-wrap">
                                                <input type="radio" name="vpn_ban_enabled" value="1"
                                                    class="form-selectgroup-input"
                                                    {{ isset($settingsFraud['vpn_ban_enabled']) && $settingsFraud['vpn_ban_enabled'] == '1' ? 'checked' : '' }}>
                                                <span class="form-selectgroup-label">Yes</span>
                                            </label>
                                            <label class="form-selectgroup-item">
                                                <input type="radio" name="vpn_ban_enabled" value="0"
                                                    class="form-selectgroup-input"
                                                    {{ isset($settingsFraud['vpn_ban_enabled']) && $settingsFraud['vpn_ban_enabled'] == '0' ? 'checked' : '' }}>
                                                <span class="form-selectgroup-label">No</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Ban Country Change -->
                                <div class="col-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Ban Country Switch?</label>
                                        <div class="form-selectgroup">
                                            <label class="form-selectgroup-item text-no-wrap">
                                                <input type="radio" name="country_ban_enabled" value="1"
                                                    class="form-selectgroup-input"
                                                    {{ isset($settingsFraud['country_ban_enabled']) && $settingsFraud['country_ban_enabled'] == '1' ? 'checked' : '' }}>
                                                <span class="form-selectgroup-label">Yes</span>
                                            </label>
                                            <label class="form-selectgroup-item">
                                                <input type="radio" name="country_ban_enabled" value="0"
                                                    class="form-selectgroup-input"
                                                    {{ isset($settingsFraud['country_ban_enabled']) && $settingsFraud['country_ban_enabled'] == '0' ? 'checked' : '' }}>
                                                <span class="form-selectgroup-label">No</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- One Device Registration -->
                                <div class="col-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Single Device Registration?</label>
                                        <div class="form-selectgroup">
                                            <label class="form-selectgroup-item text-no-wrap">
                                                <input type="radio" name="one_device_registration_only" value="1"
                                                    class="form-selectgroup-input"
                                                    {{ isset($settingsFraud['one_device_registration_only']) && $settingsFraud['one_device_registration_only'] == '1' ? 'checked' : '' }}>
                                                <span class="form-selectgroup-label">Yes</span>
                                            </label>
                                            <label class="form-selectgroup-item">
                                                <input type="radio" name="one_device_registration_only" value="0"
                                                    class="form-selectgroup-input"
                                                    {{ isset($settingsFraud['one_device_registration_only']) && $settingsFraud['one_device_registration_only'] == '0' ? 'checked' : '' }}>
                                                <span class="form-selectgroup-label">No</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Allow VPN -->
                                <div class="col-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Allow VPN?</label>
                                        <div class="form-selectgroup">
                                            <label class="form-selectgroup-item text-no-wrap">
                                                <input type="radio" name="vpn_detection_enabled" value="1"
                                                    class="form-selectgroup-input"
                                                    {{ isset($settingsFraud['vpn_detection_enabled']) && $settingsFraud['vpn_detection_enabled'] == '1' ? 'checked' : '' }}>
                                                <span class="form-selectgroup-label">Yes</span>
                                            </label>
                                            <label class="form-selectgroup-item">
                                                <input type="radio" name="vpn_detection_enabled" value="0"
                                                    class="form-selectgroup-input"
                                                    {{ isset($settingsFraud['vpn_detection_enabled']) && $settingsFraud['vpn_detection_enabled'] == '0' ? 'checked' : '' }}>
                                                <span class="form-selectgroup-label">No</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Allow disposable email -->
                                <div class="col-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Allow Temp Emails?</label>
                                        <div class="form-selectgroup">
                                            <label class="form-selectgroup-item text-no-wrap">
                                                <input type="radio" name="temporary_email_ban_enabled" value="1"
                                                    class="form-selectgroup-input"
                                                    {{ isset($settingsFraud['temporary_email_ban_enabled']) && $settingsFraud['temporary_email_ban_enabled'] == '1' ? 'checked' : '' }}>
                                                <span class="form-selectgroup-label">Yes</span>
                                            </label>
                                            <label class="form-selectgroup-item">
                                                <input type="radio" name="temporary_email_ban_enabled" value="0"
                                                    class="form-selectgroup-input"
                                                    {{ isset($settingsFraud['temporary_email_ban_enabled']) && $settingsFraud['temporary_email_ban_enabled'] == '0' ? 'checked' : '' }}>
                                                <span class="form-selectgroup-label">No</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <!-- Enable Captcha -->
                                <div class="col-6 col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Captcha Verification?</label>
                                        <div class="form-selectgroup">
                                            <label class="form-selectgroup-item text-no-wrap">
                                                <input type="radio" name="captcha_enabled" value="1"
                                                    class="form-selectgroup-input"
                                                    {{ isset($settingsFraud['captcha_enabled']) && $settingsFraud['captcha_enabled'] == '1' ? 'checked' : '' }}>
                                                <span class="form-selectgroup-label">Yes</span>
                                            </label>
                                            <label class="form-selectgroup-item text-no-wrap">
                                                <input type="radio" name="captcha_enabled" value="0"
                                                    class="form-selectgroup-input"
                                                    {{ isset($settingsFraud['captcha_enabled']) && $settingsFraud['captcha_enabled'] == '0' ? 'checked' : '' }}>
                                                <span class="form-selectgroup-label">No</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
