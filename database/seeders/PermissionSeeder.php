<?php

namespace Database\Seeders;

use getways\users\models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $curd_permissions = [
            'users','branches','questions', 'cites', 'roles', 'admins', 'transactions', 'products'
        ];
        $crud_methods = ['index', 'show', 'create', 'update', 'delete'];
        $single_permission = [
            'home', 'updateSettings', 'showSettings', 'goldprices_index', 'goldprices_create', 'goldprices_update'
            , 'users_operation', 'manufacturings_index'
        ];
        $all_crud_permissions = [];
        foreach ($curd_permissions as $permission){
            foreach ($crud_methods as $method){
                $all_crud_permissions[] = $permission . '_' . $method;
            }
        }

        $permissions = array_merge($all_crud_permissions, $single_permission);
        $role = Role::updateOrCreate([
            'name'=>'Super_admin',
        ],[
            'name'=>'Super_admin',
            'guard_name'=>'admin'
        ]);
        foreach ($permissions as $row){
            $permission = Permission::updateOrCreate([
                'name'=>$row
            ],[
                'name'=>$row,
                'guard_name'=>'admin'
            ]);
            $role->givePermissionTo($permission);
        }

        Admin::first()->assignRole('Super_admin');
    }
}
