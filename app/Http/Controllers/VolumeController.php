<?php

namespace App\Http\Controllers;

use App\Models\Volume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VolumeController extends Controller
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
     * Get all Volume
     * redirect view page
     */
    public function index()
    {
        $vols = Volume::all();

        return view('offices.volume.index', compact('vols'));
    }

    /**
     * Switch Status
     */
    public function statusSwitch($id)
    {
        /**
         * Get the Volume
         * Update Volume status
         * Redirect to view page
         */
        $vol = Volume::find($id, ['id', 'status']);

        if ($vol->status == false) {
            $vol->status = true;
        } else {
            $vol->status = false;
        }
        $vol->save();

        return back()->with('success', 'Successfully changed Volume status');
    }

    /**
     * Volume Edit Page
     */
    public function edit($id)
    {
        /**
         * Find Volume
         * Return Volume
         */
        $vol = Volume::find($id);

        return $vol;
    }


    /**
     * Update volume
     */
    public function update(Request $request)
    {
        // dd($request->all());
        /**
         * Validate Data
         * Mass Assignment
         * Return Message
         */
        $validate = Validator::make($request->all(), ['up_name' => 'unique:volumes,name,' . $request->up_id]);

        if ($validate->fails()) {
            return response()->json(['success' => false, 'message' => 'Volume Name already exists!']);
        } else {
            Volume::find($request->up_id)
                ->update(
                    [
                        'name' => $request->up_name,
                        'description' => $request->up_description,
                    ]
                );

            return response()->json(['success' => true, 'message' => 'Volume Update Successfull']);
        }
    }
}
