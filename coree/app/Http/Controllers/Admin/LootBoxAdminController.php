<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LootBoxType;
use App\Models\LootBoxItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LootBoxAdminController extends Controller
{
    /**
     * Display list of loot box types
     */
    public function index()
    {
        $lootBoxTypes = LootBoxType::with('items')->orderBy('order')->get();
        
        return view('admin.lootbox.index', compact('lootBoxTypes'));
    }
    
    /**
     * Show form to create new loot box type
     */
    public function create()
    {
        return view('admin.lootbox.create');
    }
    
    /**
     * Store new loot box type
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_usd' => 'required|numeric|min:0',
            'order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:2048'
        ]);
        
        $validated['slug'] = Str::slug($validated['name']);
        $validated['can_buy_with_earnings'] = $request->has('can_buy_with_earnings');
        $validated['can_buy_with_crypto'] = $request->has('can_buy_with_crypto');
        $validated['is_active'] = $request->has('is_active');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/images/lootbox'), $imageName);
            $validated['image'] = 'assets/images/lootbox/' . $imageName;
        }
        
        LootBoxType::create($validated);
        
        return redirect()->route('admin.lootbox.index')->with('success', 'Loot box created successfully!');
    }
    
    /**
     * Show form to edit loot box type
     */
    public function edit(LootBoxType $lootBoxType)
    {
        return view('admin.lootbox.edit', compact('lootBoxType'));
    }
    
    /**
     * Update loot box type
     */
    public function update(Request $request, LootBoxType $lootBoxType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_usd' => 'required|numeric|min:0',
            'order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|max:2048'
        ]);
        
        $validated['slug'] = Str::slug($validated['name']);
        $validated['can_buy_with_earnings'] = $request->has('can_buy_with_earnings');
        $validated['can_buy_with_crypto'] = $request->has('can_buy_with_crypto');
        $validated['is_active'] = $request->has('is_active');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/images/lootbox'), $imageName);
            $validated['image'] = 'assets/images/lootbox/' . $imageName;
        }
        
        $lootBoxType->update($validated);
        
        return redirect()->route('admin.lootbox.index')->with('success', 'Loot box updated successfully!');
    }
    
    /**
     * Delete loot box type
     */
    public function destroy(LootBoxType $lootBoxType)
    {
        $lootBoxType->delete();
        
        return redirect()->route('admin.lootbox.index')->with('success', 'Loot box deleted successfully!');
    }
    
    /**
     * Show items for a loot box type
     */
    public function showItems(LootBoxType $lootBoxType)
    {
        $items = $lootBoxType->items()->orderBy('rarity')->get();
        
        return view('admin.lootbox.items', compact('lootBoxType', 'items'));
    }
    
    /**
     * Store new item for loot box
     */
    public function storeItem(Request $request, LootBoxType $lootBoxType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'value' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'rarity' => 'required|in:common,uncommon,rare,epic,legendary',
            'drop_rate' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048'
        ]);
        
        $validated['loot_box_type_id'] = $lootBoxType->id;
        $validated['is_active'] = $request->has('is_active');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/images/lootbox'), $imageName);
            $validated['image'] = 'assets/images/lootbox/' . $imageName;
        }
        
        LootBoxItem::create($validated);
        
        return redirect()->route('admin.lootbox.items', $lootBoxType)->with('success', 'Item added successfully!');
    }
    
    /**
     * Update loot box item
     */
    public function updateItem(Request $request, LootBoxItem $item)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'value' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'rarity' => 'required|in:common,uncommon,rare,epic,legendary',
            'drop_rate' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:2048'
        ]);
        
        $validated['is_active'] = $request->has('is_active');
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/images/lootbox'), $imageName);
            $validated['image'] = 'assets/images/lootbox/' . $imageName;
        }
        
        $item->update($validated);
        
        return redirect()->route('admin.lootbox.items', $item->lootBoxType)->with('success', 'Item updated successfully!');
    }
    
    /**
     * Delete loot box item
     */
    public function destroyItem(LootBoxItem $item)
    {
        $lootBoxTypeId = $item->loot_box_type_id;
        $item->delete();
        
        return redirect()->route('admin.lootbox.items', $lootBoxTypeId)->with('success', 'Item deleted successfully!');
    }
}

