<!DOCTYPE html>
<html>

<head>
    <title>Export Virtual Meeting PDF</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #333;
            padding: 4px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h3>Data Virtual Meeting</h3>
    <p>Periode: {{ $startDate }} s/d {{ $endDate }}</p>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Tiket</th>
                <th>Nama</th>
                <th>Instansi</th>
                <th>Topik</th>
                <th>Waktu</th>
                <th>Durasi</th>
                <th>Partisipan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nomor_tiket }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <td>{{ $item->instansi }}</td>
                    <td>{{ $item->topik_meeting }}</td>
                    <td>{{ $item->waktu_pelaksanaan }}</td>
                    <td>{{ $item->durasi_meeting }}</td>
                    <td>{{ $item->jumlah_partisipan }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
