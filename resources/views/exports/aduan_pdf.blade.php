<h4>Laporan Aduan Layanan</h4>
<p>Periode: {{ date('d M Y', strtotime($startDate)) }} - {{ date('d M Y', strtotime($endDate)) }}</p>

<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>No</th>
            <th>Nomor Tiket</th>
            <th>Nama</th>
            <th>Instansi</th>
            <th>Isi Aduan</th>
            <th>Status</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->nomor_tiket }}</td>
                <td>{{ $item->nama_lengkap }}</td>
                <td>{{ $item->instansi }}</td>
                <td>{{ $item->isi_aduan }}</td>
                <td>{{ $item->status }}</td>
                <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
