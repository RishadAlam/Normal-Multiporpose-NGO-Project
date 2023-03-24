<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Arr;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Create Role
        $roleDeveloper = Role::create(['name' => 'Developer']);
        $roleSuperAdmin = Role::create(['name' => 'Super Admin']);
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleUser = Role::create(['name' => 'Field Officer']);

        // Permission
        $permissions = [
            // Dashboard
            [
                'groupName' => 'Dashboard',
                'permissions' => [
                    'Dashboard View as an Admin'
                ]
            ],
            // Registrations
            [
                'groupName' => 'Registration',
                'permissions' => [
                    'New Client Registration',
                    'Saving Account Registration',
                    'Loan Account Registration',
                    'Officer Selection in Account Registration'
                ]
            ],
            // Collection Form
            [
                'groupName' => 'Collection Form',
                'permissions' => [
                    'Loans Collection',
                    'Savings Collection'
                ]
            ],
            // Collection Report
            [
                'groupName' => 'Collection Report',
                'permissions' => [
                    'Regular Collections',
                    'Pending Collections',
                    'Collection Edit',
                    'Collection Delete',
                    'Collection Approval',
                    'Collection Report View as an Admin'
                ]
            ],
            // Withdrawal Form
            [
                'groupName' => 'Withdrawal Form',
                'permissions' => [
                    'Savings Withdrawal',
                    'Savings Withdrawal Officer Selection',
                    'Loan Savings Withdrawal',
                    'Loan Savings Withdrawal Officer Selection'
                ]
            ],
            // Closing Form
            [
                'groupName' => 'Closing Form',
                'permissions' => [
                    'Saving Account Closing',
                    'Loan Account Closing',
                ]
            ],
            // Withdrawal Report
            [
                'groupName' => 'Withdrawal Report',
                'permissions' => [
                    'Regular Savings Withdrawal Report',
                    'Loan Savings Withdrawal Report',
                    'Withdrawal Edit',
                    'Withdrawal Delete',
                    'Withdrawal Approval',
                    'Withdrawal Report View as an Admin'
                ]
            ],
            // Transaction Form
            [
                'groupName' => 'Transaction Form',
                'permissions' => [
                    'Savings to Savings',
                    'Savings to Loan Savings',
                    'Loan Savings to Loan Savings',
                    'Loan Savings to Savings',
                    'Officer Selection in Transaction Forms'
                ]
            ],
            // Transaction Report
            [
                'groupName' => 'Transaction Report',
                'permissions' => [
                    'Savings to Savings Report',
                    'Savings to Loan Savings Report',
                    'Loan Savings to Loan Savings Report',
                    'Loan Savings to Savings Report',
                    'Transaction Report View as an Admin',
                    'Transaction Edit',
                    'Transaction Delete',
                    'Transaction Approval'
                ]
            ],
            // Analytics
            [
                'groupName' => 'Analytics',
                'permissions' => [
                    'Analytics View',
                    'Analytics View as an Admin',
                ]
            ],
            // Center
            [
                'groupName' => 'Center',
                'permissions' => [
                    'Center Create',
                    'Center Edit',
                    'Center Status Edit',
                    'Center View'
                ]
            ],
            // Volume
            [
                'groupName' => 'Volume',
                'permissions' => [
                    'Volume Create',
                    'Volume Edit',
                    'Volume Status Edit',
                    'Volume View'
                ]
            ],
            // Type
            [
                'groupName' => 'Type',
                'permissions' => [
                    'Type Create',
                    'Type Edit',
                    'Type Status Edit',
                    'Type View'
                ]
            ],
            // Employee
            [
                'groupName' => 'Employee',
                'permissions' => [
                    'Employee Edit',
                    'Employee Permissions',
                    'Employee Registration',
                    'Employee Status Edit',
                    'Employee View'
                ]
            ],
            // Client Account
            [
                'groupName' => 'Client Account',
                'permissions' => [
                    'Check Account',
                    'Account Collection Edit',
                    'Account Collection Delete',
                    'Client Register Edit',
                    'Client Saving Account Edit',
                    'Client Loan Account Edit'
                ]
            ],
            // Settings
            [
                'groupName' => 'Settings',
                'permissions' => [
                    'Settings'
                ]
            ],
        ];

        /**
         * Find user
         */
        $user = User::where('email', 'admin@gmail.com')->first();
        $user->assignRole($roleDeveloper);

        for ($j = 2; $j < 12; $j++) {
            $role = Arr::random([$roleDeveloper, $roleSuperAdmin, $roleAdmin, $roleUser]);
            User::find($j)->assignRole($role);
            // $user->assignRole($roleDeveloper);
        }

        foreach ($permissions as $row) {
            $groupName = $row['groupName'];
            foreach ($row['permissions'] as $permission) {
                $permission = Permission::create(
                    [
                        'name' => $permission,
                        'group_name' => $groupName
                    ]
                );
                $user->givePermissionTo($permission);
            }
        }
    }
}
