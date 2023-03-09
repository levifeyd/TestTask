<?php
namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Permissions
        $permissions = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete'
        ];
        $role = Role::findByName('Admin');
        foreach ($permissions as $permission) {
            $permission = Permission::create(['name' => $permission]);
            $role->syncPermissions($permission);
        }
    }
}

