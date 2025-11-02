<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Track;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = (int) $request->input('perPage', 15);
        $query = Track::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('offer_name', 'like', '%' . $search . '%')
                    ->orWhere('offer_id', $search)
                    ->orWhere('uid', $search)
                    ->orWhere('partners', 'like', '%' . $search . '%');
            });
        }
        $query->orderBy('created_at', 'desc');
        $historys = $query->paginate($perPage);
        return view('admin.history', compact('historys', 'search', 'perPage'));
    }




}
