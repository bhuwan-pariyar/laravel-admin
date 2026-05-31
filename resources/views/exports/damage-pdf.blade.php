<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Damage Reports</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 12px;
            line-height: 1.5;
        }
        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
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
            padding: 8px;
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
        <h1>Damage Reports Log</h1>
        <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Item</th>
                <th>Store</th>
                <th style="width: 80px;" class="text-right">Quantity</th>
                <th>Reported By</th>
                <th>Date</th>
                <th>Remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td><strong>{{ $report->item->name ?? 'N/A' }}</strong><br><small style="color: #666;">SKU: {{ $report->item->sku ?? 'N/A' }}</small></td>
                    <td>{{ $report->store->name ?? 'N/A' }}</td>
                    <td class="text-right">{{ $report->quantity }}</td>
                    <td>{{ $report->reporter->name ?? 'N/A' }}</td>
                    <td>{{ $report->reported_at ? $report->reported_at->format('Y-m-d H:i') : 'N/A' }}</td>
                    <td>{{ $report->remarks ?? '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
