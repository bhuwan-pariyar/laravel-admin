<?php

namespace App\Livewire\Reports;

use App\Models\Item;
use App\Models\ActivityLog;
use App\Models\DamageReport;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Transfer;
use App\Models\Store;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportExport extends Component
{
    public $reportType = 'stock';
    public $selectedStore = '';
    public $startDate = '';
    public $endDate = '';
    public $format = 'csv';

    public function mount()
    {
        // Default dates to current month range
        $this->startDate = date('Y-m-01');
        $this->endDate = date('Y-m-t');
    }

    public function export()
    {
        $this->validate([
            'reportType' => 'required|string|in:stock,activity,damage,sales,purchases,transfers',
            'format' => 'required|string|in:csv,pdf',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
        ]);

        switch ($this->reportType) {
            case 'stock':
                return $this->exportStock();
            case 'activity':
                return $this->exportActivity();
            case 'damage':
                return $this->exportDamage();
            case 'sales':
                return $this->exportSales();
            case 'purchases':
                return $this->exportPurchases();
            case 'transfers':
                return $this->exportTransfers();
        }
    }

    protected function exportStock()
    {
        $query = Item::with(['category', 'storeItems.store']);

        if ($this->selectedStore) {
            $query->whereHas('storeItems', function ($q) {
                $q->where('store_id', $this->selectedStore);
            });
        }

        $items = $query->get();

        if ($this->format === 'pdf') {
            $pdf = Pdf::loadView('exports.stock-pdf', compact('items'));
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, 'stock-report.pdf');
        } else {
            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename=stock-report.csv',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $callback = function() use ($items) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'SKU', 'Item Name', 'Category', 'Total Stock', 'Cost Price', 'Selling Price']);

                foreach ($items as $row) {
                    fputcsv($file, [
                        $row->id,
                        $row->sku,
                        $row->name,
                        $row->category->name ?? 'N/A',
                        $row->stock_quantity,
                        '$' . number_format($row->cost_price, 2),
                        '$' . number_format($row->selling_price, 2)
                    ]);
                }
                fclose($file);
            };

            return response()->streamDownload($callback, 'stock-report.csv', $headers);
        }
    }

    protected function exportActivity()
    {
        $query = ActivityLog::with('user');

        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        $activities = $query->orderBy('created_at', 'desc')->get();

        if ($this->format === 'pdf') {
            $pdf = Pdf::loadView('exports.activity-pdf', compact('activities'));
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, 'activity-report.pdf');
        } else {
            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename=activity-report.csv',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $callback = function() use ($activities) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'User', 'Action', 'Description', 'IP Address', 'Timestamp']);

                foreach ($activities as $row) {
                    fputcsv($file, [
                        $row->id,
                        $row->user->name ?? 'System',
                        $row->action,
                        $row->description,
                        $row->ip_address,
                        $row->created_at->format('Y-m-d H:i:s')
                    ]);
                }
                fclose($file);
            };

            return response()->streamDownload($callback, 'activity-report.csv', $headers);
        }
    }

    protected function exportDamage()
    {
        $query = DamageReport::with(['item', 'store', 'reporter']);

        if ($this->selectedStore) {
            $query->where('store_id', $this->selectedStore);
        }
        if ($this->startDate) {
            $query->whereDate('reported_at', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('reported_at', '<=', $this->endDate);
        }

        $reports = $query->orderBy('reported_at', 'desc')->get();

        if ($this->format === 'pdf') {
            $pdf = Pdf::loadView('exports.damage-pdf', compact('reports'));
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, 'damage-report.pdf');
        } else {
            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename=damage-report.csv',
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

            return response()->streamDownload($callback, 'damage-report.csv', $headers);
        }
    }

    protected function exportSales()
    {
        $query = Sale::with(['customer', 'store']);

        if ($this->selectedStore) {
            $query->where('store_id', $this->selectedStore);
        }
        if ($this->startDate) {
            $query->whereDate('sale_date', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('sale_date', '<=', $this->endDate);
        }

        $sales = $query->orderBy('sale_date', 'desc')->get();

        if ($this->format === 'pdf') {
            $pdf = Pdf::loadView('exports.sales-pdf', compact('sales'));
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, 'sales-report.pdf');
        } else {
            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename=sales-report.csv',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $callback = function() use ($sales) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'Invoice No', 'Customer', 'Store', 'Sale Date', 'Grand Total', 'Payment Status']);

                foreach ($sales as $row) {
                    fputcsv($file, [
                        $row->id,
                        $row->invoice_no,
                        $row->customer->name ?? 'Walk-in',
                        $row->store->name ?? 'N/A',
                        $row->sale_date ? $row->sale_date->format('Y-m-d') : '',
                        '$' . number_format($row->grand_total, 2),
                        ucfirst($row->payment_status)
                    ]);
                }
                fclose($file);
            };

            return response()->streamDownload($callback, 'sales-report.csv', $headers);
        }
    }

    protected function exportPurchases()
    {
        $query = Purchase::with(['supplier', 'store']);

        if ($this->selectedStore) {
            $query->where('store_id', $this->selectedStore);
        }
        if ($this->startDate) {
            $query->whereDate('purchase_date', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('purchase_date', '<=', $this->endDate);
        }

        $purchases = $query->orderBy('purchase_date', 'desc')->get();

        if ($this->format === 'pdf') {
            $pdf = Pdf::loadView('exports.purchases-pdf', compact('purchases'));
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, 'purchases-report.pdf');
        } else {
            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename=purchases-report.csv',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $callback = function() use ($purchases) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'Purchase No', 'Supplier', 'Store', 'Purchase Date', 'Grand Total', 'Payment Status']);

                foreach ($purchases as $row) {
                    fputcsv($file, [
                        $row->id,
                        $row->purchase_no,
                        $row->supplier->name ?? 'N/A',
                        $row->store->name ?? 'N/A',
                        $row->purchase_date ? $row->purchase_date->format('Y-m-d') : '',
                        '$' . number_format($row->grand_total, 2),
                        ucfirst($row->payment_status)
                    ]);
                }
                fclose($file);
            };

            return response()->streamDownload($callback, 'purchases-report.csv', $headers);
        }
    }

    protected function exportTransfers()
    {
        $query = Transfer::with(['fromStore', 'toStore']);

        if ($this->selectedStore) {
            $query->where(function($q) {
                $q->where('from_store_id', $this->selectedStore)
                  ->orWhere('to_store_id', $this->selectedStore);
            });
        }
        if ($this->startDate) {
            $query->whereDate('transfer_date', '>=', $this->startDate);
        }
        if ($this->endDate) {
            $query->whereDate('transfer_date', '<=', $this->endDate);
        }

        $transfers = $query->orderBy('transfer_date', 'desc')->get();

        if ($this->format === 'pdf') {
            $pdf = Pdf::loadView('exports.transfers-pdf', compact('transfers'));
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, 'transfers-report.pdf');
        } else {
            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename=transfers-report.csv',
                'Pragma' => 'no-cache',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            $callback = function() use ($transfers) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['ID', 'Transfer No', 'From Store', 'To Store', 'Transfer Date', 'Status']);

                foreach ($transfers as $row) {
                    fputcsv($file, [
                        $row->id,
                        $row->transfer_no,
                        $row->fromStore->name ?? 'N/A',
                        $row->toStore->name ?? 'N/A',
                        $row->transfer_date ? $row->transfer_date->format('Y-m-d') : '',
                        ucfirst($row->status)
                    ]);
                }
                fclose($file);
            };

            return response()->streamDownload($callback, 'transfers-report.csv', $headers);
        }
    }

    public function render()
    {
        $stores = Store::where('status', true)->get();

        return view('livewire.reports.report-export', [
            'stores' => $stores,
        ]);
    }
}
