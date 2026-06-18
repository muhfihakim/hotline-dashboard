<x-pimpinan.app>
    <main class="app-main">
        <div class="app-content container-fluid">
            @foreach($layanans as $layanan)
                @php
                    $permohonans = $data[$layanan->kode]['permohonan'] ?? [];
                @endphp
                
                <div class="card card-primary mb-4">
                    <div class="card-header">
                        <h3 class="card-title">{{ $layanan->kode }}. {{ $layanan->nama }}</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped data-table">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle" style="width: 100px;">Tiket</th>
                                    <th class="text-center align-middle">Detail Permohonan (Data JSON)</th>
                                    <th class="text-center align-middle" style="width: 70px;">Status</th>
                                    <th class="text-center align-middle" style="width: 70px;">No. WhatsApp</th>
                                    <th class="text-center align-middle" style="width: 90px;">Waktu</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permohonans as $item)
                                    <tr>
                                        <td class="text-center align-middle">
                                            <span class="badge bg-primary">{{ $item->nomor_tiket }}</span>
                                        </td>
                                        <td class="align-middle text-sm">
                                            @if(is_array($item->data))
                                                <ul class="mb-0 ps-3">
                                                    @foreach($item->data as $k => $v)
                                                        <li><strong>{{ $k }}:</strong> 
                                                            @if(str_starts_with($v, '/storage/'))
                                                                <a href="{{ $v }}" target="_blank" class="text-decoration-none">Lihat Lampiran</a>
                                                            @else
                                                                {{ $v }}
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            @if($item->status == '1')
                                                <span class="badge bg-success">Selesai</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Open</span>
                                            @endif
                                        </td>
                                        @php
                                            $nomor = str_replace('@c.us', '', $item->phone);
                                        @endphp
                                        <td class="text-center align-middle">
                                            @if (!empty($nomor))
                                                <a href="https://wa.me/{{ $nomor }}" target="_blank" class="btn btn-success btn-sm">
                                                    <i class="bi bi-whatsapp"></i> Chat
                                                </a>
                                            @else
                                                <button class="btn btn-secondary btn-sm" disabled>
                                                    <i class="bi bi-whatsapp"></i> N/A
                                                </button>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            {{ optional($item->created_at)->format('H:i | d-m-Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                                @if(count($permohonans) == 0)
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada permohonan untuk layanan ini.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </main>

    @section('Scripts')
        <script src="{{ asset('dist/js/jquery.min.js') }}"></script>
        <script src="{{ asset('dist/js/bootstrap.bundle.min.js') }}"></script>

        <script>
            // Saat modal surat dibuka, baru load iframe
            $('div.modal').on('show.bs.modal', function(e) {
                let iframe = $(this).find('iframe.surat-frame');
                let dataSrc = iframe.attr('data-src');
                if (iframe.attr('src') !== dataSrc) {
                    iframe.attr('src', dataSrc);
                }
            });

            // Opsional: Kosongkan src saat modal ditutup untuk menghemat memori
            $('div.modal').on('hidden.bs.modal', function(e) {
                let iframe = $(this).find('iframe.surat-frame');
                iframe.removeAttr('src');
            });
        </script>
    @endsection
</x-pimpinan.app>
