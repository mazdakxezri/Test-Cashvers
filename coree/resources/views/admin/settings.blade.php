@extends('admin.layouts.master')

@section('title', 'System Settings')

@section('content')
    <div class="page-body">
        <div class="container-xl">
            <div class="row row-cards">

                <div class="col-12">
                    <x-admin.alert />
                </div>
                <!-- Cron Job Section -->
                <div class="col-12">
                    <div class="card mb-3">
                        <div class="card-header">
                            <h4 class="card-title">Cron Job Commands</h4>
                        </div>
                        <div class="card-body">
                            <pre class="bg-dark p-2" style="white-space: pre-wrap;">
    <span class="text-success"># Cron Job Command</span><br>
    &nbsp;{{ str_replace('lsphp', 'php', PHP_BINARY) }} {{ base_path('artisan') }} schedule:run >> /dev/null 2>&1<br><br>
</pre>



                            <small class="text-muted">Copy the above commands and add them to your server's crontab.</small>
                        </div>
                    </div>
                </div>

                <div class="cl-12 col-md-8 mb-3">
                    <form action="{{ route('admin.settings.update') }}" method="POST" class="card"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h4 class="card-title">{{ SiteName() }} Settings</h4>
                        </div>
                        <div class="card-body">
                            <div class="row g-5">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">Site Name:</label>
                                                <input type="text" class="form-control" name="site_name"
                                                    value="{{ old('site_name', $systemSettings['site_name']) }}">
                                                @error('site_name')
                                                    <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">Referral Percentage:</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="referral_percentage"
                                                        value="{{ old('referral_percentage', $systemSettings['referral_percentage']) }}">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                                @error('referral_percentage')
                                                    <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mb-3">
                                                <label class="form-label">Site Symbol:</label>
                                                <input type="text" class="form-control" name="site_currency_symbol"
                                                    value="{{ old('site_currency_symbol', $systemSettings['site_currency_symbol']) }}">
                                                @error('site_currency_symbol')
                                                    <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Proxycheck Api key</label>
                                                <input type="text" class="form-control" name="proxycheck_api_key"
                                                    value="{{ old('proxycheck_api_key', $systemSettings['proxycheck_api_key']) }}">
                                                @error('proxycheck_api_key')
                                                    <small class="text-red">{{ $message }}</small>
                                                @enderror
                                                <small>
                                                    <a href="https://www.proxycheck.io/get-api" target="_blank"
                                                        rel="noopener noreferrer" class="text-red">Click here to get your
                                                        API</a>
                                                </small>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Signup Bonus</label>
                                                <input type="number" class="form-control" name="signup_bonus"
                                                    value="{{ old('signup_bonus', $systemSettings['signup_bonus']) }}"
                                                    min="0" step="0.01">
                                                @error('signup_bonus')
                                                    <small class="text-red">{{ $message }}</small>
                                                @enderror
                                                <small class="text-info">
                                                    Set to 0 to disable the signup bonus for new users.
                                                </small>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Support Email</label>
                                                <input type="email" class="form-control" name="support_email"
                                                    value="{{ old('support_email', $systemSettings['support_email']) }}"
                                                    required>
                                                @error('support_email')
                                                    <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label class="form-label">Admin Rate</label>
                                                <input type="number" class="form-control" name="admin_rate"
                                                    value="{{ old('admin_rate', $systemSettings['admin_rate']) }}"
                                                    required>
                                                @error('admin_rate')
                                                    <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="hr-text my-4 text-cyan">Design Settings</div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <div class="form-label">Select Theme</div>
                                                <select class="form-select" name="active_template">
                                                    @foreach ($templates as $key => $templateName)
                                                        <option value="{{ $templateName }}"
                                                            {{ old('active_template', $systemSettings['active_template'] ?? '') == $templateName ? 'selected' : '' }}>
                                                            {{ $templateName }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('active_template')
                                                    <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Site Logo:</label>
                                                <input type="file" class="form-control" name="site_logo">
                                                @error('site_logo')
                                                    <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Favicon:</label>
                                                <input type="file" class="form-control" name="site_favicon">
                                                @error('site_favicon')
                                                    <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="hr-text my-4 text-cyan">SEO Settings</div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">SEO Description:</label>
                                                <textarea class="form-control" name="seo_description" rows="1">{{ old('seo_description', $systemSettings['seo_description']) }}</textarea>
                                                @error('seo_description')
                                                    <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">SEO Keywords:</label>
                                                <input type="text" class="form-control" name="seo_keywords"
                                                    value="{{ old('seo_keywords', $systemSettings['seo_keywords']) }}">
                                                @error('seo_keywords')
                                                    <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label class="form-label">Google Analytics Tracking ID:</label>
                                                <input type="text" class="form-control" name="google_analytics_key"
                                                    value="{{ old('google_analytics_key', $systemSettings['google_analytics_key']) }}">
                                                @error('google_analytics_key')
                                                    <small class="text-red">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hr-text my-4 text-cyan">Statistics</div>
                                    @php
                                        $statistics = json_decode($systemSettings['statistics'] ?? '[]', true);
                                        $stat = $statistics[0] ?? [];
                                    @endphp
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>Average Time:</label>
                                            <input type="text" name="statistics[average_time]"
                                                value="{{ old('statistics.average_time', $stat['average_time'] ?? '') }}"
                                                class="form-control" />
                                            @error('statistics.average_time')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label>Average Money:</label>
                                            <input type="text" name="statistics[average_money]"
                                                value="{{ old('statistics.average_money', $stat['average_money'] ?? '') }}"
                                                class="form-control" />
                                            @error('statistics.average_money')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label>Total Earned:</label>
                                            <input type="text" name="statistics[total_earned]"
                                                value="{{ old('statistics.total_earned', $stat['total_earned'] ?? '') }}"
                                                class="form-control" />
                                            @error('statistics.total_earned')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="hr-text my-4 text-cyan">security</div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="allowed_email">Allowed Email Domains:</label>
                                            <textarea name="allowed_email" id="allowed_email" rows="5" class="form-control"
                                                placeholder="Enter allowed domains, one per line or comma separated">{{ old('allowed_email', $systemSettings['allowed_email']) }}</textarea>
                                            @error('allowed_email')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label for="withdraw_hold_duration">Withdraw Hold Duration <small class="text-red">(Days)</small></label>
                                            <input type="number" min="1" step="1" pattern="\d+"
                                                class="form-control" name="withdraw_hold_duration"
                                                id="withdraw_hold_duration"
                                                value="{{ old('withdraw_hold_duration', $systemSettings['withdraw_hold_duration']) }}"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                placeholder="Enter number of days">
                                            @error('withdraw_hold_duration')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-dark">Save Settings</button>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-md-4 mb-3">
                    <form method="POST" action="{{ route('admin.social-media.store') }}" enctype="multipart/form-data"
                        class="card mb-3">
                        @csrf
                        <div class="card-header">
                            <h4 class="card-title">Add Social Media Link</h4>
                        </div>
                        <div class="card-body">

                            <div class="mb-3">
                                <label class="form-label" for="name">Social Media Name</label>
                                <input type="text" id="name" class="form-control" name="name"
                                    placeholder="Enter social media name" value="{{ old('name') }}" required />
                                @error('name')
                                    <div class="form-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="url">Social Media URL</label>
                                <input type="url" id="url" class="form-control" name="url"
                                    placeholder="Enter social media URL" value="{{ old('url') }}" required />
                                @error('url')
                                    <div class="form-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="icon">Icon (jpg, png, svg, webp)</label>
                                <input type="file" id="icon" class="form-control" name="icon"
                                    accept=".jpg,.jpeg,.png,.svg,.webp" required />
                                @error('icon')
                                    <div class="form-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Add Social Media Link</button>

                        </div>
                    </form>

                    <div class="card mb-3">
                        <div class="card-header">
                            <h4 class="card-title">Social Media Links</h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Link</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $socialLinks = is_string($systemSettings['social_media_links'] ?? null)
                                            ? json_decode($systemSettings['social_media_links'], true)
                                            : $systemSettings['social_media_links'] ?? [];
                                    @endphp

                                    @forelse ($socialLinks as $index => $social)
                                        <tr>
                                            <td>
                                                <div class="d-flex py-1 align-items-center">
                                                    <span class="avatar avatar-2 me-3"
                                                        style="background-image: url('{{ asset($social['icon']) }}')"></span>
                                                    <div class="flex-fill">
                                                        <div class="font-weight-medium text-capitalize">
                                                            {{ $social['name'] }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ $social['url'] }}" target="_blank"
                                                    class="text-primary text-truncate d-block">
                                                    {{ strlen($social['url']) > 10 ? substr($social['url'], 0, 10) . '...' : $social['url'] }}
                                                </a>
                                            </td>

                                            <td class="text-end">
                                                <form action="{{ route('admin.social-media.destroy', $index) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this social media link?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-sm btn-outline-danger">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted fst-italic">No social media
                                                links added yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
