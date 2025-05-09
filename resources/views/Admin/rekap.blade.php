<x-layouts.app>
    @section('Css')
        <link rel="stylesheet" href="{{ asset('dist/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/buttons.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('dist/css/daterangepicker.css') }}">
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
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Laporan Rekap</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('export.aduan') }}" method="GET">
                                <div class="form-group mb-3">
                                    <label>Rentang Tanggal:</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="bi bi-calendar3"></i>
                                            </span>
                                        </div>
                                        <input type="text" class="form-control float-right" id="reservation"
                                            name="tanggal">
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="layanan">Pilih Layanan:</label>
                                    <select class="form-control" name="layanan" id="layanan">
                                        <option value="" disabled selected>Pilih layanan</option>
                                        <option value="aduan">Aduan Layanan</option>
                                        <!-- Tambah opsi lain di masa depan -->
                                    </select>
                                </div>

                                <button type="submit" name="format" value="pdf" class="btn btn-primary mt-3">Export
                                    PDF</button>
                                <button type="submit" name="format" value="excel"
                                    class="btn btn-success mt-3 ml-2">Export Excel</button>
                            </form>

                        </div>
                    </div>
                </div>
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
        <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
        <script>
            $(function() {
                $('#reservation').daterangepicker({
                    locale: {
                        format: 'DD-MM-YYYY'
                    },
                    opens: 'left'
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
