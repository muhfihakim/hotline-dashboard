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
                        <h3 class="mb-0">Aduan Layanan</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Aduan Layanan</li>
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
                    <h3 class="card-title">Daftar Aduan Layanan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
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
                            @foreach ($aduan as $index => $item)
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
                                        <form action="{{ route('update.aduan.admin', $item->id) }}" method="POST"
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
                    @foreach ($aduan as $item)
                        @if (Str::length($item->isi_aduan) > 100)
                            <div class="modal fade" id="modalAduan{{ $item->id }}" tabindex="-1"
                                aria-labelledby="modalLabel{{ $item->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel{{ $item->id }}">Isi Aduan
                                                Lengkap</h5>
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
