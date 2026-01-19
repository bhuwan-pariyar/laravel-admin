<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Livewire\DataTable;

class UsersTable extends DataTable
{
    protected string $model = User::class;

    protected $listeners = ['userCreated' => 'resetPage'];

    protected array $modalConfig = [
        'create' => [
            'component' => 'users.create',
            'title' => 'Add New User',
            'size' => 'md',
        ],
    ];

    protected array $columns = [
        [
            'label' => 'ID',
            'field' => 'id',
            'width' => 'w-20',
            'searchable' => false,
            'orderable' => true,
        ],
        [
            'label' => 'Image',
            'field' => 'pic',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'image',
            'orderable' => false,
        ],
        [
            'label' => 'Name',
            'field' => 'name',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => true,
        ],
        [
            'label' => 'Email',
            'field' => 'email',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => true,
        ],
        [
            'label' => 'Status',
            'field' => 'status',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'statusBadge',
            'orderable' => true,
        ],
        [
            'label' => 'Date',
            'field' => 'created_at',
            'width' => 'w-auto',
            'searchable' => false,
            'orderable' => true,
        ],
    ];

    protected array $filters = [
        'status' => [
            'type' => 'select',
            'label' => 'Status',
            'options' => [
                '1' => 'Active',
                '0' => 'Inactive',
            ],
        ],
        'created_at' => [
            'type' => 'range',
            'label' => 'Range',
        ],
    ];

    protected array $executions = [
        'create' => 'items.create',
    ];

    protected function image($row)
    {
        if ($row->pic) {
            $imgUrl = asset('storage/' . $row->pic);
            return '<img src="' . $imgUrl . '" alt="User Image" class="w-10 h-10 rounded-full">';
        }

        $nameParts = explode(' ', trim($row->name));
        $initials = strtoupper(substr($nameParts[0], 0, 1));
        if (count($nameParts) > 1) {
            $initials .= strtoupper(substr($nameParts[count($nameParts) - 1], 0, 1));
        }

        $colors = [
            'bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-pink-500',
            'bg-indigo-500', 'bg-red-500', 'bg-yellow-500', 'bg-teal-500'
        ];
        $colorIndex = ord(strtolower($row->name[0])) % count($colors);
        $bgColor = $colors[$colorIndex];

        return '<div class="w-10 h-10 rounded-full ' . $bgColor . ' flex items-center justify-center text-white font-semibold text-sm">' . $initials . '</div>';
    }

    protected function statusBadge($row)
    {
        $status = $row->status ? 'active' : 'inactive';

        $colors = [
            'active' => 'bg-green-100 text-green-800',
            'inactive' => 'bg-slate-100 text-slate-800',
        ];

        return '<span class="px-2.5 py-0.5 text-xs font-semibold rounded-full ' . $colors[$status] . '">' . ucfirst($status) . '</span>';
    }

    public function actions($user)
    {
        return view('components.users.users-actions', compact('user'));
    }

    public function delete($id): void
    {
        User::findOrFail($id)->delete();
        session()->flash('success', 'User deleted successfully.');
        $this->resetPage();
    }
}
