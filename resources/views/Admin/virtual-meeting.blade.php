<x-layouts.app>
    @section('Css')
        <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('dist/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/buttons.bootstrap4.min.css') }}">
    @endsection
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Permohonan Virtual Meeting</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Permohonan Virtual Meeting</li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <div class="app-content">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Daftar Permohonan Virtual Meeting</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center align-middle" style="width: 100px;">Tiket</th>
                                <th class="text-center align-middle" style="width: 190px;">Nama Lengkap</th>
                                <th class="text-center align-middle" style="width: 180px;">Instansi</th>
                                <th class="text-center align-middle" style="width: 130px;">Fasilitas</th>
                                <th class="text-center align-middle" style="width: 100px;">Pelaksanaan</th>
                                <th class="text-center align-middle" style="width: 80px;">Surat</th>
                                <th class="text-center align-middle" style="width: 70px;">Status</th>
                                <th class="text-center align-middle" style="width: 70x;">No. Pemohon</th>
                                <th class="text-center align-middle" style="width: 90px;">Waktu Permohonan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($vm as $index => $item)
                                <tr>
                                    <td class="text-center align-middle">{{ $item->nomor_tiket }}</td>
                                    <td class="text-center align-middle">{{ $item->nama_lengkap }}</td>
                                    <td class="text-center align-middle">{{ $item->instansi }}</td>
                                    <td class="text-center align-middle">{{ $item->link_operator }}</td>
                                    <td class="text-center align-middle">
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalPelaksanaan{{ $item->id }}">
                                            <i class="bi bi-info-circle"></i> Lihat Detail
                                        </button>
                                    </td>
                                    <td class="text-center align-middle">
                                        @if ($item->surat_permohonan)
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#modalSurat{{ $item->id }}">
                                                <i class="bi bi-eye"></i> Lihat
                                            </button>
                                        @else
                                            <button type="button" class="btn btn-secondary btn-sm" disabled>
                                                <i class="bi bi-eye-slash"></i> Tidak Ada
                                            </button>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <form action="{{ route('update.vm.admin', $item->id) }}" method="POST"
                                            id="statusForm{{ $item->id }}">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" id="statusInput{{ $item->id }}">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-info btn-sm">
                                                    {{ $item->status == '1' ? 'Closed' : 'Open' }}
                                                </button>
                                                <button type="button"
                                                    class="btn btn-info btn-sm dropdown-toggle dropdown-icon"
                                                    data-toggle="dropdown">
                                                </button>
                                                <div class="dropdown-menu" role="menu">
                                                    <a class="dropdown-item" href="#"
                                                        onclick="submitStatus('{{ $item->id }}', '0')">Open</a>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="submitStatus('{{ $item->id }}', '1')">Closed</a>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                    @php $nomor = str_replace('@c.us', '', $item->user_id); @endphp
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
                    @foreach ($vm as $item)
                        {{-- Modal Surat Permohonan --}}
                        @if ($item->surat_permohonan)
                            @php $fileName = basename($item->surat_permohonan); @endphp
                            <div class="modal fade" id="modalSurat{{ $item->id }}" tabindex="-1"
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
                                            <button type="button" class="btn btn-secondary btn-sm"
                                                data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Modal Detail Pelaksanaan --}}
                        <div class="modal fade" id="modalPelaksanaan{{ $item->id }}" tabindex="-1"
                            aria-labelledby="modalPelaksanaanLabel{{ $item->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Detail Pelaksanaan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><strong>Topik:</strong>
                                                {{ $item->topik_meeting }}</li>
                                            <li class="list-group-item"><strong>Waktu:</strong>
                                                {{ $item->waktu_pelaksanaan }}</li>
                                            <li class="list-group-item"><strong>Jumlah Partisipan:</strong>
                                                {{ $item->jumlah_partisipan }}</li>
                                            <li class="list-group-item"><strong>Durasi:</strong>
                                                {{ $item->durasi_meeting }}</li>
                                            <li class="list-group-item"><strong>Lokasi:</strong>
                                                {{ $item->lokasi_meeting }}</li>
                                        </ul>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-secondary btn-sm"
                                            data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!--end::App Content-->
            </div>
        </div>
    </main>
    <!--end::App Main-->
    @section('Scripts')
        <!-- jQuery -->
        <script src="{{ asset('dist/js/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('dist/js/bootstrap.bundle.min.js') }}"></script>
        <!-- DataTables  & js -->
        <script src="{{ asset('dist/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('dist/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('dist/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('dist/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('dist/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('dist/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('dist/js/buttons.colVis.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script>
            function submitStatus(id, statusValue) {
                document.getElementById('statusInput' + id).value = statusValue;
                document.getElementById('statusForm' + id).submit();
            }
        </script>
        <!-- Page specific script -->
        <script>
            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": [{
                        extend: 'colvis',
                        text: 'Tampilkan/Kolom'
                    }],
                    "language": {
                        "buttons": {
                            "colvis": "Tampilkan/Kolom"
                        }
                    }
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });
        </script>
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if (session('alert.config'))
            <script>
                Swal.fire({!! session('alert.config') !!});
            </script>
        @endif
    @endsection
</x-layouts.app>
