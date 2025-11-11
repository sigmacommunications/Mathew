<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('admin.settings.index', compact('setting'));
    }

    public function Update(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'header_logo' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'footer_logo' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'contact_no' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string',
            'copyright' => 'nullable|string',
        ]);

        $setting = Setting::first() ?? new Setting();

        $setting->title = $request->input('title');
        $setting->contact_no = $request->input('contact_no');
        $setting->email = $request->input('email');
        $setting->description = $request->input('description');
        $setting->copyright = $request->input('copyright');
        if ($request->hasFile('header_logo')) {
            $fileName = time() . '_header.' . $request->header_logo->getClientOriginalExtension();
            $request->header_logo->storeAs('public/logos', $fileName);
            $setting->header_logo = $fileName;
        }
        if ($request->hasFile('footer_logo')) {
            $fileName = time() . '_footer.' . $request->footer_logo->getClientOriginalExtension();
            $request->footer_logo->storeAs('public/logos', $fileName);
            $setting->footer_logo = $fileName;
        }
        $setting->save();
        return redirect()->route('settings.index')->with('success', 'Settings updated successfully!');
    }
}
