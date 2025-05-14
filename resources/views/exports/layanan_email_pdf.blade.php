<!DOCTYPE html>
<html>

<head>
    <title>Laporan Layanan Email</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h3>Laporan Layanan Email</h3>
    <p>Periode: {{ $startDate }} - {{ $endDate }}</p>
    <table>
        <thead>
            <tr>
                <th>No Tiket</th>
                <th>Nama</th>
                <th>Instansi</th>
                <th>Email Dinas</th>
                <th>Status</th>
                <th>Waktu Permohonan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->nomor_tiket }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <td>{{ $item->instansi }}</td>
                    <td>{{ $item->email_dinas }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
