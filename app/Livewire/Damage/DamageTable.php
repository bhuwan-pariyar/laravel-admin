<?php

namespace App\Livewire\Damage;

use App\Models\DamageReport;
use App\Models\StoreItem;
use App\Models\Item;
use App\Models\ActivityLog;
use App\Livewire\DataTable;
use Illuminate\Support\Facades\DB;

class DamageTable extends DataTable
{
    protected string $model = DamageReport::class;

    protected array $columns = [
        [
            'label' => 'ID',
            'field' => 'id',
            'width' => 'w-20',
            'searchable' => false,
            'orderable' => true,
        ],
        [
            'label' => 'Item',
            'field' => 'item_id',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'itemName',
            'orderable' => false,
        ],
        [
            'label' => 'Store',
            'field' => 'store_id',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'storeName',
            'orderable' => false,
        ],
        [
            'label' => 'Quantity',
            'field' => 'quantity',
            'width' => 'w-auto',
            'searchable' => false,
            'orderable' => true,
        ],
        [
            'label' => 'Reported By',
            'field' => 'reported_by',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'reporterName',
            'orderable' => false,
        ],
        [
            'label' => 'Reported Date',
            'field' => 'reported_at',
            'width' => 'w-auto',
            'searchable' => false,
            'format' => 'formatDate',
            'orderable' => true,
        ],
        [
            'label' => 'Remarks',
            'field' => 'remarks',
            'width' => 'w-auto',
            'searchable' => true,
            'orderable' => false,
        ],
    ];

    protected array $executions = [
        'create' => 'damage.create',
    ];

    protected function itemName($row)
    {
        return '<span class="font-medium text-slate-800">' . e($row->item->name ?? '') . '</span>';
    }

    protected function storeName($row)
    {
        return '<span class="text-slate-600">' . e($row->store->name ?? '') . '</span>';
    }

    protected function reporterName($row)
    {
        return '<span class="text-xs text-slate-600">' . e($row->reporter->name ?? '') . '</span>';
    }

    protected function formatDate($row)
    {
        return $row->reported_at ? $row->reported_at->format('Y-m-d H:i') : '';
    }

    public function actions($row)
    {
        return view('components.damage.damage-actions', ['report' => $row]);
    }

    public function delete($id): void
    {
        $report = DamageReport::findOrFail($id);
        DB::transaction(function () use ($report) {
            // Revert store stock
            $storeItem = StoreItem::where('store_id', $report->store_id)
                ->where('item_id', $report->item_id)
                ->first();
            if ($storeItem) {
                $storeItem->increment('stock_quantity', $report->quantity);
            }

            // Revert global item stock
            $item = Item::find($report->item_id);
            if ($item) {
                $item->increment('stock_quantity', $report->quantity);
            }

            // Log activity
            ActivityLog::log('Damage Report Deleted', 'Item: ' . ($item->name ?? 'Unknown') . ' - Quantity: ' . $report->quantity . ' reverted at ' . ($report->store->name ?? 'Unknown'));

            $report->delete();
        });

        session()->flash('message', 'Damage report deleted and stock reverted successfully.');
        session()->flash('alert-type', 'success');
        $this->resetPage();
    }

    public function exportPdf()
    {
        $reports = $this->query()->get();
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('exports.damage-pdf', compact('reports'));
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'damage-reports.pdf');
    }

    public function exportExcel()
    {
        $reports = $this->query()->get();
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=damage-reports.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($reports) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Item', 'SKU', 'Store', 'Quantity', 'Reported By', 'Reported Date', 'Remarks']);

            foreach ($reports as $row) {
                fputcsv($file, [
                    $row->id,
                    $row->item->name ?? '',
                    $row->item->sku ?? '',
                    $row->store->name ?? '',
                    $row->quantity,
                    $row->reporter->name ?? '',
                    $row->reported_at ? $row->reported_at->format('Y-m-d H:i') : '',
                    $row->remarks
                ]);
            }
            fclose($file);
        };

        return response()->streamDownload($callback, 'damage-reports.csv', $headers);
    }
}

