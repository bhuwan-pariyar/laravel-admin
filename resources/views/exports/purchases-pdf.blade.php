<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Purchases Report</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 11px;
            line-height: 1.4;
        }
        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #1e3a8a;
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
        <h1>Purchases Report</h1>
        <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Purchase No</th>
                <th>Supplier</th>
                <th>Store</th>
                <th>Purchase Date</th>
                <th class="text-right">Grand Total</th>
                <th>Payment Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($purchases as $purchase)
                <tr>
                    <td>{{ $purchase->id }}</td>
                    <td><strong>{{ $purchase->purchase_no }}</strong></td>
                    <td>{{ $purchase->supplier->name ?? 'N/A' }}</td>
                    <td>{{ $purchase->store->name ?? 'N/A' }}</td>
                    <td>{{ $purchase->purchase_date ? $purchase->purchase_date->format('Y-m-d') : 'N/A' }}</td>
                    <td class="text-right">${{ number_format($purchase->grand_total, 2) }}</td>
                    <td>{{ ucfirst($purchase->payment_status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
