<?php

namespace App\Http\Controllers\Employee;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class EmployeeController extends Controller
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
     * Employee Page
     */
    public function index()
    {
        /**
         * Get All user
         * Redirect to view page
         */
        $users = User::whereNotIn('email', ['admin@gmail.com'])->get();

        return view('offices.employee.index', compact('users'));
    }

    /**
     * Employee Edit Page
     */
    public function edit($id)
    {
        /**
         * Find employee
         * Get Roles
         * Redirect to view page
         */
        $user = User::find($id);
        $roles = Role::whereNotIn('name', ['Developer'])->get();

        return view('offices.employee.edit', compact('user', 'roles'));
    }

    /**
     * Employee Update
     */
    public function update(Request $request, $id)
    {
        /**
         * Validate Request Data
         * Find employee
         * Update Data
         * Redirect to view page
         */
        $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'role' => ['required']
        ]);
        if (!empty($request->mobile)) {
            $request->validate([
                'mobile' => ['min:11', 'max:11']
            ]);
        }

        // Update Data
        $user = User::find($id)
            ->update(
                [
                    'name' => $request->name,
                    'mobile' => $request->mobile
                ]
            );

        // Update Role
        User::find($id)->syncRoles($request->role);

        return redirect(Route('employee'))->with('success', "Information Update Successsfully");
    }

    /**
     * Switch Status
     */
    public function statusSwitch($id)
    {
        /**
         * Get User
         * Update User status
         * Redirect to view page
         */
        $user = User::find($id, ['id', 'status']);

        if ($user->status == false) {
            $user->status = true;
        } else {
            $user->status = false;
        }
        $user->save();

        return back()->with('success', 'Successfully changed Employee status');
    }
}
