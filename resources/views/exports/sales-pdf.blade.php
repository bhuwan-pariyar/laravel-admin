<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Report</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 11px;
            line-height: 1.4;
        }
        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #059669;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #065f46;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 6px 8px;
            text-align: left;
        }
        th {
            background-color: #f8fafc;
            color: #475569;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f1f5f9;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sales Invoice Report</h1>
        <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Invoice No</th>
                <th>Customer</th>
                <th>Store</th>
                <th>Sale Date</th>
                <th class="text-right">Grand Total</th>
                <th>Payment Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td><strong>{{ $sale->invoice_no }}</strong></td>
                    <td>{{ $sale->customer->name ?? 'Walk-in' }}</td>
                    <td>{{ $sale->store->name ?? 'N/A' }}</td>
                    <td>{{ $sale->sale_date ? $sale->sale_date->format('Y-m-d') : 'N/A' }}</td>
                    <td class="text-right">${{ number_format($sale->grand_total, 2) }}</td>
                    <td>{{ ucfirst($sale->payment_status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
