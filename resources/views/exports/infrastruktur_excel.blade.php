<table>
    <thead>
        <tr>
            <th>No Tiket</th>
            <th>Nama</th>
            <th>Instansi</th>
            <th>Jenis Koneksi</th>
            <th>Lokasi</th>
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
                <td>{{ $item->jenis_koneksi }}</td>
                <td>{{ $item->lokasi }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
