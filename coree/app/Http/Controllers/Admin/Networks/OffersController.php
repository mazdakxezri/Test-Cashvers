<?php

namespace App\Http\Controllers\Admin\Networks;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Network;
use App\Models\Offer;
use App\Lib\FileManagement;
use App\Models\Level;


class OffersController extends Controller
{
    private $fileManager;

    public function __construct(FileManagement $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function index()
    {
        $networks = Network::orderBy('network_order', 'asc')->get();

        $groupedNetworks = $networks->groupBy(function ($network) {
            return $network->network_type;
        });

        $offer = $groupedNetworks->get('offer', collect());
        $survey = $groupedNetworks->get('survey', collect());

        $addPostbackUrl = function ($network) {
            $postbackUrl = $this->generatePostbackUrl($network);
            $network->postbackUrl = $postbackUrl;
            return $network;
        };

        $offer = $offer->map($addPostbackUrl);
        $survey = $survey->map($addPostbackUrl);

        return view('admin.networks.index', compact('offer', 'survey'));
    }

    public function saveNewtorkOrder(Request $request)
    {
        $validated = $request->validate([
            'order' => 'required|array',
        ]);

        \DB::beginTransaction();

        try {
            $networkOrders = collect($validated['order'])->pluck('order', 'name');

            foreach ($networkOrders as $name => $order) {
                Network::where('network_name', $name)->update(['network_order' => $order]);
            }

            \DB::commit();

            return response()->json(['message' => 'Order saved successfully'], 200);

        } catch (\Exception $e) {
            \DB::rollBack();

            return response()->json(['message' => 'Failed to save order', 'error' => $e->getMessage()], 500);
        }
    }



    private function generatePostbackUrl($network)
    {
        $postbackUrl = route('postback.callback', [
            'param_secret' => $network->param_secret,
            'network_slug' => $network->network_slug,
        ]);

        $params = [];

        if ($network->param_url_visibility == 1) {
            $params = [
                'payout' => $network->param_payout,
                'uid' => $network->param_user_id,
                'of_id' => $network->param_offer_id,
                'of_name' => $network->param_offer_name,
                'tx_id' => $network->param_tx_id,
                'reward' => $network->param_amount,
                'ip' => $network->param_ip,
                'country' => $network->param_country,
                'status' => $network->param_status,
            ];

            $params = array_filter($params, function ($value) {
                return !is_null($value);
            });

            // Convert to query string format
            $params = array_map(function ($key, $value) {
                return $key . '=' . $value;
            }, array_keys($params), $params);
        }


        if (!empty($params)) {
            $queryString = implode('&', $params);
            $postbackUrl .= '?' . $queryString;
        }

        return $postbackUrl;
    }

    public function ApiOffers()
    {
        $settings = [
            'ogads_api_key',
            'ogads_rate',
            'ogads_status_enabled',
            'adgate_api_key',
            'adgate_wall',
            'adgate_rate',
            'adgate_affiliate_id',
            'adgate_status_enabled',
            'torox_pubid',
            'torox_appid',
            'torox_key',
            'torox_status',
            'torox_rate',
            'hangmyads_network_id',
            'hangmyads_api',
            'hangmyads_rate',
            'hangmyads_status_enabled',
        ];

        $settingsData = Setting::whereIn('name', $settings)->pluck('value', 'name');

        return view('admin.networks.api-offers', compact('settingsData'));
    }

    public function StoreApi(Request $request)
    {
        $validatedData = $request->validate([
            'ogads_api_key' => 'nullable|string',
            'ogads_rate' => 'nullable|numeric',
            'ogads_status_enabled' => 'required|in:0,1',

            'adgate_api_key' => 'nullable|string',
            'adgate_wall' => 'nullable|string',
            'adgate_affiliate_id' => 'nullable|integer',
            'adgate_rate' => 'nullable|numeric',
            'adgate_status_enabled' => 'required|in:0,1',

            'torox_pubid' => 'nullable|integer',
            'torox_appid' => 'nullable|integer',
            'torox_key' => 'nullable|string',
            'torox_status' => 'required|in:0,1',
            'torox_rate' => 'nullable|numeric',

            'hangmyads_network_id' => 'nullable|string',
            'hangmyads_api' => 'nullable|string',
            'hangmyads_rate' => 'nullable|numeric',
            'hangmyads_status_enabled' => 'required|in:0,1',
        ]);

        collect($validatedData)->each(fn($value, $key) => Setting::updateOrCreate(['name' => $key], ['value' => $value]));

        $offerUpdates = [
            'adgatemedia' => $validatedData['adgate_status_enabled'],
            'torox' => $validatedData['torox_status'],
            'hangmyads' => $validatedData['hangmyads_status_enabled']
        ];

        foreach ($offerUpdates as $partner => $status) {
            Offer::where('partner', $partner)->update(['status' => $status]);
        }

        Cache::forget('apiSettings');

        return redirect()->back()->with('success', 'Settings saved successfully.');
    }

    public function newNetwork()
    {
        $levels = Level::select('id', 'level')
            ->orderBy('level', 'asc')
            ->get();
        return view('admin.networks.new-network', compact('levels'));
    }

    public function storeNetwork(Request $request)
    {
        // Normalize network name to lowercase and validate the request
        $request->merge(['network_name' => strtolower($request->input('network_name'))]);
        $validatedData = $request->validate($this->networkValidationRules());

        // Check if the network name already exists
        if (Network::where('network_name', $validatedData['network_name'])->exists()) {
            return redirect()->back()->withInput()->withErrors(['network_name' => 'The network name already exists.']);
        }

        try {
            $lastOrder = Network::where('network_type', $validatedData['network_type'])->max('network_order') ?? 0;

            $validatedData['network_order'] = $lastOrder + 1;
            $validatedData = $this->prepareNetworkData($request, $validatedData);

            Network::create($validatedData);
            return redirect()->route('admin.networks.index')->with('success', 'Network added successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to add network. Please try again.');
        }
    }

    public function editNetwork($id)
    {
        $networkInfo = Network::find($id);

        if (!$networkInfo) {
            return redirect()->route('admin.networks.index')->with('error', 'Network not found.');
        }

        $levels = Level::select('id', 'level')->orderBy('level', 'asc')->get();
        return view('admin.networks.edit-network', compact('networkInfo', 'levels'));
    }

    public function storeEditNetwork(Request $request, $id)
    {
        $request->validate($this->networkValidationRules());

        try {
            $network = Network::findOrFail($id);
            $network->fill($request->except('network_image'));

            if ($request->filled('network_name')) {
                $network->network_slug = $this->generateSlug($request->input('network_name'));
            }

            if ($request->hasFile('network_image')) {
                if ($network instanceof Network) {
                    $this->updateNetworkImage($network, $request->file('network_image'));
                }
            }

            $network->save();
            return redirect()->route('admin.networks.index')->with('success', 'Network updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update network. Please try again.');
        }
    }

    public function deleteNetwork($id)
    {
        try {
            $network = Network::findOrFail($id);

            if ($network->network_image) {
                $this->fileManager->delete($network->network_image);
            }

            $network->delete();
            return redirect()->route('admin.networks.index')->with('success', 'Network deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete network. Please try again.');
        }
    }


    private function networkValidationRules(): array
    {
        return [
            'network_name' => 'required|string|max:50',
            'offerwall_url' => 'required|string',
            'level_id' => 'nullable|exists:levels,id',
            'network_description' => 'nullable|string|max:10',
            'network_rating' => 'required|integer|min:1|max:5',
            'network_image' => 'nullable|image:allow_svg|max:2048',
            'network_status' => 'required|in:1,0',
            'network_type' => 'required|in:offer,survey',
            'postback_method' => 'required|in:GET,POST',
            'param_url_visibility' => 'required|in:1,0',
            'param_custom_rate' => 'nullable|numeric|required_without:param_amount',
            'param_amount' => 'nullable|string|max:40|required_without:param_custom_rate',
            'param_payout' => 'nullable|string|max:40',
            'param_user_id' => 'required|string|max:40',
            'param_offer_id' => 'nullable|string|max:40',
            'param_offer_name' => 'nullable|string|max:40',
            'param_tx_id' => 'nullable|string|max:40',
            'param_ip' => 'nullable|string|max:40',
            'param_country' => 'nullable|string',
            'param_status' => 'nullable|string',
        ];
    }

    private function prepareNetworkData(Request $request, array $validatedData): array
    {
        $validatedData['network_slug'] = $this->generateSlug($validatedData['network_name']);
        $validatedData['param_secret'] = Str::random(10);

        if ($request->hasFile('network_image')) {
            $validatedData['network_image'] = $this->fileManager->uploadImage(
                $request->file('network_image'),
                'networks'
            );
        }

        return $validatedData;
    }

    private function generateSlug(string $networkName): string
    {
        return strtolower(str_replace(' ', '-', $networkName));
    }

    private function updateNetworkImage(Network $network, $imageFile): void
    {
        if ($network->network_image) {
            $this->fileManager->delete($network->network_image);
        }

        if ($newImagePath = $this->fileManager->uploadImage($imageFile, 'networks')) {
            $network->network_image = $newImagePath;
        }
    }

}
