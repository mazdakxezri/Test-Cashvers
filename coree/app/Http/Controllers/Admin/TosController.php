<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TermsOfServiceManagements;


class TosController extends Controller
{
    public function index()
    {
        $tos = TermsOfServiceManagements::first();

        if (!$tos) {
            $tos = new TermsOfServiceManagements();
        }

        return view('admin.tos', compact('tos'));
    }

    public function savePolicy(Request $request)
    {
        $request->validate([
            'privacy_policy' => 'required',
        ]);

        $tos = TermsOfServiceManagements::first();

        if (!$tos) {
            $tos = new TermsOfServiceManagements();
        }

        $tos->privacy_policy = $request->input('privacy_policy');
        $tos->privacy_policy_updated_at = now();

        $tos->save();

        return redirect()->back();
    }

    public function saveTerms(Request $request)
    {
        $request->validate([
            'terms_of_use' => 'required',
        ]);

        $tos = TermsOfServiceManagements::first();

        if (!$tos) {
            $tos = new TermsOfServiceManagements();
        }

        $tos->terms_of_use = $request->input('terms_of_use');
        $tos->terms_of_use_updated_at = now();

        $tos->save();

        return redirect()->back();
    }


}
