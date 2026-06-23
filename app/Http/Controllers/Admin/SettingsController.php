<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'platform_name' => Setting::get('platform_name', 'EASYSOLVE'),
            'support_email' => Setting::get('support_email', 'support@easysolve.com'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'platform_name' => 'required|string|max:255',
            'support_email' => 'required|email|max:255',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
