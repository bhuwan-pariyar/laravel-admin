<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Activity Report</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            font-size: 10px;
            line-height: 1.4;
        }
        .header {
            margin-bottom: 20px;
            border-bottom: 2px solid #6b7280;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            color: #1f2937;
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
        <h1>System Activity Logs</h1>
        <p>Generated on: {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th style="width: 100px;">User</th>
                <th style="width: 120px;">Action</th>
                <th>Description</th>
                <th style="width: 90px;">IP Address</th>
                <th style="width: 110px;">Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $act)
                <tr>
                    <td>{{ $act->id }}</td>
                    <td>{{ $act->user->name ?? 'System' }}</td>
                    <td><strong>{{ $act->action }}</strong></td>
                    <td>{{ $act->description }}</td>
                    <td>{{ $act->ip_address }}</td>
                    <td>{{ $act->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
