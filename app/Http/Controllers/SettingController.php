<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Get All data
     * Return View page
     */
    public function index()
    {
        $setting = Setting::first();
        return view('offices.settings.index', compact('setting'));
    }

    /**
     * Update Settings
     * Validate Data
     * delete old logo
     * extract Image extension
     * store image
     * update data
     * return back
     */
    public function update(Request $request)
    {
        // dd($request->logo->extension());

        // Validate Data
        $request->validate([
            'logo' => 'mimes:jpeg,png,jpg,webp|max:2048',
            'full_name' => 'required',
            'short_name' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        // Delete Old Logo
        if(!empty($request->logo)){
            if(!empty($request->old_logo)){
                $del = public_path('storage/settings/' . $request->old_logo . '');
                unlink($del);
            }
            
            // Extract Extension & store image
            $logoExt = $request->logo->extension();
            $logoName = 'logo_' . time() . '.' . $logoExt;
            $request->logo->storeAs('settings/', $logoName, 'public');

            // Update Logo
            Setting::first()->update([
                'logo' => $logoName,
            ]);
        }

        // Update data
        Setting::first()->update([
            'full_name' => $request->full_name, 
            'short_name' => $request->short_name,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return back()->with('success', 'Update Successfull');
    }
}
