<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Level;


class LevelController extends Controller
{
    protected function validateRequest(Request $request, $id = null)
    {
        return $request->validate([
            'level_number' => 'required|integer|unique:levels,level' . ($id ? ",$id" : ''),
            'required_earning' => 'required|integer',
            'reward' => 'required|numeric|min:0',
        ]);
    }

    public function index(Request $request)
    {
        $levels = Level::orderBy('level', 'asc')
            ->paginate($request->get('perPage', 15));

        return view('admin.levels.index', compact('levels'));
    }

    public function create()
    {
        return view('admin.levels.create');
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        Level::create([
            'level' => $request->level_number,
            'required_earning' => $request->required_earning,
            'reward' => $request->reward,
        ]);

        return redirect()->back()->with('success', 'Level created successfully.');
    }

    public function edit($id)
    {
        $level = Level::findOrFail($id);
        return view('admin.levels.edit', compact('level'));
    }

    public function update(Request $request, $id)
    {
        $this->validateRequest($request, $id);

        $level = Level::findOrFail($id);
        $level->update([
            'level' => $request->level_number,
            'required_earning' => $request->required_earning,
            'reward' => $request->reward,
        ]);

        return redirect()->route('admin.levels.index')->with('success', 'Level updated successfully.');
    }

    public function destroy(Request $request)
    {
        Level::findOrFail($request->input('level-id'))->delete();

        return redirect()->route('admin.levels.index')->with('success', 'Level deleted successfully.');
    }
}
