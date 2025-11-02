<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Offer;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class FetchOffers extends Command
{
    protected $signature = 'FetchOffers:cron';
    protected $description = 'Fetch offers from Adgate Media, Torox and HangMyAds';

    // Provider constants
    private const ADGATE = 'adgatemedia';
    private const TOROX = 'torox';
    private const HANGMYADS = 'hangmyads';

    // Settings
    private $settings;

    // API endpoints
    private const API_ENDPOINTS = [
        self::ADGATE => 'https://api.adgatemedia.com/v3/offers',
        self::TOROX => 'https://torox.io/api/',
        self::HANGMYADS => 'http://api.hangmytracking.com/api.php'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->loadSettings();

        $this->fetchAllEnabledOffers();
        $this->info('Offers fetched and stored successfully!');
    }

    private function loadSettings()
    {
        $this->settings = Cache::remember('apiSettings', 3600, function () {
            return Setting::whereIn('name', [
                'adgate_affiliate_id',
                'adgate_api_key',
                'adgate_wall',
                'adgate_rate',
                'torox_pubid',
                'torox_appid',
                'torox_key',
                'torox_rate',
                'hangmyads_network_id',
                'hangmyads_api',
                'hangmyads_rate',
                'hangmyads_status_enabled',
            ])->pluck('value', 'name')->toArray();
        });
    }

    private function fetchAllEnabledOffers()
    {
        $providers = [
            [
                'name' => self::ADGATE,
                'enabled' => $this->isAdgateApiEnabled(),
                'fetchMethod' => 'fetchAdgateOffers'
            ],
            [
                'name' => self::TOROX,
                'enabled' => $this->isToroxApiEnabled(),
                'fetchMethod' => 'fetchToroxOffers'
            ],
            [
                'name' => self::HANGMYADS,
                'enabled' => $this->isHangmyadsApiEnabled(),
                'fetchMethod' => 'fetchHangMyAdsOffers'
            ]
        ];

        foreach ($providers as $provider) {
            if ($provider['enabled']) {
                $this->info("Fetching offers from {$provider['name']}...");
                $this->{$provider['fetchMethod']}();
            }
        }
    }

    private function fetchAdgateOffers()
    {
        $params = [
            'aff' => $this->settings['adgate_affiliate_id'],
            'api_key' => $this->settings['adgate_api_key'],
            'wall_code' => $this->settings['adgate_wall'],
            'categories' => '21,22,23',
        ];

        $url = self::API_ENDPOINTS[self::ADGATE] . '?' . http_build_query($params);
        $this->fetchOffersWithGet($url, self::ADGATE);
    }

    private function fetchToroxOffers()
    {
        $params = [
            'pubid' => $this->settings['torox_pubid'],
            'appid' => $this->settings['torox_appid'],
            'secretkey' => $this->settings['torox_key'],
            'verticals' => 0,
        ];

        $url = self::API_ENDPOINTS[self::TOROX] . '?' . http_build_query($params);
        $this->fetchOffersWithGet($url, self::TOROX);
    }

    private function fetchHangMyAdsOffers()
    {
        try {
            // Skip SSL verification in local environment
            $httpOptions = [];
            if (app()->environment('local')) {
                $httpOptions['verify'] = false;
            }

            $response = Http::withOptions($httpOptions)->post(self::API_ENDPOINTS[self::HANGMYADS], [
                'method' => 'getOffers',
                'apiID' => $this->settings['hangmyads_network_id'],
                'apiToken' => $this->settings['hangmyads_api'],
                'status' => 'active',
            ]);

            $this->processApiResponse($response, self::HANGMYADS);
        } catch (\Exception $e) {
            $this->error("Error fetching " . self::HANGMYADS . " offers: " . $e->getMessage());
        }
    }

    private function fetchOffersWithGet($url, $source)
    {
        try {
            // Skip SSL verification in local environment
            $httpOptions = [];
            if (app()->environment('local')) {
                $httpOptions['verify'] = false;
            }

           $response = Http::withOptions($httpOptions)
                        ->timeout(120)
                        ->connectTimeout(30)
                        ->get($url);
            $this->processApiResponse($response, $source);
        } catch (\Exception $e) {
            $this->error("Error fetching {$source} offers: " . $e->getMessage());
        }
    }

    private function processApiResponse($response, $source)
    {
        if (!$response->successful()) {
            $this->error("{$source} API Request failed. Status: " . $response->status());
            return;
        }

        $offers = $this->getOffersFromResponse($response, $source);

        if (empty($offers)) {
            $this->info("No offers returned from {$source}");
            return;
        }

        $processedCount = 0;
        foreach ($offers as $offer) {
            if ($this->processOffer($offer, $source)) {
                $processedCount++;
            }
        }

        $this->info("Processed {$processedCount} offers from {$source}");
    }

    private function getOffersFromResponse($response, $source)
    {
        switch ($source) {
            case self::ADGATE:
                return $response->json('data', []);
            case self::TOROX:
                return $response->json('response.offers', []);
            case self::HANGMYADS:
                return $response->object()->data->offers ?? [];
            default:
                return [];
        }
    }

    private function processOffer($offer, $source)
    {
        $countries = [];
        $events = [];
        $adjustedPayout = 0;

        switch ($source) {
            case self::ADGATE:
                $countries = array_column($offer['geo_targeting']['countries'] ?? [], 'country_code');
                $events = $this->processAdgateEvents($offer['events'] ?? []);
                $adjustedPayout = array_sum(array_column($events, 'payout'));
                break;

            case self::TOROX:
                $countries = $offer['countries'] ?? [];
                $events = $this->processToroxEvents($offer['events'] ?? []);
                $adjustedPayout = $this->calculateAdjustedPayout(
                    $offer['payout'] ?? 0,
                    $this->settings['torox_rate'] ?? 1
                );
                break;

            case self::HANGMYADS:
                $countries = isset($offer->countries_obj) ? array_keys((array) $offer->countries_obj) : [];
                $events = $this->processHangMyAdsEvents($offer);
                $adjustedPayout = $this->calculateHangMyAdsPayout(
                    $offer->payout_cents ?? 0,
                    $this->settings['hangmyads_rate'] ?? 1
                );
                break;
        }

        $operatingSystems = $this->determineOperatingSystems($offer, $source);
        $data = $this->prepareOfferData($offer, $source, $countries, $operatingSystems, $events, $adjustedPayout);

        // Skip offers with zero or negative payout for HangMyAds
        if ($source === self::HANGMYADS && $adjustedPayout <= 0) {
            return false;
        }

        Offer::updateOrCreate(['offer_id' => $data['offer_id']], $data);
        return true;
    }

    private function calculateAdjustedPayout($amount, $rate)
    {
        return (float) $amount * (float) $rate;
    }

    private function calculateHangMyAdsPayout($payCents, $rate)
    {
        return ((float) $payCents / 100) * (float) $rate;
    }

    private function processAdgateEvents($events)
    {
        return array_map(function ($event) {
            return [
                'id' => $event['id'],
                'name' => $event['name'],
                'payout' => $this->calculateAdjustedPayout(
                    $event['payout'],
                    $this->settings['adgate_rate'] ?? 1
                )
            ];
        }, $events);
    }

    private function processToroxEvents($events)
    {
        return array_map(function ($event) {
            return [
                'name' => $event['event_name'],
                'payout' => $event['payout'] * ($this->settings['torox_rate'] ?? 1)
            ];
        }, $events);
    }

    private function determineOperatingSystems($offer, $source)
    {
        $operatingSystems = [];

        switch ($source) {
            case self::ADGATE:
                $operatingSystems = $this->getAdgateOperatingSystems($offer);
                break;

            case self::TOROX:
                $operatingSystems = $this->getToroxOperatingSystems($offer);
                break;

            case self::HANGMYADS:
                $operatingSystems = $this->getHangMyAdsOperatingSystems($offer);
                break;
        }

        return array_unique($operatingSystems);
    }

    private function getAdgateOperatingSystems($offer)
    {
        $operatingSystems = [];
        $deviceTargeting = $offer['device_targeting']['operating_systems'] ?? [];

        foreach ($deviceTargeting as $device) {
            $osName = strtolower($device['name'] ?? '');
            if (in_array($osName, ['windows', 'mac os'])) {
                $operatingSystems[] = 'desktop';
            } elseif ($osName === 'ios') {
                $operatingSystems[] = 'ios';
            } elseif ($osName === 'android') {
                $operatingSystems[] = 'android';
            }
        }

        return $operatingSystems;
    }

    private function getToroxOperatingSystems($offer)
    {
        $platform = $offer['platform'] ?? '';
        $device = $offer['device'] ?? '';

        if ($platform === 'web' && empty($device)) {
            return ['all'];
        }

        if ($platform === 'mobile') {
            return [$device === 'android' ? 'android' : 'ios'];
        }

        return [];
    }

    private function getHangMyAdsOperatingSystems($offer)
    {
        $os = $offer->os ?? 'All';
        $osName = strtolower($os);

        if ($osName === 'android') {
            return ['android'];
        }

        if ($osName === 'ios') {
            return ['ios'];
        }

        return ['all'];
    }

    private function prepareOfferData($offer, $source, $countries, $operatingSystems, $events, $adjustedPayout)
    {
        $data = [
            'offer_id' => '',
            'name' => '',
            'description' => '',
            'requirements' => '',
            'payout' => $adjustedPayout,
            'creative' => '',
            'event' => json_encode($events),
            'device' => implode(', ', $operatingSystems) ?: 'all',
            'partner' => $source,
            'link' => '',
            'countries' => implode(',', $countries),
            'type' => 'api',
        ];

        switch ($source) {
            case self::ADGATE:
                $data = $this->extractAdgateOfferData($offer, $data);
                break;

            case self::TOROX:
                $data = $this->extractToroxOfferData($offer, $data);
                break;

            case self::HANGMYADS:
                $data = $this->extractHangMyAdsOfferData($offer, $data);
                break;
        }

        // Standardize link format
        if ($data['link']) {
            $data['link'] = $this->standardizeTrackingLink($data['link']);
        }

        return $data;
    }

    private function extractAdgateOfferData($offer, $data)
    {
        $data['offer_id'] = $offer['id'] ?? '';
        $data['name'] = htmlspecialchars_decode($offer['anchor'] ?? '', ENT_QUOTES);
        $data['description'] = htmlspecialchars_decode($offer['description'] ?? '', ENT_QUOTES);
        $data['requirements'] = $offer['requirements'] ?? '';
        $data['creative'] = $offer['creatives']['icon'] ?? '';
        $data['link'] = $offer['click_url'] ?? '';

        return $data;
    }

    private function extractToroxOfferData($offer, $data)
    {
        $data['offer_id'] = $offer['offer_id'] ?? '';
        $data['name'] = htmlspecialchars_decode($offer['offer_name'] ?? '', ENT_QUOTES);
        $data['description'] = htmlspecialchars_decode($offer['offer_desc'] ?? '', ENT_QUOTES);
        $data['creative'] = $offer['image_url'] ?? '';
        $data['link'] = $offer['offer_url_easy'] ?? '';

        return $data;
    }

    private function extractHangMyAdsOfferData($offer, $data)
    {
        $data['offer_id'] = $offer->id ?? '';
        $data['name'] = htmlspecialchars_decode($offer->name ?? '', ENT_QUOTES);
        $data['description'] = htmlspecialchars_decode($offer->description ?? '', ENT_QUOTES);
        $data['requirements'] = $offer->conditions ?? '';
        $data['creative'] = $offer->thumbnail ?? '';
        $data['link'] = $offer->tracking_link ?? '';

        return $data;
    }

    private function standardizeTrackingLink($link)
    {
        $link = str_replace('[USER_ID]', '[uid]', $link);
        $link = str_replace('YOUR_CLICK_ID', '[uid]', $link);
        $link = preg_replace('/s1=[^&]*/', 's1=[uid]', $link);

        return $link;
    }

    private function processHangMyAdsEvents($offer)
    {
        $events = [];

        if (empty($offer->goals)) {
            return $events;
        }

        foreach ($offer->goals as $goal) {
            foreach ($goal as $name => $details) {
                // Convert values to float to avoid type issues
                $payCents = (float) ($details->pay_cents ?? 0);
                $rate = (float) ($this->settings['hangmyads_rate'] ?? 1);

                $events[] = [
                    'name' => $details->event_desc ?? $name,
                    'payout' => ($payCents / 100) * $rate
                ];
            }
        }

        return $events;
    }

    // Helper methods for network status
    private function isAdgateApiEnabled()
    {
        return isAdgateApiEnabled();
    }

    private function isToroxApiEnabled()
    {
        return isToroxApiEnabled();
    }

    private function isHangmyadsApiEnabled()
    {
        return isHangmyadsApiEnabled();
    }
}
