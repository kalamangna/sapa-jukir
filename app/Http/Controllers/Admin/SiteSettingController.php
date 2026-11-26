<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::query()->firstOrNew();

        return view('admin.site-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'hero_title' => ['nullable', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string', 'max:2000'],
            'service_hours' => ['nullable', 'string', 'max:100'],
            'location_name' => ['nullable', 'string', 'max:255'],
            'location_url' => ['nullable', 'url:http,https', 'max:500'],
            'whatsapp_number' => ['nullable', 'string', 'max:100'],
            'whatsapp_url' => ['nullable', 'url:http,https', 'max:500'],
            'instagram' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
        ]);

        $settings = SiteSetting::query()->firstOrNew();

        if ($request->hasFile('hero_image')) {
            if (! empty($settings->hero_image) && Storage::disk('public')->exists($settings->hero_image)) {
                Storage::disk('public')->delete($settings->hero_image);
            }

            $data['hero_image'] = $request->file('hero_image')->store('site-settings', 'public');
        }

        $settings->fill($data)->save();

        return redirect()->route('admin.site-settings.index')->with('success', 'Pengaturan halaman publik berhasil disimpan.');
    }
}
