<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $super_admin = ['name'  => 'Admin','email' => 'admin@admin.com','password' =>bcrypt('password')];
        $admins = [
            ['name'  => 'Editor','email' => 'editor@editor.com','password' =>bcrypt('password')],
            ['name'  => 'Author','email' => 'author@author.com','password' =>bcrypt('password')],
        ];
        $super = Admin::Create($super_admin);
        $admin = Admin::Insert($admins);
        $role = Role::create(['name' => 'Admin','guard_name' => 'admin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $super->assignRole($role->name);
//
//        Role::insert([
//            ['name'=>'Admin','slug'=>'admin'],
//            ['name'=>'Editor','slug'=>'editor'],
//            ['name'=>'Author','slug'=>'author'],
//        ]);
//
//        Permission::insert([
//            ['name'=>'Add News','slug'=>'add-post'],
//            ['name'=>'Delete News','slug'=>'delete-post'],
//        ]);
//
//        // Assign Role
//        Admin::whereId(1)->first()->roles()->attach([1]);
//        Admin::whereId(2)->first()->roles()->attach([2]);
//        Admin::whereId(3)->first()->roles()->attach([3]);
//
//        // Role has Permission
//        Role::whereId(1)->first()->permissions()->attach([1,2]);
//        Role::whereId(2)->first()->permissions()->attach([1]);
//        Role::whereId(3)->first()->permissions()->attach([1]);

    }
}
