<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;

class EmailTemplateController extends Controller
{
    public function index()
    {
        $emailTemplates = EmailTemplate::all();
        return view('admin.email_templates', compact('emailTemplates'));
    }
    public function updateAll(Request $request)
    {
        // Validate content is array and not empty
        $request->validate([
            'content' => 'required|array',
        ]);

        $contents = $request->input('content');

        foreach ($contents as $id => $content) {
            // Find template by id
            $template = EmailTemplate::find($id);
            if ($template) {
                $template->content = $content;
                $template->save();
            }
        }

        return redirect()->route('admin.email-templates.index')
            ->with('success', 'Email templates updated successfully!');
    }
}
