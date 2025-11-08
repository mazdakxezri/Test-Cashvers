<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Services\AchievementService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AchievementAdminController extends Controller
{
    protected $achievementService;

    public function __construct(AchievementService $achievementService)
    {
        $this->achievementService = $achievementService;
    }

    /**
     * Display list of achievements
     */
    public function index()
    {
        $achievements = Achievement::orderBy('category')->orderBy('order')->paginate(20);
        
        return view('admin.achievements.index', compact('achievements'));
    }

    /**
     * Show form to create achievement
     */
    public function create()
    {
        return view('admin.achievements.create');
    }

    /**
     * Store new achievement
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:10',
            'category' => 'required|in:earning,milestone,social,special',
            'tier' => 'required|in:bronze,silver,gold,platinum,diamond',
            'points' => 'required|integer|min:0',
            'reward_amount' => 'required|numeric|min:0',
            'requirement_type' => 'required|string',
            'requirement_count' => 'required|integer|min:1',
            'order' => 'nullable|integer',
        ]);

        // Generate unique key from name
        $key = Str::slug($validated['name'], '_');
        $counter = 1;
        while (Achievement::where('key', $key)->exists()) {
            $key = Str::slug($validated['name'], '_') . '_' . $counter;
            $counter++;
        }

        Achievement::create([
            'key' => $key,
            'name' => $validated['name'],
            'description' => $validated['description'],
            'icon' => $validated['icon'],
            'category' => $validated['category'],
            'tier' => $validated['tier'],
            'points' => $validated['points'],
            'reward_amount' => $validated['reward_amount'],
            'requirements' => [
                'type' => $validated['requirement_type'],
                'count' => $validated['requirement_count'],
            ],
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->has('is_active'),
            'is_hidden' => $request->has('is_hidden'),
        ]);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Achievement created successfully!');
    }

    /**
     * Show edit form
     */
    public function edit(Achievement $achievement)
    {
        return view('admin.achievements.edit', compact('achievement'));
    }

    /**
     * Update achievement
     */
    public function update(Request $request, Achievement $achievement)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:10',
            'category' => 'required|in:earning,milestone,social,special',
            'tier' => 'required|in:bronze,silver,gold,platinum,diamond',
            'points' => 'required|integer|min:0',
            'reward_amount' => 'required|numeric|min:0',
            'requirement_type' => 'required|string',
            'requirement_count' => 'required|integer|min:1',
            'order' => 'nullable|integer',
        ]);

        $achievement->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'icon' => $validated['icon'],
            'category' => $validated['category'],
            'tier' => $validated['tier'],
            'points' => $validated['points'],
            'reward_amount' => $validated['reward_amount'],
            'requirements' => [
                'type' => $validated['requirement_type'],
                'count' => $validated['requirement_count'],
            ],
            'order' => $validated['order'] ?? 0,
            'is_active' => $request->has('is_active'),
            'is_hidden' => $request->has('is_hidden'),
        ]);

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Achievement updated successfully!');
    }

    /**
     * Delete achievement
     */
    public function destroy(Achievement $achievement)
    {
        $achievement->delete();

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Achievement deleted successfully!');
    }

    /**
     * Seed default achievements
     */
    public function seed()
    {
        $this->achievementService->seedDefaultAchievements();

        return redirect()->route('admin.achievements.index')
            ->with('success', 'Default achievements seeded successfully!');
    }
}

