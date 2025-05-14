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
                        <h3 class="mb-0">Permohonan Tanda Tangan Elektronik</h3>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Permohonan Tanda Tangan Elektronik
                            </li>
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
                    <h3 class="card-title">Daftar Permohonan Tanda Tangan Elektronik</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center align-middle">Tiket</th>
                                <th class="text-center align-middle">Nama Lengkap</th>
                                <th class="text-center align-middle">No. Pemohon</th>
                                <th class="text-center align-middle">Instansi</th>
                                <th class="text-center align-middle">E-Mail Dinas</th>
                                <th class="text-center align-middle">Surat</th>
                                <th class="text-center align-middle">Status</th>
                                <th class="text-center align-middle">Waktu Permohonan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tte as $index => $item)
                                <tr>
                                    <td class="text-center align-middle">{{ $item->nomor_tiket }}</td>
                                    <td class="text-center align-middle">{{ $item->nama_lengkap }}</td>
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
                                    <td class="text-center align-middle">{{ $item->instansi }}</td>
                                    <td class="text-center align-middle">{{ $item->email_dinas }}</td>
                                    <td class="text-center align-middle">
                                        @if ($item->surat_permohonan)
                                            @php $fileName = basename($item->surat_permohonan); @endphp
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="handleSurat('{{ $item->id }}', '{{ url('/uploads/' . $fileName) }}')">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <form action="{{ route('update.tte.admin', $item->id) }}" method="POST">
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
                                        {{ optional($item->created_at)->format('H:i | d-m-Y') ?? '-' }}</td>
                                </tr>
                                @if ($item->surat_permohonan)
                                    @php $fileName = basename($item->surat_permohonan); @endphp

                                    <div class="modal fade" id="modalSurat{{ $item->id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="modalLabel{{ $item->id }}"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Surat Permohonan</h5>
                                                </div>
                                                <div class="modal-body p-2">
                                                    <iframe src="{{ url('/uploads/' . $fileName) }}" width="100%"
                                                        height="500px" style="border: none;"></iframe>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
        {{-- <script src="{{ asset('dist/js/adminlte.min.js') }}"></script> --}}
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
    <script>
        function handleSurat(id, url) {
            const isMobile = window.innerWidth < 768; // You can adjust breakpoint here

            if (isMobile) {
                // 👇 Option A: Buka tab baru
                window.open(url, '_blank');

                // 👇 Option B (langsung download): Buat anchor & klik otomatis
                // let a = document.createElement('a');
                // a.href = url;
                // a.download = ''; // empty = gunakan nama file asli
                // document.body.appendChild(a);
                // a.click();
                // document.body.removeChild(a);
            } else {
                $('#modalSurat' + id).modal('show');
            }
        }
    </script>
</x-layouts.app>
