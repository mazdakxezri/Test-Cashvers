<?php

use App\Models\Setting;
use App\Models\Offer;
use GeoIp2\Database\Reader;
use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Cache;

function loadSettings()
{
    return Cache::remember('site_settings', 3600, function () {
        return Setting::whereIn('name', [
            'active_template',
            'site_name',
            'site_logo',
            'site_favicon',
            'site_currency_symbol',
            'seo_description',
            'seo_keywords',
            'social_media_links',
            'google_analytics_key',
            'registration_enabled',
            'captcha_enabled',
            'referral_percentage',
            'adgate_status_enabled',
            'torox_status',
            'ogads_status_enabled',
            'country_ban_enabled',
            'vpn_ban_enabled',
            'vpn_detection_enabled',
            'proxycheck_api_key',
            'hangmyads_status_enabled',
            'admin_rate',
            'statistics',
        ])->pluck('value', 'name')->toArray();
    });
}

function getSetting($key, $default = null)
{
    $settings = loadSettings();
    return $settings[$key] ?? $default;
}

// Consolidated settings accessors
function get_current_template()
{
    return getSetting('active_template', 'garnet');
}

function siteName()
{
    return getSetting('site_name');
}

function getStatistics()
{
    $json = getSetting('statistics');

    $statsArray = json_decode($json, true);

    return $statsArray[0] ?? [
        'average_time' => null,
        'average_money' => null,
        'total_earned' => null,
    ];
}

function siteLogo()
{
    return getSetting('site_logo');
}

function siteFav()
{
    return getSetting('site_favicon');
}

function siteSymbol()
{
    return getSetting('site_currency_symbol');
}

function seoDescription()
{
    return getSetting('seo_description', '');
}

function seoKeywords()
{
    return getSetting('seo_keywords', '');
}

function googleAnalyticsKey()
{
    return getSetting('google_analytics_key');
}

function proxyCheckApiKey()
{
    return getSetting('proxycheck_api_key');
}

function isRegistrationEnabled()
{
    return getSetting('registration_enabled') === '1';
}

function isCaptchaEnabled()
{
    return getSetting('captcha_enabled') === '1';
}

function ReferralCommission()
{
    return getSetting('referral_percentage', 0);
}

function socialMediaLink()
{
    return getSetting('social_media_links');
}

function AdminRate()
{
    return getSetting('admin_rate');
}

// Template utilities
function getActiveTemplate()
{
    $activeTemplate = view()->shared('activeTemplate');
    return str_replace('/', '.', $activeTemplate);
}

function get_available_templates()
{
    $templatePath = resource_path('views/templates');
    return array_map(function ($dir) use ($templatePath) {
        return basename($dir);
    }, array_filter(glob($templatePath . '/*'), 'is_dir'));
}

// GeoIP utility
function getCountryCode($ip)
{
    try {
        $reader = new Reader(storage_path('app/geoip/GeoLite2-Country.mmdb'));
        return $reader->country($ip)->country->isoCode ?? null;
    } catch (\Exception $e) {
        return null;
    }
}

function getFullCountryName($iso)
{
    $countries = Cache::rememberForever('country_list', function () {
        $data = json_decode(file_get_contents(storage_path('app/geoip/countries.json')), true);
        return array_column($data, 'name', 'code');
    });

    return $countries[strtoupper($iso)] ?? 'Unknown Country';
}



// CAPTCHA rendering
function renderCaptcha()
{
    if (isCaptchaEnabled()) {
        return '<div class="d-flex justify-content-center mb-2">' .
            '<div>' . NoCaptcha::display() . '</div>' .
            '</div>';
    }
    return '';
}

// Device detection
function detectDevicePlatform()
{
    $agent = new Agent();
    return match (true) {
        $agent->isAndroidOS() => 'android',
        $agent->is('iPhone') => 'ios',
        $agent->isDesktop() => 'desktop',
        $agent->is('Macintosh') => 'mac os',
        default => 'unknown',
    };
}

// OGADS and ADGATE API status
function isOgadsApiEnabled()
{
    return getSetting('ogads_status_enabled') == 1;
}

function isAdgateApiEnabled()
{
    return getSetting('adgate_status_enabled') == 1;
}

function isToroxApiEnabled()
{
    return getSetting('torox_status') == 1;

}

function isHangmyadsApiEnabled()
{
    return getSetting('hangmyads_status_enabled') == 1;
}

function isCountryBanEnabled()
{
    return (int) getSetting('country_ban_enabled') === 1;
}
function isVpnBanEnabled()
{
    return (int) getSetting('vpn_ban_enabled') === 1;
}

function isVpnDetectionEnabled()
{
    return (int) getSetting('vpn_detection_enabled') === 0;
}

function isCustomOffersEnabled()
{
    return Offer::where('type', 'custom')->exists();
}