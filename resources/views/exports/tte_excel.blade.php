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
