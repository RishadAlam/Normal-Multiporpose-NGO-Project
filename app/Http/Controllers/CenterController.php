<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Volume;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CenterController extends Controller
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
     * Get all Center
     * redirect view page
     */
    public function index()
    {
        $centers = Center::with('Volume')
            ->orderBy('volume_id')
            ->get();

        $vols = Volume::where('status', true)->get();
        // dd($centers);

        return view('offices.center.index', compact('centers', 'vols'));
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
        $Center = Center::find($id, ['id', 'status']);

        if ($Center->status == false) {
            $Center->status = true;
        } else {
            $Center->status = false;
        }
        $Center->save();

        return back()->with('success', 'Successfully changed Center status');
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
        $center = Center::find($id);

        return $center;
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
        $rules = ['up_name' => 'unique:volumes,name,' . $request->up_id, 'up_vol_id' => 'required'];
        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            return response()->json(['success' => false, 'message' => $validate->getMessageBag()->toArray()]);
        } else {
            Center::find($request->up_id)
                ->update(
                    [
                        'volume_id' => $request->up_vol_id,
                        'name' => $request->up_name,
                        'description' => $request->up_description,
                    ]
                );

            return response()->json(['success' => true, 'message' => 'Center Update Successfull']);
        }
    }
}
