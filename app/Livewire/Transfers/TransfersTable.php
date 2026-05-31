<?php

namespace App\Livewire\Transfers;

use App\Models\Transfer;
use App\Models\StoreItem;
use App\Models\ActivityLog;
use App\Livewire\DataTable;
use Illuminate\Support\Facades\DB;

class TransfersTable extends DataTable
{
    protected string $model = Transfer::class;

    protected array $columns = [
        [
            'label' => 'ID',
            'field' => 'id',
            'width' => 'w-20',
            'searchable' => false,
            'orderable' => true,
        ],
        [
            'label' => 'Transfer No',
            'field' => 'transfer_no',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => true,
        ],
        [
            'label' => 'From Store',
            'field' => 'from_store_id',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'fromStoreName',
            'orderable' => false,
        ],
        [
            'label' => 'To Store',
            'field' => 'to_store_id',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'toStoreName',
            'orderable' => false,
        ],
        [
            'label' => 'Transfer Date',
            'field' => 'transfer_date',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'formatDate',
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
    ];

    protected array $filters = [
        'status' => [
            'type' => 'select',
            'label' => 'Status',
            'options' => [
                'pending' => 'Pending',
                'completed' => 'Completed',
                'cancelled' => 'Cancelled',
            ],
        ],
    ];

    protected array $executions = [
        'create' => 'transfers.create',
    ];

    protected function fromStoreName($row)
    {
        return '<span class="text-slate-700">' . e($row->fromStore->name) . '</span>';
    }

    protected function toStoreName($row)
    {
        return '<span class="text-slate-700">' . e($row->toStore->name) . '</span>';
    }

    protected function formatDate($row)
    {
        return $row->transfer_date ? $row->transfer_date->format('Y-m-d') : '';
    }

    protected function statusBadge($row)
    {
        $status = strtolower($row->status);

        $colors = [
            'completed' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400',
            'pending' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400',
            'cancelled' => 'bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400',
        ];

        return '<span class="px-2.5 py-0.5 text-xs font-semibold rounded-full ' . ($colors[$status] ?? 'bg-slate-100') . '">' . ucfirst($status) . '</span>';
    }

    public function actions($transfer)
    {
        return '<div class="flex gap-2 items-center justify-center">
            <a href="' . route('transfers.show', $transfer->id) . '" class="text-green-600 hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
            </a>
            <a href="' . route('transfers.edit', $transfer->id) . '" class="text-blue-600 hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </a>
            <button wire:click="delete(' . $transfer->id . ')" wire:confirm="Are you sure you want to delete this stock transfer and revert stock levels?" class="text-red-600 hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>';
    }

    public function delete($id): void
    {
        $transfer = Transfer::findOrFail($id);
        DB::transaction(function () use ($transfer) {
            foreach ($transfer->items as $item) {
                // Restore source store stock (increment)
                $sourceStoreItem = StoreItem::where('store_id', $transfer->from_store_id)
                    ->where('item_id', $item->item_id)
                    ->first();
                if ($sourceStoreItem) {
                    $sourceStoreItem->increment('stock_quantity', $item->quantity);
                }

                // Deduct destination store stock (decrement)
                $destStoreItem = StoreItem::where('store_id', $transfer->to_store_id)
                    ->where('item_id', $item->item_id)
                    ->first();
                if ($destStoreItem) {
                    $destStoreItem->decrement('stock_quantity', $item->quantity);
                }
            }

            // Log activity
            ActivityLog::log('Delete Transfer', 'Transfer ID: ' . $transfer->id . ', Transfer No: ' . $transfer->transfer_no . ' deleted. Stock reverted.');

            // Delete associated items and the transfer
            $transfer->items()->delete();
            $transfer->delete();
        });

        session()->flash('message', 'Stock transfer deleted and stock reverted successfully.');
        session()->flash('alert-type', 'success');
        $this->resetPage();
    }
}
