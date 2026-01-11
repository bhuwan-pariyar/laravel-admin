<x-app-layout>
    <div class="p-6">
        @livewire('data-table', [
            'model' => \App\Models\User::class,
            'columns' => [
                [
                    'label' => 'ID',
                    'field' => 'id',
                    'sortable' => true,
                    'width' => 'w-20',
                    'format' => function ($row) {
                        return '<span class="font-semibold text-gray-900">#' . $row->id . '</span>';
                    },
                ],
                [
                    'label' => 'Name',
                    'field' => 'name',
                    'sortable' => true,
                    'width' => 'w-auto',
                ],
                [
                    'label' => 'Status',
                    'field' => 'status',
                    'sortable' => true,
                    'width' => 'w-32',
                    'format' => function ($row) {
                        $colors = [
                            'active' => 'bg-green-100 text-green-800',
                            'inactive' => 'bg-gray-100 text-gray-800',
                        ];
                        $status = $row->status ?? 'active';
                        return '<span class="px-2.5 py-1 text-xs font-semibold rounded-full ' . $colors[$status] . '">' . ucfirst($status) . '</span>';
                    },
                ],
                [
                    'label' => 'Actions',
                    'field' => 'id',
                    'sortable' => false,
                    'searchable' => false,
                    'width' => 'w-36',
                    'format' => function ($row) {
                        return '
                                                    <div class="flex items-center gap-2">
                                                        <a href="/users/' .
                            $row->id .
                            '/edit"
                                                           class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                           title="Edit">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </a>
                                                        <a href="/users/' .
                            $row->id .
                            '"
                                                           class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors"
                                                           title="View">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                        </a>
                                                        <button onclick="confirm(\'Are you sure you want to delete this user?\') || event.stopImmediatePropagation()"
                                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                                                title="Delete">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                ';
                    },
                ],
            ],
            'filters' => [
                [
                    'label' => 'Status',
                    'field' => 'status',
                    'options' => [
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ],
                ],
            ],
        ])
    </div>
</x-app-layout>
