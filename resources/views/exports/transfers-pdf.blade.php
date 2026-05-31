<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Transfers Report</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 11px;
            line-height: 1.4;
        }
        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #8b5cf6;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #6d28d9;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>Store Transfers Report</h1>
        <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Transfer No</th>
                <th>From Store</th>
                <th>To Store</th>
                <th>Transfer Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transfers as $transfer)
                <tr>
                    <td>{{ $transfer->id }}</td>
                    <td><strong>{{ $transfer->transfer_no }}</strong></td>
                    <td>{{ $transfer->fromStore->name ?? 'N/A' }}</td>
                    <td>{{ $transfer->toStore->name ?? 'N/A' }}</td>
                    <td>{{ $transfer->transfer_date ? $transfer->transfer_date->format('Y-m-d') : 'N/A' }}</td>
                    <td>{{ ucfirst($transfer->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
