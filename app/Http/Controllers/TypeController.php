<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeController extends Controller
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
     * Get all Types
     * redirect view page
     */
    public function index()
    {
        $types = Type::all();

        return view('offices.type.index', compact('types'));
    }

    /**
     * Switch Status
     */
    public function statusSwitch($id)
    {
        /**
         * Get the Types
         * Update Types status
         * Redirect to view page
         */
        $vol = Type::find($id, ['id', 'status']);

        if ($vol->status == false) {
            $vol->status = true;
        } else {
            $vol->status = false;
        }
        $vol->save();

        return back()->with('success', 'Successfully changed Type status');
    }

    /**
     * Types Edit Page
     */
    public function edit($id)
    {
        /**
         * Find Types
         * Return Types
         */
        $Type = Type::find($id);

        return $Type;
    }


    /**
     * Update Types
     */
    public function update(Request $request)
    {
        // dd($request->all());
        /**
         * Validate Data
         * Mass Assignment
         * Return Message
         */
        $validate = Validator::make($request->all(), ['up_name' => 'unique:types,name,' . $request->up_id]);

        if ($validate->fails()) {
            return response()->json(['success' => false, 'message' => 'Type Name already exists!']);
        } else {
            $type = Type::find($request->up_id);
            $type->name = $request->up_name;
            $type->description = $request->up_description;
            $type->savings = ($request->up_saving ? $request->up_saving : false);
            $type->loans = ($request->up_loan ? $request->up_loan : false);
            $type->time_period = $request->up_time;
            $type->save();

            return response()->json(['success' => true, 'message' => 'Type Update Successfull']);
        }
    }
}
