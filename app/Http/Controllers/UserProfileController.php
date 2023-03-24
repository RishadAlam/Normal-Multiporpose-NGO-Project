<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('offices.user.profile');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function passwordChenge(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'confirm_password' => 'required|same:new_password',
        ]);

        #Match The Old Password
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return back()->withErrors("Wrong Password!");
        }

        #Update the new Password
        User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with("success", "Password Changed Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('offices.user.profileEdit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'min:11|max:11',
            'image' => 'mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if (!empty($request->image)) {
            if (auth()->user()->image != null) {
                $path = public_path('storage/user/' . auth()->user()->image . '');
                unlink($path);
            }
            $extention = $request->image->extension();
            $imgName = 'user_' . time() . '.' . $extention;
            $imagePath = $request->image->storeAs('user/', $imgName, 'public');

            User::find(auth()->user()->id)
                ->update(
                    [
                        'image' => $imgName
                    ]
                );
        }

        User::find(auth()->user()->id)
            ->update(
                [
                    'name' => $request->name,
                    'father_name' => $request->father_name,
                    'mother_name' => $request->mother_name,
                    'nid' => $request->nid,
                    'mobile' => $request->mobile,
                    'dob' => date('Y-m-d', strtotime($request->dob)),
                    'bloog_group' => $request->bloog_group
                ]
            );

        return back()->with("success", "Profile Update Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
