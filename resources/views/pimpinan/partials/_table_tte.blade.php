<div class="card card-primary mb-4">
    <div class="card-header">
        <h3 class="card-title">Tanda Tangan Elektronik</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped data-table">
            <thead>
                <tr>
                    <th class="text-center align-middle" style="width: 100px;">Tiket</th>
                    <th class="text-center align-middle" style="width: 190px;">Nama Lengkap</th>
                    <th class="text-center align-middle" style="width: 180px;">Instansi</th>
                    <th class="text-center align-middle" style="width: 100px;">E-Mail Dinas</th>
                    <th class="text-center align-middle" style="width: 70px;">Surat</th>
                    <th class="text-center align-middle" style="width: 70px;">Status</th>
                    <th class="text-center align-middle" style="width: 70px;">No. Pemohon</th>
                    <th class="text-center align-middle" style="width: 100px;">Waktu Permohonan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $i => $item)
                    <tr>
                        <td class="text-center align-middle">{{ $item->nomor_tiket }}</td>
                        <td class="text-center align-middle">{{ $item->nama_lengkap }}</td>
                        <td class="text-center align-middle">{{ $item->instansi }}</td>
                        <td class="text-center align-middle">{{ $item->email_dinas }}</td>
                        <td class="text-center align-middle">
                            @if ($item->surat_permohonan)
                                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#modalSuratTte{{ $item->id }}">
                                    <i class="bi bi-eye"></i> Lihat
                                </button>
                            @else
                                <button type="button" class="btn btn-secondary btn-sm" disabled>
                                    <i class="bi bi-eye-slash"></i> Tidak Ada
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
                            {{ optional($item->created_at)->format('H:i | d-m-Y') ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @foreach ($data as $item)
            {{-- Modal Surat Permohonan --}}
            @if ($item->surat_permohonan)
                @php $fileName = basename($item->surat_permohonan); @endphp
                <div class="modal fade" id="modalSuratTte{{ $item->id }}" tabindex="-1"
                    aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Surat Permohonan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body p-2">
                                <iframe class="surat-frame" data-src="{{ url('/uploads/' . $fileName) }}"
                                    width="100%" height="500px" style="border: none;"></iframe>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
