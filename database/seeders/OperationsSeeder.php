<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\Customer;
use App\Models\Item;
use App\Models\StoreItem;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class OperationsSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Permissions
        $permissions = [
            'view stores', 'create stores', 'edit stores', 'delete stores',
            'view customers', 'create customers', 'edit customers', 'delete customers',
            'view sales', 'create sales',
            'view purchases', 'create purchases',
            'view transfers', 'create transfers',
            'view damage', 'create damage',
            'view reports', 'generate qr'
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        // 2. Assign to Admin Role
        $adminRole = Role::findByName('Admin');
        $adminRole->givePermissionTo(Permission::all());

        // 3. Assign to Manager Role
        $managerRole = Role::findByName('Manager');
        $managerRole->givePermissionTo([
            'view stores', 'create stores', 'edit stores',
            'view customers', 'create customers', 'edit customers',
            'view sales', 'create sales',
            'view purchases', 'create purchases',
            'view transfers', 'create transfers',
            'view damage', 'create damage',
            'view reports', 'generate qr'
        ]);

        // 4. Create Stores
        $store1 = Store::firstOrCreate(['code' => 'ST01'], [
            'name' => 'Main Warehouse',
            'location' => 'Building A, New York',
            'status' => true
        ]);

        $store2 = Store::firstOrCreate(['code' => 'ST02'], [
            'name' => 'Downtown Retail Store',
            'location' => 'Sleek Avenue, New York',
            'status' => true
        ]);

        // 5. Create Customers
        Customer::firstOrCreate(['email' => 'john.doe@gmail.com'], [
            'name' => 'John Doe',
            'phone' => '+15550199',
            'address' => '123 Main St, New York',
            'status' => true
        ]);

        Customer::firstOrCreate(['email' => 'jane.smith@gmail.com'], [
            'name' => 'Jane Smith',
            'phone' => '+15550244',
            'address' => '456 Broadway, New York',
            'status' => true
        ]);

        // 6. Seed stock levels for items in stores
        $items = Item::all();
        foreach ($items as $item) {
            StoreItem::firstOrCreate([
                'store_id' => $store1->id,
                'item_id' => $item->id
            ], [
                'stock_quantity' => rand(50, 100)
            ]);

            StoreItem::firstOrCreate([
                'store_id' => $store2->id,
                'item_id' => $item->id
            ], [
                'stock_quantity' => rand(10, 30)
            ]);

            // Sync global item stock_quantity with sum of store items
            $item->update([
                'stock_quantity' => StoreItem::where('item_id', $item->id)->sum('stock_quantity')
            ]);
        }
    }
}
