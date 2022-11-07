<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissionPlaceOrder = Permission::create(['name' => 'place order']);
        $permissionAddMoney = Permission::create(['name' => 'add money']);
        $permissionViewProduct = Permission::create(['name' => 'view product']);


        $admin = Role::create(['name' => 'admin']);
        $customer = Role::create(['name' => 'customer']);

        $customer->syncPermissions([
            $permissionPlaceOrder,
            $permissionAddMoney,
            $permissionViewProduct
        ]);
    }
}
