<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use App\Models\Setting;
use App\Lib\FileManagement;

class SettingController extends Controller
{
    private $fraudSettings = [
        'email_verification_enabled',
        'registration_enabled',
        'vpn_ban_enabled',
        'country_ban_enabled',
        'one_device_registration_only',
        'vpn_detection_enabled',
        'temporary_email_ban_enabled',
        'captcha_enabled'
    ];

    private $generalSettings = [
        'site_name',
        'site_currency_symbol',
        'active_template',
        'referral_percentage',
        'site_logo',
        'site_favicon',
        'seo_description',
        'seo_keywords',
        'google_analytics_key',
        'proxycheck_api_key',
        'signup_bonus',
        'admin_rate',
        'social_media_links',
        'statistics',
        'support_email',
        'allowed_email',
        'withdraw_hold_duration',
    ];

    private $fileManager;

    public function __construct(FileManagement $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function frauds()
    {
        $settingsFraud = Setting::whereIn('name', $this->fraudSettings)->pluck('value', 'name');

        return view('admin.frauds', compact('settingsFraud'));
    }

    public function updateFraud(Request $request)
    {
        $this->validateFraud($request);

        $settings = $this->getSettingsFromRequest($request, $this->fraudSettings)
            ->mapWithKeys(fn($value, $key) => [$key => (int) $value]);

        $settings->each(fn($value, $name) => Setting::updateOrCreate(['name' => $name], ['value' => $value]));

        return redirect()->back()->with('success', 'Fraud settings updated successfully.');
    }

    public function settings()
    {
        $templates = get_available_templates();
        $systemSettings = Setting::whereIn('name', $this->generalSettings)->pluck('value', 'name');

        return view('admin.settings', compact('systemSettings', 'templates'));
    }


    public function updateSettings(Request $request)
    {
        $this->validateSettings($request);

        $data = $this->getSettingsFromRequest($request, $this->generalSettings)->toArray();

        if ($request->has('statistics')) {
            $data['statistics'] = json_encode([$request->input('statistics')]);
        }

        $data['allowed_email'] = $this->normalizeAllowedEmailDomains($request->input('allowed_email'));

        if ($request->hasFile('site_logo')) {
            $this->deleteOldFile('site_logo', 'assets/images/logo');

            $data['site_logo'] = $this->fileManager->uploadImage(
                $request->file('site_logo'),
                'logo'
            );
        }

        if ($request->hasFile('site_favicon')) {
            $this->deleteOldFile('site_favicon', 'assets/images/favicon');

            $data['site_favicon'] = $this->fileManager->uploadImage(
                $request->file('site_favicon'),
                'favicon'
            );
        }

        $this->updateSettingsInDatabase($data);
        Cache::forget('settings');
        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    private function normalizeAllowedEmailDomains(?string $input): ?string
    {
        if (empty($input)) {
            return null;
        }

        $domains = preg_split('/[\s,]+/', trim($input));
        $domains = array_filter(array_map('strtolower', $domains));

        return implode(',', $domains);
    }


    private function validateSettings(Request $request)
    {
        $request->validate([
            'site_currency_symbol' => 'required|string',
            'active_template' => 'required|string',
            'referral_percentage' => 'required|numeric',
            'site_logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:500',
            'site_favicon' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:500',
            'seo_description' => 'required|string',
            'seo_keywords' => 'required|string',
            'google_analytics_key' => 'nullable|string',
            'proxycheck_api_key' => 'nullable|string',
            'signup_bonus' => 'required|numeric',
            'admin_rate' => 'required|numeric',

            // Validate statistics array and its keys
            'statistics' => 'required|array',
            'statistics.average_time' => 'required|string|max:20',
            'statistics.average_money' => 'required|string|max:20',
            'statistics.total_earned' => 'required|string|max:20',
            'support_email' => 'required|email',
            'allowed_email' => 'nullable|string',
            'withdraw_hold_duration' => 'nullable|integer',
        ]);
    }

    private function validateFraud(Request $request)
    {
        $request->validate([
            'email_verification_enabled' => 'required|boolean',
            'registration_enabled' => 'required|boolean',
            'vpn_ban_enabled' => 'required|boolean',
            'country_ban_enabled' => 'required|boolean',
            'one_device_registration_only' => 'required|boolean',
            'vpn_detection_enabled' => 'required|boolean',
            'temporary_email_ban_enabled' => 'required|boolean',
            'captcha_enabled' => 'required|boolean',
        ]);
    }


    private function getSettingsFromRequest(Request $request, array $keys)
    {
        return collect($request->only($keys));
    }

    private function updateSettingsInDatabase(array $data)
    {
        foreach ($this->generalSettings as $key) {
            if (array_key_exists($key, $data)) {
                Setting::where('name', $key)->update(['value' => $data[$key]]);
            }
        }
    }

    private function deleteOldFile(string $key, string $directory)
    {
        $oldFilePath = Setting::where('name', $key)->value('value');

        if ($oldFilePath) {
            $oldFilePath = 'public/' . $directory . '/' . basename($oldFilePath);

            if (Storage::exists($oldFilePath)) {
                Storage::delete($oldFilePath);
            }
        }
    }

    public function socialMediaStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'url' => 'required|url',
            'icon' => 'required|image:allow_svg|mimes:jpg,jpeg,png,svg,webp|max:500',
        ]);

        // Upload icon
        $iconPath = null;
        if ($request->hasFile('icon')) {
            $iconPath = $this->fileManager->uploadImage(
                $request->file('icon'),
                'social-icons'
            );
        }

        // Load existing links
        $setting = Setting::where('name', 'social_media_links')->first();
        $socialLinks = json_decode($setting->value ?? '[]', true);

        $socialLinks[] = [
            'name' => $request->name,
            'url' => $request->url,
            'icon' => $iconPath,
        ];

        $setting->value = json_encode($socialLinks);
        $setting->save();
        Cache::forget('site_settings');
        return redirect()->back()->with('success', 'Social media link added.');
    }



    public function socialMediaDestroy($id)
    {
        $setting = Setting::where('name', 'social_media_links')->first();

        if (!$setting) {
            return redirect()->back()->with('error', 'Social media setting not found.');
        }

        $socialLinks = json_decode($setting->value, true);

        if (!is_array($socialLinks) || !array_key_exists($id, $socialLinks)) {
            return redirect()->back()->with('error', 'Invalid social media entry.');
        }

        // Delete icon if exists
        if (!empty($socialLinks[$id]['icon'])) {
            $this->fileManager->delete($socialLinks[$id]['icon']);
        }

        // Remove the entry and reindex
        unset($socialLinks[$id]);
        $setting->value = json_encode(array_values($socialLinks));
        $setting->save();
        Cache::forget('site_settings');


        return redirect()->back()->with('success', 'Social media link deleted.');
    }

}
