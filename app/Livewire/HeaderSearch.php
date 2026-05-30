<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Item;
use App\Models\User;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Category;
use App\Models\Store;

class HeaderSearch extends Component
{
    public string $search = '';
    public array $results = [];

    public function updatedSearch(): void
    {
        $this->results = [];

        if (strlen($this->search) < 2) {
            return;
        }

        $searchTerm = '%' . $this->search . '%';

        // 1. Items
        try {
            $items = Item::where('name', 'like', $searchTerm)
                ->orWhere('sku', 'like', $searchTerm)
                ->orWhere('barcode', 'like', $searchTerm)
                ->take(5)
                ->get()
                ->map(fn ($item) => [
                    'title' => $item->name,
                    'subtitle' => 'SKU: ' . $item->sku . ' | Stock: ' . $item->stock_quantity,
                    'url' => route('items.show', $item->id),
                    'image' => $item->image ? asset('storage/' . $item->image) : null,
                    'icon' => 'fa-solid fa-box',
                ])
                ->toArray();
            if (count($items) > 0) {
                $this->results['Items'] = $items;
            }
        } catch (\Throwable $e) {
            // Skip if items table/columns don't exist
        }

        // 2. Users
        try {
            $users = User::where('name', 'like', $searchTerm)
                ->orWhere('email', 'like', $searchTerm)
                ->take(5)
                ->get()
                ->map(fn ($user) => [
                    'title' => $user->name,
                    'subtitle' => $user->email,
                    'url' => route('users.show', $user->id),
                    'image' => $user->pic_url ?? null,
                    'icon' => 'fa-solid fa-user',
                ])
                ->toArray();
            if (count($users) > 0) {
                $this->results['Users'] = $users;
            }
        } catch (\Throwable $e) {
            // Skip if users table/columns don't exist
        }

        // 3. Customers
        try {
            $customers = Customer::where('name', 'like', $searchTerm)
                ->orWhere('email', 'like', $searchTerm)
                ->orWhere('phone', 'like', $searchTerm)
                ->take(5)
                ->get()
                ->map(fn ($customer) => [
                    'title' => $customer->name,
                    'subtitle' => $customer->email ?? $customer->phone ?? 'Customer',
                    'url' => route('customers.edit', $customer->id),
                    'image' => null,
                    'icon' => 'fa-solid fa-users',
                ])
                ->toArray();
            if (count($customers) > 0) {
                $this->results['Customers'] = $customers;
            }
        } catch (\Throwable $e) {
            // Skip if customers table/columns don't exist
        }

        // 4. Suppliers
        try {
            $suppliers = Supplier::where('name', 'like', $searchTerm)
                ->orWhere('email', 'like', $searchTerm)
                ->orWhere('phone', 'like', $searchTerm)
                ->take(5)
                ->get()
                ->map(fn ($supplier) => [
                    'title' => $supplier->name,
                    'subtitle' => $supplier->email ?? $supplier->phone ?? 'Supplier',
                    'url' => route('suppliers.show', $supplier->id),
                    'image' => null,
                    'icon' => 'fa-solid fa-truck-field',
                ])
                ->toArray();
            if (count($suppliers) > 0) {
                $this->results['Suppliers'] = $suppliers;
            }
        } catch (\Throwable $e) {
            // Skip if suppliers table/columns don't exist
        }

        // 5. Categories
        try {
            $categories = Category::where('name', 'like', $searchTerm)
                ->take(5)
                ->get()
                ->map(fn ($category) => [
                    'title' => $category->name,
                    'subtitle' => $category->description ?? 'Category',
                    'url' => route('categories.show', $category->id),
                    'image' => null,
                    'icon' => 'fa-solid fa-tags',
                ])
                ->toArray();
            if (count($categories) > 0) {
                $this->results['Categories'] = $categories;
            }
        } catch (\Throwable $e) {
            // Skip if categories table/columns don't exist
        }

        // 6. Stores
        try {
            $stores = Store::where('name', 'like', $searchTerm)
                ->take(5)
                ->get()
                ->map(fn ($store) => [
                    'title' => $store->name,
                    'subtitle' => $store->location ?? 'Store',
                    'url' => route('stores.edit', $store->id),
                    'image' => null,
                    'icon' => 'fa-solid fa-store',
                ])
                ->toArray();
            if (count($stores) > 0) {
                $this->results['Stores'] = $stores;
            }
        } catch (\Throwable $e) {
            // Skip if stores table/columns don't exist
        }
    }

    public function render()
    {
        return view('livewire.header-search');
    }
}
