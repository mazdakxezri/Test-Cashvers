<?php

namespace App\Http\Controllers\Admin\Offers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Offer;
use App\Lib\FileManagement;

class CustomOffersController extends Controller
{
    private $fileManager;

    const IMAGE_VALIDATION_RULES = 'image|mimes:jpeg,png,jpg,gif,svg|max:2048';

    public function __construct(FileManagement $fileManager)
    {
        $this->fileManager = $fileManager;
    }

    public function index(Request $request)
    {
        $perPage = $request->get('perPage', 15);
        $search = $request->get('search', '');

        $offers = Offer::where('type', 'custom')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('offer_id', 'like', '%' . $search . '%')
                    ->orWhere('partner', 'like', '%' . $search . '%');
            })
            ->paginate($perPage);

        return view('admin.offers.custom.index', compact('offers', 'search'));
    }


    public function create()
    {
        $countries = $this->getCountries();
        return view('admin.offers.custom.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validatedData = $this->validateOffer($request);

        // Handle file upload
        if ($request->hasFile('custom_offer_image')) {
            $validatedData['custom_offer_image'] = $this->fileManager->uploadImage(
                $request->file('custom_offer_image'),
                'offers/custom'
            );
        }

        Offer::create([
            'offer_id' => $validatedData['offer_id'],
            'name' => $validatedData['custom_offer_name'],
            'description' => $validatedData['custom_offer_description'],
            'requirements' => $validatedData['offer_requirement'],
            'payout' => $validatedData['custom_offer_payout'],
            'link' => $validatedData['custom_offer_link'],
            'creative' => $validatedData['custom_offer_image'],
            'countries' => implode(',', $validatedData['country']),
            'device' => $validatedData['offer_device'],
            'partner' => $validatedData['network_name'],
            'status' => $validatedData['status'],
            'type' => 'custom',
        ]);

        return redirect()->back()->with('success', 'Custom offer added successfully.');
    }

    public function edit($id)
    {
        $offer = Offer::findOrFail($id);
        $countries = $this->getCountries();
        $selectedCountries = explode(',', $offer->countries);
        return view('admin.offers.custom.edit', compact('offer', 'countries', 'selectedCountries'));
    }

    public function update(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);
        $validatedData = $this->validateOffer($request, $offer);

        if ($request->hasFile('custom_offer_image')) {
            $validatedData['custom_offer_image'] = $this->fileManager->uploadImage(
                $request->file('custom_offer_image'),
                'offers/custom'
            );
            $this->fileManager->delete($offer->creative);
        } else {
            $validatedData['custom_offer_image'] = $offer->creative;
        }

        $offer->update([
            'name' => $validatedData['custom_offer_name'],
            'description' => $validatedData['custom_offer_description'],
            'requirements' => $validatedData['offer_requirement'],
            'payout' => $validatedData['custom_offer_payout'],
            'link' => $validatedData['custom_offer_link'],
            'creative' => $validatedData['custom_offer_image'],
            'countries' => implode(',', $validatedData['country']),
            'device' => $validatedData['offer_device'],
            'partner' => $validatedData['network_name'],
            'status' => $validatedData['status'],
        ]);

        // Redirect with a success message
        return redirect()->back()
            ->with('success', 'Custom offer updated successfully.');
    }

    public function destroy(Request $request)
    {
        if ($offer = Offer::find($request->input('offer-id'))) {
            $offer->creative && $this->fileManager->delete($offer->creative);
            $offer->delete();
        }
        return back()->with('success', 'Offer deleted successfully.');
    }

    private function validateOffer(Request $request, $offer = null)
    {
        return $request->validate([
            'network_name' => 'required|string|max:255',
            'custom_offer_name' => 'required|string|max:255',
            'country' => 'required|array',
            'custom_offer_image' => $offer ? 'nullable|' . self::IMAGE_VALIDATION_RULES : 'required|' . self::IMAGE_VALIDATION_RULES,
            'custom_offer_payout' => 'required|numeric|min:0',
            'offer_id' => [
                'required',
                'string',
                'max:255',
                Rule::unique('offers')->where(function ($query) use ($request) {
                    return $query->where('partner', $request->input('network_name'));
                })->ignore($offer ? $offer->id : null),
            ],
            'offer_requirement' => 'required|string',
            'custom_offer_description' => 'required|string',
            'offer_device' => 'required|string|in:android,ios,desktop,all',
            'custom_offer_link' => 'required|string',
            'status' => 'required|boolean',
        ]);
    }


    private function getCountries()
    {
        $countries = json_decode(file_get_contents(storage_path('app/geoip/countries.json')), true);
        return array_column($countries, 'name', 'code');
    }
}
