<div class="card card-primary mb-4">
    <div class="card-header">
        <h3 class="card-title">Aduan Layanan</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped data-table">
            <thead>
                <tr>
                    <th class="text-center align-middle" style="width: 100px;">Tiket</th>
                    <th class="text-center align-middle" style="width: 190px;">Nama Lengkap</th>
                    <th class="text-center align-middle" style="width: 180px;">Instansi</th>
                    <th class="text-center align-middle" style="width: 150px;">Aduan</th>
                    <th class="text-center align-middle" style="width: 70px;">Status</th>
                    <th class="text-center align-middle" style="width: 70px;">No. Pengadu</th>
                    <th class="text-center align-middle" style="width: 90px;">Waktu Pengaduan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i => $item)
                    <tr>
                        <td class="text-center align-middle">{{ $item->nomor_tiket }}</td>
                        <td class="text-center align-middle">{{ $item->nama_lengkap }}</td>
                        <td class="text-center align-middle">{{ $item->instansi }}</td>
                        @php
                            $excerpt = Str::limit($item->isi_aduan, 7); // Potong jadi 100 karakter
                        @endphp
                        <td class="text-center align-middle">
                            {{ Str::limit($item->isi_aduan, 7) }}
                            @if (Str::length($item->isi_aduan) > 7)
                                <button type="button" class="btn btn-link btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalAduan{{ $item->id }}">
                                    Lihat Selengkapnya
                                </button>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            <span class="badge {{ $item->status == '1' ? 'bg-danger' : 'bg-success' }}">
                                {{ $item->status == '1' ? 'Closed' : 'Open' }}
                            </span>
                        </td>
                        @php
                            $nomor = str_replace('@c.us', '', $item->user_id);
                        @endphp

                        <td class="text-center align-middle">
                            @if (!empty($nomor))
                                <a href="https://wa.me/{{ $nomor }}" target="_blank"
                                    class="btn btn-success btn-sm">
                                    <i class="bi bi-whatsapp"></i> Chat
                                </a>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="bi bi-whatsapp"></i> Tidak Ada
                                </button>
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            {{ optional($item->created_at)->format('H:i | d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @foreach ($data as $item)
            @if (Str::length($item->isi_aduan) > 7)
                <!-- Harus sama dengan tombol -->
                <div class="modal fade" id="modalAduan{{ $item->id }}" tabindex="-1"
                    aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel{{ $item->id }}">Isi Aduan Lengkap</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                {{ $item->isi_aduan }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
