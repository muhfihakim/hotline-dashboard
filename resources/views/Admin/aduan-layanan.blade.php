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
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Aduan Layanan</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center align-middle">Tiket</th>
                                <th class="text-center align-middle">Nama Lengkap</th>
                                <th class="text-center align-middle">No. Pengadu</th>
                                <th class="text-center align-middle">Instansi</th>
                                <th class="text-center align-middle">Aduan</th>
                                <th class="text-center align-middle">Status</th>
                                <th class="text-center align-middle">Waktu Pengaduan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aduan as $index => $item)
                                <tr>
                                    <td class="text-center align-middle">{{ $item->nomor_tiket }}</td>
                                    <td class="text-center align-middle">{{ $item->nama_lengkap }}</td>
                                    @php
                                        $nomor = str_replace('@c.us', '', $item->user_id);
                                    @endphp
                                    <td class="text-center align-middle">
                                        <a href="https://wa.me/{{ $nomor }}" target="_blank"
                                            class="btn btn-success btn-sm">
                                            <i class="fab fa-whatsapp"></i> Chat
                                        </a>
                                    </td>

                                    <td class="text-center align-middle">{{ $item->instansi }}</td>
                                    <td class="text-center align-middle">{{ $item->isi_aduan }}</td>
                                    <td class="text-center align-middle">
                                        <form action="{{ route('update.aduan.admin', $item->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" onchange="this.form.submit()">
                                                <option value="0" {{ $item->status == '0' ? 'selected' : '' }}>
                                                    Open</option>
                                                <option value="1" {{ $item->status == '1' ? 'selected' : '' }}>
                                                    Closed</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="text-center align-middle">
                                        {{ optional($item->created_at)->format('H:i | d-m-Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
        <script src="{{ asset('dist/js/jszip.min.js') }}"></script>
        <script src="{{ asset('dist/js/pdfmake.min.js') }}"></script>
        <script src="{{ asset('dist/js/vfs_fonts.js') }}"></script>
        <script src="{{ asset('dist/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('dist/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('dist/js/buttons.colVis.min.js') }}"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
        <!-- Page specific script -->
        <script>
            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false,
                    "responsive": true,
                });
            });
        </script>
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Tampilkan notifikasi jika ada session flash -->
        @if (session('alert.config'))
            <script>
                Swal.fire({!! session('alert.config') !!});
            </script>
        @endif
    @endsection
</x-layouts.app>
