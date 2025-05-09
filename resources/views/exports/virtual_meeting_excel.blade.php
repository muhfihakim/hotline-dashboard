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
