<?php

namespace App\Http\Controllers\Employee;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class EmployeePermissionController extends Controller
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
     * Employee Permissions
     */
    public function permissions(Request $request)
    {
        /**
         * Get All employee
         * Get All permissions
         * Get ALl Permission Groups
         * Get Employee Permissions
         * Redirect to view page
         */
        $employees = User::whereNotIn('email', ['admin@gmail.com'])->get();
        $permissions = Permission::orderBy('name')->get();
        $groups = Permission::select('group_name')->distinct()->orderBy('group_name')->get();
        $user_permissions = null;

        if (!empty($request->all())) {
            $user_permissions = User::find($request->employee)->getPermissionNames();
        }
        return view('offices.employee.permissions', compact('employees', 'permissions', 'user_permissions', 'groups'));
    }


    /**
     * Employee Permissions Update
     */
    public function PermissionUpdate(Request $request, $id)
    {
        /**
         * Find employee
         * Sync Permissions
         * Redirect to view page
         */
        $employee =  User::find($id);
        $employee->syncPermissions($request->permissions);

        return redirect(Route('employee'))->with('success', "Permission granted to " . $employee->name . "");
    }
}
