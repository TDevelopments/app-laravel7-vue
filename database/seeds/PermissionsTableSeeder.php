<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::findByName('admin');
        
        //Permission list
        Permission::create(['name' => 'user']);
        Permission::create(['name' => 'products']);
        Permission::create(['name' => 'categories']);
        Permission::create(['name' => 'categories']);
        Permission::create(['name' => 'sale-state-order']);
        
        $admin->givePermissionTo([
            'sale-state-order'
        ]);
    }
}
