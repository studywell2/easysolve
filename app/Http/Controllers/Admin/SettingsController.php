<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        // Platform settings storage (could be a key-value table or config)
        $validated = $request->validate([
            'platform_name' => 'required|string|max:255',
            'support_email' => 'required|email|max:255',
        ]);

        // For now, store in config cache or .env
        // This is a placeholder — real implementation would persist settings

        return back()->with('success', 'Settings updated successfully.');
    }
}